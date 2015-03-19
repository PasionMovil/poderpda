<?php global $vce_sidebar_opts; ?>
<aside id="sidebar" class="sidebar <?php echo $vce_sidebar_opts['use_sidebar']; ?>">
	<?php
		if(is_active_sidebar($vce_sidebar_opts['sidebar'])){
				dynamic_sidebar($vce_sidebar_opts['sidebar']);
		}

		if(is_active_sidebar($vce_sidebar_opts['sticky_sidebar'])){
			echo '<div class="vce-sticky">';
				dynamic_sidebar($vce_sidebar_opts['sticky_sidebar']);
			echo '</div>';
		}
	?>
</aside>