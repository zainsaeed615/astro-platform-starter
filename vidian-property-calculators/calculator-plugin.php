<?php
/**
 * Plugin Name:       Vidian Property Calculators
 * Plugin URI:        https://www.vidiancapital.com/tools/calculators
 * Description:       Property investment calculators (Stamp Duty, Rental Yield, Mortgage). Embed with shortcode [calculator_plugin].
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Vidian Capital
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       vidian-property-calculators
 *
 * @package VidianPropertyCalculators
 */

defined( 'ABSPATH' ) || exit;

define( 'VCP_VERSION', '1.0.0' );
define( 'VCP_PLUGIN_FILE', __FILE__ );
define( 'VCP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'VCP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once VCP_PLUGIN_DIR . 'includes/class-vcp-plugin.php';

/**
 * Initialize the plugin.
 *
 * @return VCP_Plugin
 */
function vcp_init() {
	return VCP_Plugin::instance();
}

add_action( 'plugins_loaded', 'vcp_init' );
