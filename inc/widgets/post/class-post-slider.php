<?php

namespace Boostify_Elementor\Widgets;

use Boostify_Elementor\Posts\Skin\Layout as Layout;
use Boostify_Elementor\Group_Control_Post;
use Boostify_Elementor\Posts\Base\Post_Base;
use Elementor\Controls_Manager;
/**
 * Post Slider
 *
 * Elementor widget for Post Slider.
 * Author: ptp
 */
class Post_Slider extends Post_Base {

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
		return 'post-slider';
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
		return 'boostify eicon-post-slider';
	}

	public function get_script_depends() {
		return array( 'boostify-addon-post-slider' );
	}

	public function _register_controls() { //phpcs:ignore
		$this->start_controls_section(
			'section_post_slider',
			array(
				'label' => __( 'Post Slider', 'boostify' ),
			)
		);
		$this->layout_control();
		$this->meta_control();
		$this->end_controls_section();

		$this->query_control();

		$this->slider_pagination();

		$this->slider_style_control();

		$this->box_style_control();

		$this->thumbnail_style_controll();

		$this->title_style_control();

		$this->meta_style_control();

		$this->excpert_style_control();

		$this->read_more_style_control();
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
		$columns    = $settings['columns'];
		$posts      = $this->query_args( $settings );
		$total_page = $posts->max_num_pages;
		$action     = 'boostify_post_slider_' . $settings['layout'];
		$classes    = array(
			'boostify-widget-post-slider-wrapper',
			'boostify-slider-tablet-' . $settings['columns_tablet'],
			'boostify-slider-mobile-' . $settings['columns_mobile'],
			'boostify-layout-' . $settings['layout'],
			'swiper-wrapper',
		);
		$class      = implode( ' ', $classes );
		if ( $posts->have_posts() ) {
			?>
			<div class="boostify-addon-widget swiper-container boostify-post-slider-widget" columns="<?php echo esc_attr( $columns ); ?>" columns-tablet="<?php echo esc_attr( $settings['columns_tablet'] ); ?>" columns-mobile="<?php echo esc_attr( $settings['columns_mobile'] ); ?>" arrow="<?php echo esc_attr( $settings['arrow'] ); ?>" dots="<?php echo esc_attr( $settings['dot'] ); ?>" slider-autoplay="<?php echo esc_attr( $settings['autoplay'] ); ?>" data-space-between="20">
				<div class="<?php echo esc_attr( $class ); ?>" slide-speed="<?php echo esc_attr( $settings['speed'] ); ?>" slide-scroll="<?php echo esc_attr( $settings['slide_scroll'] ); ?>" slider-loop="<?php echo esc_attr( $settings['loop'] ); ?>" column-space="<?php echo esc_attr( $settings['columns_space']['size'] ); ?>">
					<?php
					while ( $posts->have_posts() ) {
						$posts->the_post();
						do_action( $action, $settings );
					}
					?>
				</div>
				<!-- If we need pagination -->
				<div class="swiper-pagination"></div>
				<?php if ( $settings['arrow'] ) : ?>
					<!-- If we need navigation buttons -->
					<div class="swiper-button-prev"></div>
					<div class="swiper-button-next"></div>
				<?php endif ?>
			</div>
			<?php

			wp_reset_postdata();
		}
	}

	public function layouts() {
		$layouts = Layout::post_slider();

		return $layouts;
	}

	protected function layout_control() {
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
	}

	protected function slider_pagination() {
		$this->start_controls_section(
			'section_slider_pagination',
			array(
				'label' => __( 'Slider Pagination', 'boostify' ),
			)
		);

		$this->add_control(
			'arrow',
			array(
				'label'        => esc_html__( 'Arrow', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'boostify' ),
				'label_off'    => __( 'Hide', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'dot',
			array(
				'label'        => esc_html__( 'Dots', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'boostify' ),
				'label_off'    => __( 'Hide', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'True', 'boostify' ),
				'label_off'    => __( 'False', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'     => esc_html__( 'Speed', 'boostify' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '3500',
				'condition' => array(
					'autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'slide_scroll',
			array(
				'label'   => esc_html__( 'Slide To Scroll', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'1' => esc_html__( '1', 'boostify' ),
					'2' => esc_html__( '2', 'boostify' ),
					'3' => esc_html__( '3', 'boostify' ),
					'4' => esc_html__( '4', 'boostify' ),
					'5' => esc_html__( '5', 'boostify' ),
				),
				'default' => '1',
			)
		);

		$this->add_control(
			'loop',
			array(
				'label'        => esc_html__( 'Loop', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'True', 'boostify' ),
				'label_off'    => __( 'False', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();
	}

	protected function slider_style_control() {
		$this->start_controls_section(
			'style_post',
			array(
				'label' => __( 'Slider', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
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
			)
		);

		$this->add_responsive_control(
			'row_space',
			array(
				'label'      => __( 'Dots Space', 'boostify' ),
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

		$this->add_control(
			'arrow_heading',
			array(
				'label'     => __( 'Arrow', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'arrow' => 'yes',
				),
			)
		);

		$this->add_control(
			'arrow_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => array(
					'{{WRAPPER}} .swiper-button-prev' => 'color: {{VALUE}};',
					'{{WRAPPER}} .swiper-button-next' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'arrow' => 'yes',
				),
			)
		);

		$this->add_control(
			'arrow_backgroud_color',
			array(
				'label'     => __( 'Backgroud Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => array(
					'{{WRAPPER}} .swiper-button-prev' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .swiper-button-next' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'arrow' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'arrow_size',
			array(
				'label'      => __( 'Font Size', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .swiper-button-next:after' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .swiper-button-prev:after' => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'arrow' => 'yes',
				),
			)
		);

		$this->add_control(
			'dots_heading',
			array(
				'label'     => __( 'Dots', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'dot' => 'yes',
				),
			)
		);

		$this->add_control(
			'dot_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => array(
					'{{WRAPPER}} .swiper-pagination-bullet' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'dot' => 'yes',
				),
			)
		);

		$this->add_control(
			'dot_backgroud_color',
			array(
				'label'     => __( 'Color Active', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#CC3366',
				'selectors' => array(
					'{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'dot' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'dot_size',
			array(
				'label'      => __( 'Width', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'dot' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'dot_space',
			array(
				'label'      => __( 'Space', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .swiper-container-horizontal .swiper-pagination-bullet:not(last-child)' => 'margin: 0 {{SIZE}}{{UNIT}} 0 0',
				),
				'condition'  => array(
					'dot' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

}
