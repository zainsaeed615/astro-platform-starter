<?php
/**
 * Widget: Price-quote button (opens the popup for the current / chosen home).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Widget_Quote_Button extends MWH_Widget_Base {

	public function get_name() {
		return 'mwh_quote_button';
	}

	public function get_title() {
		return __( 'Price Quote Button', 'mw-homes' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec', array( 'label' => __( 'Button', 'mw-homes' ) ) );

		$this->add_control( 'label', array(
			'label'   => __( 'Text', 'mw-homes' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Request a Price Quote', 'mw-homes' ),
		) );

		$this->add_control( 'plan_source', array(
			'label'   => __( 'Home', 'mw-homes' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'current',
			'options' => array(
				'current' => __( 'Current home (single page)', 'mw-homes' ),
				'choose'  => __( 'Specific home', 'mw-homes' ),
			),
		) );

		$this->add_control( 'plan_id', array(
			'label'       => __( 'Select home', 'mw-homes' ),
			'type'        => \Elementor\Controls_Manager::SELECT2,
			'options'     => $this->plan_options(),
			'label_block' => true,
			'condition'   => array( 'plan_source' => 'choose' ),
		) );

		$this->add_responsive_control( 'align', array(
			'label'     => __( 'Alignment', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::CHOOSE,
			'options'   => array(
				'flex-start' => array( 'title' => __( 'Left', 'mw-homes' ), 'icon' => 'eicon-text-align-left' ),
				'center'     => array( 'title' => __( 'Center', 'mw-homes' ), 'icon' => 'eicon-text-align-center' ),
				'flex-end'   => array( 'title' => __( 'Right', 'mw-homes' ), 'icon' => 'eicon-text-align-right' ),
				'stretch'    => array( 'title' => __( 'Full', 'mw-homes' ), 'icon' => 'eicon-text-align-justify' ),
			),
			'default'   => 'flex-start',
			'selectors' => array( '{{WRAPPER}} .mwh-qbtn-wrap' => 'display:flex;justify-content:{{VALUE}};' ),
		) );

		$this->add_control( 'bg', array(
			'label'     => __( 'Background', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .mwh-quote-open' => 'background: {{VALUE}};' ),
		) );

		$this->add_control( 'color', array(
			'label'     => __( 'Text color', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .mwh-quote-open' => 'color: {{VALUE}};' ),
		) );

		$this->end_controls_section();
	}

	private function plan_options() {
		$out   = array();
		$plans = get_posts( array( 'post_type' => 'home_plan', 'posts_per_page' => 100, 'post_status' => 'publish' ) );
		foreach ( $plans as $p ) {
			$out[ $p->ID ] = $p->post_title;
		}
		return $out;
	}

	protected function render() {
		$s  = $this->get_settings_for_display();
		$id = ( 'choose' === $s['plan_source'] && ! empty( $s['plan_id'] ) ) ? absint( $s['plan_id'] ) : $this->preview_plan_id();
		if ( ! $id ) {
			$this->empty_notice( __( 'No home found. Choose a specific home or place this on a home page.', 'mw-homes' ) );
			return;
		}
		echo '<div class="mwh-qbtn-wrap">' . mwh_quote_button( $id, $s['label'] ) . '</div>'; // phpcs:ignore
	}
}
