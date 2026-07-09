<?php
/**
 * Booking business logic.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Services;

use SacredSpaces\Booking\Helpers\Sanitizer;
use SacredSpaces\Booking\Repositories\AvailabilityRepository;
use SacredSpaces\Booking\Repositories\BookingRepository;
use SacredSpaces\Booking\Repositories\ClientRepository;
use SacredSpaces\Booking\Repositories\ServiceRepository;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class BookingService
 */
class BookingService {

	private BookingRepository $bookings;
	private ClientRepository $clients;
	private ServiceRepository $services;
	private AvailabilityService $availability;
	private EmailService $email;

	public function __construct() {
		$this->bookings     = new BookingRepository();
		$this->clients      = new ClientRepository();
		$this->services     = new ServiceRepository();
		$this->availability = new AvailabilityService();
		$this->email        = new EmailService();
	}

	/**
	 * Create a new booking from form data.
	 *
	 * @param array<string, mixed> $raw Raw form data.
	 * @return array<string, mixed>|WP_Error
	 */
	public function create_booking( array $raw ): array|WP_Error {
		$data = Sanitizer::booking_form( $raw );

		if ( empty( $data['service_id'] ) ) {
			return new WP_Error( 'invalid_service', __( 'Please select a service.', 'sacred-spaces-booking' ) );
		}

		$service = $this->services->find( $data['service_id'] );
		if ( ! $service ) {
			return new WP_Error( 'service_not_found', __( 'Service not found.', 'sacred-spaces-booking' ) );
		}

		if ( empty( $data['first_name'] ) || empty( $data['last_name'] ) || empty( $data['email'] ) ) {
			return new WP_Error( 'invalid_client', __( 'Please complete all required client fields.', 'sacred-spaces-booking' ) );
		}

		if ( ! is_email( $data['email'] ) ) {
			return new WP_Error( 'invalid_email', __( 'Please enter a valid email address.', 'sacred-spaces-booking' ) );
		}

		if ( empty( $data['intentional_ack'] ) ) {
			return new WP_Error( 'ack_required', __( 'Please acknowledge the intentional design experience.', 'sacred-spaces-booking' ) );
		}

		if ( empty( $data['booking_date'] ) || empty( $data['booking_time'] ) ) {
			return new WP_Error( 'invalid_schedule', __( 'Please select a date and time.', 'sacred-spaces-booking' ) );
		}

		if ( ! $this->availability->is_slot_bookable( $data['booking_date'], $data['booking_time'] ) ) {
			return new WP_Error( 'slot_unavailable', __( 'This time slot is no longer available.', 'sacred-spaces-booking' ) );
		}

		$client_id = $this->upsert_client( $data );
		if ( ! $client_id ) {
			return new WP_Error( 'client_error', __( 'Unable to save client information.', 'sacred-spaces-booking' ) );
		}

		$booking_id = $this->bookings->create(
			array(
				'booking_ref'          => Sanitizer::booking_ref(),
				'service_id'           => $data['service_id'],
				'client_id'            => $client_id,
				'location'             => $data['location'] ?: 'virtual',
				'booking_date'         => $data['booking_date'],
				'booking_time'         => $data['booking_time'],
				'status'               => 'pending',
				'project_type'         => $data['project_type'],
				'referral_source'      => $data['referral_source'],
				'transformation_goals' => $data['transformation_goals'],
				'intentional_ack'      => $data['intentional_ack'],
				'payment_status'       => 'none',
				'payment_amount'       => null,
			)
		);

		if ( ! $booking_id ) {
			return new WP_Error( 'booking_error', __( 'Unable to create booking.', 'sacred-spaces-booking' ) );
		}

		$booking = $this->bookings->find( $booking_id );

		$this->email->send_client_confirmation( $booking );
		$this->email->send_admin_notification( $booking );

		return array(
			'booking_id'   => $booking_id,
			'booking_ref'  => $booking->booking_ref,
			'service_name' => $service->name,
		);
	}

	/**
	 * Upsert client record.
	 *
	 * @param array<string, mixed> $data Client data.
	 */
	private function upsert_client( array $data ): int|false {
		$existing = $this->clients->find_by_email( $data['email'] );
		$payload  = array(
			'first_name'        => $data['first_name'],
			'last_name'         => $data['last_name'],
			'email'             => $data['email'],
			'phone'             => $data['phone'],
			'address'           => $data['address'],
			'city'              => $data['city'],
			'state'             => $data['state'],
			'zip'               => $data['zip'],
			'country'           => $data['country'],
			'preferred_contact' => $data['preferred_contact'],
		);

		if ( $existing ) {
			$this->clients->update( (int) $existing->id, $payload );
			return (int) $existing->id;
		}

		return $this->clients->create( $payload );
	}

	/**
	 * Update booking status.
	 */
	public function update_status( int $id, string $status ): bool|WP_Error {
		$allowed = array( 'pending', 'approved', 'confirmed', 'declined', 'cancelled', 'rescheduled' );
		if ( ! in_array( $status, $allowed, true ) ) {
			return new WP_Error( 'invalid_status', __( 'Invalid status.', 'sacred-spaces-booking' ) );
		}

		$booking = $this->bookings->find( $id );
		if ( ! $booking ) {
			return new WP_Error( 'not_found', __( 'Booking not found.', 'sacred-spaces-booking' ) );
		}

		return $this->bookings->update( $id, array( 'status' => $status ) );
	}

	/**
	 * Reschedule booking.
	 */
	public function reschedule( int $id, string $date, string $time ): bool|WP_Error {
		if ( ! $this->availability->is_slot_bookable( $date, $time, $id ) ) {
			return new WP_Error( 'slot_unavailable', __( 'This time slot is not available.', 'sacred-spaces-booking' ) );
		}

		return $this->bookings->update(
			$id,
			array(
				'booking_date' => $date,
				'booking_time' => $time,
				'status'       => 'rescheduled',
			)
		);
	}

	/**
	 * Add admin note.
	 */
	public function add_note( int $booking_id, string $note ): bool {
		global $wpdb;
		$result = $wpdb->insert(
			$wpdb->prefix . 'ssb_booking_notes',
			array(
				'booking_id' => $booking_id,
				'note'       => sanitize_textarea_field( $note ),
				'author_id'  => get_current_user_id(),
			)
		);
		return false !== $result;
	}
}
