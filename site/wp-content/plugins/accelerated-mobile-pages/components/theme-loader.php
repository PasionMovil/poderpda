<?php
if ( 4 == $ampforwp_design_selector ) {
	define('AMPFORWP_CUSTOM_THEME', AMPFORWP_PLUGIN_DIR . 'templates/design-manager/swift' );
}
elseif ( ! defined('AMPFORWP_CUSTOM_THEME') ) {
	define('AMPFORWP_CUSTOM_THEME', AMPFORWP_MAIN_PLUGIN_DIR."/".$ampforwp_design_selector);
}

	require_once(  AMPFORWP_CUSTOM_THEME . '/functions.php' );
	//Filter the Template files to override previous ones
	//add_filter( 'amp_post_template_file', 'ampforwp_custom_header_file', 10, 2 );
	add_filter( 'amp_post_template_file', 'ampforwp_designing_custom_template', 10, 3 );
	//add_filter( 'amp_post_template_file', 'ampforwp_custom_footer_file', 10, 2 );

	// Custom Header
	function ampforwp_custom_header_file( $file, $type ) {
		if ( 'header' === $type ) {
			$file = AMPFORWP_CUSTOM_THEME . '/header.php';
		}
		return $file;
	}

	// Custom Template Files
	function ampforwp_designing_custom_template( $file, $type, $post ) {
	 global $redux_builder_amp;
		// Single file
	    /*if ( is_single() ) {
			if( 'single' === $type && ! ('product' === $post->post_type) ) {
				$file = AMPFORWP_CUSTOM_THEME . '/single.php';
		 	}
		}*/
		if ( is_page() ) {
			if( 'single' === $type && ! ('product' === $post->post_type) ) {
				$file = AMPFORWP_CUSTOM_THEME . '/page.php';
		 	}
		}
	    // Loop Template
	    if ( 'loop' === $type ) {
			$file = AMPFORWP_CUSTOM_THEME . '/loop.php';
		}
	    // Archive
		if ( is_archive() ) {
	        if ( 'single' === $type ) {
	            $file = AMPFORWP_CUSTOM_THEME . '/archive.php';
	        }
	    }
	    $ampforwp_custom_post_page = ampforwp_custom_post_page();
	    // Homepage
		if ( is_home() ) {
			if ( 'single' === $type ) {
	        	$file = AMPFORWP_CUSTOM_THEME . '/index.php';
	        
		        if ( $redux_builder_amp['amp-frontpage-select-option'] == 1 ) {
					$file = AMPFORWP_CUSTOM_THEME . '/page.php';
		        }
		        if ( ampforwp_is_blog() ) {
				 	$file = AMPFORWP_CUSTOM_THEME . '/index.php';
				}
		    }
	    }
	    // is_search
		if ( is_search() ) {
	        if ( 'single' === $type ) {
	            $file = AMPFORWP_CUSTOM_THEME . '/search.php';
	        }
	    }
	    //For template pages
	    switch ( true ) {
	    	case (is_tax()):
	    			$term = get_queried_object();
					$templates = array();
					if ( ! empty( $term->slug ) ) {
						$taxonomy = $term->taxonomy;
						$slug_decoded = urldecode( $term->slug );
						if ( $slug_decoded !== $term->slug ) {
							$templates[] = AMPFORWP_CUSTOM_THEME . "/taxonomy-$taxonomy-{$slug_decoded}.php";
						}
						$templates[] = AMPFORWP_CUSTOM_THEME . "/taxonomy-$taxonomy-{$term->slug}.php";
						$templates[] = AMPFORWP_CUSTOM_THEME . "/taxonomy-$taxonomy.php";
					}
					$templates[] = AMPFORWP_CUSTOM_THEME . "/taxonomy.php";
					foreach ( $templates as $key => $value ) {
						if ( 'single' === $type && file_exists($value) ) {
							$file = $value;
							break;
						}
					}
	    	break;
	    	case (is_category()):
	    		$category = get_queried_object();
				$templates = array();
				if ( ! empty( $category->slug ) ) {
					$slug_decoded = urldecode( $category->slug );
					if ( $slug_decoded !== $category->slug ) {
						$templates[] = AMPFORWP_CUSTOM_THEME . "/category-{$slug_decoded}.php";
					}
					$templates[] = AMPFORWP_CUSTOM_THEME . "/category-{$category->slug}.php";
					$templates[] = AMPFORWP_CUSTOM_THEME . "/category-{$category->term_id}.php";
				}
				$templates[] = AMPFORWP_CUSTOM_THEME . '/category.php';
				foreach ( $templates as $key => $value ) {
					if ( 'single' === $type && file_exists($value) ) {
						$file = $value;
						break;
					}
				}
	    	break;
	    	case (is_tag()):
	    		$tag = get_queried_object();
				$templates = array();
				if ( ! empty( $tag->slug ) ) {
					$slug_decoded = urldecode( $tag->slug );
					if ( $slug_decoded !== $tag->slug ) {
						$templates[] = AMPFORWP_CUSTOM_THEME . "/tag-{$slug_decoded}.php";
					}
					$templates[] = AMPFORWP_CUSTOM_THEME . "/tag-{$tag->slug}.php";
					$templates[] = AMPFORWP_CUSTOM_THEME . "/tag-{$tag->term_id}.php";
				}
				$templates[] = AMPFORWP_CUSTOM_THEME . '/tag.php';
				foreach ( $templates as $key => $value ) {
					if ( 'single' === $type && file_exists($value) ) {
						$file = $value;
						break;
					}
				}
	    	break;
	    	case (is_archive()):
	    		$post_types = array_filter( (array) get_query_var( 'post_type' ) );
				$templates = array();
				if ( count( $post_types ) == 1 ) {
					$post_type = reset( $post_types );
					$templates[] = AMPFORWP_CUSTOM_THEME . "/archive-{$post_type}.php";
				}
				$templates[] = AMPFORWP_CUSTOM_THEME . '/archive.php';
				foreach ( $templates as $key => $value ) {
					if ( 'single' === $type && file_exists($value) ) {
						$file = $value;
						break;
					}
				}
	    	break;
	    	case (is_post_type_archive()):
	    		$post_type = get_query_var( 'post_type' );
				if ( is_array( $post_type ) )
					$post_type = reset( $post_type );

				$obj = get_post_type_object( $post_type );
				if ( ! ($obj instanceof WP_Post_Type) || ! $obj->has_archive ) {
					//return '';
					break;
				}

				$post_types = array_filter( (array) get_query_var( 'post_type' ) );

				$templates = array();

				if ( count( $post_types ) == 1 ) {
					$post_type = reset( $post_types );
					$templates[] = AMPFORWP_CUSTOM_THEME . "/archive-{$post_type}.php";
				}
				$templates[] = AMPFORWP_CUSTOM_THEME . '/archive.php';
				foreach ( $templates as $key => $value ) {
					if ( 'single' === $type && file_exists($value) ) {
						$file = $value;
						break;
					}
				}
	    	break;
	    	case is_single(): 
	    		$object = get_queried_object();

				$templates = array();

				if ( ! empty( $object->post_type ) ) {
					$template = get_page_template_slug( $object );
					if ( $template && 0 === validate_file( $template ) ) {
						$templates[] = $template;
					}

					$name_decoded = urldecode( $object->post_name );
					if ( $name_decoded !== $object->post_name ) {
						$templates[] = AMPFORWP_CUSTOM_THEME . "/single-{$object->post_type}-{$name_decoded}.php";
					}

					$templates[] = AMPFORWP_CUSTOM_THEME . "/single-{$object->post_type}-{$object->post_name}.php";
					$templates[] = AMPFORWP_CUSTOM_THEME . "/single-{$object->post_type}.php";
				}

				$templates[] = AMPFORWP_CUSTOM_THEME . "/single.php";
				
				foreach ( $templates as $key => $value ) {
					if ( 'single' === $type && file_exists($value) ) {
						$file = $value;
						break;
					}
				}
	    	break;
	    }
	    // Polylang Frontpage #1779
	    if ( 'single' === $type && ampforwp_polylang_front_page() && true == $redux_builder_amp['amp-frontpage-select-option'] ) {
			$file = AMPFORWP_CUSTOM_THEME . '/page.php';
		}
	 	return $file;
	}

	// Custom Footer
	function ampforwp_custom_footer_file( $file, $type ) {
		if ( 'footer' === $type ) {
			$file = AMPFORWP_CUSTOM_THEME . '/footer.php';
		}
		return $file;
	}
	// Load the Core Styles of Custom Theme
	//add_action('amp_css', 'ampforwp_custom_style');
	function ampforwp_custom_style() { 
		global $redux_builder_amp; 
		require_once( AMPFORWP_CUSTOM_THEME . '/style.php' );
		// Custom CSS
		echo $redux_builder_amp['css_editor']; 
	}

