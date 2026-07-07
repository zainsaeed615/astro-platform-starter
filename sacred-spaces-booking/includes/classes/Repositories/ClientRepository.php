<?php
/**
 * Client repository.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Repositories;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class ClientRepository
 */
class ClientRepository {

	/**
	 * Table name.
	 */
	private function table(): string {
		global $wpdb;
		return $wpdb->prefix . 'ssb_clients';
	}

	/**
	 * Find by email.
	 */
	public function find_by_email( string $email ): ?object {
		global $wpdb;
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$this->table()} WHERE email = %s", $email ) );
		return $row ?: null;
	}

	/**
	 * Create client.
	 *
	 * @param array<string, mixed> $data Client data.
	 * @return int|false
	 */
	public function create( array $data ) {
		global $wpdb;
		$result = $wpdb->insert( $this->table(), $data );
		return false !== $result ? (int) $wpdb->insert_id : false;
	}

	/**
	 * Update client.
	 *
	 * @param int                  $id   Client ID.
	 * @param array<string, mixed> $data Data.
	 */
	public function update( int $id, array $data ): bool {
		global $wpdb;
		return false !== $wpdb->update( $this->table(), $data, array( 'id' => $id ) );
	}

	/**
	 * Recent clients.
	 *
	 * @return array<int, object>
	 */
	public function get_recent( int $limit = 10 ): array {
		global $wpdb;
		$table = $this->table();
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return $wpdb->get_results(
			$wpdb->prepare( "SELECT * FROM {$table} ORDER BY created_at DESC LIMIT %d", $limit )
		);
	}
}
