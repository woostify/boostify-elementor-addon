<?php

namespace Boostify_Elementor;

defined( 'ABSPATH' ) || exit;

/**
 * Main Boostify Elementor Admin Class.
 *
 * @class Admin
 */

class Admin {


	private static $instance;


	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Wanderlust Constructor.
	 */
	public function __construct() {
		$this->hooks();
	}

	public function hooks() {
		add_action( 'admin_menu', array( $this, 'admin_register_menu' ), 62 );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_style' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'rest_api_init', array( $this, 'register_settings' ) );
	}

	// Register Page Setting
	public function admin_register_menu() {
		// Filter to remove Admin menu.
		add_menu_page(
			'Boostify Addon',
			'Boostify Addon',
			'manage_options',
			'boostify_elementor_addon',
			array( $this, 'setting_page' ),
			'dashicons-list-view',
			6
		);
	}

	// Register Tour Settings
	public function load_admin_style() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_enqueue_style(
			'boostify-elementor-addon-style-admin',
			BOOSTIFY_ELEMENTOR_CSS . 'admin/style.css',
			array(),
			BOOSTIFY_ELEMENTOR_VER
		);

		wp_enqueue_script(
			'boostify-admin-child-theme-generator',
			BOOSTIFY_ELEMENTOR_CSS . 'admin/js/generator' . $suffix . '.js',
			array( 'jquery' ),
			BOOSTIFY_ELEMENTOR_VER,
			true
		);

		$admin_vars = array(
			'url'   => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'generator_nonce' ),
		);

		wp_localize_script(
			'boostify-admin-child-theme-generator',
			'admin',
			$admin_vars
		);
	}

	public function register_settings() {
		register_setting(
			'boostify_elementor_addon',
			'list_theme',
			array(
				'type'              => 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		register_setting(
			'boostify_elementor_addon',
			'show_list_theme',
			array(
				'type'              => 'string',
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
	}

	public function list_widget() {
		$list_widget = array(
			'basic' => array(
				'label'  => __( 'General', 'boostify' ),
				'value'  => 'base',
				'widget' => array(
					array(
						'key'   => 'Button',
						'name'  => 'button',
						'label' => __( 'Button', 'boostify' ),
					),
				)
			),
			'post' => array(
				'label'  => __( 'Post', 'boostify' ),
				'value'  => 'post',
				'widget' => array(
					array(
						'key'   => 'Post_Grid',
						'name'  => 'Post_Grid',
						'label' => __( 'Post Grid', 'boostify' ),
					),
					array(
						'key'   => 'Post_List',
						'name'  => 'button',
						'label' => __( 'Post List', 'boostify' ),
					),
					array(
						'key'   => 'Post_Slider',
						'name'  => 'button',
						'label' => __( 'Post Slider', 'boostify' ),
					),
					array(
						'key'   => 'Breadcrumb',
						'name'  => 'button',
						'label' => __( 'Breadcrumb', 'boostify' ),
					),
				)
			),
		);

		return $list_widget;
	}

	public function setting_page() {
		$data = $this->list_widget();
		?>

		<div class="boostify-elementor-addon-settings">
			<div class="boostify-elementor-settings-wrapper">
				<form method="post" action="options.php">
					<div class="form-setting-header">
						<div class="header-left">
							<div class="logo">
								<img src="<?php echo esc_url( BOOSTIFY_ELEMENTOR_IMG . 'logo.png' ) ?>" alt="<?php echo esc_attr( 'Boostify Logo' ); ?>">
							</div>
							<h2 class="title"><?php echo esc_html__( 'Boostify Elementor Addons Settings', 'boostify' ); ?></h2>
						</div>
						<div class="header-right">
							<?php submit_button(); ?>
						</div>
					</div>

					<div class="form-setting-content">
						<div class="form-content-wrapper">
							<div class="form-content-header">
								<h2 class="title-content-header"><?php echo esc_html__( 'GLOBAL CONTROL', 'boostify' ); ?></h2>
							</div>
							<div class="form-content-setting">
								<div class="list-widget-setting">
									<?php foreach ( $data as $widget_group ) : ?>
										<div class="widget-group">
											<div class="group-title">
												<h3 class="title" data-title="<?php echo esc_attr( $widget_group['value'] ); ?>"><?php echo esc_html( $widget_group['label'] ); ?></h3>
											</div>
											<div class="form-widget-group">
												<?php foreach ( $widget_group['widget'] as $widget ) : ?>
													<div class="widget-item">
														<label><?php echo esc_html( $widget['label'] ); ?></label>
														<label class="widget-switch">
															<input type="checkbox" class="widget-check" name="<?php echo esc_attr( $widget['name'] ); ?>">
															<span class="widget-slider round"></span>
														</label>
													</div>
												<?php endforeach ?>
											</div>
										</div>
									<?php endforeach ?>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php
	}


}

\Boostify_Elementor\Admin::instance();

