<?php
/**
 * Elementor Controls.
 *
 * @since 1.0.0
 * @package Boostify Addon
 */

namespace Boostify_Elementor;

/**
 * Elementor Controls.
 *
 * @class Admin
 */
class Controls {
	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $instance = null;

	/**
	 * Modules Manager
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var modules_manager.
	 */
	private $modules_manager;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$this->setup_hooks();
	}

	/**
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	private function setup_hooks() {
		add_action( 'elementor/controls/controls_registered', array( $this, 'register_controls' ) );
	}

	/**
	 * Register controls
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_controls() {
		include_once BOOSTIFY_ELEMENTOR_CONTROL . 'class-group-control-post.php';
		include_once BOOSTIFY_ELEMENTOR_CONTROL . 'class-group-control-product.php';
		$control_manager = \Elementor\Plugin::instance()->controls_manager;
		$control_manager->add_group_control( 'boostify-post', new Group_Control_Post() );
		$control_manager->add_group_control( 'boostify-product', new Group_Control_Product() );
	}

}
// Instantiate Boostify_Elementor_Addon Class.
Controls::instance();

