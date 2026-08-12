<?php
/**
 * Uninstall cleanup.
 *
 * @package MDR_ACI
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

delete_option( 'mdr_aci_settings' );

global $wpdb;
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
$wpdb->query(
	$wpdb->prepare(
		"DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
		$wpdb->esc_like( '_transient_mdr_aci_report_' ) . '%',
		$wpdb->esc_like( '_transient_timeout_mdr_aci_report_' ) . '%'
	)
);

$upload = wp_upload_dir();
$dir    = trailingslashit( $upload['basedir'] ) . 'mdr-aci';
if ( is_dir( $dir ) ) {
	$files = glob( trailingslashit( $dir ) . '*' );
	if ( is_array( $files ) ) {
		foreach ( $files as $file ) {
			if ( is_file( $file ) ) {
				wp_delete_file( $file );
			}
		}
	}
}
