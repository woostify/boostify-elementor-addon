# boostify-elementor-addon


# Post Grid Widget

## How to add custom layout post grid
1. Create function in file function.php.
	Ex.
	function boostify_post_grid_add_layout() {
		$layout = new \Boostify_Elementor\Posts\Layout();
		$args   = array(
			'layout_1' => 'Layout 1',// $setting_layout = 'layout_1';
		);
		$layout->add_layout_grid( $args );
	}
2. Add action elementor/init
	Ex. add_action( 'elementor/init', 'boostify_post_grid_add_layout' );
3. Create function get layout custom.
	Ex. function boostify_get_content() {
			<article id="post-ID">
				<!-- current post content -->
			</article><!-- #post-<?php the_ID(); ?> -->
		}
4. Add action add_action( 'boostify_post_grid_{$setting_layout}', 'boostify_get_content' );

