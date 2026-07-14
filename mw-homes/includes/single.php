<?php
/**
 * Default single-page layout.
 *
 * Replaces the_content on singular home_plan posts with the full reference
 * layout (3D Tour + Details, Floor Plan + Specs, Tours, Gallery, Disclaimer).
 * Disable under Floor Plans → Settings when using an Elementor Theme Builder
 * single template with MW Homes widgets.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Single {

	public static function init() {
		add_filter( 'the_content', array( __CLASS__, 'replace' ), 20 );
	}

	private static function enabled() {
		$s = get_option( 'mwh_settings', array() );
		return ! isset( $s['auto_single'] ) || 'off' !== $s['auto_single'];
	}

	public static function replace( $content ) {
		if ( is_admin() || ! is_singular( 'home_plan' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}
		if ( ! self::enabled() ) {
			return $content;
		}
		if ( did_action( 'elementor/theme/before_do_single' ) ) {
			return $content;
		}

		static $done = false;
		if ( $done ) {
			return $content;
		}
		$done = true;

		$id = get_the_ID();
		return mwh_render_single_layout( $id );
	}
}

MWH_Single::init();
