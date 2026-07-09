<?php
/**
 * Main plugin class.
 *
 * @package VidianPropertyCalculators
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class VCP_Plugin
 */
class VCP_Plugin {

	/**
	 * Singleton instance.
	 *
	 * @var VCP_Plugin|null
	 */
	private static $instance = null;

	/**
	 * Whether assets have been enqueued for this request.
	 *
	 * @var bool
	 */
	private $assets_enqueued = false;

	/**
	 * Get singleton instance.
	 *
	 * @return VCP_Plugin
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Whether the shortcode was rendered on this request.
	 *
	 * @var bool
	 */
	private $shortcode_rendered = false;

	/**
	 * Constructor.
	 */
	private function __construct() {
		add_action( 'wp_footer', array( $this, 'ensure_footer_assets' ), 1 );
	}

	/**
	 * Ensure CSS/JS load even when shortcode renders after wp_enqueue_scripts.
	 *
	 * @return void
	 */
	public function ensure_footer_assets() {
		if ( ! $this->shortcode_rendered ) {
			return;
		}

		if ( wp_style_is( 'vcp-calculator', 'done' ) ) {
			return;
		}

		if ( ! wp_style_is( 'vcp-calculator', 'enqueued' ) ) {
			$this->enqueue_assets();
		}

		wp_print_styles( array( 'vcp-google-fonts', 'vcp-calculator' ) );
		wp_print_scripts( array( 'vcp-calculator' ) );
	}

	/**
	 * Enqueue plugin styles and scripts.
	 *
	 * @return void
	 */
	public function enqueue_assets() {
		if ( $this->assets_enqueued ) {
			return;
		}

		wp_enqueue_style(
			'vcp-google-fonts',
			'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;600;700&display=swap',
			array(),
			null
		);

		wp_enqueue_style(
			'vcp-calculator',
			VCP_PLUGIN_URL . 'assets/css/calculator.css',
			array( 'vcp-google-fonts' ),
			VCP_VERSION
		);

		wp_enqueue_script(
			'vcp-calculator',
			VCP_PLUGIN_URL . 'assets/js/calculator.js',
			array(),
			VCP_VERSION,
			true
		);

		$this->assets_enqueued = true;
	}

	/**
	 * Render the calculator shortcode output.
	 *
	 * @param array|string $atts Shortcode attributes.
	 * @return string
	 */
	public function render_shortcode( $atts ) {
		$this->shortcode_rendered = true;

		$atts = shortcode_atts(
			array(
				'show_hero'          => 'true',
				'show_cta'           => 'true',
				'consultation_url'   => '/consultation',
				'contact_url'        => '/contact',
				'default_tab'        => 'stamp-duty',
			),
			$atts,
			'calculator_plugin'
		);

		$this->enqueue_assets();

		$show_hero        = filter_var( $atts['show_hero'], FILTER_VALIDATE_BOOLEAN );
		$show_cta         = filter_var( $atts['show_cta'], FILTER_VALIDATE_BOOLEAN );
		$consultation_url = $this->sanitize_link( $atts['consultation_url'] );
		$contact_url      = $this->sanitize_link( $atts['contact_url'] );
		$default_tab      = sanitize_key( $atts['default_tab'] );

		$allowed_tabs = array( 'stamp-duty', 'yield', 'mortgage' );
		if ( ! in_array( $default_tab, $allowed_tabs, true ) ) {
			$default_tab = 'stamp-duty';
		}

		ob_start();

		include VCP_PLUGIN_DIR . 'templates/calculators.php';

		return ob_get_clean();
	}

	/**
	 * Sanitize internal or external URLs.
	 *
	 * @param string $url Raw URL.
	 * @return string
	 */
	private function sanitize_link( $url ) {
		$url = trim( (string) $url );

		if ( '' === $url ) {
			return '#';
		}

		if ( 0 === strpos( $url, '/' ) ) {
			return esc_url( home_url( $url ) );
		}

		return esc_url( $url );
	}
}
