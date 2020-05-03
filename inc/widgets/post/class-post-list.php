<?php

namespace Boostify_Elementor\Widgets;

use Boostify_Elementor\Posts\Skin\Layout as Layout;
use Boostify_Elementor\Group_Control_Post;
use Boostify_Elementor\Posts\Base\Post_Base;
use Elementor\Controls_Manager;
/**
 * Post Grid
 *
 * Elementor widget for Post Grid.
 * Author: ptp
 */
class Post_List extends Post_Base {

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
		return 'post-list';
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
		return 'boostify eicon-post-list';
	}

	public function _register_controls() { //phpcs:ignore
		$this->start_controls_section(
			'section_post_list',
			array(
				'label' => __( 'Post List', 'boostify' ),
			)
		);
		$this->layout_control();
		$this->meta_control();
		$this->end_controls_section();

		$this->query_control();

		$this->paginations_control();

		$this->layout_style_control();

		$this->box_style_control();

		$this->thumbnail_style_controll();

		$this->title_style_control();

		$this->meta_style_control();

		$this->excpert_style_control();

		$this->read_more_style_control();

		$this->pagination_style_control();
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
		$posts      = $this->query_args( $settings );
		$total_page = $posts->max_num_pages;
		$action     = 'boostify_post_list_' . $settings['layout'];
		$classes    = array(
			'boostify-widget-post-list-wrapper',
			'boostify-list',
			'boostify-layout-' . $settings['layout'],
		);
		$class      = implode( ' ', $classes );

		if ( $posts->have_posts() ) {
			?>
			<div class="boostify-addon-widget boostify-post-list-widget">
				<div class="<?php echo esc_attr( $class ); ?>">
					<?php
					while ( $posts->have_posts() ) {
						$posts->the_post();
						do_action( $action, $settings );
					}
					?>
				</div>
				<?php
				if ( 'yes' === $settings['pagination'] && $total_page > 1 ) {
					boostify_pagination( $total_page );
				}

				?>
			</div>
			<?php

			wp_reset_postdata();
		}
	}

	public function layouts() {
		$layouts = Layout::post_list();

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
	}

}
