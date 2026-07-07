<?php
/**
 * Admin availability template.
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

use SacredSpaces\Booking\Repositories\AvailabilityRepository;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$repo  = new AvailabilityRepository();
$days  = $repo->get_all_days();
$slots = $repo->get_all_slots();
$blocked = $repo->get_all_blocked();

$day_names = array( 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' );
?>
<div class="ssb-admin-wrap">
	<header class="ssb-admin-header">
		<h1><?php esc_html_e( 'Availability', 'sacred-spaces-booking' ); ?></h1>
		<p class="ssb-admin-subtitle"><?php esc_html_e( 'Configure booking days, time slots, and blocked dates', 'sacred-spaces-booking' ); ?></p>
	</header>

	<section class="ssb-card">
		<h2><?php esc_html_e( 'Available Days', 'sacred-spaces-booking' ); ?></h2>
		<form id="ssb-availability-days" class="ssb-availability-days">
			<div class="ssb-day-checkboxes">
				<?php foreach ( $days as $day ) : ?>
					<label class="ssb-day-check">
						<input type="checkbox" name="days[]" value="<?php echo esc_attr( (string) $day->day_of_week ); ?>" <?php checked( (int) $day->is_available, 1 ); ?>>
						<?php echo esc_html( $day_names[ (int) $day->day_of_week ] ?? '' ); ?>
					</label>
				<?php endforeach; ?>
			</div>
			<button type="submit" class="ssb-btn"><?php esc_html_e( 'Save Days', 'sacred-spaces-booking' ); ?></button>
		</form>
	</section>

	<section class="ssb-card">
		<h2><?php esc_html_e( 'Time Slots', 'sacred-spaces-booking' ); ?></h2>
		<form id="ssb-time-slots-form">
			<table class="ssb-table" id="ssb-slots-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Time', 'sacred-spaces-booking' ); ?></th>
						<th><?php esc_html_e( 'Label', 'sacred-spaces-booking' ); ?></th>
						<th><?php esc_html_e( 'Active', 'sacred-spaces-booking' ); ?></th>
						<th><?php esc_html_e( 'Order', 'sacred-spaces-booking' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $slots as $i => $slot ) : ?>
						<tr data-slot-id="<?php echo esc_attr( (string) $slot->id ); ?>">
							<td><input type="time" class="ssb-input slot-time" value="<?php echo esc_attr( substr( $slot->slot_time, 0, 5 ) ); ?>"></td>
							<td><input type="text" class="ssb-input slot-label" value="<?php echo esc_attr( $slot->label ); ?>"></td>
							<td><input type="checkbox" class="slot-active" <?php checked( (int) $slot->is_active, 1 ); ?>></td>
							<td><input type="number" class="ssb-input slot-sort" value="<?php echo esc_attr( (string) $slot->sort_order ); ?>" style="width:60px"></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<button type="submit" class="ssb-btn"><?php esc_html_e( 'Save Time Slots', 'sacred-spaces-booking' ); ?></button>
		</form>
	</section>

	<section class="ssb-card">
		<h2><?php esc_html_e( 'Blocked Dates', 'sacred-spaces-booking' ); ?></h2>
		<form id="ssb-block-date-form" class="ssb-inline-form">
			<input type="date" name="date" class="ssb-input" required>
			<input type="text" name="reason" class="ssb-input" placeholder="<?php esc_attr_e( 'Reason (optional)', 'sacred-spaces-booking' ); ?>">
			<button type="submit" class="ssb-btn"><?php esc_html_e( 'Block Date', 'sacred-spaces-booking' ); ?></button>
		</form>
		<?php if ( ! empty( $blocked ) ) : ?>
			<ul class="ssb-list ssb-blocked-list">
				<?php foreach ( $blocked as $b ) : ?>
					<li>
						<strong><?php echo esc_html( gmdate( 'M j, Y', strtotime( $b->blocked_date ) ) ); ?></strong>
						<?php if ( $b->reason ) : ?>
							<span><?php echo esc_html( $b->reason ); ?></span>
						<?php endif; ?>
						<button type="button" class="ssb-btn ssb-btn--small ssb-unblock-date" data-date="<?php echo esc_attr( $b->blocked_date ); ?>"><?php esc_html_e( 'Unblock', 'sacred-spaces-booking' ); ?></button>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</section>
</div>
