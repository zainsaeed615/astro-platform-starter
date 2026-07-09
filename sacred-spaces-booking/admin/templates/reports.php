<?php
/**
 * Admin reports template.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

use SacredSpaces\Booking\Repositories\BookingRepository;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bookings = new BookingRepository();
$total    = count( $bookings->list( array( 'limit' => 10000 ) ) );
$pending  = $bookings->count_by_status( 'pending' );
$confirmed = $bookings->count_by_status( 'confirmed' );
$approved  = $bookings->count_by_status( 'approved' );
$cancelled = $bookings->count_by_status( 'cancelled' );
?>
<div class="ssb-admin-wrap">
	<header class="ssb-admin-header">
		<h1><?php esc_html_e( 'Reports', 'sacred-spaces-booking' ); ?></h1>
		<p class="ssb-admin-subtitle"><?php esc_html_e( 'Booking analytics and insights', 'sacred-spaces-booking' ); ?></p>
	</header>

	<div class="ssb-stats-grid">
		<div class="ssb-stat-card">
			<span class="ssb-stat-label"><?php esc_html_e( 'Total Bookings', 'sacred-spaces-booking' ); ?></span>
			<span class="ssb-stat-value"><?php echo esc_html( (string) $total ); ?></span>
		</div>
		<div class="ssb-stat-card">
			<span class="ssb-stat-label"><?php esc_html_e( 'Confirmed', 'sacred-spaces-booking' ); ?></span>
			<span class="ssb-stat-value"><?php echo esc_html( (string) $confirmed ); ?></span>
		</div>
		<div class="ssb-stat-card">
			<span class="ssb-stat-label"><?php esc_html_e( 'Pending', 'sacred-spaces-booking' ); ?></span>
			<span class="ssb-stat-value"><?php echo esc_html( (string) $pending ); ?></span>
		</div>
		<div class="ssb-stat-card">
			<span class="ssb-stat-label"><?php esc_html_e( 'Cancelled', 'sacred-spaces-booking' ); ?></span>
			<span class="ssb-stat-value"><?php echo esc_html( (string) $cancelled ); ?></span>
		</div>
		<div class="ssb-stat-card ssb-stat-card--wide">
			<span class="ssb-stat-label"><?php esc_html_e( 'Approved', 'sacred-spaces-booking' ); ?></span>
			<span class="ssb-stat-value"><?php echo esc_html( (string) $approved ); ?></span>
		</div>
	</div>
</div>
