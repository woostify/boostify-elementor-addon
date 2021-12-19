<?php
/**
 * Admin Space.
 *
 * @since 1.0.0
 * @package Boostify Addon
 */

namespace Boostify_Elementor;

defined( 'ABSPATH' ) || exit;

/**
 * Main Admin Boostify Elementor Admin Class.
 *
 * @class Admin
 */
class Admin {

	/**
	 * Instance Class
	 *
	 * @var instance
	 */
	private static $instance;

	/**
	 * Class Boostify Elementor Addon Instance
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Admin Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$this->hooks();
	}

	/**
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function hooks() {
		add_action( 'admin_menu', array( $this, 'admin_register_menu' ), 62 );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_style' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'rest_api_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Register admin menu
	 *
	 * @since 1.0.0
	 * @access public
	 */
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

	/**
	 * Register admin style
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function load_admin_style() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_enqueue_style(
			'boostify-elementor-addon-style-admin',
			BOOSTIFY_ELEMENTOR_CSS . 'admin/style.css',
			array(),
			BOOSTIFY_ELEMENTOR_VER
		);

		wp_enqueue_script(
			'boostify-elementor-addon-admin',
			BOOSTIFY_ELEMENTOR_JS . 'admin/admin' . $suffix . '.js',
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

	/**
	 * Register admin settings
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_settings() {
		$data = boostify_list_widget();
		foreach ( $data as $widget_group ) {
			foreach ( $widget_group['widget'] as $widget ) {
				register_setting(
					'boostify_elementor_addon',
					$widget['name'],
					array(
						'type'              => 'string',
						'show_in_rest'      => true,
						'sanitize_callback' => 'sanitize_text_field',
					)
				);
			}
		}
	}

	/**
	 * Register admin settings page
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function setting_page() {
		$data = boostify_list_widget();
		?>

		<div class="boostify-elementor-addon-settings">
			<div class="boostify-elementor-settings-wrapper">
				<form method="post" action="options.php">
					<?php settings_fields( 'boostify_elementor_addon' ); ?>
					<div class="form-setting-header">
						<div class="header-left">
							<div class="logo">
								<img src="<?php echo esc_url( BOOSTIFY_ELEMENTOR_IMG . 'logo.png' ); ?>" alt="<?php echo esc_attr( 'Boostify Logo' ); ?>">
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

								<div class="lis-action-togle">
									<button class="btn-enable-widget btn-action"><?php echo esc_html__( 'Enable All', 'boostify' ); ?></button>
									<button class="btn-disable-widget btn-action"><?php echo esc_html__( 'Disable All', 'boostify' ); ?></button>
								</div>
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
													<?php
														$check = ( 'on' == get_option( $widget['name'] ) ) ? 'checked' : ''; //phpcs:ignore
													?>
													<div class="widget-item">
														<label><?php echo esc_html( $widget['label'] ); ?></label>
														<label class="widget-switch">
															<input type="checkbox" class="widget-check" name="<?php echo esc_attr( $widget['name'] ); ?>" <?php echo esc_attr( $check ); ?>>
															<span class="widget-slider round"></span>
														</label>
													</div>
												<?php endforeach ?>

											</div>
										</div>
									<?php endforeach ?>
									<?php do_action( 'boostify_addons_toggle' ); ?>
								</div>
							</div>
						</div>
					</div>

					<div class="form-button">
						<?php submit_button(); ?>
					</div>
				</form>
			</div>
		</div>
		<?php
	}
}

\Boostify_Elementor\Admin::instance();

