<?php get_header(); ?>

<div id="content" class="container site-content">

	<?php global $vce_sidebar_opts; ?>
	<?php if ( $vce_sidebar_opts['use_sidebar'] == 'left' ) { get_sidebar(); } ?>

	<div id="primary" class="vce-main-content">

		<main id="main" class="main-box main-box-single">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'sections/content', 'page' ); ?>

		<?php endwhile; ?>

		</main>

		<?php if ( vce_get_option( 'page_show_comments' ) ) : ?>
			<?php comments_template(); ?>
		<?php endif; ?>

	</div>

	<?php if ( $vce_sidebar_opts['use_sidebar'] == 'right' ) { get_sidebar(); } ?>

</div>

<?php get_footer(); ?>