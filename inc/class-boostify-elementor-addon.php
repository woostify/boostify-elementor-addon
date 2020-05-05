<?php
/**
 * Class Boostify_Elementor\Elementor
 *
 * Main Plugin
 * @since 1.0.0
 */

class Boostify_Elementor_Addon {
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

		$this->include_files();
	}

	private function setup_hooks() {


	}

	protected function include_files() {
		include_once BOOSTIFY_ELEMENTOR_WIDGET . 'post/skin/class-layout.php';
		include_once BOOSTIFY_ELEMENTOR_WIDGET . 'class-widgets.php';
		include_once BOOSTIFY_ELEMENTOR_CONTROL . 'class-controls.php';
		include_once BOOSTIFY_ELEMENTOR_DYNAMIC . 'class-dynamic.php';
		include_once BOOSTIFY_ELEMENTOR_CORE . 'core.php';
		include_once BOOSTIFY_ELEMENTOR_CORE . 'hook.php';
		include_once BOOSTIFY_ELEMENTOR_CORE . 'template.php';
		include_once BOOSTIFY_ELEMENTOR_CORE . 'modules/class-global-breadcrumb.php';
	}

}
// Instantiate Boostify_Elementor_Addon Class
Boostify_Elementor_Addon::instance();

