<?php
/**
 * Plugin Name:       MW Homes – Floor Plans Catalog
 * Plugin URI:        https://claudialandis8.aiwebdesignz.com/
 * Description:        Manufactured & modular home floor-plan catalog with featured grid, filterable archive, rich single pages, spec sheets, 3D tours, galleries and a price-quote popup form. Fully editable through Elementor widgets.
 * Version:           1.1.0
 * Author:            AI Web Designz
 * Text Domain:       mw-homes
 * Requires PHP:      7.4
 * License:           GPL-2.0-or-later
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MWH_VERSION', '1.1.0' );
define( 'MWH_FILE', __FILE__ );
define( 'MWH_DIR', plugin_dir_path( __FILE__ ) );
define( 'MWH_URL', plugin_dir_url( __FILE__ ) );
define( 'MWH_BASENAME', plugin_basename( __FILE__ ) );

require_once MWH_DIR . 'includes/helpers.php';
require_once MWH_DIR . 'includes/templates.php';
require_once MWH_DIR . 'includes/cpt.php';
require_once MWH_DIR . 'includes/meta.php';
require_once MWH_DIR . 'includes/settings.php';
require_once MWH_DIR . 'includes/quote.php';
require_once MWH_DIR . 'includes/assets.php';
require_once MWH_DIR . 'includes/single.php';
require_once MWH_DIR . 'includes/seed.php';
require_once MWH_DIR . 'includes/elementor.php';

/**
 * Activation: register content types, flush rewrites, seed demo homes once.
 */
function mwh_activate() {
	MWH_CPT::register();
	flush_rewrite_rules();
	// Seed demo content only on first activation.
	if ( ! get_option( 'mwh_seeded' ) ) {
		MWH_Seed::run();
		update_option( 'mwh_seeded', 1 );
	}
	if ( false === get_option( 'mwh_settings' ) ) {
		update_option( 'mwh_settings', array(
			'notify_email' => get_option( 'admin_email' ),
			'from_name'    => get_bloginfo( 'name' ),
			'offered_by'   => get_bloginfo( 'name' ),
		) );
	}
}
register_activation_hook( __FILE__, 'mwh_activate' );

/**
 * Deactivation: clean rewrite rules.
 */
function mwh_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'mwh_deactivate' );
