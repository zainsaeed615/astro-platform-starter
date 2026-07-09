<?php
/**
 * Elementor compatibility helpers.
 *
 * @package VidianPropertyCalculators
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class VCP_Elementor
 */
class VCP_Elementor {

	/**
	 * Boot Elementor hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_filter( 'elementor/widget/render_content', array( __CLASS__, 'render_shortcodes_in_widgets' ), 10, 2 );
		add_action( 'elementor/frontend/after_enqueue_scripts', array( __CLASS__, 'maybe_enqueue_for_elementor' ), 5 );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'maybe_enqueue_for_elementor' ), 25 );
	}

	/**
	 * Process shortcodes inside Elementor widget output.
	 *
	 * @param string           $content Widget HTML.
	 * @param \Elementor\Widget_Base $widget  Widget instance.
	 * @return string
	 */
	public static function render_shortcodes_in_widgets( $content, $widget ) {
		if ( empty( $content ) || false === strpos( $content, '[' ) ) {
			return $content;
		}

		if (
			false !== strpos( $content, '[calculator_plugin' ) ||
			false !== strpos( $content, '[vidian_calculator' ) ||
			false !== strpos( $content, '[vidian_calculators' )
		) {
			$content = do_shortcode( $content );
		}

		return $content;
	}

	/**
	 * Enqueue assets when Elementor page contains the calculator shortcode.
	 *
	 * @return void
	 */
	public static function maybe_enqueue_for_elementor() {
		if ( is_admin() || ! class_exists( '\Elementor\Plugin' ) ) {
			return;
		}

		$post_id = get_the_ID();
		if ( ! $post_id ) {
			return;
		}

		$elementor_data = get_post_meta( $post_id, '_elementor_data', true );
		if ( empty( $elementor_data ) ) {
			return;
		}

		if (
			false !== strpos( $elementor_data, 'calculator_plugin' ) ||
			false !== strpos( $elementor_data, 'vidian_calculator' ) ||
			false !== strpos( $elementor_data, 'vidian_calculators' )
		) {
			VCP_Plugin::instance()->enqueue_assets();
		}
	}
}
