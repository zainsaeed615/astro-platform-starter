<?php
/**
 * Widget: Single home – 3D Tour + Floor Plan.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Widget_Single_Media extends MWH_Widget_Base {

	public function get_name() {
		return 'mwh_single_media';
	}

	public function get_title() {
		return __( 'Home: 3D Tour & Floor Plan', 'mw-homes' );
	}

	public function get_icon() {
		return 'eicon-video-camera';
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec', array( 'label' => __( 'Media', 'mw-homes' ) ) );
		$this->add_control( 'show_tour', array( 'label' => __( 'Show 3D tour', 'mw-homes' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ) );
		$this->add_control( 'embed_tour', array(
			'label'       => __( 'Embed tour inline', 'mw-homes' ),
			'description' => __( 'Embed the Matterport/iframe directly. Turn off to show a button link only.', 'mw-homes' ),
			'type'        => \Elementor\Controls_Manager::SWITCHER,
			'default'     => 'yes',
			'condition'   => array( 'show_tour' => 'yes' ),
		) );
		$this->add_control( 'show_fp', array( 'label' => __( 'Show floor plan', 'mw-homes' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ) );
		$this->add_control( 'layout', array(
			'label'   => __( 'Layout', 'mw-homes' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'row',
			'options' => array( 'row' => __( 'Side by side', 'mw-homes' ), 'stack' => __( 'Stacked', 'mw-homes' ) ),
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
		$tour  = mwh_get( 'tour_url', $id );
		$fp_id = mwh_get( 'floorplan_id', $id );

		if ( ! $tour && ! $fp_id ) {
			$this->empty_notice( __( 'Add a 3D tour URL and/or floor plan image to this home.', 'mw-homes' ) );
			return;
		}

		$cls = 'row' === $s['layout'] ? 'mwh-media-row' : 'mwh-media-row mwh-media-row--stack';
		echo '<div class="' . esc_attr( $cls ) . '"' . ( 'stack' === $s['layout'] ? ' style="grid-template-columns:1fr"' : '' ) . '>';

		if ( 'yes' === $s['show_tour'] && $tour ) {
			echo '<div class="mwh-media-box"><h4>' . esc_html__( '3D Tour', 'mw-homes' ) . '</h4><div class="mwh-media-box__inner">';
			if ( 'yes' === $s['embed_tour'] ) {
				$src = $this->embed_src( $tour );
				echo '<div class="mwh-tour-embed"><iframe src="' . esc_url( $src ) . '" allowfullscreen allow="xr-spatial-tracking; fullscreen" loading="lazy"></iframe></div>';
			} else {
				echo '<a class="mwh-tour-link" href="' . esc_url( $tour ) . '" target="_blank" rel="noopener">' . esc_html__( 'Launch 3D Tour →', 'mw-homes' ) . '</a>';
			}
			echo '</div></div>';
		}

		if ( 'yes' === $s['show_fp'] && $fp_id ) {
			$full = wp_get_attachment_image_url( $fp_id, 'full' );
			echo '<div class="mwh-media-box"><h4>' . esc_html__( 'Floor Plan', 'mw-homes' ) . '</h4><div class="mwh-media-box__inner">';
			echo '<a href="' . esc_url( $full ) . '" data-mwh-lightbox>' . wp_get_attachment_image( $fp_id, 'large' ) . '</a>';
			echo '</div></div>';
		}

		echo '</div>';
	}

	/**
	 * Normalise a Matterport share link into an embeddable src.
	 */
	private function embed_src( $url ) {
		if ( strpos( $url, 'matterport.com' ) !== false && strpos( $url, '/show' ) === false ) {
			// leave as-is if already an embed
		}
		return $url;
	}
}
