<?php
/**
 * Elementor Group Woocommerce Controls.
 *
 * @since 1.0.0
 * @package Boostify Addon
 */

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
class Group_Control_Product extends Group_Control_Base {

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
		return 'boostify-product';
	}

	/**
	 * Fiels.
	 *
	 * Retrieve args, in this case `post`.
	 *
	 * @param array $args | fiels array.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 */
	protected function init_args( $args ) {
		parent::init_args( $args );
		$args           = $this->get_args();
		static::$fields = $this->init_fields_by_name( $args['name'] );
	}

	/**
	 * Init fields.
	 *
	 * Initialize post control fields.
	 *
	 * @since 1.2.2
	 * @access protected
	 */
	protected function init_fields() {
		$args = $this->get_args();
		$this->init_fields_by_name( $args['name'] );
	}

	/**
	 * Fiels.
	 *
	 * Retrieve args, in this case `post`.
	 *
	 * @param array $name | fiels array.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 */
	public function init_fields_by_name( $name ) {
		$fields          = array();
		$name           .= '_';
		$tabs_wrapper    = $name . 'query_args';
		$include_wrapper = $name . 'query_include';
		$exclude_wrapper = $name . 'query_exclude';

		$fields['query_args'] = array(
			'type' => Controls_Manager::TABS,
		);

		$fields['query_include'] = array(
			'type'         => Controls_Manager::TAB,
			'label'        => __( 'Include', 'boostify' ),
			'tabs_wrapper' => $tabs_wrapper,
		);

		$fields['include'] = array(
			'label'        => __( 'Include By', 'boostify' ),
			'type'         => Controls_Manager::SELECT2,
			'multiple'     => true,
			'label_block'  => true,
			'inner_tab'    => $include_wrapper,
			'tabs_wrapper' => $tabs_wrapper,
			'options'      => array(
				'terms'   => __( 'Term', 'boostify' ),
				'authors' => __( 'Author', 'boostify' ),
			),
			'condition'    => array(
				'post_type!' => array(
					'by_id',
					'current_query',
				),
			),
		);

		$fields['include_authors'] = array(
			'label'        => __( 'Authors', 'boostify' ),
			'type'         => Controls_Manager::SELECT2,
			'multiple'     => true,
			'label_block'  => true,
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $include_wrapper,
			'options'      => boostify_user(),
			'condition'    => array(
				'include'    => 'authors',
				'post_type!' => array(
					'by_id',
					'current_query',
				),
			),
		);

		$fields['include_term_product'] = array(
			'label'        => __( 'Term', 'boostify' ),
			'type'         => Controls_Manager::SELECT2,
			'options'      => boostify_taxonomies_by_post_type( 'product' ),
			'label_block'  => true,
			'multiple'     => true,
			'group_prefix' => $name,
			'include_type' => true,
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $include_wrapper,
			'condition'    => array(
				'include' => 'terms',
			),
		);

		$fields['query_exclude'] = array(
			'type'         => Controls_Manager::TAB,
			'label'        => __( 'Exclude', 'boostify' ),
			'tabs_wrapper' => $tabs_wrapper,
		);

		$fields['exclude'] = array(
			'label'        => __( 'Exclude By', 'boostify' ),
			'type'         => Controls_Manager::SELECT2,
			'multiple'     => true,
			'label_block'  => true,
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $exclude_wrapper,
			'options'      => array(
				'current_post' => __( 'Current Post', 'boostify' ),
				'terms'        => __( 'Term', 'boostify' ),
				'authors'      => __( 'Author', 'boostify' ),
			),
			'condition'    => array(
				'post_type!' => array(
					'by_id',
					'current_query',
				),
			),
		);

		$fields['exclude_term_product'] = array(
			'label'        => __( 'Term', 'boostify' ),
			'type'         => Controls_Manager::SELECT2,
			'options'      => boostify_taxonomies_by_post_type( 'product' ),
			'label_block'  => true,
			'multiple'     => true,
			'include_type' => true,
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $exclude_wrapper,
			'condition'    => array(
				'exclude' => 'terms',
			),
		);

		$fields['exclude_authors'] = array(
			'label'        => __( 'Author', 'boostify' ),
			'type'         => Controls_Manager::SELECT2,
			'multiple'     => true,
			'label_block'  => true,
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $exclude_wrapper,
			'options'      => boostify_user(),
			'condition'    => array(
				'exclude' => 'authors',
			),
		);

		$fields['exclude_posts_product'] = array(
			'label'        => __( 'Product', 'boostify' ),
			'type'         => Controls_Manager::SELECT2,
			'options'      => boostify_post( 'product' ),
			'label_block'  => true,
			'multiple'     => true,
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $exclude_wrapper,
			'export'       => false,
			'condition'    => array(
				'exclude' => 'current_post',
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
