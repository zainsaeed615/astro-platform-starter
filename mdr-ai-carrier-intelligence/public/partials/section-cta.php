<?php
/**
 * CTA section partial — single upload button only.
 *
 * @package MDR_ACI
 */

defined( 'ABSPATH' ) || exit;

$settings = MDR_ACI\Settings::get();
$show_sub = ! empty( $settings['show_button_subtitle'] ) && ! empty( $settings['primary_button_subtitle'] );
?>
<section class="mdr-aci__hero" aria-labelledby="mdr-aci-headline">
	<div class="mdr-aci__hero-glow" aria-hidden="true"></div>
	<div class="mdr-aci__hero-inner">
		<?php if ( ! empty( $settings['logo_url'] ) ) : ?>
			<img class="mdr-aci__logo" src="<?php echo esc_url( $settings['logo_url'] ); ?>" alt="<?php esc_attr_e( 'MDR', 'mdr-ai-carrier-intelligence' ); ?>" />
		<?php endif; ?>

		<p class="mdr-aci__eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></p>
		<h2 class="mdr-aci__headline" id="mdr-aci-headline"><?php echo esc_html( $settings['headline'] ); ?></h2>
		<p class="mdr-aci__description"><?php echo esc_html( $settings['description'] ); ?></p>

		<div class="mdr-aci__cta-row mdr-aci__cta-row--single">
			<button type="button" class="mdr-aci__btn mdr-aci__btn--upload" data-mdr-aci-upload-trigger>
				<span class="mdr-aci__btn-icon" aria-hidden="true">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M7 18a4 4 0 010-8 5.5 5.5 0 0111 0 4 4 0 010 8H7z" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 12V4m0 0l-3 3m3-3l3 3" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</span>
				<span class="mdr-aci__btn-text<?php echo $show_sub ? '' : ' mdr-aci__btn-text--single'; ?>">
					<span class="mdr-aci__btn-title"><?php echo esc_html( $settings['primary_button_text'] ); ?></span>
					<?php if ( $show_sub ) : ?>
						<span class="mdr-aci__btn-subtitle"><?php echo esc_html( $settings['primary_button_subtitle'] ); ?></span>
					<?php endif; ?>
				</span>
			</button>
		</div>

		<p class="mdr-aci__error mdr-aci-hidden" data-mdr-aci-error hidden role="alert"></p>
	</div>
</section>
