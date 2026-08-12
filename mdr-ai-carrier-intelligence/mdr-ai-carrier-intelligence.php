<?php
/**
 * Plugin Name:       MDR AI Carrier Intelligence
 * Plugin URI:        https://mydrayrate.com/
 * Description:       Above-the-fold AI Carrier Intelligence CTA with secure shipment upload and actionable carrier intelligence reports.
 * Version:           1.0.8
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            My Dray Rate
 * Author URI:        https://mydrayrate.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mdr-ai-carrier-intelligence
 *
 * @package MDR_ACI
 */

defined( 'ABSPATH' ) || exit;

define( 'MDR_ACI_VERSION', '1.0.8' );
define( 'MDR_ACI_PLUGIN_FILE', __FILE__ );
define( 'MDR_ACI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MDR_ACI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'MDR_ACI_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

require_once MDR_ACI_PLUGIN_DIR . 'includes/class-autoloader.php';
MDR_ACI\Autoloader::register();

/**
 * Returns the main plugin instance.
 *
 * @return MDR_ACI\Plugin
 */
function mdr_aci() {
	return MDR_ACI\Plugin::instance();
}

register_activation_hook( __FILE__, array( 'MDR_ACI\\Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'MDR_ACI\\Deactivator', 'deactivate' ) );

mdr_aci();
