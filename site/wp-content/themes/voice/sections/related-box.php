<?php $related_posts = vce_get_related_posts(); ?>

<?php if(!empty($related_posts) && $related_posts->have_posts()): ?>
	
	<div class="main-box vce-related-box">

	<h3 class="main-box-title"><?php echo __vce('related_title'); ?></h3>
	
	<div class="main-box-inside">

		<?php while($related_posts->have_posts()): $related_posts->the_post(); ?>
			<?php get_template_part('sections/loops/layout', vce_get_option('related_layout')); ?>
		<?php endwhile; ?>

		<?php wp_reset_postdata(); ?>

	</div>

	</div>

<?php endif; ?>


	