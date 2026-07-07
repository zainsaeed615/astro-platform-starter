<?php
/**
 * Database schema management.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Database;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Schema
 */
class Schema {

	/**
	 * Create all plugin tables.
	 */
	public static function create_tables(): void {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$services = $wpdb->prefix . 'ssb_services';
		$bookings = $wpdb->prefix . 'ssb_bookings';
		$slots    = $wpdb->prefix . 'ssb_time_slots';
		$days     = $wpdb->prefix . 'ssb_availability_days';
		$blocked  = $wpdb->prefix . 'ssb_blocked_dates';
		$clients  = $wpdb->prefix . 'ssb_clients';
		$notes    = $wpdb->prefix . 'ssb_booking_notes';

		$sql = array();

		$sql[] = "CREATE TABLE {$services} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			name varchar(255) NOT NULL,
			slug varchar(255) NOT NULL,
			description longtext NOT NULL,
			investment_display varchar(255) NOT NULL DEFAULT '',
			investment_min decimal(10,2) DEFAULT NULL,
			investment_max decimal(10,2) DEFAULT NULL,
			duration_minutes int(11) NOT NULL DEFAULT 90,
			payment_mode varchar(32) NOT NULL DEFAULT 'none',
			payment_amount decimal(10,2) DEFAULT NULL,
			locations varchar(255) NOT NULL DEFAULT 'virtual,in_home',
			is_active tinyint(1) NOT NULL DEFAULT 1,
			sort_order int(11) NOT NULL DEFAULT 0,
			created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			UNIQUE KEY slug (slug),
			KEY is_active (is_active)
		) {$charset_collate};";

		$sql[] = "CREATE TABLE {$clients} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			first_name varchar(100) NOT NULL,
			last_name varchar(100) NOT NULL,
			email varchar(255) NOT NULL,
			phone varchar(50) NOT NULL DEFAULT '',
			address varchar(255) NOT NULL DEFAULT '',
			city varchar(100) NOT NULL DEFAULT '',
			state varchar(100) NOT NULL DEFAULT '',
			zip varchar(20) NOT NULL DEFAULT '',
			country varchar(100) NOT NULL DEFAULT 'United States',
			preferred_contact varchar(50) NOT NULL DEFAULT 'email',
			created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY email (email)
		) {$charset_collate};";

		$sql[] = "CREATE TABLE {$bookings} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			booking_ref varchar(32) NOT NULL,
			service_id bigint(20) unsigned NOT NULL,
			client_id bigint(20) unsigned NOT NULL,
			location varchar(32) NOT NULL DEFAULT 'virtual',
			booking_date date NOT NULL,
			booking_time time NOT NULL,
			status varchar(32) NOT NULL DEFAULT 'pending',
			project_type varchar(255) NOT NULL DEFAULT '',
			referral_source varchar(255) NOT NULL DEFAULT '',
			transformation_goals longtext NOT NULL,
			intentional_ack tinyint(1) NOT NULL DEFAULT 0,
			payment_status varchar(32) NOT NULL DEFAULT 'none',
			payment_amount decimal(10,2) DEFAULT NULL,
			stripe_payment_intent_id varchar(255) DEFAULT NULL,
			stripe_session_id varchar(255) DEFAULT NULL,
			admin_notes longtext,
			created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			UNIQUE KEY booking_ref (booking_ref),
			KEY slot_lookup (booking_date, booking_time),
			KEY service_id (service_id),
			KEY client_id (client_id),
			KEY status (status),
			KEY booking_date (booking_date)
		) {$charset_collate};";

		$sql[] = "CREATE TABLE {$slots} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			slot_time time NOT NULL,
			label varchar(50) NOT NULL DEFAULT '',
			is_active tinyint(1) NOT NULL DEFAULT 1,
			sort_order int(11) NOT NULL DEFAULT 0,
			PRIMARY KEY (id),
			UNIQUE KEY slot_time (slot_time)
		) {$charset_collate};";

		$sql[] = "CREATE TABLE {$days} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			day_of_week tinyint(1) NOT NULL,
			is_available tinyint(1) NOT NULL DEFAULT 0,
			PRIMARY KEY (id),
			UNIQUE KEY day_of_week (day_of_week)
		) {$charset_collate};";

		$sql[] = "CREATE TABLE {$blocked} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			blocked_date date NOT NULL,
			reason varchar(255) NOT NULL DEFAULT '',
			PRIMARY KEY (id),
			UNIQUE KEY blocked_date (blocked_date)
		) {$charset_collate};";

		$sql[] = "CREATE TABLE {$notes} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			booking_id bigint(20) unsigned NOT NULL,
			note longtext NOT NULL,
			author_id bigint(20) unsigned NOT NULL DEFAULT 0,
			created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY booking_id (booking_id)
		) {$charset_collate};";

		foreach ( $sql as $query ) {
			dbDelta( $query );
		}
	}
}
