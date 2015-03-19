<?php
/*-----------------------------------------------------------------------------------*/
/*	Register Theme Sidebars
/*-----------------------------------------------------------------------------------*/

function vce_register_sidebars() {
	/* Default Sidebar */

	register_sidebar(
		array(
			'id' => 'vce_default_sidebar',
			'name' => __( 'Default Sidebar', THEME_SLUG ),
			'description' => __( 'This is default sidebar.', THEME_SLUG ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>'
		)
	);

	/* Default Sticky Sidebar */
	register_sidebar(
		array(
			'id' => 'vce_default_sticky_sidebar',
			'name' => __( 'Default Sticky Sidebar', THEME_SLUG ),
			'description' => __( 'This is default sticky sidebar. Sticky means that it will be always pinned to top while you are scrolling through your website content.', THEME_SLUG ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>'
		)
	);

	/* Add sidebars from theme options */

	$custom_sidebars = vce_get_option( 'add_sidebars' );

	if ( $custom_sidebars ) {
		for ( $i = 1; $i <= $custom_sidebars; $i++ ) {
			register_sidebar(
				array(
					'id' => 'vce_sidebar_'.$i,
					'name' => __( 'Sidebar', THEME_SLUG ).' '.$i,
					'description' => '',
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h4 class="widget-title"><span>',
					'after_title' => '</span></h4>'
				)
			);
		}
	}



	/* Footer Sidebar Area 1*/
	register_sidebar(
		array(
			'id' => 'vce_footer_sidebar_1',
			'name' => __( 'Footer Column 1', THEME_SLUG ),
			'description' => __( 'This is sidebar to use in footer area column 1.', THEME_SLUG ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>'
		)
	);

	/* Footer Sidebar Area 2*/
	register_sidebar(
		array(
			'id' => 'vce_footer_sidebar_2',
			'name' => __( 'Footer Column 2', THEME_SLUG ),
			'description' => __( 'This is sidebar to use in footer area column 2.', THEME_SLUG ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>'
		)
	);


	/* Footer Sidebar Area 1*/
	register_sidebar(
		array(
			'id' => 'vce_footer_sidebar_3',
			'name' => __( 'Footer Column 3', THEME_SLUG ),
			'description' => __( 'This is sidebar to use in footer area column 3.', THEME_SLUG ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>'
		)
	);

}



?>
