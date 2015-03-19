
	<footer id="footer" class="site-footer">

		<?php if ( vce_get_option( 'footer_display' ) ) : ?>
		<div class="container">
			<div class="container-fix">
			<?php $footer_layout = explode( "_", vce_get_option( 'footer_layout' ) ); ?>
			<?php for ( $i = 0; $i < count( $footer_layout ); $i++ ) : ?>
				<div class="bit-<?php echo $footer_layout[$i]; ?>">
					<?php dynamic_sidebar( 'vce_footer_sidebar_'.($i+1) ); ?>
				</div>
			<?php endfor;?>
			</div>
		</div>
		<?php endif; ?>

		<?php if ( vce_get_option( 'enable_copyright' ) ) : ?>
			<div class="container-full site-info">
				<div class="container">
					<?php if($footer_bar_left = vce_get_option('footer_bar_left')): ?>
						<div class="vce-wrap-left">
							<?php get_template_part( 'sections/'.$footer_bar_left ); ?>
						</div>
					<?php endif; ?>

					<?php if($footer_bar_center = vce_get_option('footer_bar_center')): ?>
						<div class="vce-wrap-center">
							<?php get_template_part( 'sections/'.$footer_bar_center ); ?>
						</div>
					<?php endif; ?>

					<?php if($footer_bar_right = vce_get_option('footer_bar_right')): ?>
						<div class="vce-wrap-right">
							<?php get_template_part( 'sections/'.$footer_bar_right ); ?>
						</div>
					<?php endif; ?>				
				</div>
			</div>
		<?php endif; ?>


	</footer>


</div>
</div>

<?php if(vce_get_option('scroll_to_top')): ?>
<a href="javascript:void(0)" id="back-top"><i class="fa fa-angle-up"></i></a>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>