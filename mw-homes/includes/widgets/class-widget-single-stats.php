<?php
/**
 * Widget: Single home – stats (beds/baths/sqft/dimensions).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Widget_Single_Stats extends MWH_Widget_Base {

	public function get_name() {
		return 'mwh_single_stats';
	}

	public function get_title() {
		return __( 'Home: Stats', 'mw-homes' );
	}

	public function get_icon() {
		return 'eicon-number-field';
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec', array( 'label' => __( 'Stats', 'mw-homes' ) ) );
		$this->add_control( 'icon_color', array(
			'label'     => __( 'Icon color', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .mwh-stat__ico' => 'filter: none;' ),
		) );
		$this->add_control( 'val_color', array(
			'label'     => __( 'Value color', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .mwh-stat' => 'color: {{VALUE}};' ),
		) );
		$this->end_controls_section();
	}

	protected function render() {
		$id = $this->preview_plan_id();
		if ( ! $id ) {
			$this->empty_notice( __( 'No home found to display.', 'mw-homes' ) );
			return;
		}
		echo '<div class="mwh-single-stats">' . mwh_render_stats( $id, false ) . '</div>'; // phpcs:ignore
	}
}
