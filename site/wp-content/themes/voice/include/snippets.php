<?php
/*-----------------------------------------------------------------------------------*/
/*	Include snippets to modify/add some features to this theme
/*-----------------------------------------------------------------------------------*/

/* Allow shortcodes in widgets */
add_filter( 'widget_text', 'do_shortcode' );

/* Add classes to body tag */
if ( !function_exists( 'vce_body_class' ) ):
	function vce_body_class( $classes ) {
		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

		//Add some broswer classes which can be usefull for some css hacks later
		if ( $is_lynx ) $classes[] = 'lynx';
		elseif ( $is_gecko ) $classes[] = 'gecko';
		elseif ( $is_opera ) $classes[] = 'opera';
		elseif ( $is_NS4 ) $classes[] = 'ns4';
		elseif ( $is_safari ) $classes[] = 'safari';
		elseif ( $is_chrome ) $classes[] = 'chrome';
		elseif ( $is_IE ) $classes[] = 'ie';
		else $classes[] = 'unknown';

		if ( $is_iphone ) $classes[] = 'iphone';

		//Do not touch this, we use this global var to define current sidebar layout on all pages
		global $vce_sidebar_opts;

		$vce_sidebar_opts = vce_get_current_sidebar();
		$sidebar_class = $vce_sidebar_opts['use_sidebar'] ? 'vce-sid-'.$vce_sidebar_opts['use_sidebar'] : '';

		$classes[] = $sidebar_class;

		return $classes;
	}
endif;

add_filter( 'body_class', 'vce_body_class' );

/* Add wp_title filter */
if ( !function_exists( 'vce_wp_title' ) ):
	function vce_wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() )
			return $title;

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', THEME_SLUG ), max( $paged, $page ) );

		return $title;
	}
endif;

add_filter( 'wp_title', 'vce_wp_title', 10, 2 );

/* Run Theme Update Check */
if ( !function_exists( 'vce_run_updater' ) ):
	function vce_run_updater() {

		$user = vce_get_option( 'theme_update_username' );
		$apikey = vce_get_option( 'theme_update_apikey' );
		if ( !empty( $user ) && !empty( $apikey ) ) {
			include_once 'classes/class-pixelentity-theme-update.php';
			PixelentityThemeUpdate::init( $user, $apikey );
		}
	}
endif;

add_action( 'admin_init', 'vce_run_updater' );


/* Extend user social profiles  */
if ( !function_exists( 'vce_user_social_profiles' ) ):
	function vce_user_social_profiles( $contactmethods ) {

		unset( $contactmethods['aim'] );
		unset( $contactmethods['yim'] );
		unset( $contactmethods['jabber'] );

		$social = vce_get_social();
		foreach ( $social as $soc_id => $soc_name ) {
			if ( $soc_id ) {
				$contactmethods[$soc_id] = $soc_name;
			}
		}
		return $contactmethods;
	}
endif;

add_filter( 'user_contactmethods', 'vce_user_social_profiles' );

/* Delete our custom category meta from database on category deletion */
if ( !function_exists( 'vce_delete_category_meta' ) ):
	function vce_delete_category_meta( $term_id ) {
		delete_option( '_vce_category_'.$term_id );
	}
endif;

add_action( 'delete_category', 'vce_delete_category_meta' );


/* Change customize link to lead to theme options instead of live customizer */
if ( !function_exists( 'vce_change_customize_link' ) ):
	function vce_change_customize_link( $themes ) {
		if ( array_key_exists( 'voice', $themes ) ) {
			$themes['voice']['actions']['customize'] = admin_url( 'admin.php?page=vce_options' );
		}
		return $themes;
	}
endif;

add_filter( 'wp_prepare_themes_for_js', 'vce_change_customize_link' );

/* Print some stuff from options to head tag */
if ( !function_exists( 'vce_wp_head' ) ):
	function vce_wp_head() {

		//Add favicons
		if ( $favicon = vce_get_option_media( 'favicon' ) ) {
			echo '<link rel="shortcut icon" href="'.esc_url($favicon).'" type="image/x-icon" />';
		}

		if ( $apple_touch_icon = vce_get_option_media( 'apple_touch_icon' ) ) {
			echo '<link rel="apple-touch-icon" href="'.esc_url($apple_touch_icon).'" />';
		}

		if ( $metro_icon = vce_get_option_media( 'metro_icon' ) ) {
			echo '<meta name="msapplication-TileColor" content="#ffffff">';
			echo '<meta name="msapplication-TileImage" content="'.esc_url($metro_icon).'" />';
		}

		//Additional CSS (if user adds his custom css inside theme options)
		$additional_css = trim( preg_replace( '/\s+/', ' ', vce_get_option( 'additional_css' ) ) );
		if ( !empty( $additional_css ) ) {
			echo '<style type="text/css">'.$additional_css.'</style>';
		}

		//Google Analytics (tracking)
		if ( $ga = vce_get_option( 'ga' ) ) {
			echo $ga;
		}

	}
endif;

add_action( 'wp_head', 'vce_wp_head', 99 );

/* For advanced use - custom JS code into footer if specified in theme options */
if ( !function_exists( 'vce_wp_footer' ) ):
	function vce_wp_footer() {

		//Additional JS
		$additional_js = trim( preg_replace( '/\s+/', ' ', vce_get_option( 'additional_js' ) ) );
		if ( !empty( $additional_js ) ) {
			echo '<script type="text/javascript">
				/* <![CDATA[ */
					'.$additional_js.'
				/* ]]> */
				</script>';
		}

		
	}
endif;

add_action( 'wp_footer', 'vce_wp_footer', 99 );


/* Show welcome message and quick tips after theme activation */
if ( !function_exists( 'vce_welcome_msg' ) ):
	function vce_welcome_msg() {
		if ( !get_option( 'vce_welcome_box_displayed' ) ) { update_option( 'vce_theme_version', THEME_VERSION ); ?>
		 	<div class="updated">
				<?php include_once THEME_DIR.'/sections/welcome.php';?>
		 	</div>
		<?php
		}
	}
endif;

/* Show message box after theme update */
if ( !function_exists( 'vce_update_msg' ) ):
	function vce_update_msg() {
		if ( get_option( 'vce_welcome_box_displayed' ) ) {
			$prev_version = get_option( 'vce_theme_version' );
			$cur_version = THEME_VERSION;
			if ( $prev_version === false ) {$prev_version = '0.0.0';}
			if ( version_compare( $cur_version, $prev_version, '>' ) ) { ?>
		 		<div class="updated">
					<?php include_once THEME_DIR.'/sections/update-notify.php';?>
		 		</div>
			<?php
			}
		}
	}
endif;

/* Show admin notices */
if ( !function_exists( 'vce_check_installation' ) ):
	function vce_check_installation() {
		add_action( 'admin_notices', 'vce_welcome_msg', 1 );
		add_action( 'admin_notices', 'vce_update_msg', 1 );
	}
endif;

add_action( 'admin_init', 'vce_check_installation' );


/* Fix pagination issue caused by Facebook plugin */
if ( !function_exists( 'vce_fb_plugin_pagination_fix' ) ):
	function vce_fb_plugin_pagination_fix() {
		if ( class_exists( 'Facebook_Loader' ) && is_front_page() ) {
			global $wp_query;
			$page = get_query_var( 'page' );
			$paged = get_query_var( 'paged' );
			if ( $page > 1 || $paged > 1 ) {
				unset( $wp_query->queried_object );
			}
		}
	}
endif;

add_action( 'wp', 'vce_fb_plugin_pagination_fix', 99 );


/* Store registered sidebars so we can get them before wp_registered_sidebars is initialized to use them in theme options */
if ( !function_exists( 'vce_check_sidebars' ) ):
	function vce_check_sidebars() {
		global $wp_registered_sidebars;
		if ( !empty( $wp_registered_sidebars ) ) {
			update_option( 'vce_registered_sidebars', $wp_registered_sidebars );
		}
	}
endif;

add_action( 'admin_init', 'vce_check_sidebars' );

/* Function that outputs the contents of the dashboard widget */
if ( !function_exists( 'vce_dashboard_widget_cb' ) ):
	function vce_dashboard_widget_cb() {

		$hide = false;

		if ( $data = get_transient( 'vce_mksaw' ) ) {
			if ( $data != 'error' ) {
				echo $data;
			} else {
				$hide = true;
			}
		} else {
			$protocol = is_ssl() ? 'https://' : 'http://';
			$url = $protocol.'demo.mekshq.com/mksaw.php';
			$args = array( 'body' => array( 'key' => md5( 'meks' ), 'theme' => 'voice' ) );
			$response = wp_remote_post( $url, $args );
			if ( !is_wp_error( $response ) ) {
				$json = wp_remote_retrieve_body( $response );
				if ( !empty( $json ) ) {
					$json = ( json_decode( $json ) );
					if ( isset( $json->data ) ) {
						echo $json->data;
						set_transient( 'vce_mksaw', $json->data, 86400 );
					} else {
						set_transient( 'vce_mksaw', 'error', 86400 );
						$hide = true;
					}
				} else {
					set_transient( 'vce_mksaw', 'error', 86400 );
					$hide = true;
				}

			} else {
				set_transient( 'vce_mksaw', 'error', 86400 );
				$hide = true;
			}
		}

		if ( $hide ) {
			echo '<style>#vce_dashboard_widget {display:none;}</style>'; //hide widget if data is not returned properly
		}

	}
endif;

/* Add dashboard widget */
if ( !function_exists( 'vce_add_dashboard_widgets' ) ):
	function vce_add_dashboard_widgets() {
		add_meta_box( 'vce_dashboard_widget', 'Meks - WordPress Themes & Plugins', 'vce_dashboard_widget_cb', 'dashboard', 'side', 'high' );
	}
endif;

add_action( 'wp_dashboard_setup', 'vce_add_dashboard_widgets' );

/* Add media graber features */
if ( !function_exists( 'vce_add_media_graber' ) ):
	function vce_add_media_graber() {
		if ( !class_exists( 'Hybrid_Media_Grabber' ) ) {
			include_once 'classes/class-hybrid-media-grabber.php';
		}
	}
endif;

add_action( 'init', 'vce_add_media_graber' );


/* Add span elements to post count number in category widget */
if ( !function_exists( 'vce_add_span_cat_count' ) ):
	function vce_add_span_cat_count( $links ) {
		$links = preg_replace( '/(<a[^>]*>)/', '$1<span class="category-text">', $links );
		$links = str_replace( '</a>', '</span></a>', $links );
		$links = str_replace( '</a> (', '<span class="count"><span class="count-hidden">', $links );
		$links = str_replace( ')', '</span></span></a>', $links );
		return $links;
	}
endif;

add_filter( 'wp_list_categories', 'vce_add_span_cat_count' );

/* Unregister Entry Views widget */
if ( !function_exists( 'vce_unregister_widgets' ) ):
	function vce_unregister_widgets() {

		$widgets = array( 'EV_Widget_Entry_Views' );

		//Allow child themes or plugins to add/remove widgets they want to unregister
		$widgets = apply_filters( 'vce_modify_unregister_widgets', $widgets );

		if ( !empty( $widgets ) ) {
			foreach ( $widgets as $widget ) {
				unregister_widget( $widget );
			}
		}

	}
endif;


add_action( 'widgets_init', 'vce_unregister_widgets', 99 );

/* Remove entry views support for other post types, we need post support only */
if ( !function_exists( 'vce_remove_entry_views_support' ) ):
	function vce_remove_entry_views_support() {

		$types = array( 'page', 'attachment', 'literature', 'portfolio_item', 'recipe', 'restaurant_item' );

		//Allow child themes or plugins to modify entry views support
		$widgets = apply_filters( 'vce_modify_entry_views_support', $types );

		if ( !empty( $types ) ) {
			foreach ( $types as $type ) {
				remove_post_type_support( $type, 'entry-views' );
			}
		}

	}
endif;

add_action('init', 'vce_remove_entry_views_support', 99);

/* Change atts of wp gallery shortcode to get best size depending on column selection */
if ( !function_exists( 'vce_gallery_atts' ) ):
	function vce_gallery_atts( $out, $pairs, $atts ) {

		global $vce_sidebar_opts;

		$size_split = $vce_sidebar_opts['use_sidebar'] == 'none' ? 7 : 5;
		
		if ( !isset( $atts['columns'] ) ) {
			$atts['columns'] = 3;
		}

		if ( $atts['columns'] < $size_split ) {
			$size = 'vce-lay-b';
		} else {
			$size = 'vce-lay-d';
		}

		$out['columns'] = $atts['columns'];
		$out['size'] = $size;
		$out['link'] = 'file';

		return $out;

	}
endif;

add_filter( 'shortcode_atts_gallery', 'vce_gallery_atts', 10, 3 );


/* Slighly modify wordpress gallery shortcode */
if ( !function_exists( 'vce_gallery_shortcode' ) ):
	function vce_gallery_shortcode( $output = '', $attr, $content = false, $tag = false ) {
		$post = get_post();

		static $instance = 0;
		$instance++;

		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) ) {
				$attr['orderby'] = 'post__in';
			}
			$attr['include'] = $attr['ids'];
		}


		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( ! $attr['orderby'] ) {
				unset( $attr['orderby'] );
			}
		}

		$html5 = current_theme_supports( 'html5', 'gallery' );
		$atts = shortcode_atts( array(
				'order'      => 'ASC',
				'orderby'    => 'menu_order ID',
				'id'         => $post ? $post->ID : 0,
				'itemtag'    => $html5 ? 'figure'     : 'dl',
				'icontag'    => $html5 ? 'div'        : 'dt',
				'captiontag' => $html5 ? 'figcaption' : 'dd',
				'columns'    => 3,
				'size'       => 'thumbnail',
				'include'    => '',
				'exclude'    => '',
				'link'       => ''
			), $attr, 'gallery' );

		$id = intval( $atts['id'] );
		if ( 'RAND' == $atts['order'] ) {
			$atts['orderby'] = 'none';
		}

		if ( ! empty( $atts['include'] ) ) {
			$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( ! empty( $atts['exclude'] ) ) {
			$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		} else {
			$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
			}
			return $output;
		}

		$itemtag = tag_escape( $atts['itemtag'] );
		$captiontag = tag_escape( $atts['captiontag'] );
		$icontag = tag_escape( $atts['icontag'] );
		$valid_tags = wp_kses_allowed_html( 'post' );
		if ( ! isset( $valid_tags[ $itemtag ] ) ) {
			$itemtag = 'dl';
		}
		if ( ! isset( $valid_tags[ $captiontag ] ) ) {
			$captiontag = 'dd';
		}
		if ( ! isset( $valid_tags[ $icontag ] ) ) {
			$icontag = 'dt';
		}

		$columns = intval( $atts['columns'] );
		$itemwidth = $columns > 0 ? floor( 100/$columns ) : 100;
		$float = is_rtl() ? 'right' : 'left';

		$selector = "gallery-{$instance}";

		$gallery_style = '';

		if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
			$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
			/* see gallery_shortcode() in wp-includes/media.php */
		</style>\n\t\t";
		}

		$size_class = sanitize_html_class( $atts['size'] );
		$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

		$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

		
		$output .= '<div class="vce-gallery-big">';
		global $vce_sidebar_opts;
		$big_size = $vce_sidebar_opts['use_sidebar'] == 'none' ? 'vce-lay-a-nosid' : 'vce-lay-a';
		$vce_i = 0;
		foreach ( $attachments as $id => $attachment ) {
				$image_output = wp_get_attachment_link( $id, $big_size, false, false );
				$display = ($vce_i == 0) ? '' : 'style="display:none;"';
				$output .= '<div class="big-gallery-item item-'.$vce_i.'" '.$display.'>';
				$output .= "
			<{$icontag} class='gallery-icon'>
				$image_output
			</{$icontag}>";

				if ( $captiontag && trim( $attachment->post_excerpt ) ) {
					$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . wptexturize( $attachment->post_excerpt ) . "
				</{$captiontag}>";
				}
				$output .= '</div>';
				$vce_i++;
		}
		$output .= '</div>';

		if($columns > 1){
		$output .= '<div class="vce-gallery-slider" data-columns="'.$columns.'">';
		$i = 0; $vce_i = 0;
		foreach ( $attachments as $id => $attachment ) {

			if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
				$image_output = wp_get_attachment_link( $id, $atts['size'], false, false );
			} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
				$image_output = wp_get_attachment_image( $id, $atts['size'], false );
			} else {
				$image_output = wp_get_attachment_link( $id, $atts['size'], true, false );
			}
			$image_meta  = wp_get_attachment_metadata( $id );

			$orientation = '';
			if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
				$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
			}
			$output .= "<{$itemtag} class='gallery-item' data-item='".$vce_i."'>";
			$output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
				$image_output
			</{$icontag}>";
			$output .= "</{$itemtag}>";
			if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
				$output .= '<br style="clear: both" />';
			}

			$vce_i++;

		}

		if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
			$output .= "
			<br style='clear: both' />";
		}

		$output .= "</div>";
		}
		$output .= "</div>\n";

		return $output;
	}
endif;

add_filter( 'post_gallery', 'vce_gallery_shortcode', 10, 4 );

/* Pre get posts */
if ( !function_exists( 'vce_pre_get_posts' ) ):
	function vce_pre_get_posts( $query ) {

		if ( !is_admin() && $query->is_main_query() ) {

			/* Check whether to change number of posts per page for specific archive template if specifed in theme options */
			$template = vce_detect_template();
			$ppp = vce_get_option( $template.'_ppp' );
			if ( $ppp == 'custom' ) {
				
				$ppp = absint( vce_get_option( $template.'_ppp_num' ) );

				if ( $template == 'category' ) {
					$obj = get_queried_object();
					$cat_meta = vce_get_category_meta($obj->term_id);
					if($cat_meta['layout'] != 'inherit' && !empty($cat_meta['ppp'])){
						$ppp = $cat_meta['ppp'];
					}
				}

				$query->set( 'posts_per_page', $ppp );
			}

			/*Check for featured area on category page and exclude those posts from main post listing */
			if ( $template == 'category' ) {

				global $vce_cat_fa_args;
				$vce_cat_fa_args = vce_get_fa_cat_args();

				if ( vce_get_option( 'category_fa_not_duplicate' ) ) {
					if ( isset( $vce_cat_fa_args['fa_posts'] ) && !empty( $vce_cat_fa_args['fa_posts'] ) ) {
						$exclude_ids = array();
						foreach ( $vce_cat_fa_args['fa_posts']->posts as $p ) {
							$exclude_ids[] = $p->ID;
						}
						$query->set( 'post__not_in', $exclude_ids );
					}
				}
			}


		}

	}
endif;

add_action( 'pre_get_posts', 'vce_pre_get_posts' );

/* Change default arguments of flickr widget plugin */
if ( !function_exists( 'vce_flickr_widget_defaults' ) ):
	function vce_flickr_widget_defaults( $defaults ) {

		$defaults['t_width'] = 80;
		$defaults['t_height'] = 80;
		return $defaults;
	}
endif;

add_filter( 'mks_flickr_widget_modify_defaults', 'vce_flickr_widget_defaults' );


/* Change default arguments of author widget plugin */
if ( !function_exists( 'vce_author_widget_defaults' ) ):
	function vce_author_widget_defaults( $defaults ) {
		$defaults['avatar_size'] = 90;
		return $defaults;
	}
endif;

add_filter( 'mks_author_widget_modify_defaults', 'vce_author_widget_defaults' );


/* Rrevent redirect issue that may brake home page pagination caused by some plugins */
function vce_disable_redirect_canonical( $redirect_url) {
	if ( is_page_template('template-modules.php') && is_paged()) {
		$redirect_url = false;
	}
	return $redirect_url;
}

add_filter( 'redirect_canonical', 'vce_disable_redirect_canonical');

/* Add items dynamically to menu*/
if(!function_exists('vce_extend_navigation')):
function vce_extend_navigation($items, $args) {
	if ($args->theme_location == 'vce_main_navigation_menu' && vce_get_option('header_search')) {
        $items .= '<li class="search-header-wrap"><a class="search_header" href="javascript:void(0)"><i class="fa fa-search"></i></a><ul class="search-header-form-ul"><li>';
        $items .= '<form class="search-header-form" action="'.esc_url( home_url( '/' )).'" method="get">
		<input name="s" class="search-input" size="20" type="text" value="'.__vce('search_form').'" onfocus="(this.value == \''.__vce('search_form').'\') && (this.value = \'\')" onblur="(this.value == \'\') && (this.value = \''.__vce('search_form').'\')" placeholder="'.__vce('search_form').'" />
		</form>';
        $items .= '</li></ul></li>';
    }
    return $items;
}
endif;

add_action('wp_nav_menu_items', 'vce_extend_navigation', 10, 2 );


?>