<?php

namespace Boostify_Elementor\Posts;

/**
 * Layout Post
 *
 * Elementor widget for Copyright.
 * Author: ptp
 */
class Layout {

	public static $grid_layouts = array();

	public static $list_layouts = array();

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

}
