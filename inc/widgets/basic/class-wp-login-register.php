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
					'type'        => Controls_Manager::TEXT,
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
					'{{WRAPPER}} .login-form-header' => 'text-align: {{VALUE}}',
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

		$this->add_control(
			'username_icon',
			array(
				'label' => esc_html__( 'Username Icon', 'boostify' ),
				'type'  => \Elementor\Controls_Manager::ICONS,
			)
		);

		$this->add_control(
			'password_icon',
			array(
				'label' => esc_html__( 'Password Icon', 'boostify' ),
				'type'  => \Elementor\Controls_Manager::ICONS,
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

		$this->get_terms_conditions();

		$this->user_email_controls();

		$this->admin_email_controls();

		$this->form_validate_control();

		$this->style_general_controls();
		$this->style_header_content_controls();
		$this->style_header_content_controls( 'register' );

		$this->style_input_fields_controls();
		$this->style_labels_controls();

		$this->button_style_controls();
		$this->button_style_controls( 'register' );

		$this->link_style_controls();
		$this->link_style_controls( 'register' );

		$this->recaptcha_style();

		$this->recaptcha_style( 'register' );
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
	 * @param string $popup Popup.
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function get_login_template( $popup = false ) {
		$settings               = $this->get_settings_for_display();
		$recaptcha_sitekey      = get_option( 'boostify_recaptcha_site_key' );
		$recaptcha_secretkey    = get_option( 'boostify_recaptcha_secret_key' );
		$recaptcha_sitekey_v3   = get_option( 'boostify_recaptcha_v3_site_key' );
		$recaptcha_secretkey_v3 = get_option( 'boostify_recaptcha_v3_secret_key' );
		$recaptcha              = ( ! empty( $recaptcha_sitekey ) && ! empty( $recaptcha_sitekey ) ) ? true : false;
		$recaptchav3            = ( ! empty( $recaptcha_sitekey_v3 ) && ! empty( $recaptcha_secretkey_v3 ) ) ? true : false;
		if ( $recaptchav3 ) {
			$recaptcha_sitekey = $recaptcha_sitekey_v3;
		}

		?>
		<div class="boostify-form-login boostify-form">
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
								<label for="boostify-username-<?php echo esc_attr( $this->get_id() ); ?>" class="field-label"><?php echo esc_html( $settings['login_user_label'] ); ?></label>
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
								$this->add_render_attribute( 'login-username', 'id', 'boostify-username-' . esc_attr( $this->get_id() ) );
								if ( 'yes' == $settings['show_placeholder'] ) : //phpcs:ignore
									$placeholder = $settings['login_user_placeholder'];
									$this->add_render_attribute( 'login-username', 'placeholder', $placeholder );
								endif;

								$class_icon_user = ( ! empty( $settings['username_icon']['value'] ) ) ? ' has-icon' : '';
								$class_icon_pass = ( ! empty( $settings['password_icon']['value'] ) ) ? ' has-icon' : '';

							?>
							<div class="field-wrapper<?php echo esc_attr( $class_icon_user ); ?>">
								<?php $this->get_field_icon( $settings['username_icon'] ); ?>
								<input type="text" required <?php echo $this->get_render_attribute_string( 'login-username' ); //phpcs:ignore ?>>
							</div>
						</div>
						<div class="field-control field-password">
							<?php if ( 'yes' == $settings['show_label'] ) : //phpcs:ignore ?>
								<label for="password-<?php echo esc_attr( $this->get_id() ); ?>" class="field-label"><?php echo esc_html( $settings['login_password_label'] ); ?></label>
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
								$this->add_render_attribute( 'login-password', 'id', 'password-' . esc_attr( $this->get_id() ) );
								if ( 'yes' == $settings['show_placeholder'] ) : //phpcs:ignore
									$placeholder = $settings['login_password_placeholder'];
									$this->add_render_attribute( 'login-password', 'placeholder', $placeholder );
								endif;
							?>
							<div class="field-wrapper<?php echo esc_attr( $class_icon_pass ); ?>">
								<?php $this->get_field_icon( $settings['password_icon'] ); ?>
								<input type="password" required <?php echo $this->get_render_attribute_string( 'login-password' ); //phpcs:ignore ?>>
								<?php if ( 'yes' == $settings['password_toggle'] ) : //phpcs:ignore ?>
									<span class="visibility-password">
										<span class="dashicons dashicons-visibility"></span>
									</span>
								<?php endif ?>
							</div>
						</div>

						<div class=" form-bottom-actions field-control">
							<?php if ( 'yes' == $settings['login_show_remember_me'] ) : //phpcs:ignore ?>
								<div class="field-remember-me">
									<label for="remember" class="field-checkbox-label remember">
										<input name="rememberme"
											type="checkbox"
											id="remember"
											class="remember-me field-checkbox"
											value="1">
											<span class="checkmark"></span>
											<span class="label"><?php echo esc_html( $settings['remember_text'] ); ?></span>
									</label>
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
						<?php $this->get_google_recaptcha( $settings ); ?>

						<div class="field-messages">
						</div>

						<?php do_action( 'boostify_addon_login_form_after' ); ?>
						<div class="form-action-footer">
							<div class="field-submit">
								<?php if ( 'yes' == $settings['enable_register_recaptcha'] ) : //phpcs:ignore ?>
									<input type="hidden" value="<?php echo esc_html( $recaptcha_sitekey ); ?>" name="g-recaptcha">
								<?php endif ?>
								<?php if ( 'yes' == $settings['redirect_after_login'] && $settings['redirect_url']['url'] ) : //phpcs:ignore ?>
									<input type="hidden" name="redirect_url" value="<?php echo esc_url( $settings['redirect_url']['url'] ); ?>">
								<?php endif ?>

								<button type="submit" class="btn-submit btn-login"><?php echo esc_html( $settings['login_button_text'] ); ?></button>
							</div>

							<?php $this->get_register_template( $settings ); ?>
						</div>
					</form>

					<?php if ( 'yes' == $settings['show_register_link'] && ! $popup && 'form' == $settings['registration_link_action'] ) : //phpcs;ignore ?>
						<div class="form-popup popup-register">
							<div class="form-popup-wrapper">
								<?php $this->get_register_form( $settings ); ?>
							</div>
							<div class="popup-overlay"></div>
						</div>
					<?php endif ?>
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
	 * * @param string $popup Popup.
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function get_register_form( $popup = false ) {
		$settings = $this->get_settings_for_display();
		if ( ! $this->check_elementor_editor() && is_user_logged_in() ) :
			return;
		endif;
		?>
		<div class="boostify-form-register boostify-form">
			<div class="register-form-wrapper">
				<?php $this->form_register( $settings, $popup ); ?>
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
	 * @param array $popup | widget settings data.
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
		<div class="field-control field-register field-link">
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
				'placeholder'        => __( 'Ex. Your email is invalid.', 'boostify' ),
				'default'            => __( 'You have used an invalid email.', 'boostify' ),
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
				'placeholder'        => __( 'Ex. Email is missing or Invalid', 'boostify' ),
				'default'            => __( 'Email is missing or Invalid.', 'boostify' ),
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
				'placeholder'        => __( 'Ex. Your email is already in use.', 'boostify' ),
				'default'            => __( 'The email is already registered.', 'boostify' ),
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
				'placeholder'        => __( 'Ex. Your username is invalid.', 'boostify' ),
				'default'            => __( 'You have used an invalid username.', 'boostify' ),
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
				'placeholder'        => __( 'Ex. Your username is already registered.', 'boostify' ),
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
				'placeholder'        => __( 'Ex. Your password is invalid.', 'boostify' ),
				'default'            => __( 'Your password is invalid.', 'boostify' ),
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'err_conf_pass',
			array(
				'label'              => __( 'Invalid Password Confirmed', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'label_block'        => true,
				'placeholder'        => __( 'Ex. Password did not matched', 'boostify' ),
				'default'            => __( 'Your confirmed password did not match.', 'boostify' ),
				'frontend_available' => true,

			)
		);

		$this->add_control(
			'err_loggedin',
			array(
				'label'              => __( 'Already Logged In', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'label_block'        => true,
				'placeholder'        => __( 'Ex. You are already logged in', 'boostify' ),
				'default'            => __( 'You are already logged in.', 'boostify' ),
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
				'placeholder'        => __( 'Ex. reCAPTCHA Validation Failed', 'boostify' ),
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
				'placeholder'        => __( 'Ex. You must accept the Terms & Conditions', 'boostify' ),
				'default'            => __( 'You did not accept the Terms and Conditions.', 'boostify' ),
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
				'placeholder'        => __( 'Ex. Something went wrong', 'boostify' ),
				'default'            => __( 'Opp! Something went wrong!', 'boostify' ),
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
				'placeholder'        => __( 'Ex. You have logged in successfully', 'boostify' ),
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
				'label' => __( 'Register Form Fields', 'boostify' ),
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
						'username',
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
						'username',
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

		$repeater->add_control(
			'icon',
			array(
				'label' => esc_html__( 'Icon', 'boostify' ),
				'type'  => \Elementor\Controls_Manager::ICONS,
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
						'field_type'  => 'username',
						'field_label' => __( 'Username', 'boostify' ),
						'placeholder' => __( 'Username', 'boostify' ),
						'width'       => '100',
					),
					array(
						'field_type'  => 'email',
						'field_label' => __( 'Email', 'boostify' ),
						'placeholder' => __( 'Email', 'boostify' ),
						'required'    => 'yes',
						'width'       => '100',
					),
					array(
						'field_type'  => 'password',
						'field_label' => __( 'Password', 'boostify' ),
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
				'label'              => __( 'Register Actions', 'boostify' ),
				'description'        => __( 'You can select what should happen after a user registers successfully', 'boostify' ),
				'type'               => Controls_Manager::SELECT2,
				'multiple'           => true,
				'label_block'        => true,
				'default'            => 'send_email',
				'frontend_available' => true,
				'options'            => array(
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
				'label'              => __( 'New User Role', 'boostify' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => '',
				'options'            => $user_role,
				'separator'          => 'before',
				'frontend_available' => true,
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Terms & Conditions Control.
	 */
	private function get_terms_conditions() {
		$this->start_controls_section(
			'section_content_terms_conditions',
			array(
				'label' => __( 'Terms & Conditions', 'boostify' ),
			)
		);

		$this->add_control(
			'show_terms_conditions',
			array(
				'label'        => __( 'Enforce Terms & Conditions', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'boostify' ),
				'label_off'    => __( 'No', 'boostify' ),
				'default'      => 'no',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'acceptance_label',
			array(
				'label'       => __( 'Acceptance Label', 'boostify' ),
				'description' => __( 'Ex. I accept the terms & conditions. Note: First line is checkbox label & Last line will be used as link text.', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'rows'        => 2,
				'label_block' => true,
				'placeholder' => __( 'I Accept Terms and Conditions.', 'boostify' ),
				'default'     => __( 'I Accept [Terms and Conditions].', 'boostify' ),
				'condition'   => array(
					'show_terms_conditions' => 'yes',
				),
			)
		);

		$this->add_control(
			'acceptance_text_source',
			array(
				'label'     => __( 'Content Source', 'boostify' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'editor' => __( 'Editor', 'boostify' ),
					'custom' => __( 'Custom', 'boostify' ),
				),
				'default'   => 'custom',
				'condition' => array(
					'show_terms_conditions' => 'yes',
				),
			)
		);

		$this->add_control(
			'acceptance_text',
			array(
				'label'     => __( 'Terms and Conditions', 'boostify' ),
				'type'      => Controls_Manager::WYSIWYG,
				'rows'      => 3,
				'default'   => __( 'Please go through the following terms and conditions carefully.', 'boostify' ),
				'condition' => array(
					'show_terms_conditions'  => 'yes',
					'acceptance_text_source' => 'editor',
				),
			)
		);

		$this->add_control(
			'acceptance_text_url',
			array(
				'label'       => __( 'Terms & Conditions URL', 'boostify' ),
				'description' => __( 'Enter the link where your terms & condition or privacy policy is found.', 'boostify' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => array(
					'url'         => get_the_permalink( get_option( 'wp_page_for_privacy_policy' ) ),
					'is_external' => true,
					'nofollow'    => true,
				),
				'condition'   => array(
					'show_terms_conditions'  => 'yes',
					'acceptance_text_source' => 'custom',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Get an array of form field types.
	 */
	private function get_field_types() {
		$types = array(
			'username'     => __( 'Username', 'boostify' ),
			'email'        => __( 'Email', 'boostify' ),
			'password'     => __( 'Password', 'boostify' ),
			'confirm_pass' => __( 'Confirm Password', 'boostify' ),
			'first_name'   => __( 'First Name', 'boostify' ),
			'last_name'    => __( 'Last Name', 'boostify' ),
			'website'      => __( 'Website', 'boostify' ),
		);
		return apply_filters( 'boostify_register_form_field', $types );
	}

	/**
	 * Get an array of form field types.
	 */
	private function get_site_key() {
		$recaptcha_sitekey      = get_option( 'boostify_recaptcha_site_key' );
		$recaptcha_secretkey    = get_option( 'boostify_recaptcha_secret_key' );
		$recaptcha_sitekey_v3   = get_option( 'boostify_recaptcha_v3_site_key' );
		$recaptcha_secretkey_v3 = get_option( 'boostify_recaptcha_v3_secret_key' );
		$recaptchav3            = ( ! empty( $recaptcha_sitekey_v3 ) && ! empty( $recaptcha_secretkey_v3 ) ) ? true : false;

		if ( $recaptchav3 ) {
			$recaptcha_sitekey = $recaptcha_sitekey_v3;
		}

		return $recaptcha_sitekey;
	}

	/**
	 * Get default email custom.
	 */
	public function get_email_defaul() {
		$default_subject  = sprintf( __( '["%s"] New User Registration', 'boostify' ), get_option( 'blogname' ) ); //phpcs:ignore
		$default_message  = $default_subject . "\r\n\r\n";
		$default_message .= __( 'Username: [username]', 'boostify' ) . "\r\n\r\n";
		$default_message .= __( 'Password: [password]', 'boostify' ) . "\r\n\r\n";
		$default_message .= __( 'To reset your password, visit the following address:', 'boostify' ) . "\r\n\r\n";
		$default_message .= "[password_reset_link]\r\n\r\n";
		$default_message .= __( 'Please click the following address to login to your account:', 'boostify' ) . "\r\n\r\n";
		$default_message .= wp_login_url() . "\r\n";

		return $default_message;
	}

	/**
	 * Get email user control.
	 */
	private function user_email_controls() {
		$default_subject = sprintf( __( 'Thank you for registering on "%s"!', 'boostify' ), get_option( 'blogname' ) ); //phpcs:ignore
		$default_message = $this->get_email_defaul();
		$this->start_controls_section(
			'section_content_reg_email',
			array(
				'label'      => __( 'Register User Email Options', 'boostify' ),
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'  => 'show_register_link',
							'value' => 'yes',
						),
						array(
							'name'  => 'default_form_type',
							'value' => 'register',

						),
					),
				),
			)
		);

		$this->add_control(
			'reg_email_template_type',
			array(
				'label'       => __( 'Email Template Type', 'boostify' ),
				'description' => __( 'Default template uses WordPress Default email template. So, please select the Custom Option to send the user proper information if you used any username field.', 'boostify' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'render_type' => 'none',
				'options'     => array(
					'default' => __( 'WordPres Default', 'boostify' ),
					'custom'  => __( 'Custom', 'boostify' ),
				),
			)
		);

		$this->add_control(
			'reg_email_subject',
			array(
				'label'       => __( 'Email Subject', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => $default_subject,
				'default'     => $default_subject,
				'label_block' => true,
				'render_type' => 'none',
				'condition'   => array(
					'reg_email_template_type' => 'custom',
				),
			)
		);

		$this->add_control(
			'reg_email_message',
			array(
				'label'       => __( 'Email Message', 'boostify' ),
				'type'        => Controls_Manager::WYSIWYG,
				'placeholder' => __( 'Enter Your Custom Email Message..', 'boostify' ),
				'default'     => $default_message,
				'label_block' => true,
				'render_type' => 'none',
				'condition'   => array(
					'reg_email_template_type' => 'custom',
				),
			)
		);

		$this->add_control(
			'reg_email_content_note',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __( '<strong>Note:</strong> You can use dynamic content in the email body like [fieldname]. For example [username] will be replaced by user-typed username. Available tags are: [password], [username], [email], [firstname],[lastname], [website], [loginurl], [password_reset_link] and [sitetitle] ', 'boostify' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'reg_email_template_type' => 'custom',
				),
				'render_type'     => 'none',
			)
		);

		$this->add_control(
			'reg_email_content_type',
			array(
				'label'       => __( 'Email Content Type', 'boostify' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'html',
				'render_type' => 'none',
				'options'     => array(
					'html'  => __( 'HTML', 'boostify' ),
					'plain' => __( 'Plain', 'boostify' ),
				),
				'condition'   => array(
					'reg_email_template_type' => 'custom',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Get email admin control.
	 */
	private function admin_email_controls() {
		$default_subject  = sprintf( __( '["%s"] New User Registration', 'boostify' ), get_option( 'blogname' ) ); //phpcs:ignore
		$default_message  = sprintf( __( 'New user registration on your site %s', 'boostify' ), get_option( 'blogname' ) ) . '\r\n\r\n'; //phpcs:ignore
		$default_message .= __( 'Username: [username]', 'boostify' ) . "\r\n\r\n";
		$default_message .= __( 'Email: [email]', 'boostify' ) . "\r\n\r\n";

		$this->start_controls_section(
			'section_content_reg_admin_email',
			array(
				'label'      => __( 'Register Admin Email Options', 'boostify' ),
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'  => 'show_register_link',
							'value' => 'yes',

						),
						array(
							'name'  => 'default_form_type',
							'value' => 'register',

						),
					),
				),
			)
		);

		$this->add_control(
			'reg_admin_email_template_type',
			array(
				'label'       => __( 'Email Template Type', 'boostify' ),
				'description' => __( 'Default template uses WordPress Default Admin email template. You can customize it by choosing the custom option.', 'boostify' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'render_type' => 'none',
				'options'     => array(
					'default' => __( 'WordPres Default', 'boostify' ),
					'custom'  => __( 'Custom', 'boostify' ),
				),
			)
		);

		$this->add_control(
			'reg_admin_email_subject',
			array(
				'label'       => __( 'Email Subject', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => $default_subject,
				'default'     => $default_subject,
				'label_block' => true,
				'render_type' => 'none',
				'condition'   => array(
					'reg_admin_email_template_type' => 'custom',
				),
			)
		);

		$this->add_control(
			'reg_admin_email_message',
			array(
				'label'       => __( 'Email Message', 'boostify' ),
				'type'        => Controls_Manager::WYSIWYG,
				'placeholder' => __( 'Enter Your Custom Email Message..', 'boostify' ),
				'default'     => $default_message,
				'label_block' => true,
				'render_type' => 'none',
				'condition'   => array(
					'reg_admin_email_template_type' => 'custom',
				),
			)
		);

		$this->add_control(
			'reg_admin_email_content_note',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __( '<strong>Note:</strong> You can use dynamic content in the email body like [fieldname]. For example [username] will be replaced by user-typed username. Available tags are: [username], [email], [firstname],[lastname], [website], [loginurl] and [sitetitle] ', 'boostify' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => array(
					'reg_admin_email_template_type' => 'custom',
				),
				'render_type'     => 'none',
			)
		);

		$this->add_control(
			'reg_admin_email_content_type',
			array(
				'label'       => __( 'Email Content Type', 'boostify' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'html',
				'render_type' => 'none',
				'options'     => array(
					'html'  => __( 'HTML', 'boostify' ),
					'plain' => __( 'Plain', 'boostify' ),
				),
				'condition'   => array(
					'reg_admin_email_template_type' => 'custom',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Style general Form Control.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function style_general_controls() {
		$this->start_controls_section(
			'section_style_general',
			array(
				'label' => __( 'General', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'form_form_wrap_po_toggle',
			array(
				'label'        => __( 'Container Box', 'boostify' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'boostify' ),
				'label_on'     => __( 'Custom', 'boostify' ),
				'return_value' => 'yes',
			)
		);
		$this->start_popover();
		$this->add_responsive_control(
			'form_wrap_width',
			array(
				'label'           => esc_html__( 'Width', 'boostify' ),
				'type'            => Controls_Manager::SLIDER,
				'size_units'      => array(
					'px',
					'rem',
					'%',
				),
				'range'           => array(
					'px'  => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'rem' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => .5,
					),
					'%'   => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'desktop_default' => array(
					'unit' => '%',
					'size' => 65,
				),
				'tablet_default'  => array(
					'unit' => '%',
					'size' => 75,
				),
				'mobile_default'  => array(
					'unit' => '%',
					'size' => 100,
				),
				'selectors'       => array(
					'{{WRAPPER}} .boostify-form' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'       => array(
					'form_form_wrap_po_toggle' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'form_wrap_margin',
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'form_form_wrap_po_toggle' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'form_wrap_padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'form_form_wrap_po_toggle' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'form_wrap_border',
				'selector'  => '{{WRAPPER}} .boostify-form',
				'condition' => array(
					'form_form_wrap_po_toggle' => 'yes',
				),
			)
		);
		$this->add_control(
			'form_wrap_border_radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'form_form_wrap_po_toggle' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'form_wrap_bg_color',
				'label'     => __( 'Background Color', 'boostify' ),
				'types'     => array(
					'classic',
					'gradient',
				),
				'selector'  => '{{WRAPPER}} .boostify-form',
				'condition' => array(
					'form_form_wrap_po_toggle' => 'yes',
				),
			)
		);
		$this->end_popover();
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Container Box Shadow', 'boostify' ),
				'name'     => 'form_wrap_shadow',
				'selector' => '{{WRAPPER}} .boostify-form',
				'exclude'  => array(
					'box_shadow_position',
				),
			)
		);

		$this->add_control(
			'form_form_po_toggle',
			array(
				'label'        => __( 'Form', 'boostify' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'boostify' ),
				'label_on'     => __( 'Custom', 'boostify' ),
				'return_value' => 'yes',
				'separator'    => 'before',
			)
		);
		$this->start_popover();
		$this->add_control(
			'form_wrapper_heading',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Form Wrapper', 'boostify' ),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'form_width',
			array(
				'label'           => esc_html__( 'Wrapper width', 'boostify' ),
				'type'            => Controls_Manager::SLIDER,
				'size_units'      => array(
					'px',
					'rem',
					'%',
				),
				'range'           => array(
					'px'  => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'rem' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => .5,
					),
					'%'   => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'desktop_default' => array(
					'unit' => '%',
					'size' => 50,
				),
				'tablet_default'  => array(
					'unit' => '%',
					'size' => 75,
				),
				'mobile_default'  => array(
					'unit' => '%',
					'size' => 100,
				),
				'selectors'       => array(
					'{{WRAPPER}} .boostify-form-register, {{WRAPPER}} .boostify-form-login' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'       => array(
					'form_form_po_toggle' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'form_margin',
			array(
				'label'      => __( 'Wrapper Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-form-register, {{WRAPPER}} .boostify-form-login' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'form_form_po_toggle' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'form_padding',
			array(
				'label'      => __( 'Wrapper Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-form-register, {{WRAPPER}} .boostify-form-login' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'form_form_po_toggle' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'form_border',
				'selector'  => '{{WRAPPER}} .boostify-form-register, {{WRAPPER}} .boostify-form-login',
				'condition' => array(
					'form_form_po_toggle' => 'yes',
				),
			)
		);
		$this->add_control(
			'form_border_radius',
			array(
				'label'      => __( 'Wrapper Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-form-register, {{WRAPPER}} .boostify-form-login' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'form_form_po_toggle' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'form_bg_color',
				'label'    => __( 'Background Color', 'boostify' ),
				'types'    => array(
					'classic',
					'gradient',
				),
				'selector' => '{{WRAPPER}} .boostify-form-register, {{WRAPPER}} .boostify-form-login',
			)
		);

		$this->add_control(
			'form_input_container',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Form Style', 'boostify' ),
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'form_ic_width',
			array(
				'label'      => esc_html__( 'Form width', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
				),
				'range'      => array(
					'px'  => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'rem' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => .5,
					),
					'%'   => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-form form' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'form_form_po_toggle' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'form_ic_margin',
			array(
				'label'      => __( 'Form Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .wp-login-register-wrapper form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'form_form_po_toggle' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'form_ic_padding',
			array(
				'label'      => __( 'Form Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .wp-login-register-wrapper form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'form_form_po_toggle' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'form_ic_border',
				'selector'  => '{{WRAPPER}} .wp-login-register-wrapper form',
				'condition' => array(
					'form_form_po_toggle' => 'yes',
				),
			)
		);
		$this->add_control(
			'form_ic_border_radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .wp-login-register-wrapper form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'form_form_po_toggle' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'form_ic_bg_color',
				'label'    => __( 'Background Color', 'boostify' ),
				'types'    => array(
					'classic',
					'gradient',
				),
				'selector' => '{{WRAPPER}} .wp-login-register-wrapper form',
			)
		);
		$this->end_popover();

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Form Wrapper Shadow', 'boostify' ),
				'name'     => 'form_shadow',
				'selector' => '{{WRAPPER}} .boostify-form-register form, {{WRAPPER}} .boostify-form-login form',
				'exclude'  => array(
					'box_shadow_position',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Form Shadow', 'boostify' ),
				'name'     => 'form_ic_shadow',
				'selector' => '{{WRAPPER}} .wp-login-register-wrapper form',
				'exclude'  => array(
					'box_shadow_position',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Style general Form Control.
	 *
	 * @since 1.0.0
	 *
	 * @param string $form_type | Form Type.
	 *
	 * @access private
	 */
	private function style_header_content_controls( $form_type = 'login' ) {
		$this->start_controls_section(
			'section_style_' . $form_type . '_header_content',
			array(
				'label'      => sprintf( __( '%s Form Header', 'boostify' ), ucfirst( $form_type ) ), //phpcs:ignore
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'  => "show_{$form_type}_link",
							'value' => 'yes',
						),
						array(
							'name'  => 'default_form_type',
							'value' => $form_type,
						),
					),
				),
			)
		);

		$this->add_control(
			"{$form_type}_fhc_po_toggle",
			array(
				'label'        => __( 'Header Content', 'boostify' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'boostify' ),
				'label_on'     => __( 'Custom', 'boostify' ),
				'return_value' => 'yes',
			)
		);

		$this->start_popover();

		$this->add_responsive_control(
			"{$form_type}_fhc_width",
			array(
				'label'      => esc_html__( 'Header width', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
				),
				'range'      => array(
					'px'  => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'rem' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => .5,
					),
					'%'   => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .{$form_type}-form-header" => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_fhc_po_toggle" => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			"{$form_type}_fhc_height",
			array(
				'label'      => esc_html__( 'Header height', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
				),
				'range'      => array(
					'px'  => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'rem' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => .5,
					),
					'%'   => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .{$form_type}-form-header" => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_fhc_po_toggle" => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			"{$form_type}_fhc_margin",
			array(
				'label'      => __( 'Header Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .{$form_type}-form-header" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_fhc_po_toggle" => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			"{$form_type}_fhc_padding",
			array(
				'label'      => __( 'Header Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .{$form_type}-form-header" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_fhc_po_toggle" => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => "{$form_type}_fhc_border",
				'selector'  => "{{WRAPPER}} .{$form_type}-form-wrapper .{$form_type}-form-header",
				'condition' => array(
					"{$form_type}_fhc_po_toggle" => 'yes',
				),
			)
		);

		$this->add_control(
			"{$form_type}_fhc_border_radius",
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .{$form_type}-form-header" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_fhc_po_toggle" => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => "{$form_type}_form_header_bg",
				'label'     => __( 'Background Color', 'boostify' ),
				'types'     => array(
					'classic',
					'gradient',
				),
				'selector'  => "{{WRAPPER}} .{$form_type}-form-wrapper .{$form_type}-form-header",
				'condition' => array(
					"{$form_type}_fhc_po_toggle" => 'yes',
				),
			)
		);
		$this->end_popover();

		$this->add_control(
			"{$form_type}_form_logo_po_toggle",
			array(
				'label'        => __( 'Form Logo', 'boostify' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'boostify' ),
				'label_on'     => __( 'Custom', 'boostify' ),
				'return_value' => 'yes',
				'separator'    => 'before',
			)
		);

		$this->start_popover();
		$this->add_responsive_control(
			"{$form_type}_form_logo_width",
			array(
				'label'      => esc_html__( 'width', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
				),
				'range'      => array(
					'px'  => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'rem' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => .5,
					),
					'%'   => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 100,
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-header .header-logo-img" => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_form_logo_po_toggle" => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			"{$form_type}_form_logo_height",
			array(
				'label'      => esc_html__( 'height', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
				),
				'range'      => array(
					'px'  => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'rem' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => .5,
					),
					'%'   => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 100,
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-header .header-logo-img" => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_form_logo_po_toggle" => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			"{$form_type}_form_logo_margin",
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-header .header-logo-img" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_form_logo_po_toggle" => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			"{$form_type}_form_logo_padding",
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-header .header-logo-img" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_form_logo_po_toggle" => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => "{$form_type}_form_logo_border",
				'selector'  => "{{WRAPPER}} .{$form_type}-form-header .header-logo-img",
				'condition' => array(
					"{$form_type}_form_logo_po_toggle" => 'yes',
				),
			)
		);
		$this->add_control(
			"{$form_type}_form_logo_border_radius",
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-header .header-logo-img" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_form_logo_po_toggle" => 'yes',
				),
			)
		);
		$this->end_popover();

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Logo Shadow', 'boostify' ),
				'name'     => "{$form_type}_form_logo_shadow",
				'selector' => "{{WRAPPER}} .{$form_type}-form-header .header-logo-img",
				'exclude'  => array(
					'box_shadow_position',
				),
			)
		);

		$this->add_control(
			"{$form_type}_form_title_po_toggle",
			array(
				'label'        => __( 'Title', 'boostify' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'boostify' ),
				'label_on'     => __( 'Custom', 'boostify' ),
				'return_value' => 'yes',
				'separator'    => 'before',
			)
		);
		$this->start_popover();
		$this->add_responsive_control(
			"{$form_type}_form_title_margin",
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .form-title .title" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_form_title_po_toggle" => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			"{$form_type}_form_title_padding",
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .form-title .title" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'{$form_type}_form_title_po_toggle' => 'yes',
				),
			)
		);
		$this->add_control(
			"{$form_type}_form_title_color",
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .form-title .title" => 'color: {{VALUE}};',
				),
				'condition' => array(
					"{$form_type}_form_title_po_toggle" => 'yes',
				),
			)
		);

		$this->add_control(
			"{$form_type}_form_title_bg_color",
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .form-title .title" => 'background: {{VALUE}};',
				),
				'condition' => array(
					"{$form_type}_form_title_po_toggle" => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => "{$form_type}_form_title_border",
				'selector'  => "{{WRAPPER}} .{$form_type}-form-wrapper .form-title .title",
				'condition' => array(
					"{$form_type}_form_title_po_toggle" => 'yes',
				),
			)
		);
		$this->add_control(
			"{$form_type}_form_title_border_radius",
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .form-title .title" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_form_title_po_toggle" => 'yes',
				),
			)
		);

		$this->end_popover();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => "{$form_type}_form_title_typo",
				'label'    => __( 'Title Typography', 'boostify' ),
				'selector' => "{{WRAPPER}} .{$form_type}-form-wrapper .form-title .title",
			)
		);

		$this->add_control(
			"{$form_type}_form_subtitle_po_toggle",
			array(
				'label'        => __( 'Subtitle', 'boostify' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'boostify' ),
				'label_on'     => __( 'Custom', 'boostify' ),
				'return_value' => 'yes',
				'separator'    => 'before',
			)
		);
		$this->start_popover();
		$this->add_responsive_control(
			"{$form_type}_form_subtitle_margin",
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .form-subtitle" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_form_subtitle_po_toggle" => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			"{$form_type}_form_subtitle_padding",
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .form-subtitle" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_form_subtitle_po_toggle" => 'yes',
				),
			)
		);
		$this->add_control(
			"{$form_type}_form_subtitle_color",
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .form-subtitle" => 'color: {{VALUE}};',
				),
				'condition' => array(
					"{$form_type}_form_subtitle_po_toggle" => 'yes',
				),
			)
		);

		$this->add_control(
			"{$form_type}_form_subtitle_bg_color",
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .form-subtitle" => 'background: {{VALUE}};',
				),
				'condition' => array(
					"{$form_type}_form_subtitle_po_toggle" => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => "{$form_type}_form_subtitle_border",
				'selector'  => "{{WRAPPER}} .{$form_type}-form-wrapper .form-subtitle",
				'condition' => array(
					"{$form_type}_form_subtitle_po_toggle" => 'yes',
				),
			)
		);
		$this->add_control(
			"{$form_type}_form_subtitle_border_radius",
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .form-subtitle" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_form_subtitle_po_toggle" => 'yes',
				),
			)
		);

		$this->end_popover();
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => "{$form_type}_form_subtitle_typo",
				'label'    => __( 'Subtitle Typography', 'boostify' ),
				'selector' => "{{WRAPPER}} .{$form_type}-form-wrapper .form-subtitle",
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Style input Form Control.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function style_input_fields_controls() {
		$this->start_controls_section(
			'section_style_form_fields',
			array(
				'label' => __( 'Form Fields', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'form_field_po_toggle',
			array(
				'label'        => __( 'Spacing', 'boostify' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'boostify' ),
				'label_on'     => __( 'Custom', 'boostify' ),
				'return_value' => 'yes',
			)
		);

		$this->start_popover();
		$this->add_control(
			'form_input_fields_heading',
			array(
				'type'  => Controls_Manager::HEADING,
				'label' => __( 'Form Input Fields', 'boostify' ),
			)
		);
		$this->add_responsive_control(
			'form_field_margin',
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .field-control' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'form_field_po_toggle' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'form_field_padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'form_field_po_toggle' => 'yes',
				),
			)
		);

		$this->end_popover();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'fields_typography',
				'selector' => '{{WRAPPER}} .boostify-field',
			)
		);
		$this->add_responsive_control(
			'fields_align',
			array(
				'label'     => __( 'Text Alignment', 'boostify' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'boostify' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'boostify' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'boostify' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .boostify-field' => 'text-align: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'form_label_colors_heading',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Colors & Border', 'boostify' ),
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_form_fields_style' );

		$this->start_controls_tab(
			'tab_form_field_style_normal',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);
		$this->add_control(
			'field_color',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-field' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'field_placeholder_color',
			array(
				'label'     => __( 'Placeholder Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wp-login-register-wrapper ::placeholder' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'field_bg_color',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .boostify-field' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'field_border',
				'selector' => '{{WRAPPER}} .boostify-field, {{WRAPPER}} .checkmark',
			)
		);

		$this->add_control(
			'field_border_radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-field, {{WRAPPER}} .checkmark' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_form_field_style_active',
			array(
				'label' => __( 'Focus', 'boostify' ),
			)
		);

		$this->add_control(
			'field_placeholder_color_active',
			array(
				'label'     => __( 'Placeholder Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-field:focus::placeholder' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'field_bg_color_active',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .boostify-field:focus' => 'background-color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'field_border_focus',
				'selector' => '{{WRAPPER}} .boostify-field:focus',
			)
		);
		$this->add_control(
			'field_border_radius_focus',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-field:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Style Label Form Control.
	 *
	 * @access private
	 */
	private function style_labels_controls() {
		$this->start_controls_section(
			'section_style_form_labels',
			array(
				'label' => __( 'Form Labels', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'form_label_po_toggle',
			array(
				'label'        => __( 'Spacing', 'boostify' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'boostify' ),
				'label_on'     => __( 'Custom', 'boostify' ),
				'return_value' => 'yes',
			)
		);

		$this->start_popover();

		$this->add_responsive_control(
			'form_label_margin',
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .field-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'form_label_po_toggle' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'form_label_padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .field-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'form_label_po_toggle' => 'yes',
				),
			)
		);

		$this->end_popover();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .field-label',
			)
		);

		$this->add_control(
			'form_label_c_po_toggle',
			array(
				'label'        => __( 'Colors', 'boostify' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'boostify' ),
				'label_on'     => __( 'Custom', 'boostify' ),
				'return_value' => 'yes',
			)
		);

		$this->start_popover();

		$this->add_control(
			'label_color',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .field-label' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'form_label_c_po_toggle' => 'yes',
				),
			)
		);
		$this->add_control(
			'label_bg_color',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .field-label' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'form_label_c_po_toggle' => 'yes',
				),
			)
		);
		$this->end_popover();

		$this->add_control(
			'form_label_b_po_toggle',
			array(
				'label'        => __( 'Border', 'boostify' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'boostify' ),
				'label_on'     => __( 'Custom', 'boostify' ),
				'return_value' => 'yes',
			)
		);

		$this->start_popover();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'label_border',
				'selector'  => '{{WRAPPER}} .field-label',
				'condition' => array(
					'form_label_b_po_toggle' => 'yes',
				),
			)
		);

		$this->add_control(
			'label_border_radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .field-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'form_label_b_po_toggle' => 'yes',
				),
			)
		);
		$this->end_popover();

		$this->add_control(
			'form_icon_po_toggle',
			array(
				'label' => __( 'Icon', 'boostify' ),
				'type'  => Controls_Manager::POPOVER_TOGGLE,
			)
		);

		$this->start_popover();

		$this->add_control(
			'icon_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item-icon' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'form_icon_po_toggle' => 'yes',
				),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Font Size', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .menu-item-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'form_icon_po_toggle' => 'yes',
				),
			)
		);

		$this->end_popover();

		$this->add_control(
			'rmark_po_toggle',
			array(
				'label'     => __( 'Required Mark Style', 'boostify' ),
				'type'      => Controls_Manager::POPOVER_TOGGLE,
				'condition' => array(
					'show_labels'   => 'yes',
					'mark_required' => 'yes',
				),
			)
		);

		$this->start_popover();

		$this->add_control(
			'rmark_sign',
			array(
				'label'       => __( 'Mark Sign', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '*',
				'placeholder' => 'Enter * or (required) etc.',
				'selectors'   => array(
					'{{WRAPPER}} .field-label.mark-required:after' => 'content: {{VALUE}};',
				),
				'condition'   => array(
					'rmark_po_toggle' => 'yes',
				),
			)
		);

		$this->add_control(
			'rmark_size',
			array(
				'label'      => esc_html__( 'Size', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .field-label.mark-required:after' => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'rmark_po_toggle' => 'yes',
				),
			)
		);

		$this->add_control(
			'rmakr_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .field-label.mark-required:after' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'rmark_po_toggle' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'rmark_valign',
			array(
				'label'     => esc_html__( 'Vertical Alignment', 'boostify' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => - 50,
						'max'  => 50,
						'step' => 0,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 17,
				),
				'selectors' => array(
					'{{WRAPPER}} .field-label.mark-required:after' => 'top: {{SIZE}}px;',
				),
				'condition' => array(
					'rmark_po_toggle' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'rmark_halign',
			array(
				'label'     => esc_html__( 'Horizontal Alignment', 'boostify' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => - 50,
						'max'  => 50,
						'step' => 0,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => - 10,
				),
				'selectors' => array(
					'{{WRAPPER}} .field-label.mark-required:after' => 'right: {{SIZE}}px;',
				),
				'condition' => array(
					'rmark_po_toggle' => 'yes',
				),
			)
		);

		$this->end_popover();

		$this->add_control(
			'lpv_po_toggle',
			array(
				'label'     => __( 'Password Visibility Style', 'boostify' ),
				'type'      => Controls_Manager::POPOVER_TOGGLE,
				'condition' => array(
					'password_toggle' => 'yes',
				),
			)
		);

		$this->start_popover();

		$this->add_responsive_control(
			'lpv_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'rem',
					'%',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .visibility-password' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'lpv_po_toggle' => 'yes',
				),
			)
		);

		$this->add_control(
			'lvp_open_color',
			array(
				'label'     => __( 'Open Eye Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .dashicons-visibility' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'lpv_po_toggle' => 'yes',
				),
			)
		);

		$this->add_control(
			'lvp_close_color',
			array(
				'label'     => __( 'Close Eye Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .dashicons-hidden' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'lpv_po_toggle' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'lpv_valign',
			array(
				'label'     => esc_html__( 'Vertical Alignment', 'boostify' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => - 50,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 0.73,
				),
				'selectors' => array(
					'{{WRAPPER}} .visibility-password' => 'top: {{SIZE}}px;',
				),
				'condition' => array(
					'lpv_po_toggle' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'lpv_halign',
			array(
				'label'     => esc_html__( 'Horizontal Alignment', 'boostify' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => - 50,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => - 27,
				),
				'selectors' => array(
					'{{WRAPPER}} .visibility-password' => 'right: {{SIZE}}px;',
				),
				'condition' => array(
					'lpv_po_toggle' => 'yes',
				),
			)
		);

		$this->end_popover();

		$this->add_control(
			'form_rm_fields_heading',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Remember Me Field', 'boostify' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'remember_me_style_pot',
			array(
				'label'        => __( 'Remember Me Style', 'boostify' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'boostify' ),
				'label_on'     => __( 'Custom', 'boostify' ),
				'return_value' => 'yes',
				'condition'    => array(
					'login_show_remember_me' => 'yes',
				),
			)
		);

		$this->start_popover();

		$this->add_responsive_control(
			'form_rm_field_margin',
			array(
				'label'      => __( 'Container Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .field-control.field-forgot-password' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'remember_me_style_pot' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'form_rm_field_padding',
			array(
				'label'      => __( 'Container Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .field-control.field-forgot-password' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'remember_me_style_pot' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'form_rm_lbl_margin',
			array(
				'label'      => __( 'Label Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .field-control.field-remember-me' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'remember_me_style_pot' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'form_rm_lbl_padding',
			array(
				'label'      => __( 'Label Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .field-control.field-remember-me' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'remember_me_style_pot' => 'yes',
				),
			)
		);

		$this->add_control(
			'rm_label_color',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .field-control.field-remember-me' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'remember_me_style_pot' => 'yes',
				),
			)
		);

		$this->add_control(
			'rm_label_bg_color',
			array(
				'label'     => __( 'Text Background', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .field-control.field-remember-me' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'remember_me_style_pot' => 'yes',
				),
			)
		);

		$this->add_control(
			'rm_checkbox_color',
			array(
				'label'     => __( 'Checkbox', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .field-control.field-remember-me input[type=checkbox]:checked' => 'border-color: {{VALUE}};background: {{VALUE}};',
				),
				'condition' => array(
					'remember_me_style_pot' => 'yes',
				),
			)
		);

		$this->end_popover();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'    => __( 'Remember Me Typography', 'boostify' ),
				'name'     => 'rm_label_typography',
				'selector' => '{{WRAPPER}} .field-control.field-remember-me',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Style button submit Form Control.
	 *
	 * @since 1.0.0
	 *
	 * @param string $form_type | Form Type.
	 *
	 * @access private
	 */
	private function button_style_controls( $form_type = 'login' ) {

		$this->start_controls_section(
			"section_style_{$form_type}_btn",
			array(
				'label'      => sprintf( __( '%s Button', 'boostify' ), ucfirst( $form_type ) ), //phpcs:ignore
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'  => "show_{$form_type}_link",
							'value' => 'yes',
						),
						array(
							'name'  => 'default_form_type',
							'value' => $form_type,
						),
					),
				),
			)
		);
		$this->add_control(
			"{$form_type}_btn_pot",
			array(
				'label'        => __( 'Spacing', 'boostify' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'boostify' ),
				'label_on'     => __( 'Custom', 'boostify' ),
				'return_value' => 'yes',
			)
		);

		$this->start_popover();

		$this->add_responsive_control(
			"{$form_type}_btn_margin",
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .wp-login-register-wrapper .btn-{$form_type}" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_btn_pot" => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			"{$form_type}_btn_padding",
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .wp-login-register-wrapper .btn-{$form_type}" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_btn_pot" => 'yes',
				),
			)
		);

		$this->end_popover();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => "{$form_type}_btn_typography",
				'selector' => "{{WRAPPER}} .wp-login-register-wrapper .btn-{$form_type}",
			)
		);

		$this->add_responsive_control(
			"{$form_type}_btn_d_type",
			array(
				'label'     => __( 'Display as', 'boostify' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'row'    => __( 'Inline', 'boostify' ),
					'column' => __( 'Block', 'boostify' ),
				),
				'default'   => 'row',
				'selectors' => array(
					"{{WRAPPER}} .boostify-form-{$form_type} .form-action-footer"    => 'flex-direction: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			"{$form_type}_btn_jc",
			array(
				'label'     => __( 'Justify Content', 'boostify' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'flex-start'    => __( 'Start', 'boostify' ),
					'flex-end'      => __( 'End', 'boostify' ),
					'center'        => __( 'Center', 'boostify' ),
					'space-between' => __( 'Space Between', 'boostify' ),
					'space-around'  => __( 'Space Around', 'boostify' ),
					'space-evenly'  => __( 'Space Evenly', 'boostify' ),
				),
				'default'   => 'space-between',
				'condition' => array(
					"{$form_type}_btn_d_type" => 'row',
				),
				'selectors' => array(
					"{{WRAPPER}} .boostify-form-{$form_type} .form-action-footer" => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			"{$form_type}_btn_align",
			array(
				'label'     => __( 'Alignment', 'boostify' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => __( 'Left', 'boostify' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center'     => array(
						'title' => __( 'Center', 'boostify' ),
						'icon'  => 'eicon-h-align-center',
					),
					'flex-end'   => array(
						'title' => __( 'Right', 'boostify' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'   => '',
				'condition' => array(
					"{$form_type}_btn_d_type" => 'column',
				),
				'selectors' => array(
					"{{WRAPPER}} .boostify-form-{$form_type} .form-action-footer" => 'align-items: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			"tabs_{$form_type}_btn_colors_heading",
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Colors & Border', 'boostify' ),
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( "tabs_{$form_type}_btn_style" );

		$this->start_controls_tab(
			"tab_{$form_type}_btn_normal",
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);

		$this->add_control(
			"{$form_type}_btn_color",
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					"{{WRAPPER}} .wp-login-register-wrapper .btn-{$form_type}" => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => "{$form_type}_btn_bg_color",
				'label'    => __( 'Background Color', 'boostify' ),
				'types'    => array(
					'classic',
					'gradient',
				),
				'selector' => "{{WRAPPER}} .wp-login-register-wrapper .btn-{$form_type}",
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => "{$form_type}_btn_border",
				'selector' => "{{WRAPPER}} .wp-login-register-wrapper .btn-{$form_type}",
			)
		);

		$this->add_control(
			"{$form_type}_btn_border_radius",
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .wp-login-register-wrapper .btn-{$form_type}" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			"tab_{$form_type}_button_hover",
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);

		$this->add_control(
			"{$form_type}_button_color_hover",
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					"{{WRAPPER}} .wp-login-register-wrapper .btn-{$form_type}:hover" => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => "{$form_type}_btn_bg_color_hover",
				'label'    => __( 'Background Color', 'boostify' ),
				'types'    => array(
					'classic',
					'gradient',
				),
				'selector' => "{{WRAPPER}} .wp-login-register-wrapper .btn-{$form_type}:hover",
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => "{$form_type}_btn_border_hover",
				'selector' => "{{WRAPPER}} .wp-login-register-wrapper .btn-{$form_type}:hover",
			)
		);

		$this->add_control(
			"{$form_type}_btn_border_radius_hover",
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .wp-login-register-wrapper .btn-{$form_type}:hover" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			"{$form_type}_btn_width",
			array(
				'label'      => esc_html__( 'Button width', 'boostify' ),
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
				'selectors'  => array(
					"{{WRAPPER}} .wp-login-register-wrapper .btn-{$form_type}" => 'width: {{SIZE}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			"{$form_type}_btn_height",
			array(
				'label'      => esc_html__( 'Button Height', 'boostify' ),
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
				'selectors'  => array(
					"{{WRAPPER}} .wp-login-register-wrapper .btn-{$form_type}" => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Style button submit Form Control.
	 *
	 * @since 1.0.0
	 *
	 * @param string $form_type | Form Type.
	 *
	 * @access private
	 */
	private function link_style_controls( $form_type = 'login' ) {
		$form_name = 'login' == $form_type ? __( 'Register', 'boostify' ) : __( 'Login', 'boostify' ); //phpcs:ignore
		$this->start_controls_section(
			"section_style_{$form_type}_link",
			array(
				'label'     => sprintf( __( '%s Link', 'boostify' ), ucfirst( $form_name ) ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					"show_{$form_type}_link" => 'yes',
				),
			)
		);
		$this->add_control(
			"{$form_type}_link_style_notice",
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf( __( 'Here you can style the %s link displayed on the %s Form', 'boostify' ), $form_name, ucfirst( $form_type ) ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			)
		);

		$this->add_control(
			"{$form_type}_link_pot",
			array(
				'label'        => __( 'Spacing', 'boostify' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'boostify' ),
				'label_on'     => __( 'Custom', 'boostify' ),
				'return_value' => 'yes',
			)
		);

		$this->start_popover();

		$this->add_responsive_control(
			"{$form_type}_link_margin",
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .field-link" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_link_pot" => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			"{$form_type}_link_padding",
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .field-link" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					"{$form_type}_link_pot" => 'yes',
				),
			)
		);
		$this->end_popover();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => "{$form_type}_link_typography",
				'selector' => "{{WRAPPER}} .{$form_type}-form-wrapper .field-link",
			)
		);

		$this->add_responsive_control(
			"{$form_type}_link_d_type",
			array(
				'label'     => __( 'Display as', 'boostify' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'row'    => __( 'Inline', 'boostify' ),
					'column' => __( 'Block', 'boostify' ),
				),
				'default'   => 'row',
				'selectors' => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .field-{$form_name}" => 'display:flex; flex-direction: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			"{$form_type}_link_jc",
			array(
				'label'     => __( 'Justify Content', 'boostify' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'flex-start'    => __( 'Start', 'boostify' ),
					'flex-end'      => __( 'End', 'boostify' ),
					'center'        => __( 'Center', 'boostify' ),
					'space-between' => __( 'Space Between', 'boostify' ),
					'space-around'  => __( 'Space Around', 'boostify' ),
					'space-evenly'  => __( 'Space Evenly', 'boostify' ),
				),
				'default'   => 'center',
				'condition' => array(
					"{$form_type}_link_d_type" => 'row',
				),
				'selectors' => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .field-{$form_name}" => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			"{$form_type}_link_ai",
			array(
				'label'     => __( 'Align Items', 'boostify' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'flex-start'   => __( 'Start', 'boostify' ),
					'flex-end'     => __( 'End', 'boostify' ),
					'center'       => __( 'Center', 'boostify' ),
					'stretch'      => __( 'Stretch', 'boostify' ),
					'baseline'     => __( 'Baseline', 'boostify' ),
					'space-evenly' => __( 'Space Evenly', 'boostify' ),
				),
				'default'   => 'center',
				'condition' => array(
					"{$form_type}_link_d_type" => 'column',
				),
				'selectors' => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .field-{$form_name}" => 'align-items: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			"{$form_type}_link_align",
			array(
				'label'     => __( 'Alignment', 'boostify' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'mr-auto'         => array(
						'title' => __( 'Left', 'boostify' ),
						'icon'  => 'eicon-h-align-left',
					),
					'ml-auto mr-auto' => array(
						'title' => __( 'Center', 'boostify' ),
						'icon'  => 'eicon-h-align-center',
					),
					'ml-auto'         => array(
						'title' => __( 'Right', 'boostify' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'   => '',
				'condition' => array(
					"{$form_type}_link_d_type" => 'column',
				),
			)
		);

		$this->add_control(
			"tabs_{$form_type}_link_colors_heading",
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => __( 'Colors & Border', 'boostify' ),
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( "tabs_{$form_type}_link_style" );

		$this->start_controls_tab(
			"tab_{$form_type}_link_normal",
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);

		$this->add_control(
			"{$form_type}_link_color",
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .field-link" => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => "{$form_type}_link_bg_color",
				'label'    => __( 'Background Color', 'boostify' ),
				'types'    => array(
					'classic',
					'gradient',
				),
				'selector' => "{{WRAPPER}} .{$form_type}-form-wrapper .field-link",
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => "{$form_type}_link_border",
				'selector' => "{{WRAPPER}} .{$form_type}-form-wrapper .field-link",
			)
		);

		$this->add_control(
			"{$form_type}_link_border_radius",
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .field-link" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			"tab_{$form_type}_link_hover",
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);

		$this->add_control(
			"{$form_type}_link_color_hover",
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .field-link:hover" => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => "{$form_type}_link_bg_color_hover",
				'label'    => __( 'Background Color', 'boostify' ),
				'types'    => array(
					'classic',
					'gradient',
				),
				'selector' => "{{WRAPPER}} .{$form_type}-form-wrapper .field-link:hover",
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => "{$form_type}_link_border_hover",
				'selector' => "{{WRAPPER}} .{$form_type}-form-wrapper .field-link:hover",
			)
		);

		$this->add_control(
			"{$form_type}_link_border_radius_hover",
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .field-link:hover" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			"{$form_type}_link_wrap_width",
			array(
				'label'      => esc_html__( 'Link Container width', 'boostify' ),
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
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .field-{$form_name}" => 'width: {{SIZE}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			"{$form_type}_link_width",
			array(
				'label'      => esc_html__( 'Link width', 'boostify' ),
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
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .field-link" => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			"{$form_type}_link_height",
			array(
				'label'      => esc_html__( 'Link Height', 'boostify' ),
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
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .field-link" => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Recaptcha Style Form Control.
	 *
	 * @since 1.0.0
	 *
	 * @param string $form_type | Form Type.
	 *
	 * @access private
	 */
	protected function recaptcha_style( $form_type = 'login' ) {
		$this->start_controls_section(
			"section_style_{$form_type}_rc",
			array(
				'label'     => sprintf( __( '%s Form reCAPTCHA', 'boostify' ), ucfirst( $form_type ) ), //phpcs:ignore
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					"enable_{$form_type}_recaptcha" => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			"{$form_type}_rc_margin",
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					"{{WRAPPER}} .{$form_type}-form-wrapper .field-control.fiel-recaptcha" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),

			)
		);

		$this->add_control(
			"{$form_type}_rc_theme",
			array(
				'label'              => __( 'Theme', 'boostify' ),
				'type'               => Controls_Manager::SELECT,
				'frontend_available' => true,
				'options'            => array(
					'light' => __( 'Light', 'boostify' ),
					'dark'  => __( 'Dark', 'boostify' ),
				),
				'default'            => 'light',
			)
		);

		$this->add_control(
			"{$form_type}_rc_size",
			array(
				'label'              => __( 'Size', 'boostify' ),
				'type'               => Controls_Manager::SELECT,
				'frontend_available' => true,
				'options'            => array(
					'normal'  => __( 'Normal', 'boostify' ),
					'compact' => __( 'Compact', 'boostify' ),
				),
				'default'            => 'normal',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Form Register
	 *
	 * @param string $settings  Setting in elemetor.
	 * @param string $popup  Popup.
	 * @since 1.0.0
	 */
	private function form_register( $settings, $popup ) {
		$recaptcha_sitekey      = get_option( 'boostify_recaptcha_site_key' );
		$recaptcha_secretkey    = get_option( 'boostify_recaptcha_secret_key' );
		$recaptcha_sitekey_v3   = get_option( 'boostify_recaptcha_v3_site_key' );
		$recaptcha_secretkey_v3 = get_option( 'boostify_recaptcha_v3_secret_key' );
		$recaptcha              = ( ! empty( $recaptcha_sitekey ) && ! empty( $recaptcha_sitekey ) ) ? true : false;
		$recaptchav3            = ( ! empty( $recaptcha_sitekey_v3 ) && ! empty( $recaptcha_secretkey_v3 ) ) ? true : false;
		$id                     = $this->get_id();
		if ( $recaptchav3 ) {
			$recaptcha_sitekey = $recaptcha_sitekey_v3;
		}

		$register_action = is_string( $settings['register_action'] ) ? array( $settings['register_action'] ) : $settings['register_action'];
		?>
			<div class="register-form-header">
				<div class="form-header-wrapper">
					<?php if ( ! empty( $settings['logo']['id'] ) ) : ?>
						<div class="header-logo">
							<?php
								$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $settings['logo']['id'], 'logo_size', $settings );

							?>
							<img class="header-logo-img" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( 'Header Logo' ); ?>">

						</div>
					<?php endif ?>

					<?php if ( ! empty( $settings['register_form_title'] ) ) : ?>
						<div class="form-title">
							<h3 class="title"><?php echo esc_html( $settings['register_form_title'] ); ?></h3>
							<span class="form-subtitle">
								<?php echo esc_html( $settings['register_form_subtitle'] ); ?>
							</span>
						</div>
					<?php endif ?>
				</div>
			</div>
			<form class="wp-form-register" name="wp-form-register">
				<?php do_action( 'boostify_addon_register_form_before' ); ?>

				<?php
				foreach ( $settings['register_fields'] as $f_index => $field ) :
					$type = 'text';
					switch ( $field['field_type'] ) {
						case 'email':
							$type = 'email';
							break;

						case 'password':
						case 'confirm_pass':
							$type = 'password';
							break;

						case 'website':
							$type = 'url';
							break;

						default:
							$type = 'text';
							break;
					}

					$label_class  = 'field-label';
					$label_class .= ( 'yes' == $field['required'] || 'username' == $field['field_type'] || 'email' == $field['field_type'] ) ? ' required' : ''; //phpcs:ignore
					$label_class .= ( 'yes' == $settings['mark_required'] ) ? ' mark-required' : ''; //phpcs:ignore

					$field_class  = 'field-control ' . $field['field_type'];
					$field_class .= ( ! empty( $settings['width'] ) ) ? ' boostify-col-' . $settings['width'] : '';
					$field_class .= ( ! empty( $settings['width_tablet'] ) ) ? ' elementor-md-' . $settings['width_tablet'] : '';
					$field_class .= ( ! empty( $settings['width_mobile'] ) ) ? ' elementor-sm-' . $settings['width_mobile'] : '';
					$field_class .= ( 'yes' == $field['required'] || 'username' == $field['field_type'] || 'email' == $field['field_type'] ) ? ' field-required' : ''; //phpcs:ignore
					$required = ( 'yes' == $field['required'] || 'username' == $field['field_type'] || 'email' == $field['field_type'] ) ? 'required' : ''; //phpcs:ignore
					$icon_class = ! empty( $field['icon']['value'] ) ? ' has-icon' : '';

					?>
					<div class="<?php echo esc_attr( $field_class ); ?>">
						<?php if ( 'yes' == $settings['show_labels'] ) : //phpcs:ignore ?>
							<label for="boostify-field-<?php echo esc_attr( $field['_id'] ); ?>" class="<?php echo esc_attr( $label_class ); ?>"><?php echo esc_html( $field['field_label'] ); ?></label>
						<?php endif ?>
						<div class="field-wrapper<?php echo esc_attr( $icon_class ); ?>">
							<?php $this->get_field_icon( $field['icon'] ); ?>
							<input type="<?php echo esc_attr( $type ); ?>" id="boostify-field-<?php echo esc_attr( $field['_id'] ); ?>" class="field-input boostify-field" name="<?php echo esc_attr( $field['field_type'] . '_register' ); ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" <?php echo esc_attr( $required ); ?>>
						</div>
					</div>
					<?php

				endforeach;

				do_action( 'boostify_before_register_google_recaptcha' );

				if ( 'yes' == $settings['enable_register_recaptcha'] ): //phpcs:ignore
					boostify_get_google_recaptcha( $id );
				endif;

				?>

				<?php do_action( 'boostify_addon_register_form_after' ); ?>
				<?php if ( 'yes' == $settings['show_terms_conditions'] ) : //phpcs:ignore ?>
					<div class="field-control field-terms-conditions">
						<label for="label-terms-<?php echo esc_attr( $id ); ?>" class="field-label">
							<input type="checkbox" name="terms_conditions" class=" field-checkbox boostify-field" value="1" id="label-terms-<?php echo esc_attr( $id ); ?>">
							<span class="checkmark"></span>
							<span class="label-terms">
								<?php
								$url        = '#';
								$attributes = '';
								if ( 'custom' == $settings['acceptance_text_source'] && $settings['acceptance_text_url']['url'] ) { // phpcs:ignore
									$url         = $settings['acceptance_text_url']['url'];
									$attributes .= ! empty( $settings['acceptance_text_url']['is_external'] ) ? ' target="_blank"' : '';
									$attributes .= ! empty( $settings['acceptance_text_url']['nofollow'] ) ? ' rel="nofollow"' : '';
								}

								$html  = '<a href="' . $url . '" class="term-conditions_link"' . $attributes . '>';
								$label = str_replace( '[', $html, $settings['acceptance_label'] );
								$label = str_replace( ']', '</a>', $label );
								echo wp_kses(
									$label,
									array(
										'a' => array(
											'class'  => array(),
											'href'   => array(),
											'id'     => array(),
											'target' => array(),
											'rel'    => array(),
										),
									)
								);
								?>
							</span>
						</label>
						<?php if ( 'editor' == $settings['acceptance_text_source'] ) : //phpcs:ignore ?>
							<div class="boostify-terms-conditions-popup">
								<div class="terms-conditions-popup-wrapper">
									<?php echo $settings['acceptance_text']; // phpcs:ignore ?>
								</div>
							</div>
						<?php endif ?>
					</div>
				<?php endif ?>
				<div class="form-action-footer">
					<div class="field-control field-submit">
						<div class="group-control">
							<?php if ( ! empty( $settings['register_action'] ) ) : ?>
								<input type="hidden" value="<?php echo esc_html( implode( ',', $register_action ) ); ?>" name="register_action">
							<?php endif ?>

							<?php if ( 'yes' == $settings['enable_register_recaptcha'] ) : // phpcs:ignore ?>
								<input type="hidden" value="<?php echo esc_html( $recaptcha_sitekey ); ?>" name="g-recaptcha">
							<?php endif ?>
							<?php if ( ! empty( $settings['register_action'] ) && in_array( 'redirect', $register_action ) && $settings['register_redirect_url']['url'] ) : //phpcs:ignore ?>
								<input type="hidden" name="register_redirect_url" value="<?php echo esc_url( $settings['register_redirect_url']['url'] ); ?>">
							<?php endif ?>
							<?php if ( 'custom' == $settings['reg_admin_email_template_type'] ) : // phpcs:ignore ?>
								<?php if ( ! empty( $settings['reg_admin_email_subject'] ) ) : ?>
									<input type="hidden" value="<?php echo esc_html( $settings['reg_admin_email_subject'] ); ?>" name="admin_email_subject">
								<?php endif ?>
								<?php if ( ! empty( $settings['reg_admin_email_message'] ) ) : ?>
									<input type="hidden" value="<?php echo esc_html( $settings['reg_admin_email_message'] ); ?>" name="admin_email_message">
								<?php endif ?>
								<input type="hidden" value="<?php echo esc_html( $settings['reg_admin_email_content_type'] ); ?>" name="admin_email_content_type">
							<?php endif ?>
							<?php if ( 'custom' == $settings['reg_email_template_type'] ) : // phpcs:ignore ?>
								<?php if ( ! empty( $settings['reg_email_subject'] ) ) : ?>
									<input type="hidden" value="<?php echo esc_html( $settings['reg_email_subject'] ); ?>" name="email_subject">
								<?php endif ?>
								<?php if ( ! empty( $settings['reg_email_message'] ) ) : ?>
									<input type="hidden" value="<?php echo esc_html( $settings['reg_email_message'] ); ?>" name="email_message">
								<?php endif ?>
								<input type="hidden" value="<?php echo esc_html( $settings['reg_email_content_type'] ); ?>" name="email_content_type">
							<?php endif ?>
						</div>
						<div class="field-messages"></div>

						<button type="submit" class="btn-submit btn-register"><?php echo esc_html( $settings['register_button_text'] ); ?></button>
					</div>
					<?php if ( 'yes' == $settings['show_login_link'] && ! $popup ) : //phpcs:ignore ?>
						<?php
						$link      = '#';
						$link_atts = '';
						switch ( $settings['login_link_action'] ) {
							case 'default':
								$link = wp_registration_url();
								break;

							case 'custom':
								if ( ! empty( $settings['custom_login_url']['url'] ) ) {
									$link       = $settings['custom_login_url']['url'];
									$link_atts  = ! empty( $settings['custom_login_url']['is_external'] ) ? ' target="_blank"' : '';
									$link_atts .= ! empty( $settings['custom_login_url']['nofollow'] ) ? ' rel="nofollow"' : '';
								}
								break;

							default:
								$link = '#';
								break;
						}
						?>
						<div class="field-control field-login field-link">
							<a href="<?php echo esc_url( $link ); ?>" <?php echo $link_atts; //phpcs:ignore ?>>
								<?php echo esc_html( $settings['login_link_text'] ); ?>
							</a>
						</div>
					<?php endif ?>

				</div>
			</form>
			<?php if ( 'yes' == $settings['show_login_link'] && ! $popup && 'form' == $settings['login_link_action']  ) : //phpcs:ignore ?>
				<div class="form-popup popup-login">
					<div class="form-popup-wrapper">
						<?php $this->get_login_template( $popup = true ); ?>
					</div>
					<div class="popup-overlay"></div>
				</div>
			<?php endif ?>
		<?php
	}

	/**
	 * Get icon
	 *
	 * @param string $icon Setting in elemetor.
	 * @since 1.0.0
	 */
	private function get_field_icon( $icon ) {
		if ( ! empty( $icon['value'] ) ) :
			if ( is_string( $icon['value'] ) ) :
				?>
				<span class="menu-item-icon <?php echo esc_attr( $icon['value'] ); ?>"></span>
			<?php else : ?>
				<span class="menu-item-icon menu-item-icon-svg">
					<?php Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?>
				</span>
				<?php
			endif;
		endif;
	}
}
