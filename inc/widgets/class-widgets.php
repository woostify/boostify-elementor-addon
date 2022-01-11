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

	/**
	 * Widget setup hooks
	 */
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
	 *
	 * @param (object) $elements_manager | Object elementor manager.
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
		$list_widget = boostify_list_widget();
		$widgets     = array();
		foreach ( $list_widget as $folder => $widget_group ) {
			foreach ( $widget_group['widget'] as $widget ) {
				$active = get_option( $widget['name'] );
				if ( 'on' == $active ) { //phpcs:ignore
					$widgets[ $folder ][] = $widget['key'];
				}
			}
		}

		return $widgets;
	}

	/**
	 * Widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function widget_scripts() {
		$suffix                 = $this->suffix();
		$recaptcha_sitekey      = get_option( 'boostify_recaptcha_site_key' );
		$recaptcha_secretkey    = get_option( 'boostify_recaptcha_secret_key' );
		$recaptcha_sitekey_v3   = get_option( 'boostify_recaptcha_v3_site_key' );
		$recaptcha_secretkey_v3 = get_option( 'boostify_recaptcha_v3_secret_key' );
		$recaptcha              = ( ! empty( $recaptcha_sitekey ) && ! empty( $recaptcha_sitekey ) ) ? true : false;
		$recaptchav3            = ( ! empty( $recaptcha_sitekey_v3 ) && ! empty( $recaptcha_secretkey_v3 ) ) ? true : false;
		$recaptcha_script       = array( 'jquery', 'google-recaptcha' );

		if ( $recaptchav3 ) {
			$recaptcha_sitekey = $recaptcha_sitekey_v3;
		}
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
			'lightgallery',
			BOOSTIFY_ELEMENTOR_JS . 'lightgallery.min.js',
			array( 'jquery' ),
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
			'html5lightbox',
			BOOSTIFY_ELEMENTOR_JS . 'html5lightbox/html5lightbox.js',
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

		wp_register_script(
			'boostify-addon-faq',
			BOOSTIFY_ELEMENTOR_JS . 'base/faq' . $suffix . '.js',
			array( 'jquery' ),
			BOOSTIFY_ELEMENTOR_VER,
			true
		);

		wp_register_script(
			'boostify-addon-testimonial',
			BOOSTIFY_ELEMENTOR_JS . 'base/testimonial' . $suffix . '.js',
			array( 'jquery', 'swiper' ),
			BOOSTIFY_ELEMENTOR_VER,
			true
		);

		wp_register_script(
			'boostify-video-popup',
			BOOSTIFY_ELEMENTOR_JS . 'base/video-popup' . $suffix . '.js',
			array( 'jquery', 'html5lightbox' ),
			BOOSTIFY_ELEMENTOR_VER,
			true
		);

		wp_register_script(
			'boostify-addon-toc',
			BOOSTIFY_ELEMENTOR_JS . 'base/toc' . $suffix . '.js',
			array( 'jquery' ),
			BOOSTIFY_ELEMENTOR_VER,
			true
		);

		wp_register_script(
			'google-recaptcha',
			'https://www.google.com/recaptcha/api.js?render=' . $recaptcha_sitekey,
			array( 'jquery' ),
			BOOSTIFY_ELEMENTOR_VER,
			true
		);

		wp_register_script(
			'boostify-addon-login-register',
			BOOSTIFY_ELEMENTOR_JS . 'base/login-register' . $suffix . '.js',
			$recaptcha_script,
			BOOSTIFY_ELEMENTOR_VER,
			true
		);

		$admin_vars = array(
			'url'               => admin_url( 'admin-ajax.php' ),
			'nonce'             => wp_create_nonce( 'boostify_wp_login_register' ),
			'recaptcha_sitekey' => $recaptcha_sitekey,
			'validate'          => array(
				'user'  => __( 'Username is required!' ),
				'pass'  => __( 'Password is required!' ),
				'email' => __( 'Email is required!' ),
			),
		);

		wp_localize_script(
			'boostify-addon-login-register',
			'admin',
			$admin_vars
		);

	}


	/**
	 * Scripts in preview mode
	 *
	 * Load widgets files
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function scripts_in_preview_mode() {
		$suffix = $this->suffix();
		wp_enqueue_script(
			'boostify-addon-elementor-preview',
			BOOSTIFY_ELEMENTOR_JS . 'preview' . $suffix . '.js',
			array(
				'jquery',
				'masonry',
				'html5lightbox',
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

		wp_enqueue_style(
			'ionicons',
			BOOSTIFY_ELEMENTOR_CSS . 'ionicons.css',
			array(),
			BOOSTIFY_ELEMENTOR_VER
		);
	}

	public function register_core() {
		include_once BOOSTIFY_ELEMENTOR_WIDGET . 'class-base-widget.php';
		include_once BOOSTIFY_ELEMENTOR_WIDGET . 'post/base/class-posts.php';
		include_once BOOSTIFY_ELEMENTOR_WIDGET . 'post/base/class-post-base.php';
	}


	public function elementor_loaded() {
		new \Boostify_Elementor\Posts\Skin\Layout();
		new \Boostify_Elementor\Basic\Skin\Layout();
	}

}
// Instantiate Boostify_Elementor_Addon Class
Widgets::instance();

