<?php

namespace Boostify_Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Data_Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Featured_Image extends Data_Tag {

	public function get_name() {
		return 'boostify-featured-image';
	}

	public function get_group() {
		return 'boostify_addon';
	}

	public function get_categories() {
		return array( \Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY );
	}

	public function get_title() {
		return __( 'Featured Image', 'boostify' );
	}

	public function get_value( array $options = array() ) {
		$id           = get_the_ID();
		$thumbnail_id = get_post_thumbnail_id( $id );
		if ( $thumbnail_id ) {
			$image_data = array(
				'id'  => $thumbnail_id,
				'url' => wp_get_attachment_image_src( $thumbnail_id, 'full' )[0],
			);
		} else {
			$image_data = $this->get_settings( 'fallback' );
		}

		return $image_data;
	}
}
