<?php get_header(); ?>

<div id="content" class="container site-content">

	<?php global $vce_sidebar_opts; ?>
	<?php if ( $vce_sidebar_opts['use_sidebar'] == 'left' ) { get_sidebar(); } ?>

	<div id="primary" class="vce-main-content">

		<main id="main" class="main-box main-box-single">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'sections/content',get_post_format()); ?>

		<?php endwhile; ?>

		<?php if(vce_get_option('show_prev_next')) : ?>
			<?php get_template_part('sections/prev-next'); ?>
		<?php endif; ?>

		</main>

		<?php if(vce_get_option('show_author_box') && vce_get_option('author_box_position') == 'up') : ?>
			<?php get_template_part('sections/author-box'); ?>
		<?php endif; ?>

		<?php if(vce_get_option('show_related')) : ?>
			<?php get_template_part('sections/related-box'); ?>
		<?php endif; ?>

        <!-- SEO Tags -->
        <?php seoqueries_get_page_terms($plain_text = false); ?>

		<?php if(vce_get_option('show_author_box') && vce_get_option('author_box_position') == 'down') : ?>
			<?php get_template_part('sections/author-box'); ?>
		<?php endif; ?>

		<?php comments_template(); ?>

	</div>

	<?php if ( $vce_sidebar_opts['use_sidebar'] == 'right' ) { get_sidebar(); } ?>

</div>

<?php get_footer(); ?>
