<?php
/**
 * Admin settings template.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

use SacredSpaces\Booking\Helpers\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = Settings::all();
?>
<div class="ssb-admin-wrap">
	<header class="ssb-admin-header">
		<h1><?php esc_html_e( 'Settings', 'sacred-spaces-booking' ); ?></h1>
		<p class="ssb-admin-subtitle"><?php esc_html_e( 'General plugin configuration', 'sacred-spaces-booking' ); ?></p>
	</header>

	<section class="ssb-card">
		<form id="ssb-general-settings" class="ssb-settings-form">
			<h2><?php esc_html_e( 'General', 'sacred-spaces-booking' ); ?></h2>
			<div class="ssb-form-grid">
				<div class="ssb-field">
					<label><?php esc_html_e( 'Admin Email', 'sacred-spaces-booking' ); ?></label>
					<input type="email" name="admin_email" value="<?php echo esc_attr( $settings['admin_email'] ); ?>" class="ssb-input">
				</div>
				<div class="ssb-field">
					<label><?php esc_html_e( 'From Name', 'sacred-spaces-booking' ); ?></label>
					<input type="text" name="from_name" value="<?php echo esc_attr( $settings['from_name'] ); ?>" class="ssb-input">
				</div>
				<div class="ssb-field">
					<label><?php esc_html_e( 'From Email', 'sacred-spaces-booking' ); ?></label>
					<input type="email" name="from_email" value="<?php echo esc_attr( $settings['from_email'] ); ?>" class="ssb-input">
				</div>
				<div class="ssb-field">
					<label><?php esc_html_e( 'Booking Page URL', 'sacred-spaces-booking' ); ?></label>
					<input type="url" name="booking_page_url" value="<?php echo esc_attr( $settings['booking_page_url'] ?? '' ); ?>" class="ssb-input">
				</div>
				<div class="ssb-field">
					<label><?php esc_html_e( 'Lead Days', 'sacred-spaces-booking' ); ?></label>
					<input type="number" name="booking_lead_days" value="<?php echo esc_attr( (string) $settings['booking_lead_days'] ); ?>" class="ssb-input">
				</div>
				<div class="ssb-field">
					<label><?php esc_html_e( 'Booking Horizon (days)', 'sacred-spaces-booking' ); ?></label>
					<input type="number" name="booking_horizon_days" value="<?php echo esc_attr( (string) $settings['booking_horizon_days'] ); ?>" class="ssb-input">
				</div>
			</div>

			<h2><?php esc_html_e( 'Premium Features', 'sacred-spaces-booking' ); ?></h2>
			<p class="ssb-help"><?php esc_html_e( 'Enable optional integrations (requires additional configuration).', 'sacred-spaces-booking' ); ?></p>
			<div class="ssb-premium-features">
				<label><input type="checkbox" name="google_calendar_enabled" value="1" <?php checked( ! empty( $settings['google_calendar_enabled'] ) ); ?>> <?php esc_html_e( 'Google Calendar Sync', 'sacred-spaces-booking' ); ?></label>
				<label><input type="checkbox" name="outlook_sync_enabled" value="1" <?php checked( ! empty( $settings['outlook_sync_enabled'] ) ); ?>> <?php esc_html_e( 'Outlook Sync', 'sacred-spaces-booking' ); ?></label>
				<label><input type="checkbox" name="zoom_enabled" value="1" <?php checked( ! empty( $settings['zoom_enabled'] ) ); ?>> <?php esc_html_e( 'Zoom Integration', 'sacred-spaces-booking' ); ?></label>
				<label><input type="checkbox" name="sms_reminders_enabled" value="1" <?php checked( ! empty( $settings['sms_reminders_enabled'] ) ); ?>> <?php esc_html_e( 'SMS Reminders', 'sacred-spaces-booking' ); ?></label>
				<label><input type="checkbox" name="client_portal_enabled" value="1" <?php checked( ! empty( $settings['client_portal_enabled'] ) ); ?>> <?php esc_html_e( 'Client Portal', 'sacred-spaces-booking' ); ?></label>
			</div>

			<button type="submit" class="ssb-btn"><?php esc_html_e( 'Save Settings', 'sacred-spaces-booking' ); ?></button>
		</form>
	</section>

	<section class="ssb-card">
		<h2><?php esc_html_e( 'Shortcodes', 'sacred-spaces-booking' ); ?></h2>
		<ul class="ssb-shortcode-list">
			<li><code>[sacred_booking]</code> — <?php esc_html_e( 'Full 8-step booking wizard', 'sacred-spaces-booking' ); ?></li>
			<li><code>[sacred_calendar]</code> — <?php esc_html_e( 'Standalone calendar view', 'sacred-spaces-booking' ); ?></li>
			<li><code>[sacred_services]</code> — <?php esc_html_e( 'Services listing', 'sacred-spaces-booking' ); ?></li>
		</ul>
	</section>
</div>
