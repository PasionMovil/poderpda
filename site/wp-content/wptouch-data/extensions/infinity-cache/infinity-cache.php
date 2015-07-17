<?php

define( 'INFINITY_CACHE_VERSION', '1.2.2' );
define( 'INFINTY_CACHE_PAGENAME', 'Infinity Cache' );
define( 'INFINITY_CACHE_DIR', WPTOUCH_CUSTOM_ADDON_DIRECTORY . '/infinity-cache' );
define( 'INFINITY_CACHE_CONTENT_DIR', WPTOUCH_BASE_CONTENT_DIR . '/infinity-cache' );
define( 'INFINITY_CACHE_MAX_CDN_URL', 4 );

// Experimental
define( 'INFINITY_ALLOW_BROWSER_CACHE', true );
define( 'INFINITY_CACHE_DEBUG', false );
define( 'INFINITY_CACHE_ENABLE_GZIP', false );

if ( strncasecmp( PHP_OS, 'WIN', 3 ) == 0 ) {
	define( 'INFINITY_CACHE_WINDOWS', true );
}

add_action( 'init', 'wptouch_cache_admin_bar' );
add_action( 'wptouch_cache_page', 'wptouch_addon_cache_do_cache' );
add_action( 'wptouch_addon_cache_cleanup_event', 'wptouch_addon_cache_do_scheduled_cleanup' );
add_filter( 'admin_init', 'wptouch_addon_cache_add_directory' );
add_filter( 'wptouch_body_classes', 'wptouch_addon_cache_add_slug_to_body' );

add_action( 'create_category', 'wptouch_addon_cache_flush' );
add_action( 'edit_category', 'wptouch_addon_cache_flush' );
add_action( 'delete_category', 'wptouch_addon_cache_flush' );

add_action( 'publish_page', 'wptouch_addon_cache_flush' );
add_action( 'publish_post', 'wptouch_addon_cache_flush' );
add_action( 'publish_future_post', 'wptouch_addon_cache_flush' );
add_action( 'edit_post', 'wptouch_addon_cache_flush' );
add_action( 'deleted_post', 'wptouch_addon_cache_flush' );

add_action( 'wptouch_admin_save_settings_completed', 'wptouch_addon_cache_flush' );
add_action( 'wptouch_version_update', 'wptouch_addon_cache_flush' );

add_filter( 'wptouch_setting_defaults_addons', 'wptouch_addon_cache_settings_defaults' );
add_filter( 'wptouch_addon_options', 'wptouch_cache_addon_options' );
add_action( 'wptouch_admin_ajax_infinity-cache-reset', 'wptouch_addon_cache_handle_ajax_reset' );

add_action( 'wptouch_update_settings_domain_' . ADDON_SETTING_DOMAIN, 'wptouch_addon_update_cron' );

add_action( 'wptouch_admin_render_setting', 'wptouch_infinity_cache_render_setting' );

function wptouch_infinity_debug( $message ) {
	if ( !INFINITY_CACHE_DEBUG ) {
		return;
	}

	$debug_file = INFINITY_CACHE_CONTENT_DIR . '/debug.txt';
	$f = fopen( $debug_file, 'a+t' );
	if ( $f ) {
		fwrite( $f, time() . '  ' . $message . "\n" );
		fclose( $f );
	}
}

function wptouch_cache_admin_bar() {
	add_action( 'admin_bar_menu', 'wptouch_cache_admin_bar_links', 999 );
}

function wptouch_cache_admin_bar_links() {
	global $wp_admin_bar;
	if ( !is_super_admin() || !is_admin_bar_showing() ) {
		return;
	}

	if ( wptouch_addon_cache_is_enabled() ) {
		if ( isset( $_GET[ 'wptouch_infinity_purge' ] ) ) {
			$nonce = $_GET[ 'purge_nonce' ];
			if ( wp_verify_nonce( $nonce, 'infinity_cache' ) ) {
				wptouch_addon_cache_handle_ajax_reset();
			}
		}

		$wp_admin_bar->add_node(
			array(
				'id'   => 'infinity_cache',
				'meta' => array(),
				'title' => 'Infinity Cache',
				'href' => false
			)
		);

		$wp_admin_bar->add_node(
			array(
				'id' => 'infinity_cache_purge',
				'meta' => array(),
				'title' => __( 'Purge Page Cache', 'wptouch-pro' ),
				'parent' => 'infinity_cache',
				'href' => esc_url( add_query_arg( array( 'wptouch_infinity_purge' => '1', 'purge_nonce' => wp_create_nonce( 'infinity_cache' ) ), $_SERVER[ 'REQUEST_URI' ] ) )
			)
		);
	}
}

function wptouch_addon_cache_add_slug_to_body( $classes ) {
	if ( wptouch_addon_cache_is_enabled() ) {
		$classes[] = 'infinity-cache-active';
	}
	return $classes;
}

function wptouch_addon_update_cron() {
	wp_clear_scheduled_hook( 'wptouch_addon_cache_cleanup_event' );

	wptouch_addon_cache_check_cron();
}

function wptouch_addon_cache_settings_defaults( $settings ) {
	$settings->cache_last_flush_time = time();
	$settings->cache_enable = false;
	$settings->cache_enable_desktop = false;
	$settings->cache_garbage_collection_interval = 'hourly';
	$settings->cache_expiry_time = 3600;
	$settings->cache_ignored_urls = "/feed/\nsitemap.xml\nsitemap_index.xml";
	$settings->cache_enable_browser_cache = false;
	$settings->cache_optimize_cdn = 'none';

	if ( wptouch_addon_cache_can_use_gzip() ) {
		$settings->cache_compress_output = false;
	}

	for ( $i = 1; $i <= INFINITY_CACHE_MAX_CDN_URL; $i++ ) {
		$name = 'media_optimize_cdn_prefix_' . $i;
		$settings->$name = false;
	}

	return $settings;
}

function wptouch_addon_cache_is_enabled() {
	$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );
	return $settings->cache_enable;
}

function wptouch_addon_cache_expiry_time() {
	$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );
	return $settings->cache_expiry_time;
}

function wptouch_addon_cache_browser_cache_enabled() {
	$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );
	return $settings->cache_enable_browser_cache;
}

function wptouch_addon_cache_is_cdn_enabled() {
	$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );
	return $settings->cache_optimize_cdn != 'none';
}

function wptouch_cache_addon_options( $page_options ) {
	wptouch_add_sub_page(
        INFINTY_CACHE_PAGENAME,
        'wptouch-addon-infinity-cache',
        $page_options
    );

	$settings_array = array(
		wptouch_add_setting(
			'checkbox',
			'cache_enable',
			__( 'Enable Infinity Cache', 'wptouch-pro' ),
			'',
			WPTOUCH_SETTING_BASIC,
			'3.1'
		),
		wptouch_add_setting(
			'checkbox',
			'cache_enable_desktop',
			__( 'Create cache for desktop users', 'wptouch-pro' ),
			__( 'If you are using another cache plugin such as W3, you can disable this.', 'wptouch-pro' ),
			WPTOUCH_SETTING_BASIC,
			'3.1'
		),
	);

//	if ( INFINITY_ALLOW_BROWSER_CACHE ) {
//		$settings_array[] = wptouch_add_setting(
//			'checkbox',
//			'cache_enable_browser_cache',
//			__( 'Enable browser cache support', 'wptouch-pro' ),
//			'',
//			WPTOUCH_SETTING_ADVANCED,
//			'3.1'
//		);
//	}

	if ( wptouch_addon_cache_can_use_gzip() ) {
		$settings_array[] = wptouch_add_setting(
			'checkbox',
			'cache_compress_output',
			__( 'Compress output using GZIP', 'wptouch-pro' ),
			'',
			WPTOUCH_SETTING_BASIC,
			'3.1'
		);
	}

	$settings_array[] = wptouch_add_setting(
		'list',
		'cache_expiry_time',
		__( 'Maximum age of cached content', 'wptouch-pro' ),
		__( 'Each cached page will automatically be regenerated after this period elapses', 'wptouch-pro' ),
		WPTOUCH_SETTING_BASIC,
		'3.1',
		array(
			3600 => sprintf( _n( '%d hour', '%d hours', 1, 'wptouch-pro' ), 1 ),
			3600*3 => sprintf( _n( '%d hour', '%d hours', 3, 'wptouch-pro' ), 3 ),
			3600*6 => sprintf( _n( '%d hour', '%d hours', 6, 'wptouch-pro' ), 6 ),
			3600*12 => sprintf( _n( '%d hour', '%d hours', 12, 'wptouch-pro' ), 12 ),
			3600*24 => sprintf( _n( '%d hour', '%d hours', 24, 'wptouch-pro' ), 24 )
		)
	);

	$settings_array[] = wptouch_add_setting(
		'list',
		'cache_garbage_collection_interval',
		__( 'Remove stale cache file interval', 'wptouch-pro' ),
		'',
		WPTOUCH_SETTING_BASIC,
		'3.1',
		array(
			'hourly' => __( 'Hourly', 'wptouch-pro' ),
			'daily' => __( 'Daily', 'wptouch-pro' )
		)
	);

	$settings_array[] = wptouch_add_setting(
		'textarea',
		'cache_ignored_urls',
		__( 'Disable caching for any of these matched URL fragments', 'wptouch-pro' ),
		sprintf( __( 'Add one URL fragment per line, i.e. %s, to not cache pages that contain each URL fragment', 'wptouch-pro' ), '/support/' ),
		WPTOUCH_SETTING_BASIC,
		'3.1'
	);

	$settings_array[] = wptouch_add_setting(
		'radiolist',
		'cache_optimize_cdn',
		__( 'Content Distribution Network Service', 'wptouch-pro' ),
		__( 'Using a content distribution network (CDN) can significantly enhance the responsiveness of your website.', 'wptouch-pro' ),
		WPTOUCH_SETTING_BASIC,
		'3.1',
		array(
			'none' => __( 'None', 'wptouch-pro' ),
			'maxcdn' => __( 'Custom', 'wptouch-pro' )
		)
	);

	for ( $i = 1; $i <= INFINITY_CACHE_MAX_CDN_URL; $i++ ) {
		$settings_array[] = wptouch_add_setting(
			'text',
			'media_optimize_cdn_prefix_' . $i,
			sprintf( __( 'URL %d', 'wptouch-pro' ), $i ),
			sprintf( __( 'Add the URLs you have configured for your CDN, for example http://cdn%d.mysite.com. Add your domain for multisite as well.', 'wptouch-pro' ), $i ),
			WPTOUCH_SETTING_BASIC,
			'3.1'
		);

		$settings_array[] = wptouch_add_setting(
			'cdn_show',
			'media_optimize_cdn_prefix_' . $i
		);
	}

	$settings_array[] = wptouch_add_setting(
		'button',
		'cache_delete_cache',
		__( 'Purge Page Cache', 'wptouch-pro' ),
		'',
		WPTOUCH_SETTING_BASIC,
		'3.1'
	);

	wptouch_add_page_section(
		INFINTY_CACHE_PAGENAME,
		__( 'Infinity Cache', 'wptouch-pro' ),
		'addons-infinity-cache',
		$settings_array,
		$page_options,
		ADDON_SETTING_DOMAIN
	);

	return $page_options;
}

function wptouch_addon_cache_can_use_gzip() {
	return ( version_compare( PHP_VERSION, '5.4.0') >= 0 && INFINITY_CACHE_ENABLE_GZIP );
}

function wptouch_addon_cache_get_valid_time() {
	$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );

	return $settings->cache_last_flush_time;
}

function wptouch_addon_cache_should_cache_page() {
	// Check if cache has been disabled
	wptouch_infinity_debug( 'Checking to see if CACHE is enabled' );

	if ( !wptouch_addon_cache_is_enabled() ) {
		wptouch_infinity_debug( '...CACHE is disabled' );
		return false;
	}

	// Don't cache AJAX requests
	if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
		wptouch_infinity_debug( '...Disabling CACHE due to AJAX request' );
		return false;
	}

	// Make sure our magic cookie is set
	if ( !isset( $_COOKIE[ WPTOUCH_CACHE_COOKIE ] ) ) {
		wptouch_infinity_debug( '...Disabling due to lack of magic cookie' );
		return false;
	}

	// Don't cache comment forms that have cookies set
	if ( isset( $_COOKIE[ 'comment_author' ] ) || isset( $_COOKIE[ 'comment_author_email' ] ) || isset( $_COOKIE[ 'comment_author_url'] ) ) {
		wptouch_infinity_debug( '...Disabling CACHE due to COMMENT cookies being set' );
		return false;
	}

	$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );
	// Don't cache any page requests, either GET or POST
	if ( count( $_GET ) || count( $_POST ) ) {
		wptouch_infinity_debug( '...Disabling CACHE due to GET or POST' );
		return false;
	}

	// See if we can cache desktop users
	if ( $_COOKIE[ WPTOUCH_CACHE_COOKIE ] == 'desktop' ) {
		if ( !$settings->cache_enable_desktop ) {
			wptouch_infinity_debug( '...Disabling CACHE due to DESKTOP theme and disabled setting' );
			return false;
		}
	}

	// Check for password protected pages
	foreach( $_COOKIE as $cookie_name => $cookie_value ) {
  		if ( strncmp( $cookie_name, "wp-postpass_", 12 ) == 0 ) {
  			// Page has a password
  			wptouch_infinity_debug( '...Disabling CACHE due to Password Protected post' );
  			return false;
  		}
  	}

	// Check for ignored pages
	if ( $settings->cache_ignored_urls ) {
		$urls = explode( "\n", trim( strtolower( $settings->cache_ignored_urls ) ) );
		if ( is_array( $urls ) && count( $urls ) ) {
			$page_uri = strtolower( $_SERVER[ 'REQUEST_URI' ] );
			foreach( $urls as $url ) {
				if ( $url != '' ) {
					if ( strpos( $page_uri, $url ) !== false ) {
						// Don't cache this page
						wptouch_infinity_debug( '...Disabling CACHE due to matched URL fragment' );
						return false;
					}
				}
			}
		}
	}

	// Don't cache pages of logged in users
	if ( is_user_logged_in() ) {
		wptouch_infinity_debug( '...Disabling CACHE due to logged in user' );
		return false;
	}

	wptouch_infinity_debug( '...CACHE is ENABLED' );
	return apply_filters( 'wptouch_addon_cache_current_page', true );
}

function wptouch_addon_get_cache_filename() {
	if ( in_array( $_COOKIE[ WPTOUCH_CACHE_COOKIE ], array( 'mobile', 'desktop', 'mobile-desktop' ) ) ) {
		$prefix = $_COOKIE[ WPTOUCH_CACHE_COOKIE ];
	}

	return INFINITY_CACHE_CONTENT_DIR . '/' .  $prefix . '/' . wptouch_addon_get_cache_key() . '.html';
}

function wptouch_addon_get_cache_key() {
	$key_string = $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI'];

	// Add device class
	if ( $_COOKIE[ WPTOUCH_CACHE_COOKIE ] == 'mobile' ) {
		global $wptouch_pro;
		$key_string = $key_string . $wptouch_pro->active_device_class;
	}

	return md5( $key_string );
}

function wptouch_addon_cache_is_file_expired( $file_time ) {
	return ( $file_time < wptouch_addon_cache_get_valid_time() ) || ( ( time() - $file_time ) > wptouch_addon_cache_expiry_time() );
}

function wptouch_addon_cache_check_modified( $etag ) {
	if ( isset( $_SERVER[ 'HTTP_IF_NONE_MATCH' ] ) ) {
		$stored_etag = trim( $_SERVER[ 'HTTP_IF_NONE_MATCH' ] );
		if ( $stored_etag == $etag ) {
			header( 'HTTP/1.1 304 Not Modified' );
			die;
		}
	}
}

function wptouch_addon_cache_do_cache() {
	// Check for caching
	if ( wptouch_addon_cache_should_cache_page() ) {
		$cache_file = wptouch_addon_get_cache_filename();
		wptouch_infinity_debug( 'CACHE file is ' . $cache_file );
		if ( file_exists( $cache_file ) ) {
			wptouch_infinity_debug( '...found CACHE file; checking modification time' );
			$last_modify_time = filemtime( $cache_file );
			if ( !wptouch_addon_cache_is_file_expired( $last_modify_time ) ) {
				wptouch_infinity_debug( '...file is still valid, serving' );
				// Serve cache file
				global $wptouch_pro;

				$cache_data = false;

				$etag = 0;
				if ( wptouch_addon_cache_can_use_gzip() && isset( $_SERVER[ 'HTTP_ACCEPT_ENCODING'] ) && strpos( $_SERVER[ 'HTTP_ACCEPT_ENCODING'], 'gzip' ) !== false && function_exists( 'gzcompress' ) && file_exists( $cache_file  . '.gz' ) ) {
					wptouch_infinity_debug( '......Serving GZIP version of CACHE' );
					// Check for browsing cache
					if ( wptouch_addon_cache_browser_cache_enabled() ) {
						$etag = md5( filemtime( $cache_file  . '.gz' ) . wptouch_addon_cache_expiry_time() );
						wptouch_addon_cache_check_modified( $etag );
					}

					// Load file (with gzip encoding)
					$cache_data = $wptouch_pro->load_file( $cache_file  . '.gz' );

					// Fix Windows newlines in PHP
					if ( defined( 'INFINITY_CACHE_WINDOWS' ) ) {
						$cache_data = str_replace( "\r\n", "\n", $cache_data );
					}

					// Unserialize
					$cache_data = unserialize( $cache_data );

					header( 'Content-Encoding: gzip' );
					header( 'Content-Length: ' . strlen( $cache_data->body ) );
				} else {
					// Check for browsing cache
					if ( wptouch_addon_cache_browser_cache_enabled() ) {
						$etag = md5( filemtime( $cache_file ) . wptouch_addon_cache_expiry_time() );
						wptouch_addon_cache_check_modified( $etag );
					}

					// Load file
					$cache_data = $wptouch_pro->load_file( $cache_file );

					// Fix Windows newlines
					if ( defined( 'INFINITY_CACHE_WINDOWS' ) ) { $cache_data = str_replace( "\r\n", "\n", $cache_data ); }

					// Unserialize
					$cache_data = unserialize( $cache_data );
				}

				$skip_items = array( 'X-Infinity-Cache' );
				if ( wptouch_addon_cache_browser_cache_enabled() ) {
					$skip_items[] = 'Pragma: no-cache';
				}

				foreach( $cache_data->headers as $header ) {
					$skip = false;
					foreach( $skip_items as $item ) {
						if ( strpos( $header, $item ) !== false ) {
							$skip = true;
						}
					}

					if ( $skip ) {
						continue;
					}

					wptouch_infinity_debug( '......Adding CACHE Header ' . $header );
					header( $header );
				}

				if ( wptouch_addon_cache_browser_cache_enabled() ) {
					wptouch_infinity_debug( '......Adding CACHE-CONTROL headers' );
					header( 'ETag: ' . $etag );
					header( 'Cache-Control: max-age=3600, must-revalidate' );
				}

				wptouch_infinity_debug( '...Serving CACHE data' );
				echo $cache_data->body;
				die;
			}
		}

		global $infinity_cache_info;

		$infinity_cache_info = new stdClass;
		$infinity_cache_info->cookies = $_COOKIE;
		$infinity_cache_info->generation_time = time();

		wptouch_infinity_debug( 'Starting to generate CACHE file' );
		ob_start( 'wptouch_addon_handle_cache_done' );
	} else {
		// header( 'X-Infinity-Cache: Should Not Cache' );
	}
}

function wptouch_addon_cdn_get_urls() {
	$urls = array();
	$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );
	for ( $i = 1; $i <= INFINITY_CACHE_MAX_CDN_URL; $i++ ) {
		$name = 'media_optimize_cdn_prefix_' . $i;
		if ( strlen( $settings->$name ) ) {
			$urls[] = $settings->$name;
		}
	}

	return $urls;
}

function wptouch_addon_cache_cdnize( $content ) {
	wptouch_infinity_debug( '...Checking for CDN' );
	if ( !wptouch_addon_cache_is_cdn_enabled() ) {
		wptouch_infinity_debug( '......CDN is disabled' );
		return $content;
	}

	$match_string = '#(href|src)=([\'"](.*)\.(jpg|css|png|js|gif|ico)[\'"\?])#iU';
	$result = preg_match_all( $match_string, $content, $matches );
	if ( $result ) {
		wptouch_infinity_debug( '...found ' . count( $matches[0] ) . ' URLS' );

		$find = array();
		$replace = array();
		$cdn_urls = wptouch_addon_cdn_get_urls();

		$count = 0;
		foreach( $matches[0] as $find_url ) {
			$count++;

			$cdn_url = $cdn_urls[ $count % count( $cdn_urls ) ];

			if ( !preg_match( '#(http|https|\/\/)#i', $find_url, $new_matches ) ) {
				// Relative URL

				$actual_url = $matches[ 3 ][ $count-1 ];
				$new_url = str_replace( $actual_url, $cdn_url . $actual_url, $find_url );

				$find[] = $find_url;
				$replace[] = $new_url;

				wptouch_infinity_debug( '......replacing ' . $find_url . ' WITH ' . $new_url );
			} else {
				$home_url = home_url();
				$new_url = str_replace( $home_url, $cdn_url, $find_url );

				$find[] = $find_url;
				$replace[] = $new_url;

				wptouch_infinity_debug( '......replacing ' . $find_url . ' WITH ' . $new_url );
			}
		}

		return str_replace( $find, $replace, $content );
	} else {
		wptouch_infinity_debug( '....NO URLs found :(' );
		return $content;
	}
}

function wptouch_addon_handle_cache_done( $buffer ) {
	global $infinity_cache_info;

	$infinity_cache_info->headers = headers_list();

	$new_buffer = wptouch_addon_cache_cdnize( $buffer );

	$file_handle = fopen( wptouch_addon_get_cache_filename(), 'w+t' );
	if ( $file_handle ) {
		$infinity_cache_info->body = $new_buffer;

		fwrite( $file_handle, serialize( $infinity_cache_info ) );
		fclose( $file_handle );
	}

	if ( function_exists( 'gzcompress') && wptouch_addon_cache_can_use_gzip() ) {
		$file_handle = fopen( wptouch_addon_get_cache_filename() . '.gz', 'w+b' );
		if ( $file_handle ) {
			$infinity_cache_info->body = gzcompress( $new_buffer, 9, ZLIB_ENCODING_GZIP );

			fwrite( $file_handle, serialize( $infinity_cache_info ) );
			fclose( $file_handle );
		}
	}

	return $new_buffer;
}

function wptouch_addon_cache_get_all_subdirectories() {
	return array(
		INFINITY_CACHE_CONTENT_DIR . '/desktop',
		INFINITY_CACHE_CONTENT_DIR . '/mobile',
		INFINITY_CACHE_CONTENT_DIR . '/mobile-desktop'
	);
}

function _wptouch_addon_cache_cleanup( $remove_all = false ) {
	require_once( WPTOUCH_DIR . '/core/file-operations.php' );
	$directories = wptouch_addon_cache_get_all_subdirectories();
	foreach( $directories as $dir ) {
		$files = wptouch_get_files_in_directory( $dir, '.html', true );
		if ( count( $files ) ) {
			foreach( $files as $file ) {
				if ( $remove_all) {
					// Remove all files, can be used when cache should be invalidated
					unlink( $file );
				} else {
					// Remove only old files
					$last_modified_time = filemtime( $file );
					if ( wptouch_addon_cache_is_file_expired( $last_modified_time ) ) {
						unlink( $file );
					}
				}
			}
		}
	}
}

function wptouch_addon_cache_check_cron() {
	if ( !wp_next_scheduled( 'wptouch_addon_cache_cleanup_event' ) ) {
		$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );

		wp_schedule_event( time(), $settings->cache_garbage_collection_interval, 'wptouch_addon_cache_cleanup_event' );
	}
}

function wptouch_addon_cache_do_scheduled_cleanup() {
	_wptouch_addon_cache_cleanup();
}

function wptouch_addon_cache_flush() {
	$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );
	$settings->cache_last_flush_time = time();
	$settings->save();
}

function wptouch_addon_cache_add_directory() {
	if ( !file_exists( INFINITY_CACHE_CONTENT_DIR ) ) {
		wptouch_create_directory_if_not_exist( INFINITY_CACHE_CONTENT_DIR );

		$sub_dirs = apply_filters( 'wptouch_addon_cache_subdirectories', wptouch_addon_cache_get_all_subdirectories() );

		foreach( $sub_dirs as $dir ) {
			wptouch_create_directory_if_not_exist( $dir );
		}
	}

	wptouch_addon_cache_check_cron();

	global $wptouch_pro;

	if ( $wptouch_pro->admin_is_wptouch_page() ) {
		wp_enqueue_script(
			'infinity-cache',
			WPTOUCH_BASE_CONTENT_URL . '/extensions/infinity-cache/infinity-cache-admin.js',
			array( 'wptouch-pro-admin' ),
			FOUNDATION_VERSION,
			true
		);
	}

}

function wptouch_addon_cache_handle_ajax_reset() {
	if ( current_user_can( 'manage_options') ) {
		_wptouch_addon_cache_cleanup( true );
	}
}

function wptouch_addon_should_cache_desktop(){
	$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );
	if ( $settings->cache_enable_desktop == true ) {
		return true;
	} else {
		return false;
	}
}

function wptouch_infinity_cache_render_setting( $setting ) {
	$setting_info = wptouch_get_settings( ADDON_SETTING_DOMAIN );
	$this_setting = $setting->name;

	if ( isset( $setting_info->$this_setting ) && $setting_info->$this_setting ) {
		echo '<div class="cdn">' . sprintf( __( 'An example for this URL is: %s%s%s.', 'wptouch-pro' ), '<strong>', '</strong>', str_replace( home_url(), $setting_info->$this_setting, WPTOUCH_URL . '/readme.txt' ) ) . '</div>';
	}
}