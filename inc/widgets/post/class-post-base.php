<?php
namespace Boostify_Elementor;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class Post_Base extends Base_Widget {

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'boostify_addon' );
	}


	protected function get_taxonomies( $cpt ) {
		$terms = get_object_taxonomies( $cpt );
	}


	public function paginations_control() {
		
	}

}
