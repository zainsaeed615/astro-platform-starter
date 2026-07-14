<?php
/**
 * Shared data helpers.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The six specification tabs, in display order.
 */
function mwh_spec_tabs() {
	return array(
		'construction' => __( 'Construction', 'mw-homes' ),
		'exterior'     => __( 'Exterior', 'mw-homes' ),
		'interior'     => __( 'Interior', 'mw-homes' ),
		'utilities'    => __( 'Utilities', 'mw-homes' ),
		'baths'        => __( 'Baths', 'mw-homes' ),
		'kitchen'      => __( 'Kitchen', 'mw-homes' ),
	);
}

/**
 * List of scalar meta fields (key => default).
 */
function mwh_meta_fields() {
	return array(
		'model_number' => '',
		'built_by'     => '',
		'offered_by'   => '',
		'beds'         => '',
		'baths'        => '',
		'sqft'         => '',
		'width'        => '',
		'length'       => '',
		'sections'     => '',
		'short_desc'   => '',
		'tour_url'      => '',
		'tour_thumb_id' => '',
		'brochure_url'  => '',
		'floorplan_id'  => '',
		'gallery'       => '',
		'featured'      => '',
	);
}

/**
 * Get a single home meta value.
 */
function mwh_get( $key, $post_id = null, $default = '' ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$val     = get_post_meta( $post_id, '_mwh_' . $key, true );
	if ( '' === $val || null === $val ) {
		if ( 'offered_by' === $key ) {
			$settings = get_option( 'mwh_settings', array() );
			return isset( $settings['offered_by'] ) && $settings['offered_by'] ? $settings['offered_by'] : $default;
		}
		return $default;
	}
	return $val;
}

/**
 * Return an array of gallery attachment IDs for a plan.
 */
function mwh_gallery_ids( $post_id = null ) {
	$raw = mwh_get( 'gallery', $post_id );
	if ( ! $raw ) {
		return array();
	}
	return array_filter( array_map( 'absint', explode( ',', $raw ) ) );
}

/**
 * Parse a spec tab textarea into label/value rows.
 * Each line: "Label: Value" or "Label | Value".
 */
function mwh_get_specs( $tab_key, $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$raw     = get_post_meta( $post_id, '_mwh_spec_' . $tab_key, true );
	$rows    = array();
	if ( ! $raw ) {
		return $rows;
	}
	$lines = preg_split( '/\r\n|\r|\n/', $raw );
	foreach ( $lines as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		if ( strpos( $line, '|' ) !== false ) {
			$parts = explode( '|', $line, 2 );
		} elseif ( strpos( $line, ':' ) !== false ) {
			$parts = explode( ':', $line, 2 );
		} else {
			$parts = array( '', $line );
		}
		$rows[] = array(
			'label' => trim( $parts[0] ),
			'value' => isset( $parts[1] ) ? trim( $parts[1] ) : '',
		);
	}
	return $rows;
}

/**
 * Does this plan have any specs at all?
 */
function mwh_has_specs( $post_id = null ) {
	foreach ( array_keys( mwh_spec_tabs() ) as $key ) {
		if ( mwh_get_specs( $key, $post_id ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Dimensions string, e.g. 47'0" x 80'0".
 */
function mwh_dimensions( $post_id = null ) {
	$w = mwh_get( 'width', $post_id );
	$l = mwh_get( 'length', $post_id );
	if ( $w && $l ) {
		return $w . ' x ' . $l;
	}
	return $w . $l;
}

/**
 * First taxonomy term name for a plan.
 */
function mwh_term_name( $taxonomy, $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$terms   = get_the_terms( $post_id, $taxonomy );
	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return '';
	}
	return $terms[0]->name;
}

/**
 * Type badges (home types) for a plan, plus a Featured badge when flagged.
 */
function mwh_badges( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$badges  = array();
	$terms   = get_the_terms( $post_id, 'mwh_type' );
	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		foreach ( $terms as $t ) {
			$badges[] = array( 'label' => $t->name, 'type' => sanitize_title( $t->name ) );
		}
	}
	if ( 'yes' === mwh_get( 'featured', $post_id ) ) {
		$badges[] = array( 'label' => __( 'Featured', 'mw-homes' ), 'type' => 'featured' );
	}
	return $badges;
}

/**
 * Short description used on cards (falls back to excerpt / trimmed content).
 */
function mwh_excerpt( $post_id = null, $words = 22 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$desc    = mwh_get( 'short_desc', $post_id );
	if ( ! $desc ) {
		$post = get_post( $post_id );
		$desc = $post ? ( $post->post_excerpt ? $post->post_excerpt : $post->post_content ) : '';
	}
	$desc = wp_strip_all_tags( $desc );
	return wp_trim_words( $desc, $words, '…' );
}

/**
 * US states list for the quote form.
 */
function mwh_us_states() {
	return array(
		'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California',
		'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'FL' => 'Florida', 'GA' => 'Georgia',
		'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa',
		'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland',
		'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri',
		'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey',
		'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio',
		'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina',
		'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont',
		'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming',
	);
}

/**
 * Land option choices for the quote form.
 */
function mwh_land_options() {
	return array(
		'own'    => __( 'I own my land', 'mw-homes' ),
		'need'   => __( 'I need land', 'mw-homes' ),
		'family' => __( 'Land in the family', 'mw-homes' ),
		'unsure' => __( 'Not sure yet', 'mw-homes' ),
	);
}

/**
 * Render a stat block (icon + value) used on cards & single pages.
 */
function mwh_stat_icons() {
	return array(
		'beds'  => 'mwh-icon-bed',
		'baths' => 'mwh-icon-bath',
		'sqft'  => 'mwh-icon-area',
		'dim'   => 'mwh-icon-dim',
	);
}
