<?php
/**
 * PSR-4 autoloader for Sacred Spaces Booking.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Autoloader
 */
class Autoloader {

	/**
	 * Register the autoloader.
	 */
	public static function register(): void {
		spl_autoload_register( array( __CLASS__, 'autoload' ) );
	}

	/**
	 * Autoload classes.
	 *
	 * @param string $class Class name.
	 */
	public static function autoload( string $class ): void {
		$prefix = 'SacredSpaces\\Booking\\';

		if ( strncmp( $prefix, $class, strlen( $prefix ) ) !== 0 ) {
			return;
		}

		$relative = substr( $class, strlen( $prefix ) );

		// PSR-4 classes under includes/classes/.
		$psr4_file = SSB_PLUGIN_DIR . 'includes/classes/' . str_replace( '\\', '/', $relative ) . '.php';
		if ( file_exists( $psr4_file ) ) {
			require_once $psr4_file;
			return;
		}

		// Core bootstrap classes: includes/class-{name}.php (e.g. Plugin, Activator).
		if ( false === strpos( $relative, '\\' ) ) {
			$legacy_file = SSB_PLUGIN_DIR . 'includes/class-' . strtolower( $relative ) . '.php';
			if ( file_exists( $legacy_file ) ) {
				require_once $legacy_file;
			}
		}
	}
}
