<?php

namespace Boostify_Elementor\Widgets;

use Boostify_Elementor\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

/**
 * Button
 *
 * Elementor widget for Button.
 * Author: ptp
 */
class Button extends Base_Widget {

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
		return 'button';
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
		return 'boostify eicon-button';
	}

	protected function _register_controls() { //phpcs:ignore
		$this->start_controls_section(
			'section_title',
			array(
				'label' => __( 'Button', 'boostify' ),
			)
		);

		$this->add_control(
			'text',
			array(
				'label'       => __( 'Label', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Click Me', 'boostify' ),
				'placeholder' => __( 'Enter button label', 'boostify' ),
				'label_block' => true,
				'dynamic'     => array(
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
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_responsive_control(
			'align',
			array(
				'label'        => __( 'Alignment', 'boostify' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'left',
				'options'      => array(
					'left'    => array(
						'title' => __( 'Left', 'boostify' ),
						'icon'  => 'fa fa-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'boostify' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'   => array(
						'title' => __( 'Right', 'boostify' ),
						'icon'  => 'fa fa-align-right',
					),
					'justify' => array(
						'title' => __( 'Justify', 'boostify' ),
						'icon'  => 'fa fa-align-justify',
					),
				),
				'prefix_class' => 'boostify%s-align-',
			)
		);

		$this->add_control(
			'effect',
			array(
				'label'   => __( 'Effect', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default'         => __( 'Default', 'boostify' ),
					'slide-to-top'    => __( 'Slide To Top', 'boostify' ),
					'slide-to-bottom' => __( 'Slide To Bottom', 'boostify' ),
					'slide-to-left'   => __( 'Slide To Left', 'boostify' ),
					'slide-to-right'  => __( 'Slide To Right', 'boostify' ),
					'grow'            => __( 'Grow', 'boostify' ),
					'shrink'          => __( 'Shrink', 'boostify' ),
					'push'            => __( 'Push', 'boostify' ),
				),
			)
		);

		$this->add_control(
			'icon',
			array(
				'label' => __( 'Icon', 'boostify' ),
				'type'  => Controls_Manager::ICONS,
			)
		);

		$this->add_control(
			'icon_position',
			array(
				'label'     => __( 'Icon Position', 'boostify' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'row'         => array(
						'title' => __( 'Left', 'boostify' ),
						'icon'  => 'eicon-h-align-left',
					),
					'row-reverse' => array(
						'title' => __( 'Right', 'boostify' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'   => 'row',
				'selectors' => array(
					'{{WRAPPER}} .boostify--btn'        => 'flex-direction: {{VALUE}};',
					'{{WRAPPER}} .boostify-btn-default' => 'flex-direction: {{VALUE}};',
					'{{WRAPPER}} .boostify-label-hover' => 'flex-direction: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'font_size_icon',
			array(
				'label'      => __( 'Font Size', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 10,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_space_left',
			array(
				'label'      => __( 'Space', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 50,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn-icon' => 'padding-right: {{SIZE}}{{UNIT}};',
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 5,
				),
				'condition'  => array(
					'icon_position' => 'row',
				),
			)
		);

		$this->add_responsive_control(
			'icon_space_right',
			array(
				'label'      => __( 'Space', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 50,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn-icon' => 'padding-left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'icon_position' => 'row-reverse',
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 5,
				),
			)
		);

		$this->add_control(
			'id_button',
			array(
				'label'       => __( 'Id Button', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter button label', 'boostify' ),
				'label_block' => true,
				'description' => __( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows A-z 0-9 & underscore chars without spaces.', 'boostify' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'button_style',
			array(
				'label' => __( 'Button', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify--btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'border',
				'label'    => __( 'Border', 'boostify' ),
				'selector' => '{{WRAPPER}} .boostify--btn',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow',
				'label'    => __( 'Box Shadow', 'boostify' ),
				'selector' => '{{WRAPPER}} .boostify--btn',
			)
		);

		$this->start_controls_tabs( 'button' );

		$this->start_controls_tab(
			'button_normal',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);

		$this->add_responsive_control(
			'border_radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify--btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'background',
				'label'    => __( 'Background', 'boostify' ),
				'types'    => array( 'classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .boostify-btn-default, {{WRAPPER}} .boostify-btn--hover',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_hover',
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);

		$this->add_responsive_control(
			'border_radius_hover',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify--btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'background_hover',
				'label'    => __( 'Background', 'boostify' ),
				'types'    => array( 'classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .boostify--btn .boostify-btn--hover, {{WRAPPER}} .boostify--btn.btn-effect-default:hover .boostify-btn--hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'label_style',
			array(
				'label' => __( 'Label', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'label' );

		$this->start_controls_tab(
			'labelt_normal',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);

		$this->add_control(
			'label_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					// Stronger selector to avoid section style from overwriting.
					'{{WRAPPER}} .boostify-btn-default' => 'color: {{VALUE}};',
					'{{WRAPPER}} .btn-effect-default .boostify-label-hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'label_hover',
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);

		$this->add_control(
			'label_color_hover',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					// Stronger selector to avoid section style from overwriting.
					'{{WRAPPER}} .boostify-label-hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .btn-effect-default:hover .boostify-label-hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .boostify-btn-default, {{WRAPPER}} .boostify-label-hover',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Render Button output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.2.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$label    = $settings['text'];
		$url      = $settings['link'];
		$icons    = $settings['icon'];
		$this->link( $url );
		$this->class( $settings );
		?>
		<div class="boostify-addon-widget boostify-button-widget">
			<a <?php echo $this->get_render_attribute_string( 'button' ); // phpcs:ignore ?>>
				<span class="boostify-btn-default">
					<?php
						$this->icon( $icons, $label );
						echo esc_html( $label );
					?>
				</span>
				<span class="boostify-label-hover">
					<?php
						$this->icon( $icons, $label );
						echo esc_html( $label );
					?>
				</span>
				<span class="boostify-btn--hover"></span>
			</a>
		</div>
		<?php
	}

	protected function link( $url ) {
		if ( $url['url'] ) {
			$link = $url['url'];
		} else {
			$link = '#';
		}
		if ( $url['is_external'] ) {
			$this->add_render_attribute(
				'button',
				array(
					'target' => '_blank',
				)
			);
		}

		$this->add_render_attribute(
			'button',
			array(
				'href' => $link,
			)
		);
	}

	public function class( $settings ) {
		$effect  = $settings['effect'];
		$id      = $settings['id_button'];
		$classes = array(
			'boostify--btn',
			'boostify-btn-wrapper',
			'btn-effect-' . $settings['effect'],
		);
		if ( 'push' === $effect || 'shrink' === $effect || 'grow' === $effect ) {
			array_push( $classes, 'btn-effect-default' );
		}
		$this->add_render_attribute(
			'button',
			array(
				'class' => $classes,
				'id'    => $id,
			)
		);
	}

	public function icon( $icons, $label ) {
		if ( empty( $icons['library'] ) ) {
			return;
		}

		if ( 'svg' === $icons['library'] ) {
			?>
			<img src="<?php echo esc_url( $icons['value']['url'] ); ?>" alt="<?php echo esc_attr( $label ); ?>" class="btn-icon">
			<?php
		} else {
			?>
			<i class="btn-icon <?php echo esc_attr( $icons['value'] ); ?>"></i>
			<?php
		}
	}
}
