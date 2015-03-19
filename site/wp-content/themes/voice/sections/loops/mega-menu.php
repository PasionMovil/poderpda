<li>	
	<?php if($fimage = vce_featured_image('vce-lay-b')): ?>			
		<a class="mega-menu-img" href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
			<?php echo $fimage; ?>
			<?php if($icon = vce_post_format_icon('lay_c')) :?>
				<span class="vce-format-icon">
				<i class="fa <?php echo $icon; ?>"></i>
				</span>
			<?php endif; ?>
		</a>
	<?php endif; ?>	

	<a class="mega-menu-link" href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>"><?php the_title(); ?></a>
	
</li>