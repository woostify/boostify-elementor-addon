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

add_action( 'boostify_post_grid_box', 'boostify_template_post_grid_box' );
