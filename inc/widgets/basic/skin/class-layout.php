<?php

namespace Boostify_Elementor\Basic\Skin;

/**
 * Layout Base Widget
 *
 * Elementor widget for Copyright.
 * Author: ptp
 */
class Layout {

	public function testimonial() {
		$layout = array(
			'default' => __( 'Default', 'boostify' ),
			'masonry' => __( 'Masonry', 'boostify' ),
		);

		return apply_filters( 'boostify_testimonial_layout', $layout );
	}

}

