<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package mscfinance
 * @since mscfinance 1.0
 */

query_posts(array_merge($wp_query->query_vars, array(
	'orderby' => 'meta_value_num',
	'meta_key' => 'event_date',
	'order' => 'ASC'
)));
get_header(); ?>
<div id="events">
<div id="page" class="container">
	<div id="content" class="break-on-mobile">
		<div class="categories clearfix">
			<h2><?php _e('Categories: ') ?></h2>
			<?php
                $args = array(
                    'orderby'   => 'name',
                    'order'     => 'ASC',
                    'taxonomy'  => 'event_category',
                    'hide_empty'    => 1
                );
                $terms = get_terms( 'event_category', $args );
            	$current_cat_id = get_queried_object()->term_id;
			?>
			<ul class="category">
				<li <?php if($current_cat_id == ''): ?>class='current'<?php endif; ?>>
					<a class="button" href="<?php echo get_permalink(107); ?>"><?php _e('All Events')?></a>
				</li>
				<?php foreach ($terms as $term) : ?>
					<li <?php if($current_cat_id == $term->term_id): ?>class='current'<?php endif; ?>>
						<a class="button" href="<?php echo get_term_link($term);?>"><?php echo $term->name; ?></a>
					</li>
				 <?php endforeach; ?>
			</ul>
			<div class="mobile-category clearfix">
				<select> 			 	
					<option value=""<?php if($current_cat_id == $term->term_id): ?>selected="selected'<?php endif; ?> ">Select</option> 
					<option value="<?php echo get_permalink(107); ?>">All Events</option> 

					<?php foreach ($terms as $term) : ?>
					<option value="<?php echo get_term_link($term);?>"><?php echo $term->name; ?></option> 
					<?php endforeach; ?>
				</select> 
		  	</div>				
		</div>			
	<?php while ( have_posts() ) : the_post(); ?>	
		<div class="row content_image">
			<div class="images-bar <?php if( get_field('hide_image_on_mobile') ):?>not-chosen<?php endif; ?>">
				<img class="scale" src="<?php the_field("event_image"); ?>" alt="" />
			</div>
			<div class="content-wrapper">
			<h1><?php the_title(); ?></h1>
			<p><?php the_field("event_date"); ?></p>
			<p><b><?php the_field("event_location"); ?></b></p>
			<p><?php the_field("event_time"); ?></p>
			<p><?php the_content(); ?></p>
			
			
			<a href="<?php the_field("button_link"); ?>" class="button" <?php if( get_field('external_link') ): ?>target="_blank"<?php endif; ?>><?php the_field("button_text"); ?></a>
			</div>
		</div>
	<?php endwhile; // end of the loop. ?>
	</div>
	<?php get_template_part('sidebar'); ?>
</div><!-- #page -->
</div>
<?php get_footer(); ?>