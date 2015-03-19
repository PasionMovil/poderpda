<?php

/*-----------------------------------------------------------------------------------*/
/*	Register Menus
/*-----------------------------------------------------------------------------------*/

if( !function_exists( 'vce_register_menus' ) ) :
    function vce_register_menus() {
	    register_nav_menu('vce_main_navigation_menu', __( 'Main Navigation' , THEME_SLUG));
	    register_nav_menu('vce_top_navigation_menu', __( 'Top Menu' , THEME_SLUG));
	   	register_nav_menu('vce_social_menu', __( 'Social menu' , THEME_SLUG));
	    register_nav_menu('vce_footer_menu', __( 'Footer Menu' , THEME_SLUG));
	    register_nav_menu('vce_404_menu', __( '404 Menu' , THEME_SLUG));
    }
endif;

?>