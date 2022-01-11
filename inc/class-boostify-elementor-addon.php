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
	 * Email option
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $email_option = array();

	/**
	 * Custom Email user
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $email_user_custom = false;

	/**
	 * Custom Email admin
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $email_admin_custom = false;

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
		add_action( 'wp_ajax_boostify_wp_register', array( $this, 'wp_register' ) );
		add_action( 'wp_ajax_nopriv_boostify_wp_register', array( $this, 'wp_register' ) );
		add_filter( 'wp_new_user_notification_email', array( $this, 'new_user_notification_email' ), 10, 3 );
		add_filter( 'wp_new_user_notification_email_admin', array( $this, 'new_user_notification_email_admin' ), 10, 3 );
		add_action( 'wp_enqueue_scripts', array( $this, 'dashicons_front_end' ) );
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
		if ( is_user_logged_in() ) {
			$messages['logged_in'] = __( 'You are already logged in.', 'boostify' );

			wp_send_json_error( $messages );
			exit();

		}
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
			} else {
				$messages['error'] = __( 'Opp! Something when wrong.' );
			}
			wp_send_json_error( $messages );
		} else {
			wp_send_json_success();
			exit();
		}

	}

	/**
	 * Ajax Register form
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	public function wp_register() {
		check_ajax_referer( 'boostify_wp_login_register', 'token' );
		$username                 = isset( $_POST['username'] ) ? sanitize_text_field( $_POST['username'] ) : ''; //phpcs:ignore
		$password                 = isset( $_POST['password'] ) ? sanitize_text_field( $_POST['password'] ) : false; //phpcs:ignore
		$confirm_pass             = isset( $_POST['confirm_password'] ) ? sanitize_text_field( $_POST['confirm_password'] ) : false; //phpcs:ignore
		$email                    = isset( $_POST['email'] ) ? $_POST['email'] : ''; //phpcs:ignore
		$first_name               = isset( $_POST['first_name'] ) ? sanitize_text_field( $_POST['first_name'] ) : false; //phpcs:ignore
		$last_name                = isset( $_POST['last_name'] ) ? sanitize_text_field( $_POST['last_name'] ) : false; //phpcs:ignore
		$website                  = isset( $_POST['website'] ) ? esc_url_raw( $_POST['website'] ) : false; //phpcs:ignore
		$role                     = isset( $_POST['role'] ) ? sanitize_text_field( $_POST['role'] ) : false; //phpcs:ignore
		$action                   = isset( $_POST['action_reg'] ) ? explode( ',', $_POST['action_reg'] ) : false; //phpcs:ignore
		$default_role             = get_option( 'default_role' );
		$allowed                  = get_option( 'users_can_register' );
		$generated_pass           = $password ? true : false;
		$admin_email_subject      = isset( $_POST['admin_email_subject'] ) ? $_POST['admin_email_subject'] : false; //phpcs:ignore
		$admin_email_message      = isset( $_POST['admin_email_message'] ) ? $_POST['admin_email_message'] : false; //phpcs:ignore
		$admin_email_content_type = isset( $_POST['admin_email_content_type'] ) ? $_POST['admin_email_content_type'] : false; //phpcs:ignore
		$email_subject            = isset( $_POST['email_subject'] ) ? $_POST['email_subject'] : false; //phpcs:ignore
		$email_message            = isset( $_POST['email_message'] ) ? $_POST['email_message'] : false; //phpcs:ignore
		$email_content_type       = isset( $_POST['email_content_type'] ) ? $_POST['email_content_type'] : false; //phpcs:ignore

		if ( ! $username ) {
			$messages['username_required'] = __( 'Username is required.', 'boostify' );
		}

		if ( ! $email ) {
			$messages['email_required'] = __( 'Email is required.', 'boostify' );
		}

		if ( $admin_email_content_type && in_array( 'send_email', $action ) ) { //phpcs:ignore
			self::$email_option['email_admin_custom'] = true;
		}

		if ( $email_content_type  && in_array( 'send_email', $action ) ) { //phpcs:ignore
			self::$email_option['email_user_custom'] = true;
		}

		if ( $admin_email_subject ) {
			self::$email_option['admin_subject'] = $admin_email_subject;
		}
		if ( $admin_email_message ) {
			self::$email_option['admin_message'] = $admin_email_message;
		}
		if ( $admin_email_content_type ) {
			self::$email_option['admin_headers'] = 'Content-Type: text/' . $admin_email_content_type . '; charset=UTF-8' . "\r\n";
		}

		if ( $email_subject ) {
			self::$email_option['subject'] = $email_subject;
		}
		if ( $email_message ) {
			self::$email_option['message'] = $email_message;
		}
		if ( $email_content_type ) {
			self::$email_option['headers'] = 'Content-Type: text/' . $email_content_type . '; charset=UTF-8' . "\r\n";
		}

		if ( is_user_logged_in() ) {
			$messages['logged_in'] = __( 'You are already logged in.', 'boostify' );

			wp_send_json_error( $messages );
		}

		do_action( 'boostify_before_register' );

		if ( ! $allowed ) {
			$messages['registration'] = __( 'Registration is closed on this site', 'boostify' );
			wp_send_json_error( $messages );
		}

		if ( ! validate_username( $username ) || mb_strlen( $username ) > 60 ) {
			$messages['username'] = __( 'Invalid username provided.', 'boostify' );
			wp_send_json_error( $messages );
		} elseif ( username_exists( $username ) ) {
			$messages['username_registered'] = __( 'The username already registered.', 'boostify' );
			wp_send_json_error( $messages );
		}

		if ( ! is_email( $email ) ) {
			$messages['email_format'] = __( 'Please enter correct email format.', 'boostify' );
		}

		if ( email_exists( $email ) ) {
			$messages['email'] = __( 'The provided email is already registered with other account. Please login or reset password or use another email.', 'boostify' );
		}

		if ( $confirm_pass && $pass && $confirm_pass !== $password ) {
			$messages['confirm_password'] = __( 'The confirmed password did not match.', 'boostify' );
			wp_send_json_error( $messages );
		}

		if ( ! $password ) {
			$password = wp_generate_password();
		}

		$user_data = array(
			'user_login' => $username,
			'user_pass'  => $password,
			'user_email' => $email,
			'role'       => $default_role,
		);

		if ( $website ) {
			$user_data['website'] = $website;
		}

		if ( $first_name ) {
			$user_data['first_name'] = $website;
		}

		if ( $last_name ) {
			$user_data['last_name'] = $website;
		}

		if ( $role ) {
			$user_data['role'] = $role;
		}

		$user_id = wp_insert_user( $user_data );

		do_action( 'boostify_after_create_user', $user_id, $user_data );

		if ( is_wp_error( $user_id ) ) {
			$messages['user_create'] = __( 'Sorry, something went wrong. User could not be registered.', 'boostify' );
			wp_send_json_error( $messages );
		}

		if ( $generated_pass ) {
			update_user_option( $user_id, 'default_password_nag', true, true );
			$user = get_user_by( 'id', $user_id );
			$key  = get_password_reset_key( $user );
			if ( ! is_wp_error( $key ) ) {
				self::$email_option['password_reset_link'] = network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user->user_login ), 'login' ) . "\r\n\r\n";
			}
		}

		do_action( 'register_new_user', $user_id );
		$notify = ( $generated_pass || in_array( 'send_email', $register_actions ) ) ? 'both' : 'admin'; //phpcs:ignore
		wp_new_user_notification( $user_id, null, $notify );

		if ( in_array( 'auto_login', $action ) && ! is_user_logged_in() ) { //phpcs:ignore
			wp_signon(
				array(
					'user_login'    => $username,
					'user_password' => $password,
					'remember'      => true,
				)
			);
		}

		wp_send_json_success();
	}

	/**
	 * Filters the contents of the new user notification email sent to the new user.
	 *
	 * @since 1.0.0
	 *
	 * @param array   $email_data Email daa array.
	 * @param WP_User $user     User object for new user.
	 * @param string  $blogname The site title.
	 */
	public function new_user_notification_email( $email_data, $user, $blogname ) {
		if ( ! self::$email_user_custom ) {
			return $email_data;
		}

		if ( ! empty( self::$email_option['subject'] ) ) {
			$email_data['subject'] = self::$email_option['subject'];
		}

		if ( ! empty( self::$email_option['message'] ) ) {
			$email_data['message'] = $this->replace_placeholders( self::$email_option['message'], 'user' );
		}

		if ( ! empty( self::$email_option['headers'] ) ) {
			$email_data['headers'] = self::$email_option['headers'];
		}

		return apply_filters( 'boostify_register_new_user_email_data', $email_data, $user, $blogname );

	}

	/**
	 * Filters the contents of the new user notification email sent to the site admin.
	 *
	 * @since 1.0.0
	 *
	 * @param array   $email_data Email daa array.
	 * @param WP_User $user     User object for new user.
	 * @param string  $blogname The site title.
	 */
	public function new_user_notification_email_admin( $email_data, $user, $blogname ) {

		if ( ! self::$send_custom_email_admin ) {
			return $email_data;
		}

		if ( ! empty( self::$email_option['admin_subject'] ) ) {
			$email_data['subject'] = self::$email_option['admin_subject'];
		}

		if ( ! empty( self::$email_option['admin_message'] ) ) {
			$email_data['message'] = $this->replace_placeholders( self::$email_option['admin_message'], 'admin' );
		}

		if ( ! empty( self::$email_option['admin_headers'] ) ) {
			$email_data['headers'] = self::$email_option['admin_headers'];
		}

		return apply_filters( 'boostify_register_new_user_email_data_admin', $email_data, $user, $blogname );
	}

	/**
	 * It replaces  return data.
	 *
	 * @param string $message Custom message.
	 * @param string $receiver Receiver admin|user.
	 */
	private function replace_value( $message, $receiver = 'user' ) {
		$placeholders = array(
			'/\[password\]/',
			'/\[password_reset_link\]/',
			'/\[username\]/',
			'/\[email\]/',
			'/\[firstname\]/',
			'/\[lastname\]/',
			'/\[website\]/',
			'/\[loginurl\]/',
			'/\[sitetitle\]/',
		);
		$replacement  = array(
			self::$email_option['password'],
			self::$email_option['password_reset_link'],
			self::$email_option['username'],
			self::$email_option['email'],
			self::$email_option['firstname'],
			self::$email_option['lastname'],
			self::$email_option['website'],
			wp_login_url(),
			get_option( 'blogname' ),
		);

		if ( 'user' !== $receiver ) {
			unset( $placeholders[0] );
			unset( $placeholders[1] );
			unset( $replacement[0] );
			unset( $replacement[1] );
		}

		return preg_replace( $placeholders, $replacement, $message );
	}

	public function dashicons_front_end() {
		wp_enqueue_style( 'dashicons' );
	}

}
// Instantiate Boostify_Elementor_Addon Class.
Boostify_Elementor_Addon::instance();

