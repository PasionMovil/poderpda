<?php  if(get_next_posts_link() || get_previous_posts_link()) : ?>
<nav id="vce-pagination">
	<div class="vce-next">
		<?php previous_posts_link(__vce('newer_entries')); ?>
	</div>
	<div class="vce-prev">
		<?php next_posts_link(__vce('older_entries')); ?>
	</div>
</nav>
<?php endif; ?>