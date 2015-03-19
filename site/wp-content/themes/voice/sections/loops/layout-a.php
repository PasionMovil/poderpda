<article <?php post_class('vce-post vce-lay-a'); ?>>
	
	<?php global $vce_sidebar_opts; $img_size = $vce_sidebar_opts['use_sidebar'] == 'none' ? 'vce-lay-a-nosid' : 'vce-lay-a'; ?>
	<?php if($fimage = vce_featured_image($img_size)): ?>
	 	<div class="meta-image">			
			<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
				<?php echo $fimage; ?>
				<?php if($icon = vce_post_format_icon('lay_a')) :?>
					<span class="vce-format-icon">
					<i class="fa <?php echo $icon; ?>"></i>
					</span>
				<?php endif; ?>
			</a>
		</div>
	<?php endif; ?>	

	<header class="entry-header">
		<?php if( vce_get_option('lay_a_cat')) : ?>
			<span class="meta-category"><?php echo vce_get_category(); ?></span>
		<?php endif; ?>
		<h2 class="entry-title"><a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>"><?php echo vce_get_title('lay-a'); ?></a></h2>
		<div class="entry-meta"><?php echo vce_get_meta_data('lay-a'); ?></div>
	</header>

	<?php if( vce_get_option('lay_a_excerpt')) : ?>
		<div class="entry-content">
			<p><?php echo vce_get_excerpt('lay-a'); ?></p>
		</div>
	<?php endif; ?>
</article>