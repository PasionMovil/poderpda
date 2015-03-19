<?php
/*-----------------------------------------------------------------------------------*/
/*	Add simple solution for mega menu in navigation menus
/*-----------------------------------------------------------------------------------*/

/* Add custom fields to menu */
if ( !function_exists( 'vce_add_custom_nav_fields' ) ):
function vce_add_custom_nav_fields( $menu_item ) {
	$menu_item->mega_menu_cat = get_post_meta( $menu_item->ID, '_vce_mega_menu_cat', true ) ? 1 : 0;
	$menu_item->mega_menu = get_post_meta( $menu_item->ID, '_vce_mega_menu', true ) ? 1 : 0;
	return $menu_item;
}
endif;

add_filter( 'wp_setup_nav_menu_item', 'vce_add_custom_nav_fields' );

/* Save custom fiedls to menu */
if ( !function_exists( 'vce_update_custom_nav_fields' ) ):
function vce_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {

	if ( $args['menu-item-object'] == 'category' ) {
		$value = isset( $_REQUEST['menu-item-mega-menu-cat'][$menu_item_db_id] ) ? 1 : 0;
		update_post_meta( $menu_item_db_id, '_vce_mega_menu_cat', $value );
	} else {
		$value = isset( $_REQUEST['menu-item-mega-menu'][$menu_item_db_id] ) ? 1 : 0;
		update_post_meta( $menu_item_db_id, '_vce_mega_menu', $value );
	}
}
endif;

add_action( 'wp_update_nav_menu_item', 'vce_update_custom_nav_fields', 10, 3 );


/* Edit nav menu walker */
if ( !function_exists( 'vce_edit_menu_walker' ) ):
function vce_edit_menu_walker( $walker, $menu_id ) {

	class vce_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit {

		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$temp_output = '';
			$mega_menu_html = '';

			if ( $item->object == 'category' ) {
				$mega_menu_html .= '<p class="field-custom description description-wide">
		                <label for="edit-menu-item-mega-'.$item->db_id.'">
		        		<input type="checkbox" id="edit-menu-item-mega-'.$item->db_id.'" class="widefat code edit-menu-item-custom" name="menu-item-mega-menu-cat['.$item->db_id.']" value="1" '.checked( $item->mega_menu_cat, 1, false ). ' />
		                '.__( 'Mega Menu (display posts from category)', THEME_SLUG ).'</label>
		            </p>';
			} else {
				$mega_menu_html .= '<p class="field-custom description description-wide">
		                <label for="edit-menu-item-mega-'.$item->db_id.'">
		        		<input type="checkbox" id="edit-menu-item-mega-'.$item->db_id.'" class="widefat code edit-menu-item-custom" name="menu-item-mega-menu['.$item->db_id.']" value="1" '.checked( $item->mega_menu, 1, false ). ' />
		                '.__( 'Mega Menu (classic)', THEME_SLUG ).'
		            </label></p>';
			}

			parent::start_el( $temp_output, $item, $depth, $args, $id );

			$temp_output = preg_replace( '/(?=<div.*submitbox)/', $mega_menu_html, $temp_output );

			$output .= $temp_output;
		}

	}

	return 'vce_Walker_Nav_Menu_Edit';
}
endif;


add_filter( 'wp_edit_nav_menu_walker', 'vce_edit_menu_walker', 10, 2 );


/* Add class to menu category item when mega menu is detected */
if ( !function_exists( 'vce_add_class_to_menu' ) ):
function vce_add_class_to_menu( $classes, $item ) {

	if ( $item->object == 'category' && !$item->menu_item_parent && isset( $item->mega_menu_cat ) && $item->mega_menu_cat ) {
		$classes[] = 'vce-mega-cat';
	}

	if ( $item->object == 'category') {
		$classes[] = 'vce-cat-'.$item->object_id;
	}

	if(!$item->menu_item_parent && isset( $item->mega_menu ) && $item->mega_menu){
		$classes[] = 'vce-mega-menu';
	}

	return $classes;

}
endif;

add_filter( 'nav_menu_css_class', 'vce_add_class_to_menu', 10, 2 );


/* Add category id to category link with mega menu enabled */
if ( !function_exists( 'vce_nav_link_atts' ) ):
function vce_nav_link_atts( $atts, $item, $args ) {
    
    if ( $item->object == 'category' && !$item->menu_item_parent && isset( $item->mega_menu_cat ) && $item->mega_menu_cat ) {
		$atts['data-mega_cat_id'] = $item->object_id;
	}
    return $atts;
}
endif;

add_filter( 'nav_menu_link_attributes', 'vce_nav_link_atts', 10, 3 );

?>
