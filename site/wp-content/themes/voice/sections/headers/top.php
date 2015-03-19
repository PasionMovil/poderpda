<div class="top-header">
	<div class="container">

		<?php if($top_bar_left = vce_get_option('top_bar_left')): ?>
			<div class="vce-wrap-left">
				<?php get_template_part( 'sections/'.$top_bar_left ); ?>
			</div>
		<?php endif; ?>

		<?php if($top_bar_center = vce_get_option('top_bar_center')): ?>
			<div class="vce-wrap-center">
				<?php get_template_part( 'sections/'.$top_bar_center ); ?>
			</div>
		<?php endif; ?>

		<?php if($top_bar_right = vce_get_option('top_bar_right')): ?>
			<div class="vce-wrap-right">
				<?php get_template_part( 'sections/'.$top_bar_right ); ?>
			</div>
		<?php endif; ?>

	</div>
</div>