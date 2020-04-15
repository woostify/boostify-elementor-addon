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
	 * @var array Post control fields.
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
		$fields = array();

		$fields['post_type'] = array(
			'label'   => _x( 'Post Type', 'Post Control', 'boostify' ),
			'type'    => Controls_Manager::SELECT,
			'options' => boostify_theme_post_type(),
			'default' => 'post',
		);

		$fields['term'] = array(
			'label'      => _x( 'Term', 'Post Control', 'boostify' ),
			'type'       => Controls_Manager::SELECT2,
			'condition'  => array(
				'post!' => '',
			),
			'responsive' => true,
		);

		$fields['color'] = array(
			'label'     => _x( 'Color', 'Post Control', 'boostify' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'condition' => array(
				'post!' => '',
			),
		);

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
		return array(
			'popover' => false,
		);
	}
}
