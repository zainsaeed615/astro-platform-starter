<?php
/**
 * Elementor compatibility.
 *
 * @package MDR_ACI
 */

namespace MDR_ACI;

defined( 'ABSPATH' ) || exit;

/**
 * Class Elementor_Integration
 */
class Elementor_Integration {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'elementor/preview/enqueue_scripts', array( $this, 'enqueue_preview_assets' ) );
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'enqueue_preview_assets' ) );
	}

	/**
	 * Ensure assets load in Elementor editor/preview.
	 */
	public function enqueue_preview_assets() {
		Assets::flag_enqueue();
	}
}
