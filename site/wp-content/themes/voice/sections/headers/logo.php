<div class="vce-res-nav">
	<a class="vce-responsive-nav" href="#sidr-main"><i class="fa fa-bars"></i></a>
</div>
<div class="site-branding">
	<?php 
		$logo_url = vce_get_option('logo_custom_url') ? esc_url(vce_get_option('logo_custom_url')) : home_url( '/' ); 
		$logo = vce_get_option('logo')
	?>
	
	<?php 
		$title_tag = is_front_page() ? 'h1' : 'span';
		$class = !empty($logo['url']) ? 'class="has-logo"' : '';
	?>

	<<?php echo $title_tag;?> class="site-title">
		<a href="<?php echo esc_url( $logo_url ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" <?php echo $class; ?>><?php if(!empty($logo['url'])) : ?><img src="<?php echo $logo['url']; ?>" alt="<?php bloginfo( 'name' ); ?>" /><?php else: ?><?php bloginfo( 'name' ); ?><?php endif; ?></a>
	</<?php echo $title_tag;?>>

<?php if (vce_get_option('header_description')) { ?><span class="site-description"><?php echo get_bloginfo('description'); ?></span>	
<?php } ?>	

</div>