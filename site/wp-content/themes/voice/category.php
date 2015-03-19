<?php

get_header(); ?>

<?php get_template_part( 'sections/featured-area'); ?>

<div id="content" class="container site-content">

	<?php global $vce_sidebar_opts; ?>
	<?php if ( $vce_sidebar_opts['use_sidebar'] == 'left' ) { get_sidebar(); } ?>

	<div id="primary" class="vce-main-content">

		<div class="main-box">

		<?php get_template_part( 'sections/archive-title' ); ?>

			<div class="main-box-inside">

			<?php if ( have_posts() ) : ?>

				<?php $cat_posts = vce_get_category_layout(); ?>

				<?php $i = 0; while ( have_posts() ) : the_post(); $i++;?>
					
					<?php echo vce_loop_wrap_div($cat_posts, $i, count( $wp_query->posts )); ?>

						<?php get_template_part( 'sections/loops/layout-'.vce_module_layout($cat_posts, $i) ); ?>

					<?php if ( $i == ( count( $wp_query->posts ) ) ) : ?>
						</div>
					<?php endif;?>

				<?php endwhile; ?>

				<?php get_template_part( 'sections/pagination/'.vce_get_category_pagination() ); ?>

			<?php else: ?>
					
				<?php get_template_part( 'sections/content-none'); ?>

			<?php endif; ?>

			</div>

		</div>

	</div>

	<?php if ( $vce_sidebar_opts['use_sidebar'] == 'right' ) { get_sidebar(); } ?>

</div>

<?php get_footer(); ?>
