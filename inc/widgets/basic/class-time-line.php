<?php
/**
 * Time Line Widget
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
 * Time Line
 *
 * Elementor widget for Video
 *
 */
class Time_Line extends Base_Widget {

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
		return 'time-line';
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
		return 'boostify eicon-time-line';
	}

	protected function _register_controls() { //phpcs:ignore
		$this->start_controls_section(
			'section_title',
			array(
				'label' => __( 'Time Line', 'boostify' ),
			)
		);
		$this->add_control(
			'tl_type',
			array(
				'label'   => esc_html__( 'Timeline Type', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left-right',
				'options' => array(
					'left-right' => esc_html__( 'Left and Right', 'boostify' ),
					'left'       => esc_html__( 'Left Side Only', 'boostify' ),
					'right'      => esc_html__( 'Right Side Only', 'boostify' ),
				),
			),
		);
		$this->add_control(
			'enable_image',
			array(
				'label'        => esc_html__( 'Show Image', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'boostify' ),
				'label_off'    => esc_html__( 'No', 'boostify' ),
				'return_value' => 'yes',
			)
		);
		$this->add_control(
			'enable_date',
			array(
				'label'        => esc_html__( 'Show Date', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'boostify' ),
				'label_off'    => esc_html__( 'No', 'boostify' ),
				'return_value' => 'yes',
			)
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'tl_icon',
			array(
				'label'   => __( 'Choose Icon', 'boostify' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-plus',
					'library' => 'fa-solid',
				),
			),
		);
		$repeater->add_control(
			'tl_image',
			array(
				'label'   => esc_html__( 'Image', 'boostify' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);
		$repeater->add_control(
			'tl_due_date',
			array(
				'label'   => __( 'Due Date', 'boostify' ),
				'type'    => Controls_Manager::DATE_TIME,
				'default' => '2020-12-12 00:00',
			),
		);
		$repeater->add_control(
			'tl_title',
			array(
				'label'       => esc_html__( 'Title', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Title', 'boostify' ),
				'default'     => esc_html__( 'Elit eros tincidunt sem', 'boostify' ),
			)
		);
		$repeater->add_control(
			'tl_content',
			array(
				'label'       => esc_html__( 'Content', 'boostify' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter Content', 'boostify' ),
				'default'     => esc_html__( 'Fusce cursus, elit quis imperdiet ullamcorper, elit eros tincidunt sem, non rhoncus massa elit eget. Nam interdum sed quam amet accumsan. Donec non molestie nisi, id sollicitudin dui. Fusce tempus sapien. Praesent quis pellentesque metus dunt.', 'boostify' ),
			)
		);
		$this->add_control(
			'tl_items',
			array(
				'label'   => esc_html__( 'Items', 'boostify' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => array(
					array(),
					array(),
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'tl_gen_style',
			array(
				'label' => __( 'General', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'tl_gen_border',
				'label'    => __( 'Border', 'boostify' ),
				'selector' => '{{WRAPPER}} .btf-time-line__item',
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'tl_gen_boxshadow',
				'label'    => __( 'Box Shadow', 'boostify' ),
				'selector' => '{{WRAPPER}} .btf-time-line__item',
			)
		);
		$this->add_responsive_control(
			'tl_gen_padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .btf-time-line__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'tl_gen_margin',
			array(
				'label'      => __( 'Magin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .btf-time-line-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'tl_line_color',
			array(
				'label'     => __( 'Time Line Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#999999',
				'selectors' => array(
					'{{WRAPPER}} .btf-time-line::before' => 'background-color: {{VALUE}};',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'tl_image_style',
			array(
				'label'     => __( 'Image', 'boostify' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'enable_image' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'        => 'item_thumb_size',
				'default'     => 'medium_large',
				'label'       => esc_html__( 'Image Size', 'boostify' ),
				'description' => esc_html__( 'Custom thumbnail size.', 'boostify' ),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'tl_date_style',
			array(
				'label'     => __( 'Date', 'boostify' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'enable_date' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tl_date_typography',
				'selector' => '{{WRAPPER}} .btf-time-line__item__date',
			)
		);
		$this->add_control(
			'tl_date_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .btf-time-line__item__date' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'tl_date_brg_color',
			array(
				'label'     => esc_html__( 'Background color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .btf-time-line__item__date' => 'background-color: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'tl_date_padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .btf-time-line__item__date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'tl_date_margin',
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .btf-time-line__item__date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'tl_date_border',
				'label'    => __( 'Border', 'boostify' ),
				'selector' => '{{WRAPPER}} .btf-time-line__item__date',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'tl_title_style',
			array(
				'label' => __( 'Title', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tl_title_typography',
				'selector' => '{{WRAPPER}} .btf-time-line__item__title',
			)
		);
		$this->add_control(
			'tl_title_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .btf-time-line__item__title' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'tl_title_margin',
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .btf-time-line__item__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'tl_content_style',
			array(
				'label' => __( 'Content', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tl_content_typography',
				'selector' => '{{WRAPPER}} .btf-time-line__item__content',
			)
		);
		$this->add_control(
			'tl_content_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .btf-time-line__item__content' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'tl_content_margin',
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .btf-time-line__item__content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
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
		$tl_type  = $settings['tl_type'];
		$items    = $settings['tl_items'];
		$en_image = ( 'yes' === $settings['enable_image'] ) ? true : false;
		$en_date  = ( 'yes' === $settings['enable_date'] ) ? true : false;
		?>
			<div class="btf-time-line tl-<?php echo esc_attr( $tl_type ); ?>">
				<?php
				foreach ( $items as $item ) {
					$item_img_url = Group_Control_Image_Size::get_attachment_image_src( $item['tl_image']['id'], 'item_thumb_size', $settings );
					$item_date    = date_i18n( apply_filters( 'wpb_ea_timeline_date_format', get_option( 'date_format' ) ), strtotime( $item['tl_due_date'] ) );
					?>
					<div class="btf-time-line-wrap">
						<div class="btf-time-line__item">
							<div class="btf-time-line__item__icon">
								<?php $this->icon_play( $item['tl_icon'] ); ?>
							</div>
							<?php if ( $en_image ) : ?>
							<div class="btf-time-line__item__image"><img src="<?php echo esc_url( $item_img_url ); ?>" alt="item-img"></div>
							<?php endif; ?>
							<?php if ( $en_date ) : ?>
							<div class="btf-time-line__item__date"><?php echo esc_html( $item_date ); ?></div>
							<?php endif; ?>
							<div class="btf-time-line__item__title"><?php echo esc_html( $item['tl_title'] ); ?></div>
							<div class="btf-time-line__item__content"><?php echo esc_html( $item['tl_content'] ); ?></div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		<?php
	}

	/**
	 * Get btn icon.
	 *
	 * @param string $icon settting of icon default.
	 */
	public function icon_play( $icon ) {
		if ( empty( $icon['library'] ) ) {
			return;
		}
		if ( 'svg' === $icon_common['library'] ) {
			?>
			<img src="<?php echo esc_url( $icon['value']['url'] ); ?>" alt="play-icon">
			<?php
		} else {
			?>
			<i class="<?php echo esc_attr( $icon['value'] ); ?>"></i>
			<?php
		}
	}

}
