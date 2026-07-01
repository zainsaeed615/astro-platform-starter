<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class VP_Templates {

	public function __construct() {
		add_filter( 'the_content', array( $this, 'auto_content' ) );
		add_filter( 'template_include', array( $this, 'template_include' ), 99 );
		add_shortcode( 'vp_property_grid', array( $this, 'shortcode_grid' ) );
		add_shortcode( 'vp_property_details', array( $this, 'shortcode_details' ) );
		add_shortcode( 'vp_property_card', array( $this, 'shortcode_card' ) );
	}

	/**
	 * Automatically render plugin content when the active theme still calls
	 * the_content(). This is kept as a fallback; the template_include filter
	 * below is the primary fix for Elementor/theme title-only single pages.
	 */
	public function auto_content( $content ) {
		if ( is_singular( 'vp_property' ) && in_the_loop() && is_main_query() ) {
			require_once VP_PLUGIN_DIR . 'includes/class-vp-render.php';
			if ( strpos( $content, 'vp-details' ) === false && ! has_shortcode( $content, 'vp_property_details' ) ) {
				$content .= VP_Render::details( get_the_ID() );
			}
		}

		if ( is_post_type_archive( 'vp_property' ) && in_the_loop() && is_main_query() ) {
			require_once VP_PLUGIN_DIR . 'includes/class-vp-render.php';
			static $printed_grid = false;
			if ( ! $printed_grid ) {
				$printed_grid = true;
				$content = VP_Render::grid( array( 'posts_per_page' => -1 ) );
			} else {
				$content = '';
			}
		}

		return $content;
	}

	public function template_include( $template ) {
		if ( is_singular( 'vp_property' ) ) {
			$plugin_template = VP_PLUGIN_DIR . 'templates/single-vp-property.php';
			if ( file_exists( $plugin_template ) ) {
				return $plugin_template;
			}
		}

		if ( is_post_type_archive( 'vp_property' ) ) {
			$plugin_template = VP_PLUGIN_DIR . 'templates/archive-vp-property.php';
			if ( file_exists( $plugin_template ) ) {
				return $plugin_template;
			}
		}

		return $template;
	}

	public function shortcode_grid( $atts ) {
		require_once VP_PLUGIN_DIR . 'includes/class-vp-render.php';
		$atts = shortcode_atts( array(
			'posts_per_page' => 6,
			'columns'        => 3,
			'category'       => '',
			'orderby'        => 'date',
			'order'          => 'DESC',
		), $atts, 'vp_property_grid' );

		return VP_Render::grid( $atts );
	}

	public function shortcode_details( $atts ) {
		require_once VP_PLUGIN_DIR . 'includes/class-vp-render.php';
		$atts = shortcode_atts( array( 'id' => 0 ), $atts, 'vp_property_details' );
		$post_id = absint( $atts['id'] );
		if ( ! $post_id && is_singular( 'vp_property' ) ) {
			$post_id = get_the_ID();
		}

		if ( ! $post_id || get_post_type( $post_id ) !== 'vp_property' ) {
			return '<p>Please select a valid property.</p>';
		}

		return VP_Render::details( $post_id );
	}

	public function shortcode_card( $atts ) {
		require_once VP_PLUGIN_DIR . 'includes/class-vp-render.php';
		$atts = shortcode_atts( array( 'id' => 0 ), $atts, 'vp_property_card' );
		$post_id = absint( $atts['id'] );
		if ( ! $post_id && is_singular( 'vp_property' ) ) {
			$post_id = get_the_ID();
		}

		if ( ! $post_id || get_post_type( $post_id ) !== 'vp_property' ) {
			return '<p>Please select a valid property.</p>';
		}

		return VP_Render::card( $post_id );
	}
}
