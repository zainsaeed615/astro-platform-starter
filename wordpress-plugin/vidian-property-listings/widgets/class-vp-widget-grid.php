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

		$this->start_controls_section( 'card_style', array(
			'label' => 'Card Style',
			'tab'   => Controls_Manager::TAB_STYLE,
		) );

		$this->add_control( 'title_color', array(
			'label'     => 'Title Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => array(
				'{{WRAPPER}} .vp-card-title' => 'color: {{VALUE}} !important;',
			),
		) );

		$this->add_responsive_control( 'title_size', array(
			'label'      => 'Title Font Size',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array( 'px' => array( 'min' => 18, 'max' => 60 ) ),
			'default'    => array( 'size' => 32, 'unit' => 'px' ),
			'selectors'  => array(
				'{{WRAPPER}} .vp-card-title' => 'font-size: {{SIZE}}{{UNIT}};',
			),
		) );

		$this->add_control( 'location_bg', array(
			'label'     => 'Location Background',
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(20,20,30,0.62)',
			'selectors' => array(
				'{{WRAPPER}} .vp-card-location' => 'background: {{VALUE}};',
			),
		) );

		$this->add_control( 'location_color', array(
			'label'     => 'Location Text Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => array(
				'{{WRAPPER}} .vp-card-location' => 'color: {{VALUE}};',
			),
		) );

		$this->add_control( 'price_color', array(
			'label'     => 'Price Text Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => array(
				'{{WRAPPER}} .vp-card-price' => 'color: {{VALUE}};',
			),
		) );

		$this->add_control( 'button_text_color', array(
			'label'     => 'Button Text Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => array(
				'{{WRAPPER}} .vp-card-btn' => 'color: {{VALUE}};',
			),
		) );

		$this->add_control( 'button_border_color', array(
			'label'     => 'Button Border Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(255,255,255,0.85)',
			'selectors' => array(
				'{{WRAPPER}} .vp-card-btn' => 'border-color: {{VALUE}};',
			),
		) );

		$this->add_responsive_control( 'card_min_height', array(
			'label'      => 'Card Image Height',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array( 'px' => array( 'min' => 260, 'max' => 700 ) ),
			'default'    => array( 'size' => 420, 'unit' => 'px' ),
			'selectors'  => array(
				'{{WRAPPER}} .vp-card-img' => 'min-height: {{SIZE}}{{UNIT}};',
			),
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
