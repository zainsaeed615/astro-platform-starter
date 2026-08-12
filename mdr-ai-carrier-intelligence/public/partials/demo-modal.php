<?php
/**
 * Demo scheduling modal partial.
 *
 * @package MDR_ACI
 */

defined( 'ABSPATH' ) || exit;

$settings = MDR_ACI\Settings::get();
?>
<div class="mdr-aci mdr-aci__modal mdr-aci__modal--demo mdr-aci-hidden" data-mdr-aci-modal hidden aria-hidden="true" style="<?php echo esc_attr( MDR_ACI\Settings::css_vars_style() ); ?>">
	<div class="mdr-aci__modal-overlay" data-mdr-aci-modal-overlay></div>
	<div class="mdr-aci__modal-dialog" role="dialog" aria-modal="true" aria-labelledby="mdr-aci-modal-title">
		<div class="mdr-aci__modal-header">
			<h3 id="mdr-aci-modal-title"><?php echo esc_html( $settings['demo_button_text'] ); ?></h3>
			<button type="button" class="mdr-aci__modal-close" data-mdr-aci-modal-close aria-label="<?php esc_attr_e( 'Close', 'mdr-ai-carrier-intelligence' ); ?>">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
			</button>
		</div>
		<div class="mdr-aci__modal-body mdr-aci__modal-body--calendar">
			<?php echo MDR_ACI\Settings::calendar_embed_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized on save via wp_kses. ?>
		</div>
	</div>
</div>
