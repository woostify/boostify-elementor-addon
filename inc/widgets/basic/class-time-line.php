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
