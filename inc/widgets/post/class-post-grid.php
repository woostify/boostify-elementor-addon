<?php

namespace Boostify_Elementor\Widgets;

use Boostify_Elementor\Base_Widget;
use Boostify_Elementor\Layout;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;

/**
 * Copyright
 *
 * Elementor widget for Copyright.
 * Author: ptp
 */
class Post_Grid extends Base_Widget {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function name() {
		return 'post-grid';
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
		return 'boostify eicon-posts-grid';
	}

	public function _register_controls() { //phpcs:ignore
		$this->start_controls_section(
			'section_post_grid',
			array(
				'label' => __( 'Post Grid', 'boostify' ),
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->layouts(),
				'default' => 'default',
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'          => esc_html__( 'Columns', 'boostify' ),
				'type'           => Controls_Manager::SELECT,
				'options'        => array(
					'1' => esc_html__( '1', 'boostify' ),
					'2' => esc_html__( '2', 'boostify' ),
					'3' => esc_html__( '3', 'boostify' ),
					'4' => esc_html__( '4', 'boostify' ),
					'5' => esc_html__( '5', 'boostify' ),
				),
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
			)
		);

		$this->add_control(
			'image',
			array(
				'label'        => __( 'Thumbnail', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'boostify' ),
				'label_off'    => __( 'Hide', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'title_tag',
			array(
				'label'   => __( 'Title HTML Tag', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h5',
				'options' => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				),
			)
		);

		$this->add_control(
			'excpert',
			array(
				'label'        => __( 'Excpert', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'boostify' ),
				'label_off'    => __( 'Hide', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'length',
			array(
				'label'     => __( 'Excpert Length', 'boostify' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 50,
				'min'       => 0,
				'condition' => array(
					'excpert' => 'yes',
				),
			)
		);

		$this->add_control(
			'meta_data',
			array(
				'label'       => esc_html__( 'Meta Data', 'boostify' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => array( 'author', 'date', 'category' ),
				'label_block' => true,
				'options'     => array(
					'author'   => __( 'Author', 'boostify' ),
					'date'     => __( 'Date', 'boostify' ),
					'time'     => __( 'Time', 'boostify' ),
					'category' => __( 'Category', 'boostify' ),
					'comment'  => __( 'Comments', 'boostify' ),
				),
			)
		);

		$this->add_control(
			'meta_separator',
			array(
				'label'     => __( 'Separator Between', 'boostify' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '/',
				'selectors' => array(
					'{{WRAPPER}} .boostify-meta-item:not(:last-child):after' => 'content: "{{VALUE}}"',
				),
				'condition' => array(
					'meta_data!' => array(),
				),
			)
		);

		$this->add_control(
			'show_read_more',
			array(
				'label'        => __( 'Read More', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'boostify' ),
				'label_off'    => __( 'Hide', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'read_more',
			array(
				'label'       => __( 'Read More Text', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => __( 'Read More', 'boostify' ),
				'placeholder' => __( 'Enter Read More Text', 'boostify' ),
				'condition'   => array(
					'show_read_more' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'query',
			array(
				'label' => __( 'Query', 'boostify' ),
			)
		);

		$this->add_control(
			'post_type',
			array(
				'label'   => __( 'Post Type', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => boostify_theme_post_type(),
			)
		);

		$this->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'Order By', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'ID'     => esc_html__( 'ID', 'boostify' ),
					'date'   => esc_html__( 'Date', 'boostify' ),
					'title'  => esc_html__( 'Title', 'boostify' ),
					'author' => esc_html__( 'Author', 'boostify' ),
					'rand'   => esc_html__( 'Random', 'boostify' ),
				),
				'default' => 'date',
			)
		);

		$this->add_control(
			'order',
			array(
				'label'   => esc_html__( 'Order', 'boostify' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'ASC'  => array(
						'title' => esc_html__( 'ASC', 'boostify' ),
						'icon'  => 'fa fa-sort-numeric-asc',
					),
					'DESC' => array(
						'title' => esc_html__( 'DESC', 'boostify' ),
						'icon'  => 'fa fa-sort-numeric-desc',
					),
				),
				'default' => 'DESC',
			)
		);

		$this->add_control(
			'posts_per_page',
			array(
				'label'   => esc_html__( 'Posts Per Page', 'boostify' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pagination_section',
			array(
				'label' => __( 'Pagination', 'boostify' ),
			)
		);

		$this->add_control(
			'pagination',
			array(
				'label'        => esc_html__( 'Pagination', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'boostify' ),
				'label_off'    => __( 'Hide', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_responsive_control(
			'align_pagination',
			array(
				'label'     => __( 'Alignment', 'boostify' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start'   => array(
						'title' => __( 'Left', 'boostify' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'boostify' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end'  => array(
						'title' => __( 'Right', 'boostify' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'default'   => 'flex-start',
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_post',
			array(
				'label' => __( 'Layout', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'columns_space',
			array(
				'label'      => __( 'Columns Space', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-post-item' => 'padding-left: {{SIZE}}{{UNIT}};padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .boostify-grid'      => 'margin: 0 -{{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'row_space',
			array(
				'label'      => __( 'Row Space', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 15,
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-post-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-post-item-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'align',
			array(
				'label'     => __( 'Alignment', 'boostify' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'boostify' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'boostify' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'boostify' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .boostify-post-item-wrapper' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_box',
			array(
				'label' => __( 'Box', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'border_width',
			array(
				'label'      => __( 'Border Width', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-post-item-wrapper' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid',
				),
			)
		);

		$this->add_control(
			'border-radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-post-item-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'padding_content',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-post-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'box' );

		$this->start_controls_tab(
			'box_normal',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);

		$this->add_control(
			'background',
			array(
				'label'     => __( 'Background', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-post-item-wrapper' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'boxshadown',
				'label'    => __( 'Box Shadow', 'boostify' ),
				'selector' => '{{WRAPPER}} .boostify-post-item-wrapper',
			)
		);

		$this->add_control(
			'border-color',
			array(
				'label'     => __( 'Border Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-post-item-wrapper' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'box_hover',
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);

		$this->add_control(
			'background_hover',
			array(
				'label'     => __( 'Background', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-post-item-wrapper:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'boxshadown_hover',
				'label'    => __( 'Box Shadow', 'boostify' ),
				'selector' => '{{WRAPPER}} .boostify-post-item-wrapper:hover',
			)
		);

		$this->add_control(
			'border-color-hover',
			array(
				'label'     => __( 'Border Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-post-item-wrapper:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'image_style',
			array(
				'label' => esc_html__( 'Image', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'image-border-radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-post-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_space',
			array(
				'label'      => __( 'Space', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-post-thumbnail' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'images_thumb' );

		$this->start_controls_tab(
			'image_normal',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} .boostify-post-thumbnail img',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'image_hover',
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .boostify-post-item-wrapper:hover .boostify-post-thumbnail img',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'style_title',
			array(
				'label' => __( 'Title', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => array(
					'{{WRAPPER}} .boostify-post-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => __( 'Typography', 'boostify' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .boostify-post-title',
			)
		);

		$this->add_responsive_control(
			'title_space',
			array(
				'label'      => __( 'Space', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-post-title' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_meta',
			array(
				'label' => __( 'Meta Data', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666',
				'selectors' => array(
					'{{WRAPPER}} .boostify-meta-item'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .boostify-meta-item a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'meta_typography',
				'label'    => __( 'Typography', 'boostify' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .boostify-meta-item',
			)
		);

		$this->add_responsive_control(
			'meta_space',
			array(
				'label'      => __( 'Space', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-post-meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_excpert',
			array(
				'label' => __( 'Excpert', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'excpert_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => array(
					'{{WRAPPER}} .boostify-post-excpert .post-excpert' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'excpert' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'excpert_typography',
				'label'     => __( 'Typography', 'boostify' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .boostify-post-excpert .post-excpert',
				'condition' => array(
					'excpert' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'excpert_space',
			array(
				'label'      => __( 'Space', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-post-excpert' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'excpert' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'read_more_style',
			array(
				'label' => __( 'Read More Button', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'read_more_tab' );

		$this->start_controls_tab(
			'read_more_normal',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);

		$this->add_control(
			'read_more_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => array(
					'{{WRAPPER}} .boostify-post-read-more' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'show_read_more' => 'yes',
				),
			)
		);

		$this->add_control(
			'read_more_background_color',
			array(
				'label'     => __( 'Background', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-post-read-more' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'show_read_more' => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'read_more_hover',
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);

		$this->add_control(
			'read_more_color_hover',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => array(
					'{{WRAPPER}} .boostify-post-read-more:hover' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'show_read_more' => 'yes',
				),
			)
		);

		$this->add_control(
			'read_more_background_color_hover',
			array(
				'label'     => __( 'Background', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-post-read-more:hover' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'show_read_more' => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'read_more_typography',
				'label'     => __( 'Typography', 'boostify' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .boostify-post-read-more',
				'condition' => array(
					'show_read_more' => 'yes',
				),
			)
		);

		$this->add_control(
			'read_more_padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-post-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'show_read_more' => 'yes',
				),
			)
		);

		$this->add_control(
			'read-more-border-radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-post-read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'show_read_more' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pagination_style',
			array(
				'label' => __( 'Pagination', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'space_page',
			array(
				'label'      => __( 'Space Top', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 30,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'    => __( 'Typography', 'boostify' ),
				'name'     => 'typo_pagination',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .boostify-pagination .page-numbers, {{WRAPPER}} .boostify-pagination .page-numbers.next:after, {{WRAPPER}} .boostify-pagination .page-numbers.prev:after',
			)
		);
		$this->add_responsive_control(
			'page_width',
			array(
				'label'      => __( 'Width', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 30,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'border_pagi_width',
			array(
				'label'      => __( 'Border Width', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid',
				),
			)
		);

		$this->add_control(
			'border_pagi_radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'pagination_tab' );

		$this->start_controls_tab(
			'pagi_nornal',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);

		$this->add_control(
			'pagi_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers' => 'color: {{VALUE}};',
					'{{WRAPPER}} .boostify-pagination .page-numbers.prev:after' => 'color: {{VALUE}}',
					'{{WRAPPER}} .boostify-pagination .page-numbers.next:after' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagi_color_bd',
			array(
				'label'     => __( 'Color Border', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'pagi_color_bg',
			array(
				'label'     => __( 'Background', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagi_active',
			array(
				'label' => __( 'Active', 'boostify' ),
			)
		);

		$this->add_control(
			'pagi_color_active',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666',
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers.current' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'pagi_color_bd_acti',
			array(
				'label'     => __( 'Color Border', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers.current' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'pagi_color_bg_active',
			array(
				'label'     => __( 'Background', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers.current' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagi_hover',
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);

		$this->add_control(
			'pagi_color_hover',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666',
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .boostify-pagination .page-numbers:hover.prev:after' => 'color: {{VALUE}}',
					'{{WRAPPER}} .boostify-pagination .page-numbers:hover.next:after' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagi_color_bd_hover',
			array(
				'label'     => __( 'Color Border', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'pagi_color_bg_acti',
			array(
				'label'     => __( 'Background', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render Copyright output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.2.0
	 * @access protected
	 */
	protected function render() {
		$settings   = $this->get_settings_for_display();
		$path       = BOOSTIFY_ELEMENTOR_PATH . 'templates/content/content-post-grid.php';
		$columns    = $settings['columns'];
		$args       = array(
			'post_type'      => $settings['post_type'],
			'post_status'    => 'publish',
			'posts_per_page' => $settings['posts_per_page'],
			'order'          => $settings['order'],
			'orderby'        => $settings['orderby'],
			'paged'          => get_query_var( 'paged' ),
		);
		$posts      = new \WP_Query( $args );
		$total_page = $posts->max_num_pages;
		$action     = 'boostify_post_grid_' . $settings['layout'];
		$classes    = array(
			'boostify-widget-post-grid-wrapper',
			'boostify-grid',
			'boostify-grid-' . $columns,
			'boostify-grid-tablet-' . $settings['columns_tablet'],
			'boostify-grid-mobile-' . $settings['columns_mobile'],
		);
		$class      = implode( ' ', $classes );
		if ( $posts->have_posts() ) {
			?>
			<div class="boostify-addon-widget boostify-post-grid-widget">
				<div class="<?php echo esc_attr( $class ); ?>">
					<?php
					while ( $posts->have_posts() ) {
						$posts->the_post();
						do_action( $action, $settings );
					}
					?>
				</div>
				<?php
				if ( $total_page > 1 && 'yes' === $settings['pagination'] ) {
					boostify_pagination( $total_page );
				}
				?>
			</div>
			<?php

			wp_reset_postdata();
		}
	}

	public function layouts() {
		$layout = new \Boostify_Elementor\Posts\Layout();
		$args   = array(
			'default' => 'Default',
			'box'     => 'Box',
		);
		$layout->add_layout_grid( $args );
		$layouts = \Boostify_Elementor\Posts\Layout::$grid_layouts;

		return $layouts;
	}

}
