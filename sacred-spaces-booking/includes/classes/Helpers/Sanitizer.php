<?php
/**
 * Sanitization helpers.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Sanitizer
 */
class Sanitizer {

	/**
	 * Sanitize booking form data.
	 *
	 * @param array<string, mixed> $data Raw input.
	 * @return array<string, mixed>
	 */
	public static function booking_form( array $data ): array {
		return array(
			'service_id'           => absint( $data['service_id'] ?? 0 ),
			'location'             => sanitize_text_field( $data['location'] ?? '' ),
			'booking_date'         => sanitize_text_field( $data['booking_date'] ?? '' ),
			'booking_time'         => sanitize_text_field( $data['booking_time'] ?? '' ),
			'first_name'           => sanitize_text_field( $data['first_name'] ?? '' ),
			'last_name'            => sanitize_text_field( $data['last_name'] ?? '' ),
			'email'                => sanitize_email( $data['email'] ?? '' ),
			'phone'                => sanitize_text_field( $data['phone'] ?? '' ),
			'address'              => sanitize_text_field( $data['address'] ?? '' ),
			'city'                 => sanitize_text_field( $data['city'] ?? '' ),
			'state'                => sanitize_text_field( $data['state'] ?? '' ),
			'zip'                  => sanitize_text_field( $data['zip'] ?? '' ),
			'country'              => sanitize_text_field( $data['country'] ?? 'United States' ),
			'preferred_contact'    => sanitize_text_field( $data['preferred_contact'] ?? 'email' ),
			'project_type'         => sanitize_text_field( $data['project_type'] ?? '' ),
			'referral_source'      => sanitize_text_field( $data['referral_source'] ?? '' ),
			'transformation_goals' => sanitize_textarea_field( $data['transformation_goals'] ?? '' ),
			'intentional_ack'      => ! empty( $data['intentional_ack'] ) ? 1 : 0,
		);
	}

	/**
	 * Generate unique booking reference.
	 */
	public static function booking_ref(): string {
		return 'SSB-' . strtoupper( wp_generate_password( 8, false, false ) );
	}
}
