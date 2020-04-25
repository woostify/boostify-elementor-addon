<?php
/**
 * Register Hook Main Plugin
 *
 * Main Plugin
 * @since 1.0.0
 */

// For post grid template
add_action( 'boostify_post_grid_template', 'boostify_template_post_grid', 10 );

add_action( 'boostify_post_grid_default', 'boostify_template_post_grid', 10, 1 );

add_action( 'boostify_post_grid_masonry', 'boostify_template_post_grid_masonry', 10, 1 );

add_action( 'boostify_post_list_default', 'boostify_template_post_list', 10, 1 );

add_action( 'boostify_post_list_image_right', 'boostify_template_post_list', 10, 1 );

add_action( 'boostify_post_list_zigzag', 'boostify_template_post_list', 10, 1 );

add_action( 'boostify_post_slider_default', 'boostify_template_post_slider', 10, 1 );
