<section class="main-box mbt-border-top author-box">

	<h3 class="main-box-title"><?php echo __vce('about_author'); ?></h3>

	<div class="main-box-inside">

	<div class="data-image">
		<?php echo get_avatar( get_the_author_meta('ID'), 112 ); ?>
	</div>
	
	<div class="data-content">
		<h4 class="author-title"><?php the_author_meta('display_name'); ?></h4>
		<div class="data-entry-content">
			<?php echo wpautop(get_the_author_meta('description')); ?>
		</div>
	</div>

	</div>

	<div class="vce-content-outside">
		<div class="data-links">
				<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="vce-author-link vce-button"><?php echo __vce('view_all_posts'); ?></a>
		</div>
		<div class="vce-author-links">
			<?php if (get_the_author_meta('url')) {?> <a href="<?php the_author_meta('url'); ?>" target="_blank" class="fa fa-link vce-author-website"></a><?php } ?>
			<?php $user_social = vce_get_social(); ?>			
			<?php foreach($user_social as $soc_id => $soc_name): ?>
				<?php if($social_meta = get_the_author_meta($soc_id)) : ?>
					<a href="<?php echo $social_meta; ?>" target="_blank" class="fa fa-<?php echo $soc_id.' soc_squared'; ?>"></a>
				<?php endif; ?>			
			<?php endforeach; ?>					
		</div>
	</div>

</section>