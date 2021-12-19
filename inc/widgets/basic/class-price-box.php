<?php
/**
 * Widget Price Box
 *
 * @class Price_Box
 *
 * @package Boostify Addon
 *
 * Written by ptp
 */

namespace Boostify_Elementor\Widgets;

use Boostify_Elementor\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * \FAQs
 *
 * Elementor widget for \FAQs.
 * Author: ptp
 */
class Price_Box extends Base_Widget {
	// Exit if accessed directly.

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
		return 'price-box';
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
		return esc_html__( 'Price Box', 'boostify' );
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
		return 'boostify eicon-price-table';
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
			'section_header',
			array(
				'label' => __( 'Header', 'boostify' ),
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'   => __( 'Title', 'boostify' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Enter your title', 'boostify' ),
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'sub_heading',
			array(
				'label'   => __( 'Description', 'boostify' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Enter your description', 'boostify' ),
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'heading_tag',
			array(
				'label'   => __( 'Title HTML Tag', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				),
				'default' => 'h3',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pricing',
			array(
				'label' => __( 'Pricing', 'boostify' ),
			)
		);

		$this->add_control(
			'currency_symbol',
			array(
				'label'   => __( 'Currency Symbol', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''             => __( 'None', 'boostify' ),
					'dollar'       => '&#36; ' . _x( 'Dollar', 'Currency', 'boostify' ),
					'euro'         => '&#128; ' . _x( 'Euro', 'Currency', 'boostify' ),
					'baht'         => '&#3647; ' . _x( 'Baht', 'Currency', 'boostify' ),
					'franc'        => '&#8355; ' . _x( 'Franc', 'Currency', 'boostify' ),
					'guilder'      => '&fnof; ' . _x( 'Guilder', 'Currency', 'boostify' ),
					'krona'        => 'kr ' . _x( 'Krona', 'Currency', 'boostify' ),
					'lira'         => '&#8356; ' . _x( 'Lira', 'Currency', 'boostify' ),
					'peseta'       => '&#8359 ' . _x( 'Peseta', 'Currency', 'boostify' ),
					'peso'         => '&#8369; ' . _x( 'Peso', 'Currency', 'boostify' ),
					'pound'        => '&#163; ' . _x( 'Pound Sterling', 'Currency', 'boostify' ),
					'real'         => 'R$ ' . _x( 'Real', 'Currency', 'boostify' ),
					'ruble'        => '&#8381; ' . _x( 'Ruble', 'Currency', 'boostify' ),
					'rupee'        => '&#8360; ' . _x( 'Rupee', 'Currency', 'boostify' ),
					'indian_rupee' => '&#8377; ' . _x( 'Rupee (Indian)', 'Currency', 'boostify' ),
					'shekel'       => '&#8362; ' . _x( 'Shekel', 'Currency', 'boostify' ),
					'yen'          => '&#165; ' . _x( 'Yen/Yuan', 'Currency', 'boostify' ),
					'won'          => '&#8361; ' . _x( 'Won', 'Currency', 'boostify' ),
					'custom'       => __( 'Custom', 'boostify' ),
				),
				'default' => 'dollar',
			)
		);

		$this->add_control(
			'currency_symbol_custom',
			array(
				'label'     => __( 'Custom Symbol', 'boostify' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'currency_symbol' => 'custom',
				),
			)
		);

		$this->add_control(
			'price',
			array(
				'label'   => __( 'Price', 'boostify' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '39.99',
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'currency_format',
			array(
				'label'   => __( 'Currency Format', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''  => '1,234.56 (Default)',
					',' => '1.234,56',
				),
			)
		);

		$this->add_control(
			'sale',
			array(
				'label'     => __( 'Sale', 'boostify' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'On', 'boostify' ),
				'label_off' => __( 'Off', 'boostify' ),
				'default'   => '',
			)
		);

		$this->add_control(
			'original_price',
			array(
				'label'     => __( 'Original Price', 'boostify' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '59',
				'condition' => array(
					'sale' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'period',
			array(
				'label'   => __( 'Period', 'boostify' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Monthly', 'boostify' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_features',
			array(
				'label' => __( 'Features', 'boostify' ),
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'item_text',
			array(
				'label'   => __( 'Text', 'boostify' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'List Item', 'boostify' ),
			)
		);

		$default_icon = array(
			'value'   => 'far fa-check-circle',
			'library' => 'fa-regular',
		);

		$repeater->add_control(
			'selected_item_icon',
			array(
				'label'            => __( 'Icon', 'boostify' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'item_icon',
				'default'          => $default_icon,
			)
		);

		$repeater->add_control(
			'item_icon_color',
			array(
				'label'     => __( 'Icon Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} i'   => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} svg' => 'fill: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'features_list',
			array(
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'item_text'          => __( 'List Item #1', 'boostify' ),
						'selected_item_icon' => $default_icon,
					),
					array(
						'item_text'          => __( 'List Item #2', 'boostify' ),
						'selected_item_icon' => $default_icon,
					),
					array(
						'item_text'          => __( 'List Item #3', 'boostify' ),
						'selected_item_icon' => $default_icon,
					),
				),
				'title_field' => '{{{ item_text }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_footer',
			array(
				'label' => __( 'Footer', 'boostify' ),
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'   => __( 'Button Text', 'boostify' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Click Here', 'boostify' ),
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'link',
			array(
				'label'       => __( 'Link', 'boostify' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'boostify' ),
				'default'     => array(
					'url' => '#',
				),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'footer_additional_info',
			array(
				'label'   => __( 'Additional Info', 'boostify' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'This is text element', 'boostify' ),
				'rows'    => 3,
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_ribbon',
			array(
				'label' => __( 'Ribbon', 'boostify' ),
			)
		);

		$this->add_control(
			'show_ribbon',
			array(
				'label'     => __( 'Show', 'boostify' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'ribbon_title',
			array(
				'label'     => __( 'Title', 'boostify' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Popular', 'boostify' ),
				'condition' => array(
					'show_ribbon' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'ribbon_horizontal_position',
			array(
				'label'     => __( 'Position', 'boostify' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'  => array(
						'title' => __( 'Left', 'boostify' ),
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => __( 'Right', 'boostify' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'condition' => array(
					'show_ribbon' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_header_style',
			array(
				'label'      => __( 'Header', 'boostify' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'header_bg_color',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__header' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'header_padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-price-table__header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_heading_style',
			array(
				'label'     => __( 'Title', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'heading_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__heading' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .boostify-price-table__heading',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
			)
		);

		$this->add_control(
			'heading_sub_heading_style',
			array(
				'label'     => __( 'Sub Title', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'sub_heading_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__subheading' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sub_heading_typography',
				'selector' => '{{WRAPPER}} .boostify-price-table__subheading',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pricing_element_style',
			array(
				'label'      => __( 'Pricing', 'boostify' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'pricing_element_bg_color',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__price' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'pricing_element_padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-price-table__price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__currency, {{WRAPPER}} .boostify-price-table__integer-part, {{WRAPPER}} .boostify-price-table__fractional-part' => 'color: {{VALUE}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} .boostify-price-table__price',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
			)
		);

		$this->add_control(
			'heading_currency_style',
			array(
				'label'     => __( 'Currency Symbol', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'currency_symbol!' => '',
				),
			)
		);

		$this->add_control(
			'currency_size',
			array(
				'label'     => __( 'Size', 'boostify' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__currency' => 'font-size: calc({{SIZE}}em/100)',
				),
				'condition' => array(
					'currency_symbol!' => '',
				),
			)
		);

		$this->add_control(
			'currency_position',
			array(
				'label'   => __( 'Position', 'boostify' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'before',
				'options' => array(
					'before' => array(
						'title' => __( 'Before', 'boostify' ),
						'icon'  => 'eicon-h-align-left',
					),
					'after'  => array(
						'title' => __( 'After', 'boostify' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
			)
		);

		$this->add_control(
			'currency_vertical_position',
			array(
				'label'                => __( 'Vertical Position', 'boostify' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => array(
					'top'    => array(
						'title' => __( 'Top', 'boostify' ),
						'icon'  => 'eicon-v-align-top',
					),
					'middle' => array(
						'title' => __( 'Middle', 'boostify' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'bottom' => array(
						'title' => __( 'Bottom', 'boostify' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'default'              => 'top',
				'selectors_dictionary' => array(
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				),
				'selectors'            => array(
					'{{WRAPPER}} .boostify-price-table__currency' => 'align-self: {{VALUE}}',
				),
				'condition'            => array(
					'currency_symbol!' => '',
				),
			)
		);

		$this->add_control(
			'fractional_part_style',
			array(
				'label'     => __( 'Fractional Part', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'fractional-part_size',
			array(
				'label'     => __( 'Size', 'boostify' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__fractional-part' => 'font-size: calc({{SIZE}}em/100)',
				),
			)
		);

		$this->add_control(
			'fractional_part_vertical_position',
			array(
				'label'                => __( 'Vertical Position', 'boostify' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => array(
					'top'    => array(
						'title' => __( 'Top', 'boostify' ),
						'icon'  => 'eicon-v-align-top',
					),
					'middle' => array(
						'title' => __( 'Middle', 'boostify' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'bottom' => array(
						'title' => __( 'Bottom', 'boostify' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'default'              => 'top',
				'selectors_dictionary' => array(
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				),
				'selectors'            => array(
					'{{WRAPPER}} .boostify-price-table__after-price' => 'justify-content: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'heading_original_price_style',
			array(
				'label'     => __( 'Original Price', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'sale'            => 'yes',
					'original_price!' => '',
				),
			)
		);

		$this->add_control(
			'original_price_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__original-price' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'sale'            => 'yes',
					'original_price!' => '',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'original_price_typography',
				'selector'  => '{{WRAPPER}} .boostify-price-table__original-price',
				'global'    => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'condition' => array(
					'sale'            => 'yes',
					'original_price!' => '',
				),
			)
		);

		$this->add_control(
			'original_price_vertical_position',
			array(
				'label'                => __( 'Vertical Position', 'boostify' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => array(
					'top'    => array(
						'title' => __( 'Top', 'boostify' ),
						'icon'  => 'eicon-v-align-top',
					),
					'middle' => array(
						'title' => __( 'Middle', 'boostify' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'bottom' => array(
						'title' => __( 'Bottom', 'boostify' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'selectors_dictionary' => array(
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				),
				'default'              => 'bottom',
				'selectors'            => array(
					'{{WRAPPER}} .boostify-price-table__original-price' => 'align-self: {{VALUE}}',
				),
				'condition'            => array(
					'sale'            => 'yes',
					'original_price!' => '',
				),
			)
		);

		$this->add_control(
			'heading_period_style',
			array(
				'label'     => __( 'Period', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'period!' => '',
				),
			)
		);

		$this->add_control(
			'period_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__period' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'period!' => '',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'period_typography',
				'selector'  => '{{WRAPPER}} .boostify-price-table__period',
				'global'    => array(
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				),
				'condition' => array(
					'period!' => '',
				),
			)
		);

		$this->add_control(
			'period_position',
			array(
				'label'       => __( 'Position', 'boostify' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'options'     => array(
					'below'  => __( 'Below', 'boostify' ),
					'beside' => __( 'Beside', 'boostify' ),
				),
				'default'     => 'below',
				'condition'   => array(
					'period!' => '',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_features_list_style',
			array(
				'label'      => __( 'Features', 'boostify' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'features_list_bg_color',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__features-list' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'features_list_padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-price-table__features-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'features_list_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__features-list' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'features_list_typography',
				'selector' => '{{WRAPPER}} .boostify-price-table__features-list li',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
			)
		);

		$this->add_control(
			'features_list_alignment',
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
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__features-list' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'item_width',
			array(
				'label'     => __( 'Width', 'boostify' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'%' => array(
						'min' => 25,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__feature-inner' => 'margin-left: calc((100% - {{SIZE}}%)/2); margin-right: calc((100% - {{SIZE}}%)/2)',
				),
			)
		);

		$this->add_control(
			'list_divider',
			array(
				'label'     => __( 'Divider', 'boostify' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'divider_style',
			array(
				'label'     => __( 'Style', 'boostify' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'solid'  => __( 'Solid', 'boostify' ),
					'double' => __( 'Double', 'boostify' ),
					'dotted' => __( 'Dotted', 'boostify' ),
					'dashed' => __( 'Dashed', 'boostify' ),
				),
				'default'   => 'solid',
				'condition' => array(
					'list_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__features-list li:before' => 'border-top-style: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'divider_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ddd',
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
				'condition' => array(
					'list_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__features-list li:before' => 'border-top-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'divider_weight',
			array(
				'label'     => __( 'Weight', 'boostify' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 2,
					'unit' => 'px',
				),
				'range'     => array(
					'px' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'condition' => array(
					'list_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__features-list li:before' => 'border-top-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'divider_width',
			array(
				'label'     => __( 'Width', 'boostify' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => array(
					'list_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__features-list li:before' => 'margin-left: calc((100% - {{SIZE}}%)/2); margin-right: calc((100% - {{SIZE}}%)/2)',
				),
			)
		);

		$this->add_control(
			'divider_gap',
			array(
				'label'     => __( 'Gap', 'boostify' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 15,
					'unit' => 'px',
				),
				'range'     => array(
					'px' => array(
						'min' => 1,
						'max' => 50,
					),
				),
				'condition' => array(
					'list_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__features-list li:before' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_footer_style',
			array(
				'label'      => __( 'Footer', 'boostify' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'footer_bg_color',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__footer' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'footer_padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-price-table__footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_footer_button',
			array(
				'label'     => __( 'Button', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'button_size',
			array(
				'label'     => __( 'Size', 'boostify' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'md',
				'options'   => array(
					'xs' => __( 'Extra Small', 'boostify' ),
					'sm' => __( 'Small', 'boostify' ),
					'md' => __( 'Medium', 'boostify' ),
					'lg' => __( 'Large', 'boostify' ),
					'xl' => __( 'Extra Large', 'boostify' ),
				),
				'condition' => array(
					'button_text!' => '',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label'     => __( 'Normal', 'boostify' ),
				'condition' => array(
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				),
				'selector' => '{{WRAPPER}} .boostify-price-table__button',
			)
		);

		$this->add_control(
			'button_background_color',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_ACCENT,
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'button_border',
				'selector'  => '{{WRAPPER}} .boostify-price-table__button',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-price-table__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'button_text_padding',
			array(
				'label'      => __( 'Text Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-price-table__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label'     => __( 'Hover', 'boostify' ),
				'condition' => array(
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__button:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_background_hover_color',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__button:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_border_color',
			array(
				'label'     => __( 'Border Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__button:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_animation',
			array(
				'label' => __( 'Animation', 'boostify' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_additional_info',
			array(
				'label'     => __( 'Additional Info', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'footer_additional_info!' => '',
				),
			)
		);

		$this->add_control(
			'additional_info_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__additional_info' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'footer_additional_info!' => '',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'additioal_info_typography',
				'selector'  => '{{WRAPPER}} .boostify-price-table__additional_info',
				'global'    => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'condition' => array(
					'footer_additional_info!' => '',
				),
			)
		);

		$this->add_control(
			'additional_info_margin',
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'top'    => 15,
					'right'  => 30,
					'bottom' => 0,
					'left'   => 30,
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-price-table__additional_info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				'condition'  => array(
					'footer_additional_info!' => '',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_ribbon_style',
			array(
				'label'      => __( 'Ribbon', 'boostify' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => array(
					'show_ribbon' => 'yes',
				),
			)
		);

		$this->add_control(
			'ribbon_bg_color',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_ACCENT,
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__ribbon-inner' => 'background-color: {{VALUE}}',
				),
			)
		);

		$ribbon_distance_transform = is_rtl() ? 'translateY(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)' : 'translateY(-50%) translateX(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)';

		$this->add_responsive_control(
			'ribbon_distance',
			array(
				'label'     => __( 'Distance', 'boostify' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__ribbon-inner' => 'margin-top: {{SIZE}}{{UNIT}}; transform: ' . $ribbon_distance_transform,
				),
			)
		);

		$this->add_control(
			'ribbon_text_color',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .boostify-price-table__ribbon-inner' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'ribbon_typography',
				'selector' => '{{WRAPPER}} .boostify-price-table__ribbon-inner',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .boostify-price-table__ribbon-inner',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 *
	 * @param (string) $symbol | Symbol Currency.
	 * @param (string) $location | Symbol Position.
	 */
	private function render_currency_symbol( $symbol, $location ) {
		$currency_position = $this->get_settings( 'currency_position' );
		$location_setting  = ! empty( $currency_position ) ? $currency_position : 'before';
		if ( ! empty( $symbol ) && $location === $location_setting ) {
			?>
			<span class="boostify-price-table__currency boostify-currency--<?php echo esc_attr( $location );?>'"><?php echo ($symbol);//phpcs:ignore ?></span>
			<?php
		}
	}


	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 * @param (string) $symbol_name | Symbol Name.
	 */
	private function get_currency_symbol( $symbol_name ) {
		$symbols = array(
			'dollar'       => '&#36;',
			'euro'         => '&#128;',
			'franc'        => '&#8355;',
			'pound'        => '&#163;',
			'ruble'        => '&#8381;',
			'shekel'       => '&#8362;',
			'baht'         => '&#3647;',
			'yen'          => '&#165;',
			'won'          => '&#8361;',
			'guilder'      => '&fnof;',
			'peso'         => '&#8369;',
			'peseta'       => '&#8359',
			'lira'         => '&#8356;',
			'rupee'        => '&#8360;',
			'indian_rupee' => '&#8377;',
			'real'         => 'R$',
			'krona'        => 'kr',
		);

		return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
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
		$symbol   = '';

		if ( ! empty( $settings['currency_symbol'] ) ) {
			if ( 'custom' !== $settings['currency_symbol'] ) {
				$symbol = $this->get_currency_symbol( $settings['currency_symbol'] );
			} else {
				$symbol = $settings['currency_symbol_custom'];
			}
		}
		$currency_format = empty( $settings['currency_format'] ) ? '.' : $settings['currency_format'];
		$price           = explode( $currency_format, $settings['price'] );
		$intpart         = $price[0];
		$fraction        = '';
		if ( 2 === count( $price ) ) {
			$fraction = $price[1];
		}

		$this->add_render_attribute(
			'button_text',
			'class',
			array(
				'boostify-price-table__button',
				'boostify-button',
				'boostify-size-' . $settings['button_size'],
			)
		);

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'button_text', $settings['link'] );
		}

		if ( ! empty( $settings['button_hover_animation'] ) ) {
			$this->add_render_attribute( 'button_text', 'class', 'boostify-animation-' . $settings['button_hover_animation'] );
		}

		$this->add_render_attribute( 'heading', 'class', 'boostify-price-table__heading' );
		$this->add_render_attribute( 'sub_heading', 'class', 'boostify-price-table__subheading' );
		$this->add_render_attribute( 'period', 'class', array( 'boostify-price-table__period', 'boostify-typo-excluded' ) );
		$this->add_render_attribute( 'footer_additional_info', 'class', 'boostify-price-table__additional_info' );
		$this->add_render_attribute( 'ribbon_title', 'class', 'boostify-price-table__ribbon-inner' );

		$this->add_inline_editing_attributes( 'heading', 'none' );
		$this->add_inline_editing_attributes( 'sub_heading', 'none' );
		$this->add_inline_editing_attributes( 'period', 'none' );
		$this->add_inline_editing_attributes( 'footer_additional_info' );
		$this->add_inline_editing_attributes( 'button_text' );
		$this->add_inline_editing_attributes( 'ribbon_title' );

		$period_position   = $settings['period_position'];
		$period_element    = '<span ' . $this->get_render_attribute_string( 'period' ) . '>' . $settings['period'] . '</span>';
		$heading_tag       = \Elementor\Utils::validate_html_tag( $settings['heading_tag'] );
		$migration_allowed = \Elementor\Icons_Manager::is_migration_allowed();
		?>

		<div class="boostify-price-table-widget">

			<div class="boostify-price-table">
				<?php if ( $settings['heading'] || $settings['sub_heading'] ) : ?>
					<div class="boostify-price-table__header">
						<?php if ( ! empty( $settings['heading'] ) ) : ?>
							<<?php echo $heading_tag . ' ' . $this->get_render_attribute_string( 'heading' ); //phpcs:ignore ?>><?php echo $settings['heading'] . '</' . $heading_tag; ?>>
						<?php endif; ?>

						<?php if ( ! empty( $settings['sub_heading'] ) ) : ?>
							<span <?php echo $this->get_render_attribute_string( 'sub_heading' ); //phpcs:ignore ?>><?php echo $settings['sub_heading']; ?></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="boostify-price-table__price">
					<?php if ( 'yes' === $settings['sale'] && ! empty( $settings['original_price'] ) ) : ?>
						<div class="boostify-price-table__original-price boostify-typo-excluded"><?php echo $symbol . $settings['original_price']; //phpcs:ignore?></div>
					<?php endif; ?>
					<?php $this->render_currency_symbol( $symbol, 'before' ); ?>
					<?php if ( ! empty( $intpart ) || 0 <= $intpart ) : ?>
						<span class="boostify-price-table__integer-part"><?php echo $intpart;//phpcs:ignore ?></span>
					<?php endif; ?>

					<?php if ( '' !== $fraction || ( ! empty( $settings['period'] ) && 'beside' === $period_position ) ) : ?>
						<div class="boostify-price-table__after-price">
							<span class="boostify-price-table__fractional-part"><?php echo $fraction; //phpcs:ignore ?></span>

							<?php if ( ! empty( $settings['period'] ) && 'beside' === $period_position ) : ?>
								<?php echo $period_element; //phpcs:ignore ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php $this->render_currency_symbol( $symbol, 'after' ); ?>

					<?php if ( ! empty( $settings['period'] ) && 'below' === $period_position ) : ?>
						<?php echo $period_element; //phpcs:ignore?>
					<?php endif; ?>
				</div>

				<?php if ( ! empty( $settings['features_list'] ) ) : ?>
					<ul class="boostify-price-table__features-list">
						<?php
						foreach ( $settings['features_list'] as $index => $item ) :
							$repeater_setting_key = $this->get_repeater_setting_key( 'item_text', 'features_list', $index );
							$this->add_inline_editing_attributes( $repeater_setting_key );

							$migrated = isset( $item['__fa4_migrated']['selected_item_icon'] );
							// add old default.
							if ( ! isset( $item['item_icon'] ) && ! $migration_allowed ) {
								$item['item_icon'] = 'fa fa-check-circle';
							}
							$is_new = ! isset( $item['item_icon'] ) && $migration_allowed;
							?>
							<li class="boostify-repeater-item-<?php echo $item['_id']; //phpcs:ignore ?>">
								<div class="boostify-price-table__feature-inner">
									<?php if ( ! empty( $item['item_icon'] ) || ! empty( $item['selected_item_icon'] ) ) : ?>
										<?php
										if ( $is_new || $migrated ) :
											\Elementor\Icons_Manager::render_icon( $item['selected_item_icon'], array( 'aria-hidden' => 'true' ) );
										else :
											?>
												<span class="<?php echo esc_attr( $item['item_icon'] ); ?>" aria-hidden="true"></span>
											<?php
										endif;
									endif;
									?>
									<?php if ( ! empty( $item['item_text'] ) ) : ?>
										<span <?php echo $this->get_render_attribute_string( $repeater_setting_key ); //phpcs:ignore ?>>
											<?php echo $item['item_text']; //phpcs:ignore ?>
										</span>
										<?php
									else :
										echo '&nbsp;';
									endif;
									?>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( ! empty( $settings['button_text'] ) || ! empty( $settings['footer_additional_info'] ) ) : ?>
					<div class="boostify-price-table__footer">
						<?php if ( ! empty( $settings['button_text'] ) ) : ?>
							<a <?php echo $this->get_render_attribute_string( 'button_text' ); ?>><?php echo $settings['button_text']; //phpcs:ignore ?></a>
						<?php endif; ?>

						<?php if ( ! empty( $settings['footer_additional_info'] ) ) : ?>
							<div <?php echo $this->get_render_attribute_string( 'footer_additional_info' ); ?>><?php echo $settings['footer_additional_info']; //phpcs:ignore ?></div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php
			if ( 'yes' === $settings['show_ribbon'] && ! empty( $settings['ribbon_title'] ) ) :
				$this->add_render_attribute( 'ribbon-wrapper', 'class', 'boostify-price-table__ribbon' );

				if ( ! empty( $settings['ribbon_horizontal_position'] ) ) :
					$this->add_render_attribute( 'ribbon-wrapper', 'class', 'boostify-ribbon-' . $settings['ribbon_horizontal_position'] );
				endif;

				?>
				<div <?php echo $this->get_render_attribute_string( 'ribbon-wrapper' ); //phpcs:ignore ?>>
					<div <?php echo $this->get_render_attribute_string( 'ribbon_title' ); //phpcs:ignore ?>><?php echo $settings['ribbon_title']; //phpcs:ignore ?></div>
				</div>
				<?php
			endif;
			?>
		</div>
		<?php
	}

}
