<?php
/**
 * Class Boostify_Elementor\Elementor
 *
 * Main Plugin
 * @since 1.0.0
 */

namespace Boostify_Elementor;

class Dynamic {
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
	 * @since 1.1.0
	 * @access public
	 */
	public function __construct() {
		$this->setup_hooks();
	}

	private function setup_hooks() {
		add_action( 'elementor/dynamic_tags/register_tags', array( $this, 'register_dymanic_tags' ) );
	}

	public function register_dymanic_tags( $dynamic_tags ) {
		\Elementor\Plugin::$instance->dynamic_tags->register_group(
			'boostify_addon',
			array(
				'title' => 'Boostify Addon',
			)
		);

		include BOOSTIFY_ELEMENTOR_DYNAMIC . 'tags/class-featured-image.php';

		$dynamic_tags->register_tag( 'Boostify_Elementor\Featured_Image' );
	}

}
// Instantiate Dynamic Class
Dynamic::instance();

