<article id="post-<?php the_ID(); ?>" <?php post_class('vce-single'); ?>>

	<header class="entry-header">
		<?php if(vce_get_option('show_cat')) : ?>
			<span class="meta-category"><?php echo vce_get_category(); ?></span>
		<?php endif; ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<div class="entry-meta"><?php echo vce_get_meta_data('single'); ?></div>
	</header>

	<?php if ($audio = hybrid_media_grabber( array( 'type' => 'audio', 'split_media' => true ) ) ): ?>
	 	<div class="meta-media">
	 		<?php echo $audio; ?>
	 		<?php if ( has_post_thumbnail() ) : ?>
	 		<?php global $vce_sidebar_opts; $img_size = $vce_sidebar_opts['use_sidebar'] == 'none' ? 'vce-lay-a-nosid' : 'vce-lay-a'; ?>
				<?php the_post_thumbnail( $img_size ); ?>
			<?php endif; ?>	
		</div>
	<?php endif; ?>	

    <?php if(vce_get_option('show_headline') && has_excerpt()) : ?>
	    <div class="entry-headline">
	    	<?php the_excerpt(); ?>
	    </div>
    <?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<?php if(vce_get_option('show_tags')) : ?>
		<footer class="entry-footer">
			<div class="meta-tags">
				<?php the_tags( false, ' ', false ); ?>
			</div>
		</footer>
	<?php endif; ?>

	<?php if ( vce_get_option( 'show_share' ) ) : ?>
	  	<?php get_template_part('sections/share-bar'); ?>
	<?php endif; ?>

</article>