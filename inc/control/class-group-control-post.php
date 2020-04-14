<?php
namespace Boostify_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor post control.
 *
 * A base control for creating post control. Displays input fields to define
 * post type, post width and post color.
 *
 * @since 1.0.0
 */
class Group_Control_Post extends Group_Control_Base {

	/**
	 * Fields.
	 *
	 * Holds all the post control fields.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @static
	 *
	 * @var array Border control fields.
	 */
	protected static $fields;

	/**
	 * Get post control type.
	 *
	 * Retrieve the control type, in this case `post`.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return string Control type.
	 */
	public static function get_type() {
		return 'boostify-post';
	}

	/**
	 * Init fields.
	 *
	 * Initialize post control fields.
	 *
	 * @since 1.2.2
	 * @access protected
	 *
	 * @return array Control fields.
	 */
	protected function init_fields() {
		$fields = [];

		$fields['post'] = [
			'label' => _x( 'Border Type', 'Border Control', 'elementor' ),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'' => __( 'None', 'elementor' ),
				'solid' => _x( 'Solid', 'Border Control', 'elementor' ),
				'double' => _x( 'Double', 'Border Control', 'elementor' ),
				'dotted' => _x( 'Dotted', 'Border Control', 'elementor' ),
				'dashed' => _x( 'Dashed', 'Border Control', 'elementor' ),
				'groove' => _x( 'Groove', 'Border Control', 'elementor' ),
			],
		];

		$fields['width'] = [
			'label' => _x( 'Width', 'Border Control', 'elementor' ),
			'type' => Controls_Manager::DIMENSIONS,
			'condition' => [
				'post!' => '',
			],
			'responsive' => true,
		];

		$fields['color'] = [
			'label' => _x( 'Color', 'Border Control', 'elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '',
			'condition' => [
				'post!' => '',
			],
		];

		return $fields;
	}

	/**
	 * Get default options.
	 *
	 * Retrieve the default options of the post control. Used to return the
	 * default options while initializing the post control.
	 *
	 * @since 1.9.0
	 * @access protected
	 *
	 * @return array Default post control options.
	 */
	protected function get_default_options() {
		return [
			'popover' => false,
		];
	}
}
