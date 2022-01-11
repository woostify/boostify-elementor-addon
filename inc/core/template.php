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
 * @param int $total_page .
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
 * @param string $settings  Setting in elemetor.
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

/**
 * Post Slider Template
 *
 * @param string $settings  Setting in elemetor.
 */
function boostify_template_post_slider( $settings ) {
	boostify_default_template( $settings, 'swiper-slide' );
}


/**
 * Testimonial Template
 *
 * @param string $settings  Setting in elemetor.
 */
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

/**
 * Team member Template
 *
 * @param array $settings  Setting in elemetor.
 */
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

/**
 * Render google recaptcha template.
 *
 * @param int $id Widget ID.
 * @since 1.0.0
 */
function boostify_get_google_recaptcha( $id ) {
	$recaptcha_sitekey      = get_option( 'boostify_recaptcha_site_key' );
	$recaptcha_secretkey    = get_option( 'boostify_recaptcha_secret_key' );
	$recaptcha_sitekey_v3   = get_option( 'boostify_recaptcha_v3_site_key' );
	$recaptcha_secretkey_v3 = get_option( 'boostify_recaptcha_v3_secret_key' );
	$recaptcha              = ( ! empty( $recaptcha_sitekey ) && ! empty( $recaptcha_sitekey ) ) ? true : false;
	$recaptchav3            = ( ! empty( $recaptcha_sitekey_v3 ) && ! empty( $recaptcha_secretkey_v3 ) ) ? true : false;
	if ( $recaptchav3 ) {
		$recaptcha_sitekey = $recaptcha_sitekey_v3;
	}
	?>
	<div class="field-control fiel-recaptcha">
		<input type="hidden" value="<?php echo esc_html( $recaptcha_sitekey ); ?>" name="g-recaptcha">
		<div id="g-recaptcha-register-<?php echo esc_attr( $id ); ?>" class="g-recaptcha"></div>
	</div>
	<?php
}

/**
 * Team member Template
 *
 * @param string $settings  Setting in elemetor.
 * @param int    $id Widget ID.
 *
 * @since 1.0.0
 */
function boostify_form_register( $settings, $id ) {
	$recaptcha_sitekey      = get_option( 'boostify_recaptcha_site_key' );
	$recaptcha_secretkey    = get_option( 'boostify_recaptcha_secret_key' );
	$recaptcha_sitekey_v3   = get_option( 'boostify_recaptcha_v3_site_key' );
	$recaptcha_secretkey_v3 = get_option( 'boostify_recaptcha_v3_secret_key' );
	$recaptcha              = ( ! empty( $recaptcha_sitekey ) && ! empty( $recaptcha_sitekey ) ) ? true : false;
	$recaptchav3            = ( ! empty( $recaptcha_sitekey_v3 ) && ! empty( $recaptcha_secretkey_v3 ) ) ? true : false;
	if ( $recaptchav3 ) {
		$recaptcha_sitekey = $recaptcha_sitekey_v3;
	}

	$register_action = is_string( $settings['register_action'] ) ? array( $settings['register_action'] ) : $settings['register_action'];

	?>
		<div class="register-form-header">
			<div class="form-header-wrapper">
				<?php if ( ! empty( $settings['logo']['id'] ) ) : ?>
					<div class="header-logo">
						<?php
							$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $settings['logo']['id'], 'logo_size', $settings );

						?>
						<img class="header-logo-img" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( 'Header Logo' ); ?>">

					</div>
				<?php endif ?>

				<?php if ( ! empty( $settings['register_form_title'] ) ) : ?>
					<div class="form-title">
						<h3 class="title"><?php echo esc_html( $settings['register_form_title'] ); ?></h3>
						<span class="form-subtitle">
							<?php echo esc_html( $settings['register_form_subtitle'] ); ?>
						</span>
					</div>
				<?php endif ?>
			</div>
		</div>
		<form class="wp-form-register">
			<?php do_action( 'boostify_addon_register_form_before' ); ?>

			<?php
			foreach ( $settings['register_fields'] as $f_index => $field ) :
				$type = 'text';
				switch ( $field['field_type'] ) {
					case 'email':
						$type = 'email';
						break;

					case 'password':
					case 'confirm_pass':
						$type = 'password';
						break;

					case 'website':
						$type = 'url';
						break;

					default:
						$type = 'text';
						break;
				}

				$label_class  = 'field-label';
				$label_class .= ( 'yes' == $field['required'] || 'username' == $field['field_type'] || 'email' == $field['field_type'] ) ? ' required' : ''; //phpcs:ignore
				$label_class .= ( 'yes' == $settings['mark_required'] ) ? ' mark-required' : ''; //phpcs:ignore

				$field_class  = 'field-control ' . $field['field_type'];
				$field_class .= ( ! empty( $settings['width'] ) ) ? ' boostify-col-' . $settings['width'] : '';
				$field_class .= ( ! empty( $settings['width_tablet'] ) ) ? ' elementor-md-' . $settings['width_tablet'] : '';
				$field_class .= ( ! empty( $settings['width_mobile'] ) ) ? ' elementor-sm-' . $settings['width_mobile'] : '';
				$field_class .= ( 'yes' == $field['required'] || 'username' == $field['field_type'] || 'email' == $field['field_type'] ) ? ' field-required' : ''; //phpcs:ignore
				$required = ( 'yes' == $field['required'] || 'username' == $field['field_type'] || 'email' == $field['field_type'] ) ? 'required' : ''; //phpcs:ignore

				?>
				<div class="<?php echo esc_attr( $field_class ); ?>">
					<?php if ( 'yes' == $settings['show_labels'] ) : //phpcs:ignore ?>
						<label for="boostify-field-<?php echo esc_attr( $field['_id'] ); ?>" class="<?php echo esc_attr( $label_class ); ?>"><?php echo esc_html( $field['field_label'] ); ?></label>
					<?php endif ?>
					<input type="<?php echo esc_attr( $type ); ?>" id="boostify-field-<?php echo esc_attr( $field['_id'] ); ?>" class="field-input boostify-field" name="<?php echo esc_attr( $field['field_type'] ); ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" <?php echo esc_attr( $required ); ?>>
					<div class="boostify-error"></div>
				</div>
				<?php

			endforeach;

			do_action( 'boostify_before_register_google_recaptcha' );

			if ( 'yes' == $settings['enable_register_recaptcha'] ): //phpcs:ignore
				boostify_get_google_recaptcha( $id );
			endif;

			?>

			<?php do_action( 'boostify_addon_register_form_after' ); ?>
				<?php if ( 'yes' == $settings['show_terms_conditions'] ) : //phpcs:ignore ?>
					<div class="field-control field-terms-conditions">
						<label for="label-terms-<?php echo esc_attr( $id ); ?>" class="field-label">
							<input type="checkbox" name="terms_conditions" class=" field-checkbox boostify-field" value="1" id="label-terms-<?php echo esc_attr( $id ); ?>">
							<span class="checkmark"></span>
							<span class="label-terms">
								<?php
								$url        = '#';
								$attributes = '';
								if ( 'custom' == $settings['acceptance_text_source'] && $settings['acceptance_text_url']['url'] ) { // phpcs:ignore
									$url         = $settings['acceptance_text_url']['url'];
									$attributes .= ! empty( $settings['acceptance_text_url']['is_external'] ) ? ' target="_blank"' : '';
									$attributes .= ! empty( $settings['acceptance_text_url']['nofollow'] ) ? ' rel="nofollow"' : '';
								}

								$html  = '<a href="' . $url . '" class="term-conditions_link"' . $attributes . '>';
								$label = str_replace( '[', $html, $settings['acceptance_label'] );
								$label = str_replace( ']', '</a>', $label );
								echo wp_kses(
									$label,
									array(
										'a' => array(
											'class'  => array(),
											'href'   => array(),
											'id'     => array(),
											'target' => array(),
											'rel'    => array(),
										),
									)
								);
								?>
							</span>
						</label>
						<?php if ( 'editor' == $settings['acceptance_text_source'] ) : //phpcs:ignore ?>
							<div class="boostify-terms-conditions-popup">
								<div class="terms-conditions-popup-wrapper">
									<?php echo $settings['acceptance_text']; // phpcs:ignore ?>
								</div>
							</div>
						<?php endif ?>
					</div>
				<?php endif ?>
			<div class="form-action-footer">
				<div class="field-control field-submit">
					<div class="group-control">
						<?php if ( ! empty( $settings['register_action'] ) ) : ?>
							<input type="hidden" value="<?php echo esc_html( implode( ',', $register_action ) ); ?>" name="register_action">
						<?php endif ?>

						<?php if ( 'yes' == $settings['enable_register_recaptcha'] ) : // phpcs:ignore ?>
							<input type="hidden" value="<?php echo esc_html( $recaptcha_sitekey ); ?>" name="g-recaptcha">
						<?php endif ?>
						<?php if ( ! empty( $settings['register_action'] ) && in_array( 'redirect', $register_action ) && $settings['register_redirect_url']['url'] ) : //phpcs:ignore ?>
							<input type="hidden" name="register_redirect_url" value="<?php echo esc_url( $settings['register_redirect_url']['url'] ); ?>">
						<?php endif ?>
						<?php if ( 'custom' == $settings['reg_admin_email_template_type'] ) : // phpcs:ignore ?>
							<?php if ( ! empty( $settings['reg_admin_email_subject'] ) ) : ?>
								<input type="hidden" value="<?php echo esc_html( $settings['reg_admin_email_subject'] ); ?>" name="admin_email_subject">
							<?php endif ?>
							<?php if ( ! empty( $settings['reg_admin_email_message'] ) ) : ?>
								<input type="hidden" value="<?php echo esc_html( $settings['reg_admin_email_message'] ); ?>" name="admin_email_message">
							<?php endif ?>
							<input type="hidden" value="<?php echo esc_html( $settings['reg_admin_email_content_type'] ); ?>" name="admin_email_content_type">
						<?php endif ?>
						<?php if ( 'custom' == $settings['reg_email_template_type'] ) : // phpcs:ignore ?>
							<?php if ( ! empty( $settings['reg_email_subject'] ) ) : ?>
								<input type="hidden" value="<?php echo esc_html( $settings['reg_email_subject'] ); ?>" name="email_subject">
							<?php endif ?>
							<?php if ( ! empty( $settings['reg_email_message'] ) ) : ?>
								<input type="hidden" value="<?php echo esc_html( $settings['reg_email_message'] ); ?>" name="email_message">
							<?php endif ?>
							<input type="hidden" value="<?php echo esc_html( $settings['reg_email_content_type'] ); ?>" name="email_content_type">
						<?php endif ?>
					</div>


					<button type="submit" class="btn-submit btn-register"><?php echo esc_html( $settings['register_button_text'] ); ?></button>
				</div>
				<?php if ( 'yes' == $settings['show_login_link'] ) : //phpcs:ignore ?>
					<?php
					$link      = '#';
					$link_atts = '';
					switch ( $settings['login_link_action'] ) {
						case 'default':
							$link = wp_registration_url();
							break;

						case 'custom':
							if ( ! empty( $settings['custom_login_url']['url'] ) ) {
								$link       = $settings['custom_login_url']['url'];
								$link_atts  = ! empty( $settings['custom_login_url']['is_external'] ) ? ' target="_blank"' : '';
								$link_atts .= ! empty( $settings['custom_login_url']['nofollow'] ) ? ' rel="nofollow"' : '';
							}
							break;

						default:
							$link = '#';
							break;
					}
					?>
				<div class="field-control field-login field-link">
					<a href="<?php echo esc_url( $link ); ?>" <?php echo $link_atts; //phpcs:ignore ?>>
						<?php echo esc_html( $settings['login_link_text'] ); ?>
					</a>
				</div>
				<?php endif ?>

			</div>
		</form>

	<?php
}
