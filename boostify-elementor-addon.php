<?php
/**
 * Plugin Name: Boostify Elementor Addon
 * Plugin URI: https://boostifythemes.com
 * Description: Create Header and Footer for your site using Elementor Page Builder.
 * Version: 1.0.0
 * Author: Woostify
 * Author URI: https://woostify.com
 */

define( 'BOOSTIFY_ELEMENTOR_PATH', plugin_dir_path( __FILE__ ) );
define( 'BOOSTIFY_ELEMENTOR_URL', plugin_dir_url( __FILE__ ) );
define( 'BOOSTIFY_ELEMENTOR_VER', '1.0.0' );

require_once BOOSTIFY_ELEMENTOR_PATH . 'inc/class-boostify-elementor-addon.php';
