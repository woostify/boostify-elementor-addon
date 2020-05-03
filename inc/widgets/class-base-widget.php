<?php
namespace Boostify_Elementor;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class Base_Widget extends Widget_Base {

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

	/**
	 * Get Settings For Main Menu
	 */
	abstract public function name();

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'boostify-' . $this->name();
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		$name = $this->name();
		$name = str_replace( '-', ' ', $name );
		$name = ucwords( $name );

		return esc_html__( $name, 'boostify' );//phpcs:ignore
	}
}
