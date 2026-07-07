<?php
/**
 * Admin payments template.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

use SacredSpaces\Booking\Helpers\Settings;
use SacredSpaces\Booking\Repositories\BookingRepository;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = Settings::all();
$bookings = ( new BookingRepository() )->list( array( 'limit' => 50 ) );
$paid     = array_filter( $bookings, fn( $b ) => 'paid' === $b->payment_status );
?>
<div class="ssb-admin-wrap">
	<header class="ssb-admin-header">
		<h1><?php esc_html_e( 'Payments', 'sacred-spaces-booking' ); ?></h1>
		<p class="ssb-admin-subtitle"><?php esc_html_e( 'Stripe configuration and payment history', 'sacred-spaces-booking' ); ?></p>
	</header>

	<section class="ssb-card">
		<h2><?php esc_html_e( 'Stripe Settings', 'sacred-spaces-booking' ); ?></h2>
		<form id="ssb-payments-settings" class="ssb-settings-form">
			<div class="ssb-form-grid">
				<div class="ssb-field">
					<label><?php esc_html_e( 'Mode', 'sacred-spaces-booking' ); ?></label>
					<select name="stripe_mode" class="ssb-select">
						<option value="test" <?php selected( $settings['stripe_mode'], 'test' ); ?>><?php esc_html_e( 'Test', 'sacred-spaces-booking' ); ?></option>
						<option value="live" <?php selected( $settings['stripe_mode'], 'live' ); ?>><?php esc_html_e( 'Live', 'sacred-spaces-booking' ); ?></option>
					</select>
				</div>
				<div class="ssb-field">
					<label><?php esc_html_e( 'Test Publishable Key', 'sacred-spaces-booking' ); ?></label>
					<input type="text" name="stripe_test_publishable" value="<?php echo esc_attr( $settings['stripe_test_publishable'] ); ?>" class="ssb-input">
				</div>
				<div class="ssb-field">
					<label><?php esc_html_e( 'Test Secret Key', 'sacred-spaces-booking' ); ?></label>
					<input type="password" name="stripe_test_secret" value="<?php echo esc_attr( $settings['stripe_test_secret'] ); ?>" class="ssb-input">
				</div>
				<div class="ssb-field">
					<label><?php esc_html_e( 'Live Publishable Key', 'sacred-spaces-booking' ); ?></label>
					<input type="text" name="stripe_live_publishable" value="<?php echo esc_attr( $settings['stripe_live_publishable'] ); ?>" class="ssb-input">
				</div>
				<div class="ssb-field">
					<label><?php esc_html_e( 'Live Secret Key', 'sacred-spaces-booking' ); ?></label>
					<input type="password" name="stripe_live_secret" value="<?php echo esc_attr( $settings['stripe_live_secret'] ); ?>" class="ssb-input">
				</div>
				<div class="ssb-field ssb-field--full">
					<label><?php esc_html_e( 'Webhook Secret', 'sacred-spaces-booking' ); ?></label>
					<input type="password" name="stripe_webhook_secret" value="<?php echo esc_attr( $settings['stripe_webhook_secret'] ); ?>" class="ssb-input">
					<p class="ssb-help"><?php esc_html_e( 'Webhook URL:', 'sacred-spaces-booking' ); ?> <code><?php echo esc_html( rest_url( 'sacred-spaces-booking/v1/stripe-webhook' ) ); ?></code></p>
				</div>
			</div>
			<button type="submit" class="ssb-btn"><?php esc_html_e( 'Save Payment Settings', 'sacred-spaces-booking' ); ?></button>
		</form>
	</section>

	<section class="ssb-card">
		<h2><?php esc_html_e( 'Recent Payments', 'sacred-spaces-booking' ); ?></h2>
		<table class="ssb-table">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Ref', 'sacred-spaces-booking' ); ?></th>
					<th><?php esc_html_e( 'Client', 'sacred-spaces-booking' ); ?></th>
					<th><?php esc_html_e( 'Amount', 'sacred-spaces-booking' ); ?></th>
					<th><?php esc_html_e( 'Status', 'sacred-spaces-booking' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $paid as $b ) : ?>
					<tr>
						<td><?php echo esc_html( $b->booking_ref ); ?></td>
						<td><?php echo esc_html( $b->first_name . ' ' . $b->last_name ); ?></td>
						<td>$<?php echo esc_html( number_format( (float) $b->payment_amount, 2 ) ); ?></td>
						<td><span class="ssb-badge ssb-badge--confirmed"><?php echo esc_html( ucfirst( $b->payment_status ) ); ?></span></td>
					</tr>
				<?php endforeach; ?>
				<?php if ( empty( $paid ) ) : ?>
					<tr><td colspan="4" class="ssb-empty"><?php esc_html_e( 'No payments yet.', 'sacred-spaces-booking' ); ?></td></tr>
				<?php endif; ?>
			</tbody>
		</table>
	</section>
</div>
