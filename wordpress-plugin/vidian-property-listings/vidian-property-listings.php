<?php
/**
 * Plugin Name: Vidian Property Listings
 * Description: Custom property listing system with Elementor widgets, cards, grids, full detail pages, galleries, highlights, amenities, maps, and inquiry forms.
 * Version: 1.0.5
 * Author: Vidian Capital
 * Text Domain: vidian-property
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'VP_PLUGIN_FILE', __FILE__ );
define( 'VP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'VP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'VP_VERSION', '1.0.5' );

final class Vidian_Property_Listings {

	private static $instance = null;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', array( $this, 'includes' ), 0 );
		register_activation_hook( VP_PLUGIN_FILE, array( $this, 'activate' ) );
		register_deactivation_hook( VP_PLUGIN_FILE, array( $this, 'deactivate' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_assets' ) );

		add_action( 'plugins_loaded', array( $this, 'load_elementor_integration' ) );

		add_action( 'admin_notices', array( $this, 'maybe_elementor_notice' ) );
		add_action( 'admin_init', array( $this, 'maybe_seed_defaults' ) );
	}

	public function includes() {
		require_once VP_PLUGIN_DIR . 'includes/class-vp-cpt.php';
		require_once VP_PLUGIN_DIR . 'includes/class-vp-metaboxes.php';
		require_once VP_PLUGIN_DIR . 'includes/class-vp-settings.php';
		require_once VP_PLUGIN_DIR . 'includes/class-vp-ajax.php';
		require_once VP_PLUGIN_DIR . 'includes/class-vp-render.php';
		require_once VP_PLUGIN_DIR . 'includes/class-vp-templates.php';
		require_once VP_PLUGIN_DIR . 'includes/class-vp-seeder.php';

		new VP_CPT();
		new VP_Metaboxes();
		new VP_Settings();
		new VP_Ajax();
		new VP_Templates();
	}

	public function load_elementor_integration() {
		if ( did_action( 'elementor/loaded' ) ) {
			require_once VP_PLUGIN_DIR . 'includes/class-vp-elementor.php';
			new VP_Elementor();
		}
	}

	public function maybe_elementor_notice() {
		if ( ! did_action( 'elementor/loaded' ) && current_user_can( 'activate_plugins' ) ) {
			echo '<div class="notice notice-warning"><p><strong>Vidian Property Listings:</strong> Elementor plugin install/activate karein taake Property widgets Elementor editor me show hon. Property add/edit karna Elementor ke baghair bhi kaam karega.</p></div>';
		}
	}

	public function admin_assets( $hook ) {
		global $post_type;
		if ( $post_type !== 'vp_property' ) return;
		wp_enqueue_media();
		wp_enqueue_style( 'vp-admin-css', VP_PLUGIN_URL . 'assets/css/admin.css', array(), VP_VERSION );
		wp_enqueue_script( 'vp-admin-js', VP_PLUGIN_URL . 'assets/js/admin.js', array( 'jquery', 'jquery-ui-sortable' ), VP_VERSION, true );
	}

	public function frontend_assets() {
		wp_enqueue_style( 'vp-frontend-css', VP_PLUGIN_URL . 'assets/css/frontend.css', array(), VP_VERSION );
		wp_enqueue_script( 'vp-frontend-js', VP_PLUGIN_URL . 'assets/js/frontend.js', array( 'jquery' ), VP_VERSION, true );
		wp_localize_script( 'vp-frontend-js', 'VP_Ajax', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'vp_inquiry_nonce' ),
		) );
	}

	public function activate() {
		require_once VP_PLUGIN_DIR . 'includes/class-vp-cpt.php';
		$cpt = new VP_CPT();
		$cpt->register_post_type();
		$cpt->register_taxonomy();
		flush_rewrite_rules();
		require_once VP_PLUGIN_DIR . 'includes/class-vp-seeder.php';
		VP_Seeder::seed_defaults();
	}

	public function deactivate() {
		flush_rewrite_rules();
	}

	public function maybe_seed_defaults() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		if ( get_option( 'vp_default_developments_seeded' ) === VP_VERSION ) {
			return;
		}
		if ( class_exists( 'VP_Seeder' ) ) {
			VP_Seeder::seed_defaults();
		}
	}
}

Vidian_Property_Listings::instance();
