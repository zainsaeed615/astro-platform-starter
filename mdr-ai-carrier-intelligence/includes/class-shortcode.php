<?php
/**
 * Shortcode registration and rendering.
 *
 * @package MDR_ACI
 */

namespace MDR_ACI;

defined( 'ABSPATH' ) || exit;

/**
 * Class Shortcode
 */
class Shortcode {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_shortcode( 'mdr_ai_carrier_intelligence', array( $this, 'render' ) );
	}

	/**
	 * Render shortcode output.
	 *
	 * @param array<string, string> $atts Shortcode attributes.
	 * @return string
	 */
	public function render( $atts = array() ) {
		Assets::flag_enqueue();

		$settings = Settings::get();
		$atts     = shortcode_atts(
			array(
				'show_cta' => 'yes',
			),
			$atts,
			'mdr_ai_carrier_intelligence'
		);

		ob_start();
		?>
		<div
			class="mdr-aci"
			id="mdr-aci-root"
			style="--mdr-aci-accent: <?php echo esc_attr( $settings['accent_color'] ); ?>; --mdr-aci-cta: <?php echo esc_attr( $settings['cta_color'] ); ?>; --mdr-aci-bg: <?php echo esc_attr( $settings['background_color'] ); ?>;"
			data-mdr-aci-root
		>
			<div class="mdr-aci__grid-bg" aria-hidden="true"></div>

			<div class="mdr-aci__view mdr-aci__view--cta" data-mdr-aci-view="cta">
				<?php include MDR_ACI_PLUGIN_DIR . 'public/partials/section-cta.php'; ?>
			</div>

			<div class="mdr-aci__view mdr-aci__view--report mdr-aci-hidden" data-mdr-aci-view="report" hidden>
				<?php include MDR_ACI_PLUGIN_DIR . 'public/partials/report.php'; ?>
			</div>

			<div class="mdr-aci__loading mdr-aci-hidden" data-mdr-aci-loading hidden>
				<div class="mdr-aci__loading-card">
					<div class="mdr-aci__spinner" aria-hidden="true"></div>
					<p class="mdr-aci__loading-text" data-mdr-aci-loading-text><?php esc_html_e( 'Analyzing your transportation network…', 'mdr-ai-carrier-intelligence' ); ?></p>
					<div class="mdr-aci__progress">
						<div class="mdr-aci__progress-bar" data-mdr-aci-progress-bar></div>
					</div>
					<span class="mdr-aci__progress-percent" data-mdr-aci-progress-percent>0%</span>
				</div>
			</div>

			<?php include MDR_ACI_PLUGIN_DIR . 'public/partials/upload-modal.php'; ?>
			<?php include MDR_ACI_PLUGIN_DIR . 'public/partials/demo-modal.php'; ?>
		</div>
		<?php
		return ob_get_clean();
	}
}
