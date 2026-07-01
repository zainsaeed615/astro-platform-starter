<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class VP_Elementor {

	public function __construct() {
		add_action( 'elementor/elements/categories_registered', array( $this, 'category' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
	}

	public function category( $elements_manager ) {
		$elements_manager->add_category( 'vidian-property', array(
			'title' => 'Vidian Property',
			'icon'  => 'fa fa-building',
		) );
	}

	public function register_widgets( $widgets_manager ) {
		require_once VP_PLUGIN_DIR . 'widgets/class-vp-widget-card.php';
		require_once VP_PLUGIN_DIR . 'widgets/class-vp-widget-grid.php';
		require_once VP_PLUGIN_DIR . 'widgets/class-vp-widget-details.php';

		$widgets_manager->register( new \VP_Widget_Card() );
		$widgets_manager->register( new \VP_Widget_Grid() );
		$widgets_manager->register( new \VP_Widget_Details() );
	}
}
