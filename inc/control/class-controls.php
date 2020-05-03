<?php
/**
 * Class Boostify_Elementor\Elementor
 *
 * Main Plugin
 * @since 1.0.0
 */

namespace Boostify_Elementor;

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


	private $modules_manager;
	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
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
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {
		$this->setup_hooks();
	}

	private function setup_hooks() {
		add_action( 'elementor/controls/controls_registered', array( $this, 'register_controls' ) );
	}

	public function register_controls() {
		include_once BOOSTIFY_ELEMENTOR_CONTROL . 'class-group-control-post.php';
		$control_manager = \Elementor\Plugin::instance()->controls_manager;
		$control_manager->add_group_control( 'boostify-post', new Group_Control_Post() );
	}

}
// Instantiate Boostify_Elementor_Addon Class
Controls::instance();

