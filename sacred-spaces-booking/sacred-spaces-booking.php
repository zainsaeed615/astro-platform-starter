<?php
/**
 * Plugin Name:       Sacred Spaces Booking
 * Plugin URI:        https://sacredspacesbysharon.com
 * Description:       A luxury booking experience for Sacred Spaces by Sharon — intentional design consultations and private client experiences.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      8.2
 * Author:            Sacred Spaces by Sharon
 * Author URI:        https://sacredspacesbysharon.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sacred-spaces-booking
 * Domain Path:       /languages
 *
 * @package SacredSpaces\Booking
 */

declare(strict_types=1);

namespace SacredSpaces\Booking;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SSB_VERSION', '1.0.0' );
define( 'SSB_PLUGIN_FILE', __FILE__ );
define( 'SSB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SSB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'SSB_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

require_once SSB_PLUGIN_DIR . 'includes/class-autoloader.php';

Autoloader::register();

if ( file_exists( SSB_PLUGIN_DIR . 'vendor/autoload.php' ) ) {
	require_once SSB_PLUGIN_DIR . 'vendor/autoload.php';
}

/**
 * Initialize the plugin.
 */
function ssb_init(): void {
	$plugin = Plugin::instance();
	$plugin->run();
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\ssb_init' );

register_activation_hook( __FILE__, array( Activator::class, 'activate' ) );
register_deactivation_hook( __FILE__, array( Deactivator::class, 'deactivate' ) );
