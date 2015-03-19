<?php if ( has_nav_menu( 'vce_footer_menu' ) ) : ?>
	<?php wp_nav_menu( array( 'theme_location' => 'vce_footer_menu', 'menu' => 'vce_footer_menu', 'menu_class' => 'bottom-nav-menu', 'menu_id' => 'vce_footer_menu', 'container' => false, 'depth' => 1 ) ); ?>
<?php else: ?>
	<ul id="vce_footer_menu" class="bottom-nav-menu">
		<li>
			<a href="<?php echo admin_url( 'nav-menus.php' ); ?>"><?php _e( 'Click here to add footer navigation', THEME_SLUG ); ?></a>
		</li>
	</ul>
<?php endif; ?>