<?php $e = 0; ?>
<?php while(has_sub_field("content")): $e++; ?>
<?php $layout = get_row_layout(); ?>

	<?php if(get_row_layout() == "content"): ?>

		<div class="row <?php echo $layout; ?>" style="<?php the_sub_field("css"); ?>">
			<h1><?php the_sub_field("title"); ?></h1>
			<?php the_sub_field("content_field"); ?>
		</div>
 
	<?php elseif(get_row_layout() == "content_image"): ?>
 
		<div class="row <?php echo $layout; ?>" style="<?php the_sub_field("css"); ?>">
			<div class="images-bar">
				
				<img class="scale <?php if( get_sub_field('first-image') ):?>not-chosen<?php endif; ?>" src="<?php the_sub_field("image"); ?>" alt="<?php the_sub_field("title"); ?>">

				<?php 
					$images = get_sub_field('images');
					if( $images ): ?>
			            <?php foreach( $images as $image ): ?>
			                    <img class="scale not-chosen"  src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
			            <?php endforeach; ?>
				<?php endif; ?>				
			</div>
			<div class="content-wrapper">
				<h1><?php the_sub_field("title"); ?></h1>
				<?php the_sub_field("img-content"); ?>
			</div>
		</div>

	<?php elseif(get_row_layout() == "accordion"): ?>
 
		<div id="acc-<?php echo $e; ?>" class="row <?php echo $layout; ?>" style="<?php the_sub_field("css"); ?>">
			<h1><?php the_sub_field("title"); ?></h1>
			<?php if(get_sub_field('items')): $i = 0; ?>
				<?php while(has_sub_field('items')): $i++; ?>
					<?php if( get_sub_field('subtitle') ):?>
						<h2 class="subtitle"><?php the_sub_field("title"); ?></h2>			
					<?php else: ?>				
						<div class="accordion-item" data-id="<?php echo $i; ?>">
							<h2><a class="trigger" data-id="<?php echo $i; ?>"><?php the_sub_field("title"); ?></a></h2>
							<div class="content" data-id="<?php echo $i; ?>">
								<p><?php the_sub_field('content'); ?></p>
							</div>
						</div>
					<?php endif; ?>		 					
				<?php endwhile; ?>
			<?php endif; ?>
		</div>	
 
	<?php elseif(get_row_layout() == "accordion_image"): ?>

		<div id="acc-<?php echo $e; ?>" class="row <?php echo $layout; ?>" style="<?php the_sub_field("css"); ?>">
			<div class="images-bar">
				<img class="scale" src="<?php the_sub_field("image"); ?>" alt="<?php the_sub_field("title"); ?>">
				<?php 
					$images = get_sub_field('images');
					if( $images ): ?>
			            <?php foreach( $images as $image ): ?>
			                    <img class="scale not-chosen" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
			            <?php endforeach; ?>
				<?php endif; ?>				
			</div>	
			<div class="content-wrapper">		
				<h1><?php the_sub_field("title"); ?></h1>
				<?php if(get_sub_field('items')): $i = 0; ?>
					<?php while(has_sub_field('items')): $i++; ?>	
						<?php if( get_sub_field('subtitle') ):?>
							<h2 class="subtitle"><?php the_sub_field("title"); ?></h2>			
						<?php else: ?>
							<div class="accordion-item" data-id="<?php echo $i; ?>">
								<h2><a class="trigger" data-id="<?php echo $i; ?>"><?php the_sub_field("title"); ?></a></h2>
								<div class="content" data-id="<?php echo $i; ?>">
									<p><?php the_sub_field('content'); ?></p>
								</div>
							</div>
						<?php endif; ?>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>

	<?php elseif(get_row_layout() == "ajax_content"): ?>	
	
		<div id="ajax-content" style="<?php the_sub_field("css"); ?>">

		</div>	
		<script>
			var myUrl = '<?php the_sub_field("ajax-content"); ?>' + " <?php the_sub_field("selector"); ?>";
			jQuery("#ajax-content").load(myUrl);
			return false;
		</script>

	<?php elseif(get_row_layout() == "columns"): ?>		

	

	<div class="columns clearfix">
		<?php $total_columns = count( get_sub_field('column-content')); ?>
		<?php while (has_sub_field('column-content')) : ?>

		<?php
		switch($total_columns){
			case 2:
				$class = 'five';
				break;
			case 3:
				$class = 'one-third';
				break;
			case 4:
				$class = 'one-fourth';
				break;
			case 5:
				$class = 'one-fifth';
				break;
			case 1:
			default:
				$class = 'ten';
				break;
		} ?>
			<div class="break-on-mobile span <?php echo $class; ?>" style="<?php the_sub_field('css'); ?>;">
				<div class="inner equal-height">
					<div class="content clearfix">
						<?php the_sub_field('content'); ?>
					</div>
						<?php if(get_sub_field('link_to')): ?>
						<a href="<?php the_sub_field('link_to'); ?>" class="button"><?php _e('Tell me more')?></a>
					<?php endif?>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
 
	<?php endif; ?>
<?php endwhile; ?>