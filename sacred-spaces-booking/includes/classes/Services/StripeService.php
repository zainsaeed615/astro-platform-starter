<?php
/**
 * Stripe payment integration.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Services;

use SacredSpaces\Booking\Helpers\Settings;
use SacredSpaces\Booking\Repositories\BookingRepository;
use WP_REST_Request;
use WP_REST_Response;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class StripeService
 */
class StripeService {

	private BookingRepository $bookings;

	public function __construct() {
		$this->bookings = new BookingRepository();

		add_action( 'rest_api_init', array( $this, 'register_webhook_route' ) );
	}

	/**
	 * Register Stripe webhook REST route.
	 */
	public function register_webhook_route(): void {
		register_rest_route(
			'sacred-spaces-booking/v1',
			'/stripe-webhook',
			array(
				'methods'             => 'POST',
				'callback'              => array( $this, 'handle_webhook' ),
				'permission_callback'   => '__return_true',
			)
		);
	}

	/**
	 * Create Stripe Checkout Session via API.
	 *
	 * @param int    $booking_id Booking ID.
	 * @param float  $amount     Amount in dollars.
	 * @param string $mode       Payment mode full|deposit.
	 * @return array<string, mixed>|\WP_Error
	 */
	public function create_checkout_session( int $booking_id, float $amount, string $mode = 'full' ): array|\WP_Error {
		$secret = Settings::stripe_secret_key();
		if ( empty( $secret ) ) {
			return new \WP_Error( 'stripe_not_configured', __( 'Payment processing is not configured.', 'sacred-spaces-booking' ) );
		}

		$booking = $this->bookings->find( $booking_id );
		if ( ! $booking ) {
			return new \WP_Error( 'booking_not_found', __( 'Booking not found.', 'sacred-spaces-booking' ) );
		}

		$amount_cents = (int) round( $amount * 100 );
		$success_url  = add_query_arg(
			array(
				'ssb_payment' => 'success',
				'ref'         => $booking->booking_ref,
			),
			$this->get_return_url()
		);
		$cancel_url = add_query_arg(
			array(
				'ssb_payment' => 'cancelled',
				'ref'         => $booking->booking_ref,
			),
			$this->get_return_url()
		);

		$description = 'deposit' === $mode
			? sprintf( __( 'Deposit — %s', 'sacred-spaces-booking' ), $booking->service_name )
			: sprintf( __( 'Full Payment — %s', 'sacred-spaces-booking' ), $booking->service_name );

		$body = array(
			'mode'                 => 'payment',
			'success_url'          => $success_url,
			'cancel_url'           => $cancel_url,
			'customer_email'       => $booking->email,
			'client_reference_id'  => $booking->booking_ref,
			'metadata'             => array(
				'booking_id'   => (string) $booking_id,
				'booking_ref'  => $booking->booking_ref,
				'payment_mode' => $mode,
			),
			'line_items'           => array(
				array(
					'price_data' => array(
						'currency'     => 'usd',
						'unit_amount'  => $amount_cents,
						'product_data' => array(
							'name'        => $booking->service_name,
							'description' => $description,
						),
					),
					'quantity'   => 1,
				),
			),
		);

		$response = wp_remote_post(
			'https://api.stripe.com/v1/checkout/sessions',
			array(
				'headers' => array(
					'Authorization' => 'Bearer ' . $secret,
					'Content-Type'  => 'application/x-www-form-urlencoded',
				),
				'body'    => $this->build_stripe_body( $body ),
				'timeout' => 30,
			)
		);

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$code = wp_remote_retrieve_response_code( $response );
		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( $code < 200 || $code >= 300 || empty( $data['id'] ) ) {
			$message = $data['error']['message'] ?? __( 'Payment session could not be created.', 'sacred-spaces-booking' );
			return new \WP_Error( 'stripe_error', $message );
		}

		$this->bookings->update(
			$booking_id,
			array( 'stripe_session_id' => sanitize_text_field( $data['id'] ) )
		);

		return array(
			'session_id' => $data['id'],
			'url'        => $data['url'] ?? '',
		);
	}

	/**
	 * Build URL-encoded body for Stripe API (nested arrays).
	 *
	 * @param array<string, mixed> $data Data.
	 * @param string               $prefix Key prefix.
	 * @return string
	 */
	private function build_stripe_body( array $data, string $prefix = '' ): string {
		$parts = array();

		foreach ( $data as $key => $value ) {
			$full_key = '' === $prefix ? (string) $key : $prefix . '[' . $key . ']';

			if ( is_array( $value ) ) {
				$parts[] = $this->build_stripe_body( $value, $full_key );
			} else {
				$parts[] = rawurlencode( $full_key ) . '=' . rawurlencode( (string) $value );
			}
		}

		return implode( '&', array_filter( $parts ) );
	}

	/**
	 * Handle Stripe webhook.
	 *
	 * @param WP_REST_Request $request Request.
	 */
	public function handle_webhook( WP_REST_Request $request ): WP_REST_Response {
		$payload   = $request->get_body();
		$sig       = $request->get_header( 'stripe-signature' );
		$secret    = Settings::get( 'stripe_webhook_secret', '' );

		if ( empty( $secret ) ) {
			return new WP_REST_Response( array( 'error' => 'Webhook not configured' ), 400 );
		}

		if ( ! $this->verify_webhook_signature( $payload, $sig, $secret ) ) {
			return new WP_REST_Response( array( 'error' => 'Invalid signature' ), 400 );
		}

		$event = json_decode( $payload, true );
		if ( ! is_array( $event ) || empty( $event['type'] ) ) {
			return new WP_REST_Response( array( 'error' => 'Invalid payload' ), 400 );
		}

		if ( 'checkout.session.completed' === $event['type'] ) {
			$session = $event['data']['object'] ?? array();
			$ref     = $session['client_reference_id'] ?? '';
			$intent  = $session['payment_intent'] ?? '';

			if ( $ref ) {
				$booking = $this->bookings->find_by_ref( $ref );
				if ( $booking ) {
					( new BookingService() )->mark_paid( (int) $booking->id, sanitize_text_field( $intent ) );
				}
			}
		}

		return new WP_REST_Response( array( 'received' => true ), 200 );
	}

	/**
	 * Verify Stripe webhook signature.
	 */
	private function verify_webhook_signature( string $payload, ?string $sig_header, string $secret ): bool {
		if ( empty( $sig_header ) ) {
			return false;
		}

		$parts = array();
		foreach ( explode( ',', $sig_header ) as $item ) {
			$pair = explode( '=', trim( $item ), 2 );
			if ( 2 === count( $pair ) ) {
				$parts[ $pair[0] ] = $pair[1];
			}
		}

		if ( empty( $parts['t'] ) || empty( $parts['v1'] ) ) {
			return false;
		}

		$signed     = $parts['t'] . '.' . $payload;
		$expected   = hash_hmac( 'sha256', $signed, $secret );
		return hash_equals( $expected, $parts['v1'] );
	}

	/**
	 * Get return URL for Stripe redirects.
	 */
	private function get_return_url(): string {
		$url = Settings::get( 'booking_page_url', '' );
		if ( empty( $url ) ) {
			$url = home_url( '/' );
		}
		return esc_url( $url );
	}

	/**
	 * Get publishable key for frontend.
	 */
	public static function get_publishable_key(): string {
		return Settings::stripe_publishable_key();
	}
}
