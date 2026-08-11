<?php
/**
 * Asset registration and enqueue.
 *
 * @package MDR_ACI
 */

namespace MDR_ACI;

defined( 'ABSPATH' ) || exit;

/**
 * Class Assets
 */
class Assets {

	/**
	 * Whether shortcode is present on page.
	 *
	 * @var bool
	 */
	private static $enqueue = false;

	/**
	 * Whether assets were already enqueued.
	 *
	 * @var bool
	 */
	private static $done = false;

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 5 );
		add_action( 'wp_enqueue_scripts', array( $this, 'maybe_enqueue' ), 999 );
		add_action( 'wp_footer', array( $this, 'maybe_enqueue' ), 1 );
	}

	/**
	 * Flag assets for enqueue (called from shortcode).
	 */
	public static function flag_enqueue() {
		self::$enqueue = true;
		self::maybe_enqueue_static();
	}

	/**
	 * Static enqueue helper for shortcode context.
	 */
	public static function maybe_enqueue_static() {
		if ( ! self::$enqueue || self::$done ) {
			return;
		}

		self::$done = true;

		wp_enqueue_style( 'mdr-aci' );
		wp_enqueue_script( 'mdr-aci' );

		$settings = Settings::get();

		wp_localize_script(
			'mdr-aci',
			'mdrAci',
			array(
				'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'mdr_aci_upload' ),
				'maxBytes' => Settings::max_upload_bytes(),
				'allowed'  => Settings::allowed_extensions(),
				'i18n'     => array(
					'uploading'    => __( 'Uploading shipment data…', 'mdr-ai-carrier-intelligence' ),
					'analyzing'    => __( 'Analyzing your transportation network…', 'mdr-ai-carrier-intelligence' ),
					'generating'   => __( 'Generating AI carrier intelligence report…', 'mdr-ai-carrier-intelligence' ),
					'invalidType'  => __( 'Please upload a CSV, XLS, or XLSX file.', 'mdr-ai-carrier-intelligence' ),
					'invalidSize'  => __( 'File exceeds the maximum upload size.', 'mdr-ai-carrier-intelligence' ),
					'genericError' => __( 'Something went wrong. Please try again.', 'mdr-ai-carrier-intelligence' ),
					'sessionError' => __( 'Your session expired. Please refresh the page and try again.', 'mdr-ai-carrier-intelligence' ),
					'dropHint'     => __( 'Drag & drop your file here, or click to browse', 'mdr-ai-carrier-intelligence' ),
				),
				'colors'   => array(
					'accent'     => sanitize_hex_color( $settings['accent_color'] ) ?: '#3388FF',
					'cta'        => sanitize_hex_color( $settings['cta_color'] ) ?: '#DA1121',
					'background' => sanitize_hex_color( $settings['background_color'] ) ?: '#09090B',
				),
			)
		);
	}

	/**
	 * Register styles and scripts.
	 */
	public function register_assets() {
		wp_register_style(
			'mdr-aci',
			MDR_ACI_PLUGIN_URL . 'public/css/mdr-aci.css',
			array(),
			MDR_ACI_VERSION
		);

		wp_register_script(
			'mdr-aci',
			MDR_ACI_PLUGIN_URL . 'public/js/mdr-aci.js',
			array(),
			MDR_ACI_VERSION,
			true
		);
	}

	/**
	 * Enqueue when shortcode rendered.
	 */
	public function maybe_enqueue() {
		self::maybe_enqueue_static();
	}
}
