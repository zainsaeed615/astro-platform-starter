<?php
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

while ( have_posts() ) {
	the_post();
	require_once VP_PLUGIN_DIR . 'includes/class-vp-render.php';
	echo VP_Render::details( get_the_ID() );
}

get_footer();
