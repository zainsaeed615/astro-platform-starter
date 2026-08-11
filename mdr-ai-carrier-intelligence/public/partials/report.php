<?php
/**
 * Report partial — rendered inside upload modal step 3.
 *
 * @package MDR_ACI
 */

defined( 'ABSPATH' ) || exit;

$settings = MDR_ACI\Settings::get();
?>
<section class="mdr-aci__report mdr-aci__report--in-modal" data-mdr-aci-report aria-live="polite">
	<header class="mdr-aci__report-header">
		<h2 class="mdr-aci__report-title" data-mdr-aci-report-title><?php esc_html_e( 'Network Analysis Complete', 'mdr-ai-carrier-intelligence' ); ?></h2>
		<p class="mdr-aci__report-meta" data-mdr-aci-report-meta></p>
		<p class="mdr-aci__report-summary mdr-aci-hidden" data-mdr-aci-executive-summary hidden></p>
	</header>

	<div class="mdr-aci__report-grid" data-mdr-aci-report-sections></div>

	<footer class="mdr-aci__report-footer">
		<p class="mdr-aci__disclaimer" data-mdr-aci-disclaimer><?php echo esc_html( $settings['report_disclaimer'] ); ?></p>
		<div class="mdr-aci__cta-row mdr-aci__cta-row--report">
			<a class="mdr-aci__btn mdr-aci__btn--primary" data-mdr-aci-signup href="<?php echo esc_url( $settings['signup_url'] ); ?>" target="_blank" rel="noopener noreferrer">
				<?php echo esc_html( $settings['signup_button_text'] ); ?>
			</a>
			<button type="button" class="mdr-aci__btn mdr-aci__btn--ghost" data-mdr-aci-demo-open>
				<?php echo esc_html( $settings['demo_button_text'] ); ?>
			</button>
		</div>
		<button type="button" class="mdr-aci__link-btn" data-mdr-aci-reset><?php esc_html_e( 'Analyze another file', 'mdr-ai-carrier-intelligence' ); ?></button>
	</footer>
</section>
