<?php
/**
 * Shared base for MW Homes Elementor widgets.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class MWH_Widget_Base extends \Elementor\Widget_Base {

	public function get_categories() {
		return array( 'mw-homes' );
	}

	public function get_icon() {
		return 'eicon-home-heart';
	}

	/**
	 * Resolve the plan ID to render.
	 */
	protected function preview_plan_id() {
		$id = get_the_ID();
		if ( $id && 'home_plan' === get_post_type( $id ) ) {
			return $id;
		}
		$recent = get_posts( array(
			'post_type'      => 'home_plan',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'fields'         => 'ids',
		) );
		return $recent ? $recent[0] : 0;
	}

	protected function is_editor() {
		return \Elementor\Plugin::$instance->editor->is_edit_mode() || ( isset( $_GET['elementor-preview'] ) );
	}

	protected function empty_notice( $text ) {
		if ( $this->is_editor() ) {
			echo '<div class="mwh-eph">' . esc_html( $text ) . '</div>';
		}
	}

	/**
	 * Style controls for listing card grids (heading, image size, overlays, typography, buttons).
	 *
	 * @param string $grid_selector CSS selector for the grid that uses --mwh-cols / card vars.
	 */
	protected function register_card_style_controls( $grid_selector = '{{WRAPPER}} .mwh-homes-grid' ) {
		$this->start_controls_section(
			'sec_style_heading',
			array(
				'label' => __( 'Style: Heading', 'mw-homes' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_color',
			array(
				'label'     => __( 'Heading color', 'mw-homes' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#0f2a52',
				'selectors' => array(
					'{{WRAPPER}} .mwh-section-title' => 'color: {{VALUE}}; --mwh-heading-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'heading_size',
			array(
				'label'      => __( 'Heading size', 'mw-homes' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px' => array( 'min' => 14, 'max' => 64 ),
				),
				'default'    => array( 'unit' => 'px', 'size' => 30 ),
				'selectors'  => array(
					'{{WRAPPER}} .mwh-section-title' => 'font-size: {{SIZE}}{{UNIT}}; --mwh-heading-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typo',
				'selector' => '{{WRAPPER}} .mwh-section-title',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'sec_style_image',
			array(
				'label' => __( 'Style: Images', 'mw-homes' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'card_image_height',
			array(
				'label'      => __( 'Featured image height', 'mw-homes' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 140, 'max' => 420 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 220 ),
				'selectors'  => array(
					$grid_selector . ' .mwh-card' => '--mwh-card-img-h: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mwh-card'       => '--mwh-card-img-h: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'card_image_fit',
			array(
				'label'     => __( 'Image fit', 'mw-homes' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'cover',
				'options'   => array(
					'cover'   => __( 'Cover (crop to fill)', 'mw-homes' ),
					'contain' => __( 'Contain (show full image)', 'mw-homes' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .mwh-card__photo img' => 'object-fit: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'overlay_width',
			array(
				'label'      => __( 'Overlay thumb width', 'mw-homes' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 70, 'max' => 200 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 121 ),
				'selectors'  => array(
					'{{WRAPPER}} .mwh-card' => '--mwh-ov-w: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'overlay_height',
			array(
				'label'      => __( 'Overlay thumb height', 'mw-homes' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 50, 'max' => 160 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 81 ),
				'selectors'  => array(
					'{{WRAPPER}} .mwh-card' => '--mwh-ov-h: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'fp_overlay_fit',
			array(
				'label'     => __( 'Floor plan overlay fit', 'mw-homes' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'contain',
				'options'   => array(
					'contain' => __( 'Contain', 'mw-homes' ),
					'cover'   => __( 'Cover', 'mw-homes' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .mwh-ov--fp img' => 'object-fit: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'sec_style_title',
			array(
				'label' => __( 'Style: Card Title', 'mw-homes' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'card_title_color',
			array(
				'label'     => __( 'Title color', 'mw-homes' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#0f2a52',
				'selectors' => array(
					'{{WRAPPER}} .mwh-card__title' => 'color: {{VALUE}}; --mwh-title-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_title_size',
			array(
				'label'      => __( 'Title size', 'mw-homes' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array( 'px' => array( 'min' => 12, 'max' => 36 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 17 ),
				'selectors'  => array(
					'{{WRAPPER}} .mwh-card__title' => 'font-size: {{SIZE}}{{UNIT}}; --mwh-title-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_title_typo',
				'selector' => '{{WRAPPER}} .mwh-card__title',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'sec_style_buttons',
			array(
				'label' => __( 'Style: Buttons', 'mw-homes' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'btn_info_bg',
			array(
				'label'     => __( 'More Info button color', 'mw-homes' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#0f2a52',
				'selectors' => array(
					'{{WRAPPER}} .mwh-btn--info' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mwh-card'      => '--mwh-btn-info-bg: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'btn_quote_bg',
			array(
				'label'     => __( 'Price Quote button color', 'mw-homes' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#2f7fd1',
				'selectors' => array(
					'{{WRAPPER}} .mwh-btn--quote, {{WRAPPER}} .mwh-btn--primary' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mwh-card' => '--mwh-btn-quote-bg: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'btn_text_color',
			array(
				'label'     => __( 'Button text color', 'mw-homes' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .mwh-card__actions .mwh-btn' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mwh-card' => '--mwh-btn-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'btn_font_size',
			array(
				'label'      => __( 'Button font size', 'mw-homes' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 10, 'max' => 22 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 13 ),
				'selectors'  => array(
					'{{WRAPPER}} .mwh-card__actions .mwh-btn' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mwh-card' => '--mwh-btn-font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'btn_typo',
				'label'    => __( 'Button typography', 'mw-homes' ),
				'selector' => '{{WRAPPER}} .mwh-card__actions .mwh-btn',
			)
		);

		$this->end_controls_section();
	}
}
