<?php
/**
 * Widget Product Grid.
 *
 * @since 1.0.0
 * @package Boostify Addon
 */

namespace Boostify_Elementor\Widgets;

use Boostify_Elementor\Base_Widget;
use Boostify_Elementor\Woocommerce\Base\Woocommerce as WoocommerceBase;
use Elementor\Controls_Manager;

/**
 * Product Grids
 *
 * Elementor widget for Product Grids.
 * Author: ptp
 */
class Product_Grid extends WoocommerceBase {

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
		return 'product-grid';
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
		return 'boostify eicon-product-breadcrumbs';
	}

	public function _register_controls() { //phpcs:ignore
		$this->start_controls_section(
			'section_post_grid',
			array(
				'label' => __( 'Post Grid', 'boostify' ),
			)
		);

		$this->layout_control();

		do_action( 'boostify_addon_product_grid_layout_control_after' );

		$this->end_controls_section();

		$this->query_control();

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
		$action     = 'boostify_product_grid_' . $settings['layout'];
		$classes    = array(
			'boostify-widget-post-grid-wrapper',
			'boostify-' . $settings['layout'],
			'boostify-grid-' . $columns,
			'boostify-grid-tablet-' . $settings['columns_tablet'],
			'boostify-grid-mobile-' . $settings['columns_mobile'],
			'boostify-layout-' . $settings['layout'],
		);
		$class      = implode( ' ', $classes );
		echo $action;

		if ( $posts->have_posts() ) {
			?>
			<div class="boostify-addon-widget boostify-product-grid-widget">
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

	/**
	 * Layout Controls.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.2.0
	 * @access protected
	 */
	protected function layout_control() {
		$layouts = array(
			'grid'    => __( 'Grid', 'boostify' ),
			'list'    => __( 'List', 'boostify' ),
			'masonry' => __( 'Masonry', 'boostify' ),
		);

		$style = array(
			'default' => __( 'Default', 'boostify' ),
			'simple'  => __( 'Simple', 'boostify' ),
			'overlay' => __( 'Overlay', 'boostify' ),
			'base'    => __( 'Base', 'boostify' ),
		);
		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => apply_filters( 'boostify_addon_product_grid_layout', $layouts ),
				'default' => 'grid',
			)
		);

		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'Style', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => apply_filters( 'boostify_addon_product_grid_styles', $style ),
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
					'6' => esc_html__( '6', 'boostify' ),
				),
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
			)
		);
	}

}
