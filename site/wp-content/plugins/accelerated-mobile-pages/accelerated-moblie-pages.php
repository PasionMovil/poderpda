<?php
/*
Plugin Name: Accelerated Mobile Pages
Plugin URI: https://wordpress.org/plugins/accelerated-mobile-pages/
Description: AMP for WP - Accelerated Mobile Pages for WordPress
Version: 0.9.84.1
Author: Ahmed Kaludi, Mohammed Kaludi
Author URI: https://ampforwp.com/
Donate link: https://www.paypal.me/Kaludi/25
License: GPL2+
Text Domain: accelerated-mobile-pages
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

define('AMPFORWP_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('AMPFORWP_PLUGIN_DIR_URI', plugin_dir_url(__FILE__));
define('AMPFORWP_DISQUS_URL',plugin_dir_url(__FILE__).'includes/disqus.html');
define('AMPFORWP_IMAGE_DIR',plugin_dir_url(__FILE__).'images');
define('AMPFORWP_MAIN_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
define('AMPFORWP_VERSION','0.9.84.1');

// any changes to AMP_QUERY_VAR should be refelected here
function ampforwp_generate_endpoint(){
    $ampforwp_slug = '';
    $get_permalink_structure = '';

   	$ampforwp_slug = "amp";

    return $ampforwp_slug;
}

define('AMPFORWP_AMP_QUERY_VAR', apply_filters( 'amp_query_var', ampforwp_generate_endpoint() ) );

load_plugin_textdomain( 'accelerated-mobile-pages', false, trailingslashit(AMPFORWP_PLUGIN_DIR) . 'languages' );

// Rewrite the Endpoints after the plugin is activate, as priority is set to 11
function ampforwp_add_custom_post_support() {
	global $redux_builder_amp;
	add_rewrite_endpoint( AMPFORWP_AMP_QUERY_VAR, EP_PAGES | EP_PERMALINK | EP_AUTHORS | EP_ALL_ARCHIVES | EP_ROOT );
	// Pages
	if ( isset($redux_builder_amp['amp-on-off-for-all-pages']) && $redux_builder_amp['amp-on-off-for-all-pages'] ) {
		add_post_type_support( 'page', AMPFORWP_AMP_QUERY_VAR );
	}
	// Custom Post Types
	if ( isset($redux_builder_amp['ampforwp-custom-type'] ) && $redux_builder_amp['ampforwp-custom-type'] ) {
	        foreach ( $redux_builder_amp['ampforwp-custom-type'] as $custom_post ) {
	            add_post_type_support( $custom_post, AMP_QUERY_VAR );
	        }
	}
}
add_action( 'init', 'ampforwp_add_custom_post_support',11);

// Frontpage and Blog page check from reading settings.
function ampforwp_name_blog_page() {
	if ( ! $page_for_posts = get_option('page_for_posts')) return;
	$page_for_posts = get_option( 'page_for_posts' );
	$post = get_post($page_for_posts); 
	if ( $post ) {
		$slug = $post->post_name;
		return $slug;
	}
}
function ampforwp_custom_post_page() {
	$front_page_type = get_option( 'show_on_front' );
	if ( $front_page_type ) {
		return $front_page_type;
	}
}

function ampforwp_get_the_page_id_blog_page(){
	$page = "";
	$output = "";
	if ( ampforwp_name_blog_page() ) {
		$page = get_page_by_path( ampforwp_name_blog_page() );
		$output = $page->ID;
	}

	return $output;
}

// Add Custom Rewrite Rule to make sure pagination & redirection is working correctly
function ampforwp_add_custom_rewrite_rules() {
	global $redux_builder_amp;
    // For Homepage
    add_rewrite_rule(
      'amp/?$',
      'index.php?amp',
      'top'
    );
	// For Homepage with Pagination
    add_rewrite_rule(
        'amp/page/([0-9]{1,})/?$',
        'index.php?amp&paged=$matches[1]',
        'top'
    );
	// For /Blog page with Pagination
	    add_rewrite_rule(
	        ampforwp_name_blog_page(). '/amp/page/([0-9]{1,})/?$',
	        'index.php?amp&paged=$matches[1]&page_id=' .ampforwp_get_the_page_id_blog_page(),
	        'top'
	    );
	    // Pagination to work with Extensions like.hml
	    add_rewrite_rule(
	        ampforwp_name_blog_page(). '(.+?)/amp/page/([0-9]{1,})/?$',
	        'index.php?amp&paged=$matches[2]&page_id=' .ampforwp_get_the_page_id_blog_page(),
	        'top'
	    );

    // For Author pages
    add_rewrite_rule(
        'author\/([^/]+)\/amp\/?$',
        'index.php?amp&author_name=$matches[1]',
        'top'
    );

    add_rewrite_rule(
        'author\/([^/]+)\/amp\/page\/?([0-9]{1,})\/?$',
        'index.php?amp=1&author_name=$matches[1]&paged=$matches[2]',
        'top'
    );

    // For category pages
    $rewrite_category = get_option('category_base');
    if ( ! empty($rewrite_category) ) {
    	$rewrite_category = get_option('category_base');
    } else {
    	$rewrite_category = 'category';
    }

    add_rewrite_rule(
      $rewrite_category.'\/(.+?)\/amp/?$',
      'index.php?amp&category_name=$matches[1]',
      'top'
    );
    // For category pages with Pagination
    add_rewrite_rule(
      $rewrite_category.'\/(.+?)\/amp\/page\/?([0-9]{1,})\/?$',
      'index.php?amp&category_name=$matches[1]&paged=$matches[2]',
      'top'
    );

    // For category pages with Pagination (Custom Permalink Structure)
	$permalink_structure = get_option('permalink_structure');
	$permalink_structure = preg_replace('/(%.*%)/', '', $permalink_structure);
	$permalink_structure = preg_replace('/\//', '', $permalink_structure);
	if ( $permalink_structure ) {
	  	add_rewrite_rule(
	      $permalink_structure.'\/'.$rewrite_category.'\/(.+?)\/amp\/page\/?([0-9]{1,})\/?$',
	      'index.php?amp&category_name=$matches[1]&paged=$matches[2]',
	      'top'
	    );
  	}

    // For tag pages
	$rewrite_tag = get_option('tag_base');
    if ( ! empty($rewrite_tag) ) {
    	$rewrite_tag = get_option('tag_base');
    } else {
    	$rewrite_tag = 'tag';
    }
    add_rewrite_rule(
      $rewrite_tag.'\/(.+?)\/amp/?$',
      'index.php?amp&tag=$matches[1]',
      'top'
    );
    // For tag pages with Pagination
    add_rewrite_rule(
      $rewrite_tag.'\/(.+?)\/amp\/page\/?([0-9]{1,})\/?$',
      'index.php?amp&tag=$matches[1]&paged=$matches[2]',
      'top'
    );
    // For tag pages with Pagination (Custom Permalink Structure)
    if ( $permalink_structure ) {
	  	add_rewrite_rule(
	      $permalink_structure.'\/'.$rewrite_tag.'\/(.+?)\/amp\/page\/?([0-9]{1,})\/?$',
	      'index.php?amp&tag=$matches[1]&paged=$matches[2]',
	      'top'
	    );
  	}
    
	//Rewrite rule for custom Taxonomies
	$args = array(
	  		'public'   => true,
	  		'_builtin' => false,  
	); 
	$output = 'names'; // or objects
	$operator = 'and'; // 'and' or 'or'
	$taxonomies = get_taxonomies( $args, $output, $operator ); 
	if ( $taxonomies ) {
	  foreach ( $taxonomies  as $taxonomy ) {   
	    add_rewrite_rule(
	      $taxonomy.'\/(.+?)\/amp/?$',
	      'index.php?amp&'.$taxonomy.'=$matches[1]',
	      'top'
	    );
	    // For Custom Taxonomies with pages
	    add_rewrite_rule(
	      $taxonomy.'\/(.+?)\/amp\/page\/?([0-9]{1,})\/?$',
	      'index.php?amp&'.$taxonomy.'=$matches[1]&paged=$matches[2]',
	      'top'
	    );
	  }
	}
}
add_action( 'init', 'ampforwp_add_custom_rewrite_rules' );

register_activation_hook( __FILE__, 'ampforwp_rewrite_activation', 20 );
function ampforwp_rewrite_activation() {

	// Run AMP deactivation code while activation  
	ampforwp_deactivate_amp_plugin();

		if ( ! did_action( 'ampforwp_init' ) ) {
	 		ampforwp_init();
		}

	flush_rewrite_rules();

    ampforwp_add_custom_post_support();
    ampforwp_add_custom_rewrite_rules();

    // Flushing rewrite urls ONLY on activation
	global $wp_rewrite;
	$wp_rewrite->flush_rules();

	delete_option('ampforwp_rewrite_flush_option');

    // Set transient for Welcome page
	set_transient( 'ampforwp_welcome_screen_activation_redirect', true, 30 );

}

add_action('init', 'ampforwp_flush_rewrite_by_option', 20);

function ampforwp_flush_rewrite_by_option(){

	global $wp_rewrite;
	$get_current_permalink_settings  = "";

	$get_current_permalink_settings  = get_option('ampforwp_rewrite_flush_option');

	if ( $get_current_permalink_settings ) {
		return;
	}
	// Adding double check to make sure, we are not updating and calling database unnecessarily
	if ( empty( $get_current_permalink_settings ) ) {
		$wp_rewrite->flush_rules();
		update_option('ampforwp_rewrite_flush_option', 'true');
	}

}

register_deactivation_hook( __FILE__, 'ampforwp_rewrite_deactivate', 20 );
function ampforwp_rewrite_deactivate() {
	// Flushing rewrite urls ONLY on deactivation
	global $wp_rewrite;
	
	foreach ( $wp_rewrite->endpoints as $index => $endpoint ) {
		if ( AMP_QUERY_VAR === $endpoint[1] ) {
			unset( $wp_rewrite->endpoints[ $index ] );
			break;
		}
	}

	flush_rewrite_rules();

	$wp_rewrite->flush_rules();

	// Remove transient for Welcome page
	delete_transient( 'ampforwp_welcome_screen_activation_redirect');
}

add_action( 'admin_init','ampforwp_parent_plugin_check');
function ampforwp_parent_plugin_check() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$amp_plugin_activation_check = is_plugin_active( 'amp/amp.php' );
	if ( $amp_plugin_activation_check ) {
		// set_transient( 'ampforwp_parent_plugin_check', true, 30 );
	} else {
		delete_option( 'ampforwp_parent_plugin_check');
	}
}
if(!function_exists('ampforwp_upcomming_layouts_demo') && is_admin()){
	function ampforwp_upcomming_layouts_demo(){
		return array(array(
			"name"=>'News',
			"image"=>''.AMPFORWP_IMAGE_DIR . '/layouts-1.png',
			"link"=>'https://ampforwp.com/amp-layouts/',
			)
			);
	}
}
// Redux panel inclusion code
if ( ! class_exists( 'ReduxFramework' ) ) {
    require_once dirname( __FILE__ ).'/includes/options/extensions/loader.php';
    require_once dirname( __FILE__ ).'/includes/options/redux-core/framework.php';
}
if ( is_admin() ) {
	// Register all the main options	
	require_once dirname( __FILE__ ).'/includes/options/admin-config.php';
	require_once dirname( __FILE__ ).'/templates/report-bugs.php';
}
// Modules 
add_action('after_setup_theme','ampforwp_add_module_files');
function ampforwp_add_module_files() {
	
	global $redux_builder_amp;
	if ( isset($redux_builder_amp['ampforwp-content-builder']) && $redux_builder_amp['ampforwp-content-builder'] ) {
		if ( ! function_exists( 'bstw' ) ) {
			require_once AMPFORWP_PLUGIN_DIR .'/includes/vendor/tinymce-widget/tinymce-widget.php';
		}
		require_once AMPFORWP_PLUGIN_DIR .'/includes/modules/ampforwp-blurb.php';
		require_once AMPFORWP_PLUGIN_DIR .'/includes/modules/ampforwp-button.php';
	}
}

/*
 * Load Files only in the backend
 * As we don't need plugin activation code to run everytime the site loads
*/
if ( is_admin() ) {

	// Include Welcome page only on Admin pages
	require AMPFORWP_PLUGIN_DIR .'/includes/welcome.php';

 	// Add Settings Button in Plugin backend
 	if ( ! function_exists( 'ampforwp_plugin_settings_link' ) ) {
 		
 		// Deactivate Parent Plugin notice
 		add_filter( 'plugin_action_links', 'ampforwp_plugin_settings_link', 10, 5 );

 		function ampforwp_plugin_settings_link( $actions, $plugin_file ) {
 			static $plugin;
 			if ( ! isset($plugin))
 				$plugin = plugin_basename(__FILE__);
 				if ( $plugin === $plugin_file ) {
 					$settings = array( 'settings' => '<a href="admin.php?page=amp_options&tab=8">' . __('Settings', 'accelerated-mobile-pages') . '</a> | <a href="https://ampforwp.com/extensions/#utm_source=plugin-panel&utm_medium=plugin-extension&utm_campaign=features">' . __('Premium Features', 'accelerated-mobile-pages') . '</a> | <a href="https://ampforwp.com/membership/#utm_source=plugin-panel&utm_medium=plugin-extension&utm_campaign=pro">' . __('Pro', 'accelerated-mobile-pages') . '</a>' );
 					
					include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
					$actions = array_merge( $actions, $settings );
 				}
 		return $actions;
 		}
 	}
} // is_admin() closing

// AMP endpoint Verifier
function ampforwp_is_amp_endpoint() {
	if ( ampforwp_is_non_amp() && ! is_admin()) {
		return ampforwp_is_non_amp();
	}
	else {
		return false !== get_query_var( 'amp', false );
	}
}

if ( ! class_exists( 'Ampforwp_Init', false ) ) {
	class Ampforwp_Init {

		public function __construct(){

			// Load Files required for the plugin to run
			require AMPFORWP_PLUGIN_DIR .'/includes/includes.php';

			// Redirection Code added
			require AMPFORWP_PLUGIN_DIR.'/includes/redirect.php';

			require AMPFORWP_PLUGIN_DIR .'/classes/class-init.php';
			new Ampforwp_Loader();

		}
	}
}
/*
 * Start the plugin.
 * Gentlemen start your engines
 */
function ampforwp_plugin_init() {
	
	if ( defined( 'AMP__FILE__' ) && defined('AMPFORWP_PLUGIN_DIR') ) {
		new Ampforwp_Init();
	}
}
add_action('init','ampforwp_plugin_init',9);

/*
* customized output widget
* to be used be used in before or after Loop
*/
require AMPFORWP_PLUGIN_DIR.'/templates/category-widget.php';
require AMPFORWP_PLUGIN_DIR.'/templates/woo-widget.php';


/*
* 	Including core AMP plugin files and removing any other things if necessary
*/
function ampforwp_bundle_core_amp_files(){
	// Bundling Default plugin
	require_once AMPFORWP_PLUGIN_DIR .'/includes/vendor/amp/amp.php';

	define( 'AMP__FILE__', __FILE__ );
	if ( ! defined('AMP__DIR__') ) {
		define( 'AMP__DIR__', plugin_dir_path(__FILE__) . 'includes/vendor/amp/' );
	}
	define( 'AMP__VERSION', '0.4.2' );

	require_once( AMP__DIR__ . '/back-compat/back-compat.php' );
	require_once( AMP__DIR__ . '/includes/amp-helper-functions.php' );
	require_once( AMP__DIR__ . '/includes/admin/functions.php' );
	require_once( AMP__DIR__ . '/includes/settings/class-amp-customizer-settings.php' );
	require_once( AMP__DIR__ . '/includes/settings/class-amp-customizer-design-settings.php' );
} 
add_action('plugins_loaded','ampforwp_bundle_core_amp_files', 8);

function ampforwp_deactivate_amp_plugin() {
 
	if ( version_compare( floatval( get_bloginfo( 'version' ) ), '3.5', '>=' ) ) {

	    if ( current_user_can( 'activate_plugins' ) ) {

	        add_action( 'admin_init', 'ampforwp_deactivate_amp' ); 

	        function ampforwp_deactivate_amp() {
	            deactivate_plugins( AMPFORWP_MAIN_PLUGIN_DIR . 'amp/amp.php' );
	        }
	    }
	}
}
add_action( 'plugins_loaded', 'ampforwp_deactivate_amp_plugin' );

function ampforwp_modify_amp_activatation_link( $actions, $plugin_file ) {
	$plugin = '';

	$plugin = 'amp/amp.php'; 
	if ( $plugin == $plugin_file ) {
		add_thickbox();
		unset($actions['activate']);
		$a = '<span style="cursor:pointer;color:#0089c8" class="warning_activate_amp" onclick="alert(\'AMP is already bundled with AMPforWP. Please do not install this plugin with AMPforWP to avoid conflicts. \')">Activate</span>';
		array_unshift ($actions,$a);
	} 
 	return $actions;
}
add_filter( 'plugin_action_links', 'ampforwp_modify_amp_activatation_link', 10, 2 );

if ( ! function_exists('ampforwp_init') ) {
	add_action( 'init', 'ampforwp_init' );
	function ampforwp_init() {
		if ( false === apply_filters( 'amp_is_enabled', true ) ) {
			return;
		}

		define( 'AMP_QUERY_VAR', apply_filters( 'amp_query_var', 'amp' ) );

		if ( ! defined('AMP__DIR__') ) {
			define( 'AMP__DIR__', plugin_dir_path(__FILE__) . 'includes/vendor/amp/' );
		}

		do_action( 'amp_init' );

		load_plugin_textdomain( 'amp', false, plugin_basename( AMP__DIR__ ) . '/languages' );

		add_rewrite_endpoint( AMP_QUERY_VAR, EP_PERMALINK );
		add_post_type_support( 'post', AMP_QUERY_VAR );

		add_filter( 'request', 'amp_force_query_var_value' );
		add_action( 'wp', 'amp_maybe_add_actions' );

		// Redirect the old url of amp page to the updated url. #1033 (Vendor Update)
		add_filter( 'old_slug_redirect_url', 'ampforwp_redirect_old_slug_to_new_url' );

		if ( class_exists( 'Jetpack' ) && ! (defined( 'IS_WPCOM' ) && IS_WPCOM) ) {
			require_once( AMP__DIR__ . '/jetpack-helper.php' );
		}
	}
}


function amp_update_db_check() {
	global $redux_builder_amp;
	$ampforwp_current_version = AMPFORWP_VERSION;
   	if ( get_option( 'AMPforwp_db_version' ) !== $ampforwp_current_version ) {

   		if ( isset( $_GET['ampforwp-dismiss'] ) && trim( $_GET['ampforwp-dismiss']) === "ampforwp_dismiss_admin_notices" ) {
			update_option( 'AMPforwp_db_version', $ampforwp_current_version );
			wp_redirect(remove_query_arg('ampforwp-dismiss'), 301);
		}
		if ( isset($redux_builder_amp['ampforwp-update-notification-bar'] ) && $redux_builder_amp['ampforwp-update-notification-bar'] && current_user_can( 'manage_options' ) ) {

	        add_action('admin_notices', 'ampforwp_update_notice');
	    }
    }
}
add_action( 'plugins_loaded', 'amp_update_db_check' );

function ampforwp_update_notice() {
	$screen = '';
	$screen = get_current_screen();
	$ampforwp_current_version = AMPFORWP_VERSION;
	if ( 'toplevel_page_amp_options' == $screen->base ) { ?>
    <div class="notice-success notice is-dismissible amp-update-notice">
        <div class="amp-update-notice-text-box">
        	<img src="data:image/png;base64,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" width="128" height="128" />
	 		<div class="amp-update-notice-text"> <?php echo esc_attr('AMP has been updated to '.$ampforwp_current_version, 'accelerated-mobile-pages' ); ?></div>
	    	<a href="https://ampforwp.com/new/" target="_blank" href="admin.php?page=acmforwp_update">What's New?</a> 
    	</div>
		<div class="amp-update-notice-dismiss">
        	<a title="Close this Notification" href="<?php echo esc_url(add_query_arg( 'ampforwp-dismiss', 'ampforwp_dismiss_admin_notices' )) ?>">X</a>
    	</div> 
		<div class="amp-update-notice-review-box">
			<a class="star_icon" href="https://wordpress.org/support/view/plugin-reviews/accelerated-mobile-pages?rate=5#new-post" target="_blank"> Appreciate it?  <br> <span title="Give Us 5 Star">Leave a Review →</span></a>
		</div>
	</div>
<?php }
}
if ( ! defined('AMP_FRAMEWORK_COMOPNENT_DIR_PATH') ) {
	define('AMP_FRAMEWORK_COMOPNENT_DIR_PATH', plugin_dir_path( __FILE__ )."/components"); 
}
require_once( AMP_FRAMEWORK_COMOPNENT_DIR_PATH . '/components-core.php' );
require_once(  AMPFORWP_PLUGIN_DIR. 'pagebuilder/amp-page-builder.php' );
require_once(  AMPFORWP_PLUGIN_DIR. 'base_remover/base_remover.php' );
require_once(  AMPFORWP_PLUGIN_DIR. 'includes/thirdparty-compatibility.php' );
require ( AMPFORWP_PLUGIN_DIR.'/install/index.php' );

/**
 * Redirects the old AMP URL to the new AMP URL.
 * If post slug is updated the amp page with old post slug will be redirected to the updated url.
 *
 * @param  string $link New URL of the post.
 *
 * @return string $link URL to be redirected.
 */
 if ( ! function_exists( 'ampforwp_redirect_old_slug_to_new_url' ) ) {
	function ampforwp_redirect_old_slug_to_new_url( $link ) {

		if ( function_exists( 'ampforwp_is_amp_endpoint' ) && ampforwp_is_amp_endpoint() ) {
			$link = trailingslashit( trailingslashit( $link ) . AMPFORWP_AMP_QUERY_VAR );
		}

		return $link;
	}
}

// Hide Post Builder if Swift is enabled
add_filter('amp_customizer_is_enabled', 'ampforwp_customizer_is_enabled');
if ( ! function_exists('ampforwp_customizer_is_enabled') ) {
	function ampforwp_customizer_is_enabled($value){
		global $redux_builder_amp;
		if ( 4 == $redux_builder_amp['amp-design-selector'] ) {
			$value = false;
		}
		return $value;
	}
}