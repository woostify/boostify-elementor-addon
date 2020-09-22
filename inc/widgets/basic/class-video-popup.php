<?php
/**
 * Video Popup Widget
 *
 * @package Boostify Elementor Widget
 */

namespace Boostify_Elementor\Widgets;

use Boostify_Elementor\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

/**
 * Video Popup
 *
 * Elementor widget for Video
 * Author: ptp
 */
class Video_Popup extends Base_Widget {

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
		return 'video-popup';
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
		return 'boostify eicon-play';
	}
	/**
	 * Script depend.
	 */
	public function get_script_depends() {
		return array( 'boostify-addon-video-popup' );
	}

	protected function _register_controls() { //phpcs:ignore
		$this->start_controls_section(
			'section_title',
			array(
				'label' => __( 'Play Button', 'boostify' ),
			)
		);
		$this->add_control(
			'pop_btn',
			array(
				'label'       => __( 'Text', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Click Me', 'boostify' ),
				'placeholder' => __( 'Enter button label', 'boostify' ),
			)
		);
		$this->add_responsive_control(
			'wrapper_v_align',
			array(
				'label'     => __( 'Verticle Align', 'boostify' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => array(
					'flex-start' => __( 'Start', 'boostify' ),
					'center'     => __( 'Center', 'boostify' ),
					'flex-end'   => __( 'End', 'boostify' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .video-popup-wrapper' => 'justify-content: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'wrapper_h_align',
			array(
				'label'     => __( 'Horizontal Align', 'boostify' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => array(
					'flex-start' => __( 'Start', 'boostify' ),
					'center'     => __( 'Center', 'boostify' ),
					'flex-end'   => __( 'End', 'boostify' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .video-popup-wrapper' => 'align-items: {{VALUE}};',
				),
				'condition' => array(
					'enable_thumb' => 'yes',
				),
			)
		);
		$this->add_control(
			'icon_play',
			array(
				'label'   => __( 'Icon', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'common' => __( 'Icon', 'boostify' ),
					'custom' => __( 'Image', 'boostify' ),
				),
			)
		);
		$this->add_control(
			'icon_common',
			array(
				'label'     => __( 'Choose from library', 'boostify' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => 'fas fa-play-circle',
				'condition' => array(
					'icon_play' => 'common',
				),
			),
		);

		$this->add_control(
			'icon_custom',
			array(
				'label'     => __( 'Your Image', 'boostify' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'icon_play' => 'custom',
				),
			),
		);
		$this->add_control(
			'data_source',
			array(
				'label'       => esc_html__( 'Video URL', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'https://www.youtube.com/watch?v=9uOETcuFjbE',
				'placeholder' => esc_attr__( 'Enter URL Video', 'boostify' ),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_title2',
			array(
				'label' => __( 'Image Overlay', 'boostify' ),
			)
		);
		$this->add_control(
			'enable_thumb',
			array(
				'label'        => esc_html__( 'Enable', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'boostify' ),
				'label_off'    => esc_html__( 'No', 'boostify' ),
				'return_value' => 'yes',
			)
		);
		$this->add_control(
			'vid_thumb',
			array(
				'label'     => __( 'Choose Image', 'boostify' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'enable_thumb' => 'yes',
				),
			),
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'        => 'vid_thumb_size',
				'default'     => 'full',
				'label'       => esc_html__( 'Thumbnail', 'boostify' ),
				'description' => esc_html__( 'Custom thumbnail size.', 'boostify' ),
				'condition'   => array(
					'enable_thumb' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'vid_thumb_height',
			array(
				'label'      => __( 'Height ', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 10,
						'max'  => 1000,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .video-popup-wrapper' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'enable_thumb' => 'yes',
				),
			)
		);
		$this->add_control(
			'hide_btn_play',
			array(
				'label'        => esc_html__( 'Hide Play Button', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '1',
				'label_on'     => esc_html__( 'Yes', 'boostify' ),
				'label_off'    => esc_html__( 'No', 'boostify' ),
				'return_value' => '0',
				'selectors'    => array(
					'{{WRAPPER}} .boostify-popup-btn' => 'opacity: {{VALUE}};',
				),
				'condition'    => array(
					'enable_thumb' => 'yes',
				),
			)
		);
		$this->end_controls_section();

		/*
		 * Style option.
		 */
		$this->start_controls_section(
			'video_popup_style',
			array(
				'label' => __( 'Button', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'play_btn_width_opt',
			array(
				'label'   => __( 'Width', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'inline',
				'options' => array(
					'full'   => __( 'Full', 'boostify' ),
					'custom' => __( 'Custom', 'boostify' ),
					'inline' => __( 'Inline', 'boostify' ),
				),
			)
		);
		$this->add_responsive_control(
			'play_btn_width_custom',
			array(
				'label'      => __( 'Size', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 10,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 10,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .video-popup-wrapper .width--custom ' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'play_btn_width_opt' => 'custom',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'pop_btn_typography',
				'selector' => '{{WRAPPER}} .boostify-popup-btn',
			)
		);
		$this->add_responsive_control(
			'padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-popup-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'popup_btn_hover_style',
			array(
				'label'     => __( 'Hover', 'boostify' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			),
		);
		$this->start_controls_tabs( 'popup_btn' );
		$this->start_controls_tab(
			'popup_btn_normal',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);
		$this->add_control(
			'popup_btn_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-popup-btn' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'pop_btn_brg_color',
			array(
				'label'     => esc_html__( 'Background color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-popup-btn' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'pop_btn_border',
				'label'    => __( 'Border', 'boostify' ),
				'selector' => '{{WRAPPER}} .boostify-popup-btn',
			)
		);
		$this->add_responsive_control(
			'pop_btn_border_radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-popup-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'pop_btn_box_shadow',
				'label'    => __( 'Box Shadow', 'boostify' ),
				'selector' => '{{WRAPPER}} .boostify-popup-btn',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'popup_btn_hover',
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);
		$this->add_control(
			'popup_btn_color_hover',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-popup-btn:hover' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'pop_btn_brg_color_hover',
			array(
				'label'     => esc_html__( 'Background color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-popup-btn:hover' => 'background-color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'pop_btn_border_hover',
				'label'    => __( 'Border', 'boostify' ),
				'selector' => '{{WRAPPER}} .boostify-popup-btn:hover',
			)
		);
		$this->add_responsive_control(
			'pop_btn_border_radius_hover',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-popup-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'pop_btn_box_shadow_hover',
				'label'    => __( 'Box Shadow', 'boostify' ),
				'selector' => '{{WRAPPER}} .boostify-popup-btn:hover',
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'icon_play_style',
			array(
				'label' => __( 'Icon Play', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'icon_play_position',
			array(
				'label'     => __( 'Icon Position', 'boostify' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'row',
				'options'   => array(
					'row'            => array(
						'title' => __( 'Left', 'boostify' ),
						'icon'  => 'eicon-h-align-left',
					),
					'column-reverse' => array(
						'title' => __( 'Bottom', 'boostify' ),
						'icon'  => 'eicon-v-align-bottom',
					),
					'column'         => array(
						'title' => __( 'Top', 'boostify' ),
						'icon'  => 'eicon-v-align-top',
					),
					'row-reverse'    => array(
						'title' => __( 'Right', 'boostify' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-popup-btn' => 'flex-direction: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'popup_btn_v_align',
			array(
				'label'     => __( 'Verticle Align', 'boostify' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => array(
					'flex-start' => __( 'Start', 'boostify' ),
					'center'     => __( 'Center', 'boostify' ),
					'flex-end'   => __( 'End', 'boostify' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-popup-btn' => 'justify-content: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'popup_btn_h_align',
			array(
				'label'     => __( 'Horizontal Align', 'boostify' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => array(
					'flex-start' => __( 'Start', 'boostify' ),
					'center'     => __( 'Center', 'boostify' ),
					'flex-end'   => __( 'End', 'boostify' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-popup-btn' => 'align-items: {{VALUE}};',
				),

			)
		);
		$this->add_responsive_control(
			'icon_common_size',
			array(
				'label'      => __( 'Icon Font Size ', 'boostify' ),
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
					'{{WRAPPER}} .boostify-popup-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'icon_play' => 'common',
				),
			)
		);
		$this->add_responsive_control(
			'icon_common_margin',
			array(
				'label'      => __( 'Icon Magin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-popup-btn i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'icon_play' => 'common',
				),
			)
		);
		/* Style for common icon. */
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'        => 'custom_play_icon',
				'default'     => 'full',
				'label'       => esc_html__( 'Thumbnail', 'boostify' ),
				'description' => esc_html__( 'Custom thumbnail size.', 'boostify' ),
				'condition'   => array(
					'icon_play' => 'custom',
				),

			)
		);
		$this->add_responsive_control(
			'custom_icon_dimension',
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-popup-btn img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'icon_play' => 'custom',
				),
			)
		);
		$this->start_controls_tabs(
			'icon_play_custom',
			array(
				'condition' => array(
					'icon_play' => 'custom',
				),
			),
		);
		$this->start_controls_tab(
			'icon_play_custom_nor',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'custom_icon_filter',
				'label'    => __( 'Fiter', 'boostify' ),
				'selector' => '{{WRAPPER}} .boostify-popup-btn img',
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'custom_icon_shadow',
				'label'    => __( 'Box Shadow', 'boostify' ),
				'selector' => '{{WRAPPER}} .boostify-popup-btn img',
			)
		);
		$this->add_responsive_control(
			'custom_icon_border_radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-popup-btn img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'icon_play_custom_hover',
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'custom_icon_filter_hover',
				'label'    => __( 'Fiter', 'boostify' ),
				'selector' => '{{WRAPPER}} .boostify-popup-btn img:hover',
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'custom_icon_shadow_hover',
				'label'    => __( 'Box Shadow', 'boostify' ),
				'selector' => '{{WRAPPER}} .boostify-popup-btn img:hover',
			)
		);
		$this->add_responsive_control(
			'custom_icon_border_radius_hover',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-popup-btn img:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

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
		$settings     = $this->get_settings_for_display();
		$data_src     = $settings['data_source'];
		$pop_btn      = $settings['pop_btn'];
		$icon_is_cus  = ( 'common' === $settings['icon_play'] ) ? false : true;
		$icon_common  = $settings['icon_common'];
		$icon_custom  = $settings['icon_custom'];
		$class_width  = $settings['play_btn_width_opt'];
		$enable_thumb = ( 'yes' === $settings['enable_thumb'] ) ? true : false;
		$icon_cus_url = Group_Control_Image_Size::get_attachment_image_src( $icon_custom['id'], 'custom_play_icon', $settings );
		$thumb_url    = Group_Control_Image_Size::get_attachment_image_src( $settings['vid_thumb']['id'], 'vid_thumb_size', $settings );
		$has_thumb    = ( $enable_thumb ) ? 'video-popup-has-thumbnail' : '';
		?>
		<?php if ( $enable_thumb ) : ?>
			<div class="video-popup-has-thumbnail">
				<img class="video-popup-has-thumbnail__img" src="<?php echo esc_url( $thumb_url ); ?>" alt="thumbnail">
		<?php endif ?>
		<div class="video-popup-wrapper <?php echo esc_attr( $has_thumb ); ?>">
			<a class="boostify-popup-btn width--<?php echo esc_attr( $class_width ); ?>" href="<?php echo esc_attr( $data_src ); ?>">
				<?php
				if ( $icon_is_cus && ! $is_icon_def ) {
					?>
					<img src="<?php echo esc_url( $icon_cus_url ); ?>" alt="cus_icon-play">
					<?php
				} else {
					$this->icon_play( $icon_common );
				}
					echo esc_html( $pop_btn );
				?>
			</a>
		</div>
		<?php if ( $enable_thumb ) : ?>
			</div>
		<?php endif ?>
		<?php
	}

	/**
	 * Get btn icon.
	 *
	 * @param string $icon_common settting of icon default.
	 */
	public function icon_play( $icon_common ) {
		if ( empty( $icon_common['library'] ) ) {
			return;
		}
		if ( 'svg' === $icon_common['library'] ) {
			?>
			<img src="<?php echo esc_url( $icon_common['value']['url'] ); ?>" alt="play-icon">
			<?php
		} else {
			?>
			<i class="<?php echo esc_attr( $icon_common['value'] ); ?>"></i>
			<?php
		}
	}

}
