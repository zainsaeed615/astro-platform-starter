<?php
/**
 * REST API controller.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Api;

use SacredSpaces\Booking\Repositories\ServiceRepository;
use SacredSpaces\Booking\Services\AvailabilityService;
use SacredSpaces\Booking\Services\BookingService;
use WP_REST_Request;
use WP_REST_Response;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class RestController
 */
class RestController {

	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register REST routes.
	 */
	public function register_routes(): void {
		$namespace = 'sacred-spaces-booking/v1';

		register_rest_route(
			$namespace,
			'/services',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_services' ),
				'permission_callback' => '__return_true',
			)
		);

		register_rest_route(
			$namespace,
			'/availability/dates',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_available_dates' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'year'  => array( 'required' => true, 'type' => 'integer' ),
					'month' => array( 'required' => true, 'type' => 'integer' ),
				),
			)
		);

		register_rest_route(
			$namespace,
			'/availability/slots',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_available_slots' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'date' => array( 'required' => true, 'type' => 'string' ),
				),
			)
		);

		register_rest_route(
			$namespace,
			'/availability/config',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_calendar_config' ),
				'permission_callback' => '__return_true',
			)
		);

		register_rest_route(
			$namespace,
			'/bookings',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'create_booking' ),
				'permission_callback' => array( $this, 'verify_nonce' ),
			)
		);

		register_rest_route(
			$namespace,
			'/bookings/(?P<ref>[a-zA-Z0-9\-]+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_booking' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * Verify REST nonce.
	 */
	public function verify_nonce( WP_REST_Request $request ): bool {
		$nonce = $request->get_header( 'X-WP-Nonce' );
		return (bool) wp_verify_nonce( $nonce ?: '', 'wp_rest' );
	}

	/**
	 * Get services.
	 */
	public function get_services(): WP_REST_Response {
		$repo     = new ServiceRepository();
		$services = $repo->get_active();

		$formatted = array_map(
			function ( $s ) {
				return array(
					'id'                 => (int) $s->id,
					'name'               => $s->name,
					'slug'               => $s->slug,
					'description'        => $s->description,
					'investment_display' => $s->investment_display,
					'investment_min'     => $s->investment_min ? (float) $s->investment_min : null,
					'investment_max'     => $s->investment_max ? (float) $s->investment_max : null,
					'duration_minutes'   => (int) $s->duration_minutes,
					'locations'          => explode( ',', $s->locations ),
				);
			},
			$services
		);

		return new WP_REST_Response( $formatted, 200 );
	}

	/**
	 * Get available dates.
	 */
	public function get_available_dates( WP_REST_Request $request ): WP_REST_Response {
		$year  = (int) $request->get_param( 'year' );
		$month = (int) $request->get_param( 'month' );
		$service = new AvailabilityService();
		$dates   = $service->get_available_dates( $year, $month );
		return new WP_REST_Response( array( 'dates' => $dates ), 200 );
	}

	/**
	 * Get available slots.
	 */
	public function get_available_slots( WP_REST_Request $request ): WP_REST_Response {
		$date    = sanitize_text_field( $request->get_param( 'date' ) );
		$service = new AvailabilityService();
		$slots   = $service->get_available_slots( $date );
		return new WP_REST_Response( array( 'slots' => $slots ), 200 );
	}

	/**
	 * Get calendar config.
	 */
	public function get_calendar_config(): WP_REST_Response {
		$service = new AvailabilityService();
		return new WP_REST_Response( $service->get_calendar_config(), 200 );
	}

	/**
	 * Create booking.
	 */
	public function create_booking( WP_REST_Request $request ): WP_REST_Response {
		$data    = $request->get_json_params();
		$service = new BookingService();
		$result  = $service->create_booking( is_array( $data ) ? $data : array() );

		if ( is_wp_error( $result ) ) {
			return new WP_REST_Response(
				array( 'message' => $result->get_error_message() ),
				400
			);
		}

		return new WP_REST_Response( $result, 201 );
	}

	/**
	 * Get booking by reference.
	 */
	public function get_booking( WP_REST_Request $request ): WP_REST_Response {
		$ref     = sanitize_text_field( $request->get_param( 'ref' ) );
		$booking = ( new \SacredSpaces\Booking\Repositories\BookingRepository() )->find_by_ref( $ref );

		if ( ! $booking ) {
			return new WP_REST_Response( array( 'message' => 'Not found' ), 404 );
		}

		return new WP_REST_Response(
			array(
				'ref'                => $booking->booking_ref,
				'service_name'       => $booking->service_name,
				'booking_date'       => $booking->booking_date,
				'booking_time'       => $booking->booking_time,
				'location'           => $booking->location,
				'investment_display' => $booking->investment_display,
				'first_name'         => $booking->first_name,
				'status'             => $booking->status,
			),
			200
		);
	}
}
