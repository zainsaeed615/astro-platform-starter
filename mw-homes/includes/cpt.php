<?php
/**
 * Custom post types & taxonomies.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MWH_CPT {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register' ) );
	}

	public static function register() {
		self::register_home_plan();
		self::register_quote_request();
		self::register_taxonomies();
	}

	/**
	 * Floor Plan / Home post type (public, single pages + archive).
	 */
	public static function register_home_plan() {
		$labels = array(
			'name'               => __( 'Floor Plans', 'mw-homes' ),
			'singular_name'      => __( 'Floor Plan', 'mw-homes' ),
			'menu_name'          => __( 'Floor Plans', 'mw-homes' ),
			'add_new'            => __( 'Add New', 'mw-homes' ),
			'add_new_item'       => __( 'Add New Floor Plan', 'mw-homes' ),
			'edit_item'          => __( 'Edit Floor Plan', 'mw-homes' ),
			'new_item'           => __( 'New Floor Plan', 'mw-homes' ),
			'view_item'          => __( 'View Floor Plan', 'mw-homes' ),
			'search_items'       => __( 'Search Floor Plans', 'mw-homes' ),
			'not_found'          => __( 'No floor plans found', 'mw-homes' ),
			'not_found_in_trash' => __( 'No floor plans found in Trash', 'mw-homes' ),
			'all_items'          => __( 'All Floor Plans', 'mw-homes' ),
		);

		register_post_type( 'home_plan', array(
			'labels'              => $labels,
			'public'              => true,
			'has_archive'         => true,
			'menu_icon'           => 'dashicons-admin-home',
			'menu_position'       => 25,
			'show_in_rest'        => true,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'rewrite'             => array( 'slug' => 'plan', 'with_front' => false ),
			'capability_type'     => 'post',
		) );
	}

	/**
	 * Quote request storage (private, admin only).
	 */
	public static function register_quote_request() {
		register_post_type( 'quote_request', array(
			'labels' => array(
				'name'          => __( 'Quote Requests', 'mw-homes' ),
				'singular_name' => __( 'Quote Request', 'mw-homes' ),
				'menu_name'     => __( 'Quote Requests', 'mw-homes' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => 'edit.php?post_type=home_plan',
			'capability_type'     => 'post',
			'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'        => true,
			'supports'            => array( 'title' ),
			'menu_icon'           => 'dashicons-email',
		) );
	}

	/**
	 * Manufacturer, Series, Home Type taxonomies.
	 */
	public static function register_taxonomies() {
		register_taxonomy( 'mwh_manufacturer', 'home_plan', array(
			'labels'            => self::tax_labels( __( 'Manufacturer', 'mw-homes' ), __( 'Manufacturers', 'mw-homes' ) ),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'manufacturer' ),
		) );

		register_taxonomy( 'mwh_series', 'home_plan', array(
			'labels'            => self::tax_labels( __( 'Series', 'mw-homes' ), __( 'Series', 'mw-homes' ) ),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'series' ),
		) );

		register_taxonomy( 'mwh_type', 'home_plan', array(
			'labels'            => self::tax_labels( __( 'Home Type', 'mw-homes' ), __( 'Home Types', 'mw-homes' ) ),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'home-type' ),
		) );
	}

	private static function tax_labels( $single, $plural ) {
		return array(
			'name'          => $plural,
			'singular_name' => $single,
			'search_items'  => sprintf( __( 'Search %s', 'mw-homes' ), $plural ),
			'all_items'     => sprintf( __( 'All %s', 'mw-homes' ), $plural ),
			'edit_item'     => sprintf( __( 'Edit %s', 'mw-homes' ), $single ),
			'add_new_item'  => sprintf( __( 'Add New %s', 'mw-homes' ), $single ),
			'menu_name'     => $plural,
		);
	}
}

MWH_CPT::init();
