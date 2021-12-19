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
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Icons_Manager;
use Elementor\Core\Responsive\Responsive;

/**
 * Table of Content
 *
 * Elementor widget for Table of Content.
 * Author: ptp
 */
class Table_Of_Content extends Base_Widget {
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
		return 'table-of-content';
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
		return esc_html__( 'Table of Content', 'boostify' );
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
		return 'boostify eicon-table-of-contents';
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
		return array( 'boostify-addon-toc' );
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
			'table_of_contents',
			array(
				'label' => __( 'Table of Contents', 'boostify' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => __( 'Title', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => __( 'Table of Contents', 'boostify' ),
			)
		);

		$this->add_control(
			'html_tag',
			array(
				'label'   => __( 'HTML Tag', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h2'  => 'H2',
					'h3'  => 'H3',
					'h4'  => 'H4',
					'h5'  => 'H5',
					'h6'  => 'H6',
					'div' => 'div',
				),
				'default' => 'h4',
			)
		);

		$this->start_controls_tabs( 'include_exclude_tags', array( 'separator' => 'before' ) );

		$this->start_controls_tab(
			'include',
			array(
				'label' => __( 'Include', 'boostify' ),
			)
		);

		$this->add_control(
			'headings_by_tags',
			array(
				'label'              => __( 'Anchors By Tags', 'boostify' ),
				'type'               => Controls_Manager::SELECT2,
				'multiple'           => true,
				'default'            => array( 'h2', 'h3', 'h4', 'h5', 'h6' ),
				'frontend_available' => true,
				'options'            => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				),
				'label_block'        => true,
			)
		);

		$this->add_control(
			'container',
			array(
				'label'              => __( 'Container', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'label_block'        => true,
				'description'        => __( 'This control confines the Table of Contents to heading elements under a specific container', 'boostify' ),
				'frontend_available' => true,
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'exclude',
			array(
				'label' => __( 'Exclude', 'boostify' ),
			)
		);

		$this->add_control(
			'exclude_headings_by_selector',
			array(
				'label'              => __( 'Anchors By Selector', 'boostify' ),
				'type'               => Controls_Manager::TEXT,
				'description'        => __( 'CSS selectors, in a comma-separated list', 'boostify' ),
				'default'            => array(),
				'label_block'        => true,
				'frontend_available' => true,
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'marker_view',
			array(
				'label'              => __( 'Marker View', 'boostify' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'numbers',
				'frontend_available' => true,
				'options'            => array(
					'numbers' => __( 'Numbers', 'boostify' ),
					'bullets' => __( 'Bullets', 'boostify' ),
				),
				'separator'          => 'before',
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'                  => __( 'Icon', 'boostify' ),
				'type'                   => Controls_Manager::ICONS,
				'default'                => array(
					'value'   => 'fas fa-circle',
					'library' => 'fa-solid',
				),
				'recommended'            => array(
					'fa-solid'   => array(
						'circle',
						'dot-circle',
						'square-full',
					),
					'fa-regular' => array(
						'circle',
						'dot-circle',
						'square-full',
					),
				),
				'condition'              => array(
					'marker_view' => 'bullets',
				),
				'skin'                   => 'inline',
				'label_block'            => false,
				'exclude_inline_options' => array( 'svg' ),
				'frontend_available'     => true,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'additional_options',
			array(
				'label' => __( 'Additional Options', 'boostify' ),
			)
		);

		$this->add_control(
			'word_wrap',
			array(
				'label'        => __( 'Word Wrap', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'ellipsis',
				'prefix_class' => 'boostify-toc--content-',
			)
		);

		$this->add_control(
			'minimize_box',
			array(
				'label'              => __( 'Minimize Box', 'boostify' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'expand_icon',
			array(
				'label'       => __( 'Icon', 'boostify' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => array(
					'value'   => 'fas fa-chevron-down',
					'library' => 'fa-solid',
				),
				'recommended' => array(
					'fa-solid'   => array(
						'chevron-down',
						'angle-down',
						'angle-double-down',
						'caret-down',
						'caret-square-down',
					),
					'fa-regular' => array(
						'caret-square-down',
					),
				),
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => array(
					'minimize_box' => 'yes',
				),
			)
		);

		$this->add_control(
			'collapse_icon',
			array(
				'label'       => __( 'Minimize Icon', 'boostify' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => array(
					'value'   => 'fas fa-chevron-up',
					'library' => 'fa-solid',
				),
				'recommended' => array(
					'fa-solid'   => array(
						'chevron-up',
						'angle-up',
						'angle-double-up',
						'caret-up',
						'caret-square-up',
					),
					'fa-regular' => array(
						'caret-square-up',
					),
				),
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => array(
					'minimize_box' => 'yes',
				),
			)
		);

		$breakpoints = Responsive::get_breakpoints();

		$this->add_control(
			'minimized_on',
			array(
				'label'              => __( 'Minimized On', 'boostify' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'tablet',
				'options'            => array(
					'mobile' => sprintf( __( 'Mobile (< %dpx)', 'boostify' ), $breakpoints['md'] ), //phpcs:ignore
					'tablet' => sprintf( __( 'Tablet (< %dpx)', 'boostify' ), $breakpoints['lg'] ), //phpcs:ignore
					'none'   => __( 'None', 'boostify' ),
				),
				'prefix_class'       => 'boostify-toc--minimized-on-',
				'condition'          => array(
					'minimize_box!' => '',
				),
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'hierarchical_view',
			array(
				'label'              => __( 'Hierarchical View', 'boostify' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'collapse_subitems',
			array(
				'label'              => __( 'Collapse Subitems', 'boostify' ),
				'type'               => Controls_Manager::SWITCHER,
				'description'        => __( 'The "Collapse" option should only be used if the Table of Contents is made sticky', 'boostify' ),
				'frontend_available' => true,
				'condition'          => array(
					'hierarchical_view' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'box_style',
			array(
				'label' => __( 'Box', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'background_color',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}' => '--box-background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'border_color',
			array(
				'label'     => __( 'Border Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--box-border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'border_width',
			array(
				'label'     => __( 'Border Width', 'boostify' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}}' => '--box-border-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'border_radius',
			array(
				'label'     => __( 'Border Radius', 'boostify' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}}' => '--box-border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'padding',
			array(
				'label'     => __( 'Padding', 'boostify' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}}' => '--box-padding: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'min_height',
			array(
				'label'              => __( 'Min Height', 'boostify' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => array( 'px', 'vh' ),
				'frontend_available' => true,
				'range'              => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'selectors'          => array(
					'{{WRAPPER}}' => '--box-min-height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'header_style',
			array(
				'label' => __( 'Header', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'header_background_color',
			array(
				'label'     => __( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--header-background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'header_text_color',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}}' => '--header-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'header_typography',
				'selector' => '{{WRAPPER}} .boostify-toc-header, {{WRAPPER}} .boostify-toc-header-title',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
			)
		);

		$this->add_control(
			'toggle_button_color',
			array(
				'label'     => __( 'Icon Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'minimize_box' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}}' => '--toggle-button-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'header_separator_width',
			array(
				'label'     => __( 'Separator Width', 'boostify' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}}' => '--separator-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'list_style',
			array(
				'label' => __( 'List', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'max_height',
			array(
				'label'      => __( 'Max Height', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}' => '--toc-body-max-height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'list_typography',
				'selector' => '{{WRAPPER}} .boostify-toc-list-item',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
			)
		);

		$this->add_control(
			'list_indent',
			array(
				'label'      => __( 'Indent', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit' => 'em',
				),
				'selectors'  => array(
					'{{WRAPPER}}' => '--nested-list-indent: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'item_text_style' );

		$this->start_controls_tab(
			'normal',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);

		$this->add_control(
			'item_text_color_normal',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
				'selectors' => array(
					'{{WRAPPER}}' => '--item-text-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'item_text_underline_normal',
			array(
				'label'     => __( 'Underline', 'boostify' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => array(
					'{{WRAPPER}}' => '--item-text-decoration: underline',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover',
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);

		$this->add_control(
			'item_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_ACCENT,
				),
				'selectors' => array(
					'{{WRAPPER}}' => '--item-text-hover-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'item_text_underline_hover',
			array(
				'label'     => __( 'Underline', 'boostify' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'selectors' => array(
					'{{WRAPPER}}' => '--item-text-hover-decoration: underline',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'active',
			array(
				'label' => __( 'Active', 'boostify' ),
			)
		);

		$this->add_control(
			'item_text_color_active',
			array(
				'label'     => __( 'Text Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--item-text-active-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'item_text_underline_active',
			array(
				'label'     => __( 'Underline', 'boostify' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => array(
					'{{WRAPPER}}' => '--item-text-active-decoration: underline',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_marker',
			array(
				'label'     => __( 'Marker', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'marker_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
				'selectors' => array(
					'{{WRAPPER}}' => '--marker-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'marker_size',
			array(
				'label'      => __( 'Size', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}}' => '--marker-size: {{SIZE}}{{UNIT}}',
				),
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
		$settings = $this->get_settings_for_display();
		$html_tag = $this->validate_html_tag( $settings['html_tag'] );
		?>
		<div class="boostify-addon-widget boostify-widget-toc">
			<div class="boostify-toc-header">
				<?php echo '<' . $html_tag . ' class="boostify-toc-header-title">' . $settings['title'] . '</' . $html_tag . '>'; //phpcs:ignore ?>
				<?php if ( 'yes' === $settings['minimize_box'] ) : ?>
					<div class="boostify-toc-toggle-button boostify-toc-toggle-button--expand"><?php Icons_Manager::render_icon( $settings['expand_icon'] ); ?></div>
					<div class="boostify-toc-toggle-button boostify-toc-toggle-button--collapse"><?php Icons_Manager::render_icon( $settings['collapse_icon'] ); ?></div>
				<?php endif; ?>
			</div>
			<div class="">
				<div class="boostify-toc-spinner-container">
					<i class="icon-spinner eicon-loading eicon-animation-spin" aria-hidden="true"></i>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Validate html tag.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @param (string) $tag | html tag.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function validate_html_tag( $tag ) {
		$allowed_html_wrapper_tags = array(
			'article',
			'aside',
			'div',
			'footer',
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6',
			'header',
			'main',
			'nav',
			'p',
			'section',
			'span',
		);

		return in_array( strtolower( $tag ), $allowed_html_wrapper_tags ) ? $tag : 'div'; //phpcs:ignore
	}
}
