<?php
/**
 * Availability business logic.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Services;

use SacredSpaces\Booking\Helpers\Settings;
use SacredSpaces\Booking\Repositories\AvailabilityRepository;
use SacredSpaces\Booking\Repositories\BookingRepository;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class AvailabilityService
 */
class AvailabilityService {

	private AvailabilityRepository $availability;
	private BookingRepository $bookings;

	public function __construct() {
		$this->availability = new AvailabilityRepository();
		$this->bookings     = new BookingRepository();
	}

	/**
	 * Check if a date is bookable.
	 */
	public function is_date_bookable( string $date ): bool {
		$timestamp = strtotime( $date );
		if ( false === $timestamp ) {
			return false;
		}

		$lead_days     = (int) Settings::get( 'booking_lead_days', 1 );
		$horizon_days  = (int) Settings::get( 'booking_horizon_days', 90 );
		$min_date      = strtotime( '+' . $lead_days . ' days', strtotime( 'today' ) );
		$max_date      = strtotime( '+' . $horizon_days . ' days', strtotime( 'today' ) );

		if ( $timestamp < $min_date || $timestamp > $max_date ) {
			return false;
		}

		$day_of_week = (int) gmdate( 'w', $timestamp );
		$available_days = $this->availability->get_available_days();

		if ( ! in_array( $day_of_week, $available_days, true ) ) {
			return false;
		}

		if ( $this->availability->is_date_blocked( $date ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Check if slot is bookable.
	 *
	 * @param int $exclude_booking_id Exclude booking when rescheduling.
	 */
	public function is_slot_bookable( string $date, string $time, int $exclude_booking_id = 0 ): bool {
		if ( ! $this->is_date_bookable( $date ) ) {
			return false;
		}

		$slots = $this->availability->get_active_slots();
		$valid_times = array_map( fn( $s ) => $s->slot_time, $slots );

		if ( ! in_array( $time, $valid_times, true ) ) {
			return false;
		}

		if ( ! $this->bookings->is_slot_available( $date, $time ) ) {
			if ( $exclude_booking_id > 0 ) {
				$booked = $this->bookings->get_booked_times_for_date( $date );
				$booking = ( new BookingRepository() )->find( $exclude_booking_id );
				if ( $booking && $booking->booking_date === $date && $booking->booking_time === $time ) {
					return true;
				}
			}
			return false;
		}

		return true;
	}

	/**
	 * Get available dates for a month.
	 *
	 * @return array<int, string>
	 */
	public function get_available_dates( int $year, int $month ): array {
		$dates      = array();
		$days_in_month = (int) gmdate( 't', strtotime( "{$year}-{$month}-01" ) );

		for ( $d = 1; $d <= $days_in_month; $d++ ) {
			$date = sprintf( '%04d-%02d-%02d', $year, $month, $d );
			if ( $this->is_date_bookable( $date ) ) {
				$dates[] = $date;
			}
		}

		return $dates;
	}

	/**
	 * Get available time slots for a date.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	public function get_available_slots( string $date ): array {
		if ( ! $this->is_date_bookable( $date ) ) {
			return array();
		}

		$all_slots    = $this->availability->get_active_slots();
		$booked_times = $this->bookings->get_booked_times_for_date( $date );
		$available    = array();

		foreach ( $all_slots as $slot ) {
			if ( ! in_array( $slot->slot_time, $booked_times, true ) ) {
				$available[] = array(
					'id'    => (int) $slot->id,
					'time'  => $slot->slot_time,
					'label' => $slot->label,
				);
			}
		}

		return $available;
	}

	/**
	 * Get calendar data for frontend.
	 *
	 * @return array<string, mixed>
	 */
	public function get_calendar_config(): array {
		$days = $this->availability->get_all_days();
		$day_names = array(
			0 => __( 'Sunday', 'sacred-spaces-booking' ),
			1 => __( 'Monday', 'sacred-spaces-booking' ),
			2 => __( 'Tuesday', 'sacred-spaces-booking' ),
			3 => __( 'Wednesday', 'sacred-spaces-booking' ),
			4 => __( 'Thursday', 'sacred-spaces-booking' ),
			5 => __( 'Friday', 'sacred-spaces-booking' ),
			6 => __( 'Saturday', 'sacred-spaces-booking' ),
		);

		$available_days = array();
		foreach ( $days as $day ) {
			if ( (int) $day->is_available ) {
				$available_days[] = array(
					'day'  => (int) $day->day_of_week,
					'name' => $day_names[ (int) $day->day_of_week ] ?? '',
				);
			}
		}

		return array(
			'available_days'    => $available_days,
			'lead_days'         => (int) Settings::get( 'booking_lead_days', 1 ),
			'horizon_days'      => (int) Settings::get( 'booking_horizon_days', 90 ),
			'time_slots'        => $this->availability->get_active_slots(),
		);
	}
}
