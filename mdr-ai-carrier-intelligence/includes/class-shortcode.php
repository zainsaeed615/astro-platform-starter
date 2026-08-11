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

		$atts = shortcode_atts(
			array(
				'show_cta' => 'yes',
			),
			$atts,
			'mdr_ai_carrier_intelligence'
		);

		ob_start();
		?>
		<div
			class="mdr-aci mdr-aci--minimal"
			id="mdr-aci-root"
			style="<?php echo esc_attr( Settings::css_vars_style() ); ?>"
			data-mdr-aci-root
		>
			<div class="mdr-aci__view mdr-aci__view--cta" data-mdr-aci-view="cta">
				<?php include MDR_ACI_PLUGIN_DIR . 'public/partials/section-cta.php'; ?>
			</div>

			<?php include MDR_ACI_PLUGIN_DIR . 'public/partials/upload-modal.php'; ?>
			<?php include MDR_ACI_PLUGIN_DIR . 'public/partials/demo-modal.php'; ?>
		</div>
		<?php
		return ob_get_clean();
	}
}
