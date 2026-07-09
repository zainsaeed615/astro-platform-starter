<?php
/**
 * Booking wizard template.
 *
 * @package SacredSpaces\Booking
 *
 * @var array<int, object> $services Active services for server-rendered fallback.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$services = $services ?? array();
?>
<div class="ssb-booking" id="ssb-booking-app" role="application" aria-label="<?php esc_attr_e( 'Sacred Spaces Booking', 'sacred-spaces-booking' ); ?>">
	<section class="ssb-hero">
		<h1 class="ssb-hero__title"><?php esc_html_e( 'Begin Your Sanctuary Session', 'sacred-spaces-booking' ); ?></h1>
		<p class="ssb-hero__subtitle"><?php esc_html_e( 'Your transformation begins with a single intentional step. Choose the experience that best supports your home and your next chapter.', 'sacred-spaces-booking' ); ?></p>
	</section>

	<div class="ssb-progress" aria-hidden="true">
		<div class="ssb-progress__track">
			<div class="ssb-progress__fill" id="ssb-progress-fill" style="width:12.5%"></div>
		</div>
		<ol class="ssb-progress__steps" id="ssb-progress-steps">
			<li class="is-active"><span><?php esc_html_e( 'Service', 'sacred-spaces-booking' ); ?></span></li>
			<li><span><?php esc_html_e( 'Location', 'sacred-spaces-booking' ); ?></span></li>
			<li><span><?php esc_html_e( 'Calendar', 'sacred-spaces-booking' ); ?></span></li>
			<li><span><?php esc_html_e( 'Time', 'sacred-spaces-booking' ); ?></span></li>
			<li><span><?php esc_html_e( 'Details', 'sacred-spaces-booking' ); ?></span></li>
			<li><span><?php esc_html_e( 'Questionnaire', 'sacred-spaces-booking' ); ?></span></li>
			<li><span><?php esc_html_e( 'Review', 'sacred-spaces-booking' ); ?></span></li>
			<li><span><?php esc_html_e( 'Confirm', 'sacred-spaces-booking' ); ?></span></li>
		</ol>
	</div>

	<div class="ssb-wizard">
		<div class="ssb-wizard__panels" id="ssb-wizard-panels">
			<div class="ssb-panel is-active" data-step="0" role="tabpanel">
				<h2 class="ssb-panel__title" tabindex="-1"><?php esc_html_e( 'Choose Service', 'sacred-spaces-booking' ); ?></h2>
				<p class="ssb-panel__subtitle"><?php esc_html_e( 'Investment', 'sacred-spaces-booking' ); ?></p>
				<div class="ssb-service-grid" role="listbox">
					<?php if ( empty( $services ) ) : ?>
						<p class="ssb-panel__subtitle"><?php esc_html_e( 'Loading services...', 'sacred-spaces-booking' ); ?></p>
					<?php else : ?>
						<?php foreach ( $services as $service ) : ?>
							<?php
							$locations = array_map( 'trim', explode( ',', $service->locations ) );
							?>
							<button type="button" class="ssb-service-option"
								data-service-id="<?php echo esc_attr( (string) $service->id ); ?>"
								data-slug="<?php echo esc_attr( $service->slug ); ?>"
								data-locations="<?php echo esc_attr( implode( ',', $locations ) ); ?>"
								aria-pressed="false">
								<span class="ssb-service-option__name"><?php echo esc_html( $service->name ); ?></span>
								<span class="ssb-service-option__investment"><?php echo esc_html( $service->investment_display ); ?></span>
								<span class="ssb-service-option__meta"><?php echo esc_html( (string) $service->duration_minutes ); ?> <?php esc_html_e( 'Minutes', 'sacred-spaces-booking' ); ?></span>
								<p class="ssb-service-option__desc"><?php echo esc_html( $service->description ); ?></p>
							</button>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
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

	<noscript>
		<p class="ssb-panel__subtitle" style="text-align:center;margin-top:24px;">
			<?php esc_html_e( 'JavaScript is required to complete your booking. Please enable JavaScript in your browser.', 'sacred-spaces-booking' ); ?>
		</p>
	</noscript>
</div>
