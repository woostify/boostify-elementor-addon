<?php
/**
 * Template Post Grid
 *
 *
 * @package Post Grid;
 */

?>

<article id="post-<?php the_ID(); ?>" <?php boostify_post_class(  ); ?>>
	<h2><?php the_title(); ?></h2>
</article><!-- #post-<?php the_ID(); ?> -->