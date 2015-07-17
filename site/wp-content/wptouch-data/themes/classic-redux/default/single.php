<?php get_header(); ?>

<div id="content">
	<?php if ( wptouch_have_posts() ) { ?>
		<?php wptouch_the_post(); ?>

		<div id="title-area" class="box <?php if ( has_post_thumbnail() && classic_should_show_thumbnail() ) { echo 'show-thumbnails'; } ?>">
			<?php if ( classic_should_show_thumbnail() ) { ?>
			<div class="wptouch-icon-area">
				<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'large' ); ?>
			</div>
			<?php } ?>
			<h2 class="post-title"><?php the_title(); ?></h2>
			<div class="post-meta">
				<?php if ( classic_should_show_date() ) { ?>
					<div class="time"><i class="wptouch-icon-time"></i> <?php wptouch_the_time(); ?></div>
				<?php } if ( classic_should_show_author() ) { ?>
					<div class="author"><i class="wptouch-icon-user"></i> <?php echo sprintf( __( 'Written by %s', 'wptouch-pro' ), get_the_author() ); ?></div>
				<?php } ?>
			</div>
		</div>

		<div id="content-area" class="<?php wptouch_post_classes(); ?> box">
			<?php wptouch_the_content(); ?>
		</div>

		<?php get_template_part( 'related-posts' ); ?>
		<?php get_template_part( 'nav-bar' ); ?>

		<div id="comments">
			<?php comments_template(); ?>
		</div>

	<?php } ?>
</div>

<?php get_footer(); ?>