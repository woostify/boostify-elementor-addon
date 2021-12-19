<?php
/**
 * Widget Team Member.
 *
 * @since 1.0.0
 * @package Boostify Addon
 */

namespace Boostify_Elementor\Widgets;

use Boostify_Elementor\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Boostify_Elementor\Basic\Skin\Layout as Layout;


/**
 * Team_Member
 *
 * Elementor widget for Team_Member.
 * Author: ptp
 */
class Team_Member extends Base_Widget {
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
		return 'team_member';
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
		return esc_html__( 'Team Member', 'boostify' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'boostify eicon-user-circle-o';
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
		return array( 'boostify-addon-testimonial' );
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
	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 */
	protected function _register_controls() { // phpcs:ignore
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Team Member', 'boostify' ),
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => __( 'Layout', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => $this->layouts(),
			)
		);

		$this->add_control(
			'image',
			array(
				'label'   => __( 'Avatar', 'boostify' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_control(
			'name',
			array(
				'label'       => __( 'Name', 'boostify' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'Emma Adela',
				'label_block' => 'true',
			)
		);

		$this->add_control(
			'position',
			array(
				'label'       => __( 'Position', 'boostify' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'Tour Guide',
				'label_block' => 'true',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			array(
				'name'    => 'size', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'full',
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'icon',
			array(
				'label'       => esc_html__( 'Icon', 'boostify' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => array(
					'value'   => 'fas fa-star',
					'library' => 'solid',
				),
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'boostify' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => esc_attr( 'https://member-link.com' ),
				'default'     => array(
					'is_external' => 'true',
					'url'         => '#',
				),
			)
		);

		$this->add_control(
			'contact_list',
			array(
				'label'       => esc_html__( 'Social Icons', 'boostify' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ icon.value }}}',
				'default'     => array(
					array(
						'icon' => 'fas fa-twitter',
					),
				),
			)
		);

		$this->add_control(
			'content_align',
			array(
				'label'     => esc_html__( 'Align', 'boostify' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'boostify' ),
						'icon'  => 'fa fa-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'boostify' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'boostify' ),
						'icon'  => 'fa fa-align-right',
					),
				),

				'selectors' => array(
					'{{WRAPPER}} .widget-team-member' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .member-info'        => 'align-items: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => __( 'Style', 'boostify' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'name_heading',
			array(
				'label' => __( 'Name', 'boostify' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->start_controls_tabs( 'name_style' );

		$this->start_controls_tab(
			'name_normal',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);

		$this->add_control(
			'color_name',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => array(
					'{{WRAPPER}} .member-info .member-name' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'name_hover',
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);

		$this->add_control(
			'name_color_hover',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#333',
				'selectors' => array(
					'{{WRAPPER}} .widget-team-member--wrapper:hover .member-info .member-name' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'name_typography',
				'label'    => __( 'Typography', 'boostify' ),
				'selector' => '{{WRAPPER}} .member-name',
			)
		);

		$this->add_control(
			'position_heading',
			array(
				'label'     => __( 'Position', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'position_style' );

		$this->start_controls_tab(
			'position_normal',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);

		$this->add_control(
			'color_position',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#787878',
				'selectors' => array(
					'{{WRAPPER}} .member-info .member-position' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'position_hover',
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);

		$this->add_control(
			'position_color_hover',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#d11919',
				'selectors' => array(
					'{{WRAPPER}} .widget-team-member--wrapper:hover .member-info .member-position' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'position_typography',
				'label'    => __( 'Typography', 'boostify' ),
				'selector' => '{{WRAPPER}} .member-info .member-position',
			)
		);

		$this->add_control(
			'list_contact_heading',
			array(
				'label'     => __( 'List Contact', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'icon_font',
			array(
				'label'      => __( 'Fontsize', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 10,
						'max'  => 30,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .icon-contact' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'bdrs',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .icon-contact' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'list_contact_style' );

		$this->start_controls_tab(
			'list_contact_normal',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);

		$this->add_control(
			'color_list_contact',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .icon-contact' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'background_color_list_contact',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#777777',
				'selectors' => array(
					'{{WRAPPER}} .icon-contact' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'list_contact_hover',
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);

		$this->add_control(
			'list_contact_color_hover',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .icon-contact:hover:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'background_color_list_contact_hover',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#d11919',
				'selectors' => array(
					'{{WRAPPER}} .icon-contact:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

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
		$layout   = $settings['layout'];
		$action   = 'boostify_teammember_' . $layout;
		do_action( $action, $settings );
	}

	/**
	 * Register Layout.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	public function layouts() {
		$layout  = new Layout();
		$layouts = $layout->team_member();

		return $layouts;
	}

}
