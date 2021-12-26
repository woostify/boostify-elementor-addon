<?php
/**
 * Widget Table of Content.
 *
 * @since 1.0.0
 * @package Boostify Addon
 */

namespace Boostify_Elementor\Widgets;

use Boostify_Elementor\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;


/**
 * \Contact_Form7
 *
 * Elementor widget for \Contact Form 7.
 * Author: ptp
 */
class Contact_Form7 extends Base_Widget {
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
		return 'contact-form7';
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
		return esc_html__( 'Contact Form 7', 'boostify' );
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
		return 'boostify eicon-form-horizontal';
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

		if ( ! check_contact_form7_active() ) {
			$this->start_controls_section(
				'global_warning',
				array(
					'label' => __( 'Warning!', 'boostify' ),
				)
			);

			$this->add_control(
				'global_warning_text',
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( '<strong>Contact Form 7</strong> is not installed/activated on your site. Please install and activate <strong>Contact Form 7</strong> first.', 'boostify' ),
					'content_classes' => 'boostify-warning',
				)
			);

			$this->end_controls_section();
		} else {

			$this->start_controls_section(
				'section_info_box',
				array(
					'label' => __( 'Contact Form', 'boostify' ),
				)
			);

			$this->add_control(
				'contact_form_list',
				array(
					'label'       => esc_html__( 'Select Form', 'boostify' ),
					'type'        => Controls_Manager::SELECT,
					'label_block' => true,
					'options'     => get_list_contact_form7(),
					'default'     => '0',
				)
			);

			$this->add_control(
				'form_title',
				array(
					'label'        => __( 'Form Title', 'boostify' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'On', 'boostify' ),
					'label_off'    => __( 'Off', 'boostify' ),
					'return_value' => 'yes',
				)
			);

			$this->add_control(
				'form_title_text',
				array(
					'label'       => esc_html__( 'Title', 'boostify' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => array(
						'active' => true,
					),
					'default'     => '',
					'condition'   => array(
						'form_title' => 'yes',
					),
				)
			);

			$this->add_control(
				'form_description',
				array(
					'label'        => __( 'Form Description', 'boostify' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'On', 'boostify' ),
					'label_off'    => __( 'Off', 'boostify' ),
					'return_value' => 'yes',
				)
			);

			$this->add_control(
				'form_description_text',
				array(
					'label'     => esc_html__( 'Description', 'boostify' ),
					'type'      => Controls_Manager::TEXTAREA,
					'dynamic'   => array(
						'active' => true,
					),
					'default'   => '',
					'condition' => array(
						'form_description' => 'yes',
					),
				)
			);

			$this->add_control(
				'labels_switch',
				array(
					'label'        => __( 'Labels', 'boostify' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'label_on'     => __( 'Show', 'boostify' ),
					'label_off'    => __( 'Hide', 'boostify' ),
					'return_value' => 'yes',
				)
			);

			$this->end_controls_section();
		}

		$this->start_controls_section(
			'section_container_style',
			array(
				'label' => __( 'Form Container', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'contact_form_background',
				'label'    => __( 'Background', 'boostify' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .boostify-contact-form',
			)
		);

		$this->add_responsive_control(
			'contact_form_alignment',
			array(
				'label'       => esc_html__( 'Form Alignment', 'boostify' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options'     => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'boostify' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'boostify' ),
						'icon'  => 'eicon-h-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'boostify' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'     => 'default',
				'selectors'   => array(
					'{{WRAPPER}} .boostify-widget-contact-form-7' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'contact_form_max_width',
			array(
				'label'      => esc_html__( 'Form Max Width', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 1500,
					),
					'em' => array(
						'min' => 1,
						'max' => 80,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'contact_form_margin',
			array(
				'label'      => esc_html__( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'contact_form_padding',
			array(
				'label'      => esc_html__( 'Form Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'contact_form_border',
				'selector' => '{{WRAPPER}} .boostify-contact-form',
			)
		);

		$this->add_control(
			'contact_form_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'before',
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'contact_form_box_shadow',
				'selector' => '{{WRAPPER}} .boostify-contact-form',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_fields_title_description',
			array(
				'label' => __( 'Title & Description', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'heading_alignment',
			array(
				'label'     => __( 'Alignment', 'boostify' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'boostify' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'boostify' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'boostify' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .boostify-contact-form-7-heading' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_heading',
			array(
				'label'     => __( 'Title', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'title_text_color',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .boostify-contact-form-7-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => __( 'Typography', 'boostify' ),
				'scheme'   => Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .boostify-contact-form-7 .boostify-contact-form-7-title',
			)
		);

		$this->add_control(
			'description_heading',
			array(
				'label'     => __( 'Description', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'description_text_color',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .boostify-contact-form-7-description' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'label'    => __( 'Typography', 'boostify' ),
				'scheme'   => Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .boostify-contact-form-7 .boostify-contact-form-7-description',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_fields_style',
			array(
				'label' => __( 'Input & Textarea', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'tabs_fields_style' );

		$this->start_controls_tab(
			'tab_fields_normal',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);

		$this->add_control(
			'field_bg',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'field_text_color',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-select, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-list-item-label' => 'color: {{VALUE}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'input_spacing',
			array(
				'label'      => __( 'Spacing', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '0',
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form p:not(:last-of-type) .wpcf7-form-control-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'field_padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'text_indent',
			array(
				'label'      => __( 'Text Indent', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 60,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 30,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'text-indent: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'input_width',
			array(
				'label'      => __( 'Input Width', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1200,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'input_height',
			array(
				'label'      => __( 'Input Height', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1200,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'textarea_width',
			array(
				'label'      => __( 'Textarea Width', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1200,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'textarea_height',
			array(
				'label'      => __( 'Textarea Height', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1200,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'field_border',
				'label'       => __( 'Border', 'boostify' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-select',
				'separator'   => 'before',
			)
		);

		$this->add_control(
			'field_radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'field_typography',
				'label'     => __( 'Typography', 'boostify' ),
				'scheme'    => Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-select',
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'field_box_shadow',
				'selector'  => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control.wpcf7-select',
				'separator' => 'before',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_fields_focus',
			array(
				'label' => __( 'Focus', 'boostify' ),
			)
		);

		$this->add_control(
			'field_bg_focus',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form input:focus, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form textarea:focus' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'input_border_focus',
				'label'       => __( 'Border', 'boostify' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form input:focus, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form textarea:focus',
				'separator'   => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'focus_box_shadow',
				'selector'  => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form input:focus, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form textarea:focus',
				'separator' => 'before',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Style Tab: Label Section
		 */
		$this->start_controls_section(
			'section_label_style',
			array(
				'label'     => __( 'Labels', 'boostify' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'labels_switch' => 'yes',
				),
			)
		);

		$this->add_control(
			'label_error_note',
			array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => __( 'if <strong>label</strong> spacing doesn\'t worked, please update <strong>label</strong> display', 'boostify' ),
				'content_classes' => 'boostify-warning',
			)
		);
		$this->add_control(
			'label_disply_type',
			array(
				'label'     => __( 'Display', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''             => __( 'Default', 'boostify' ),
					'inherit'      => __( 'Inherit', 'boostify' ),
					'initial'      => __( 'Initial', 'boostify' ),
					'inline'       => __( 'Inline', 'boostify' ),
					'inline-block' => __( 'Inline Block', 'boostify' ),
					'flex'         => __( 'Flex', 'boostify' ),
					'inline-flex'  => __( 'Inline Flex', 'boostify' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form label, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form .wpcf7-quiz-label' => 'display: {{UNIT}}',
				),
			)
		);

		$this->add_control(
			'text_color_label',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form label' => 'color: {{VALUE}}',
					'{{WRAPPER}} .boostify-contact-form-7 label'             => 'color: {{VALUE}}',
				),
				'condition' => array(
					'labels_switch' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'label_spacing',
			array(
				'label'      => __( 'Spacing', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form label, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form .wpcf7-quiz-label' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'labels_switch' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'typography_label',
				'label'     => __( 'Typography', 'boostify' ),
				'scheme'    => Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form label, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-form .wpcf7-quiz-label',
				'condition' => array(
					'labels_switch' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Placeholder Section
		 */
		$this->start_controls_section(
			'section_placeholder_style',
			array(
				'label' => __( 'Placeholder', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'placeholder_switch',
			array(
				'label'        => __( 'Show Placeholder', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'boostify' ),
				'label_off'    => __( 'No', 'boostify' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'text_color_placeholder',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control::-webkit-input-placeholder' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'placeholder_switch' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'typography_placeholder',
				'label'     => __( 'Typography', 'boostify' ),
				'scheme'    => Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form-control::-webkit-input-placeholder',
				'condition' => array(
					'placeholder_switch' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_radio_checkbox_style',
			array(
				'label' => __( 'Radio & Checkbox', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'custom_radio_checkbox',
			array(
				'label'        => __( 'Custom Styles', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'boostify' ),
				'label_off'    => __( 'No', 'boostify' ),
				'return_value' => 'yes',
			)
		);

		$this->add_responsive_control(
			'radio_checkbox_size',
			array(
				'label'      => __( 'Size', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'size' => '15',
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 80,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wpcf7-radio input[type=radio]' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .wpcf7-checkbox input[type=checkbox]' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',

				),
				'condition'  => array(
					'custom_radio_checkbox' => 'yes',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_radio_checkbox_style' );

		$this->start_controls_tab(
			'radio_checkbox_normal',
			array(
				'label'     => __( 'Normal', 'boostify' ),
				'condition' => array(
					'custom_radio_checkbox' => 'yes',
				),
			)
		);

		$this->add_control(
			'radio_checkbox_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .wpcf7-radio input[type=radio], {{WRAPPER}} .wpcf7-checkbox input[type=checkbox]' => 'border-color: {{VALUE}}',
				),
				'condition' => array(
					'custom_radio_checkbox' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'radio_checkbox_border_width',
			array(
				'label'      => __( 'Border Width', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 15,
						'step' => 1,
					),
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .wpcf7-radio input[type=radio], {{WRAPPER}} .wpcf7-checkbox input[type=checkbox]' => 'border-width: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'custom_radio_checkbox' => 'yes',
				),
			)
		);

		$this->add_control(
			'checkbox_heading',
			array(
				'label'     => __( 'Checkbox', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'custom_radio_checkbox' => 'yes',
				),
			)
		);

		$this->add_control(
			'checkbox_border_radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wpcf7-checkbox input[type=checkbox], .wpcf7-checkbox input[type=checkbox]:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'custom_radio_checkbox' => 'yes',
				),
			)
		);

		$this->add_control(
			'radio_heading',
			array(
				'label'     => __( 'Radio Buttons', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'custom_radio_checkbox' => 'yes',
				),
			)
		);

		$this->add_control(
			'radio_border_radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wpcf7-radio input[type=radio],{{WRAPPER}}  .wpcf7-radio input[type=radio]:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'custom_radio_checkbox' => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'radio_checkbox_checked',
			array(
				'label'     => __( 'Checked', 'boostify' ),
				'condition' => array(
					'custom_radio_checkbox' => 'yes',
				),
			)
		);

		$this->add_control(
			'radio_checkbox_color_checked',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .wpcf7-radio input:checked:after, {{WRAPPER}} .wpcf7-checkbox input:checked:after' => 'background: {{VALUE}}',
				),
				'condition' => array(
					'custom_radio_checkbox' => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'checkbox_display',
			array(
				'label'     => esc_html__( 'Display', 'boostify' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'inline-flex' => array(
						'title' => esc_html__( 'Inline', 'boostify' ),
						'icon'  => 'eicon-ellipsis-h',
					),
					'block'       => array(
						'title' => esc_html__( 'List', 'boostify' ),
						'icon'  => 'eicon-editor-list-ul',
					),
				),
				'default'   => 'inline-flex',
				'selectors' => array(
					'{{WRAPPER}} .wpcf7-list-item' => 'display: {{VALUE}}',
				),
				'toggle'    => true,
			)
		);

		$this->add_responsive_control(
			'checkbox_item_space_inline',
			array(
				'label'      => __( 'Item Space', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => 'px',
					'size' => 30,
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wpcf7-list-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'checkbox_display' => 'inline-flex',
				),
			)
		);

		$this->add_responsive_control(
			'checkbox_item_space_block',
			array(
				'label'      => __( 'Item Space', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => 'px',
					'size' => 30,
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .wpcf7-list-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'checkbox_display' => 'block',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Submit Button
		 */
		$this->start_controls_section(
			'section_submit_button_style',
			array(
				'label' => __( 'Submit Button', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'button_align',
			array(
				'label'        => __( 'Alignment', 'boostify' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'left',
				'prefix_class' => 'boostify-contact-form-button-align-',
				'options'      => array(
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
				'condition'    => array(
					'button_width_type' => 'custom',
				),
			)
		);

		$this->add_control(
			'button_width_type',
			array(
				'label'        => __( 'Width', 'boostify' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'custom',
				'options'      => array(
					'full-width' => __( 'Full Width', 'boostify' ),
					'custom'     => __( 'Custom', 'boostify' ),
				),
				'prefix_class' => 'boostify-contact-form-7-button-',
			)
		);

		$this->add_responsive_control(
			'button_width',
			array(
				'label'      => __( 'Width', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1200,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form input[type="submit"]' => 'width: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'button_width_type' => 'custom',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);

		$this->add_control(
			'button_bg_color_normal',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form input[type="submit"]' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_text_color_normal',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form input[type="submit"]' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'button_border_normal',
				'label'    => __( 'Border', 'boostify' ),
				'default'  => '1px',
				'selector' => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form input[type="submit"]',
			)
		);

		$this->add_control(
			'button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_margin',
			array(
				'label'      => __( 'Margin Top', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form input[type="submit"]' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'button_typography',
				'label'     => __( 'Typography', 'boostify' ),
				'scheme'    => Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form input[type="submit"]',
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'button_box_shadow',
				'selector'  => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form input[type="submit"]',
				'separator' => 'before',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);

		$this->add_control(
			'button_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form input[type="submit"]:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form input[type="submit"]:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-form input[type="submit"]:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Style Tab: Errors
		 */
		$this->start_controls_section(
			'section_error_style',
			array(
				'label' => __( 'Errors', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'error_messages_heading',
			array(
				'label'     => __( 'Error Messages', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
			)
		);

		$this->start_controls_tabs( 'tabs_error_messages_style' );

		$this->start_controls_tab(
			'tab_error_messages_alert',
			array(
				'label'     => __( 'Alert', 'boostify' ),
			)
		);

		$this->add_control(
			'error_alert_text_color',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-not-valid-tip' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'error_alert_bg_color',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-not-valid-tip' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'error_alert_typography',
				'label'     => __( 'Typography', 'boostify' ),
				'scheme'    => Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-not-valid-tip',
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'error_alert_border',
				'label'       => __( 'Border', 'boostify' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-not-valid-tip',
				'separator'   => 'before',
				'condition'   => array(
					'error_messages' => 'show',
				),
			)
		);

		$this->add_responsive_control(
			'error_alert_padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-not-valid-tip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'error_messages' => 'show',
				),
			)
		);

		$this->add_responsive_control(
			'error_alert_spacing',
			array(
				'label'      => __( 'Spacing', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-not-valid-tip' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'error_messages' => 'show',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_error_messages_fields',
			array(
				'label'     => __( 'Fields', 'boostify' ),
			)
		);

		$this->add_control(
			'error_field_bg_color',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-not-valid' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'error_field_color',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-not-valid.wpcf7-text' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'error_field_border',
				'label'       => __( 'Border', 'boostify' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-not-valid',
				'separator'   => 'before',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Style Tab: After Submit Feedback
		 */
		$this->start_controls_section(
			'section_after_submit_feedback_style',
			array(
				'label' => __( 'After Submit Feedback', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'contact_form_after_submit_feedback_typography',
				'label'     => __( 'Typography', 'boostify' ),
				'selector'  => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-mail-sent-ng, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-mail-sent-ok, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-response-output',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'contact_form_after_submit_feedback_color',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-mail-sent-ng'    => 'color: {{VALUE}}',
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-mail-sent-ok'    => 'color: {{VALUE}}',
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-response-output' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'contact_form_after_submit_feedback_background',
				'label'     => __( 'Background', 'boostify' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-mail-sent-ng, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-mail-sent-ok, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-response-output',
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'contact_form_after_submit_feedback_border',
				'label'       => __( 'Border', 'boostify' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .boostify-contact-form-7 .wpcf7-mail-sent-ng, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-mail-sent-ok, {{WRAPPER}} .boostify-contact-form-7 .wpcf7-response-output',
				'separator'   => 'before',
			)
		);

		$this->add_responsive_control(
			'contact_form_after_submit_feedback_border_radius',
			array(
				'label'      => esc_html__( 'Radius', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 1500,
					),
					'em' => array(
						'min' => 1,
						'max' => 80,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-mail-sent-ng'    => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-mail-sent-ok'    => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-response-output' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'contact_form_after_submit_feedback_border_margin',
			array(
				'label'      => esc_html__( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-mail-sent-ng'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-mail-sent-ok'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-response-output' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'contact_form_after_submit_feedback_border_padding',
			array(
				'label'      => esc_html__( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-mail-sent-ng' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-mail-sent-ok' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .boostify-contact-form-7 .wpcf7-response-output' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

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
		if ( ! check_contact_form7_active() ) {
			return;
		}

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			'contact-form',
			'class',
			array(
				'boostify-contact-form',
				'boostify-contact-form-7',
				'boostify-contact-form-' . esc_attr( $this->get_id() ),
			)
		);

		if ( 'yes' != $settings['labels_switch'] ) { //phpcs:ignore
			$this->add_render_attribute( 'contact-form', 'class', 'labels-hide' );
		}

		if ( 'yes' == $settings['placeholder_switch'] ) { //phpcs:ignore
			$this->add_render_attribute( 'contact-form', 'class', 'placeholder-show' );
		}

		if ( 'yes' == $settings['custom_radio_checkbox'] ) { //phpcs:ignore
			$this->add_render_attribute( 'contact-form', 'class', 'boostify-custom-radio-checkbox' );
		}

		$class = 'boostify-contact-form-align-' . $settings['contact_form_alignment'];

		$this->add_render_attribute( 'contact-form', 'class', $class );

		if ( ! empty( $settings['contact_form_list'] ) ) :
			?>
			<div class="boostify-addon-widget boostify-widget-contact-form-7">
				<div class="boostify-contact-form-7-wrapper">
					<div <?php echo $this->get_render_attribute_string( 'contact-form'); //phpcs:ignore ?> >
						<?php if ( 'yes' == $settings['form_title'] || 'yes' == $settings['form_description'] ) : // phpcs:ignore ?>
							<div class="boostify-contact-form-7-heading">
								<?php if ( 'yes' == $settings['form_title'] && '' != $settings['form_title_text'] ) : // phpcs:ignore ?>
									<h3 class="boostify-contact-form-title boostify-contact-form-7-title">
										<?php echo esc_html( $settings['form_title_text'] ); ?>
									</h3>
								<?php endif ?>

								<?php if ( 'yes' == $settings['form_description'] && '' != $settings['form_description_text'] ) : // phpcs:ignore ?>
									<div class="boostify-contact-form-description boostify-contact-form-7-description">
										<?php echo $this->parse_text_editor( $settings['form_description_text'] ); // phpcs:ignore ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php echo do_shortcode( '[contact-form-7 id="' . $settings['contact_form_list'] . '" ]' ); //phpcs:ignore ?>
					</div>
				</div>
			</div>
			<?php
		endif;
	}
}
