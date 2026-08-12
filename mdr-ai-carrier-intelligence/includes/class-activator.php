<?php
/**
 * Plugin activation routines.
 *
 * @package MDR_ACI
 */

namespace MDR_ACI;

defined( 'ABSPATH' ) || exit;

/**
 * Class Activator
 */
class Activator {

	/**
	 * Run on plugin activation.
	 */
	public static function activate() {
		if ( ! get_option( 'mdr_aci_settings' ) ) {
			update_option( 'mdr_aci_settings', Settings::defaults() );
		}

		self::create_upload_dir();
		flush_rewrite_rules();
	}

	/**
	 * Ensure secure upload directory exists.
	 */
	private static function create_upload_dir() {
		$upload = wp_upload_dir();
		$dir    = trailingslashit( $upload['basedir'] ) . 'mdr-aci';

		if ( ! file_exists( $dir ) ) {
			wp_mkdir_p( $dir );
		}

		$htaccess = $dir . '/.htaccess';
		if ( ! file_exists( $htaccess ) ) {
			file_put_contents( $htaccess, "Options -Indexes\n<FilesMatch \"\\.(php|phtml|php3|php4|php5|php7|phps|cgi|pl|exe)$\">\nDeny from all\n</FilesMatch>\n" ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
		}

		$index = $dir . '/index.php';
		if ( ! file_exists( $index ) ) {
			file_put_contents( $index, "<?php\n// Silence is golden.\n" ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
		}
	}
}
