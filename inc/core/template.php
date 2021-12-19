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

function boostify_template_testimonial_default( $settings ) {
	$list        = $settings['testi'];
	$layout      = $settings['layout'];
	$show_avatar = $settings['show_avatar'];
	$col         = $settings['column'];
	$arrow       = $settings['arrow'];
	$dot         = $settings['dot'];
	?>
	<div class="boostify-addon-widget widget-testimonial">
		<div class="widget-testimonial--wrapper swiper-container" data-col="<?php echo esc_attr( $col ); ?>" data-arrow="<?php echo esc_attr( $arrow ); ?>" data-arrow="<?php echo esc_attr( $dot ); ?>">
			<div class="testimonial-list swiper-wrapper">
			<?php foreach ( $list as $item ) : ?>
				<div class="testimonial-item swiper-slide">
					<div class="testimonial-item--wrapper">
						<div class="testimonial-content">
							<span class="content">
								<?php echo esc_html( $item['content'] ); ?>
							</span>
						</div>
						<div class="testimonial-infomation">
							<?php if ( $show_avatar ) : ?>
								<div class="avatar">
									<?php
										if ( empty( $item['image']['id'] ) ) {
										?>
										<img src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="image-placeholer">
										<?php
									} else {
										$url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $item['image']['id'], 'thumbnail', $settings );
										?>
											<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
										<?php
									}
									?>
								</div>
							<?php endif ?>
							<span class="name"><?php echo esc_html( $item['name'] ); ?></span>
							<span class="position"><?php echo esc_html( $item['position'] ); ?></span>
						</div>
					</div>
				</div>
			<?php endforeach ?>
			</div>
			<?php if ( $dot == 'yes' ) :  //phpcs:ignore ?>
				<div class="swiper-pagination"></div>
			<?php endif ?>
			<?php if ( $arrow == 'yes' ) : //phpcs:ignore ?>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			<?php endif ?>
		</div>
	</div>
	<?php
}


function boostify_template_teammember_default( $settings ) {
	$name         = $settings['name'];
	$position     = $settings['position'];
	$contact_list = $settings['contact_list'];

	if ( empty( $settings['image']['id'] ) ) {
		$image_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'size', 'image' );
	} else {
		$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $settings['image']['id'], 'size', $settings );

		$image_html = '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( 'Avatar of ' . $name ) . '" >';
	}
	?>
	<div class="boostify-widget widget-team-member">
		<div class="widget-team-member--wrapper">
			<div class="member-avatar">
				<?php
				echo wp_kses(
					$image_html,
					array(
						'img' => array(
							'src'   => array(),
							'class' => array(),
							'alt'   => array(),
						),
					)
				);
				?>
				<div class="member-contact">
					<div class="contact--wrapper">
						<?php foreach ( $contact_list as $item ) : ?>
							<?php $icon = $item['icon']; ?>
							<div class="item-contact">
								<?php
								if ( ! empty( $icon['value'] ) ) :
									if ( is_string( $icon['value'] ) ) :
										?>
										<a href="<?php echo esc_url( $item['link']['url'] ); ?>" class="icon-contact <?php echo esc_attr( $icon['value'] ); ?>"></a>
									<?php else : ?>
										<a href="<?php echo esc_url( $item['link']['url'] ); ?>" class="icon-contact <?php echo esc_attr( $item['icon'] ); ?>"><?php Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?></a>

										<?php
									endif;
								endif;
								?>

							</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
			<div class="member-info">
				<h4 class="member-name"><?php echo esc_html( $name ); ?></h4>
				<span class="member-position"><?php echo esc_html( $position ); ?></span>
			</div>
		</div>
	</div>
	<?php
}

