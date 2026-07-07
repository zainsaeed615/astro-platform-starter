<?php
/**
 * Admin dashboard template.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

use SacredSpaces\Booking\Repositories\BookingRepository;
use SacredSpaces\Booking\Repositories\ClientRepository;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bookings = new BookingRepository();
$clients  = new ClientRepository();

$today       = $bookings->get_today();
$upcoming    = $bookings->get_upcoming( 8 );
$revenue     = $bookings->get_revenue_total();
$pending     = $bookings->count_by_status( 'pending' );
$recent      = $clients->get_recent( 6 );
?>
<div class="ssb-admin-wrap">
	<header class="ssb-admin-header">
		<h1><?php esc_html_e( 'Sacred Spaces', 'sacred-spaces-booking' ); ?></h1>
		<p class="ssb-admin-subtitle"><?php esc_html_e( 'Sanctuary booking dashboard', 'sacred-spaces-booking' ); ?></p>
	</header>

	<div class="ssb-stats-grid">
		<div class="ssb-stat-card">
			<span class="ssb-stat-label"><?php esc_html_e( "Today's Appointments", 'sacred-spaces-booking' ); ?></span>
			<span class="ssb-stat-value"><?php echo esc_html( (string) count( $today ) ); ?></span>
		</div>
		<div class="ssb-stat-card">
			<span class="ssb-stat-label"><?php esc_html_e( 'Pending Requests', 'sacred-spaces-booking' ); ?></span>
			<span class="ssb-stat-value"><?php echo esc_html( (string) $pending ); ?></span>
		</div>
		<div class="ssb-stat-card">
			<span class="ssb-stat-label"><?php esc_html_e( 'Revenue', 'sacred-spaces-booking' ); ?></span>
			<span class="ssb-stat-value">$<?php echo esc_html( number_format( $revenue, 0 ) ); ?></span>
		</div>
		<div class="ssb-stat-card">
			<span class="ssb-stat-label"><?php esc_html_e( 'Upcoming', 'sacred-spaces-booking' ); ?></span>
			<span class="ssb-stat-value"><?php echo esc_html( (string) count( $upcoming ) ); ?></span>
		</div>
	</div>

	<div class="ssb-admin-grid">
		<section class="ssb-card">
			<h2><?php esc_html_e( "Today's Appointments", 'sacred-spaces-booking' ); ?></h2>
			<?php if ( empty( $today ) ) : ?>
				<p class="ssb-empty"><?php esc_html_e( 'No appointments scheduled for today.', 'sacred-spaces-booking' ); ?></p>
			<?php else : ?>
				<table class="ssb-table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Time', 'sacred-spaces-booking' ); ?></th>
							<th><?php esc_html_e( 'Client', 'sacred-spaces-booking' ); ?></th>
							<th><?php esc_html_e( 'Service', 'sacred-spaces-booking' ); ?></th>
							<th><?php esc_html_e( 'Status', 'sacred-spaces-booking' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $today as $b ) : ?>
							<tr>
								<td><?php echo esc_html( gmdate( 'g:i A', strtotime( $b->booking_time ) ) ); ?></td>
								<td><?php echo esc_html( $b->first_name . ' ' . $b->last_name ); ?></td>
								<td><?php echo esc_html( $b->service_name ); ?></td>
								<td><span class="ssb-badge ssb-badge--<?php echo esc_attr( $b->status ); ?>"><?php echo esc_html( ucfirst( $b->status ) ); ?></span></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</section>

		<section class="ssb-card">
			<h2><?php esc_html_e( 'Upcoming Bookings', 'sacred-spaces-booking' ); ?></h2>
			<?php if ( empty( $upcoming ) ) : ?>
				<p class="ssb-empty"><?php esc_html_e( 'No upcoming bookings.', 'sacred-spaces-booking' ); ?></p>
			<?php else : ?>
				<ul class="ssb-list">
					<?php foreach ( $upcoming as $b ) : ?>
						<li>
							<strong><?php echo esc_html( gmdate( 'M j', strtotime( $b->booking_date ) ) . ' · ' . gmdate( 'g:i A', strtotime( $b->booking_time ) ) ); ?></strong>
							<span><?php echo esc_html( $b->first_name . ' ' . $b->last_name ); ?> — <?php echo esc_html( $b->service_name ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</section>

		<section class="ssb-card">
			<h2><?php esc_html_e( 'Recent Clients', 'sacred-spaces-booking' ); ?></h2>
			<ul class="ssb-list">
				<?php foreach ( $recent as $c ) : ?>
					<li>
						<strong><?php echo esc_html( $c->first_name . ' ' . $c->last_name ); ?></strong>
						<span><?php echo esc_html( $c->email ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	</div>
</div>
