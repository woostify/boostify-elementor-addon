<?php

namespace Boostify_Elementor\Posts\Skin;

/**
 * Layout Post
 *
 * Elementor widget for Copyright.
 * Author: ptp
 */
class Layout {

	public static $grid_layouts = array();

	public static $list_layouts = array();

	public static $slider_layout = array();

	public function add_layout_grid( $layout = array() ) {
		$default            = self::$grid_layouts;
		$grid_layouts       = array_merge( $default, $layout );
		self::$grid_layouts = $grid_layouts;
	}

	public function add_layout_list( $layout = array() ) {
		$default            = self::$list_layouts;
		$list_layouts       = array_merge( $default, $layout );
		self::$list_layouts = $list_layouts;
	}

	public function add_layout_slider( $layout = array() ) {
		$default              = self::$slider_layouts;
		$slider_layouts       = array_merge( $default, $layout );
		self::$slider_layouts = $slider_layouts;
	}


	public static function post_grid() {
		$layout = array(
			'default' => __( 'Default', 'boostify' ),
			'masonry' => __( 'Masonry', 'boostify' ),
		);

		return apply_filters( 'boostify_post_grid_layout', $layout );
	}

	public static function post_list() {
		$layout = array(
			'default'     => __( 'Default', 'boostify' ),
			'zigzag'      => __( 'Zigzag', 'boostify' ),
			'image_right' => __( 'Image Right', 'boostify' ),
		);

		return apply_filters( 'boostify_post_list_layout', $layout );
	}

	public static function post_slider() {
		$layout = array(
			'default' => __( 'Default', 'boostify' ),
		);

		return apply_filters( 'boostify_post_slider_layout', $layout );
	}

}

