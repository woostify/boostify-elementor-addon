<?php
/**
 * Core function
 *
 * Main Plugin
 * @since 1.0.0
 */

function boostify_post_class( $class = '' ) {
	$classes = array(
		'boostify-post',
		'boostify-post-item',
		'post-' . get_the_ID(),
		'post-type-' . get_post_type(),
		'format-' . get_post_format(),
		$class,
	);

	echo 'class="' . join( ' ', $classes ) . '"';// phpcs:ignore
}

function boostify_post_thumbnail() {
	if ( has_post_thumbnail() ) {
		?>
		<div class="boostify-post-thumbnail">
			<a href="<?php echo esc_url( get_the_permalink() ); ?>">
				<?php the_post_thumbnail(); ?>
			</a>
		</div>
		<?php
	}
}

function boostify_post_image() {
	?>
	<div class="boostify-post-thumbnail">
		<?php
		if ( has_post_thumbnail() ) {
			?>
				<a href="<?php echo esc_url( get_the_permalink() ); ?>">
					<?php the_post_thumbnail(); ?>
				</a>
			<?php
		} else {
			?>
				<a href="<?php echo esc_url( get_the_permalink() ); ?>">
					<img src="<?php echo esc_url( BOOSTIFY_ELEMENTOR_URL . 'assets/images/placeholder.png' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
				</a>
			<?php
		}
		?>
	</div>
	<?php
}

function boostify_post_meta() {
	$date   = get_the_date();
	$author = get_the_author_meta( 'ID' );
	?>
	<div class="boostify-post-meta">
		<?php boostify_post_author(); ?>
		<?php boostify_post_date(); ?>
		<?php boostify_post_category(); ?>
	</div>
	<?php
}


function boostify_post_category() {
	$category_list = get_the_category();
	?>
	<span class="boostify-term-list boostify-meta-item">
	<?php
	foreach ( $category_list as $category ) {
		?>
		<span class="boostify-term-item">
			<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
				<?php echo esc_html( $category->name ); ?>
			</a>
		</span>
		<?php
	}
	?>
	</span>
	<?php
}

function boostify_post_date() {
	$date = get_the_date();
	?>
		<span class="boostify-meta-item boostify-post-in">
			<?php echo esc_html( $date ); ?>
		</span>
	<?php
}

function boostify_post_author() {
	$author = get_the_author_meta( 'ID' );
	?>
	<span class="boostify-meta-item boostify-author-meta boostify-post-by">
		<a href="<?php echo esc_url( get_author_posts_url( $author ) ); ?>">
			<?php the_author(); ?>
		</a>
	</span>
	<?php
}

function boostify_post_time() {
	$time = get_the_time();
	?>
	<span class="boostify-meta-item boostify-time-meta">
		<?php echo esc_html( $time ); ?>
	</span>
	<?php
}

function boostify_comment_count() {
	$comment = get_comments_number();
	?>
	<span class="boostify-meta-item boostify-comment-count">
	<?php
	if ( 0 == $comment ) { // phpcs:ignore
		echo esc_html__( 'No Comments', 'boostify' );
	} else {
		printf(
			/* translators: 1: comment count number, 2: title. */
			esc_html( _n( '%1$s Comment', '%1$s Comments', $comment, 'boostify' ) ),
			esc_html( number_format_i18n( $comment ) )
		);
	}
	?>
	</span>
	<?php
}

function boostify_theme_post_type() {
	$post_types       = get_post_types();
	$post_types_unset = array(
		'attachment'          => 'attachment',
		'revision'            => 'revision',
		'nav_menu_item'       => 'nav_menu_item',
		'custom_css'          => 'custom_css',
		'customize_changeset' => 'customize_changeset',
		'oembed_cache'        => 'oembed_cache',
		'user_request'        => 'user_request',
		'wp_block'            => 'wp_block',
		'elementor_library'   => 'elementor_library',
		'btf_builder'         => 'btf_builder',
		'elementor-hf'        => 'elementor-hf',
		'elementor_font'      => 'elementor_font',
		'elementor_icons'     => 'elementor_icons',
		'wpforms'             => 'wpforms',
		'wpforms_log'         => 'wpforms_log',
		'acf-field-group'     => 'acf-field-group',
		'acf-field'           => 'acf-field',
		'booked_appointments' => 'booked_appointments',
		'wpcf7_contact_form'  => 'wpcf7_contact_form',
		'scheduled-action'    => 'scheduled-action',
		'shop_order'          => 'shop_order',
		'shop_order_refund'   => 'shop_order_refund',
		'shop_coupon'         => 'shop_coupon',
		'product_variation'   => 'product_variation',
	);
	$options          = array_diff( $post_types, $post_types_unset );

	foreach ( $options as $key => $option ) {
		$object_post = get_post_type_object( $option );
		if ( $object_post->label ) {
			$options[ $key ] = $object_post->label;
		} else {
			$value           = str_replace( '_', ' ', $option );
			$value           = ucwords( $value );
			$options[ $key ] = $value;
		}
	}

	return $options;
}

function boostify_user() {
	$users     = get_users();
	$list_user = array();
	if ( ! empty( $users ) ) {
		foreach ( $users as $user ) {
			$list_user[ $user->ID ] = $user->user_login;
		}
	}

	return $list_user;
}

function boostify_taxonomies() {
	$post_types = boostify_theme_post_type();
	$list_term     = array();
	foreach ( $post_types as $key => $post_type ) {
		$taxonomies = get_object_taxonomies( $key, 'objects' );
		foreach ( $taxonomies as $taxonomy => $object ) {
			$name = $object->label . ': ';
			$terms = get_terms( $taxonomy );
			foreach ( $terms as $term ) {
				$list_term[ $term->term_id ] = $name . $term->name;
			}
		}
	}

	return $list_term;
}


function boostify_taxonomies_by_post_type( $post_type ) {
	$taxonomies = get_object_taxonomies( $post_type, 'objects' );
	$list_term  = array();
	foreach ( $taxonomies as $taxonomy => $object ) {
		$name  = $object->label . ': ';
		$terms = get_terms( $taxonomy );
		foreach ( $terms as $term ) {
			$key               = $taxonomy . '___' . $term->slug;
			$list_term[ $key ] = $name . $term->name;
		}
	}

	return $list_term;
}

function boostify_post( $post_type ) {
	$args      = array(
		'post_type'           => $post_type,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page'      => -1,
	);
	$posts     = new WP_Query( $args );
	$list_post = array();

	if ( $posts->have_posts() ) {
		while ( $posts->have_posts() ) {
			$posts->the_post();
			$list_post[ get_the_ID() ] = get_the_title();
		}

		wp_reset_postdata();
	}

	return $list_post;
}
