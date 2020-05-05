<?php

namespace Boostify_Elementor\Widgets;

use Boostify_Elementor\Base_Widget;
use Boostify_Elementor\Core\Global_Breadcrumb as BoostifyBreadcrumb;
use Elementor\Controls_Manager;
/**
 * Breadcrumb
 *
 * Elementor widget for Breadcrumb.
 * Author: ptp
 */
class Breadcrumb extends Base_Widget {

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
		return 'breadcrumb';
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
			'section_breadcrumb',
			array(
				'label' => __( 'Breadcrumb', 'boostify' ),
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
		bcn_display();
		$crumb = new BoostifyBreadcrumb();
		// if ( ! empty( $args['home'] ) ) {
		// 	$crumb->add_crumb( $args['home'], apply_filters( 'boostify_breadcrumb_home_url', home_url() ) );
		// }
		$crumb->add_crumb( 'home', home_url() );

		$list_crumb = $crumb->generate();
		var_dump( $list_crumb );
		?>
		<div class="boostify-addon-breadcrumb widget-breadcrumb">
			<div class="widget-breadcrumb--wrapper">
				<ul class="list-breadcrumb-item">
					<li class="boostify-item-breadcrumb">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php echo esc_html__( 'Home', 'boostify' ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<?php
	}


	protected function get_item_is_single() {
		if ( is_single() ) {
			$title = single_post_title();
		} elseif ( is_search() ) {
			sprintf( esc_html__( 'Search Results for: %s', 'boostify' ), '<span>' . get_search_query() . '</span>' );
		} elseif ( is_archive() ) {
			if ( class_exists( 'WooCommerce' ) ) {
				if ( is_shop() ) {
					echo '<h1 class="page-title">' . esc_html__( 'Shop', 'boostify' ) . '</h1>';
				} else {
					the_archive_title( '<h1 class="page-title">', '</h1>' );
				}
			} else {
				the_archive_title( '<h1 class="page-title">', '</h1>' );
			}
		} else {
			echo '<h1 class="page-title">'.get_the_title().'</h1>';
		}
	}

	protected function item_single() {
		if ( is_single() ) {
			$title = single_post_title();
		} elseif ( is_search() ) {
			sprintf( esc_html__( 'Search Results for: %s', 'boostify' ), '<span>' . get_search_query() . '</span>' );
		} elseif ( is_archive() ) {
			if ( class_exists( 'WooCommerce' ) ) {
				if ( is_shop() ) {
					echo '<h1 class="page-title">' . esc_html__( 'Shop', 'boostify' ) . '</h1>';
				} else {
					the_archive_title( '<h1 class="page-title">', '</h1>' );
				}
			} else {
				the_archive_title( '<h1 class="page-title">', '</h1>' );
			}
		} else {
			echo '<h1 class="page-title">'.get_the_title().'</h1>';
		}
	}

	protected function item_search() {
		?>
		<li class="boostify-item-breadcrumb">
			<span class="name">
				<?php sprintf( esc_html__( 'Search Results for: %s', 'boostify' ), '<span>' . get_search_query() . '</span>' ); ?>
			</span>
		</li>
		<?php
	}


	protected function item_archive() {
		?>
		<li class="boostify-item-breadcrumb">
			<span class="name">
			<?php
			if ( class_exists( 'WooCommerce' ) ) {
				if ( is_shop() ) {
					echo esc_html__( 'Shop', 'boostify' );
				} else {
					the_archive_title();
				}
			} else {
				the_archive_title();
			}
			?>
			</span>
		</li>
		<?php
	}

	protected function other() {
		?>
		<li class="boostify-item-breadcrumb">
			<span class="name">
				<?php echo esc_html( get_the_title() ); ?>
			</span>
		</li>
		<?php
	}

}
