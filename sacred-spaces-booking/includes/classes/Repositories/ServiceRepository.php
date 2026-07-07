<?php
/**
 * Service repository.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Repositories;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class ServiceRepository
 */
class ServiceRepository {

	/**
	 * Table name.
	 */
	private function table(): string {
		global $wpdb;
		return $wpdb->prefix . 'ssb_services';
	}

	/**
	 * Get all active services.
	 *
	 * @return array<int, object>
	 */
	public function get_active(): array {
		global $wpdb;
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return $wpdb->get_results( "SELECT * FROM {$this->table()} WHERE is_active = 1 ORDER BY sort_order ASC" );
	}

	/**
	 * Get all services.
	 *
	 * @return array<int, object>
	 */
	public function get_all(): array {
		global $wpdb;
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return $wpdb->get_results( "SELECT * FROM {$this->table()} ORDER BY sort_order ASC" );
	}

	/**
	 * Find by ID.
	 *
	 * @param int $id Service ID.
	 */
	public function find( int $id ): ?object {
		global $wpdb;
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$this->table()} WHERE id = %d", $id ) );
		return $row ?: null;
	}

	/**
	 * Update service.
	 *
	 * @param int                  $id   Service ID.
	 * @param array<string, mixed> $data Data.
	 * @return bool
	 */
	public function update( int $id, array $data ): bool {
		global $wpdb;
		return false !== $wpdb->update( $this->table(), $data, array( 'id' => $id ) );
	}

	/**
	 * Create service.
	 *
	 * @param array<string, mixed> $data Data.
	 * @return int|false
	 */
	public function create( array $data ) {
		global $wpdb;
		$result = $wpdb->insert( $this->table(), $data );
		return false !== $result ? (int) $wpdb->insert_id : false;
	}

	/**
	 * Delete service.
	 *
	 * @param int $id Service ID.
	 */
	public function delete( int $id ): bool {
		global $wpdb;
		return false !== $wpdb->delete( $this->table(), array( 'id' => $id ) );
	}
}
