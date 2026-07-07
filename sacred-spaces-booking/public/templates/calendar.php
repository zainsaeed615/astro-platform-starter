<?php
/**
 * Standalone calendar template.
 *
 * @package SacredSpaces\Booking
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="ssb-calendar-widget" id="ssb-calendar-widget" data-mode="standalone">
	<div class="ssb-calendar-widget__header">
		<button type="button" class="ssb-cal-nav" id="ssb-cal-prev" aria-label="<?php esc_attr_e( 'Previous month', 'sacred-spaces-booking' ); ?>">&larr;</button>
		<h2 class="ssb-calendar-widget__title" id="ssb-cal-title"></h2>
		<button type="button" class="ssb-cal-nav" id="ssb-cal-next" aria-label="<?php esc_attr_e( 'Next month', 'sacred-spaces-booking' ); ?>">&rarr;</button>
	</div>
	<div class="ssb-calendar-widget__grid" id="ssb-cal-grid" role="grid" aria-label="<?php esc_attr_e( 'Available dates', 'sacred-spaces-booking' ); ?>"></div>
</div>
