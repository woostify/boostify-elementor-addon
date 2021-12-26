<?php
/**
 * Widget Faqs.
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


/**
 * \FAQs
 *
 * Elementor widget for \FAQs.
 * Author: ptp
 */
class Faqs extends Base_Widget {
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
		return 'faqs';
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
		return esc_html__( 'Faqs', 'boostify' );
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
		return array( 'boostify-addon-faq' );
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
	protected function _register_controls() {
		$this->start_controls_section(
			'section_faqs',
			array(
				'label' => esc_html__( 'Faqs', 'boostify' ),
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'question',
			array(
				'label'      => esc_html__( 'Question', 'boostify' ),
				'type'       => Controls_Manager::TEXTAREA,
				'rows'       => 3,
				'default'    => esc_html__( 'Lorem Ipsum', 'boostify' ),
				'placeholer' => esc_html__( 'Enter Question', 'boostify' ),
			)
		);

		$repeater->add_control(
			'answer',
			array(
				'label'      => esc_html__( 'Answer', 'boostify' ),
				'type'       => Controls_Manager::TEXTAREA,
				'rows'       => 10,
				'default'    => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam ultrices lectus at odio laoreet rutrum. Integer risus quam, euismod vitae lacus in, tempor efficitur orci.', 'boostify' ),
				'placeholer' => esc_html__( 'Enter Answer', 'boostify' ),
			)
		);

		$this->add_control(
			'faq',
			array(
				'label'       => esc_html__( 'FAQS', 'boostify' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'question' => esc_html__( 'Can ', 'boostify' ),
						'answer'   => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'boostify' ),
					),
				),
				'title_field' => '{{{ question }}}'
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'faqs_style',
			array(
				'label' => esc_html__( 'FAQS', 'boostify' ),
				'tab' => Controls_Manager::TAB_STYLE
			)
		);

		$this->add_control(
			'border-width',
			array(
				'label' => esc_html__( 'Border Width', 'boostify' ),
				'type' => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'max' => 10,
						'min' => 0
					)
				),
				'default' => array(
					'size' => 1,
					'unit' => 'px'
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-faq' => 'border-width: {{SIZE}}{{UNIT}}'
				)
			)
		);

		$this->add_control(
			'border-color',
			array(
				'label' => esc_html__( 'Border Color', 'boostify' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d4d4d4',
				'selectors' => array(
					'{{WRAPPER}} .boostify-faq' => 'border-color: {{VALUE}};'
				)
			)
		);

		$this->add_control(
			'icon-color',
			array(
				'label' => esc_html__( 'Icon Color', 'boostify' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d6252d',
				'selectors' => array(
					'{{WRAPPER}} .boostify-question:after' => 'color: {{VALUE}};'
				)
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'question_style',
			array(
				'label' => esc_html__( 'Question', 'boostify' ),
				'tab' => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'question_color',
			array(
				'label' => esc_html__( 'Color', 'boostify' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .boostify-question' => 'color: {{VALUE}}'
				)
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label' => esc_html__( 'Typography', 'boostify' ),
				'name' => 'question_boostify',
				'selector' => '{{WRAPPER}} .boostify-answer span',
			)
		);

		$this->add_control(
			'question_padding',
			array(
				'label' => esc_html__( 'Padding', 'boostify' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default' => array(
					'unit' => 'px',
					'top' => 15,
					'bottom' => 15,
					'left' => 0,
					'right' => 35
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-question' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name' => 'question_background',
				'selector' => '{{WRAPPER}} .boostify-question'
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'answer_style',
			array(
				'label' => esc_html__( 'Answer', 'boostify' ),
				'tab' => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'answer_color',
			array(
				'label' => esc_html__( 'Color', 'boostify' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .boostify-answer' => 'color: {{VALUE}}'
				)
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'label' => esc_html__( 'Typography', 'boostify' ),
				'name' => 'answer_boostify',
				'selector' => '{{WRAPPER}} .boostify-answer span',
			)
		);

		$this->add_control(
			'answer_padding',
			array(
				'label' => esc_html__( 'Padding', 'boostify' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default' => array(
					'unit' => 'px',
					'top' => 15,
					'bottom' => 15,
					'left' => 0,
					'right' => 35
				),
				'selectors' => array(
					'{{WRAPPER}} .boostify-answer .answer-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name' => 'answer_background',
				'selector' => '{{WRAPPER}} .boostify-answer'
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
		?>

		<div class="boostify-addon-widget boostify-faqs">
			<div class="faqs-wrapper">
				<?php
					foreach ( $settings['faq'] as $key => $faq ) {
				?>
					<div class="boostify-faq">
						<div class="boostify-question">
							<span class="question-item"><?php echo esc_html__( $faq['question'], 'boostify' ); ?></span>
						</div>

						<div class="boostify-answer">
							<span class="answer-content"><?php echo wp_kses_post( $faq['answer'], 'boostify' ); ?></span>
						</div>
					</div>
				<?php
					}
				 ?>
			</div>
		</div>

		<?php
	}

}
