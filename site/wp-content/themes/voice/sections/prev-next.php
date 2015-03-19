<?php
	$in_same_cat = vce_get_option('prev_next_cat') ? true : false;
	$prev = get_previous_post($in_same_cat); 
	$next = get_next_post($in_same_cat);
?>
<nav class="prev-next-nav">
	<?php if($prev) : ?>
		<?php $img = vce_featured_image('vce-lay-b', $prev->ID); ?>

		<div class="vce-prev-link">
			<?php previous_post_link('%link','<span class="img-wrp">'.$img.'<span class="vce-pn-ico"><i class="fa fa fa-chevron-left"></i></span></span><span class="vce-prev-next-link">%title</span>', $in_same_cat); ?>
		</div>

	<?php endif; ?>
	
	<?php if($next) : ?>
		<?php $img = vce_featured_image('vce-lay-b', $next->ID); ?>

		<div class="vce-next-link">
			<?php next_post_link('%link','<span class="img-wrp">'.$img.'<span class="vce-pn-ico"><i class="fa fa fa-chevron-right"></i></span></span><span class="vce-prev-next-link">%title</span>', $in_same_cat); ?>
		</div>	
	<?php endif; ?>
</nav>