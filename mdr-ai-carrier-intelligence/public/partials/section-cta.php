<?php
/**
 * CTA section partial — single upload button only.
 *
 * @package MDR_ACI
 */

defined( 'ABSPATH' ) || exit;

$settings = MDR_ACI\Settings::get();
$subtitle = ! empty( $settings['primary_button_subtitle'] )
	? $settings['primary_button_subtitle']
	: __( 'Get Your Free AI Report', 'mdr-ai-carrier-intelligence' );
?>
<section class="mdr-aci__hero" aria-labelledby="mdr-aci-headline">
	<div class="mdr-aci__hero-glow" aria-hidden="true"></div>
	<div class="mdr-aci__hero-inner">
		<?php if ( ! empty( $settings['logo_url'] ) ) : ?>
			<img class="mdr-aci__logo" src="<?php echo esc_url( $settings['logo_url'] ); ?>" alt="<?php esc_attr_e( 'MDR', 'mdr-ai-carrier-intelligence' ); ?>" />
		<?php else : ?>
			<span class="mdr-aci__badge mdr-aci__badge--new">
				<?php esc_html_e( 'New! Get your FREE AI Report in minutes.', 'mdr-ai-carrier-intelligence' ); ?>
			</span>
		<?php endif; ?>

		<p class="mdr-aci__eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></p>
		<h2 class="mdr-aci__headline" id="mdr-aci-headline"><?php echo esc_html( $settings['headline'] ); ?></h2>
		<p class="mdr-aci__description"><?php echo esc_html( $settings['description'] ); ?></p>

		<div class="mdr-aci__cta-row mdr-aci__cta-row--single">
			<button type="button" class="mdr-aci__btn mdr-aci__btn--upload" data-mdr-aci-upload-trigger>
				<span class="mdr-aci__btn-icon" aria-hidden="true">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M12 16V4m0 0l-4 4m4-4l4 4M4 20h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</span>
				<span class="mdr-aci__btn-text">
					<span class="mdr-aci__btn-title"><?php echo esc_html( $settings['primary_button_text'] ); ?></span>
					<span class="mdr-aci__btn-subtitle"><?php echo esc_html( $subtitle ); ?></span>
				</span>
			</button>
		</div>

		<p class="mdr-aci__error mdr-aci-hidden" data-mdr-aci-error hidden role="alert"></p>
	</div>
</section>
