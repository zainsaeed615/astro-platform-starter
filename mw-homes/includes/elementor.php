<?php
/**
 * Elementor integration: category + widget registration.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Elementor {

	public static function init() {
		add_action( 'elementor/elements/categories_registered', array( __CLASS__, 'category' ) );
		add_action( 'elementor/widgets/register', array( __CLASS__, 'widgets' ) );
	}

	public static function category( $mgr ) {
		$mgr->add_category( 'mw-homes', array(
			'title' => __( 'MW Homes', 'mw-homes' ),
			'icon'  => 'eicon-home-heart',
		) );
	}

	public static function widgets( $mgr ) {
		require_once MWH_DIR . 'includes/widgets/class-widget-base.php';
		$files = array(
			'class-widget-featured-grid.php'  => 'MWH_Widget_Featured_Grid',
			'class-widget-archive.php'        => 'MWH_Widget_Archive',
			'class-widget-single-layout.php'  => 'MWH_Widget_Single_Layout',
			'class-widget-single-header.php'  => 'MWH_Widget_Single_Header',
			'class-widget-single-stats.php'   => 'MWH_Widget_Single_Stats',
			'class-widget-single-desc.php'    => 'MWH_Widget_Single_Desc',
			'class-widget-single-media.php'   => 'MWH_Widget_Single_Media',
			'class-widget-single-gallery.php' => 'MWH_Widget_Single_Gallery',
			'class-widget-single-specs.php'   => 'MWH_Widget_Single_Specs',
			'class-widget-quote-button.php'   => 'MWH_Widget_Quote_Button',
		);
		foreach ( $files as $file => $class ) {
			require_once MWH_DIR . 'includes/widgets/' . $file;
			if ( class_exists( $class ) ) {
				$mgr->register( new $class() );
			}
		}
	}
}

// Wire up if Elementor is present. Elementor fires `elementor/loaded` while
// including its own main file, which (alphabetically) happens before this
// plugin loads — so the action has usually already fired by now. Register
// directly in that case; otherwise wait for the action.
if ( did_action( 'elementor/loaded' ) || class_exists( '\Elementor\Plugin' ) ) {
	MWH_Elementor::init();
} else {
	add_action( 'elementor/loaded', array( 'MWH_Elementor', 'init' ) );
}
