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

	public function add_layout_grid( $layout = array() ) {
		$default            = self::$grid_layouts;
		$grid_layouts       = array_merge( $default, $layout );
		self::$grid_layouts = $grid_layouts;
	}

}
