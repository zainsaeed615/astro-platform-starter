<?php
/**
 * Booking repository.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Repositories;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class BookingRepository
 */
class BookingRepository {

	/**
	 * Bookings table.
	 */
	private function bookings_table(): string {
		global $wpdb;
		return $wpdb->prefix . 'ssb_bookings';
	}

	/**
	 * Clients table.
	 */
	private function clients_table(): string {
		global $wpdb;
		return $wpdb->prefix . 'ssb_clients';
	}

	/**
	 * Services table.
	 */
	private function services_table(): string {
		global $wpdb;
		return $wpdb->prefix . 'ssb_services';
	}

	/**
	 * Active statuses that block a slot.
	 *
	 * @return array<int, string>
	 */
	private function blocking_statuses(): array {
		return array( 'pending', 'approved', 'confirmed' );
	}

	/**
	 * Check if slot is available.
	 */
	public function is_slot_available( string $date, string $time ): bool {
		global $wpdb;
		$table    = $this->bookings_table();
		$statuses = $this->blocking_statuses();
		$placeholders = implode( ',', array_fill( 0, count( $statuses ), '%s' ) );

		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.PreparedSQLPlaceholders.UnfinishedPlaceholder
		$sql = $wpdb->prepare(
			"SELECT COUNT(*) FROM {$table} WHERE booking_date = %s AND booking_time = %s AND status IN ({$placeholders})",
			array_merge( array( $date, $time ), $statuses )
		);

		return 0 === (int) $wpdb->get_var( $sql );
	}

	/**
	 * Get booked times for a date.
	 *
	 * @return array<int, string>
	 */
	public function get_booked_times_for_date( string $date ): array {
		global $wpdb;
		$table    = $this->bookings_table();
		$statuses = $this->blocking_statuses();
		$placeholders = implode( ',', array_fill( 0, count( $statuses ), '%s' ) );

		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.PreparedSQLPlaceholders.UnfinishedPlaceholder
		$sql = $wpdb->prepare(
			"SELECT booking_time FROM {$table} WHERE booking_date = %s AND status IN ({$placeholders})",
			array_merge( array( $date ), $statuses )
		);

		$rows = $wpdb->get_col( $sql );
		return array_map( 'strval', $rows );
	}

	/**
	 * Create booking.
	 *
	 * @param array<string, mixed> $data Booking data.
	 * @return int|false
	 */
	public function create( array $data ) {
		global $wpdb;
		$result = $wpdb->insert( $this->bookings_table(), $data );
		return false !== $result ? (int) $wpdb->insert_id : false;
	}

	/**
	 * Update booking.
	 *
	 * @param int                  $id   Booking ID.
	 * @param array<string, mixed> $data Data.
	 */
	public function update( int $id, array $data ): bool {
		global $wpdb;
		return false !== $wpdb->update( $this->bookings_table(), $data, array( 'id' => $id ) );
	}

	/**
	 * Find booking by ID with joins.
	 */
	public function find( int $id ): ?object {
		global $wpdb;
		$b = $this->bookings_table();
		$c = $this->clients_table();
		$s = $this->services_table();

		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$row = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT b.*, c.first_name, c.last_name, c.email, c.phone, c.address, c.city, c.state, c.zip, c.country, c.preferred_contact,
				s.name AS service_name, s.investment_display, s.duration_minutes
				FROM {$b} b
				INNER JOIN {$c} c ON c.id = b.client_id
				INNER JOIN {$s} s ON s.id = b.service_id
				WHERE b.id = %d",
				$id
			)
		);
		return $row ?: null;
	}

	/**
	 * Find by reference.
	 */
	public function find_by_ref( string $ref ): ?object {
		global $wpdb;
		$b = $this->bookings_table();
		$c = $this->clients_table();
		$s = $this->services_table();

		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$row = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT b.*, c.first_name, c.last_name, c.email, c.phone, c.address, c.city, c.state, c.zip, c.country, c.preferred_contact,
				s.name AS service_name, s.investment_display, s.duration_minutes
				FROM {$b} b
				INNER JOIN {$c} c ON c.id = b.client_id
				INNER JOIN {$s} s ON s.id = b.service_id
				WHERE b.booking_ref = %s",
				$ref
			)
		);
		return $row ?: null;
	}

	/**
	 * List bookings with filters.
	 *
	 * @param array<string, mixed> $args Query args.
	 * @return array<int, object>
	 */
	public function list( array $args = array() ): array {
		global $wpdb;
		$b = $this->bookings_table();
		$c = $this->clients_table();
		$s = $this->services_table();

		$defaults = array(
			'status'   => '',
			'search'   => '',
			'date_from'=> '',
			'date_to'  => '',
			'limit'    => 50,
			'offset'   => 0,
		);
		$args     = wp_parse_args( $args, $defaults );

		$where  = array( '1=1' );
		$params = array();

		if ( ! empty( $args['status'] ) ) {
			$where[]  = 'b.status = %s';
			$params[] = $args['status'];
		}

		if ( ! empty( $args['search'] ) ) {
			$like     = '%' . $wpdb->esc_like( $args['search'] ) . '%';
			$where[]  = '(c.first_name LIKE %s OR c.last_name LIKE %s OR c.email LIKE %s OR b.booking_ref LIKE %s)';
			$params   = array_merge( $params, array( $like, $like, $like, $like ) );
		}

		if ( ! empty( $args['date_from'] ) ) {
			$where[]  = 'b.booking_date >= %s';
			$params[] = $args['date_from'];
		}

		if ( ! empty( $args['date_to'] ) ) {
			$where[]  = 'b.booking_date <= %s';
			$params[] = $args['date_to'];
		}

		$where_sql = implode( ' AND ', $where );
		$limit     = absint( $args['limit'] );
		$offset    = absint( $args['offset'] );

		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.PreparedSQLPlaceholders.ReplacementsWrongNumber
		$sql = "SELECT b.*, c.first_name, c.last_name, c.email, c.phone,
			s.name AS service_name, s.investment_display
			FROM {$b} b
			INNER JOIN {$c} c ON c.id = b.client_id
			INNER JOIN {$s} s ON s.id = b.service_id
			WHERE {$where_sql}
			ORDER BY b.booking_date DESC, b.booking_time DESC
			LIMIT {$limit} OFFSET {$offset}";

		if ( ! empty( $params ) ) {
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$sql = $wpdb->prepare( $sql, $params );
		}

		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		return $wpdb->get_results( $sql );
	}

	/**
	 * Count bookings by status.
	 */
	public function count_by_status( string $status ): int {
		global $wpdb;
		$table = $this->bookings_table();
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$table} WHERE status = %s", $status ) );
	}

	/**
	 * Today's appointments.
	 *
	 * @return array<int, object>
	 */
	public function get_today(): array {
		return $this->list(
			array(
				'date_from' => gmdate( 'Y-m-d' ),
				'date_to'   => gmdate( 'Y-m-d' ),
				'limit'     => 20,
			)
		);
	}

	/**
	 * Upcoming bookings.
	 *
	 * @return array<int, object>
	 */
	public function get_upcoming( int $limit = 10 ): array {
		global $wpdb;
		$b = $this->bookings_table();
		$c = $this->clients_table();
		$s = $this->services_table();
		$today = gmdate( 'Y-m-d' );

		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT b.*, c.first_name, c.last_name, c.email, s.name AS service_name
				FROM {$b} b
				INNER JOIN {$c} c ON c.id = b.client_id
				INNER JOIN {$s} s ON s.id = b.service_id
				WHERE b.booking_date >= %s AND b.status IN ('pending','approved','confirmed')
				ORDER BY b.booking_date ASC, b.booking_time ASC
				LIMIT %d",
				$today,
				$limit
			)
		);
	}

	/**
	 * Revenue total for paid bookings.
	 */
	public function get_revenue_total(): float {
		global $wpdb;
		$table = $this->bookings_table();
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return (float) $wpdb->get_var(
			"SELECT COALESCE(SUM(payment_amount), 0) FROM {$table} WHERE payment_status = 'paid'"
		);
	}

	/**
	 * Export all bookings for CSV.
	 *
	 * @return array<int, object>
	 */
	public function export_all(): array {
		return $this->list( array( 'limit' => 10000 ) );
	}
}
