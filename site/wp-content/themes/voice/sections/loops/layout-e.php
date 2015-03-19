<article <?php post_class( 'vce-post vce-lay-e' ); ?>>

	<?php if ( $fimage = vce_featured_image( 'vce-lay-d' ) ): ?>
	 	<div class="meta-image">
			<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
				<?php echo $fimage; ?>
				<?php if ( $icon = vce_post_format_icon( 'lay_e' ) ) :?>
					<span class="vce-format-icon">
					<i class="fa <?php echo $icon; ?>"></i>
					</span>
				<?php endif; ?>
			</a>
		</div>
	<?php endif; ?>

	<?php if ( vce_get_option( 'lay_e_title' ) ) : ?>
		<header class="entry-header">
			<h2 class="entry-title"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo vce_get_title( 'lay-e' ); ?></a></h2>
		</header>
	<?php endif; ?>

</article>
