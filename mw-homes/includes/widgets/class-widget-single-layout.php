<?php
/**
 * Widget: Complete single floor-plan layout (reference page order).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Widget_Single_Layout extends MWH_Widget_Base {

	public function get_name() {
		return 'mwh_single_layout';
	}

	public function get_title() {
		return __( 'Home: Full Single Layout', 'mw-homes' );
	}

	public function get_icon() {
		return 'eicon-single-page';
	}

	public function get_keywords() {
		return array( 'homes', 'floor plan', 'single', 'detail', 'mw' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec', array( 'label' => __( 'Layout sections', 'mw-homes' ) ) );

		foreach ( array(
			'show_topbar'     => __( 'Title bar + back link', 'mw-homes' ),
			'show_tour'       => __( '3D Tour panel', 'mw-homes' ),
			'show_floorplan'  => __( 'Floor plan image', 'mw-homes' ),
			'show_specs'      => __( 'Specifications tabs', 'mw-homes' ),
			'show_tours'      => __( 'Tours & Videos', 'mw-homes' ),
			'show_gallery'    => __( 'Photo Gallery', 'mw-homes' ),
			'show_disclaimer' => __( 'Disclaimer', 'mw-homes' ),
		) as $key => $label ) {
			$this->add_control( $key, array(
				'label'   => $label,
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			) );
		}

		$this->add_control( 'embed_tour', array(
			'label'     => __( 'Embed 3D tour inline (iframe)', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::SWITCHER,
			'default'   => '',
			'condition' => array( 'show_tour' => 'yes' ),
		) );

		$this->add_control( 'archive_url', array(
			'label'       => __( 'Back link URL', 'mw-homes' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'default'     => array( 'url' => get_post_type_archive_link( 'home_plan' ) ),
			'condition'   => array( 'show_topbar' => 'yes' ),
		) );

		$this->add_control( 'disclaimer', array(
			'label'       => __( 'Disclaimer text', 'mw-homes' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 3,
			'placeholder' => __( 'Leave blank to use Settings default.', 'mw-homes' ),
			'condition'   => array( 'show_disclaimer' => 'yes' ),
		) );

		$this->end_controls_section();

		$this->start_controls_section(
			'sec_style',
			array(
				'label' => __( 'Style', 'mw-homes' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control( 'heading_color', array(
			'label'     => __( 'Section heading color', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .mwh-h2' => 'color: {{VALUE}};' ),
		) );

		$this->add_responsive_control( 'heading_size', array(
			'label'      => __( 'Section heading size', 'mw-homes' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array( 'px' => array( 'min' => 16, 'max' => 48 ) ),
			'selectors'  => array( '{{WRAPPER}} .mwh-h2' => 'font-size: {{SIZE}}{{UNIT}};' ),
		) );

		$this->add_control( 'btn_info_bg', array(
			'label'     => __( 'Brochure button color', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .mwh-btn--info' => 'background-color: {{VALUE}};' ),
		) );

		$this->add_control( 'btn_quote_bg', array(
			'label'     => __( 'Price Quote button color', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .mwh-btn--quote' => 'background-color: {{VALUE}};' ),
		) );

		$this->add_responsive_control( 'btn_font_size', array(
			'label'      => __( 'Button font size', 'mw-homes' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => array( 'px' ),
			'range'      => array( 'px' => array( 'min' => 10, 'max' => 22 ) ),
			'selectors'  => array( '{{WRAPPER}} .mwh-details-actions .mwh-btn' => 'font-size: {{SIZE}}{{UNIT}};' ),
		) );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'btn_typo',
				'label'    => __( 'Button typography', 'mw-homes' ),
				'selector' => '{{WRAPPER}} .mwh-details-actions .mwh-btn',
			)
		);

		$this->add_control( 'topbar_bg', array(
			'label'     => __( 'Title bar background', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .mwh-single-topbar' => 'background-color: {{VALUE}};' ),
		) );

		$this->end_controls_section();
	}

	protected function render() {
		$s  = $this->get_settings_for_display();
		$id = $this->preview_plan_id();
		if ( ! $id ) {
			$this->empty_notice( __( 'No home found to display.', 'mw-homes' ) );
			return;
		}

		$archive = ! empty( $s['archive_url']['url'] ) ? $s['archive_url']['url'] : get_post_type_archive_link( 'home_plan' );

		echo mwh_render_single_layout( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$id,
			array(
				'show_topbar'     => ( 'yes' === $s['show_topbar'] ),
				'show_tour'       => ( 'yes' === $s['show_tour'] ),
				'embed_tour'      => ( 'yes' === $s['embed_tour'] ),
				'show_floorplan'  => ( 'yes' === $s['show_floorplan'] ),
				'show_specs'      => ( 'yes' === $s['show_specs'] ),
				'show_tours'      => ( 'yes' === $s['show_tours'] ),
				'show_gallery'    => ( 'yes' === $s['show_gallery'] ),
				'show_disclaimer' => ( 'yes' === $s['show_disclaimer'] ),
				'archive_url'     => $archive,
				'disclaimer'      => ! empty( $s['disclaimer'] ) ? $s['disclaimer'] : '',
			)
		);
	}
}
