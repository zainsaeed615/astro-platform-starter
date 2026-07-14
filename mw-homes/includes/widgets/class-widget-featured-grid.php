<?php
/**
 * Widget: Featured Homes grid.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Widget_Featured_Grid extends MWH_Widget_Base {

	public function get_name() {
		return 'mwh_featured_grid';
	}

	public function get_title() {
		return __( 'Featured Homes Grid', 'mw-homes' );
	}

	public function get_keywords() {
		return array( 'homes', 'floor plan', 'grid', 'featured', 'mw' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'sec_query', array( 'label' => __( 'Homes', 'mw-homes' ) ) );

		$this->add_control( 'heading', array(
			'label'   => __( 'Heading', 'mw-homes' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Featured Homes', 'mw-homes' ),
			'dynamic' => array( 'active' => true ),
		) );

		$this->add_control( 'source', array(
			'label'   => __( 'Show', 'mw-homes' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'featured',
			'options' => array(
				'featured' => __( 'Featured only', 'mw-homes' ),
				'latest'   => __( 'Latest', 'mw-homes' ),
				'manual'   => __( 'Hand-picked', 'mw-homes' ),
			),
		) );

		$this->add_control( 'manual_ids', array(
			'label'       => __( 'Select homes', 'mw-homes' ),
			'type'        => \Elementor\Controls_Manager::SELECT2,
			'multiple'    => true,
			'options'     => $this->plan_options(),
			'label_block' => true,
			'condition'   => array( 'source' => 'manual' ),
		) );

		$this->add_control( 'manufacturer', array(
			'label'       => __( 'Manufacturer', 'mw-homes' ),
			'type'        => \Elementor\Controls_Manager::SELECT,
			'default'     => '',
			'options'     => $this->term_options( 'mwh_manufacturer' ),
			'condition'   => array( 'source!' => 'manual' ),
		) );

		$this->add_control( 'type', array(
			'label'     => __( 'Home Type', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => '',
			'options'   => $this->term_options( 'mwh_type' ),
			'condition' => array( 'source!' => 'manual' ),
		) );

		$this->add_control( 'limit', array(
			'label'     => __( 'Number of homes', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 3,
			'min'       => 1,
			'max'       => 24,
			'condition' => array( 'source!' => 'manual' ),
		) );

		$this->add_responsive_control( 'columns', array(
			'label'          => __( 'Columns', 'mw-homes' ),
			'type'           => \Elementor\Controls_Manager::SELECT,
			'default'        => '3',
			'tablet_default' => '2',
			'mobile_default' => '1',
			'options'        => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ),
			'selectors'      => array( '{{WRAPPER}} .mwh-homes-grid' => '--mwh-cols: {{VALUE}};' ),
		) );

		$this->add_control( 'stats_mode', array(
			'label'   => __( 'Specs display', 'mw-homes' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'labels',
			'options' => array(
				'labels' => __( 'Text labels (Beds: 3) — reference style', 'mw-homes' ),
				'icons'  => __( 'Icons', 'mw-homes' ),
			),
		) );

		$this->add_control( 'show_excerpt', array(
			'label'   => __( 'Show short description', 'mw-homes' ),
			'type'    => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
		) );

		$this->add_control( 'show_all', array(
			'label'   => __( 'Show "See All" button', 'mw-homes' ),
			'type'    => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
		) );

		$this->add_control( 'all_text', array(
			'label'     => __( 'Button text', 'mw-homes' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => __( 'See All Floor Plans', 'mw-homes' ),
			'condition' => array( 'show_all' => 'yes' ),
		) );

		$this->add_control( 'all_link', array(
			'label'       => __( 'Button link', 'mw-homes' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => home_url( '/plan/' ),
			'default'     => array( 'url' => get_post_type_archive_link( 'home_plan' ) ),
			'condition'   => array( 'show_all' => 'yes' ),
		) );

		$this->end_controls_section();

		$this->register_card_style_controls( '{{WRAPPER}} .mwh-homes-grid' );
	}

	private function plan_options() {
		$out   = array();
		$plans = get_posts( array( 'post_type' => 'home_plan', 'posts_per_page' => 100, 'post_status' => 'publish' ) );
		foreach ( $plans as $p ) {
			$out[ $p->ID ] = $p->post_title;
		}
		return $out;
	}

	private function term_options( $tax ) {
		$out   = array( '' => __( 'All', 'mw-homes' ) );
		$terms = get_terms( array( 'taxonomy' => $tax, 'hide_empty' => false ) );
		if ( ! is_wp_error( $terms ) ) {
			foreach ( $terms as $t ) {
				$out[ $t->slug ] = $t->name;
			}
		}
		return $out;
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		$args = array(
			'post_type'      => 'home_plan',
			'post_status'    => 'publish',
			'posts_per_page' => (int) ( $s['limit'] ? $s['limit'] : 3 ),
		);

		if ( 'manual' === $s['source'] ) {
			$ids = ! empty( $s['manual_ids'] ) ? array_map( 'absint', $s['manual_ids'] ) : array();
			if ( empty( $ids ) ) {
				$this->empty_notice( __( 'Select one or more homes to display.', 'mw-homes' ) );
				return;
			}
			$args['post__in']       = $ids;
			$args['orderby']        = 'post__in';
			$args['posts_per_page'] = count( $ids );
		} else {
			if ( 'featured' === $s['source'] ) {
				$args['meta_query'] = array( array( 'key' => '_mwh_featured', 'value' => 'yes' ) );
			}
			$tax = array();
			if ( ! empty( $s['manufacturer'] ) ) {
				$tax[] = array( 'taxonomy' => 'mwh_manufacturer', 'field' => 'slug', 'terms' => $s['manufacturer'] );
			}
			if ( ! empty( $s['type'] ) ) {
				$tax[] = array( 'taxonomy' => 'mwh_type', 'field' => 'slug', 'terms' => $s['type'] );
			}
			if ( $tax ) {
				$args['tax_query'] = $tax;
			}
		}

		$q = new WP_Query( $args );

		if ( ! $q->have_posts() ) {
			$this->empty_notice( __( 'No homes found. Add Floor Plans or mark some as Featured.', 'mw-homes' ) );
			return;
		}

		$card_args = array(
			'stats_mode'   => ! empty( $s['stats_mode'] ) ? $s['stats_mode'] : 'labels',
			'show_excerpt' => ( 'yes' === $s['show_excerpt'] ),
		);

		echo '<div class="mwh-homes">';
		if ( $s['heading'] ) {
			$parts = explode( ' ', $s['heading'] );
			$last  = array_pop( $parts );
			echo '<h2 class="mwh-section-title">' . esc_html( implode( ' ', $parts ) ) . ' <em>' . esc_html( $last ) . '</em></h2>';
		}
		echo '<div class="mwh-homes-grid">';
		while ( $q->have_posts() ) {
			$q->the_post();
			echo mwh_render_card( get_the_ID(), $card_args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		echo '</div>';
		wp_reset_postdata();

		if ( 'yes' === $s['show_all'] && ! empty( $s['all_link']['url'] ) ) {
			echo '<div style="text-align:center;margin-top:28px">';
			printf( '<a class="mwh-btn mwh-btn--info" href="%s">%s</a>', esc_url( $s['all_link']['url'] ), esc_html( $s['all_text'] ) );
			echo '</div>';
		}
		echo '</div>';
	}
}
