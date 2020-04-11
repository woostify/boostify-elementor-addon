<?php

namespace Boostify_Elementor\Widgets;

use Boostify_Elementor\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

/**
 * Copyright
 *
 * Elementor widget for Copyright.
 * Author: ptp
 */
class Post_Grid extends Base_Widget {

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
		return 'post-grid';
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
		return 'eicon-posts-grid';
	}

	public function _register_controls() { //phpcs:ignore
		$this->start_controls_section(
			'section_post_grid',
			array(
				'label' => __( 'Post Grid', 'boostify' ),
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


		$this->end_controls_section();

		$this->start_controls_section(
			'query',
			array(
				'label' => __( 'Query', 'boostify' ),
			)
		);


		$this->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'Order By', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'ID'     => esc_html__( 'ID', 'boostify' ),
					'date'   => esc_html__( 'Date', 'boostify' ),
					'title'  => esc_html__( 'Title', 'boostify' ),
					'author' => esc_html__( 'Author', 'boostify' ),
					'rand'   => esc_html__( 'Random', 'boostify' ),
				),
				'default' => 'date',
			)
		);

		$this->add_control(
			'order',
			array(
				'label'   => esc_html__( 'Order', 'boostify' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'ASC'  => array(
						'title' => esc_html__( 'ASC', 'boostify' ),
						'icon'  => 'fa fa-sort-numeric-asc',
					),
					'DESC' => array(
						'title' => esc_html__( 'DESC', 'boostify' ),
						'icon'  => 'fa fa-sort-numeric-desc',
					),
				),
				'default' => 'DESC',
			)
		);

		$this->add_control(
			'posts_per_page',
			array(
				'label'   => esc_html__( 'Posts Per Page', 'boostify' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
			)
		);

		$this->add_control(
			'pagination',
			array(
				'label'   => esc_html__( 'Posts Per Page', 'boostify' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
			)
		);

		$this->end_controls_section();
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
		$settings = $this->get_settings_for_display();
		$path     = BOOSTIFY_ELEMENTOR_PATH . 'templates/content/content-post-grid.php';
		$columns  = $settings['columns'];
		$args     = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		);
		$posts    = new \WP_Query( $args );
		var_dump( boostify_theme_default() );

		if ( $posts->have_posts() ) {
			?>
			<div class="boostify-addon-widget boostify-post-grid-widget">
				<div class="boostify-widget-post-grid-wrapper boostify-grid boostify-grid-<?php echo esc_attr( $columns ); ?>">
					<?php
					while ( $posts->have_posts() ) {
						$posts->the_post();
						boostify_template_post_grid();
					}
					?>

				</div>
			</div>
			<?php

			wp_reset_postdata();
		}
	}


	public function taxonomies() {
		$taxonomies = get_taxonomies();
	}

}
