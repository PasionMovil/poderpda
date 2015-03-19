<?php get_header(); ?>

<div id="content" class="container site-content site-404">

	<div id="primary" class="vce-main-content">

		<main id="main" class="main-box main-box-single">
			<?php if($img = vce_get_option_media('404_img')): ?>
				<img src="<?php echo $img; ?>" />
			<?php endif; ?>

			<div class="entry-content page-content">
				<h4><?php echo __vce( '404_title'); ?></h4>
				<h1 class="entry-title"><?php echo __vce( '404_subtitle'); ?></h1>

				<p><?php echo __vce( '404_text'); ?></p>

				<?php 
					if(has_nav_menu('vce_404_menu')) {
							wp_nav_menu( array( 'theme_location' => 'vce_404_menu', 'menu' => 'vce_404_menu', 'menu_class' => 'vce-404-menu', 'menu_id' => 'vce_404_menu', 'container' => false ) );
					} 
				?>

			</div>

		</main>

	</div>



</div>

<?php get_footer(); ?>