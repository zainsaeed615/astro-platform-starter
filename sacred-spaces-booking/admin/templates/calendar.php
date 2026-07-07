<?php
/**
 * Admin calendar template.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

use SacredSpaces\Booking\Repositories\BookingRepository;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$month = absint( $_GET['month'] ?? (int) gmdate( 'n' ) );
$year  = absint( $_GET['year'] ?? (int) gmdate( 'Y' ) );

$bookings = ( new BookingRepository() )->list(
	array(
		'date_from' => sprintf( '%04d-%02d-01', $year, $month ),
		'date_to'   => gmdate( 'Y-m-t', strtotime( "{$year}-{$month}-01" ) ),
		'limit'     => 500,
	)
);

$by_date = array();
foreach ( $bookings as $b ) {
	$by_date[ $b->booking_date ][] = $b;
}

$first_day    = (int) gmdate( 'w', strtotime( "{$year}-{$month}-01" ) );
$days_in_month = (int) gmdate( 't', strtotime( "{$year}-{$month}-01" ) );
$prev_month   = $month <= 1 ? 12 : $month - 1;
$prev_year    = $month <= 1 ? $year - 1 : $year;
$next_month   = $month >= 12 ? 1 : $month + 1;
$next_year    = $month >= 12 ? $year + 1 : $year;
?>
<div class="ssb-admin-wrap">
	<header class="ssb-admin-header ssb-admin-header--row">
		<div>
			<h1><?php esc_html_e( 'Calendar', 'sacred-spaces-booking' ); ?></h1>
			<p class="ssb-admin-subtitle"><?php echo esc_html( gmdate( 'F Y', strtotime( "{$year}-{$month}-01" ) ) ); ?></p>
		</div>
		<div class="ssb-calendar-nav">
			<a href="<?php echo esc_url( admin_url( "admin.php?page=sacred-spaces-calendar&month={$prev_month}&year={$prev_year}" ) ); ?>" class="ssb-btn ssb-btn--outline">&larr;</a>
			<a href="<?php echo esc_url( admin_url( "admin.php?page=sacred-spaces-calendar&month={$next_month}&year={$next_year}" ) ); ?>" class="ssb-btn ssb-btn--outline">&rarr;</a>
		</div>
	</header>

	<section class="ssb-card">
		<div class="ssb-admin-calendar">
			<div class="ssb-admin-calendar__head">
				<?php
				$days = array( 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' );
				foreach ( $days as $d ) :
					?>
					<span><?php echo esc_html( $d ); ?></span>
				<?php endforeach; ?>
			</div>
			<div class="ssb-admin-calendar__grid">
				<?php for ( $i = 0; $i < $first_day; $i++ ) : ?>
					<div class="ssb-admin-calendar__day ssb-admin-calendar__day--empty"></div>
				<?php endfor; ?>
				<?php for ( $d = 1; $d <= $days_in_month; $d++ ) : ?>
					<?php
					$date_str = sprintf( '%04d-%02d-%02d', $year, $month, $d );
					$day_bookings = $by_date[ $date_str ] ?? array();
					?>
					<div class="ssb-admin-calendar__day <?php echo ! empty( $day_bookings ) ? 'ssb-admin-calendar__day--has' : ''; ?>">
						<span class="ssb-admin-calendar__num"><?php echo esc_html( (string) $d ); ?></span>
						<?php foreach ( array_slice( $day_bookings, 0, 3 ) as $b ) : ?>
							<div class="ssb-admin-calendar__event" title="<?php echo esc_attr( $b->first_name . ' — ' . $b->service_name ); ?>">
								<?php echo esc_html( gmdate( 'g:i', strtotime( $b->booking_time ) ) . ' ' . $b->first_name ); ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</section>
</div>
