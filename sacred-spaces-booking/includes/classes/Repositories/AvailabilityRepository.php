<?php
/**
 * Availability repository.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Repositories;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class AvailabilityRepository
 */
class AvailabilityRepository {

	/**
	 * Days table.
	 */
	private function days_table(): string {
		global $wpdb;
		return $wpdb->prefix . 'ssb_availability_days';
	}

	/**
	 * Slots table.
	 */
	private function slots_table(): string {
		global $wpdb;
		return $wpdb->prefix . 'ssb_time_slots';
	}

	/**
	 * Blocked dates table.
	 */
	private function blocked_table(): string {
		global $wpdb;
		return $wpdb->prefix . 'ssb_blocked_dates';
	}

	/**
	 * Get available days (0=Sunday).
	 *
	 * @return array<int, int>
	 */
	public function get_available_days(): array {
		global $wpdb;
		$table = $this->days_table();
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$rows = $wpdb->get_results( "SELECT day_of_week FROM {$table} WHERE is_available = 1" );
		return array_map( fn( $r ) => (int) $r->day_of_week, $rows );
	}

	/**
	 * Get all day settings.
	 *
	 * @return array<int, object>
	 */
	public function get_all_days(): array {
		global $wpdb;
		$table = $this->days_table();
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return $wpdb->get_results( "SELECT * FROM {$table} ORDER BY day_of_week ASC" );
	}

	/**
	 * Update day availability.
	 */
	public function update_day( int $day_of_week, bool $available ): bool {
		global $wpdb;
		return false !== $wpdb->update(
			$this->days_table(),
			array( 'is_available' => $available ? 1 : 0 ),
			array( 'day_of_week' => $day_of_week )
		);
	}

	/**
	 * Get active time slots.
	 *
	 * @return array<int, object>
	 */
	public function get_active_slots(): array {
		global $wpdb;
		$table = $this->slots_table();
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return $wpdb->get_results( "SELECT * FROM {$table} WHERE is_active = 1 ORDER BY sort_order ASC" );
	}

	/**
	 * Get all time slots.
	 *
	 * @return array<int, object>
	 */
	public function get_all_slots(): array {
		global $wpdb;
		$table = $this->slots_table();
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return $wpdb->get_results( "SELECT * FROM {$table} ORDER BY sort_order ASC" );
	}

	/**
	 * Update time slot.
	 *
	 * @param int                  $id   Slot ID.
	 * @param array<string, mixed> $data Data.
	 */
	public function update_slot( int $id, array $data ): bool {
		global $wpdb;
		return false !== $wpdb->update( $this->slots_table(), $data, array( 'id' => $id ) );
	}

	/**
	 * Create time slot.
	 *
	 * @param array<string, mixed> $data Slot data.
	 * @return int|false
	 */
	public function create_slot( array $data ) {
		global $wpdb;
		$result = $wpdb->insert( $this->slots_table(), $data );
		return false !== $result ? (int) $wpdb->insert_id : false;
	}

	/**
	 * Delete time slot.
	 */
	public function delete_slot( int $id ): bool {
		global $wpdb;
		return false !== $wpdb->delete( $this->slots_table(), array( 'id' => $id ) );
	}

	/**
	 * Check if date is blocked.
	 */
	public function is_date_blocked( string $date ): bool {
		global $wpdb;
		$table = $this->blocked_table();
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$count = (int) $wpdb->get_var(
			$wpdb->prepare( "SELECT COUNT(*) FROM {$table} WHERE blocked_date = %s", $date )
		);
		return $count > 0;
	}

	/**
	 * Get blocked dates in range.
	 *
	 * @return array<int, string>
	 */
	public function get_blocked_dates( string $from, string $to ): array {
		global $wpdb;
		$table = $this->blocked_table();
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return $wpdb->get_col(
			$wpdb->prepare(
				"SELECT blocked_date FROM {$table} WHERE blocked_date BETWEEN %s AND %s",
				$from,
				$to
			)
		);
	}

	/**
	 * Block a date.
	 */
	public function block_date( string $date, string $reason = '' ): bool {
		global $wpdb;
		$result = $wpdb->insert(
			$this->blocked_table(),
			array(
				'blocked_date' => $date,
				'reason'       => $reason,
			)
		);
		return false !== $result;
	}

	/**
	 * Unblock a date.
	 */
	public function unblock_date( string $date ): bool {
		global $wpdb;
		return false !== $wpdb->delete( $this->blocked_table(), array( 'blocked_date' => $date ) );
	}

	/**
	 * Get all blocked dates.
	 *
	 * @return array<int, object>
	 */
	public function get_all_blocked(): array {
		global $wpdb;
		$table = $this->blocked_table();
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return $wpdb->get_results( "SELECT * FROM {$table} ORDER BY blocked_date ASC" );
	}
}
