<?php
/**
 * Booking wizard template.
 *
 * @package SacredSpaces\Booking
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="ssb-booking" id="ssb-booking-app" role="application" aria-label="<?php esc_attr_e( 'Sacred Spaces Booking', 'sacred-spaces-booking' ); ?>">
	<section class="ssb-hero">
		<h1 class="ssb-hero__title"><?php esc_html_e( 'Begin Your Sanctuary Session', 'sacred-spaces-booking' ); ?></h1>
		<p class="ssb-hero__subtitle"><?php esc_html_e( 'Your transformation begins with a single intentional step. Choose the experience that best supports your home and your next chapter.', 'sacred-spaces-booking' ); ?></p>
	</section>

	<div class="ssb-progress" aria-hidden="true">
		<div class="ssb-progress__track">
			<div class="ssb-progress__fill" id="ssb-progress-fill"></div>
		</div>
		<ol class="ssb-progress__steps" id="ssb-progress-steps"></ol>
	</div>

	<div class="ssb-wizard">
		<div class="ssb-wizard__panels" id="ssb-wizard-panels">
			<!-- Panels rendered by JavaScript -->
		</div>

		<nav class="ssb-wizard__nav" aria-label="<?php esc_attr_e( 'Booking navigation', 'sacred-spaces-booking' ); ?>">
			<button type="button" class="ssb-btn ssb-btn--ghost" id="ssb-btn-back" hidden>
				<?php esc_html_e( 'Back', 'sacred-spaces-booking' ); ?>
			</button>
			<button type="button" class="ssb-btn ssb-btn--primary" id="ssb-btn-next">
				<?php esc_html_e( 'Continue', 'sacred-spaces-booking' ); ?>
			</button>
		</nav>
	</div>

	<div class="ssb-loading" id="ssb-loading" hidden>
		<div class="ssb-loading__spinner" aria-hidden="true"></div>
		<span><?php esc_html_e( 'Loading...', 'sacred-spaces-booking' ); ?></span>
	</div>
</div>
