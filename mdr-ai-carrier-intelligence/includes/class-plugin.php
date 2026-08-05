<?php
/**
 * Main plugin bootstrap.
 *
 * @package MDR_ACI
 */

namespace MDR_ACI;

defined( 'ABSPATH' ) || exit;

/**
 * Class Plugin
 */
class Plugin {

	/**
	 * Singleton instance.
	 *
	 * @var Plugin|null
	 */
	private static $instance = null;

	/**
	 * Get singleton.
	 *
	 * @return Plugin
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
		$this->init_hooks();
	}

	/**
	 * Register hooks.
	 */
	private function init_hooks() {
		add_action( 'init', array( $this, 'load_textdomain' ) );

		new Assets();
		new Shortcode();
		new Ajax_Handler();

		if ( is_admin() ) {
			new Admin\Settings();
		}
	}

	/**
	 * Load translations.
	 */
	public function load_textdomain() {
		load_plugin_textdomain(
			'mdr-ai-carrier-intelligence',
			false,
			dirname( MDR_ACI_PLUGIN_BASENAME ) . '/languages'
		);
	}
}
