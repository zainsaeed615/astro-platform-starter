<?php
/**
 * Widget: Single home – description (main content).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Widget_Single_Desc extends MWH_Widget_Base {

	public function get_name() {
		return 'mwh_single_desc';
	}

	public function get_title() {
		return __( 'Home: Description', 'mw-homes' );
	}

	public function get_icon() {
		return 'eicon-text';
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec', array( 'label' => __( 'Description', 'mw-homes' ) ) );
		$this->add_control( 'source', array(
			'label'   => __( 'Text source', 'mw-homes' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'content',
			'options' => array(
				'content' => __( 'Full content (editor)', 'mw-homes' ),
				'short'   => __( 'Short description', 'mw-homes' ),
			),
		) );
		$this->add_control( 'text_color', array(
			'label'     => __( 'Text color', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .mwh-single-desc' => 'color: {{VALUE}};' ),
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
		echo '<div class="mwh-single-desc">';
		if ( 'short' === $s['source'] ) {
			$short = mwh_get( 'short_desc', $id );
			echo wpautop( wp_kses_post( $short ) );
		} else {
			$post = get_post( $id );
			echo apply_filters( 'the_content', $post ? $post->post_content : '' ); // phpcs:ignore
		}
		echo '</div>';
	}
}
