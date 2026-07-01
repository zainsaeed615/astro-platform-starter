<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class VP_CPT {

	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );
	}

	public function register_post_type() {
		$labels = array(
			'name'               => 'Properties',
			'singular_name'      => 'Property',
			'menu_name'          => 'Properties',
			'add_new'            => 'Add New Property',
			'add_new_item'       => 'Add New Property',
			'edit_item'          => 'Edit Property',
			'new_item'           => 'New Property',
			'view_item'          => 'View Property',
			'search_items'       => 'Search Properties',
			'not_found'          => 'No properties found',
			'not_found_in_trash' => 'No properties found in Trash',
			'all_items'          => 'All Properties',
		);

		$args = array(
			'labels'          => $labels,
			'public'          => true,
			'show_in_rest'    => true,
			'menu_icon'       => 'dashicons-building',
			'menu_position'   => 5,
			'supports'        => array( 'title', 'thumbnail', 'custom-fields' ),
			'has_archive'     => true,
			'rewrite'         => array( 'slug' => 'properties' ),
			'show_in_menu'    => true,
			'capability_type' => 'post',
		);

		register_post_type( 'vp_property', $args );
	}

	public function register_taxonomy() {
		register_taxonomy( 'vp_property_category', 'vp_property', array(
			'labels' => array(
				'name'          => 'Property Categories',
				'singular_name' => 'Property Category',
				'menu_name'     => 'Categories',
			),
			'public'       => true,
			'hierarchical' => true,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'property-category' ),
		) );
	}
}
