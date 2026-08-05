<?php
/**
 * CTA section partial.
 *
 * @package MDR_ACI
 */

defined( 'ABSPATH' ) || exit;

$settings = MDR_ACI\Settings::get();
?>
<section class="mdr-aci__hero" aria-labelledby="mdr-aci-headline">
	<div class="mdr-aci__hero-glow" aria-hidden="true"></div>
	<div class="mdr-aci__hero-inner">
		<?php if ( ! empty( $settings['logo_url'] ) ) : ?>
			<img class="mdr-aci__logo" src="<?php echo esc_url( $settings['logo_url'] ); ?>" alt="<?php esc_attr_e( 'MDR', 'mdr-ai-carrier-intelligence' ); ?>" />
		<?php else : ?>
			<span class="mdr-aci__badge">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
				<?php esc_html_e( 'MDR Intelligence', 'mdr-ai-carrier-intelligence' ); ?>
			</span>
		<?php endif; ?>

		<p class="mdr-aci__eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></p>
		<h2 class="mdr-aci__headline" id="mdr-aci-headline"><?php echo esc_html( $settings['headline'] ); ?></h2>
		<p class="mdr-aci__description"><?php echo esc_html( $settings['description'] ); ?></p>

		<div class="mdr-aci__cta-row">
			<button type="button" class="mdr-aci__btn mdr-aci__btn--primary" data-mdr-aci-upload-trigger>
				<span class="mdr-aci__btn-icon" aria-hidden="true">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 16V4m0 0l-4 4m4-4l4 4M4 20h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</span>
				<?php echo esc_html( $settings['primary_button_text'] ); ?>
			</button>
			<button type="button" class="mdr-aci__btn mdr-aci__btn--ghost" data-mdr-aci-demo-open>
				<?php echo esc_html( $settings['demo_button_text'] ); ?>
			</button>
		</div>

		<blockquote class="mdr-aci__quote">
			<?php esc_html_e( '"If this free report is this valuable, imagine what the full platform can do."', 'mdr-ai-carrier-intelligence' ); ?>
		</blockquote>
	</div>
</section>
