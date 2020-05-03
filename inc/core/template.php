<?php
/**
 * Core function template
 *
 * Main Plugin
 * @since 1.0.0
 */


/**
 * Default Post Template
 *
 * @param string    $settings  Setting in elemetor.
 * @param string    $class  custom class.
 */
function boostify_default_template( $settings, $class = '' ) {
	$meta_data = $settings['meta_data'];
	$tag       = $settings['title_tag'];
	?>
	<article id="post-<?php the_ID(); ?>" <?php boostify_post_class( $class ); ?>>
		<div class="boostify-post-item-wrapper">
			<?php
			if ( 'yes' === $settings['image'] ) {
				boostify_post_thumbnail();
			}
			?>
			<div class="boostify-post-info">

				<<?php echo esc_attr( $tag ); ?> class="boostify-post-title">
					<a href="<?php echo esc_url( get_the_permalink() ); ?>">
						<?php echo esc_html( get_the_title() ); ?>
					</a>
				</<?php echo esc_attr( $tag ); ?>>
				<div class="boostify-post-meta">
					<?php
					if ( in_array( 'author', $meta_data ) ) { //phpcs:ignore
						boostify_post_author();
					}
					if ( in_array( 'date', $meta_data ) ) { //phpcs:ignore
						boostify_post_date();
					}
					if ( in_array( 'time', $meta_data ) ) { //phpcs:ignore
						boostify_post_time();
					}
					if ( in_array( 'category', $meta_data ) && 'post' === get_post_type() ) { //phpcs:ignore
						boostify_post_category();
					}
					if ( in_array( 'comment', $meta_data ) ) { //phpcs:ignore
						boostify_comment_count();
					}

					?>
				</div>

				<?php if ( 'yes' === $settings['excpert'] ) : ?>
					<div class="boostify-post-excpert">
						<span class="post-excpert">
							<?php echo wp_trim_words( get_the_content( get_the_ID() ) , $settings['length'], null ); //phpcs:ignore ?>
						</span>
					</div>
				<?php endif ?>

				<?php if ( $settings['show_read_more'] ) : ?>
					<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="boostify-post-read-more">
						<?php echo esc_html( $settings['read_more'] ); ?>
					</a>
				<?php endif ?>
			</div>

		</div>
	</article><!-- #post-<?php the_ID(); ?> -->
	<?php
}


/**
 * Post Grid Default Template
 *
 * @param string    $settings  Setting in elemetor.
 * @param string    $class  custom class.
 */
function boostify_template_post_grid( $settings ) {
	boostify_default_template( $settings, 'boostify-grid-item' );
}

/**
 * Post Grid Masonry Template
 *
 * @param string    $settings  Setting in elemetor.
 * @param string    $class  custom class.
 */
function boostify_template_post_grid_masonry( $settings ) {
	$meta_data = $settings['meta_data'];
	$tag       = $settings['title_tag'];
	?>
	<article id="post-<?php the_ID(); ?>" <?php boostify_post_class( 'boostify-grid-item' ); ?>>
		<div class="boostify-post-item-wrapper">
			<?php
			if ( 'yes' === $settings['image'] ) {
				boostify_post_thumbnail();
			}
			?>
			<div class="boostify-post-info">

				<<?php echo esc_attr( $tag ); ?> class="boostify-post-title">
					<a href="<?php echo esc_url( get_the_permalink() ); ?>">
						<?php echo esc_html( get_the_title() ); ?>
					</a>
				</<?php echo esc_attr( $tag ); ?>>

				<?php if ( 'yes' === $settings['excpert'] ) : ?>
					<div class="boostify-post-excpert">
						<span class="post-excpert">
							<?php echo wp_trim_words( get_the_content( get_the_ID() ) , $settings['length'], null ); //phpcs:ignore ?>
						</span>
					</div>
				<?php endif ?>

				<?php if ( $settings['show_read_more'] ) : ?>
					<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="boostify-post-read-more">
						<?php echo esc_html( $settings['read_more'] ); ?>
					</a>
				<?php endif ?>
				<div class="boostify-entry-footer">
					<div class="boostify-post-meta">
						<?php
						if ( in_array( 'author', $meta_data ) ) { //phpcs:ignore
							boostify_post_author();
						}
						if ( in_array( 'date', $meta_data ) ) { //phpcs:ignore
							boostify_post_date();
						}
						if ( in_array( 'time', $meta_data ) ) { //phpcs:ignore
							boostify_post_time();
						}
						if ( in_array( 'category', $meta_data ) && 'post' === get_post_type() ) { //phpcs:ignore
							boostify_post_category();
						}
						if ( in_array( 'comment', $meta_data ) ) { //phpcs:ignore
							boostify_comment_count();
						}

						?>
					</div>
				</div>
			</div>
		</div>
	</article><!-- #post-<?php the_ID(); ?> -->
	<?php
}

/**
 * Pagination
 *
 * @param int    $total_page .
 */
function boostify_pagination( $total_page ) {
	if ( $total_page > 1 ) {
		$current_page = max( 1, get_query_var( 'paged' ) );
		?>
		<nav class="boostify-pagination blog-pagination">
			<?php
			echo paginate_links( //phpcs:ignore
				array(
					'base'      => get_pagenum_link( 1 ) . '%_%',
					'format'    => '/page/%#%',
					'current'   => $current_page,
					'total'     => $total_page,
					'prev_text' => esc_html__( 'Prev', 'boostify' ),
					'next_text' => esc_html__( 'Next', 'boostify' ),
					'end_size'  => 3,
					'mid_size'  => 3,
				)
			);
			?>
		</nav>
		<?php
	}
}

function boostify_button_load_more( $text ) {
	?>
	<div class="boostify-pagination load-more-pagination">
		<button type="button" class="boostify-btn-load-more">
			<span class="btn-text"><?php echo esc_html( $text ); ?></span>
		</button>
	</div>
	<?php
}


/**
 * Post List Template
 *
 * @param string    $settings  Setting in elemetor.
 * @param string    $class  custom class.
 */
function boostify_template_post_list( $settings ) {
	$meta_data = $settings['meta_data'];
	$tag       = $settings['title_tag'];
	?>
	<article id="post-<?php the_ID(); ?>" <?php boostify_post_class( 'boostify-grid-item' ); ?>>
		<div class="boostify-post-item-wrapper">
			<?php
			if ( 'yes' === $settings['image'] ) {
				boostify_post_image();
			}
			?>
			<div class="boostify-post-info">
				<div class="boostify-post-meta">
					<?php
					if ( in_array( 'author', $meta_data ) ) { //phpcs:ignore
						boostify_post_author();
					}
					if ( in_array( 'date', $meta_data ) ) { //phpcs:ignore
						boostify_post_date();
					}
					if ( in_array( 'time', $meta_data ) ) { //phpcs:ignore
						boostify_post_time();
					}
					if ( in_array( 'category', $meta_data ) && 'post' === get_post_type() ) { //phpcs:ignore
						boostify_post_category();
					}
					if ( in_array( 'comment', $meta_data ) ) { //phpcs:ignore
						boostify_comment_count();
					}

					?>
				</div>

				<<?php echo esc_attr( $tag ); ?> class="boostify-post-title">
					<a href="<?php echo esc_url( get_the_permalink() ); ?>">
						<?php echo esc_html( get_the_title() ); ?>
					</a>
				</<?php echo esc_attr( $tag ); ?>>


				<?php if ( 'yes' === $settings['excpert'] ) : ?>
					<div class="boostify-post-excpert">
						<span class="post-excpert">
							<?php echo wp_trim_words( get_the_content( get_the_ID() ) , $settings['length'], null ); //phpcs:ignore ?>
						</span>
					</div>
				<?php endif ?>

				<?php if ( $settings['show_read_more'] ) : ?>
					<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="boostify-post-read-more">
						<?php echo esc_html( $settings['read_more'] ); ?>
					</a>
				<?php endif ?>
			</div>

		</div>
	</article><!-- #post-<?php the_ID(); ?> -->
	<?php
}


function boostify_template_post_slider( $settings ) {
	boostify_default_template( $settings, 'swiper-slide' );
}
