	</div><!-- #main -->
	<?php while (have_posts()) : the_post(); ?>
	        <div id="slideupbox" <?php if( get_field('slideup_box')): ?>class='slideup'<?php endif; ?>>
	        	<a href="#" class="close-link">x</a>
				<p><?php the_field('slideup_box_content', 'option'); ?></p>
			</div>
	<?php endwhile;?>
	
	<footer id="footer"  role="contentinfo">
		<div class="container">
			<div class="inner content clearfix">
				<div class="span two logos">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer First Column')) : ?><?php endif; ?>
				</div>
				<div class="span two footer-menu">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Second Column')) : ?><?php endif; ?>
				</div>
				<div class="span five break-on-mobile">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Third Column')) : ?><?php endif; ?>		
				</div>
			</div>
			<div class="bottom-nav">
				<span class="copyright">&copy; <?php bloginfo( 'name' ); ?></span>
				<?php wp_nav_menu( array( 'theme_location' => 'secondary_footer', 'menu_class' => 'clearfix menu', 'container' => false ) ); ?>
				
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->
<?php if( get_field('want_lightbox')): ?>
	<div id="lightbox" data-delay="<?php the_field('lightbox_delay') ?>">
		<div id="lightbox-inner">
			<div class="container">
				<div class="span ten">
					<img class="scale" src="<?php the_field('lightbox_header_image', 'option'); ?>" alt="">
				</div>
				<div class="span five">
					<?php the_field('lightbox_content', 'option'); ?>
				</div>
				<div class="span five">
					<?php gravity_form(2, false, false, false, '', true); ?>
				</div>
			</div>	
		</div>
	</div>
<?php endif; ?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=579639135402354";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>