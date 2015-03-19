<?php 

/*-----------------------------------------------------------------------------------*/
/*	Include functions to handle ajax calls
/*-----------------------------------------------------------------------------------*/

/* Generate mega menu posts */
if(!function_exists('vce_generate_mega_menu_content')):
function vce_generate_mega_menu_content(){
	
	if(isset($_POST['cat'])){
		$cat = absint($_POST['cat']);

		$args['post_type'] = 'post';
		$args['post_status'] = 'publish';
		$args['cat'] = $cat;
		$args['posts_per_page'] = 5;

		$q = new WP_Query($args);

		?>
		<?php if($q->have_posts()) : ?>
			<?php while($q->have_posts()) : $q->the_post(); ?>
				<?php get_template_part('sections/loops/mega-menu'); ?>
			<?php endwhile; ?>
		<?php endif; ?>
	
<?php }
	die();
}
endif;

add_action('wp_ajax_nopriv_vce_mega_menu', 'vce_generate_mega_menu_content');
add_action('wp_ajax_vce_mega_menu', 'vce_generate_mega_menu_content');


/* Update latest theme version (we use internally for new version introduction text) */

if(!function_exists('vce_update_version')):
function vce_update_version(){
	update_option('vce_theme_version',THEME_VERSION);
	die();
}
endif;

add_action('wp_ajax_vce_update_version', 'vce_update_version');

/* Update latest theme version */

if(!function_exists('vce_hide_welcome')):
function vce_hide_welcome(){
	update_option('vce_welcome_box_displayed', true);
	die();
}
endif;

add_action('wp_ajax_vce_hide_welcome', 'vce_hide_welcome');


?>