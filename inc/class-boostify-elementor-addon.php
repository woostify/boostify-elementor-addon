<?php
/**
 * Main Plugin Boostify Addon.
 *
 * @since 1.0.0
 * @package Boostify Addon
 */

/**
 * Boostify Elementor Addon.
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

		$this->include_files();
	}

	/**
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function setup_hooks() {
		add_action( 'wp_ajax_boostify_wp_login', array( $this, 'wp_login' ) );
		add_action( 'wp_ajax_nopriv_boostify_wp_login', array( $this, 'wp_login' ) );
	}

	/**
	 * Register file
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function include_files() {
		include_once BOOSTIFY_ELEMENTOR_WIDGET . 'post/skin/class-layout.php';
		include_once BOOSTIFY_ELEMENTOR_WIDGET . 'basic/skin/class-layout.php';
		include_once BOOSTIFY_ELEMENTOR_WIDGET . 'class-widgets.php';
		include_once BOOSTIFY_ELEMENTOR_CONTROL . 'class-controls.php';
		include_once BOOSTIFY_ELEMENTOR_DYNAMIC . 'class-dynamic.php';
		include_once BOOSTIFY_ELEMENTOR_CORE . 'core.php';
		include_once BOOSTIFY_ELEMENTOR_CORE . 'hook.php';
		include_once BOOSTIFY_ELEMENTOR_CORE . 'template.php';
		include_once BOOSTIFY_ELEMENTOR_CORE . 'widget.php';
		include_once BOOSTIFY_ELEMENTOR_CORE . 'modules/class-global-breadcrumb.php';
		include_once BOOSTIFY_ELEMENTOR_PATH . 'inc/admin/class-admin.php';
	}

	/**
	 * Ajax Login form
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	public function wp_login() {
		check_ajax_referer( 'boostify_wp_login_register', 'token' );
		$username     = isset( $_POST['user'] ) ? sanitize_text_field( $_POST['user'] ) : ''; //phpcs:ignore
		$password     = isset( $_POST['pass'] ) ? sanitize_text_field( $_POST['pass'] ) : ''; //phpcs:ignore
		$remember     = isset( $_POST['remember'] ) ? $_POST['remember'] : false; //phpcs:ignore

		$creds = array(
			'user_login'    => $username,
			'user_password' => $password,
			'remember'      => true,
		);

		$user = wp_signon( $creds, false );

		if ( is_wp_error( $user ) ) {
			$messages = array();

			if ( isset( $user->errors['invalid_email'][0] ) ) {
				$messages['invalid_email'] = $user->errors['invalid_email'][0];
			} elseif ( isset( $user->errors['invalid_username'][0] ) ) {
				$messages['invalid_username'] = $user->errors['invalid_username'][0];
			} elseif ( isset( $user->errors['incorrect_password'][0] ) ) {
				$messages['incorrect_password'] = $user->errors['incorrect_password'][0];
			} elseif ( isset( $user->errors['empty_password'][0] ) ) {
				$messages['empty_password'] = $user->errors['empty_password'][0];
			}
			wp_send_json_error( $messages );
		} else {
			wp_send_json_success();
			exit();
		}

	}

}
// Instantiate Boostify_Elementor_Addon Class.
Boostify_Elementor_Addon::instance();

