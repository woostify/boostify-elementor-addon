<?php
/**
 * Class Boostify_Elementor
 *
 * Main Plugin
 * @since 1.0.0
 */

namespace Boostify_Elementor;

class Widgets {
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
	}

	private function setup_hooks() {

		add_action( 'elementor/elements/categories_registered', array( $this, 'add_elementor_widget_categories' ) );

		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'widget_scripts' ) );

		add_action( 'elementor/preview/enqueue_scripts', array( $this, 'scripts_in_preview_mode' ) );

		add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_widgets' ) );

		add_action( 'elementor/init', array( $this, 'register_core' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'style' ), 99 );

		add_action( 'elementor/init', array( $this, 'elementor_loaded' ) );

		add_action( 'elementor/editor/wp_head', array( $this, 'enqueue_icon' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_icon' ) );

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
				'Button',
			),
			'post'  => array(
				'Post_Grid',
				'Post_List',
				'Post_Slider',
				'Breadcrumb',
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

		wp_register_script(
			'isotope',
			BOOSTIFY_ELEMENTOR_JS . 'isotope' . $suffix . '.js',
			array( 'jquery' ),
			BOOSTIFY_ELEMENTOR_VER,
			true
		);

		wp_register_script(
			'masonry',
			BOOSTIFY_ELEMENTOR_JS . 'masonry' . $suffix . '.js',
			array( 'jquery' ),
			BOOSTIFY_ELEMENTOR_VER,
			true
		);

		$admin_vars = array(
			'url'   => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'boostify_post_nonce' ),
		);

		wp_localize_script(
			'boostify-addon-post-grid',
			'admin',
			$admin_vars
		);

		wp_register_script(
			'boostify-addon-post-grid',
			BOOSTIFY_ELEMENTOR_JS . 'posts/post-grid' . $suffix . '.js',
			array( 'jquery', 'masonry' ),
			BOOSTIFY_ELEMENTOR_VER,
			true
		);

		wp_register_script(
			'swiper',
			BOOSTIFY_ELEMENTOR_JS . 'swiper.min.js',
			array(),
			BOOSTIFY_ELEMENTOR_VER,
			true
		);

		wp_register_script(
			'boostify-addon-post-slider',
			BOOSTIFY_ELEMENTOR_JS . 'posts/post-slider' . $suffix . '.js',
			array( 'jquery', 'swiper' ),
			BOOSTIFY_ELEMENTOR_VER,
			true
		);
	}


	public function scripts_in_preview_mode() {
		$suffix = $this->suffix();
		wp_enqueue_script(
			'boostify-addon-elementor-preview',
			BOOSTIFY_ELEMENTOR_JS . 'preview' . $suffix . '.js',
			array(
				'jquery',
				'masonry',
			),
			BOOSTIFY_ELEMENTOR_VER,
			true
		);

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
				$filename = BOOSTIFY_ELEMENTOR_WIDGET . $folder . '/class-' . $filename . '.php';

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
			BOOSTIFY_ELEMENTOR_CSS . 'style.css',
			array(),
			BOOSTIFY_ELEMENTOR_VER
		);

		wp_enqueue_style(
			'slick-theme',
			BOOSTIFY_ELEMENTOR_CSS . 'slick-theme.css',
			array(),
			BOOSTIFY_ELEMENTOR_VER
		);

		wp_enqueue_style(
			'swiper',
			BOOSTIFY_ELEMENTOR_CSS . 'swiper.min.css',
			array(),
			BOOSTIFY_ELEMENTOR_VER
		);
	}

	public function enqueue_icon() {
		wp_enqueue_style(
			'boostify-font',
			BOOSTIFY_ELEMENTOR_CSS . 'boostify-font.css',
			array(),
			BOOSTIFY_ELEMENTOR_VER
		);

		wp_enqueue_style(
			'boostify-elementor-editer',
			BOOSTIFY_ELEMENTOR_CSS . 'elementor-editer.css',
			array(),
			BOOSTIFY_ELEMENTOR_VER
		);
	}

	public function register_core() {
		include_once BOOSTIFY_ELEMENTOR_WIDGET . 'class-base-widget.php';
		include_once BOOSTIFY_ELEMENTOR_WIDGET . 'post/base/class-posts.php';
		include_once BOOSTIFY_ELEMENTOR_WIDGET . 'post/base/class-post-base.php';
		include_once BOOSTIFY_ELEMENTOR_WIDGET . 'post/base/class-global-breadcrumb.php';
	}


	public function elementor_loaded() {
		new \Boostify_Elementor\Posts\Skin\Layout();
	}

}
// Instantiate Boostify_Elementor_Addon Class
Widgets::instance();

