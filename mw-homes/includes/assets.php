<?php
/**
 * Front-end assets + archive AJAX filter handler.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_Assets {

	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
		add_action( 'wp_ajax_mwh_filter', array( __CLASS__, 'ajax_filter' ) );
		add_action( 'wp_ajax_nopriv_mwh_filter', array( __CLASS__, 'ajax_filter' ) );
	}

	public static function enqueue() {
		wp_enqueue_style( 'mwh-front', MWH_URL . 'assets/css/mw-homes.css', array(), MWH_VERSION );
		wp_enqueue_script( 'mwh-front', MWH_URL . 'assets/js/mw-homes.js', array( 'jquery' ), MWH_VERSION, true );
		wp_localize_script( 'mwh-front', 'MWH', array(
			'ajax'       => admin_url( 'admin-ajax.php' ),
			'quoteNonce' => wp_create_nonce( 'mwh_quote' ),
			'filterNonce'=> wp_create_nonce( 'mwh_filter' ),
			'i18n'       => array(
				'sending' => __( 'Sending…', 'mw-homes' ),
				'submit'  => __( 'Submit', 'mw-homes' ),
				'error'   => __( 'Something went wrong. Please try again.', 'mw-homes' ),
			),
		) );
	}

	/**
	 * AJAX: filter/paginate the archive grid.
	 */
	public static function ajax_filter() {
		check_ajax_referer( 'mwh_filter', 'nonce' );

		$paged    = isset( $_POST['paged'] ) ? max( 1, absint( $_POST['paged'] ) ) : 1;
		$per_page = isset( $_POST['per_page'] ) ? absint( $_POST['per_page'] ) : 9;
		$per_page = $per_page ? $per_page : 9;

		$args = array(
			'post_type'      => 'home_plan',
			'post_status'    => 'publish',
			'posts_per_page' => $per_page,
			'paged'          => $paged,
			'meta_query'     => array(),
			'tax_query'      => array(),
		);

		// Taxonomy filters.
		foreach ( array( 'mwh_manufacturer', 'mwh_series', 'mwh_type' ) as $tax ) {
			if ( ! empty( $_POST[ $tax ] ) ) {
				$args['tax_query'][] = array(
					'taxonomy' => $tax,
					'field'    => 'slug',
					'terms'    => sanitize_title( wp_unslash( $_POST[ $tax ] ) ),
				);
			}
		}

		// Numeric meta filters.
		if ( ! empty( $_POST['beds'] ) ) {
			$args['meta_query'][] = array( 'key' => '_mwh_beds', 'value' => absint( $_POST['beds'] ), 'type' => 'NUMERIC', 'compare' => '>=' );
		}
		if ( ! empty( $_POST['baths'] ) ) {
			$args['meta_query'][] = array( 'key' => '_mwh_baths', 'value' => floatval( $_POST['baths'] ), 'type' => 'DECIMAL', 'compare' => '>=' );
		}
		if ( ! empty( $_POST['sections'] ) ) {
			$args['meta_query'][] = array( 'key' => '_mwh_sections', 'value' => absint( $_POST['sections'] ), 'type' => 'NUMERIC', 'compare' => '=' );
		}
		if ( ! empty( $_POST['sqft_min'] ) ) {
			$args['meta_query'][] = array( 'key' => '_mwh_sqft', 'value' => absint( $_POST['sqft_min'] ), 'type' => 'NUMERIC', 'compare' => '>=' );
		}
		if ( ! empty( $_POST['sqft_max'] ) ) {
			$args['meta_query'][] = array( 'key' => '_mwh_sqft', 'value' => absint( $_POST['sqft_max'] ), 'type' => 'NUMERIC', 'compare' => '<=' );
		}
		if ( ! empty( $_POST['has_tour'] ) ) {
			$args['meta_query'][] = array( 'key' => '_mwh_tour_url', 'value' => '', 'compare' => '!=' );
		}
		if ( ! empty( $_POST['s'] ) ) {
			$args['s'] = sanitize_text_field( wp_unslash( $_POST['s'] ) );
		}

		$q = new WP_Query( $args );

		$stats_mode   = isset( $_POST['stats_mode'] ) ? sanitize_key( wp_unslash( $_POST['stats_mode'] ) ) : 'labels';
		$show_excerpt = ! empty( $_POST['show_excerpt'] );
		if ( ! in_array( $stats_mode, array( 'labels', 'icons' ), true ) ) {
			$stats_mode = 'labels';
		}
		$card_args = array(
			'stats_mode'   => $stats_mode,
			'show_excerpt' => $show_excerpt,
		);

		ob_start();
		if ( $q->have_posts() ) {
			while ( $q->have_posts() ) {
				$q->the_post();
				echo mwh_render_card( get_the_ID(), $card_args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		} else {
			echo '<p class="mwh-noresults">' . esc_html__( 'No floor plans match your filters.', 'mw-homes' ) . '</p>';
		}
		wp_reset_postdata();
		$html = ob_get_clean();

		wp_send_json_success( array(
			'html'    => $html,
			'found'   => (int) $q->found_posts,
			'pages'   => (int) $q->max_num_pages,
			'paged'   => $paged,
		) );
	}
}

MWH_Assets::init();
