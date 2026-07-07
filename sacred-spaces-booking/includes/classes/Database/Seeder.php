<?php
/**
 * Default data seeder.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking\Database;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Seeder
 */
class Seeder {

	/**
	 * Seed default services, time slots, and settings.
	 */
	public static function seed_defaults(): void {
		global $wpdb;

		$services_table = $wpdb->prefix . 'ssb_services';
		$count          = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$services_table}" );

		if ( 0 === $count ) {
			$services = array(
				array(
					'name'               => 'Private Consultation',
					'slug'               => 'private-consultation',
					'description'        => 'Focused consultation bringing clarity, harmony and energetic alignment.',
					'investment_display' => '$900',
					'investment_min'     => 900.00,
					'investment_max'     => 900.00,
					'duration_minutes'   => 90,
					'payment_mode'       => 'full',
					'payment_amount'     => 900.00,
					'locations'          => 'virtual,in_home',
					'is_active'          => 1,
					'sort_order'         => 1,
				),
				array(
					'name'               => 'Spatial Reset – Private Client Experience',
					'slug'               => 'spatial-reset',
					'description'        => 'A transformative private client experience tailored to your home and lifestyle.',
					'investment_display' => 'Investment determined after consultation.',
					'investment_min'     => 4000.00,
					'investment_max'     => 6500.00,
					'duration_minutes'   => 90,
					'payment_mode'       => 'none',
					'payment_amount'     => null,
					'locations'          => 'in_home',
					'is_active'          => 1,
					'sort_order'         => 2,
				),
				array(
					'name'               => 'Private Retainer',
					'slug'               => 'private-retainer',
					'description'        => 'Ongoing design partnership for discerning clients seeking continuous refinement.',
					'investment_display' => 'Schedule an introductory consultation.',
					'investment_min'     => 3500.00,
					'investment_max'     => 5000.00,
					'duration_minutes'   => 90,
					'payment_mode'       => 'none',
					'payment_amount'     => null,
					'locations'          => 'virtual,in_home',
					'is_active'          => 1,
					'sort_order'         => 3,
				),
			);

			foreach ( $services as $service ) {
				$wpdb->insert( $services_table, $service );
			}
		}

		$slots_table = $wpdb->prefix . 'ssb_time_slots';
		$slot_count  = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$slots_table}" );

		if ( 0 === $slot_count ) {
			$slots = array(
				array( 'slot_time' => '10:00:00', 'label' => '10:00 AM', 'sort_order' => 1 ),
				array( 'slot_time' => '11:30:00', 'label' => '11:30 AM', 'sort_order' => 2 ),
				array( 'slot_time' => '13:30:00', 'label' => '1:30 PM', 'sort_order' => 3 ),
				array( 'slot_time' => '15:00:00', 'label' => '3:00 PM', 'sort_order' => 4 ),
				array( 'slot_time' => '16:30:00', 'label' => '4:30 PM', 'sort_order' => 5 ),
			);

			foreach ( $slots as $slot ) {
				$wpdb->insert( $slots_table, $slot );
			}
		}

		$days_table = $wpdb->prefix . 'ssb_availability_days';
		$day_count  = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$days_table}" );

		if ( 0 === $day_count ) {
			for ( $d = 0; $d <= 6; $d++ ) {
				$wpdb->insert(
					$days_table,
					array(
						'day_of_week'   => $d,
						'is_available'  => in_array( $d, array( 2, 3 ), true ) ? 1 : 0,
					)
				);
			}
		}

		$defaults = array(
			'stripe_mode'              => 'test',
			'stripe_test_publishable'  => '',
			'stripe_test_secret'       => '',
			'stripe_live_publishable'  => '',
			'stripe_live_secret'       => '',
			'stripe_webhook_secret'    => '',
			'default_payment_mode'     => 'full',
			'admin_email'              => get_option( 'admin_email' ),
			'from_name'                => 'Sacred Spaces by Sharon',
			'from_email'               => get_option( 'admin_email' ),
			'booking_lead_days'        => 1,
			'booking_horizon_days'     => 90,
			'google_calendar_enabled'  => 0,
			'outlook_sync_enabled'     => 0,
			'zoom_enabled'             => 0,
			'sms_reminders_enabled'    => 0,
			'client_portal_enabled'    => 0,
		);

		$existing = get_option( 'ssb_settings', array() );
		if ( empty( $existing ) ) {
			update_option( 'ssb_settings', $defaults );
		} else {
			update_option( 'ssb_settings', array_merge( $defaults, $existing ) );
		}

		$email_templates = get_option( 'ssb_email_templates', array() );
		if ( empty( $email_templates ) ) {
			update_option(
				'ssb_email_templates',
				array(
					'client_confirmation_subject' => 'Your Sacred Spaces Session — Confirmation',
					'client_confirmation_body'    => self::default_client_email(),
					'admin_notification_subject'  => 'New Booking Request — {service_name}',
					'admin_notification_body'     => self::default_admin_email(),
				)
			);
		}
	}

	/**
	 * Default client email HTML.
	 */
	private static function default_client_email(): string {
		return '<p>Dear {first_name},</p>
<p>Thank you for beginning your sanctuary journey with Sacred Spaces by Sharon.</p>
<p><strong>Service:</strong> {service_name}<br>
<strong>Date:</strong> {booking_date}<br>
<strong>Time:</strong> {booking_time}<br>
<strong>Location:</strong> {location}<br>
<strong>Investment:</strong> {investment}</p>
<p>We look forward to supporting your transformation with intention and care.</p>
<p>With warmth,<br>Sacred Spaces by Sharon</p>';
	}

	/**
	 * Default admin email HTML.
	 */
	private static function default_admin_email(): string {
		return '<p>A new booking request has been received.</p>
<p><strong>Client:</strong> {first_name} {last_name}<br>
<strong>Email:</strong> {email}<br>
<strong>Phone:</strong> {phone}<br>
<strong>Service:</strong> {service_name}<br>
<strong>Date:</strong> {booking_date} at {booking_time}<br>
<strong>Location:</strong> {location}</p>
<p><strong>Project Type:</strong> {project_type}<br>
<strong>Referral:</strong> {referral_source}</p>
<p><strong>Transformation Goals:</strong><br>{transformation_goals}</p>';
	}
}
