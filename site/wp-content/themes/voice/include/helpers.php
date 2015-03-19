<?php
/*-----------------------------------------------------------------------------------*/
/*	Helpers and utils functions for theme use
/*-----------------------------------------------------------------------------------*/

/* 	Debug (log) function */
if ( !function_exists( 'vce_log' ) ):
	function vce_log( $mixed ) {

		if ( is_array( $mixed ) ) {
			$mixed = print_r( $mixed, 1 );
		} else if ( is_object( $mixed ) ) {
				ob_start();
				var_dump( $mixed );
				$mixed = ob_get_clean();
			}

		$handle = fopen( THEME_DIR . '/log', 'a' );
		fwrite( $handle, $mixed . PHP_EOL );
		fclose( $handle );
	}
endif;

/* 	Get theme option function */
if ( !function_exists( 'vce_get_option' ) ):
	function vce_get_option( $option ) {
		global $vce_settings;
		if ( isset( $vce_settings[$option] ) ) {
			return $vce_settings[$option];
		} else {
			return false;
		}
	}
endif;

/* 	Update theme option function */
if ( !function_exists( 'vce_update_option' ) ):
	function vce_update_option( $key = false, $value = false ) {
		global $Redux_Options;
		if ( !empty( $key ) ) {
			$Redux_Options->set( $key, $value );
		}
	}
endif;

/* Get list of image sizes to generate for theme use */
if ( !function_exists( 'vce_get_image_sizes' ) ):
	function vce_get_image_sizes() {
		$sizes = array(
			'vce-lay-a' => array( 'title' => 'Layout A (also layout G, single post and page)', 'w' => 810, 'h' => 9999, 'crop' => false ),
			'vce-lay-a-nosid' => array( 'title' => 'Layout A (full width - no sidebar)', 'w' => 1140, 'h' => 9999, 'crop' => false ),
			'vce-lay-b' => array( 'title' => 'Layout B (also layout C and post gallery thumbnails)', 'w' => 375, 'h' => 195, 'crop' => true ),
			'vce-lay-d' => array( 'title' => 'Layout D (also layout E and post gallery thumbnails)', 'w' => 145, 'h' => 100, 'crop' => true ),
			'vce-fa-full' => array( 'title' => 'Featured area (big - full width)', 'w' => 9999, 'h' => 500, 'crop' => true ),
			'vce-fa-grid' => array( 'title' => 'Featured area (grid item)', 'w' => 380, 'h' => 260, 'crop' => true ),
		);

		$sizes = apply_filters( 'vce_modify_image_sizes', $sizes );

		return $sizes;
	}
endif;

/* Get sidebar layouts */
if ( !function_exists( 'vce_get_sidebar_layouts' ) ):
	function vce_get_sidebar_layouts( $inherit = false ) {

		$layouts = array();

		if ( $inherit ) {
			$layouts['inherit'] = array( 'title' => __( 'Inherit', THEME_SLUG ), 'img' => IMG_URI . '/admin/inherit.png' );
		}

		$layouts['none'] = array( 'title' => __( 'No sidebar (full width)', THEME_SLUG ), 'img' => IMG_URI . '/admin/content_no_sid.png' );
		$layouts['left'] = array( 'title' => __( 'Left sidebar', THEME_SLUG ), 'img' => IMG_URI . '/admin/content_sid_left.png' );
		$layouts['right'] = array( 'title' => __( 'Right sidebar', THEME_SLUG ), 'img' => IMG_URI . '/admin/content_sid_right.png' );

		return $layouts;
	}
endif;

/* Get all sidebars */
if ( !function_exists( 'vce_get_sidebars_list' ) ):
	function vce_get_sidebars_list( $inherit = false ) {

		$sidebars = array();

		if ( $inherit ) {
			$sidebars['inherit'] = __( 'Inherit', THEME_SLUG );
		}

		$sidebars['0'] = __( 'None', THEME_SLUG );

		global $wp_registered_sidebars;

		if ( !empty( $wp_registered_sidebars ) ) {

			foreach ( $wp_registered_sidebars as $sidebar ) {
				$sidebars[$sidebar['id']] = $sidebar['name'];
			}

		} else {
			//Get sidebars from wp_options if global var is not loaded yet
			$fallback_sidebars = get_option( 'vce_registered_sidebars' );
			if ( !empty( $fallback_sidebars ) ) {
				foreach ( $fallback_sidebars as $sidebar ) {
					if ( !array_key_exists( $sidebar['id'], $sidebars ) ) {
						$sidebars[$sidebar['id']] = $sidebar['name'];
					}
				}
			}

			//Check for theme additional sidebars
			$custom_sidebars = vce_get_option( 'add_sidebars' );

			if ( empty( $custom_sidebars ) ) {
				$settings = get_option( 'vce_settings' );
				$custom_sidebars = isset( $settings['add_sidebars'] ) ? $settings['add_sidebars'] : false;
			}

			if ( $custom_sidebars ) {
				for ( $i = 1; $i <= $custom_sidebars; $i++ ) {
					if ( !array_key_exists( 'vce_sidebar_'.$i, $sidebars ) ) {
						$sidebars['vce_sidebar_'.$i] = __( 'Sidebar', THEME_SLUG ).' '.$i;
					}
				}
			}
		}

		//Do not display footer sidebars for selection
		unset( $sidebars['vce_footer_sidebar_1'] );
		unset( $sidebars['vce_footer_sidebar_2'] );
		unset( $sidebars['vce_footer_sidebar_3'] );

		return $sidebars;
	}
endif;

/* Get current archive layout  */
if ( !function_exists( 'vce_get_archive_layout' ) ):
	function vce_get_archive_layout() {

		$template = vce_detect_template();

		if ( in_array( $template, array( 'search', 'tag', 'author', 'archive', 'posts_page' ) ) ) {

			$layout = vce_get_option( $template.'_layout' );
		}

		if ( empty( $layout ) ) {
			$layout = 'b';
		}

		return $layout;
	}
endif;

/* Get current archive layout  */
if ( !function_exists( 'vce_get_archive_pagination' ) ):
	function vce_get_archive_pagination() {

		$template = vce_detect_template();

		if ( in_array( $template, array( 'search', 'tag', 'author', 'archive', 'posts_page' ) ) ) {

			$pagination = vce_get_option( $template.'_pagination' );
		}

		if ( empty( $pagination ) ) {
			$pagination = 'numeric';
		}

		return $pagination;
	}
endif;

/* Get current archive layout  */
if ( !function_exists( 'vce_get_category_pagination' ) ):
	function vce_get_category_pagination() {

		$pagination = vce_get_option( 'category_pagination' );

		if ( empty( $pagination ) ) {
			$pagination = 'numeric';
		}

		return $pagination;
	}
endif;

/* Get current category layout  */
if ( !function_exists( 'vce_get_category_layout' ) ):
	function vce_get_category_layout() {

		$args = array();
		$obj = get_queried_object();
		$meta = vce_get_category_meta( $obj->term_id );
		$args['layout'] = $meta['layout'] == 'inherit' ? vce_get_option( 'category_layout' ) : $meta['layout'];

		$paged = absint( get_query_var( 'paged' ) );

		if ( $paged <= 1 ) {
			if ( $meta['top_layout'] == 'inherit' ) {
				$args['top_layout'] = vce_get_option( 'category_use_top' ) ? vce_get_option( 'category_top_layout' ) : false;
				$args['top_limit'] = vce_get_option( 'category_use_top' ) ? vce_get_option( 'category_top_limit' ) : false;
			} else {
				$args['top_layout'] = $meta['top_layout'];
				$args['top_limit'] = $meta['top_limit'];
			}
		} else {
			$args['top_layout'] = false;
			$args['top_limit'] = false;
		}

		return $args;
	}
endif;

/* Get featured area layouts */
if ( !function_exists( 'vce_get_featured_area_layouts' ) ):
	function vce_get_featured_area_layouts( $inherit = false, $none = false ) {

		if ( $inherit ) {
			$layouts['inherit'] = array( 'title' => __( 'Inherit', THEME_SLUG ), 'img' => IMG_URI . '/admin/inherit.png' );
		}

		if ( $none ) {
			$layouts['0'] = array( 'title' => __( 'None', THEME_SLUG ), 'img' => IMG_URI . '/admin/none.png' );
		}

		$layouts['full_grid'] = array( 'title' => __( 'Big post + slider below', THEME_SLUG ), 'img' => IMG_URI . '/admin/featured_both.png' );
		$layouts['full'] = array( 'title' => __( 'Big post(s) only', THEME_SLUG ), 'img' => IMG_URI . '/admin/featured_big.png' );
		$layouts['grid'] = array( 'title' => __( 'Slider only', THEME_SLUG ), 'img' => IMG_URI . '/admin/featured_grid.png' );

		return $layouts;
	}
endif;

/* Get main post layouts layouts */
if ( !function_exists( 'vce_get_main_layouts' ) ):
	function vce_get_main_layouts( $inherit = false, $none = false ) {

		if ( $inherit ) {
			$layouts['inherit'] = array( 'title' => __( 'Inherit', THEME_SLUG ), 'img' => IMG_URI . '/admin/inherit.png' );
		}

		if ( $none ) {
			$layouts['0'] = array( 'title' => __( 'None', THEME_SLUG ), 'img' => IMG_URI . '/admin/none.png' );
		}

		$layouts['a'] = array( 'title' => __( 'Layout A', THEME_SLUG ), 'img' => IMG_URI . '/admin/layout_a.png' );
		$layouts['b'] = array( 'title' => __( 'Layout B', THEME_SLUG ), 'img' => IMG_URI . '/admin/layout_b.png' );
		$layouts['c'] = array( 'title' => __( 'Layout C', THEME_SLUG ), 'img' => IMG_URI . '/admin/layout_c.png' );
		$layouts['d'] = array( 'title' => __( 'Layout D', THEME_SLUG ), 'img' => IMG_URI . '/admin/layout_d.png' );
		$layouts['e'] = array( 'title' => __( 'Layout E', THEME_SLUG ), 'img' => IMG_URI . '/admin/layout_e.png' );
		$layouts['f'] = array( 'title' => __( 'Layout F', THEME_SLUG ), 'img' => IMG_URI . '/admin/layout_f.png' );
		$layouts['g'] = array( 'title' => __( 'Layout G', THEME_SLUG ), 'img' => IMG_URI . '/admin/layout_g.png' );

		return $layouts;
	}
endif;

/* Get main post layouts layouts */
if ( !function_exists( 'vce_get_pagination_layouts' ) ):
	function vce_get_pagination_layouts() {
		$layouts = array(
			'prev-next' => array( 'title' => __( 'Prev/Next page links', THEME_SLUG ), 'img' => IMG_URI . '/admin/pag_prev_next.png' ),
			'numeric' => array( 'title' => __( 'Numeric pagination links', THEME_SLUG ), 'img' => IMG_URI . '/admin/pag_numeric.png' ),
			'load-more' => array( 'title' => __( 'Load more button', THEME_SLUG ), 'img' => IMG_URI . '/admin/pag_load_more.png' ),
			'infinite-scroll' => array( 'title' => __( 'Infinite scroll', THEME_SLUG ), 'img' => IMG_URI . '/admin/pag_infinite.png' ),
		);

		return $layouts;
	}
endif;

/* Get module actions */
if ( !function_exists( 'vce_get_module_actions' ) ):
	function vce_get_module_actions() {
		$actions = array(
			'0' => __( 'None', THEME_SLUG ),
			'slider' => __( 'Apply slider', THEME_SLUG ),
			'pagination' => __( 'Add pagination', THEME_SLUG ),
			'link' => __( 'Add action link', THEME_SLUG )
		);

		return $actions;
	}
endif;


/* Include simple pagination */
if ( !function_exists( 'vce_pagination' ) ):
	function vce_pagination( $prev = '&lsaquo;', $next = '&rsaquo;' ) {
		global $wp_query, $wp_rewrite;
		$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
		$pagination = array(
			'base' => @add_query_arg( 'paged', '%#%' ),
			'format' => '',
			'total' => $wp_query->max_num_pages,
			'current' => $current,
			'prev_text' => $prev,
			'next_text' => $next,
			'type' => 'plain'
		);
		if ( $wp_rewrite->using_permalinks() )
			$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

		if ( !empty( $wp_query->query_vars['s'] ) )
			$pagination['add_args'] = array( 's' => str_replace( ' ', '+', get_query_var( 's' ) ) );

		$links = paginate_links( $pagination );

		if ( $links ) {
			return $links;
		}
	}
endif;


/* Convert hexdec color string to rgba */
if ( !function_exists( 'vce_hex2rgba' ) ):
	function vce_hex2rgba( $color, $opacity = false ) {
		$default = 'rgb(0,0,0)';

		//Return default if no color provided
		if ( empty( $color ) )
			return $default;

		//Sanitize $color if "#" is provided
		if ( $color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		//Check if color has 6 or 3 characters and get values
		if ( strlen( $color ) == 6 ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}

		//Convert hexadec to rgb
		$rgb =  array_map( 'hexdec', $hex );

		//Check if opacity is set(rgba or rgb)
		if ( $opacity ) {
			if ( abs( $opacity ) > 1 ) { $opacity = 1.0; }
			$output = 'rgba('.implode( ",", $rgb ).','.$opacity.')';
		} else {
			$output = 'rgb('.implode( ",", $rgb ).')';
		}

		//Return rgb(a) color string
		return $output;
	}
endif;

/* Get array of social options  */
if ( !function_exists( 'vce_get_social' ) ) :
	function vce_get_social( $existing = false ) {
		$social = array(
			'0' => 'None',
			'apple' => 'Apple',
			'behance' => 'Behance',
			'delicious' => 'Delicious',
			'deviantart' => 'DeviantArt',
			'digg' => 'Digg',
			'dribbble' => 'Dribbble',
			'facebook' => 'Facebook',
			'flickr' => 'Flickr',
			'github' => 'Github',
			'google' => 'GooglePlus',
			'instagram' => 'Instagram',
			'linkedin' => 'LinkedIN',
			'pinterest' => 'Pinterest',
			'reddit' => 'ReddIT',
			'rss' => 'Rss',
			'skype' => 'Skype',
			'stumbleupon' => 'StumbleUpon',
			'soundcloud' => 'SoundCloud',
			'spotify' => 'Spotify',
			'tumblr' => 'Tumblr',
			'twitter' => 'Twitter',
			'vimeo' => 'Vimeo',
			'vine' => 'Vine',
			'wordpress' => 'WordPress',
			'xing' => 'Xing' ,
			'yahoo' => 'Yahoo',
			'youtube' => 'Youtube'
		);

		if ( $existing ) {
			$new_social = array();
			foreach ( $social as $key => $soc ) {
				if ( $key && vce_get_option( 'soc_'.$key.'_url' ) ) {
					$new_social[$key] = $soc;
				}
			}
			$social = $new_social;
		}

		return $social;
	}
endif;


/* Get Theme Translated String */
if ( !function_exists( '__vce' ) ):
	function __vce( $string_key ) {
		if ( ( $translated_string = vce_get_option( 'tr_'.$string_key ) ) && vce_get_option( 'enable_translate' ) ) {

			if ( $translated_string == '-1' ) {
				return "";
			}

			return $translated_string;

		} else {

			$translate = vce_get_translate_options();
			return $translate[$string_key]['translated'];
		}
	}
endif;

/* Get All Translation Strings */
if ( !function_exists( 'vce_get_translate_options' ) ):
	function vce_get_translate_options() {
		global $vce_translate;
		get_template_part( 'include/translate' );
		$translate = apply_filters( 'vce_modify_translate_options', $vce_translate );
		return $translate;
	}
endif;

/* Compress CSS Code  */
if ( !function_exists( 'vce_compress_css_code' ) ) :
	function vce_compress_css_code( $code ) {

		// Remove Comments
		$code = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $code );

		// Remove tabs, spaces, newlines, etc.
		$code = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $code );

		return $code;
	}
endif;


/* Get image option url */
if ( !function_exists( 'vce_get_option_media' ) ):
	function vce_get_option_media( $option ) {
		$media = vce_get_option( $option );
		if ( isset( $media['url'] ) && !empty( $media['url'] ) ) {
			return $media['url'];
		}
		return false;
	}
endif;

/* Generate font links */
if ( !function_exists( 'vce_generate_font_links' ) ):
	function vce_generate_font_links() {

		$output = array();
		$fonts = array();
		$fonts[] = vce_get_option( 'main_font' );
		$fonts[] = vce_get_option( 'h_font' );
		$fonts[] = vce_get_option( 'nav_font' );
		$unique = array(); //do not add same font links
		$native = vce_get_native_fonts();
		$protocol = is_ssl() ? 'https://' : 'http://';

		foreach ( $fonts as $font ) {
			if ( !in_array( $font['font-family'], $native ) ) {
				$temp = array();
				if(isset($font['font-style'])){
					$temp['font-style'] = $font['font-style'];
				}
				if(isset($font['subsets'])){
					$temp['subsets'] = $font['subsets'];
				}
				if(isset($font['font-weight'])){
					$temp['font-weight'] = $font['font-weight'];
				}
				$unique[$font['font-family']][] = $temp;
			}
		}

		foreach ( $unique as $family => $items ) {

			$link = $protocol.'fonts.googleapis.com/css?family='.str_replace( ' ', '%20', $family ); //valid

			$weight = array( '400' );
			$subsets = array( 'latin' );

			foreach ( $items as $item ) {

				//Check weight and style
				if ( isset( $item['font-weight'] ) && !empty( $item['font-weight'] ) ) {
					$temp = $item['font-weight'];
					if ( isset( $item['font-style'] ) && empty( $item['font-style'] ) ) {
						$temp .= $item['font-style'];
					}

					if ( !in_array( $temp, $weight ) ) {
						$weight[] = $temp;
					}
				}

				//Check subsets
				if ( isset( $item['subsets'] ) && !empty( $item['subsets'] ) ) {
					if ( !in_array( $item['subsets'], $subsets ) ) {
						$subsets[] = $item['subsets'];
					}
				}
			}

			$link .= ':'.implode( ",", $weight );
			$link .= '&subset='.implode( ",", $subsets );

			$output[] = str_replace( '&', '&amp;', $link ); //valid
		}

		return $output;
	}
endif;

/* Generate dynamic CSS */
if ( !function_exists( 'vce_generate_dynamic_css' ) ):
	function vce_generate_dynamic_css() {
		ob_start();
		get_template_part( 'css/dynamic-css' );
		$output = ob_get_contents();
		ob_end_clean();
		return vce_compress_css_code( $output );
	}
endif;


/* Get list of native fonts */
if ( !function_exists( 'vce_get_native_fonts' ) ):
	function vce_get_native_fonts() {

		$fonts = array(
			"Arial, Helvetica, sans-serif",
			"'Arial Black', Gadget, sans-serif",
			"'Bookman Old Style', serif",
			"'Comic Sans MS', cursive",
			"Courier, monospace",
			"Garamond, serif",
			"Georgia, serif",
			"Impact, Charcoal, sans-serif",
			"'Lucida Console', Monaco, monospace",
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"'MS Sans Serif', Geneva, sans-serif",
			"'MS Serif', 'New York', sans-serif",
			"'Palatino Linotype', 'Book Antiqua', Palatino, serif",
			"Tahoma,Geneva, sans-serif",
			"'Times New Roman', Times,serif",
			"'Trebuchet MS', Helvetica, sans-serif",
			"Verdana, Geneva, sans-serif"
		);

		return $fonts;
	}
endif;


/* Add class to category links */
if ( !function_exists( 'vce_get_category' ) ):
	function vce_get_category() {

		$cats = get_the_category();
		$output = '';
		if ( !empty( $cats ) ) {
			foreach ( $cats as $k => $cat ) {
				$output.= '<a href="'.get_category_link( $cat->term_id ).'" class="category-'.$cat->term_id.'">'.$cat->name.'</a>';
				if ( ( $k + 1 ) != count( $cats ) ) {
					$output.= ' <span>&bull;</span> ';
				}
			}
		}
		return $output;
	}
endif;

/* Custom function to limit post content words */
if ( !function_exists( 'vce_get_excerpt' ) ):
	function vce_get_excerpt( $layout = 'lay-a' ) {

		$map = array(
			'lay-a' => 'lay_a',
			'lay-b' => 'lay_b',
			'lay-c' => 'lay_c',
			'lay-fa-big' => 'lay_fa_big',
		);

		if ( !array_key_exists( $layout, $map ) ) {
			return '';
		}

		if ( has_excerpt() ) {
			$content =  get_the_excerpt();
		} else {
			//$content = apply_filters('the_content',get_the_content(''));
			$text = get_the_content( '' );
			$text = strip_shortcodes( $text );
			$text = apply_filters( 'the_content', $text );
			$content = str_replace( ']]>', ']]&gt;', $text );
		}

		//print_r($content);

		if ( !empty( $content ) ) {
			$limit = vce_get_option( $map[$layout].'_excerpt_limit' );
			$more = vce_get_option( 'more_string' );
			$content = wp_strip_all_tags( $content );
			$content = preg_replace( '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $content );
			$excerpt = vce_trim_chars( $content, $limit, $more );
			return $excerpt;
		}

		return '';

	}
endif;

/* Custom function to limit post title chars for specific layout */
if ( !function_exists( 'vce_get_title' ) ):
	function vce_get_title( $layout = 'lay-a' ) {

		$map = array(
			'lay-a' => 'lay_a',
			'lay-b' => 'lay_b',
			'lay-c' => 'lay_c',
			'lay-d' => 'lay_d',
			'lay-e' => 'lay_e',
			'lay-f' => 'lay_f',
			'lay-fa-grid' => 'lay_fa_grid'
		);

		if ( !array_key_exists( $layout, $map ) ) {
			return get_the_title();
		}


		$title_limit = vce_get_option( $map[$layout].'_title_limit' );


		if ( !empty( $title_limit ) ) {
			$output = vce_trim_chars( strip_tags( get_the_title() ), $title_limit, vce_get_option( 'more_string' ) );
		} else {
			$output = get_the_title();
		}


		return $output;

	}
endif;

/* Trim chars of string */
if ( !function_exists( 'vce_trim_chars' ) ):
	function vce_trim_chars( $string, $limit, $more = '...' ) {

		if ( strlen( $string ) > $limit ) {
			$last_space = strrpos( substr( $string, 0, $limit ), ' ' );
			$string = substr( $string, 0, $last_space );
			$string = rtrim( $string, ".,-?!" );
			$string.= $more;
		}

		return $string;
	}
endif;

/* Custom function to get meta data for specific layout */
if ( !function_exists( 'vce_get_meta_data' ) ):
	function vce_get_meta_data( $layout = 'lay-a', $force_meta = false) {

		if(!$force_meta){
			
			$map = array(
				'lay-a' => 'lay_a',
				'lay-b' => 'lay_b',
				'lay-c' => 'lay_c',
				'lay-d' => 'lay_d',
				'lay-g' => 'lay_g',
				'lay-fa-grid' => 'lay_fa_grid',
				'lay-fa-big' => 'lay_fa_big',
				'single' => 'single',
			);
			//Layouts theme options
			$layout_metas = array_filter( vce_get_option( $map[$layout].'_meta' ) );

		} else {
			//From widget
			$layout_metas = array( $force_meta => '1' );
		}

		$output = '';

		if ( !empty( $layout_metas ) ) {

			foreach ( $layout_metas as $mkey => $active ) {


				$meta = '';

				switch ( $mkey ) {

				case 'date':
					$meta = '<span class="updated">'.vce_get_date().'</span>';
					break;
				case 'author':
					$meta = '<span class="vcard author"><span class="fn">'.__vce( 'by_author' ).' <a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.get_the_author_meta( 'display_name' ).'</a></span></span>';
					break;

				case 'comments':
					if ( comments_open() || get_comments_number() ) {
						ob_start();
						comments_popup_link( __vce( 'no_comments' ), __vce( 'one_comment' ), __vce( 'multiple_comments' ) );
						$meta = ob_get_contents();
						ob_end_clean();
					} else {
						$meta = '';
					}
					break;

				case 'views':
					$meta = function_exists( 'ev_get_post_view_count' ) ?  number_format( absint( str_replace(',', '', ev_get_post_view_count( get_the_ID() )) + vce_get_option( 'views_forgery' ) ), 0, '', ',' )  . ' '.__vce( 'views' ) : '';
					break;

				case 'rtime': 
					$meta = vce_read_time(get_the_content());
					if(!empty($meta)){
						$meta .= ' '.__vce('min_read');
					}
					break;

				default:
					break;
				}

				if ( !empty( $meta ) ) {
					$output .= '<div class="meta-item '.$mkey.'">'.$meta.'</div>';
				}
			}
		}


		return $output;

	}
endif;

/* Display featured image, and more :) */
if ( !function_exists( 'vce_featured_image' ) ):
	function vce_featured_image( $size = 'large', $post_id = false ) {


		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		if ( has_post_thumbnail( $post_id ) ) {
			return get_the_post_thumbnail( $post_id, $size );

		} else if ( $placeholder = vce_get_option_media( 'default_fimg' ) ) {

				global $placeholder_img, $placeholder_imgs;

				if ( empty( $placeholder_img ) ) {
					$img_id = vce_get_image_id_by_url( $placeholder );
				} else {
					$img_id = $placeholder_img;
				}

				if ( !empty( $img_id ) ) {
					if ( !isset( $placeholder_imgs[$size] ) ) {
						$def_img = wp_get_attachment_image( $img_id, $size );
					} else {
						$def_img = $placeholder_imgs[$size];
					}

					if ( !empty( $def_img ) ) {
						$placeholder_imgs[$size] = $def_img;
						return $def_img;
					}
				}

				return '<img src="'.$placeholder.'" />';
			}

		return false;
	}
endif;

/* Get image id by url */
if ( !function_exists( 'vce_get_image_id_by_url' ) ):
	function vce_get_image_id_by_url( $image_url ) {
		global $wpdb;

		$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );

		if ( isset( $attachment[0] ) ) {
			return $attachment[0];
		}

		return false;
	}
endif;

/* Check wheter to display date in standard or "time ago" format */
if ( !function_exists( 'vce_get_date' ) ):
	function vce_get_date() {

		if ( vce_get_option( 'time_ago' ) ) {

			$limits = array(
				'hour' => 3600,
				'day' => 86400,
				'week' => 604800,
				'month' => 2592000,
				'vceee_months' => 7776000,
				'six_months' => 15552000,
				'year' => 31104000,
				'0' => 0
			);

			$ago_limit = vce_get_option( 'time_ago_limit' );

			if ( array_key_exists( $ago_limit, $limits ) ) {

				if ( ( current_time( 'timestamp' ) - get_the_time( 'U' ) <= $limits[$ago_limit] ) || empty( $ago_limit ) ) {
					if ( vce_get_option( 'ago_before' ) ) {
						return __vce( 'ago' ).' '.human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) );
					} else {
						return human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ).' '.__vce( 'ago' );
					}
				} else {
					return get_the_date();
				}
			} else {
				return get_the_date();
			}
		} else {
			return get_the_date();
		}
	}
endif;

/* Get post meta with default values */
if ( !function_exists( 'vce_get_post_meta' ) ):
	function vce_get_post_meta( $post_id, $field = false ) {

		$defaults = array(
			'use_sidebar' => 'inherit',
			'sidebar' => 'inherit',
			'sticky_sidebar' => 'inherit'
		);

		$meta = get_post_meta( $post_id, '_vce_meta', true );
		$meta = wp_parse_args( (array) $meta, $defaults );

		if ( $field ) {
			if ( isset( $meta[$field] ) ) {
				return $meta[$field];
			} else {
				return false;
			}
		}

		return $meta;
	}
endif;

/* Get post meta with default values */
if ( !function_exists( 'vce_get_page_meta' ) ):
	function vce_get_page_meta( $post_id, $field = false ) {

		$defaults = array(
			'use_sidebar' => 'inherit',
			'sidebar' => 'inherit',
			'sticky_sidebar' => 'inherit',
			'fa_layout' => 0,
			'fa_limit' => 8,
			'fa_time' => 0,
			'fa_cat' => array(),
			'fa_order' => 'date',
			'fa_manual' => array(),
			'fa_exclude' => 1,
			'fa_cat_child' => 0,
			'modules' => array(),
			'display_content' => array('position' => 0, 'style' => 'wrap', 'width' => 'container'),
		);

		$meta = get_post_meta( $post_id, '_vce_meta', true );
		$meta = wp_parse_args( (array) $meta, $defaults );

		if ( $field ) {
			if ( isset( $meta[$field] ) ) {
				return $meta[$field];
			} else {
				return false;
			}
		}

		return $meta;
	}
endif;

/* Get category meta with default values */
if ( !function_exists( 'vce_get_category_meta' ) ):
	function vce_get_category_meta( $cat_id = false, $field = false ) {
		$defaults = array(
			'layout' => 'inherit',
			'top_layout' => 'inherit',
			'top_limit' => vce_get_option( 'category_top_limit' ),
			'fa_layout' => 'inherit',
			'fa_limit' => vce_get_option( 'category_fa_limit' ),
			'use_sidebar' => 'inherit',
			'sidebar' => 'inherit',
			'sticky_sidebar' => 'inherit',
			'color_type' => 'inherit',
			'color' => '#000000',
			'ppp' => ''
		);

		if ( $cat_id ) {
			$meta = get_option( '_vce_category_'.$cat_id );
			$meta = wp_parse_args( (array) $meta, $defaults );
		} else {
			$meta = $defaults;
		}

		if ( $field ) {
			if ( isset( $meta[$field] ) ) {
				return $meta[$field];
			} else {
				return false;
			}
		}

		return $meta;
	}
endif;

/* Cache recently used category colors */
if ( !function_exists( 'vce_update_recent_cat_colors' ) ):
	function vce_update_recent_cat_colors( $color, $num_col = 10 ) {
		if ( empty( $color ) )
			return false;

		$current = get_option( 'vce_recent_cat_colors' );
		if ( empty( $current ) ) {
			$current = array();
		}

		$update = false;

		if ( !in_array( $color, $current ) ) {
			$current[] = $color;
			if ( count( $current ) > $num_col ) {
				$current = array_slice( $current, ( count( $current ) - $num_col ), ( count( $current ) - 1 ) );
			}
			$update = true;
		}

		if ( $update ) {
			update_option( 'vce_recent_cat_colors', $current );
		}

	}
endif;

/* Store color per each category */
if ( !function_exists( 'vce_update_cat_colors' ) ):
	function vce_update_cat_colors( $cat_id, $color, $type ) {

		$colors = (array)get_option( 'vce_cat_colors' );

		if ( array_key_exists( $cat_id, $colors ) ) {

			if ( $type == 'inherit' ) {
				unset( $colors[$cat_id] );
			} elseif ( $colors[$cat_id] != $color ) {
				$colors[$cat_id] = $color;
			}

		} else {

			if ( $type != 'inherit' ) {
				$colors[$cat_id] = $color;
			}
		}

		update_option( 'vce_cat_colors', $colors );

	}
endif;

/* Detect WordPress template */
if ( !function_exists( 'vce_detect_template' ) ):
	function vce_detect_template() {
		$template = '';
		if ( is_single() ) {
			$template = 'single';
		} else if ( is_page_template( 'template-modules.php' ) ) {
				$template = 'home_page';
			} else if ( is_page() ) {
				$template = 'page';
			} else if ( is_category() ) {
				$template = 'category';
			} else if ( is_tag() ) {
				$template = 'tag';
			} else if ( is_search() ) {
				$template = 'search';
			} else if ( is_author() ) {
				$template = 'author';
			} else if ( is_home() && ( $posts_page = get_option( 'page_for_posts' ) ) && !is_page_template( 'template-modules.php' ) ) {
				$template = 'posts_page';
			} else {
			$template = 'archive';
		}
		return $template;
	}
endif;

/* Get current sidebar options */
if ( !function_exists( 'vce_get_current_sidebar' ) ):
	function vce_get_current_sidebar() {

		/* Default */
		$use_sidebar = 'none';
		$sidebar = 'vce_default_sidebar';
		$sticky_sidebar = 'vce_default_sticky_sidebar';

		$vce_template = vce_detect_template();

		if ( in_array( $vce_template, array( 'search', 'tag', 'author', 'archive' ) ) ) {

			$use_sidebar = vce_get_option( $vce_template.'_use_sidebar' );
			if ( $use_sidebar != 'none' ) {
				$sidebar = vce_get_option( $vce_template.'_sidebar' );
				$sticky_sidebar = vce_get_option( $vce_template.'_sticky_sidebar' );
			}

		} else if ( $vce_template == 'category' ) {
				$obj = get_queried_object();
				if ( isset( $obj->term_id ) ) {
					$meta = vce_get_category_meta( $obj->term_id );
				}

				if ( $meta['use_sidebar'] != 'none' ) {
					$use_sidebar = ( $meta['use_sidebar'] == 'inherit' ) ? vce_get_option( $vce_template.'_use_sidebar' ) : $meta['use_sidebar'];
					if ( $use_sidebar ) {
						$sidebar = ( $meta['sidebar'] == 'inherit' ) ?  vce_get_option( $vce_template.'_sidebar' ) : $meta['sidebar'];
						$sticky_sidebar = ( $meta['sticky_sidebar'] == 'inherit' ) ?  vce_get_option( $vce_template.'_sticky_sidebar' ) : $meta['sticky_sidebar'];
					}
				}

			} else if ( $vce_template == 'single' ) {

				$meta = vce_get_post_meta( get_the_ID() );
				$use_sidebar = ( $meta['use_sidebar'] == 'inherit' ) ? vce_get_option( $vce_template.'_use_sidebar' ) : $meta['use_sidebar'];
				if ( $use_sidebar != 'none' ) {
					$sidebar = ( $meta['sidebar'] == 'inherit' ) ?  vce_get_option( $vce_template.'_sidebar' ) : $meta['sidebar'];
					$sticky_sidebar = ( $meta['sticky_sidebar'] == 'inherit' ) ?  vce_get_option( $vce_template.'_sticky_sidebar' ) : $meta['sticky_sidebar'];
				}

			} else if ( in_array( $vce_template, array( 'home_page', 'page', 'posts_page' ) ) ) {
				if ( $vce_template == 'posts_page' ) {
					$meta = vce_get_page_meta( get_option( 'page_for_posts' ) );
				} else {
					$meta = vce_get_page_meta( get_the_ID() );
				}


				$use_sidebar = ( $meta['use_sidebar'] == 'inherit' ) ? vce_get_option( 'page_use_sidebar' ) : $meta['use_sidebar'];
				if ( $use_sidebar != 'none' ) {
					$sidebar = ( $meta['sidebar'] == 'inherit' ) ?  vce_get_option( 'page_sidebar' ) : $meta['sidebar'];
					$sticky_sidebar = ( $meta['sticky_sidebar'] == 'inherit' ) ?  vce_get_option( 'page_sticky_sidebar' ) : $meta['sticky_sidebar'];
				}

			}

		$args = array(
			'use_sidebar' => $use_sidebar,
			'sidebar' => $sidebar,
			'sticky_sidebar' => $sticky_sidebar
		);

		return $args;
	}
endif;

/* Get post format icon */
if ( !function_exists( 'vce_post_format_icon' ) ):
	function vce_post_format_icon( $layout = '' ) {

		if ( vce_get_option( $layout.'_icon' ) ) {
			$format = get_post_format();

			$icons = array(
				'video' => 'fa-play',
				'audio' => 'fa-music',
				'image' => 'fa-camera',
				'gallery' => 'fa-picture-o'
			);

			//Allow plugins or child themes to modify icons
			$icons = apply_filters( 'vce_post_format_icons', $icons );

			if ( $format && array_key_exists( $format, $icons ) ) {
				return $icons[$format];
			}
		}

		return false;
	}
endif;


/* Get related posts for particular post */
if ( !function_exists( 'vce_get_related_posts' ) ):
	function vce_get_related_posts( $post_id = false ) {

		if ( empty( $post_id ) ) {
			$post_id = get_the_id();
		}

		$args['post_type'] = 'post';

		//Exclude current post form query
		$args['post__not_in'] = array( $post_id );

		//If previuos next posts active exclude them too
		if ( vce_get_option( 'show_prev_next' ) ) {
			$in_same_cat = vce_get_option( 'prev_next_cat' ) ? true : false;
			$prev = get_previous_post( $in_same_cat );

			if ( !empty( $prev ) ) {
				$args['post__not_in'][] = $prev->ID;
			}
			$next = get_next_post( $in_same_cat );
			if ( !empty( $next ) ) {
				$args['post__not_in'][] = $next->ID;
			}
		}

		$num_posts = absint( vce_get_option( 'related_limit' ) );
		if ( $num_posts > 100 ) {
			$num_posts = 100;
		}
		$args['posts_per_page'] = $num_posts;
		$args['orderby'] = vce_get_option( 'related_order' );

		if ( $args['orderby'] == 'views' && function_exists( 'ev_get_meta_key' ) ) {
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = ev_get_meta_key();
		}

		if( $args['orderby'] == 'comments_number'){
			$args['orderby'] = 'comment_count';
		}

		if ( $time_diff = vce_get_option( 'related_time' ) ) {
			$args['date_query'] = array( 'after' => date( 'Y-m-d', strtotime( $time_diff ) ) );
		}

		if ( $type = vce_get_option( 'related_type' ) ) {
			switch ( $type ) {

			case 'cat':
				$cats = get_the_category( $post_id );
				$cat_args = array();
				if ( !empty( $cats ) ) {
					foreach ( $cats as $k => $cat ) {
						$cat_args[] = $cat->term_id;
					}
				}
				$args['category__in'] = $cat_args;
				break;

			case 'tag':
				$tags = get_the_tags( $post_id );
				$tag_args = array();
				if ( !empty( $tags ) ) {
					foreach ( $tags as $tag ) {
						$tag_args[] = $tag->term_id;
					}
				}
				$args['tag__in'] = $tag_args;
				break;

			case 'cat_and_tag':
				$cats = get_the_category( $post_id );
				$cat_args = array();
				if ( !empty( $cats ) ) {
					foreach ( $cats as $k => $cat ) {
						$cat_args[] = $cat->term_id;
					}
				}
				$tags = get_the_tags( $post_id );
				$tag_args = array();
				if ( !empty( $tags ) ) {
					foreach ( $tags as $tag ) {
						$tag_args[] = $tag->term_id;
					}
				}
				$args['tax_query'] = array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'category',
						'field'    => 'id',
						'terms'    => $cat_args,
					),
					array(
						'taxonomy' => 'post_tag',
						'field'    => 'id',
						'terms'    => $tag_args,
					)
				);
				break;

			case 'cat_or_tag':
				$cats = get_the_category( $post_id );
				$cat_args = array();
				if ( !empty( $cats ) ) {
					foreach ( $cats as $k => $cat ) {
						$cat_args[] = $cat->term_id;
					}
				}
				$tags = get_the_tags( $post_id );
				$tag_args = array();
				if ( !empty( $tags ) ) {
					foreach ( $tags as $tag ) {
						$tag_args[] = $tag->term_id;
					}
				}
				$args['tax_query'] = array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'category',
						'field'    => 'id',
						'terms'    => $cat_args,
					),
					array(
						'taxonomy' => 'post_tag',
						'field'    => 'id',
						'terms'    => $tag_args,
					)
				);
				break;

			case 'default':
				break;
			}
		}

		$related_query = new WP_Query( $args );

		return !is_wp_error( $related_query ) ? $related_query : false;
	}
endif;

/* Get options for selection of time dependent posts */
if ( !function_exists( 'vce_get_time_diff_opts' ) ) :
	function vce_get_time_diff_opts() {

		$options = array(
			'-1 day' => __( '1 Day', THEME_SLUG ),
			'-1 days' => __( '3 Days', THEME_SLUG ),
			'-1 week' => __( '1 Week', THEME_SLUG ),
			'-1 month' => __( '1 Month', THEME_SLUG ),
			'-3 months' => __( '3 Months', THEME_SLUG ),
			'-6 months' => __( '6 Months', THEME_SLUG ),
			'-1 year' => __( '1 Year', THEME_SLUG ),
			'0' => __( 'All time', THEME_SLUG )
		);

		//Allow child themes or plugins to change these options
		$options = apply_filters( 'vce_modify_time_diff_opts', $options );

		return $options;
	}
endif;

/* Get options for selection of post ordering */
if ( !function_exists( 'vce_get_post_order_opts' ) ) :
	function vce_get_post_order_opts() {

		$options = array(
			'date' => __( 'Date', THEME_SLUG ),
			'comment_count' => __( 'Number of comments', THEME_SLUG ),
			'views' => __( 'Number of views', THEME_SLUG ),
			'rand' => __( 'Random', THEME_SLUG ),
		);

		//Allow child themes or plugins to change these options
		$options = apply_filters( 'vce_modify_post_order_opts', $options );

		return $options;
	}
endif;

/* Get featured area posts and arguments */
if ( !function_exists( 'vce_get_fa_args' ) ) :
	function vce_get_fa_args() {

		if ( is_category() ) {

			global $vce_cat_fa_args;
			return $vce_cat_fa_args;

		} else if ( is_page_template( 'template-modules.php' ) ) {

				return vce_get_fa_home_args();
		}
	}
endif;

/* Get featured area posts and arguments for modules page */
if ( !function_exists( 'vce_get_fa_home_args' ) ) :
	function vce_get_fa_home_args() {

		$args = array( 'use_fa' => false );

		//Check home page featured area options
		$obj = get_queried_object();
		$meta = vce_get_page_meta( $obj->ID );

		$fa_layout = $meta['fa_layout'];

		if ( $fa_layout ) {

			$q_args['post_type'] = 'post';
			$q_args['ignore_sticky_posts'] = 1;

			if ( !empty( $meta['fa_manual'] ) ) {

				$q_args['orderby'] =  'post__in';
				$q_args['post__in'] =  $meta['fa_manual'];
				$q_args['post_type'] = array('page', 'post');

			} else {
				$num_posts = absint( $meta['fa_limit'] );
				$q_args['posts_per_page'] = $num_posts;
				$q_args['orderby'] = $meta['fa_order'];
				if ( $q_args['orderby'] == 'views' && function_exists( 'ev_get_meta_key' ) ) {
					$q_args['orderby'] = 'meta_value_num';
					$q_args['meta_key'] = ev_get_meta_key();
				}

				if( $q_args['orderby'] == 'comments_number'){
					$q_args['orderby'] = 'comment_count';
				}

				if ( $meta['fa_time'] ) {
					$q_args['date_query'] = array( 'after' => date( 'Y-m-d', strtotime( $meta['fa_time'] ) ) );
				}

				if ( !empty( $meta['fa_cat'] ) ) {
					if($meta['fa_cat_child']){
						$child_cat_temp = array();
						foreach($meta['fa_cat'] as $parent){
							$child_cats = get_categories(array('child_of' => $parent));
							if(!empty($child_cats))	{
								foreach($child_cats as $child){
									$child_cat_temp[] = $child->term_id;
								}
							}
						}
						$meta['fa_cat'] = array_merge($meta['fa_cat'], $child_cat_temp);
					}
					$q_args['category__in'] = $meta['fa_cat'];
				}
			}


			$args['fa_posts'] = new WP_Query( $q_args );

			if ( !is_wp_error( $args['fa_posts'] ) && !empty( $args['fa_posts'] ) ) {

				$num_posts = count( $args['fa_posts']->posts );
				$fa_layout = explode( "_", $fa_layout );
				$args['both'] = count( $fa_layout ) == 2 ? true: false;
				$args['full'] = $fa_layout[0] == 'full' ? true: false;
				$args['full_slider'] = ( $num_posts > 1 && !isset( $fa_layout[1] ) && $fa_layout[0] == 'full' ) ? true : false;
				$args['grid'] = in_array( 'grid', $fa_layout ) ? true: false;
				$args['use_fa'] = true;

				if ( $meta['fa_exclude'] ) {
					global $vce_fa_home_posts;
					$vce_fa_home_posts = array();
					foreach ( $args['fa_posts']->posts as $p ) {
						$vce_fa_home_posts[] = $p->ID;
					}
				}

			}
		}

		//print_r($q_args);

		return $args;
	}
endif;

/* Get featured area posts and arguments for category */
if ( !function_exists( 'vce_get_fa_cat_args' ) ) :
	function vce_get_fa_cat_args() {

		$args = array( 'use_fa' => false );

		//Check category featured area options

		$obj = get_queried_object();
		$meta = vce_get_category_meta( $obj->term_id );

		if ( $meta['fa_layout'] == 'inherit' ) {
			$fa_layout = vce_get_option( 'category_fa' ) ? vce_get_option( 'category_fa_layout' ) : false;
			$num_posts = vce_get_option( 'category_fa' ) ? vce_get_option( 'category_fa_limit' ) : false;
		} else {
			$fa_layout = $meta['fa_layout'];
			$num_posts = $meta['fa_limit'];
		}


		if ( $fa_layout ) {

			$q_args['post_type'] = 'post';
			$q_args['posts_per_page'] = $num_posts;
			$q_args['orderby'] = vce_get_option( 'category_fa_order' );

			if ( $q_args['orderby'] == 'views' && function_exists( 'ev_get_meta_key' ) ) {
				$q_args['orderby'] = 'meta_value_num';
				$q_args['meta_key'] = ev_get_meta_key();
			}

			if( $q_args['orderby'] == 'comments_number'){
					$q_args['orderby'] = 'comment_count';
			}

			if ( $time_diff = vce_get_option( 'category_fa_time' ) ) {
				$q_args['date_query'] = array( 'after' => date( 'Y-m-d', strtotime( $time_diff ) ) );
			}

			$q_args['cat'] = $obj->term_id;

			$args['fa_posts'] = new WP_Query( $q_args );

			if ( !is_wp_error( $args['fa_posts'] ) && !empty( $args['fa_posts'] ) ) {

				$num_posts = count( $args['fa_posts']->posts );

				$fa_layout = explode( "_", $fa_layout );
				$args['both'] = count( $fa_layout ) == 2 ? true: false;
				$args['full'] = $fa_layout[0] == 'full' ? true: false;
				$args['full_slider'] = ( $num_posts > 1 && !isset( $fa_layout[1] ) && $fa_layout[0] == 'full' ) ? true : false;
				$args['grid'] = in_array( 'grid', $fa_layout ) ? true: false;

				$args['use_fa'] = true;
			}

			if ( vce_get_option( 'category_fa_hide_on_pages' ) && absint( get_query_var( 'paged' ) > 1 ) ) {
				$args['use_fa'] = false;
				//Show only on first page
			}
		}

		//print_r($q_args);

		return $args;
	}
endif;

/* Compares two values and sanitazes 0 */
if ( !function_exists( 'vce_compare' ) ):
	function vce_compare( $a, $b ) {
		return (string) $a === (string) $b;
	}
endif;

/* Parse arguments and returns posts for specific module */
if ( !function_exists( 'vce_get_module_query' ) ):
	function vce_get_module_query( $args = array() ) {

		global $vce_fa_home_posts;

		$defaults = array(
			'order' => 'date',
			'limit' => 4,
			'cat' => array(),
			'cat_child' => 0,
			'manual' => array(),
		);



		$args = wp_parse_args( (array) $args, $defaults );

		$q_args['post_type'] = 'post';
		$q_args['ignore_sticky_posts'] = 1;
		$q_args['paged'] = $args['curr_page'];
		global $paged;
		$paged = $args['curr_page'];


		if ( isset( $vce_fa_home_posts ) && !empty( $vce_fa_home_posts ) ) {
			$q_args['post__not_in'] = $vce_fa_home_posts;
		}

		if ( !empty( $args['manual'] ) ) {

			$q_args['posts_per_page'] = absint( count( $args['manual'] ) );
			$q_args['orderby'] =  'post__in';
			$q_args['post__in'] =  $args['manual'];
			$q_args['post_type'] = array('page', 'post');

		} else {

			$q_args['posts_per_page'] = absint( $args['limit'] );
			if ( !empty( $args['cat'] ) ) {

				if($args['cat_child']){
					$child_cat_temp = array();
					foreach($args['cat'] as $parent){
						$child_cats = get_categories(array('child_of' => $parent));
						if(!empty($child_cats))	{
							foreach($child_cats as $child){
								$child_cat_temp[] = $child->term_id;
							}
						}
					}
					$args['cat'] = array_merge($args['cat'], $child_cat_temp);
				}

				$q_args['category__in'] = $args['cat'];
			}
			$q_args['orderby'] = $args['order'];
			if ( $q_args['orderby'] == 'views' && function_exists( 'ev_get_meta_key' ) ) {
				$q_args['orderby'] = 'meta_value_num';
				$q_args['meta_key'] = ev_get_meta_key();
			}
			if( $q_args['orderby'] == 'comments_number'){
					$q_args['orderby'] = 'comment_count';
			}
			if ( $time_diff = $args['time'] ) {
				$q_args['date_query'] = array( 'after' => date( 'Y-m-d', strtotime( $time_diff ) ) );
			}
		}

		return new WP_Query( $q_args );

	}
endif;

/* Creates category color bar on module top */
if ( !function_exists( 'vce_get_cat_class' ) ):
	function vce_get_cat_class( $mod ) {

		if ( empty( $mod['manual'] ) && isset( $mod['cat'] ) && !empty( $mod['cat'] ) ) {
			return 'cat-'.$mod['cat'][0];
		}

		return '';
	}
endif;

/* Wrap posts in main layout if layouts are combined */
if ( !function_exists( 'vce_loop_wrap_div' ) ):
	function vce_loop_wrap_div( $mod, $i, $real_count ) {

		if ( $real_count < ( $mod['top_limit'] + 1 ) ) {
			$mod['top_layout'] = 0;
		}

		if ( ( $mod['top_layout'] && $i == ( $mod['top_limit'] + 1 ) ) || ( !$mod['top_layout'] && $i == 1 ) ) {
			if ( isset( $mod['action'] ) && !empty( $mod['action'] ) && $mod['action'] == 'slider' ) {
				$slider_class = ' vce-slider-pagination vce-slider-'.$mod['layout'];
			} else {
				$slider_class = '';
			}
			return '<div class="vce-loop-wrap'.$slider_class.'">';
		}

		return '';
	}
endif;

/* Check which layout to display when two layouts are combined */
if ( !function_exists( 'vce_module_layout' ) ):
	function vce_module_layout( $mod, $i ) {

		$layout = $mod['top_layout'] && $i <= $mod['top_limit'] ? $mod['top_layout'] : $mod['layout'];

		return $layout;
	}
endif;


/* Check whether to remove padding in module (for layout A and G) */
if ( !function_exists( 'vce_get_mainbox_class' ) ):
	function vce_get_mainbox_class( $mod ) {

		$class = array();

		if ( in_array( $mod['layout'], array( 'a', 'g' ) ) && $mod['limit'] == 1 ) {
			$class[] = 'main-box-nopad';
		}

		if ( !empty( $class ) ) {
			return implode( " ", $class );
		}

		return '';
	}
endif;

/* Creates category color bar on module top */
if ( !function_exists( 'vce_get_column_class' ) ):
	function vce_get_column_class( $mod ) {

		$class = array();

		if ( isset( $mod['one_column'] ) && !empty( $mod['one_column'] ) ) {
			$class[] = 'main-box-half';
		}

		if ( !empty( $class ) ) {
			return implode( " ", $class );
		}

		return '';
	}
endif;

/* Check whether to open div wrapper for one-columned modules*/
if ( !function_exists( 'vce_open_column_wrap' ) ):
	function vce_open_column_wrap( $mod ) {
		global $vce_module_column_flag;

		if ( empty( $vce_module_column_flag ) && isset( $mod['one_column'] ) && !empty( $mod['one_column'] ) ) {
			if ( in_array( $mod['layout'], array( 'c', 'd', 'f' ) ) && in_array( $mod['top_layout'], array( '0', 'c', 'd', 'f' ) ) ) {
				$vce_module_column_flag = 1;
				return '<div class="vce-module-columns">';
			}
		}

		return '';

	}
endif;

/* Check whether to close div wrapper for one-columned modules */
if ( !function_exists( 'vce_close_column_wrap' ) ):
	function vce_close_column_wrap( $modules, $k ) {
		global $vce_module_column_flag;
		if ( !empty( $vce_module_column_flag ) ) {
			if ( !isset( $modules[$k+1] ) || !isset( $modules[$k+1]['one_column'] ) || ( isset( $modules[$k+1]['one_column'] ) && ( !in_array( $modules[$k+1]['layout'], array( 'c', 'd', 'f' ) ) || !in_array( $modules[$k+1]['top_layout'], array( '0', 'c', 'd', 'f' ) ) ) ) ) {
				$vce_module_column_flag = 0;
				return '</div>';
			}

		}

		return '';

	}
endif;

/* Check if module has additional actions */
if ( !function_exists( 'vce_check_module_action' ) ):
	function vce_check_module_action( $modules, $k ) {

		$output = '';

		if ( !empty( $modules[$k]['action'] ) ) {
			switch ( $modules[$k]['action'] ) {
			case 'slider':
				break;
			case 'pagination':
				if ( $k == ( count( $modules ) -1 ) ) {
					ob_start();
					get_template_part( 'sections/pagination/'.$modules[$k]['pagination'] );
					$output = ob_get_contents();
					ob_end_clean();
				}
				break;
			case 'link':
				$output.= '<div id="vce-pagination"><a class="vce-button vce-action-link" href="'.esc_url( $modules[$k]['action_link_url'] ).'">'.esc_html( $modules[$k]['action_link_text'] ).'</a></div>';
				break;
			default:
				break;
			}
		}

		if ( !empty( $output ) ) {
			return $output;
		}
		return '';

	}
endif;

/* Check is post is paginated */
if ( !function_exists( 'vce_is_paginated_post' ) ):
	function vce_is_paginated_post() {

		global $multipage;
		return 0 !== $multipage;

	}
endif;

/* Get settings to pass to main JS file */
if ( !function_exists( 'vce_get_js_settings' ) ):
	function vce_get_js_settings() {

		$js_settings = array();
		$js_settings['sticky_header'] = vce_get_option( 'sticky_header' ) ? true : false;
		$js_settings['sticky_header_offset'] = absint( vce_get_option( 'sticky_header_offset' ) );
		$js_settings['sticky_header_logo'] = vce_get_option_media( 'sticky_header_logo' );
		$js_settings['logo_retina'] = vce_get_option_media( 'logo_retina' );
		$js_settings['rtl_mode'] = vce_get_option( 'rtl_mode' ) ? 1: 0;
		$protocol = is_ssl() ? 'https://' : 'http://';
		$js_settings['ajax_url'] = admin_url( 'admin-ajax.php', $protocol );
		$js_settings['lay_fa_grid_center'] = vce_get_option( 'lay_fa_grid_center' ) ? true : false;

		return $js_settings;
	}
endif;

/* Parse font option */
if ( !function_exists( 'vce_get_font_option' ) ):
	function vce_get_font_option( $option = false ) {

		$font = vce_get_option( $option );
		$native_fonts = vce_get_native_fonts();
		if ( !in_array( $font['font-family'], $native_fonts ) ) {
			$font['font-family'] = "'".$font['font-family']."'";
		}

		return $font;
	}
endif;

/* Parse background option */
if ( !function_exists( 'vce_get_bg_styles' ) ):
	function vce_get_bg_styles( $option = false ) {

		$style = vce_get_option( $option );
		$css = '';

		if ( ! empty( $style ) && is_array( $style ) ) {
			foreach ( $style as $key => $value ) {
				if ( ! empty( $value ) && $key != "media" ) {
					if ( $key == "background-image" ) {
						$css .= $key . ":url('" . $value . "');";
					} else {
						$css .= $key . ":" . $value . ";";
					}
				}
			}
		}


		return $css;
	}
endif;

/* Get topbar items */
if ( !function_exists( 'vce_get_topbar_items' ) ):
	function vce_get_topbar_items() {
		$items = array(
			'0' => __( 'None', THEME_SLUG),
			'top-navigation' => __( 'Top navigation menu', THEME_SLUG ),
			'social-menu' => __( 'Social menu', THEME_SLUG )
		);

		return $items;
	}
endif;

/* Get copyright bar items */
if ( !function_exists( 'vce_get_copybar_items' ) ):
	function vce_get_copybar_items() {
		$items = array(
			'0' => __( 'None', THEME_SLUG),
			'footer-menu' => __( 'Footer menu' , THEME_SLUG),
			'social-menu' => __( 'Social menu', THEME_SLUG ),
			'copyright-text' =>  __( 'Copyright text', THEME_SLUG )
		);

		return $items;
	}
endif;

/* 	Update theme option function */
if ( !function_exists( 'vce_read_time' ) ):
	function vce_read_time( $text ) {
		$words = str_word_count(strip_tags($text));
		if(!empty($words)){
			$time_in_minutes = ceil($words / 200);
			return $time_in_minutes;
		}
		return false;
	}
endif;

?>