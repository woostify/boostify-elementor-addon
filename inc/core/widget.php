<?php

function boostify_list_widget() {
	$list_widget = array(
		'basic'       => array(
			'label'  => __( 'General', 'boostify' ),
			'value'  => 'base',
			'widget' => array(
				array(
					'key'   => 'Button',
					'name'  => 'button',
					'label' => __( 'Button', 'boostify' ),
				),
				array(
					'key'   => 'Faqs',
					'name'  => 'faqs',
					'label' => __( 'FAQs', 'boostify' ),
				),
				array(
					'key'   => 'Testimonial',
					'name'  => 'testimonial',
					'label' => __( 'Testimonial', 'boostify' ),
				),
				array(
					'key'   => 'Video_Popup',
					'name'  => 'video_popup',
					'label' => __( 'Video Popup', 'boostify' ),
				),
				array(
					'key'   => 'Price_Box',
					'name'  => 'price_box',
					'label' => __( 'Price Box', 'boostify' ),
				),
				array(
					'key'   => 'Team_Member',
					'name'  => 'team_member',
					'label' => __( 'Team Member', 'boostify' ),
				),
				array(
					'key'   => 'Table_Of_Content',
					'name'  => 'table_of_content',
					'label' => __( 'Table of Content', 'boostify' ),
				),
				array(
					'key'   => 'Contact_Form7',
					'name'  => 'contact_form7',
					'label' => __( 'Contact Form 7', 'boostify' ),
				),
				array(
					'key'   => 'WP_Login_Register',
					'name'  => 'wp_login_register',
					'label' => __( 'Login Register', 'boostify' ),
				),
			),
		),
		'post'        => array(
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
			),
		),
		'woocommerce' => array(
			'label'  => __( 'Woocommerce', 'boostify' ),
			'value'  => 'woocommerce',
			'widget' => array(
				array(
					'key'   => 'Product_Grid',
					'name'  => 'product_grid',
					'label' => __( 'Product Grid', 'boostify' ),
				),
			),
		),
	);

	return apply_filters( 'boostify_addon_widgets', $list_widget );
}

function boostify_get_widget() {
	$list_widget = boostify_list_widget();
	$widgets     = array();
	if ( ! empty( $list_widget ) ) {
		foreach ( $list_widget as $folder => $wids ) {
			foreach ( $wids['widget'] as $widget ) {
				$widgets[ $folder ][] = $widget['key'];
			}
		}
	}
	return $widgets;
}
