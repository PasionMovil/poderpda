<?php get_header(); ?>

	<div id="content">
		<?php while ( wptouch_have_posts() ) { ?>

			<?php wptouch_the_post(); ?>

			<div class="<?php wptouch_post_classes(); ?>">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="post-head" style="background-image: url(<?php simple_full_image_url(); ?>);">
						<!-- This is intentionally H2 for the blog page -->
						<h2><?php the_title(); ?></h2>
						<p><span class="date"><?php echo date_i18n( get_option( 'date_format' ), get_the_time( 'U' ) ); ?></span></p>
						<!-- <p><a href="<?php the_permalink(); ?>">Read This Post</a></p> -->
					</div>

					<div class="content">
						<?php the_content(); ?>
					</div>
				</article>
			</div>

		<?php } ?>
	</div> <!-- content -->

	<?php get_template_part( 'related-posts' ); ?>
	<?php get_template_part( 'nav-bar' ); ?>

	<?php if ( comments_open() || wptouch_have_comments() ) { ?>
		<div id="comments">
			<?php comments_template(); ?>
		</div>
	<?php } ?>

<?php get_footer(); ?>