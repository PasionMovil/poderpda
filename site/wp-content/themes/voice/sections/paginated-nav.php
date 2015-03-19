<div class="vce-link-pages">
		<?php global $page, $numpages; ?>
		<span class="vce-paginated-num"><?php printf(__vce( 'page_of' ), $page, $numpages); ?></span>
		<?php if($page == 1) : ?>
			<?php echo _wp_link_page( $numpages ).__vce( 'prev_page' ).'</a>'; ?>
		<?php endif; ?>
		<?php wp_link_pages(array('before' => '', 'after' => '', 'next_or_number' => 'next', 'nextpagelink'     => __vce( 'next_page' ),
		'previouspagelink' => __vce( 'prev_page' ))); ?>
		<?php if($page == $numpages) : ?>
			<?php echo _wp_link_page( 1 ).__vce( 'next_page' ).'</a>'; ?>
		<?php endif; ?>
</div>