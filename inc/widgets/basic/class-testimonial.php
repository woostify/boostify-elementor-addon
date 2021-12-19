<?php
/**
 * Widget Testimonial.
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
 * Testimonial
 *
 * Elementor widget for Testimonial.
 * Author: ptp
 */
class Testimonial extends Base_Widget {
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
		return 'testimonial';
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
		return esc_html__( 'Testimonial', 'boostify' );
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
		return 'boostify eicon-testimonial';
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
	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Testimonial', 'boostify' ),
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'content',
			array(
				'label'   => __( 'Content', 'boostify' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 10,
				'default' => __( 'Me and my travel buddy decided to book a tour on boostify, and that is the best decision we’ve ever made. The tour itself is full  excitement activities, but the staff are also kind & helpful. I’d love  to recommend this agent for all travel lovers', 'boostify' ),
			)
		);

		$repeater->add_control(
			'name',
			array(
				'label'       => __( 'Name', 'boostify' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => __( 'Megan lynch', 'boostify' ),
				'placeholder' => __( 'Enter Name', 'boostify' ),
			)
		);

		$repeater->add_control(
			'position',
			array(
				'label'       => __( 'Position', 'boostify' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => __( 'Design', 'boostify' ),
				'placeholder' => __( 'Enter Position', 'boostify' ),
			)
		);

		$repeater->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Image', 'boostify-tour' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_control(
			'testi',
			array(
				'label'       => __( 'Testimonial', 'boostify' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'default'     => array(
					array(
						'name'     => 'John Doe',
						'position' => 'Designer',
						'content'  => 'Me and my travel buddy decided to book a tour on boostify, and that is the best decision we’ve ever made. The tour itself is full  excitement activities, but the staff are also kind & helpful. I’d love  to recommend this agent for all travel lovers',
					),
					array(
						'name'     => 'Nick',
						'position' => 'Designer',
						'content'  => 'Me and my travel buddy decided to book a tour on boostify, and that is the best decision we’ve ever made. The tour itself is full  excitement activities, but the staff are also kind & helpful. I’d love  to recommend this agent for all travel lovers',
					),
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			array(
				'name'        => 'thumbnail',
				'default'     => 'full',
				'label'       => esc_html__( 'Image Size', 'boostify-tour' ),
				'description' => esc_html__( 'Custom image size when selected image.', 'boostify-tour' ),
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
			'testimonial_heading',
			array(
				'label' => __( 'Testimonial', 'boostify' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'    => 40,
					'left'   => 40,
					'bottom' => 40,
					'right'  => 40,
					'unit '  => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .testimonial-item--wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'align',
			array(
				'label'   => __( 'Alignment', 'boostify' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
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
						'icon'  => 'eicon-h-align-center',
					),
				),
				'default' => 'center',
				'toggle'  => true,
			)
		);

		$this->add_control(
			'name_heading',
			array(
				'label'     => __( 'Name', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'name_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1c1c1c',
				'selectors' => array(
					'{{WRAPPER}} .name' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'name_typography',
				'label'    => __( 'Typography', 'boostify' ),
				'selector' => '{{WRAPPER}} .name',
			)
		);

		$this->add_responsive_control(
			'space',
			array(
				'label'      => __( 'Space', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 90,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .name' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'name_position',
			array(
				'label'     => __( 'Job', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'position_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#999999',
				'selectors' => array(
					'{{WRAPPER}} .position' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'position_typography',
				'label'    => __( 'Typography', 'boostify' ),
				'selector' => '{{WRAPPER}} .position',
			)
		);

		$this->add_responsive_control(
			'position_space',
			array(
				'label'      => __( 'Space', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 90,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .position' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'content_heading',
			array(
				'label'     => __( 'Content', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'content_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#666666',
				'selectors' => array(
					'{{WRAPPER}} .content' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'conent_typography',
				'label'    => __( 'Typography', 'boostify' ),
				'selector' => '{{WRAPPER}} .content',
			)
		);

		$this->add_responsive_control(
			'space_content',
			array(
				'label'      => __( 'Space', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 40,
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 90,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .testimonial-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'dots_heading',
			array(
				'label'     => __( 'Dots', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'dots_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#8d8d8d',
				'selectors' => array(
					'{{WRAPPER}} .widget-testimonial--wrapper.swiper-container-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'dots_color_active',
			array(
				'label'     => __( 'Color Active', 'boostify' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#e6183f',
				'selectors' => array(
					'{{WRAPPER}} .widget-testimonial--wrapper.swiper-container-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'space_dots',
			array(
				'label'      => __( 'Space', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 90,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .swiper-pagination-bullets' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'testimonial_layout',
			array(
				'label' => __( 'Layout', 'boostify' ),
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
			'show_avatar',
			array(
				'label'        => __( 'Show Avatar', 'boostify' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'boostify' ),
				'label_off'    => __( 'Hide', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'column',
			array(
				'label'   => __( 'Column', 'boostify' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
			)
		);

		$this->add_control(
			'arrow',
			array(
				'label'        => __( 'Show Arrow', 'boostify' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'boostify' ),
				'label_off'    => __( 'Hide', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'dot',
			array(
				'label'        => __( 'Show Dots', 'boostify' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'boostify' ),
				'label_off'    => __( 'Hide', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
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
		$settings    = $this->get_settings_for_display();
		$list        = $settings['testi'];
		$layout      = $settings['layout'];
		$show_avatar = $settings['show_avatar'];
		$col         = $settings['column'];
		$arrow       = $settings['arrow'];
		$dot         = $settings['dot'];
		$action      = 'boostify_testimonial_' . $layout;
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
		$layouts = $layout->testimonial();

		return $layouts;
	}

	/**
	 * Register Layout.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @param array $item | image data.
	 * @param array $settings | Setting data.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	private function get_image( $item, $settings ) {
		if ( empty( $item['image']['id'] ) ) {

			?>
			<img src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
			<?php

		} else {
			$url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $item['image']['id'], 'thumbnail', $settings );
			?>
			<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
			<?php
		}
	}

}
