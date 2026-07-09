<?php
/**
 * Plugin Name:       Vidian Property Calculators
 * Plugin URI:        https://www.vidiancapital.com/tools/calculators
 * Description:       Property investment calculators (Stamp Duty, Rental Yield, Mortgage). Embed with shortcode [calculator_plugin].
 * Version:           1.0.2
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

define( 'VCP_VERSION', '1.0.2' );
define( 'VCP_PLUGIN_FILE', __FILE__ );
define( 'VCP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'VCP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once VCP_PLUGIN_DIR . 'includes/class-vcp-plugin.php';
require_once VCP_PLUGIN_DIR . 'includes/class-vcp-elementor.php';

/**
 * Register shortcode as early as possible.
 *
 * @return void
 */
function vcp_register_shortcode() {
	add_shortcode( 'calculator_plugin', 'vcp_render_calculator_shortcode' );
	add_shortcode( 'vidian_calculator', 'vcp_render_calculator_shortcode' );
}
add_action( 'init', 'vcp_register_shortcode', 5 );

/**
 * Shortcode callback wrapper.
 *
 * @param array|string $atts Shortcode attributes.
 * @return string
 */
function vcp_render_calculator_shortcode( $atts = array() ) {
	return VCP_Plugin::instance()->render_shortcode( $atts );
}

/**
 * Initialize plugin services.
 *
 * @return VCP_Plugin
 */
function vcp_init() {
	VCP_Elementor::init();
	return VCP_Plugin::instance();
}
add_action( 'plugins_loaded', 'vcp_init' );

/**
 * Enqueue assets when shortcode is present in post content.
 *
 * @return void
 */
function vcp_maybe_enqueue_assets() {
	if ( is_admin() ) {
		return;
	}

	global $post;

	if ( ! is_a( $post, 'WP_Post' ) ) {
		return;
	}

	if (
		has_shortcode( $post->post_content, 'calculator_plugin' ) ||
		has_shortcode( $post->post_content, 'vidian_calculator' )
	) {
		VCP_Plugin::instance()->enqueue_assets();
	}
}
add_action( 'wp_enqueue_scripts', 'vcp_maybe_enqueue_assets', 20 );

/**
 * Show usage hint in plugins list.
 *
 * @param array $links Plugin action links.
 * @return array
 */
function vcp_plugin_action_links( $links ) {
	$links[] = '<strong>' . esc_html__( 'Shortcode:', 'vidian-property-calculators' ) . '</strong> <code>[calculator_plugin]</code>';
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'vcp_plugin_action_links' );

/**
 * Admin notice with setup instructions.
 *
 * @return void
 */
function vcp_admin_notice() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	if ( get_user_meta( get_current_user_id(), 'vcp_dismiss_notice', true ) ) {
		return;
	}

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'plugins' !== $screen->id ) {
		return;
	}
	?>
	<div class="notice notice-success is-dismissible" data-vcp-notice="1">
		<p>
			<strong><?php esc_html_e( 'Vidian Property Calculators is active.', 'vidian-property-calculators' ); ?></strong>
			<?php esc_html_e( 'Use shortcode', 'vidian-property-calculators' ); ?>
			<code>[calculator_plugin]</code>
			<?php esc_html_e( 'inside Elementor → Shortcode widget (not Text Editor).', 'vidian-property-calculators' ); ?>
		</p>
	</div>
	<script>
		(function () {
			document.addEventListener('click', function (event) {
				var notice = event.target.closest('.notice[data-vcp-notice="1"] .notice-dismiss');
				if (!notice) {
					return;
				}
				var formData = new FormData();
				formData.append('action', 'vcp_dismiss_notice');
				formData.append('nonce', '<?php echo esc_js( wp_create_nonce( 'vcp_dismiss_notice' ) ); ?>');
				fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
					method: 'POST',
					credentials: 'same-origin',
					body: formData
				});
			});
		})();
	</script>
	<?php
}
add_action( 'admin_notices', 'vcp_admin_notice' );

/**
 * Dismiss admin notice.
 *
 * @return void
 */
function vcp_dismiss_notice_ajax() {
	check_ajax_referer( 'vcp_dismiss_notice', 'nonce' );
	update_user_meta( get_current_user_id(), 'vcp_dismiss_notice', 1 );
	wp_send_json_success();
}
add_action( 'wp_ajax_vcp_dismiss_notice', 'vcp_dismiss_notice_ajax' );
