<?php
/**
 * Admin bookings template.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

use SacredSpaces\Booking\Repositories\BookingRepository;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$status = sanitize_text_field( wp_unslash( $_GET['status'] ?? '' ) );
$search = sanitize_text_field( wp_unslash( $_GET['s'] ?? '' ) );

$bookings = ( new BookingRepository() )->list(
	array(
		'status' => $status,
		'search' => $search,
		'limit'  => 100,
	)
);

$statuses = array( '', 'pending', 'approved', 'confirmed', 'declined', 'cancelled', 'rescheduled' );
?>
<div class="ssb-admin-wrap">
	<header class="ssb-admin-header ssb-admin-header--row">
		<div>
			<h1><?php esc_html_e( 'Bookings', 'sacred-spaces-booking' ); ?></h1>
			<p class="ssb-admin-subtitle"><?php esc_html_e( 'Manage sanctuary sessions', 'sacred-spaces-booking' ); ?></p>
		</div>
		<a href="<?php echo esc_url( admin_url( 'admin-ajax.php?action=ssb_export_bookings&nonce=' . wp_create_nonce( 'ssb_admin_nonce' ) ) ); ?>" class="ssb-btn ssb-btn--outline">
			<?php esc_html_e( 'Export CSV', 'sacred-spaces-booking' ); ?>
		</a>
	</header>

	<div class="ssb-filters">
		<form method="get" class="ssb-filter-form">
			<input type="hidden" name="page" value="sacred-spaces-bookings">
			<input type="search" name="s" value="<?php echo esc_attr( $search ); ?>" placeholder="<?php esc_attr_e( 'Search clients...', 'sacred-spaces-booking' ); ?>" class="ssb-input">
			<select name="status" class="ssb-select">
				<option value=""><?php esc_html_e( 'All statuses', 'sacred-spaces-booking' ); ?></option>
				<?php foreach ( $statuses as $s ) : ?>
					<?php if ( '' === $s ) { continue; } ?>
					<option value="<?php echo esc_attr( $s ); ?>" <?php selected( $status, $s ); ?>><?php echo esc_html( ucfirst( $s ) ); ?></option>
				<?php endforeach; ?>
			</select>
			<button type="submit" class="ssb-btn"><?php esc_html_e( 'Filter', 'sacred-spaces-booking' ); ?></button>
		</form>
	</div>

	<section class="ssb-card">
		<table class="ssb-table ssb-table--bookings">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Ref', 'sacred-spaces-booking' ); ?></th>
					<th><?php esc_html_e( 'Client', 'sacred-spaces-booking' ); ?></th>
					<th><?php esc_html_e( 'Service', 'sacred-spaces-booking' ); ?></th>
					<th><?php esc_html_e( 'Date', 'sacred-spaces-booking' ); ?></th>
					<th><?php esc_html_e( 'Time', 'sacred-spaces-booking' ); ?></th>
					<th><?php esc_html_e( 'Status', 'sacred-spaces-booking' ); ?></th>
					<th><?php esc_html_e( 'Payment', 'sacred-spaces-booking' ); ?></th>
					<th><?php esc_html_e( 'Actions', 'sacred-spaces-booking' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( empty( $bookings ) ) : ?>
					<tr><td colspan="8" class="ssb-empty"><?php esc_html_e( 'No bookings found.', 'sacred-spaces-booking' ); ?></td></tr>
				<?php else : ?>
					<?php foreach ( $bookings as $b ) : ?>
						<tr data-booking-id="<?php echo esc_attr( (string) $b->id ); ?>">
							<td><code><?php echo esc_html( $b->booking_ref ); ?></code></td>
							<td>
								<strong><?php echo esc_html( $b->first_name . ' ' . $b->last_name ); ?></strong><br>
								<small><?php echo esc_html( $b->email ); ?></small>
							</td>
							<td><?php echo esc_html( $b->service_name ); ?></td>
							<td><?php echo esc_html( gmdate( 'M j, Y', strtotime( $b->booking_date ) ) ); ?></td>
							<td><?php echo esc_html( gmdate( 'g:i A', strtotime( $b->booking_time ) ) ); ?></td>
							<td><span class="ssb-badge ssb-badge--<?php echo esc_attr( $b->status ); ?>"><?php echo esc_html( ucfirst( $b->status ) ); ?></span></td>
							<td><?php echo esc_html( ucfirst( $b->payment_status ) ); ?></td>
							<td class="ssb-actions">
								<select class="ssb-select ssb-status-select" data-id="<?php echo esc_attr( (string) $b->id ); ?>">
									<?php foreach ( $statuses as $s ) : ?>
										<?php if ( '' === $s ) { continue; } ?>
										<option value="<?php echo esc_attr( $s ); ?>" <?php selected( $b->status, $s ); ?>><?php echo esc_html( ucfirst( $s ) ); ?></option>
									<?php endforeach; ?>
								</select>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</section>
</div>
