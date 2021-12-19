<?php
namespace Boostify_Elementor\Posts\Base;

use Boostify_Elementor\Base_Widget;
use Boostify_Elementor\Group_Control_Post;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class Posts extends Base_Widget {

	protected function paginations_control() {
		$this->start_controls_section(
			'pagination_section',
			array(
				'label' => __( 'Pagination', 'boostify' ),
			)
		);

		$this->add_control(
			'pagination',
			array(
				'label'        => esc_html__( 'Pagination', 'boostify' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'boostify' ),
				'label_off'    => __( 'Hide', 'boostify' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_responsive_control(
			'align_pagination',
			array(
				'label'     => __( 'Alignment', 'boostify' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => __( 'Left', 'boostify' ),
						'icon'  => 'fa fa-align-left',
					),
					'center'     => array(
						'title' => __( 'Center', 'boostify' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end'   => array(
						'title' => __( 'Right', 'boostify' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'default'   => 'flex-start',
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function query_control() {

		$this->start_controls_section(
			'query',
			array(
				'label' => __( 'Query', 'boostify' ),
			)
		);

		$this->add_group_control(
			Group_Control_Post::get_type(),
			array(
				'name' => 'post_group',
			)
		);

		$this->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'Order By', 'boostify' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'ID'     => esc_html__( 'ID', 'boostify' ),
					'date'   => esc_html__( 'Date', 'boostify' ),
					'title'  => esc_html__( 'Title', 'boostify' ),
					'author' => esc_html__( 'Author', 'boostify' ),
					'rand'   => esc_html__( 'Random', 'boostify' ),
				),
				'default' => 'date',
			)
		);

		$this->add_control(
			'order',
			array(
				'label'   => esc_html__( 'Order', 'boostify' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'ASC'  => array(
						'title' => esc_html__( 'ASC', 'boostify' ),
						'icon'  => 'fa fa-sort-numeric-asc',
					),
					'DESC' => array(
						'title' => esc_html__( 'DESC', 'boostify' ),
						'icon'  => 'fa fa-sort-numeric-desc',
					),
				),
				'default' => 'DESC',
			)
		);

		$this->add_control(
			'posts_per_page',
			array(
				'label'   => esc_html__( 'Posts Per Page', 'boostify' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
			)
		);

		$this->end_controls_section();
	}

	protected function pagination_style_control() {

		$this->start_controls_section(
			'pagination_style',
			array(
				'label' => __( 'Pagination', 'boostify' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'space_page',
			array(
				'label'      => __( 'Space Top', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 30,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'    => __( 'Typography', 'boostify' ),
				'name'     => 'typo_pagination',
				'selector' => '{{WRAPPER}} .boostify-pagination .page-numbers, {{WRAPPER}} .boostify-pagination .page-numbers.next:after, {{WRAPPER}} .boostify-pagination .page-numbers.prev:after',
			)
		);
		$this->add_responsive_control(
			'page_width',
			array(
				'label'      => __( 'Width', 'boostify' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 30,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'border_pagi_width',
			array(
				'label'      => __( 'Border Width', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid',
				),
			)
		);

		$this->add_control(
			'border_pagi_radius',
			array(
				'label'      => __( 'Border Radius', 'boostify' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'pagination_tab' );

		$this->start_controls_tab(
			'pagi_nornal',
			array(
				'label' => __( 'Normal', 'boostify' ),
			)
		);

		$this->add_control(
			'pagi_color',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers' => 'color: {{VALUE}};',
					'{{WRAPPER}} .boostify-pagination .page-numbers.prev:after' => 'color: {{VALUE}}',
					'{{WRAPPER}} .boostify-pagination .page-numbers.next:after' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagi_color_bd',
			array(
				'label'     => __( 'Color Border', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'pagi_color_bg',
			array(
				'label'     => __( 'Background', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagi_active',
			array(
				'label' => __( 'Active', 'boostify' ),
			)
		);

		$this->add_control(
			'pagi_color_active',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666',
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers.current' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'pagi_color_bd_acti',
			array(
				'label'     => __( 'Color Border', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers.current' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'pagi_color_bg_active',
			array(
				'label'     => __( 'Background', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers.current' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagi_hover',
			array(
				'label' => __( 'Hover', 'boostify' ),
			)
		);

		$this->add_control(
			'pagi_color_hover',
			array(
				'label'     => __( 'Color', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666',
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .boostify-pagination .page-numbers:hover.prev:after' => 'color: {{VALUE}}',
					'{{WRAPPER}} .boostify-pagination .page-numbers:hover.next:after' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagi_color_bd_hover',
			array(
				'label'     => __( 'Color Border', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'pagi_color_bg_acti',
			array(
				'label'     => __( 'Background', 'boostify' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .boostify-pagination .page-numbers:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function query_args( $settings ) {
		$post_type      = $settings['post_group_post_type'];
		$include        = $settings['post_group_include'];
		$include_author = $settings['post_group_include_authors'];
		$in_term_key    = 'post_group_include_term_' . $post_type;
		$include_term   = $settings[ $in_term_key ];
		$exclude        = $settings['post_group_exclude'];
		$exclude_author = $settings['post_group_exclude_authors'];
		$ex_term_key    = 'post_group_exclude_term_' . $post_type;
		$exclude_term   = $settings[ $ex_term_key ];
		$ex_post_key    = 'post_group_exclude_posts_' . $post_type;
		$exclude_posts  = $settings[ $ex_post_key ];
		$in_terms       = array();
		$ex_terms       = array();
		if ( ! empty( $include_term ) ) {
			foreach ( $include_term as $term ) {
				$list                   = explode( '___', $term );
				$in_terms[ $list[0] ][] = $list[1];
			}
		}
		if ( ! empty( $exclude_term ) ) {
			foreach ( $exclude_term as $term ) {
				$list                   = explode( '___', $term );
				$ex_terms[ $list[0] ][] = $list[1];
			}
		}

		$args = array(
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => $settings['posts_per_page'],
			'order'          => $settings['order'],
			'orderby'        => $settings['orderby'],
			'paged'          => get_query_var( 'paged' ),
		);

		if ( ! empty( $include ) ) {
			if ( $include_author ) {
				$args['author__in'] = $include_author;
			}
			if ( $include_term ) {
				foreach ( $in_terms as $tax => $term ) {
					$args['tax_query'] = array(
						'relation' => 'AND',
						array(
							'taxonomy'         => $tax,
							'field'            => 'slug',
							'terms'            => $term,
							'include_children' => true,
							'operator'         => 'IN',
						),
					);
				}
			}
		}

		if ( ! empty( $exclude ) ) {
			if ( ! empty( $exclude_author ) ) {
				$args['author__not_in'] = $include_author;
			}
			if ( ! empty( $exclude_term ) ) {
				foreach ( $ex_terms as $tax => $term ) {
					$args['tax_query'] = array(
						'relation' => 'AND',
						array(
							'taxonomy'         => $tax,
							'field'            => 'slug',
							'terms'            => $term,
							'include_children' => true,
							'operator'         => 'NOT IN',
						),
					);
				}
			}
			if ( ! empty( $exclude_posts ) ) {
				$args['post__not_in'] = $exclude_posts;
			}
		}

		$posts = new \WP_Query( $args );

		return $posts;
	}

}
