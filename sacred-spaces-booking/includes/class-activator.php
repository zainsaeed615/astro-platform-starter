<?php
/**
 * Plugin activation.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking;

use SacredSpaces\Booking\Database\Schema;
use SacredSpaces\Booking\Database\Seeder;
use SacredSpaces\Booking\Database\Upgrader;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Activator
 */
class Activator {

	/**
	 * Run on plugin activation.
	 */
	public static function activate(): void {
		Schema::create_tables();
		Seeder::seed_defaults();
		Upgrader::maybe_upgrade();
		flush_rewrite_rules();
		update_option( 'ssb_version', SSB_VERSION );
	}
}
