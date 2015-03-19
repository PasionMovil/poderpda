<?php $fa_args = vce_get_fa_args(); if ( !empty( $fa_args ) ) : ?>

<?php  extract( $fa_args ); ?>

	<?php if ( $use_fa ) : ?>
		<?php if ( $fa_posts->have_posts() ) : ?>

			<?php $i = 0; while ( $fa_posts->have_posts() ) : $fa_posts->the_post(); ?>

				<?php if ( $i == 0  && $full ) : ?>
					<?php  if ( $full_slider ): ?>
						<div class="vce-featured-full-slider">
					<?php endif; ?>

						<?php get_template_part( 'sections/loops/featured-full' ); ?>

				<?php endif; ?>


				<?php if ( ( $i == 1 && $both ) || ( $i == 0 && !$full ) ) : ?>
					<div id="vce-featured-grid" class="vce-featured-grid">
				<?php endif; ?>

				<?php
					if ( ( $i != 0 && $both ) || !$full ) {
						get_template_part( 'sections/loops/featured-grid' );
					} else if ( $i != 0 ) {
							get_template_part( 'sections/loops/featured-full' );
						}
					?>

				<?php if ( ( $i == count( $fa_posts->posts ) - 1 ) && $grid ) : ?>
					</div>
				<?php endif; ?>

				<?php if ( $full_slider && ( $i == count( $fa_posts->posts ) - 1 ) ): ?>
						</div>
					<?php endif; ?>

			<?php $i++; endwhile; ?>

			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	<?php endif; ?>

<?php endif; ?>
