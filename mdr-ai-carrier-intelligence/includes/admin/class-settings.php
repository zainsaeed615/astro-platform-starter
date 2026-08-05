<?php
/**
 * Admin settings page.
 *
 * @package MDR_ACI
 */

namespace MDR_ACI\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Class Settings
 */
class Settings {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}

	/**
	 * Add settings submenu.
	 */
	public function add_menu() {
		add_options_page(
			__( 'MDR AI Carrier Intelligence', 'mdr-ai-carrier-intelligence' ),
			__( 'MDR AI Carrier Intelligence', 'mdr-ai-carrier-intelligence' ),
			'manage_options',
			'mdr-aci-settings',
			array( $this, 'render_page' )
		);
	}

	/**
	 * Register settings.
	 */
	public function register_settings() {
		register_setting(
			'mdr_aci_settings_group',
			\MDR_ACI\Settings::OPTION_KEY,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize' ),
				'default'           => \MDR_ACI\Settings::defaults(),
			)
		);
	}

	/**
	 * Sanitize settings input.
	 *
	 * @param array<string, mixed> $input Raw input.
	 * @return array<string, mixed>
	 */
	public function sanitize( $input ) {
		$defaults = \MDR_ACI\Settings::defaults();
		$output   = wp_parse_args( is_array( $input ) ? $input : array(), $defaults );

		$output['eyebrow']             = sanitize_text_field( $output['eyebrow'] );
		$output['headline']            = sanitize_text_field( $output['headline'] );
		$output['description']         = sanitize_textarea_field( $output['description'] );
		$output['primary_button_text'] = sanitize_text_field( $output['primary_button_text'] );
		$output['demo_button_text']    = sanitize_text_field( $output['demo_button_text'] );
		$output['signup_button_text']  = sanitize_text_field( $output['signup_button_text'] );
		$output['signup_url']          = esc_url_raw( $output['signup_url'] );
		$output['logo_url']            = esc_url_raw( $output['logo_url'] );
		$output['accent_color']        = sanitize_hex_color( $output['accent_color'] ) ?: '#3388FF';
		$output['cta_color']           = sanitize_hex_color( $output['cta_color'] ) ?: '#DA1121';
		$output['background_color']    = sanitize_hex_color( $output['background_color'] ) ?: '#09090B';
		$output['max_upload_mb']       = max( 1, min( 50, (int) $output['max_upload_mb'] ) );
		$output['allowed_extensions']  = sanitize_text_field( $output['allowed_extensions'] );
		$output['delete_after_process'] = empty( $output['delete_after_process'] ) ? 0 : 1;
		$output['enable_ai_narrative'] = empty( $output['enable_ai_narrative'] ) ? 0 : 1;
		$output['openai_api_key']      = sanitize_text_field( $output['openai_api_key'] );
		$output['openai_model']        = sanitize_text_field( $output['openai_model'] );
		$output['report_disclaimer']   = sanitize_textarea_field( $output['report_disclaimer'] );
		$output['rate_limit_per_hour'] = max( 1, (int) $output['rate_limit_per_hour'] );
		$output['calendar_embed']      = $this->sanitize_iframe_embed( $output['calendar_embed'] );

		return $output;
	}

	/**
	 * Allow safe iframe embed HTML.
	 *
	 * @param string $html Raw embed HTML.
	 * @return string
	 */
	private function sanitize_iframe_embed( $html ) {
		$allowed = array(
			'iframe' => array(
				'src'             => true,
				'width'           => true,
				'height'          => true,
				'style'           => true,
				'frameborder'     => true,
				'allow'           => true,
				'allowfullscreen' => true,
				'loading'         => true,
				'title'           => true,
			),
		);
		return wp_kses( (string) $html, $allowed );
	}

	/**
	 * Enqueue admin styles.
	 *
	 * @param string $hook Current admin page hook.
	 */
	public function enqueue_admin_assets( $hook ) {
		if ( 'settings_page_mdr-aci-settings' !== $hook ) {
			return;
		}
		wp_enqueue_style(
			'mdr-aci-admin',
			MDR_ACI_PLUGIN_URL . 'admin/css/admin.css',
			array(),
			MDR_ACI_VERSION
		);
	}

	/**
	 * Render settings page.
	 */
	public function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$settings = \MDR_ACI\Settings::get();
		include MDR_ACI_PLUGIN_DIR . 'admin/views/settings-page.php';
	}
}
