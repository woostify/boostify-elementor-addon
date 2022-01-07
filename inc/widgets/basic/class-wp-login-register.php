<?php
/**
 * Widget WP Login Register.
 *
 * @since 1.0.0
 * @package Boostify Addon
 */

namespace Boostify_Elementor\Widgets;

use Boostify_Elementor\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Utils;

/**
 * Class WP_Login_Register
 */
class WP_Login_Register extends Base_Widget {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 *
	 * @return string Widget Name.
	 */
	public function name() {
		return 'wp-login-register';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Login | Register Form', 'boostify' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'boostify eicon-lock-user';
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return array( 'google-recaptcha-v3', 'boostify-addon-login-register' );
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_content_general',
			array(
				'label' => __( 'General', 'boostify' ),
			)
		);

		$this->add_control(
			'type',
			array(
				'label'   => __( 'Default Form Type', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'login'    => __( 'Login', 'boostify' ),
					'register' => __( 'Registration', 'boostify' ),
				),
				'default' => 'login',
			)
		);

		if ( ! boostify_users_can_register() ) {
			$this->add_control(
				'registration_off_notice',
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( 'Registration is disabled on your site. Please enable it to use registration form. You can enable it from Dashboard » Settings » General » %1$sMembership%2$s.', 'boostify' ), '<a href="' . esc_attr( esc_url( admin_url( 'options-general.php' ) ) ) . '" target="_blank">', '</a>' ), //phpcs:ignore
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
					'condition'       => array(
						'type' => 'register',
					),
				)
			);
		}

		$this->add_control(
			'hide_for_logged_in_user',
			array(
				'label'       => __( 'Hide all forms from logged-in users', 'boostify' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
				'show_label'  => true,
				'label_block' => true,
			)
		);

		$this->add_control(
			'gen_lgn_content_po_toggle',
			array(
				'label'        => __( 'Login Form General', 'boostify' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Controls', 'boostify' ),
				'label_on'     => __( 'Custom', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'type' => 'login',
				),
			)
		);

		$this->start_popover();

		$this->add_control(
			'show_logout',
			array(
				'label'   => __( 'Show Logout Link', 'boostify' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'show_forgot_password',
			array(
				'label'   => __( 'Show Lost your password?', 'boostify' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'forgot_password_text',
			array(
				'label'       => __( 'Forgot Password Text', 'boostify' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => __( 'Forgot password?', 'boostify' ),
				'condition'   => array(
					'show_forgot_password' => 'yes',
				),
			)
		);

		$this->add_control(
			'lost_password_link_type',
			array(
				'label'       => __( 'Lost Password Link to', 'boostify' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'default' => __( 'Default WordPress Page', 'boostify' ),
					'custom'  => __( 'Custom URL', 'boostify' ),
				),
				'default'     => 'default',
				'condition'   => array(
					'show_forgot_password' => 'yes',
				),
			)
		);

		$this->add_control(
			'lost_password_url',
			array(
				'label'         => __( 'Custom Lost Password URL', 'boostify' ),
				'label_block'   => true,
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'dynamic'       => array(
					'active' => true,
				),
				'condition'     => array(
					'lost_password_link_type' => 'custom',
					'show_forgot_password'    => 'yes',
				),
			)
		);

		$this->add_control(
			'login_show_remember_me',
			array(
				'label'     => __( 'Remember Me Field', 'boostify' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_off' => __( 'Hide', 'boostify' ),
				'label_on'  => __( 'Show', 'boostify' ),
			)
		);

		$this->add_control(
			'remember_text',
			array(
				'label'       => __( 'Remember Me Field Text', 'boostify' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => __( 'Remember Me', 'boostify' ),
				'condition'   => array(
					'login_show_remember_me' => 'yes',
				),
			)
		);

		if ( boostify_users_can_register() ) {
			$this->add_control(
				'reg_hr',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$this->add_control(
				'show_register_link',
				array(
					'label'     => __( 'Show Register Link', 'boostify' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'separator' => 'before',
				)
			);

			$this->add_control(
				'registration_link_text',
				array(
					'label'       => __( 'Register Link Text', 'boostify' ),
					'label_block' => true,
					'description' => __( 'You can put text in two lines to make the last line linkable. Pro Tip: You can keep the first line empty and put the text only in the second line to get a link only.', 'boostify' ),
					'type'        => Controls_Manager::TEXTAREA,
					'rows'        => 2,
					'dynamic'     => array(
						'active' => true,
					),
					'default'     => __( 'Register Now', 'boostify' ),
					'condition'   => array(
						'show_register_link' => 'yes',
					),
				)
			);

			$this->add_control(
				'registration_link_action',
				array(
					'label'       => __( 'Registration Link Action', 'boostify' ),
					'label_block' => true,
					'type'        => Controls_Manager::SELECT,
					'options'     => array(
						'default' => __( 'WordPress Registration Page', 'boostify' ),
						'custom'  => __( 'Custom URL', 'boostify' ),
						'form'    => __( 'Show Register Form', 'boostify' ),
					),
					'default'     => 'form',
					'condition'   => array(
						'show_register_link' => 'yes',
					),
				)
			);

			$this->add_control(
				'custom_register_url',
				array(
					'label'         => __( 'Custom Register URL', 'boostify' ),
					'label_block'   => true,
					'type'          => Controls_Manager::URL,
					'show_external' => false,
					'dynamic'       => array(
						'active' => true,
					),
					'condition'     => array(
						'registration_link_action' => 'custom',
						'show_register_link'       => 'yes',
					),
				)
			);
		} else {
			$this->add_control(
				'show_register_link',
				array(
					'label'     => __( 'Show Register Link', 'boostify' ),
					'type'      => Controls_Manager::HIDDEN,
					'default'   => 'no',
					'separator' => 'before',
				)
			);
		}
		$this->add_control(
			'enable_login_recaptcha',
			array(
				'label'        => __( 'Enable Google reCAPTCHA', 'boostify' ),
				'description'  => __( 'reCAPTCHA will prevent spam login from bots.', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'boostify' ),
				'label_off'    => __( 'No', 'boostify' ),
				'return_value' => 'yes',
			)
		);
		if ( empty( $this->recaptcha_sitekey ) ) {
			$this->add_control(
				'login_recaptcha_keys_missing',
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( 'reCAPTCHA API keys are missing. Please add them from %sDashboard > Boostify  Addons > Settings %sSettings', 'boostify' ), '<strong>', '</strong>' ), //phpcs:ignore
					'content_classes' => 'boostify-warning',
					'condition'       => array(
						'enable_login_recaptcha' => 'yes',
					),
				)
			);
		}

		$this->end_popover();

		if ( boostify_users_can_register() ) {
			$this->add_control(
				'gen_reg_content_po_toggle',
				array(
					'label'        => __( 'Register Form General', 'boostify' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => __( 'Default', 'boostify' ),
					'label_on'     => __( 'Custom', 'boostify' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => array(
						'type' => 'register',
					),
				)
			);

			$this->start_popover();

			$this->add_control(
				'show_login_link',
				array(
					'label'   => __( 'Show Login Link', 'boostify' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				)
			);

			$this->add_control(
				'login_link_text',
				array(
					'label'       => __( 'Login Link Text', 'boostify' ),
					'label_block' => true,
					'description' => __( 'You can put text in two lines to make the last line linkable. Pro Tip: You can keep the first line empty and put the text only in the second line to get a link only.', 'boostify' ),
					'type'        => Controls_Manager::TEXTAREA,
					'rows'        => 2,
					'dynamic'     => array(
						'active' => true,
					),
					'default'     => __( 'Sign In', 'boostify' ),
					'condition'   => array(
						'show_login_link' => 'yes',
					),
				)
			);

			$this->add_control(
				'login_link_action',
				array(
					'label'       => __( 'Login Link Action', 'boostify' ),
					'label_block' => true,
					'type'        => Controls_Manager::SELECT,
					'options'     => array(
						'default' => __( 'Default WordPress Page', 'boostify' ),
						'custom'  => __( 'Custom URL', 'boostify' ),
						'form'    => __( 'Show Login Form', 'boostify' ),
					),
					'default'     => 'form',
					'condition'   => array(
						'show_login_link' => 'yes',
					),
				)
			);

			$this->add_control(
				'custom_login_url',
				array(
					'label'         => __( 'Custom Login URL', 'boostify' ),
					'label_block'   => true,
					'show_external' => false,
					'type'          => Controls_Manager::URL,
					'dynamic'       => array(
						'active' => true,
					),
					'condition'     => array(
						'login_link_action' => 'custom',
						'show_login_link'   => 'yes',
					),
				)
			);

			$this->add_control(
				'enable_register_recaptcha',
				array(
					'label'        => __( 'Enable Google reCAPTCHA', 'boostify' ),
					'description'  => __( 'reCAPTCHA will prevent spam registration from bots.', 'boostify' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'boostify' ),
					'label_off'    => __( 'No', 'boostify' ),
					'return_value' => 'yes',
				)
			);

			if ( ! $this->check_recaptcha() ) {
				$this->add_control(
					'recaptcha_keys_missing',
					array(
						'type'            => Controls_Manager::RAW_HTML,
						'raw'             => sprintf( __( 'reCAPTCHA API keys are missing. Please add them from %sDashboard > Boostify  Addons > Settings %sSettings', 'boostify' ), '<strong>', '</strong>' ), //phpcs:ignore
						'content_classes' => 'boostify-warning',
						'condition'       => array(
							'enable_register_recaptcha' => 'yes',
						),
					)
				);
			}
			$this->end_popover();

		} else {
			$this->add_control(
				'show_login_link',
				array(
					'label'   => __( 'Show Login Link', 'boostify' ),
					'type'    => Controls_Manager::HIDDEN,
					'default' => 'no',
				)
			);
		}

		do_action( 'boostify_login_register_after_general_controls', $this );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_form_header',
			array(
				'label' => __( 'Form Header Content', 'boostify' ),
			)
		);

		$this->add_control(
			'logo',
			array(
				'label'   => __( 'Header Logo', 'boostify' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => array(
					'active' => true,
				),
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'logo_size',
				'default'   => 'full',
				'separator' => 'none',
			)
		);

		$this->add_control(
			'login_form_title',
			array(
				'label'       => __( 'Login Form Title', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'placeholder' => __( 'Welcome Back!', 'boostify' ),
				'separator'   => 'before',
				'condition'   => array(
					'type' => 'login',
				),
			)
		);

		$this->add_control(
			'login_form_subtitle',
			array(
				'label'       => __( 'Login Form Sub Title', 'boostify' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => array( 'active' => true ),
				'placeholder' => __( 'Please login to your account', 'boostify' ),
				'condition'   => array(
					'type' => 'login',
				),
			)
		);

		$this->add_control(
			'form_logo_position',
			array(
				'label'     => __( 'Header Align', 'boostify' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'boostify' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __( 'Top', 'boostify' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'  => array(
						'title' => __( 'Top', 'boostify' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .header-logo' => 'text-align: {{VALUE}}',
				),
				'separator' => 'after',
			)
		);

		$this->add_control(
			'register_form_title',
			array(
				'label'       => __( 'Register Form Title', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => __( 'Create a New Account', 'boostify' ),
				'separator'   => 'before',
				'condition'   => array(
					'type' => 'register',
				),
			)
		);
		$this->add_control(
			'register_form_subtitle',
			array(
				'label'       => __( 'Register Form Sub Title', 'boostify' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => __( 'Create an account to enjoy awesome features.', 'boostify' ),
				'condition'   => array(
					'type' => 'register',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_login_fields',
			array(
				'label'     => __( 'Login Form Fields', 'boostify' ),
				'condition' => array( 'type' => 'login' ),
			)
		);

		$this->add_control(
			'login_labels_heading',
			array(
				'label'     => __( 'Labels', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array( 'login_label_types' => 'custom' ),
			)
		);

		$this->add_control(
			'show_label',
			array(
				'label'        => esc_html__( 'Show Label', 'boostify' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'boostify' ),
				'label_off'    => esc_html__( 'Hide', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'login_user_label',
			array(
				'label'       => __( 'Username Label', 'boostify' ),
				'placeholder' => __( 'Username or Email Address', 'boostify' ),
				'default'     => __( 'Username or Email Address', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'label_block' => true,
				'condition'   => array( 'show_label' => 'yes' ),
			)
		);

		$this->add_control(
			'login_password_label',
			array(
				'label'       => __( 'Password Label', 'boostify' ),
				'placeholder' => __( 'Password', 'boostify' ),
				'default'     => __( 'Password', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'label_block' => true,
				'condition'   => array( 'show_label' => 'yes' ),
			)
		);

		$this->add_control(
			'login_placeholders_heading',
			array(
				'label'     => esc_html__( 'Placeholders', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array( 'login_label_types' => 'custom' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'show_placeholder',
			array(
				'label'        => esc_html__( 'Show Placeholders', 'boostify' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'boostify' ),
				'label_off'    => esc_html__( 'Hide', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'login_user_placeholder',
			array(
				'label'       => __( 'Username Placeholder', 'boostify' ),
				'placeholder' => __( 'Username or Email Address', 'boostify' ),
				'default'     => __( 'Username or Email Address', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'label_block' => true,
				'condition'   => array( 'show_placeholder' => 'yes' ),
			)
		);

		$this->add_control(
			'login_password_placeholder',
			array(
				'label'       => __( 'Password Placeholder', 'boostify' ),
				'placeholder' => __( 'Password', 'boostify' ),
				'default'     => __( 'Password', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'label_block' => true,
				'condition'   => array( 'show_placeholder' => 'yes' ),
			)
		);

		$this->add_responsive_control(
			'login_field_width',
			array(
				'label'      => esc_html__( 'Input Fields width', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 500,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} .field-control field-input' => 'width: {{SIZE}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_control(
			'password_toggle',
			array(
				'label'     => __( 'Password Visibility Icon', 'boostify' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'boostify' ),
				'label_on'  => __( 'Show', 'boostify' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'login_button_heading',
			array(
				'label'     => esc_html__( 'Login Button', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'login_button_text',
			array(
				'label'       => __( 'Button Text', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'default'     => __( 'Log In', 'boostify' ),
				'placeholder' => __( 'Log In', 'boostify' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_login_options',
			array(
				'label'     => __( 'Login Form Options', 'boostify' ),
				'condition' => array(
					'type' => 'login',
				),
			)
		);

		$this->add_control(
			'redirect_for_logged_in_user',
			array(
				'label'   => __( 'Redirect for Logged-in Users', 'boostify' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			)
		);

		$this->add_control(
			'redirect_url_for_logged_in_user',
			array(
				'type'          => Controls_Manager::URL,
				'show_label'    => false,
				'show_external' => false,
				'placeholder'   => site_url(),
				'description'   => __( 'Please note that only your current domain is allowed here to keep your site secure.', 'boostify' ),
				'condition'     => array(
					'redirect_for_logged_in_user' => 'yes',
				),
				'default'       => array(
					'url'         => site_url(),
					'is_external' => false,
					'nofollow'    => true,
				),
			)
		);

		$this->add_control(
			'redirect_after_login',
			array(
				'label' => __( 'Redirect After Login', 'boostify' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		$this->add_control(
			'redirect_url',
			array(
				'type'          => Controls_Manager::URL,
				'show_label'    => false,
				'show_external' => false,
				'placeholder'   => admin_url(),
				'description'   => __( 'Please note that only your current domain is allowed here to keep your site secure.', 'boostify' ),
				'condition'     => array(
					'redirect_after_login' => 'yes',
				),
				'default'       => array(
					'url'         => admin_url(),
					'is_external' => false,
					'nofollow'    => true,
				),
				'separator'     => 'after',
			)
		);

		$this->end_controls_section();

		$this->register_form_control();

		$this->form_validate_control();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="boostify-addon-widget boostify-wp-login-register">
			<div class="wp-login-register-wrapper">
				<?php
				if ( 'login' == $settings['type'] ) : //phpcs:ignore
					$this->get_login_template();
				else :
					$this->get_register_form();
				endif;
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Get Login Form template.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function get_login_template() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="boostify-form-login" id="boostify-login-form">
			<div class="login-form-wrapper">

				<?php if ( ! $this->check_elementor_editor() && is_user_logged_in() ) : ?>
					<?php if ( 'yes' == $settings['redirect_for_logged_in_user'] && $settings['redirect_url_for_logged_in_user']['url'] ) : //phpcs:ignore ?>
						<input type="hidden" name="redirect_for_logined" value="<?php echo esc_url( $settings['redirect_url_for_logged_in_user']['url'] ); ?>">
					<?php endif ?>
					<?php $user = wp_get_current_user(); ?>
					<span class="boostify-login-notice">
						<?php
							echo sprintf(__( 'You are already logged in as %s.', 'boostify' ), $user->display_name ); //phpcs:ignore
						?>
						<?php if ( 'yes' == $settings['show_logout'] ) : //phpcs:ignore ?>
							<a href="<?php echo esc_url( wp_logout_url() ); ?>"><?php echo esc_html__( 'Logout.', 'boostify' ); ?></a>
						<?php endif ?>
					</span>
				<?php else : ?>
					<div class="login-form-header">
						<div class="form-header-wrapper">
							<?php if ( ! empty( $settings['logo']['id'] ) ) : ?>
								<div class="header-logo">
									<?php
										$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $settings['logo']['id'], 'logo_size', $settings );

									?>
									<img class="header-logo-img" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( 'Header Logo' ); ?>">

								</div>
							<?php endif ?>

							<?php if ( ! empty( $settings['login_form_title'] ) ) : ?>
								<div class="form-title">
									<h3 class="title"><?php echo esc_html( $settings['login_form_title'] ); ?></h3>
									<span class="form-subtitle">
										<?php echo esc_html( $settings['login_form_subtitle'] ); ?>
									</span>
								</div>
							<?php endif ?>
						</div>
					</div>
					<form action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" class="wp-form-login">
						<?php do_action( 'boostify_addon_login_form_before' ); ?>
						<div class="field-control field-username">
							<?php if ( 'yes' == $settings['show_label'] ) : //phpcs:ignore ?>
								<label for="boostify-username" class="field-label"><?php echo esc_html( $settings['login_user_label'] ); ?></label>
							<?php endif ?>
							<?php
								$this->add_render_attribute(
									'login-username',
									'class',
									array(
										'field-input',
										'boostify-field',
									)
								);
								$this->add_render_attribute( 'login-username', 'name', 'username' );
								$this->add_render_attribute( 'login-username', 'id', 'boostify-username' );
								if ( 'yes' == $settings['show_placeholder'] ) : //phpcs:ignore
									$placeholder = $settings['login_user_placeholder'];
									$this->add_render_attribute( 'login-username', 'placeholder', $placeholder );
								endif;
							?>
							<input type="text" required <?php echo $this->get_render_attribute_string( 'login-username' ); //phpcs:ignore ?>>
							<div class="field-messages"></div>
						</div>
						<div class="field-control field-password">
							<?php if ( 'yes' == $settings['show_label'] ) : //phpcs:ignore ?>
								<label for="password" class="field-label"><?php echo esc_html( $settings['login_password_label'] ); ?></label>
							<?php endif ?>
							<?php
								$this->add_render_attribute(
									'login-password',
									'class',
									array(
										'field-input',
										'boostify-field',
									)
								);
								$this->add_render_attribute( 'login-password', 'name', 'password' );
								$this->add_render_attribute( 'login-password', 'id', 'password' );
								if ( 'yes' == $settings['show_placeholder'] ) : //phpcs:ignore
									$placeholder = $settings['login_password_placeholder'];
									$this->add_render_attribute( 'login-password', 'placeholder', $placeholder );
								endif;
							?>
							<div class="field-wrapper">
								<input type="password" required <?php echo $this->get_render_attribute_string( 'login-password' ); //phpcs:ignore ?>>
								<?php if ( 'yes' == $settings['password_toggle'] ) : //phpcs:ignore ?>
									<span class="visibility-password dashicons dashicons-visibility"></span>
								<?php endif ?>
								<div class="field-messages"></div>
							</div>
						</div>

						<div class=" form-bottom-actions">
							<?php if ( 'yes' == $settings['login_show_remember_me'] ) : //phpcs:ignore ?>
								<div class="field-control field-remember-me">
									<input name="rememberme"
										type="checkbox"
										id="remember"
										class="remember-me"
										value="1">
									<label for="rememberme" class="field-checkbox-label remember"><?php echo esc_html( $settings['remember_text'] ); ?></label>
								</div>
							<?php endif ?>
							<?php if ( 'yes' == $settings['show_forgot_password'] ) : //phpcs:ignore ?>
								<?php
								$link_atts = '';
								switch ( $settings['lost_password_link_type'] ) {
									case 'custom':
										$link = '#';
										if ( ! empty( $settings['lost_password_url']['url'] ) ) {
											$link       = $settings['lost_password_url']['url'];
											$link_atts  = ! empty( $settings['custom_register_url']['is_external'] ) ? ' target="_blank"' : '';
											$link_atts .= ! empty( $settings['custom_register_url']['nofollow'] ) ? ' rel="nofollow"' : '';
										}
										break;

									default:
										$link      = wp_lostpassword_url();
										$link_atts = '';
										break;
								}
								?>
								<div class="field-control field-forgot-password">
									<a href="<?php echo esc_url( $link ); ?>" <?php echo $link_atts; //phpcs:ignore ?>><?php echo esc_html( $settings['forgot_password_text'] ); ?></a>
								</div>
							<?php endif ?>
						</div>
						<?php
							$this->get_register_template( $settings );

							$this->get_google_recaptcha( $settings );
						?>


						<?php do_action( 'boostify_addon_login_form_after' ); ?>
						<div class="field-control field-submit">
							<?php if ( 'yes' == $settings['redirect_after_login'] && $settings['redirect_url']['url'] ) : //phpcs:ignore ?>
								<input type="hidden" name="redirect_url" value="<?php echo esc_url( $settings['redirect_url']['url'] ); ?>">
							<?php endif ?>

							<button type="submit" class="btn-submit btn-login"><?php echo esc_html( $settings['login_button_text'] ); ?></button>
						</div>
					</form>
				<?php endif ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Get Login Form template.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function get_register_form() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="boostify-form-register">
			<div class="register-form-wrapper">
				<?php boostify_form_register( $settings ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Check elementor editor.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @param array $settings | widget settings data.
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function get_register_template( $settings ) {
		if ( 'yes' !== $settings['show_register_link'] ) {
			return;
		}

		$link      = '#';
		$link_atts = '';
		switch ( $settings['registration_link_action'] ) {
			case 'default':
				$link = wp_registration_url();
				break;

			case 'custom':
				if ( ! empty( $settings['custom_register_url']['url'] ) ) {
					$link       = $settings['custom_register_url']['url'];
					$link_atts  = ! empty( $settings['custom_register_url']['is_external'] ) ? ' target="_blank"' : '';
					$link_atts .= ! empty( $settings['custom_register_url']['nofollow'] ) ? ' rel="nofollow"' : '';
				}
				break;

			default:
				$link = '#';
				break;
		}
		?>
		<div class="field-control field-register">
			<a href="<?php echo esc_url( $link ); ?>" <?php echo $link_atts; //phpcs:ignore ?>>
				<?php echo esc_html( $settings['registration_link_text'] ); ?>
			</a>
		</div>
		<?php
	}

	/**
	 * Check elementor editor.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function check_elementor_editor() {
		return \Elementor\Plugin::instance()->editor->is_edit_mode();
	}

	/**
	 * Form validate control.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function form_validate_control() {
		$this->start_controls_section(
			'section_content_errors',
			array(
				'label' => __( 'Validation Messages', 'boostify' ),
			)
		);

		$this->add_control(
			'err_message_heading',
			array(
				'label' => esc_html__( 'Error Messages', 'boostify' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'err_email',
			array(
				'label'              => __( 'Invalid Email', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'label_block'        => true,
				'placeholder'        => __( 'Eg. Your email is invalid.', 'boostify' ),
				'default'            => __( 'You have used an invalid email', 'boostify' ),
				'frontend_available' => true,
				'condition'          => array(
					'type' => 'login',
				),
			)
		);
		$this->add_control(
			'err_email_missing',
			array(
				'label'              => __( 'Email is missing', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'label_block'        => true,
				'placeholder'        => __( 'Eg. Email is missing or Invalid', 'boostify' ),
				'default'            => __( 'Email is missing or Invalid', 'boostify' ),
				'frontend_available' => true,
				'condition'          => array(
					'type' => 'login',
				),
			)
		);
		$this->add_control(
			'err_email_used',
			array(
				'label'              => __( 'Already Used Email', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'label_block'        => true,
				'placeholder'        => __( 'Eg. Your email is already in use..', 'boostify' ),
				'default'            => __( 'The provided email is already registered with other account. Please login or reset password or use another email.', 'boostify' ),
				'frontend_available' => true,
				'condition'          => array(
					'type' => 'login',
				),
			)
		);

		$this->add_control(
			'err_username',
			array(
				'label'              => __( 'Invalid Username', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'label_block'        => true,
				'placeholder'        => __( 'Eg. Your username is invalid.', 'boostify' ),
				'default'            => __( 'You have used an invalid username', 'boostify' ),
				'frontend_available' => true,
				'condition'          => array(
					'type' => 'login',
				),
			)
		);
		$this->add_control(
			'err_username_used',
			array(
				'label'              => __( 'Username already in use', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'label_block'        => true,
				'placeholder'        => __( 'Eg. Your username is already registered.', 'boostify' ),
				'default'            => __( 'Invalid username provided or the username already registered.', 'boostify' ),
				'frontend_available' => true,
				'condition'          => array(
					'type' => 'login',
				),
			)
		);
		$this->add_control(
			'err_pass',
			array(
				'label'              => __( 'Invalid Password', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'label_block'        => true,
				'placeholder'        => __( 'Eg. Your password is invalid', 'boostify' ),
				'default'            => __( 'Your password is invalid.', 'boostify' ),
				'frontend_available' => true,
				'condition'          => array(
					'type' => 'login',
				),
			)
		);

		$this->add_control(
			'err_conf_pass',
			array(
				'label'              => __( 'Invalid Password Confirmed', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'label_block'        => true,
				'placeholder'        => __( 'Eg. Password did not matched', 'boostify' ),
				'default'            => __( 'Your confirmed password did not match', 'boostify' ),
				'frontend_available' => true,
				'condition'          => array(
					'type' => 'login',
				),
			)
		);

		$this->add_control(
			'err_loggedin',
			array(
				'label'              => __( 'Already Logged In', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'label_block'        => true,
				'placeholder'        => __( 'Eg. You are already logged in', 'boostify' ),
				'default'            => __( 'You are already logged in', 'boostify' ),
				'frontend_available' => true,
				'condition'          => array(
					'type' => 'login',
				),
			)
		);

		$this->add_control(
			'err_recaptcha',
			array(
				'label'              => __( 'reCAPTCHA Failed', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'label_block'        => true,
				'placeholder'        => __( 'Eg. reCAPTCHA Validation Failed', 'boostify' ),
				'default'            => __( 'You did not pass reCAPTCHA challenge.', 'boostify' ),
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'err_tc',
			array(
				'label'              => __( 'Terms & Condition Error', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'label_block'        => true,
				'placeholder'        => __( 'Eg. You must accept the Terms & Conditions', 'boostify' ),
				'default'            => __( 'You did not accept the Terms and Conditions. Please accept it and try again.', 'boostify' ),
				'frontend_available' => true,
				'condition'          => array(
					'type' => 'register',
				),
			)
		);

		$this->add_control(
			'err_unknown',
			array(
				'label'              => __( 'Other Errors', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'label_block'        => true,
				'placeholder'        => __( 'Eg. Something went wrong', 'boostify' ),
				'default'            => __( 'Something went wrong!', 'boostify' ),
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'success_message_heading',
			array(
				'label'     => esc_html__( 'Success Messages', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'success_login',
			array(
				'label'              => __( 'Successful Login', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'label_block'        => true,
				'placeholder'        => __( 'Eg. You have logged in successfully', 'boostify' ),
				'default'            => __( 'You have logged in successfully', 'boostify' ),
				'frontend_available' => true,
				'condition'          => array(
					'type' => 'login',
				),
			)
		);
		$this->add_control(
			'success_register',
			array(
				'label'              => __( 'Successful Registration', 'boostify' ),
				'type'               => Controls_Manager::TEXTAREA,
				'default'            => __( 'Registration completed successfully, Check your inbox for password if you did not provided while registering.', 'boostify' ),
				'placeholder'        => __( 'eg. Registration completed successfully', 'boostify' ),
				'frontend_available' => true,
				'condition'          => array(
					'type' => 'register',
				),
			)
		);

		$this->end_controls_section();
	}


	/**
	 * Check setting recaptcha.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function check_recaptcha() {
		$recaptcha_sitekey      = get_option( 'boostify_recaptcha_site_key' );
		$recaptcha_secretkey    = get_option( 'boostify_recaptcha_secret_key' );
		$recaptcha_sitekey_v3   = get_option( 'boostify_recaptcha_v3_site_key' );
		$recaptcha_secretkey_v3 = get_option( 'boostify_recaptcha_v3_secret_key' );
		$recaptcha              = ( ! empty( $recaptcha_sitekey ) && ! empty( $recaptcha_sitekey ) ) ? true : false;
		$recaptchav3            = ( ! empty( $recaptcha_sitekey_v3 ) && ! empty( $recaptcha_secretkey_v3 ) ) ? true : false;

		if ( ! $recaptcha && ! $recaptchav3 ) {
			return false;
		}

		return true;
	}

	/**
	 * Render google recaptcha template.
	 *
	 * @param array $settings | widget settings data.
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function get_google_recaptcha( $settings ) {
		if ( 'yes' != $settings['enable_login_recaptcha'] ) { //phpcs:ignore
			return;
		}
		$recaptcha_sitekey      = get_option( 'boostify_recaptcha_site_key' );
		$recaptcha_secretkey    = get_option( 'boostify_recaptcha_secret_key' );
		$recaptcha_sitekey_v3   = get_option( 'boostify_recaptcha_v3_site_key' );
		$recaptcha_secretkey_v3 = get_option( 'boostify_recaptcha_v3_secret_key' );
		$recaptcha              = ( ! empty( $recaptcha_sitekey ) && ! empty( $recaptcha_sitekey ) ) ? true : false;
		$recaptchav3            = ( ! empty( $recaptcha_sitekey_v3 ) && ! empty( $recaptcha_secretkey_v3 ) ) ? true : false;
		?>
		<div class="field-control fiel-recaptcha">
			<div id="g-recaptcha-<?php echo esc_attr( $this->get_id() ); ?>" class="g-recaptcha"></div>
		</div>
		<?php
	}

	/**
	 * Register Form Control.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_form_control() {
		$this->start_controls_section(
			'section_content_register_fields',
			array(
				'label'     => __( 'Register Form Fields', 'boostify' ),
				'condition' => array(
					'type' => 'register',
				),
			)
		);
		$this->add_control(
			'register_form_field_note',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __( 'Select the type of fields you want to show in the registration form', 'boostify' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			)
		);
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'field_type',
			array(
				'label'   => __( 'Type', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_field_types(),
				'default' => 'first_name',
			)
		);

		$repeater->add_control(
			'field_label',
			array(
				'label'   => __( 'Label', 'boostify' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'placeholder',
			array(
				'label'   => __( 'Placeholder', 'boostify' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'required',
			array(
				'label'     => __( 'Required', 'boostify' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'field_type!' => array(
						'email',
						'password',
						'confirm_pass',
					),
				),
			)
		);

		$repeater->add_control(
			'required_note',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __( 'Note: This field is required by default.', 'boostify' ),
				'condition'       => array(
					'field_type' => array(
						'email',
						'password',
						'confirm_pass',
					),
				),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			)
		);

		$repeater->add_responsive_control(
			'width',
			array(
				'label'   => __( 'Field Width', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''    => __( 'Default', 'boostify' ),
					'100' => '100%',
					'80'  => '80%',
					'75'  => '75%',
					'66'  => '66%',
					'60'  => '60%',
					'50'  => '50%',
					'40'  => '40%',
					'33'  => '33%',
					'25'  => '25%',
					'20'  => '20%',
				),
				'default' => '100',
			)
		);
		apply_filters( 'boostify_form_register_repeater_controls', $repeater );

		$this->add_control(
			'register_fields',
			array(
				'label'       => __( 'Fields', 'boostify' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'type'        => 'user_name',
						'label'       => __( 'Username', 'boostify' ),
						'placeholder' => __( 'Username', 'boostify' ),
						'width'       => '100',
					),
					array(
						'type'        => 'email',
						'label'       => __( 'Email', 'boostify' ),
						'placeholder' => __( 'Email', 'boostify' ),
						'required'    => 'yes',
						'width'       => '100',
					),
					array(
						'type'        => 'password',
						'label'       => __( 'Password', 'boostify' ),
						'placeholder' => __( 'Password', 'boostify' ),
						'required'    => 'yes',
						'width'       => '100',
					),
				),
				'title_field' => '{{ field_label }}',
			)
		);

		$this->add_control(
			'show_labels',
			array(
				'label'   => __( 'Show Label', 'boostify' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'mark_required',
			array(
				'label'     => __( 'Show Required Mark', 'boostify' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'show_labels' => 'yes',
				),
			)
		);

		$this->add_control(
			'register_button_heading',
			array(
				'label'     => esc_html__( 'Register Button', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'register_button_text',
			array(
				'label'   => __( 'Button Text', 'boostify' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array( 'active' => true ),
				'default' => __( 'Register', 'boostify' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_register_actions',
			array(
				'label'     => __( 'Register Form Options', 'boostify' ),
				'condition' => array(
					'type' => 'register',
				),
			)
		);

		$this->add_control(
			'register_action',
			array(
				'label'       => __( 'Register Actions', 'boostify' ),
				'description' => __( 'You can select what should happen after a user registers successfully', 'boostify' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'default'     => 'send_email',
				'options'     => array(
					'redirect'   => __( 'Redirect', 'boostify' ),
					'auto_login' => __( 'Auto Login', 'boostify' ),
					'send_email' => __( 'Notify User By Email', 'boostify' ),
				),
			)
		);

		$this->add_control(
			'register_redirect_url',
			array(
				'type'          => Controls_Manager::URL,
				'label'         => __( 'Custom Redirect URL', 'boostify' ),
				'show_external' => false,
				'placeholder'   => __( 'https://your-link.com/', 'boostify' ),
				'description'   => __( 'Please note that only your current domain is allowed here to keep your site secure.', 'boostify' ),
				'default'       => array(
					'url'         => get_admin_url(),
					'is_external' => false,
					'nofollow'    => true,
				),
				'condition'     => array(
					'register_action' => 'redirect',
				),
			)
		);

		if ( current_user_can( 'create_users' ) ) {
			$user_role = boostify_get_user_roles();
		} else {
			$user_role = array( get_option( 'default_role' ) => ucfirst( get_option( 'default_role' ) ) );
		}

		$this->add_control(
			'register_user_role',
			array(
				'label'     => __( 'New User Role', 'boostify' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => $user_role,
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Get an array of form field types.
	 */
	private function get_field_types() {
		$types = array(
			'user_name'    => __( 'Username', 'boostify' ),
			'email'        => __( 'Email', 'boostify' ),
			'password'     => __( 'Password', 'boostify' ),
			'confirm_pass' => __( 'Confirm Password', 'boostify' ),
			'first_name'   => __( 'First Name', 'boostify' ),
			'last_name'    => __( 'Last Name', 'boostify' ),
			'website'      => __( 'Website', 'boostify' ),
		);
		return apply_filters( 'boostify_register_form_field', $types );
	}

}
