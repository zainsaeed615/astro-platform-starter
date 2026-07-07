<?php
/**
 * Email service with luxury HTML templates.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Services;

use SacredSpaces\Booking\Helpers\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class EmailService
 */
class EmailService {

	/**
	 * Send client confirmation email.
	 *
	 * @param object $booking Booking object.
	 */
	public function send_client_confirmation( object $booking ): bool {
		$templates = get_option( 'ssb_email_templates', array() );
		$subject   = $templates['client_confirmation_subject'] ?? 'Your Sacred Spaces Session — Confirmation';
		$body      = $templates['client_confirmation_body'] ?? '';

		$subject = $this->replace_tokens( $subject, $booking );
		$body    = $this->replace_tokens( $body, $booking );
		$html    = $this->wrap_template( $body, $booking );

		$headers = $this->get_headers();

		return wp_mail( $booking->email, $subject, $html, $headers );
	}

	/**
	 * Send admin notification email.
	 *
	 * @param object $booking Booking object.
	 */
	public function send_admin_notification( object $booking ): bool {
		$templates  = get_option( 'ssb_email_templates', array() );
		$subject    = $templates['admin_notification_subject'] ?? 'New Booking Request';
		$body       = $templates['admin_notification_body'] ?? '';
		$admin_email = Settings::get( 'admin_email', get_option( 'admin_email' ) );

		$subject = $this->replace_tokens( $subject, $booking );
		$body    = $this->replace_tokens( $body, $booking );
		$html    = $this->wrap_template( $body, $booking, true );

		$headers = $this->get_headers();

		return wp_mail( $admin_email, $subject, $html, $headers );
	}

	/**
	 * Replace template tokens.
	 */
	private function replace_tokens( string $content, object $booking ): string {
		$location_labels = array(
			'virtual' => __( 'Virtual', 'sacred-spaces-booking' ),
			'in_home' => __( 'In Home', 'sacred-spaces-booking' ),
		);

		$tokens = array(
			'{first_name}'           => $booking->first_name ?? '',
			'{last_name}'            => $booking->last_name ?? '',
			'{email}'                => $booking->email ?? '',
			'{phone}'                => $booking->phone ?? '',
			'{service_name}'         => $booking->service_name ?? '',
			'{booking_date}'         => $this->format_date( $booking->booking_date ?? '' ),
			'{booking_time}'         => $this->format_time( $booking->booking_time ?? '' ),
			'{location}'             => $location_labels[ $booking->location ?? '' ] ?? ( $booking->location ?? '' ),
			'{investment}'           => $booking->investment_display ?? '',
			'{booking_ref}'          => $booking->booking_ref ?? '',
			'{project_type}'         => $booking->project_type ?? '',
			'{referral_source}'      => $booking->referral_source ?? '',
			'{transformation_goals}' => nl2br( esc_html( $booking->transformation_goals ?? '' ) ),
			'{address}'              => $this->format_address( $booking ),
		);

		return str_replace( array_keys( $tokens ), array_values( $tokens ), $content );
	}

	/**
	 * Format date for display.
	 */
	private function format_date( string $date ): string {
		if ( empty( $date ) ) {
			return '';
		}
		$timestamp = strtotime( $date );
		return $timestamp ? gmdate( 'l, F j, Y', $timestamp ) : $date;
	}

	/**
	 * Format time for display.
	 */
	private function format_time( string $time ): string {
		if ( empty( $time ) ) {
			return '';
		}
		$timestamp = strtotime( $time );
		return $timestamp ? gmdate( 'g:i A', $timestamp ) : $time;
	}

	/**
	 * Format client address.
	 *
	 * @param object $booking Booking.
	 */
	private function format_address( object $booking ): string {
		$parts = array_filter(
			array(
				$booking->address ?? '',
				$booking->city ?? '',
				$booking->state ?? '',
				$booking->zip ?? '',
				$booking->country ?? '',
			)
		);
		return implode( ', ', $parts );
	}

	/**
	 * Wrap content in luxury HTML email template.
	 */
	private function wrap_template( string $body, object $booking, bool $is_admin = false ): string {
		$title = $is_admin
			? esc_html__( 'New Booking Request', 'sacred-spaces-booking' )
			: esc_html__( 'Your Sanctuary Session', 'sacred-spaces-booking' );

		ob_start();
		include SSB_PLUGIN_DIR . 'templates/emails/base.php';
		return (string) ob_get_clean();
	}

	/**
	 * Get email headers.
	 *
	 * @return array<int, string>
	 */
	private function get_headers(): array {
		$from_name  = Settings::get( 'from_name', 'Sacred Spaces by Sharon' );
		$from_email = Settings::get( 'from_email', get_option( 'admin_email' ) );

		return array(
			'Content-Type: text/html; charset=UTF-8',
			'From: ' . $from_name . ' <' . $from_email . '>',
		);
	}
}
