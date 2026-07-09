<?php
/**
 * Plugin upgrade routines.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Database;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Upgrader
 */
class Upgrader {

	/**
	 * Run versioned upgrades.
	 */
	public static function maybe_upgrade(): void {
		$stored  = get_option( 'ssb_version', '0' );
		$current = SSB_VERSION;

		if ( version_compare( $stored, $current, '>=' ) ) {
			return;
		}

		if ( version_compare( $stored, '1.1.0', '<' ) ) {
			self::disable_payments();
		}

		update_option( 'ssb_version', $current );
	}

	/**
	 * Disable online payments for all services.
	 */
	private static function disable_payments(): void {
		global $wpdb;

		$table = $wpdb->prefix . 'ssb_services';
		// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$wpdb->query( "UPDATE {$table} SET payment_mode = 'none', payment_amount = NULL" );
	}
}
