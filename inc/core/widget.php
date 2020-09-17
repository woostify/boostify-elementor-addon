<?php

function boostify_list_widget() {
	$list_widget = array(
		'basic' => array(
			'label'  => __( 'General', 'boostify' ),
			'value'  => 'base',
			'widget' => array(
				array(
					'key'   => 'Button',
					'name'  => 'button',
					'label' => __( 'Button', 'boostify' ),
				),
				array(
					'key'   => 'Video_Popup',
					'name'  => 'video_popup',
					'label' => __( 'Video Popup', 'boostify' ),
				),
			),
		),
		'post' => array(
			'label'  => __( 'Post', 'boostify' ),
			'value'  => 'post',
			'widget' => array(
				array(
					'key'   => 'Post_Grid',
					'name'  => 'post_grid',
					'label' => __( 'Post Grid', 'boostify' ),
				),
				array(
					'key'   => 'Post_List',
					'name'  => 'post_list',
					'label' => __( 'Post List', 'boostify' ),
				),
				array(
					'key'   => 'Post_Slider',
					'name'  => 'post_slider',
					'label' => __( 'Post Slider', 'boostify' ),
				),
				array(
					'key'   => 'Breadcrumb',
					'name'  => 'breadcrumb',
					'label' => __( 'Breadcrumb', 'boostify' ),
				),
			)
		),
	);

	return $list_widget;
}