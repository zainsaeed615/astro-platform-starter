<?php
/**
 * Uninstall Sacred Spaces Booking.
 *
 * @package SacredSpaces\Booking
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

$delete_data = get_option( 'ssb_delete_data_on_uninstall', false );

if ( ! $delete_data ) {
	return;
}

$tables = array(
	$wpdb->prefix . 'ssb_services',
	$wpdb->prefix . 'ssb_bookings',
	$wpdb->prefix . 'ssb_time_slots',
	$wpdb->prefix . 'ssb_availability_days',
	$wpdb->prefix . 'ssb_blocked_dates',
	$wpdb->prefix . 'ssb_clients',
	$wpdb->prefix . 'ssb_booking_notes',
);

foreach ( $tables as $table ) {
	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$wpdb->query( "DROP TABLE IF EXISTS {$table}" );
}

delete_option( 'ssb_settings' );
delete_option( 'ssb_email_templates' );
delete_option( 'ssb_version' );
delete_option( 'ssb_delete_data_on_uninstall' );
