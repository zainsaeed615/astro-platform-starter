<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class VP_Widget_Card extends Widget_Base {

	public function get_name() { return 'vp_property_card'; }
	public function get_title() { return 'Single Property Card'; }
	public function get_icon() { return 'eicon-post-navigation'; }
	public function get_categories() { return array( 'vidian-property' ); }

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => 'Property' ) );

		$properties = get_posts( array( 'post_type' => 'vp_property', 'posts_per_page' => -1 ) );
		$options = array( 'current' => '— Use current property (on single property page) —' );
		foreach ( $properties as $p ) $options[ $p->ID ] = $p->post_title;

		$this->add_control( 'property_id', array(
			'label'   => 'Select Property',
			'type'    => Controls_Manager::SELECT2,
			'options' => $options,
			'default' => 'current',
		) );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$post_id = ( $settings['property_id'] === 'current' ) ? get_the_ID() : intval( $settings['property_id'] );
		if ( ! $post_id ) { echo 'Property select karein.'; return; }
		require_once VP_PLUGIN_DIR . 'includes/class-vp-render.php';
		echo VP_Render::card( $post_id );
	}
}
