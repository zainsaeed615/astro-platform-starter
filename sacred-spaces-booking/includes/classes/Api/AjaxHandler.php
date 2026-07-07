<?php
/**
 * Admin AJAX handlers.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Api;

use SacredSpaces\Booking\Helpers\Settings;
use SacredSpaces\Booking\Repositories\AvailabilityRepository;
use SacredSpaces\Booking\Repositories\BookingRepository;
use SacredSpaces\Booking\Repositories\ServiceRepository;
use SacredSpaces\Booking\Services\BookingService;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class AjaxHandler
 */
class AjaxHandler {

	public function __construct() {
		$actions = array(
			'ssb_update_booking_status',
			'ssb_reschedule_booking',
			'ssb_add_booking_note',
			'ssb_save_availability',
			'ssb_save_time_slots',
			'ssb_block_date',
			'ssb_unblock_date',
			'ssb_save_service',
			'ssb_save_settings',
			'ssb_save_email_templates',
			'ssb_export_bookings',
		);

		foreach ( $actions as $action ) {
			add_action( 'wp_ajax_' . $action, array( $this, str_replace( 'ssb_', 'handle_', $action ) ) );
		}
	}

	/**
	 * Verify admin AJAX request.
	 */
	private function verify_admin(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Unauthorized.', 'sacred-spaces-booking' ) ), 403 );
		}

		check_ajax_referer( 'ssb_admin_nonce', 'nonce' );
	}

	/**
	 * Update booking status.
	 */
	public function handle_update_booking_status(): void {
		$this->verify_admin();
		$id     = absint( $_POST['booking_id'] ?? 0 );
		$status = sanitize_text_field( wp_unslash( $_POST['status'] ?? '' ) );

		$service = new BookingService();
		$result  = $service->update_status( $id, $status );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}

		wp_send_json_success( array( 'message' => __( 'Status updated.', 'sacred-spaces-booking' ) ) );
	}

	/**
	 * Reschedule booking.
	 */
	public function handle_reschedule_booking(): void {
		$this->verify_admin();
		$id   = absint( $_POST['booking_id'] ?? 0 );
		$date = sanitize_text_field( wp_unslash( $_POST['date'] ?? '' ) );
		$time = sanitize_text_field( wp_unslash( $_POST['time'] ?? '' ) );

		$service = new BookingService();
		$result  = $service->reschedule( $id, $date, $time );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}

		wp_send_json_success( array( 'message' => __( 'Booking rescheduled.', 'sacred-spaces-booking' ) ) );
	}

	/**
	 * Add booking note.
	 */
	public function handle_add_booking_note(): void {
		$this->verify_admin();
		$id   = absint( $_POST['booking_id'] ?? 0 );
		$note = sanitize_textarea_field( wp_unslash( $_POST['note'] ?? '' ) );

		$service = new BookingService();
		$result  = $service->add_note( $id, $note );

		if ( ! $result ) {
			wp_send_json_error( array( 'message' => __( 'Could not save note.', 'sacred-spaces-booking' ) ) );
		}

		wp_send_json_success( array( 'message' => __( 'Note added.', 'sacred-spaces-booking' ) ) );
	}

	/**
	 * Save availability days.
	 */
	public function handle_save_availability(): void {
		$this->verify_admin();
		$days = isset( $_POST['days'] ) ? array_map( 'absint', (array) wp_unslash( $_POST['days'] ) ) : array();
		$repo = new AvailabilityRepository();

		for ( $d = 0; $d <= 6; $d++ ) {
			$repo->update_day( $d, in_array( $d, $days, true ) );
		}

		wp_send_json_success( array( 'message' => __( 'Availability saved.', 'sacred-spaces-booking' ) ) );
	}

	/**
	 * Save time slots.
	 */
	public function handle_save_time_slots(): void {
		$this->verify_admin();
		$slots_raw = isset( $_POST['slots'] ) ? wp_unslash( $_POST['slots'] ) : '[]';
		$slots     = json_decode( $slots_raw, true );
		$repo      = new AvailabilityRepository();

		if ( ! is_array( $slots ) ) {
			wp_send_json_error( array( 'message' => __( 'Invalid data.', 'sacred-spaces-booking' ) ) );
		}

		foreach ( $slots as $slot ) {
			$id = absint( $slot['id'] ?? 0 );
			$data = array(
				'slot_time'  => sanitize_text_field( $slot['time'] ?? '' ),
				'label'      => sanitize_text_field( $slot['label'] ?? '' ),
				'is_active'  => ! empty( $slot['active'] ) ? 1 : 0,
				'sort_order' => absint( $slot['sort'] ?? 0 ),
			);

			if ( $id ) {
				$repo->update_slot( $id, $data );
			} else {
				$repo->create_slot( $data );
			}
		}

		wp_send_json_success( array( 'message' => __( 'Time slots saved.', 'sacred-spaces-booking' ) ) );
	}

	/**
	 * Block a date.
	 */
	public function handle_block_date(): void {
		$this->verify_admin();
		$date   = sanitize_text_field( wp_unslash( $_POST['date'] ?? '' ) );
		$reason = sanitize_text_field( wp_unslash( $_POST['reason'] ?? '' ) );
		$repo   = new AvailabilityRepository();
		$repo->block_date( $date, $reason );
		wp_send_json_success( array( 'message' => __( 'Date blocked.', 'sacred-spaces-booking' ) ) );
	}

	/**
	 * Unblock a date.
	 */
	public function handle_unblock_date(): void {
		$this->verify_admin();
		$date = sanitize_text_field( wp_unslash( $_POST['date'] ?? '' ) );
		$repo = new AvailabilityRepository();
		$repo->unblock_date( $date );
		wp_send_json_success( array( 'message' => __( 'Date unblocked.', 'sacred-spaces-booking' ) ) );
	}

	/**
	 * Save service.
	 */
	public function handle_save_service(): void {
		$this->verify_admin();
		$id   = absint( $_POST['id'] ?? 0 );
		$data = array(
			'name'               => sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) ),
			'description'        => sanitize_textarea_field( wp_unslash( $_POST['description'] ?? '' ) ),
			'investment_display' => sanitize_text_field( wp_unslash( $_POST['investment_display'] ?? '' ) ),
			'investment_min'     => floatval( $_POST['investment_min'] ?? 0 ) ?: null,
			'investment_max'     => floatval( $_POST['investment_max'] ?? 0 ) ?: null,
			'duration_minutes'   => absint( $_POST['duration_minutes'] ?? 90 ),
			'payment_mode'       => sanitize_text_field( wp_unslash( $_POST['payment_mode'] ?? 'none' ) ),
			'payment_amount'     => floatval( $_POST['payment_amount'] ?? 0 ) ?: null,
			'locations'          => sanitize_text_field( wp_unslash( $_POST['locations'] ?? 'virtual,in_home' ) ),
			'is_active'          => ! empty( $_POST['is_active'] ) ? 1 : 0,
		);

		$repo = new ServiceRepository();
		if ( $id ) {
			$repo->update( $id, $data );
		} else {
			$data['slug'] = sanitize_title( $data['name'] );
			$repo->create( $data );
		}

		wp_send_json_success( array( 'message' => __( 'Service saved.', 'sacred-spaces-booking' ) ) );
	}

	/**
	 * Save settings.
	 */
	public function handle_save_settings(): void {
		$this->verify_admin();
		$fields = array(
			'stripe_mode', 'stripe_test_publishable', 'stripe_test_secret',
			'stripe_live_publishable', 'stripe_live_secret', 'stripe_webhook_secret',
			'default_payment_mode', 'admin_email', 'from_name', 'from_email',
			'booking_lead_days', 'booking_horizon_days', 'booking_page_url',
			'google_calendar_enabled', 'outlook_sync_enabled', 'zoom_enabled',
			'sms_reminders_enabled', 'client_portal_enabled',
		);

		$data = array();
		foreach ( $fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				$value = wp_unslash( $_POST[ $field ] );
				$data[ $field ] = is_numeric( $value ) ? absint( $value ) : sanitize_text_field( $value );
			}
		}

		Settings::update( $data );
		wp_send_json_success( array( 'message' => __( 'Settings saved.', 'sacred-spaces-booking' ) ) );
	}

	/**
	 * Save email templates.
	 */
	public function handle_save_email_templates(): void {
		$this->verify_admin();
		$templates = array(
			'client_confirmation_subject' => sanitize_text_field( wp_unslash( $_POST['client_confirmation_subject'] ?? '' ) ),
			'client_confirmation_body'    => wp_kses_post( wp_unslash( $_POST['client_confirmation_body'] ?? '' ) ),
			'admin_notification_subject'  => sanitize_text_field( wp_unslash( $_POST['admin_notification_subject'] ?? '' ) ),
			'admin_notification_body'     => wp_kses_post( wp_unslash( $_POST['admin_notification_body'] ?? '' ) ),
		);
		update_option( 'ssb_email_templates', $templates );
		wp_send_json_success( array( 'message' => __( 'Email templates saved.', 'sacred-spaces-booking' ) ) );
	}

	/**
	 * Export bookings CSV.
	 */
	public function handle_export_bookings(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Unauthorized.', 'sacred-spaces-booking' ) );
		}
		check_admin_referer( 'ssb_admin_nonce', 'nonce' );
		$repo     = new BookingRepository();
		$bookings = $repo->export_all();

		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=ssb-bookings-' . gmdate( 'Y-m-d' ) . '.csv' );

		$output = fopen( 'php://output', 'w' );
		fputcsv(
			$output,
			array( 'Ref', 'First Name', 'Last Name', 'Email', 'Service', 'Date', 'Time', 'Status', 'Payment', 'Amount' )
		);

		foreach ( $bookings as $b ) {
			fputcsv(
				$output,
				array(
					$b->booking_ref,
					$b->first_name,
					$b->last_name,
					$b->email,
					$b->service_name,
					$b->booking_date,
					$b->booking_time,
					$b->status,
					$b->payment_status,
					$b->payment_amount,
				)
			);
		}

		fclose( $output );
		exit;
	}
}
