<?php
/**
 * Template Name: Alumni
 *
 * @package mscfinance
 * @since mscfinance 1.0
 */
get_header(); ?>

<div id="page" class="container alumni">
	<?php while ( have_posts() ) : the_post(); ?>
	<div id="content" class="break-on-mobile">
		<div id="alumni">
			<?php if(!$post->post_content == ''): ?>
			<div class="page-content">
				<?php the_content(); ?>
			</div>
			<?php endif; ?>
			<?php if ( get_field('content')):?>
				<?php get_template_part('inc/content'); ?>
			<?php endif; ?>
		</div>
	</div>
	<?php get_template_part('sidebar'); ?>
	<?php endwhile; // end of the loop. ?>
</div><!-- #page -->
<?php get_footer(); ?>