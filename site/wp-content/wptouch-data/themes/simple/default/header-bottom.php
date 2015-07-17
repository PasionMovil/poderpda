<!-- Back Button for Web-App Mode -->
<div class="wptouch-icon-arrow-left back-button tappable"><!-- css-button --></div>

	<?php if ( wptouch_has_menu( 'site_menu' ) ) { ?>
		<div id="menu" class="wptouch-menu show-hide-menu <?php simple_css_noise(); ?>">
			<?php wptouch_show_menu( 'site_menu' ); ?>
		</div>
	<?php } ?>

	<div class="page-wrapper <?php simple_css_noise(); ?>" style="background-image: url(<?php simple_get_background_image(); ?>);"><!-- .page-wrapper tag closed in foundation's footer.php -->

	<?php do_action( 'wptouch_advertising_top' ); ?>

	<div class="menu-bumper <?php simple_css_noise(); ?>">
		<?php if ( wptouch_has_menu( 'site_menu' ) ) { ?>
			<a href="javascript:return false;" class="toggle-button slide-toggle <?php simple_css_noise(); ?>" data-effect-target="menu">
				<?php __( 'Toggle Menu', 'wptouch-pro' ); ?>
			</a>
		<?php } ?>

		<?php if ( function_exists( 'wptouch_fdn_show_login' ) ) { ?>
			<?php if ( wptouch_fdn_show_login() ) { ?>
				<?php if ( !is_user_logged_in() ) { ?>
					<a href="#" class="<?php simple_css_noise(); ?> login-button login-toggle no-ajax" title="<?php _e( 'Login', 'wptouch-pro' ); ?>"></a>
				<?php } else { ?>
					<a href="<?php echo wp_logout_url( esc_url_raw( $_SERVER['REQUEST_URI'] ) ); ?>" class="login-button logout" title="<?php _e( 'Logout', 'wptouch-pro' ); ?>"></a>
				<?php } ?>
			<?php } ?>
		<?php } ?>
	</div>


	<div id="header-area">
		<a href="<?php wptouch_bloginfo( 'url' ); ?>">
			<?php if ( foundation_has_logo_image() ) { ?>
				<img src="<?php foundation_the_logo_image(); ?>" alt="logo image" />
			<?php } else { ?>
				<h1 class="heading-font"><?php wptouch_bloginfo( 'site_title' ); ?></h1>
			<?php } ?>
		</a>
	</div>

	<?php if ( is_home() || is_front_page() ) { // On homepage load the slider ?>
		<?php if ( function_exists( 'foundation_featured_slider' ) ) { ?>
			<?php foundation_featured_slider(); ?>
		<?php } ?>
	<?php } ?>