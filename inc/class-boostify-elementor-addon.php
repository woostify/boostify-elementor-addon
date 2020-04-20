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

		add_action( 'elementor/elements/categories_registered', array( $this, 'add_elementor_widget_categories' ) );

		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'widget_scripts' ) );

		add_action( 'elementor/preview/enqueue_scripts', array( $this, 'scripts_in_preview_mode' ) );

		add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_widgets' ) );
		add_action( 'elementor/init', array( $this, 'register_core' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'style' ), 99 );

		add_action( 'elementor/init', array( $this, 'elementor_loaded' ) );

		add_action( 'elementor/editor/wp_head', array( $this, 'enqueue_icon' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_icon' ) );

		add_action( 'elementor/controls/controls_registered', array( $this, 'register_controls' ) );

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
			BOOSTIFY_ELEMENTOR_URL . 'assets/js/isotope' . $suffix . '.js',
			array( 'jquery' ),
			BOOSTIFY_HEADER_FOOTER_VER,
			true
		);

		wp_register_script(
			'masonry',
			BOOSTIFY_ELEMENTOR_URL . 'assets/js/masonry' . $suffix . '.js',
			array( 'jquery' ),
			BOOSTIFY_HEADER_FOOTER_VER,
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
			BOOSTIFY_ELEMENTOR_URL . 'assets/js/posts/post-grid' . $suffix . '.js',
			array( 'jquery', 'masonry' ),
			BOOSTIFY_HEADER_FOOTER_VER,
			true
		);

		wp_register_script(
			'slick',
			BOOSTIFY_ELEMENTOR_URL . 'assets/js/slick' . $suffix . '.js',
			array( 'jquery' ),
			BOOSTIFY_HEADER_FOOTER_VER,
			true
		);

		wp_register_script(
			'swiper',
			BOOSTIFY_ELEMENTOR_URL . 'assets/js/swiper.min.js',
			array(),
			BOOSTIFY_HEADER_FOOTER_VER,
			true
		);

		// wp_register_script(
		// 	'boostify-addon-post-slider',
		// 	BOOSTIFY_ELEMENTOR_URL . 'assets/js/posts/post-slider' . $suffix . '.js',
		// 	array( 'jquery', 'slick' ),
		// 	BOOSTIFY_HEADER_FOOTER_VER,
		// 	true
		// );

		wp_register_script(
			'boostify-addon-post-slider',
			BOOSTIFY_ELEMENTOR_URL . 'assets/js/posts/post-slider' . $suffix . '.js',
			array( 'jquery', 'swiper' ),
			BOOSTIFY_HEADER_FOOTER_VER,
			true
		);
	}


	public function scripts_in_preview_mode() {
		$suffix = $this->suffix();
		wp_enqueue_script(
			'boostify-addon-elementor-preview',
			BOOSTIFY_ELEMENTOR_URL . '/assets/js/preview' . $suffix . '.js',
			array(
				'jquery',
				'masonry',
			),
			BOOSTIFY_HEADER_FOOTER_VER,
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
				$filename = BOOSTIFY_ELEMENTOR_PATH . 'inc/widgets/' . $folder . '/class-' . $filename . '.php';

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

		wp_enqueue_style(
			'slick-theme',
			BOOSTIFY_ELEMENTOR_URL . 'assets/css/slick-theme.css',
			array(),
			BOOSTIFY_ELEMENTOR_VER
		);

		wp_enqueue_style(
			'slick',
			BOOSTIFY_ELEMENTOR_URL . 'assets/css/slick.css',
			array(),
			BOOSTIFY_ELEMENTOR_VER
		);

		wp_enqueue_style(
			'swiper',
			BOOSTIFY_ELEMENTOR_URL . 'assets/css/swiper.min.css',
			array(),
			BOOSTIFY_ELEMENTOR_VER
		);
	}

	public function enqueue_icon() {
		wp_enqueue_style(
			'boostify-font',
			BOOSTIFY_ELEMENTOR_URL . '/assets/css/boostify-font.css',
			array(),
			BOOSTIFY_ELEMENTOR_VER
		);

		wp_enqueue_style(
			'boostify-elementor-editer',
			BOOSTIFY_ELEMENTOR_URL . '/assets/css/elementor-editer.css',
			array(),
			BOOSTIFY_ELEMENTOR_VER
		);
	}

	public function register_core() {
		include_once BOOSTIFY_ELEMENTOR_PATH . 'inc/core/class-base-widget.php';
		include_once BOOSTIFY_ELEMENTOR_PATH . 'inc/widgets/post/base/class-posts.php';
		include_once BOOSTIFY_ELEMENTOR_PATH . 'inc/widgets/post/base/class-post-base.php';
	}

	public function register_controls() {
		include_once BOOSTIFY_ELEMENTOR_PATH . 'inc/control/class-group-control-post.php';
		$control_manager = \Elementor\Plugin::instance()->controls_manager;
		$control_manager->add_group_control( 'boostify-post', new Boostify_Elementor\Group_Control_Post() );
	}

	public function include_files() {
		include_once BOOSTIFY_ELEMENTOR_PATH . 'inc/core/core.php';
		include_once BOOSTIFY_ELEMENTOR_PATH . 'inc/core/hook.php';
		include_once BOOSTIFY_ELEMENTOR_PATH . 'inc/core/template.php';
		include_once BOOSTIFY_ELEMENTOR_PATH . 'inc/widgets/post/skin/class-layout.php';
	}


	public function elementor_loaded() {
		new \Boostify_Elementor\Posts\Layout();
	}

}
// Instantiate Boostify_Elementor_Addon Class
Boostify_Elementor_Addon::instance();

