<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class VP_Widget_Grid extends Widget_Base {

	public function get_name() { return 'vp_property_grid'; }
	public function get_title() { return 'Properties Grid - Multiple Listings'; }
	public function get_icon() { return 'eicon-posts-grid'; }
	public function get_categories() { return array( 'vidian-property' ); }

	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => 'Listing Settings' ) );

		$this->add_control( 'posts_per_page', array(
			'label'   => 'Number of Properties (-1 = all)',
			'type'    => Controls_Manager::NUMBER,
			'default' => -1,
		) );

		$this->add_responsive_control( 'columns', array(
			'label'   => 'Columns',
			'type'    => Controls_Manager::SELECT,
			'options' => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ),
			'default' => '3',
			'selectors' => array(
				'{{WRAPPER}} .vp-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
			),
		) );

		$this->add_control( 'display_scope', array(
			'label'   => 'What to show',
			'type'    => Controls_Manager::SELECT,
			'options' => array(
				'all'      => 'All Properties',
				'category' => 'Only Selected Category',
			),
			'default' => 'all',
		) );

		$terms = get_terms( array( 'taxonomy' => 'vp_property_category', 'hide_empty' => false ) );
		$cat_options = array( '' => 'All Categories' );
		if ( ! is_wp_error( $terms ) ) {
			foreach ( $terms as $t ) $cat_options[ $t->slug ] = $t->name;
		}
		$this->add_control( 'category', array(
			'label'   => 'Category / Market',
			'type'    => Controls_Manager::SELECT,
			'options' => $cat_options,
			'default' => '',
			'description' => 'Use with "Only Selected Category". Seeded categories include UK, Dubai, Manchester, Birmingham, Liverpool, Business Bay, etc.',
		) );

		$this->add_control( 'orderby', array(
			'label'   => 'Order By',
			'type'    => Controls_Manager::SELECT,
			'options' => array( 'date' => 'Date', 'title' => 'Title', 'menu_order' => 'Menu Order' ),
			'default' => 'date',
		) );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		require_once VP_PLUGIN_DIR . 'includes/class-vp-render.php';
		$category = ( isset( $settings['display_scope'] ) && $settings['display_scope'] === 'category' ) ? $settings['category'] : '';
		echo VP_Render::grid( array(
			'posts_per_page' => $settings['posts_per_page'],
			'columns'        => $settings['columns'],
			'category'       => $category,
			'orderby'        => $settings['orderby'],
		) );
	}
}
