<?php
/**
 * Video Count Down Widget
 *
 * @package Boostify Elementor Widget
 */

namespace Boostify_Elementor\Widgets;

use Boostify_Elementor\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
/**
 * Count Down.
 *
 * Elementor widget for number.
 */
class Count_Down extends Base_Widget {

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
		return 'count-down';
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
		return 'boostify eicon-countdown';
	}
	/**
	 * Script depend.
	 */
	public function get_script_depends() {
		return array( 'boostify-addon-countdown' );
	}

	protected function _register_controls() { //phpcs:ignore
		$this->start_controls_section(
			'section_title',
			array(
				'label' => __( 'Count Down', 'boostify' ),
			)
		);
		$this->add_control(
			'due_date',
			array(
				'label'   => __( 'Due Date', 'boostify' ),
				'type'    => Controls_Manager::DATE_TIME,
				'default' => '2025-12-12 00:00',
			),
		);
		$this->add_control(
			'enable_zero',
			array(
				'label'        => esc_html__( 'Zero Digit', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'boostify' ),
				'label_off'    => esc_html__( 'No', 'boostify' ),
				'return_value' => 'yes',
			)
		);
		$this->add_responsive_control(
			'countdown_position',
			array(
				'label'     => __( 'Direction', 'boostify' ),
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
					'{{WRAPPER}} .boostify-count-down ul' => 'flex-direction: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'cdown_v_align',
			array(
				'label'     => __( 'Verticle Align', 'boostify' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => array(
					'flex-start'    => __( 'Start', 'boostify' ),
					'center'        => __( 'Center', 'boostify' ),
					'flex-end'      => __( 'End', 'boostify' ),
					'space-around'  => __( 'Space Around', 'boostify' ),
					'space-between' => __( 'Space Between', 'boostify' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-count-down ul' => 'justify-content: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'cdown_h_align',
			array(
				'label'     => __( 'Horizontal Align', 'boostify' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => array(
					'flex-start'    => __( 'Start', 'boostify' ),
					'center'        => __( 'Center', 'boostify' ),
					'flex-end'      => __( 'End', 'boostify' ),
					'space-around'  => __( 'Space Around', 'boostify' ),
					'space-between' => __( 'Space Between', 'boostify' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-count-down ul' => 'align-items: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'day_text',
			array(
				'label'       => __( 'Day Text', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Days', 'boostify' ),
				'placeholder' => __( 'Enter button label', 'boostify' ),
			)
		);
		$this->add_control(
			'hour_text',
			array(
				'label'       => __( 'Hour Text', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Hours', 'boostify' ),
				'placeholder' => __( 'Enter button label', 'boostify' ),
			)
		);
		$this->add_control(
			'minute_text',
			array(
				'label'       => __( 'Minute Text', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Minutes', 'boostify' ),
				'placeholder' => __( 'Enter button label', 'boostify' ),
			)
		);
		$this->add_control(
			'second_text',
			array(
				'label'       => __( 'Second Text', 'boostify' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Seconds', 'boostify' ),
				'placeholder' => __( 'Enter button label', 'boostify' ),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'countdown_style',
			array(
				'label' => __( 'Number Block', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'num_cd_typography',
				'selector' => '{{WRAPPER}} .boostify-count-down ul li span',
			)
		);
		$this->add_control(
			'num_cd_color',
			array(
				'label'     => esc_html__( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-count-down ul li span' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'num_cd_bgcolor',
			array(
				'label'     => esc_html__( 'Background Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-count-down ul li' => 'background-color: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'cd_num_padding',
			array(
				'label'      => __( 'Padding', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-count-down ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'cd_margin',
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-count-down ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'numblock_border',
				'label'    => __( 'Border', 'boostify' ),
				'selector' => '{{WRAPPER}} .boostify-count-down ul li',
			)
		);
		$this->add_responsive_control(
			'cd_num_border_radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-count-down ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'num_block_box_shadow',
				'label'    => __( 'Box Shadow', 'boostify' ),
				'selector' => '{{WRAPPER}} .boostify-count-down ul li',
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'text_style',
			array(
				'label' => __( 'Text', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_cd_typography',
				'selector' => '{{WRAPPER}} .boostify-count-down ul li > div',
			)
		);
		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-count-down ul li > div' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'numb_cd_position',
			array(
				'label'     => __( 'Direction', 'boostify' ),
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
					'{{WRAPPER}} .boostify-count-down ul li' => 'flex-direction: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'num_cdown_v_align',
			array(
				'label'     => __( 'Alignment', 'boostify' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => array(
					'flex-start' => array(
						'title' => __( 'Left', 'boostify' ),
						'icon'  => 'fa fa-align-left',
					),
					'center'     => array(
						'title' => __( 'Center', 'boostify' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end'   => array(
						'title' => __( 'Right', 'boostify' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-count-down ul li' => 'align-items: {{VALUE}};',
				),
			),
		);
		$this->add_responsive_control(
			'cd_text_margin',
			array(
				'label'      => __( 'Margin', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-count-down ul li > div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Render Count Down frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.2.0
	 * @access protected
	 */
	protected function render() {
		$settings    = $this->get_settings_for_display();
		$widget_id   = $this->get_id();
		$due_date    = $settings['due_date'];
		$enable_zero = $settings['enable_zero'];
		$day_text    = $settings['day_text'];
		$hour_text   = $settings['hour_text'];
		$minute_text = $settings['minute_text'];
		$second_text = $settings['second_text'];
		?>
		<div 
			class="boostify-count-down" 
			data-digit ="<?php echo esc_attr( $enable_zero ); ?>"
			id="bcd-<?php echo esc_attr( $widget_id ); ?>" 
			data-id="<?php echo esc_attr( $widget_id ); ?>" 
			data-date="<?php echo esc_attr( $due_date ); ?>"
		>
			<?php if ( $due_date ) : ?>
			<ul>
				<li><span id="days-<?php echo esc_attr( $widget_id ); ?>"></span><div><?php echo esc_attr( $day_text ); ?></div></li>
				<li><span id="hours-<?php echo esc_attr( $widget_id ); ?>"></span><div><?php echo esc_attr( $hour_text ); ?></div></li>
				<li><span id="minutes-<?php echo esc_attr( $widget_id ); ?>"></span><div><?php echo esc_attr( $minute_text ); ?></div></li>
				<li><span id="seconds-<?php echo esc_attr( $widget_id ); ?>"></span><div><?php echo esc_attr( $second_text ); ?></div></li>
			</ul>
			<?php endif; ?>
		</div>
		<?php
	}
}
