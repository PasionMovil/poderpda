<article id="post-<?php the_ID(); ?>" <?php post_class('vce-post vce-lay-g'); ?>>

    <div class="vce-featured-header">
        <div class="vce-featured-info">
        	<?php if( vce_get_option('lay_g_cat')) : ?>
	            <span class="meta-category">
	                <?php echo vce_get_category(); ?>
	            </span>
            <?php endif; ?>

            <h2 class="entry-title">
                <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>"><?php echo get_the_title(); ?></a>        
            </h2>

            <div class="entry-meta"><?php echo vce_get_meta_data('lay-g'); ?></div>

        </div>
        
        <div class="vce-featured-header-background"></div>
    </div>

	<?php global $vce_sidebar_opts; $img_size = $vce_sidebar_opts['use_sidebar'] == 'none' ? 'vce-lay-a-nosid' : 'vce-lay-a'; ?>
	<?php if($fimage = vce_featured_image($img_size)): ?>
	 	<div class="meta-image">			
			<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
				<?php echo $fimage; ?>
				<?php if($icon = vce_post_format_icon('lay_g')) :?>
					<span class="vce-format-icon">
					<i class="fa <?php echo $icon; ?>"></i>
					</span>
				<?php endif; ?>
			</a>
		</div>
	<?php endif; ?>	

</article>