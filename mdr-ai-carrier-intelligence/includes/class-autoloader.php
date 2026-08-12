<?php
/**
 * PSR-4 style autoloader for plugin classes.
 *
 * @package MDR_ACI
 */

namespace MDR_ACI;

defined( 'ABSPATH' ) || exit;

/**
 * Class Autoloader
 */
class Autoloader {

	/**
	 * Register autoloader.
	 */
	public static function register() {
		spl_autoload_register( array( __CLASS__, 'autoload' ) );
	}

	/**
	 * Autoload class files.
	 *
	 * @param string $class Class name.
	 */
	public static function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ . '\\' ) ) {
			return;
		}

		$relative = substr( $class, strlen( __NAMESPACE__ . '\\' ) );
		$parts    = explode( '\\', $relative );
		$name     = array_pop( $parts );
		$file     = 'class-' . strtolower( str_replace( '_', '-', $name ) ) . '.php';

		$base = MDR_ACI_PLUGIN_DIR . 'includes/';
		if ( ! empty( $parts ) ) {
			$base .= strtolower( implode( '/', $parts ) ) . '/';
		}

		$path = $base . $file;
		if ( file_exists( $path ) ) {
			require_once $path;
		}
	}
}
