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
	 * Constructor.
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'register_shortcode' ) );
	}

	/**
	 * Register the calculator shortcode.
	 *
	 * @return void
	 */
	public function register_shortcode() {
		add_shortcode( 'calculator_plugin', array( $this, 'render_shortcode' ) );
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
		$consultation_url = esc_url( $atts['consultation_url'] );
		$contact_url      = esc_url( $atts['contact_url'] );
		$default_tab      = sanitize_key( $atts['default_tab'] );

		$allowed_tabs = array( 'stamp-duty', 'yield', 'mortgage' );
		if ( ! in_array( $default_tab, $allowed_tabs, true ) ) {
			$default_tab = 'stamp-duty';
		}

		ob_start();

		include VCP_PLUGIN_DIR . 'templates/calculators.php';

		return ob_get_clean();
	}
}
