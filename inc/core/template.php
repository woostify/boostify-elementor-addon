<?php
/**
 * Core function template
 *
 * Main Plugin
 * @since 1.0.0
 */

function boostify_template_post_grid() {
	?>
	<article id="post-<?php the_ID(); ?>" <?php boostify_post_class( 'boostify-grid-item' ); ?>>
		<div class="boostify-post-item-wrapper">
			<?php boostify_post_thumbnail(); ?>
			<div class="boostify-post-info">
				<h2 class="boostify-post-title">
					<a href="<?php echo esc_url( get_the_permalink() ); ?>">
						<?php echo esc_html( get_the_title() ); ?>
					</a>
				</h2>
				<?php boostify_post_meta(); ?>
			</div>
			<div class="boostify-post-excpert">
				<span class="post-excpert">
					<?php the_excerpt(); ?>
				</span>
			</div>
		</div>
	</article><!-- #post-<?php the_ID(); ?> -->
	<?php
}
