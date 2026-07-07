<?php
/**
 * Admin email templates.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$templates = get_option( 'ssb_email_templates', array() );
$tokens = '{first_name}, {last_name}, {email}, {phone}, {service_name}, {booking_date}, {booking_time}, {location}, {investment}, {booking_ref}, {project_type}, {referral_source}, {transformation_goals}, {address}';
?>
<div class="ssb-admin-wrap">
	<header class="ssb-admin-header">
		<h1><?php esc_html_e( 'Email Templates', 'sacred-spaces-booking' ); ?></h1>
		<p class="ssb-admin-subtitle"><?php esc_html_e( 'Luxury HTML email customization', 'sacred-spaces-booking' ); ?></p>
	</header>

	<section class="ssb-card">
		<p class="ssb-help"><?php esc_html_e( 'Available tokens:', 'sacred-spaces-booking' ); ?> <code><?php echo esc_html( $tokens ); ?></code></p>

		<form id="ssb-email-templates" class="ssb-settings-form">
			<h2><?php esc_html_e( 'Client Confirmation', 'sacred-spaces-booking' ); ?></h2>
			<div class="ssb-field">
				<label><?php esc_html_e( 'Subject', 'sacred-spaces-booking' ); ?></label>
				<input type="text" name="client_confirmation_subject" value="<?php echo esc_attr( $templates['client_confirmation_subject'] ?? '' ); ?>" class="ssb-input">
			</div>
			<div class="ssb-field">
				<label><?php esc_html_e( 'Body (HTML)', 'sacred-spaces-booking' ); ?></label>
				<textarea name="client_confirmation_body" class="ssb-textarea" rows="10"><?php echo esc_textarea( $templates['client_confirmation_body'] ?? '' ); ?></textarea>
			</div>

			<h2><?php esc_html_e( 'Admin Notification', 'sacred-spaces-booking' ); ?></h2>
			<div class="ssb-field">
				<label><?php esc_html_e( 'Subject', 'sacred-spaces-booking' ); ?></label>
				<input type="text" name="admin_notification_subject" value="<?php echo esc_attr( $templates['admin_notification_subject'] ?? '' ); ?>" class="ssb-input">
			</div>
			<div class="ssb-field">
				<label><?php esc_html_e( 'Body (HTML)', 'sacred-spaces-booking' ); ?></label>
				<textarea name="admin_notification_body" class="ssb-textarea" rows="10"><?php echo esc_textarea( $templates['admin_notification_body'] ?? '' ); ?></textarea>
			</div>

			<button type="submit" class="ssb-btn"><?php esc_html_e( 'Save Templates', 'sacred-spaces-booking' ); ?></button>
		</form>
	</section>
</div>
