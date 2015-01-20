<?php
//inicia agregado para quitar hotwords
function adios_hotwords() {
    add_meta_box( 'hotwordsno', 'Hotwords', 'sin_hotwords', 'post' );
} 
add_action( 'add_meta_boxes', 'adios_hotwords' );

function sin_hotwords( $post ) { 
    wp_nonce_field( basename( __FILE__ ), 'example_nonce' );
    $example_stored_meta = get_post_meta( $post->ID );
?>
<p>
    <span>Marca la casilla para desactivar hotwords en este post tambien elimina adsense dentro del post</span>
    <div>
        <label for="quita-hotw">
            <input type="checkbox" name="quita-hotw" id="quita-hotw" value="yes" <?php checked( $example_stored_meta['quita-hotw'][0], 'yes' ); ?> />
            Eliminar Hotwords de este post
        </label>
    </div>
</p>
<?php
    echo 'Dudas <a href="http://twitter.com/davidmirandaz" target="_blank">@DavidMirandaZ</a>'; 
}
function sin_hotwords_save( $post_id ) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'quita-hotw' ] ) && wp_verify_nonce( $_POST[ 'quita-hotw' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
if( isset( $_POST[ 'quita-hotw' ] ) ) {
    update_post_meta( $post_id, 'quita-hotw', 'yes' );
	} else {
	    update_post_meta( $post_id, 'quita-hotw', '' );
	} 
}
add_action( 'save_post', 'sin_hotwords_save' );
//termina agregado para quitar hotwords
?>
<?php 

if ( !function_exists( 'optionsframework_init' ) ) {

/*-----------------------------------------------------------------------------------*/
/* Options Framework Theme
/*-----------------------------------------------------------------------------------*/


/* Set the file path based on whether the Options Framework Theme is a parent theme or child theme */

if ( get_stylesheet_directory() == get_template_directory() ) {
	define('OPTIONS_FRAMEWORK_URL', get_template_directory() . '/admin/');
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/');
} else {
	define('OPTIONS_FRAMEWORK_URL', get_template_directory() . '/admin/');
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/');
}

require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');

}

/*  Add a custom script to the admin panel */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('.section.hidden').fadeToggle(400);
	});
	
	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('.section.hidden').show();
	}
	
});
</script>

<?php
}

/*-----------------------------------------------------------------------------------*/
/* Add Theme Shortcodes
/*-----------------------------------------------------------------------------------*/
include("functions/shortcodes.php");

/*-----------------------------------------------------------------------------------*/
/* Add Multiple Thumbnail Support
/*-----------------------------------------------------------------------------------*/
include("functions/multi-post-thumbnails.php");

/*-----------------------------------------------------------------------------------*/
/* Add Theme Functions
/*-----------------------------------------------------------------------------------*/
include("functions/extra-functions.php");

/*-----------------------------------------------------------------------------------*/
/* Localize Wordpress Ajax
/*-----------------------------------------------------------------------------------*/

function ag_ajax()
{
     wp_localize_script( 'function', 'ag_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

add_action('template_redirect', 'ag_ajax');

/*-----------------------------------------------------------------------------------*/
/* Register Widget Sidebars
/*-----------------------------------------------------------------------------------*/

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Top Area',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div><div class="clear"></div>',
		'before_title' => '<h4 style="display:none;">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'name' => 'Home Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div><div class="clear"></div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'name' => 'Blog Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div><div class="clear"></div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'name' => 'Single Post Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div><div class="clear"></div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'name' => 'Page Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div><div class="clear"></div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'name' => 'Contact Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div><div class="clear"></div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	));
		
	register_sidebar(array( 
		'name' => 'Footer Left',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div><div class="clear"></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	
	register_sidebar(array( 
		'name' => 'Footer Center',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div><div class="clear"></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	
	register_sidebar(array( 
		'name' => 'Footer Right',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div><div class="clear"></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	
}

/*-----------------------------------------------------------------------------------*/
/*	Add Widget Shortcode Support
/*-----------------------------------------------------------------------------------*/

add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');

// Add the News Custom Widget
include("functions/widget-news.php");
// Add the Twitter Custom Widget
include("functions/widget-twitter.php");
// Add the Contact Custom Widget
include("functions/widget-contact.php");
// Add the Social Counter Custom Widget
include("functions/widget-counter.php");
// Add the Social Counter Tabs Widget
include("functions/widget-tab.php");
// Add the Ad Wigdets
include("functions/widget-ad125.php");
include("functions/widget-ad480.php");
// Add the Custom Fields for Video Posts
include("functions/customfields.php");

/*-----------------------------------------------------------------------------------*/
/*	Include Update Notifier
/*-----------------------------------------------------------------------------------*/
include("functions/update_notifier.php");

/*-----------------------------------------------------------------------------------*/
/*	Register and load common JS
/*-----------------------------------------------------------------------------------*/

function ag_register_js() {
	if (!is_admin()) {
		
		wp_register_script('custom', get_template_directory_uri() . '/js/custom.js', 'jquery', '1.3.4', true);

		wp_enqueue_script('jquery');
		wp_enqueue_script('custom');
	}
}
add_action('init', 'ag_register_js');

/*-----------------------------------------------------------------------------------*/
/*	Register Stylesheets
/*-----------------------------------------------------------------------------------*/
function ag_register_iecss () {
	if (!is_admin()) {
		global $wp_styles;
		wp_enqueue_style(  "ie7",  get_template_directory_uri() . "/css/ie7.css", false, 'ie7', "all");
		wp_enqueue_style(  "ie8",  get_template_directory_uri() . "/css/ie8.css", false, 'ie8', "all");
		$wp_styles->add_data( "ie7", 'conditional', 'IE 7' );
		$wp_styles->add_data( "ie8", 'conditional', 'IE 8' );
	}
}
add_action('init', 'ag_register_iecss');


function custom_enqueue_css() {
	wp_register_style('options', get_template_directory_uri() . '/css/custom.css', 'style');
	wp_enqueue_style( 'options');
}
add_action('wp_print_styles', 'custom_enqueue_css');

/*-----------------------------------------------------------------------------------*/
/* Register Navigation 
/*-----------------------------------------------------------------------------------*/

add_theme_support('menus');

if ( function_exists( 'register_nav_menus' ) ) {
    register_nav_menus(
        array(
          'main_nav_menu' => 'Main Navigation Menu'
        )
    );
      register_nav_menus(
        array(
          'top_nav_menu' => 'Top Bar Navigation Menu'
        )
    );

	// remove menu container div
	function my_wp_nav_menu_args( $args = '' ) {
	    $args['container'] = false;
	    return $args;
	} 
	add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );

}

/*-----------------------------------------------------------------------------------*/
/*	Change Default Excerpt Length
/*-----------------------------------------------------------------------------------*/

function ag_excerpt_length($length) {
	return 15; 
}
add_filter('excerpt_length', 'ag_excerpt_length');

/*-----------------------------------------------------------------------------------*/
/*	Set Max Content Width (use in conjuction with ".blogpost .featuredimage img" css)
/*-----------------------------------------------------------------------------------*/

if ( ! isset( $content_width ) ) $content_width = 620;

/*-----------------------------------------------------------------------------------*/
/*	Automatic Feed Links
/*-----------------------------------------------------------------------------------*/

if(function_exists('add_theme_support')) {
    add_theme_support('automatic-feed-links');
    //WP Auto Feed Links
}

/*-----------------------------------------------------------------------------------*/
/*	Configure Excerpt String, Remove Automatic Periods
/*-----------------------------------------------------------------------------------*/

function ag_excerpt_more($excerpt) {
	return str_replace('[...]', '...', $excerpt); 
}
add_filter('wp_trim_excerpt', 'ag_excerpt_more');

/*------------------------------------------------------------------------------*/
/*	Remove More Link Anchor
/*------------------------------------------------------------------------------*/

function remove_more_jump_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}

add_filter('the_content_more_link', 'remove_more_jump_link');


/*-----------------------------------------------------------------------------------*/
/*	Add Browser Detection Body Class
/*-----------------------------------------------------------------------------------*/

add_filter('body_class','ag_browser_body_class');
function ag_browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}


/*-----------------------------------------------------------------------------------*/
/*	Configure WP2.9+ Thumbnails
/*-----------------------------------------------------------------------------------*/

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 56, 56, true ); // Normal post thumbnails
	add_image_size( 'blog', 314, 160, true ); // Blog thumbnail
	add_image_size( 'blogonecol', 420, 215, true ); // Blog One Column thumbnail
	add_image_size( 'tinyfeatured', 50, 50, true ); // Tiny Featured thumbnail
	add_image_size( 'smallrecfeatured', 320, 158, true ); // Small Rectangle Featured thumbnail
	add_image_size( 'smallrecfeaturedindex', 358, 158, true ); // Small Rectangle Featured thumbnail
	add_image_size( 'smallfeatured', 320, 316, true ); // Small Featured thumbnail	
	add_image_size( 'largefeatured', 642, 316, true ); // Large Featured thumbnail
	add_image_size( 'post', 700, 325, true ); // Portfolio Large thumbnail
	add_image_size( 'postnc', 700, '', false ); // Portfolio Large thumbnail
}

if (class_exists('MultiPostThumbnails')) { 

   if ( $thumbnum = of_get_option('of_thumbnail_number') ) { $thumbnum = ($thumbnum + 1); } else { $thumbnum = 7;}
   $counter1 = 2;

	while ($counter1 < ($thumbnum)) {

		switch ($counter1) {
			case (2) : $countername = 'second'; break;
			case (3) : $countername = 'third'; break;
			case (4) : $countername = 'fourth'; break;
			case (5) : $countername = 'fifth'; break;
			case (6) : $countername = 'sixth'; break;
			default : $countername = $counter1;
		}
		
	new MultiPostThumbnails( 
		array( 
			'label' => 'Slide ' . $counter1, 
			'id' => $countername . '-slide', 
			'post_type' => 'post' 
		));
	
	$counter1++;
	
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Comment Reply Javascript Action
/*-----------------------------------------------------------------------------------*/

function mytheme_enqueue_comment_reply() {
    // on single blog post pages with comments open and threaded comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { 
        // enqueue the javascript that performs in-link comment reply fanciness
        wp_enqueue_script( 'comment-reply' ); 
    }
}
// Hook into wp_enqueue_scripts
add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_comment_reply' );

/*------------------------------------------------------------------------------*/
/*	Comments Template
/*------------------------------------------------------------------------------*/

function ag_comment($comment, $args, $depth) {

    $isByAuthor = false;

    if($comment->comment_author_email == get_the_author_meta('email')) {
        $isByAuthor = true;
    }

    $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
   <div id="comment-<?php comment_ID(); ?>" class="singlecomment">
        <p class="commentsmetadata">
        	<cite><?php comment_date('F j, Y'); ?></cite>
        </p>
    	<div class="author">
            <div class="reply"><?php echo comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth'])); ?></div>
            <div class="name"><?php comment_author_link() ?></div>
        </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <p class="moderation"><?php _e('Your comment is awaiting moderation.', 'framework') ?></p>
      <?php endif; ?>
        <div class="commenttext">
            <?php comment_text() ?>
        </div>
	</div>
<?php
}


/*-----------------------------------------------------------------------------------*/
/*	Load Text Domain
/*-----------------------------------------------------------------------------------*/

function theme_init(){
    load_theme_textdomain('framework', get_template_directory() . '/lang');
}
add_action ('init', 'theme_init');

/*-----------------------------------------------------------------------------------*/
/*	Add Shortcode Buttons to WYSIWIG
/*-----------------------------------------------------------------------------------*/

add_action('init', 'add_ag_shortcodes');  

function add_ag_shortcodes() {  
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
   {  
   
   	 //Add "button" button
     add_filter('mce_external_plugins', 'add_plugin_button');  
     add_filter('mce_buttons', 'register_button');  
	 
     //Add "divider" button
     add_filter('mce_external_plugins', 'add_plugin_divider');  
     add_filter('mce_buttons', 'register_divider'); 

     //Add "slider" button
     add_filter('mce_external_plugins', 'add_plugin_slider');  
     add_filter('mce_buttons', 'register_slider');  
     
	 //Add "tabs" button
     add_filter('mce_external_plugins', 'add_plugin_featuredfulltabs');  
     add_filter('mce_buttons', 'register_featuredfulltabs');   
	 
	 //Add "lightbox" button
     add_filter('mce_external_plugins', 'add_plugin_lightbox');  
     add_filter('mce_buttons', 'register_lightbox');  
	 
	 //Add "shortcodes" buttons - 3rd row
	 
	 add_filter('mce_external_plugins', 'add_plugin_onehalf');  
     add_filter('mce_buttons_3', 'register_onehalf'); 
	 
	 add_filter('mce_external_plugins', 'add_plugin_onehalflast');  
     add_filter('mce_buttons_3', 'register_onehalflast'); 
	 
	 add_filter('mce_external_plugins', 'add_plugin_onethird');  
     add_filter('mce_buttons_3', 'register_onethird'); 
	 
	 add_filter('mce_external_plugins', 'add_plugin_onethirdlast');  
     add_filter('mce_buttons_3', 'register_onethirdlast');
	 
	 add_filter('mce_external_plugins', 'add_plugin_twothird');  
     add_filter('mce_buttons_3', 'register_twothird'); 
	 
	 add_filter('mce_external_plugins', 'add_plugin_twothirdlast');  
     add_filter('mce_buttons_3', 'register_twothirdlast'); 
	 
	 add_filter('mce_external_plugins', 'add_plugin_onefourth');  
     add_filter('mce_buttons_3', 'register_onefourth'); 
	 
	 add_filter('mce_external_plugins', 'add_plugin_onefourthlast');  
     add_filter('mce_buttons_3', 'register_onefourthlast');
	 
	 add_filter('mce_external_plugins', 'add_plugin_threefourth');  
     add_filter('mce_buttons_3', 'register_threefourth'); 
	 
	 add_filter('mce_external_plugins', 'add_plugin_threefourthlast');  
     add_filter('mce_buttons_3', 'register_threefourthlast');
	 
	 add_filter('mce_external_plugins', 'add_plugin_onefifth');  
     add_filter('mce_buttons_3', 'register_onefifth'); 
	 
	 add_filter('mce_external_plugins', 'add_plugin_onefifthlast');  
     add_filter('mce_buttons_3', 'register_onefifthlast');
	 
	 add_filter('mce_external_plugins', 'add_plugin_twofifth');  
     add_filter('mce_buttons_3', 'register_twofifth'); 
	 
	 add_filter('mce_external_plugins', 'add_plugin_twofifthlast');  
     add_filter('mce_buttons_3', 'register_twofifthlast');
	 
	 add_filter('mce_external_plugins', 'add_plugin_threefifth');  
     add_filter('mce_buttons_3', 'register_threefifth'); 
	 
	 add_filter('mce_external_plugins', 'add_plugin_threefifthlast');  
     add_filter('mce_buttons_3', 'register_threefifthlast');
	 
	 add_filter('mce_external_plugins', 'add_plugin_fourfifth');  
     add_filter('mce_buttons_3', 'register_fourfifth'); 
	 
	 add_filter('mce_external_plugins', 'add_plugin_fourfifthlast');  
     add_filter('mce_buttons_3', 'register_fourfifthlast');
	 
	 add_filter('mce_external_plugins', 'add_plugin_onesixth');  
     add_filter('mce_buttons_3', 'register_onesixth'); 
	 
	 add_filter('mce_external_plugins', 'add_plugin_onesixthlast');  
     add_filter('mce_buttons_3', 'register_onesixthlast');
	 
	 add_filter('mce_external_plugins', 'add_plugin_fivesixth');  
     add_filter('mce_buttons_3', 'register_fivesixth'); 
	 
	 add_filter('mce_external_plugins', 'add_plugin_fivesixthlast');  
     add_filter('mce_buttons_3', 'register_fivesixthlast');
	 
   }  
}  

function register_button($buttons) {  
   array_push($buttons, "button");  
   return $buttons;  
} 
function add_plugin_button($plugin_array) {  
   $plugin_array['button'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}  
function register_divider($buttons) {  
   array_push($buttons, "divider");  
   return $buttons;  
}
function add_plugin_divider($plugin_array) {  
   $plugin_array['divider'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}
function register_slider($buttons) {  
   array_push($buttons, "slider");  
   return $buttons;  
}
function add_plugin_slider($plugin_array) {  
   $plugin_array['slider'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}
function register_featuredfulltabs($buttons) {  
   array_push($buttons, "featuredfulltabs");  
   return $buttons;  
}
function add_plugin_featuredfulltabs($plugin_array) {  
   $plugin_array['featuredfulltabs'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}
function register_lightbox($buttons) {  
   array_push($buttons, "lightbox");  
   return $buttons;  
}
function add_plugin_lightbox($plugin_array) {  
   $plugin_array['lightbox'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

function register_onehalf($buttons) {  
   array_push($buttons, "onehalf");  
   return $buttons;  
}
function add_plugin_onehalf($plugin_array) {  
   $plugin_array['onehalf'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

function register_onehalflast($buttons) {  
   array_push($buttons, "onehalflast");  
   return $buttons;  
}
function add_plugin_onehalflast($plugin_array) {  
   $plugin_array['onehalflast'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

function register_onethird($buttons) {  
   array_push($buttons, "onethird");  
   return $buttons;  
}
function add_plugin_onethird($plugin_array) {  
   $plugin_array['onethird'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

function register_onethirdlast($buttons) {  
   array_push($buttons, "onethirdlast");  
   return $buttons;  
}
function add_plugin_onethirdlast($plugin_array) {  
   $plugin_array['onethirdlast'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

function register_twothird($buttons) {  
   array_push($buttons, "twothird");  
   return $buttons;  
}
function add_plugin_twothird($plugin_array) {  
   $plugin_array['twothird'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

function register_twothirdlast($buttons) {  
   array_push($buttons, "twothirdlast");  
   return $buttons;  
}
function add_plugin_twothirdlast($plugin_array) {  
   $plugin_array['twothirdlast'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

// one fourth buttons

function register_onefourth($buttons) {  
   array_push($buttons, "onefourth");  
   return $buttons;  
}
function add_plugin_onefourth($plugin_array) {  
   $plugin_array['onefourth'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

function register_onefourthlast($buttons) {  
   array_push($buttons, "onefourthlast");  
   return $buttons;  
}
function add_plugin_onefourthlast($plugin_array) {  
   $plugin_array['onefourthlast'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}


// three fourth buttons

function register_threefourth($buttons) {  
   array_push($buttons, "threefourth");  
   return $buttons;  
}
function add_plugin_threefourth($plugin_array) {  
   $plugin_array['threefourth'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

function register_threefourthlast($buttons) {  
   array_push($buttons, "threefourthlast");  
   return $buttons;  
}
function add_plugin_threefourthlast($plugin_array) {  
   $plugin_array['threefourthlast'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

// one fifth buttons

function register_onefifth($buttons) {  
   array_push($buttons, "onefifth");  
   return $buttons;  
}
function add_plugin_onefifth($plugin_array) {  
   $plugin_array['onefifth'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

function register_onefifthlast($buttons) {  
   array_push($buttons, "onefifthlast");  
   return $buttons;  
}
function add_plugin_onefifthlast($plugin_array) {  
   $plugin_array['onefifthlast'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

// two fifth buttons

function register_twofifth($buttons) {  
   array_push($buttons, "twofifth");  
   return $buttons;  
}
function add_plugin_twofifth($plugin_array) {  
   $plugin_array['twofifth'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

function register_twofifthlast($buttons) {  
   array_push($buttons, "twofifthlast");  
   return $buttons;  
}
function add_plugin_twofifthlast($plugin_array) {  
   $plugin_array['twofifthlast'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

// three fifth buttons

function register_threefifth($buttons) {  
   array_push($buttons, "threefifth");  
   return $buttons;  
}
function add_plugin_threefifth($plugin_array) {  
   $plugin_array['threefifth'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

function register_threefifthlast($buttons) {  
   array_push($buttons, "threefifthlast");  
   return $buttons;  
}
function add_plugin_threefifthlast($plugin_array) {  
   $plugin_array['threefifthlast'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

// four fifth buttons

function register_fourfifth($buttons) {  
   array_push($buttons, "fourfifth");  
   return $buttons;  
}
function add_plugin_fourfifth($plugin_array) {  
   $plugin_array['fourfifth'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

function register_fourfifthlast($buttons) {  
   array_push($buttons, "fourfifthlast");  
   return $buttons;  
}
function add_plugin_fourfifthlast($plugin_array) {  
   $plugin_array['fourfifthlast'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

// one sixth buttons

function register_onesixth($buttons) {  
   array_push($buttons, "onesixth");  
   return $buttons;  
}
function add_plugin_onesixth($plugin_array) {  
   $plugin_array['onesixth'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

function register_onesixthlast($buttons) {  
   array_push($buttons, "onesixthlast");  
   return $buttons;  
}
function add_plugin_onesixthlast($plugin_array) {  
   $plugin_array['onesixthlast'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

// five sixth buttons

function register_fivesixth($buttons) {  
   array_push($buttons, "fivesixth");  
   return $buttons;  
}
function add_plugin_fivesixth($plugin_array) {  
   $plugin_array['fivesixth'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}

function register_fivesixthlast($buttons) {  
   array_push($buttons, "fivesixthlast");  
   return $buttons;  
}
function add_plugin_fivesixthlast($plugin_array) {  
   $plugin_array['fivesixthlast'] = get_template_directory_uri().'/js/ag_customcodes.js';    
   return $plugin_array;  
}


function parse_shortcode_content( $content ) {

    /* Parse nested shortcodes and add formatting. */
    $content = trim( wpautop( do_shortcode( $content ) ) );

    /* Remove '</p>' from the start of the string. */
    if ( substr( $content, 0, 4 ) == '</p>' )
        $content = substr( $content, 4 );

    /* Remove '<p>' from the end of the string. */
    if ( substr( $content, -3, 3 ) == '<p>' )
        $content = substr( $content, 0, -3 );

    /* Remove any instances of '<p></p>'. */
    $content = str_replace( array( '<p></p>' ), '', $content );

    return $content;
}

?>