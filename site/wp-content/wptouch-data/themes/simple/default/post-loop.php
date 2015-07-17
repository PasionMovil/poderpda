<a href="<?php the_permalink(); ?>" class="post-head" style="background-image: url(<?php simple_full_image_url(); ?>);">
	<!-- This is intentionally H2 for the blog page -->
	<h2><?php the_title(); ?></h2>
	<p><span class="date"><?php echo date_i18n( get_option( 'date_format' ), get_the_time( 'U' ) ); ?></p>
	<!-- <p><a href="<?php the_permalink(); ?>">Read This Post</a></p> -->
</a>
<div class="content">
	<?php the_excerpt(); ?>
	<p><a href="<?php the_permalink(); ?>"><?php _e( 'Read This Post &rsaquo;', 'wptouch-pro' ); ?></a></p>

</div>

<?php /* <!-- simple post loop -->
<div class="post-meta">
	<?php wptouch_the_time(); ?> // <?php the_author(); ?>
</div>

<h2 class="post-title heading-font">
	<a href="<?php wptouch_the_permalink(); ?>"><?php the_title(); ?></a>
</h2>

<div class="post-content">
	<?php if ( is_home() ) { ?>
		<?php wptouch_the_excerpt(); ?>
	<?php } else { ?>
		<?php wptouch_the_content(); ?>
	<?php } ?>
</div> */ ?>