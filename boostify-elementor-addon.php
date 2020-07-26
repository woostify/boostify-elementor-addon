<?php
/**
 * Plugin Name: Boostify Elementor Addon
 * Plugin URI: https://boostifythemes.com
 * Description: Create Header and Footer for your site using Elementor Page Builder.
 * Version: 1.0.0
 * Author: Woostify
 * Author URI: https://woostify.com
 */
define( 'BOOSTIFY_ELEMENTOR_VER', '1.0.0' );
define( 'BOOSTIFY_ELEMENTOR_PATH', plugin_dir_path( __FILE__ ) );
define( 'BOOSTIFY_ELEMENTOR_URL', plugin_dir_url( __FILE__ ) );
define( 'BOOSTIFY_ELEMENTOR_CORE', BOOSTIFY_ELEMENTOR_PATH . 'inc/core/' );
define( 'BOOSTIFY_ELEMENTOR_WIDGET', BOOSTIFY_ELEMENTOR_PATH . 'inc/widgets/' );
define( 'BOOSTIFY_ELEMENTOR_CONTROL', BOOSTIFY_ELEMENTOR_PATH . 'inc/control/' );
define( 'BOOSTIFY_ELEMENTOR_DYNAMIC', BOOSTIFY_ELEMENTOR_PATH . 'inc/dynamic/' );
define( 'BOOSTIFY_ELEMENTOR_CSS', BOOSTIFY_ELEMENTOR_URL . 'assets/css/' );
define( 'BOOSTIFY_ELEMENTOR_JS', BOOSTIFY_ELEMENTOR_URL . 'assets/js/' );
define( 'BOOSTIFY_ELEMENTOR_IMG', BOOSTIFY_ELEMENTOR_URL . 'assets/images/' );

require_once BOOSTIFY_ELEMENTOR_PATH . 'inc/class-boostify-elementor-addon.php';
