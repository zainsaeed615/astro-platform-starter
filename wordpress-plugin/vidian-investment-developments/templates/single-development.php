<?php
/**
 * Single investment development template.
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) {
    the_post();
    echo do_shortcode('[vidian_development id="' . absint(get_the_ID()) . '"]');
}

get_footer();
