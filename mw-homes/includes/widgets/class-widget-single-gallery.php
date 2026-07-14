<?php
/**
 * Widget: Single home – photo gallery.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Widget_Single_Gallery extends MWH_Widget_Base {

	public function get_name() {
		return 'mwh_single_gallery';
	}

	public function get_title() {
		return __( 'Home: Gallery', 'mw-homes' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec', array( 'label' => __( 'Gallery', 'mw-homes' ) ) );
		$this->add_responsive_control( 'columns', array(
			'label'     => __( 'Columns', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => '4',
			'options'   => array( '2' => '2', '3' => '3', '4' => '4', '5' => '5' ),
			'selectors' => array( '{{WRAPPER}} .mwh-gallery' => 'grid-template-columns: repeat({{VALUE}},1fr);' ),
		) );
		$this->add_control( 'include_featured', array(
			'label'   => __( 'Include featured image first', 'mw-homes' ),
			'type'    => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
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
		$ids = mwh_gallery_ids( $id );
		if ( 'yes' === $s['include_featured'] && has_post_thumbnail( $id ) ) {
			array_unshift( $ids, get_post_thumbnail_id( $id ) );
		}
		$ids = array_values( array_unique( array_filter( $ids ) ) );
		if ( empty( $ids ) ) {
			$this->empty_notice( __( 'Add gallery images to this home.', 'mw-homes' ) );
			return;
		}
		echo '<div class="mwh-gallery">';
		foreach ( $ids as $img ) {
			$full = wp_get_attachment_image_url( $img, 'full' );
			echo '<a href="' . esc_url( $full ) . '" data-mwh-lightbox>' . wp_get_attachment_image( $img, 'medium_large' ) . '</a>';
		}
		echo '</div>';
	}
}
