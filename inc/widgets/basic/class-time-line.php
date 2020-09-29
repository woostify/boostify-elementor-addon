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
			'tl_direct',
			array(
				'label'   => esc_html__( 'Direction', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'vertical',
				'options' => array(
					'vertical'   => esc_html__( 'Vertical', 'boostify' ),
					'horizontal' => esc_html__( 'Horizontal', 'boostify' ),
				),
			),
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
		$repeater = new \Elementor\Repeater();
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
			'time_line_style',
			array(
				'label' => __( 'Item', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
		$settings  = $this->get_settings_for_display();
		$direction = $settings['tl_direct'];
		$tl_type   = $settings['tl_type'];
		$items     = $settings['tl_items'];
		?>
			<div class="btf-time-line">
				<?php
				foreach ( $items as $item ) {
					$item_img_url = Group_Control_Image_Size::get_attachment_image_src( $item['tl_image']['id'], 'item_thumb_size', $settings );
					$item_date    = date_i18n( apply_filters( 'wpb_ea_timeline_date_format', get_option( 'date_format' ) ) , strtotime( $item['tl_due_date'] ) );
					?>
					<div class="btf-time-line__item">
						<div class="btf-time-line__item__image"><img src="<?php echo esc_url( $item_img_url ); ?>" alt="item-img"></div>
						<div class="btf-time-line__item__date"><?php echo esc_html( $item_date ); ?></div>
						<div class="btf-time-line__item__title"><?php echo esc_html( $item['tl_title'] ); ?></div>
						<div class="btf-time-line__item__content"><?php echo esc_html( $item['tl_content'] ); ?></div>
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
