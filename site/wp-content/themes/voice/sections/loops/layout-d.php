<article <?php post_class('vce-post vce-lay-d'); ?>>
	
 	<?php if($fimage = vce_featured_image('vce-lay-d')): ?>
	 	<div class="meta-image">			
			<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
				<?php echo $fimage; ?>
				<?php if($icon = vce_post_format_icon('lay_d')) :?>
					<span class="vce-format-icon">
					<i class="fa <?php echo $icon; ?>"></i>
					</span>
				<?php endif; ?>
			</a>
		</div>
	<?php endif; ?>	

	<header class="entry-header">
		<?php if( vce_get_option('lay_d_cat')) : ?>
			<span class="meta-category"><?php echo vce_get_category(); ?></span>
		<?php endif; ?>
		<h2 class="entry-title"><a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>"><?php echo vce_get_title('lay-d'); ?></a></h2>
		<div class="entry-meta"><?php echo vce_get_meta_data('lay-d'); ?></div>
	</header>

</article>