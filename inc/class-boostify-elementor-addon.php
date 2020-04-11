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
	 * Register custom widget categories.
	 */
	public function add_elementor_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'boostify_addon',
			array(
				'title' => esc_html__( 'Boostify', 'boostify' ),
			)
		);
	}
	/**
	 * Widget Class
	 */
	public function get_widgets() {
		$widgets = array(
			'basic' => array(
				// 'Post_Grid',
				'Button',
			),
		);
		return $widgets;
	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_scripts() {
		$suffix = $this->suffix();
	}
	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function autoload_widgets() {
		$list_widget = $this->get_widgets();
		foreach ( $list_widget as $folder => $widgets ) {
			foreach ( $widgets as $widget ) {
				$filename = strtolower( $widget );
				$filename = str_replace( '_', '-', $filename );
				$filename = BOOSTIFY_ELEMENTOR_PATCH . 'inc/widgets/' . $folder . '/class-' . $filename . '.php';

				if ( is_readable( $filename ) ) {
					include $filename;
				}
			}
		}
	}

	/**
	 * Define Script debug.
	 *
	 * @return     string $suffix
	 */
	public function suffix() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		return $suffix;
	}


	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init_widgets() {
		$this->autoload_widgets();
		$list_widget = $this->get_widgets();
		// Its is now safe to include Widgets files
		$widget_manager = \Elementor\Plugin::instance()->widgets_manager;
		foreach ( $list_widget as $widgets ) {
			foreach ( $widgets as $widget ) {
				$class_name = 'Boostify_Elementor\Widgets\\' . $widget;
				$widget_manager->register_widget_type( new $class_name() );
			}
		}
	}

	public function style() {
		wp_enqueue_style(
			'boostify-addon-style',
			BOOSTIFY_ELEMENTOR_URL . 'assets/css/style.css',
			array(),
			BOOSTIFY_ELEMENTOR_VER
		);
	}

	private function setup_hooks() {
		// Register custom widget categories.
		add_action( 'elementor/elements/categories_registered', array( $this, 'add_elementor_widget_categories' ) );
		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'widget_scripts' ) );
		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_widgets' ) );
		add_action( 'elementor/init', array( $this, 'register_core' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'style' ), 99 );
	}

	public function register_core() {
		require BOOSTIFY_ELEMENTOR_PATCH . 'inc/core/class-base-widget.php';
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
}
// Instantiate Boostify_Elementor_Addon Class
Boostify_Elementor_Addon::instance();

