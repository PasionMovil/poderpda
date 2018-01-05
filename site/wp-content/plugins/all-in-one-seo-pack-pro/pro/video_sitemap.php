<?php
/**
 * @package All-in-One-SEO-Pack
 */
/**
 * The Video Sitemap class.
 */
if ( !class_exists( 'All_in_One_SEO_Pack_Sitemap' ) ) {
	include_once( AIOSEOP_PLUGIN_DIR . "modules/aioseop_sitemap.php" );
}
if ( class_exists( 'All_in_One_SEO_Pack_Sitemap' ) && ( !class_exists( 'All_in_One_SEO_Pack_Video_Sitemap' ) ) ) {
	class All_in_One_SEO_Pack_Video_Sitemap extends All_in_One_SEO_Pack_Sitemap {

        private static $_wp_oembed = null;

		function __construct( ) {
			$this->name = __( 'Video Sitemap', 'all-in-one-seo-pack' );	// Human-readable name of the plugin
			$this->prefix = 'aiosp_video_sitemap_';						// option prefix
			$this->file = __FILE__;									// the current file
			parent::__construct();
			$this->default_options['filename']['default'] = 'video-sitemap';
			$this->default_options['videos_only'] = Array( 'name' => __( 'Show Only Posts With Videos', 'all-in-one-seo-pack' ), 'default' => 'On' );
			$this->default_options['video_scan'] = Array( 'name' => __( 'Scan Posts For Videos', 'all-in-one-seo-pack' ), 'type' => 'custom', 'save' => false, 'nowrap' => false );
			$this->layout['default']['options'][] = 'videos_only';
			$this->layout['status']['options'][] = 'video_scan';

			$this->layout['status']['help_link'] = 'https://semperplugins.com/documentation/video-sitemap/';

			$this->help_text['video_scan']		= __( 'Press the Scan button to scan your posts for videos! Do this if video content from a post or posts is not showing up in your sitemap.', 'all-in-one-seo-pack' );
			$this->help_text['videos_only']		= __( 'If checked, only posts that have videos in them will be displayed on the sitemap.', 'all-in-one-seo-pack' );

			$this->help_anchors['video_scan']		= '#scan-posts-for-videos';
			$this->help_anchors['videos_only']		= 'https://semperplugins.com/documentation/video-sitemap/#show-only-posts-with-videos';

			$this->layout['default']['options'][] = 'custom_fields';
			$this->default_options['custom_fields'] = Array( 'name' => __( 'Include Custom Fields', 'all-in-one-seo-pack' ));
			$this->help_text['custom_fields'] = __( 'Enable this option to look for videos in custom fields as well.', 'all-in-one-seo-pack' );
			$this->help_anchors['custom_fields']	= 'https://semperplugins.com/documentation/video-sitemap/#custom-fields-video-sitemap';

			$this->add_help_text_links();

            if ( is_null( self::$_wp_oembed ) ) {
				include_once( ABSPATH . 'wp-includes/class-oembed.php' );
                // instead of using the traditional action 'wp_oembed_add_provider', which adds the providers to its own static wp_oembed object, we will use the filter 'oembed_providers' because we are loading our own instance of wp_oembed
                add_filter('oembed_providers', array( $this, 'add_oembed_providers' ) );
				self::$_wp_oembed = new WP_oEmbed();
            }

			add_filter( $this->prefix . 'prio_item_filter', Array( $this, 'do_post_video'), 10, 3 );
			add_filter( 'embed_oembed_html', Array( $this, 'oembed_discovery' ), 10, 4 );
			add_filter( 'save_post', Array( $this, 'oembed_cache' ) );
			add_filter( $this->prefix . 'xml_namespace', Array( $this, 'add_namespace' ) );
			add_filter( 'aioseop_sitemap_index_filenames', array( $this, 'sitemap_index_filenames' ), 10, 3 );
		}

		function sitemap_index_filenames( $files, $prefix, $suffix ) {
			global $aioseop_options;
			$files[] = array(
				'loc'        => aioseop_home_url ( '/' . $aioseop_options['modules']['aiosp_video_sitemap_options']['aiosp_video_sitemap_filename'] . $suffix ),
				'priority'   => '0.3',
				'changefreq' => 'daily',
			);
			return $files;
		}

        function add_oembed_providers( $providers ) {
            global $wp_version;

            $providers['#https?://(www\.)?videopress.com/v/.*#i'] = array(
                'http://public-api.wordpress.com/oembed?for=' . urlencode(AIOSEOP_PLUGIN_NAME),
                true
            );

            $providers['#https?:\/\/(.+)?(wistia.com|wi.st)\/(medias|embed)\/.*#i'] = array(
                'http://fast.wistia.com/oembed',
                true
            );

            $providers['#https?://(www\.)?flickr\.com/.*#i'] = array(
                'https://www.flickr.com/services/oembed?format={format}',
                true
            );

            if ( version_compare( $wp_version, '4.0.0', '>=' ) ) {
                // viddler was removed in WP 4.0.0
                // also, remove the provider in case it is added back in a later WP version
                $providers['#https?://(www\.)?viddler.com/v/.*#i'] = array(
                    'http://www.viddler.com/oembed/',
                    true
                );
            }
            return $providers;
        }

		function add_namespace( $ns ) {
			$ns['xmlns:video'] = 'http://www.google.com/schemas/sitemap-video/1.1';
			return $ns;
		}
		/** Initialize options, after constructor **/
		function load_sitemap_options() {
			parent::load_sitemap_options();
			if ( $this->option_isset( 'videos_only' ) ) {
				add_filter( $this->prefix . 'post_query', Array( $this, 'fetch_videos_only' ) );
				add_filter( $this->prefix . 'post_counts', Array( $this, 'count_videos_only' ), 10, 2 );
			}
		}
		/** Custom settings **/
		function display_custom_options( $buf, $args ) {
			if ( $args['name'] == "{$this->prefix}video_scan" ) {
				ob_start();
				$this->scan_videos();
				return $buf . ob_get_clean();
			} else {
				return parent::display_custom_options( $buf, $args );
			}
		}

		function do_rewrite_sitemap( $sitemap_type, $page = 0 ) {
				parent::do_rewrite_sitemap( $sitemap_type, $page );
		}

		function scan_videos() {
			set_time_limit(0);
			//$post_ids = get_posts( Array( 'numberposts' => -1, 'fields' => 'ids', 'post_type' => 'any', 'no_found_rows' => true ) );
			if ( $this->option_isset( 'videos_only' ) )
				remove_filter( $this->prefix . 'post_counts', Array( $this, 'count_videos_only' ), 10, 2 );
			$max = $this->get_total_post_count( Array( 'post_type' => $this->options["{$this->prefix}posttypes"], 'post_status' => 'publish' ) );
			if ( $this->option_isset( 'videos_only' ) )
				add_filter( $this->prefix . 'post_counts', Array( $this, 'count_videos_only' ), 10, 2 );
			if ( $max > 0 ) {
			?><div id="aiosp_sitemap_oembed_scan"><input name=aiosp_sitemap_scan id=aiosp_sitemap_scan type="submit" value="<?php
				echo __( 'Scan', 'all-in-one-seo-pack' ); ?>" class="button-primary"><div id="aiosp_sitemap_scan" style="display:inline-block;margin-left:10px;""></div></div><progress id=p style="width:100%;" value=0 max=<?php echo (int)$max;
			?>></progress><script>
			jQuery(document).ready(function() {
				var min = 5;
				var cur = 5;
				var max = 25000;
				var count = <?php echo (int)$max; ?>;
				var scale = 2;
				jQuery("div#aiosp_sitemap_oembed_scan").delegate("input[name='aiosp_sitemap_scan']", "click", function(e) {
					e.preventDefault();
					var c = 0;
					var i = 0;
					var start;
					var end;
					var succ = function() {
						var diff = new Date().getTime() - start;
						if ( diff > 2 ) {
							if ( diff < 2500 ) {
								scale *= 2;
								if ( scale > 4 ) scale = 4;
							} else if ( diff < 5000 ) {
								if ( scale > 3 ) scale = 3;
							} else if ( scale > 2 ) scale = 2;
							if ( diff < 15000 )
								cur *= scale;
							else {
								cur /= scale;
								scale = 1 + ( (scale - 1) / 2 );
								if ( scale < 1.1 ) scale = 1.1;
							}
							cur = Math.round( cur );
							if ( cur < min ) cur = min;
							if ( cur > max ) cur = max;
							// console.log('milliseconds passed', diff + ' ' + cur);
						}
						c = i;
						jQuery("#p").val(c);
						if ( c >= count ) return;
						var s = "";
						i = c;
						s += i;
						i = c + cur;
						if ( c + cur > count ) i = count;
						s += ',';
						s += i;
						start = new Date().getTime();
						aioseop_handle_post_url('aioseop_ajax_update_oembed', 'sitemap_scan', s, succ );
					}
					start = new Date().getTime();
					succ();
					return false;
				});
			});
			</script>
			<?php
			}
		}
		function do_post_video( $pr_info, $post, $args ) {
			if ( !empty( $post ) ) {
				$post_id = $post->ID;
				$opts = get_post_meta( $post_id, '_aioseop_oembed_info', true );
				if ( !empty( $opts ) ) {
					$pr_info["video:video"] = Array();
                    $videos     = array();
					foreach( $opts as $o ) {
						$videos[] = $this->parse_video_opts( $o );
                    }
                    if ( $videos ) {
						// weed out duplicate videos e.g. embedding daily motion causes it to insert 2 videos
						$urls	= array();
                        foreach ( $videos as $video ) {
                            if ( ! is_array( $video ) ) {
                                $video  = array( $video );
                            }
                            foreach ( $video as $vid ) {
								if ( ! in_array( $vid['video:player_loc'], $urls ) ) {
	                                $pr_info["video:video"][] = $vid;
									$urls[]	= $vid['video:player_loc'];
								}
                            }
                        }
                    }
					return $pr_info;
				}
			}
			if ( $this->option_isset( 'videos_only' ) ) return Array();
			return $pr_info;
		}
		function fetch_videos_only( $args ) {
			$args['meta_query'] = Array(
				Array( 'key' => '_aioseop_oembed_info', 'compare' => 'EXISTS' )
			);
			return $args;
		}
		function count_videos_only( $counts, $args ) {
			if ( !empty( $counts ) ) {
				$status = 'inherit';
				if ( !empty( $args['post_status'] ) ) $status = $args['post_status'];
				if ( !is_array( $counts ) ) {
					$counts = Array( $args['post_type'] => $counts );
				}
				foreach( $counts as $post_type => $count ) {
					$args = Array( 'numberposts' => -1, 'post_status' => 'publish', 'fields' => 'ids', 'post_type' => $post_type, 'status' => $status );
					if ( $post_type == 'attachment' )
						$args['status'] = 'inherit';
					$args = $this->fetch_videos_only( $args );
					$q = new WP_Query( $args );
					$counts[$post_type] = $q->found_posts;
				}
			}
			return $counts;
		}
		function parse_video_opts( $data, $return_single = false ) {
            $opts   = array();
			$fields = array(
				'thumbnail_url' => 'video:thumbnail_loc',
				'title' => 'video:title',
				'description' => 'video:description',
				'duration' => 'video:duration',
				'author_name' => 'video:uploader',
				'html' => 'video:player_loc'
			);

            $links      = array();
			if ( !empty( $data ) ) {
				$data = (array) $data;
				if ( !empty( $data['html'] ) ) {
                    $dom_document = new DOMDocument();
				    @$dom_document->loadHTML( $data['html'] );
				    $dom_xpath = new DOMXpath( $dom_document );
				    $iframes = $dom_xpath->query( "//iframe" );
                    $embeds = $dom_xpath->query( "//embed" );
                    $anchors = $dom_xpath->query( "//a" );
                    $scripts = $dom_xpath->query( "//script" );
				    if (!is_null( $iframes ) && $iframes->length ) {
				        foreach ( $iframes as $iframe ) {
				            if ( $iframe->hasAttributes() ) {
				                $attributes = $iframe->attributes;
				                if ( !is_null( $attributes ) ) {

                          foreach ( $attributes as $index=>$attr ){
						                if ( $attr->name == 'src' ) {
                                            $links[]        = $attr->value;
						                }
                                    }
                                }
                            }
                        }
					}
                    if (!is_null( $embeds ) && $embeds->length ) {
                        foreach ( $embeds as $embed ) {
                            if ( $embed->hasAttributes() ) {
                                $attributes = $embed->attributes;
                                if ( !is_null( $attributes ) ){
                                    foreach ( $attributes as $index=>$attr ){
                                        if ( $attr->name == 'src' ) {
                                            $links[]        = $attr->value;
                                        }
                                    }
                                }
                             }
                        }
                    }
                    if (!is_null( $anchors ) && $anchors->length ) {
                        foreach ( $anchors as $anchor ) {
                            if ( $anchor->hasAttributes() ) {
                                $attributes = $anchor->attributes;
                                if ( !is_null( $attributes ) ){
                                    foreach ( $attributes as $index=>$attr ){
                                        if ( $attr->name == 'href' ) {
                                            $links[]        = $attr->value;
                                        }
                                    }
                                }
                             }
                        }
                    }
                    if (!is_null( $scripts ) && $scripts->length ) {
                        foreach ( $scripts as $script ) {
                            if ( $script->hasAttributes() ) {
                                $attributes = $script->attributes;
                                if ( !is_null( $attributes ) ){
                                    foreach ( $attributes as $index=>$attr ){
                                        if ( $attr->name == 'src' ) {
                                            $links[]        = $attr->value;
                                        }
                                    }
                                }
                             }
                        }
                    }
				}

                $this->scrub_video_links( $links );

				if ( $links ) {
                    foreach ( $links as $index => $link ) {
                        if ( ! filter_var( $link, FILTER_VALIDATE_URL ) ) {
							continue;
						}

					    $parse_url = parse_url( str_replace( ':////', '://', esc_url_raw( $link ) ) );
                        if ( empty( $parse_url['scheme'] ) ) {
                            $parse_url['scheme']    = 'http';
                            $link                   = str_replace( ':////', '://', esc_url_raw( $this->unparse_url( $parse_url ) ) );
                        }

                        $query_params   = parse_str( parse_url( $link, PHP_URL_QUERY ) );

                        $opt            = array();
                        foreach( $fields as $k => $v ) {
                            if ( ! empty( $query_params[$k] ) ) {
                                $opt[$v] = ent2ncr( esc_attr( $query_params[$k] ) );
                            } elseif ( ! empty( $data[$k] ) ) {
                                $opt[$v] = ent2ncr( esc_attr( $data[$k] ) );
                            }
                        }

                        $opt['video:player_loc'] = esc_url( $link );

                        if ( empty( $opt['video:description'] ) ) {
                            $opt['video:description'] = "Video ";
                            if ( ! empty($opt['video:title']) ) {
                                $opt['video:description'] .= $opt['video:title'];
                            }
                            if ( ! empty( $opt['video:uploader'] ) ) {
                                $opt['video:description'] .= ' by ' . $opt['video:uploader'];
                            }
                        }

						if ( ! empty ( $data['id'] ) && ! empty( $opt['video:player_loc'] ) ) {
							$this->oembed_discovery( $link, $opt['video:player_loc'], null, $data['id'] );
						}

                        if ( ! empty( $opt['video:player_loc'] ) && empty( $opt['video:thumbnail_loc'] ) ) {
                            $this->get_additional_data( $opt );
                        }


                        if ( $return_single ) {
                            $opts   = $opt;
                        } else {
                            $opts[] = $opt;
                        }
                    }
                }
			}

            return $opts;
		}


        /** scrub the links that supposedly contain the video and remove the ones that are tainted or do not obviously contain a video **/
        function scrub_video_links ( &$links ) {
            foreach ( $links as &$link ) {
                $link           = urldecode( $link );
                if ( strpos( $link, 'facebook.com' ) !== false ) {
                    if ( strpos( $link, '/videos/' ) !== false ) {
                        // the url can be of type 
                        // https://www.facebook.com/plugins/video.php?href=https://www.facebook.com/facebook/videos/10155214512696729/&show_text=0&width=560
                        // OR
                        // https://www.facebook.com/facebook/videos/10155214512696729/
                        $args   = explode( '/', $link );
                        $args   = array_filter( $args );
                        // the video id is usually after /videos/
                        $index  = array_search( 'videos', $args );
                        if ( $index !== false ) {
                            $id     = $args[ $index + 1 ];
                            if ( ! is_numeric( $id ) ) {
                                $link   = null;
                            } else {
                                // change the link so that it becomes a definitive video link
                                $link   = "https://www.facebook.com/facebook/videos/$id";
                            }
                        } else {
                            $link   = null;
                        }
                    } else {
                        $link   = null;
                    }
                } else {
					// if the URL does not begin with a scheme and instead begins with //, it will be rejected. So let's correct it.
					if ( strpos( $link, 'http' ) !== 0 && strpos( $link, '//' ) === 0) {
						$link	= 'http:' . $link;
					}
				}

				// ignore js files: some vidoes, e.g. wordpress.tv embed the iframe as well as the script so the video is detected twice
				if ( strpos( $link, '.js' ) !== false ) {
					// make sure that this is indeed a url that refers to the js file and not a url that might have the string .js
					$path	= parse_url( $link, PHP_URL_PATH );
					if ( strpos( $path, '.js' ) === ( strlen( $path ) - 3 ) ) {
						$link		= null;
					}
				}
            }
            $links  = array_filter( $links );
        }

        /** if certain attributes (such as thumnbnail) have not been provided, try a service-specific method to fetch them **/
        function get_additional_data( &$opt ) {
            $link   = $opt['video:player_loc'];
            if ( strpos( $link, 'facebook.com' ) !== false ) {
                if ( strpos( $link, '/videos/' ) !== false ) {
                    $args   = explode( '/', $link );
                    $args   = array_filter( $args );
                    // the video id is usually after /videos/
                    $index  = array_search( 'videos', $args );
                    if ( $index !== false ) {
                        $id     = $args[ $index + 1 ];
                        if ( is_numeric( $id ) ) {
                            $opt['video:title'] = $id;
                            $opt['video:thumbnail_loc'] = "http://graph.facebook.com/$id/picture";
                        }
                    }
                }
            }
        }

		function oembed_discover_url( $url ) {
			$data = array();
			if ( !empty( $url ) ) {
                $url        = $this->massage_oembed_url( $url );
				$parse_url = parse_url( str_replace( ':////', '://', esc_url_raw( $url ) ) );
				if ( empty( $parse_url['scheme'] ) ) $parse_url['scheme'] = 'http';
				$url = $this->unparse_url( $parse_url );

				include_once( ABSPATH . 'wp-includes/class-oembed.php' );
				$wp_oembed = self::$_wp_oembed;
				$provider = false;
                foreach ( $wp_oembed->providers as $matchmask => $d ) {
                        list( $providerurl, $regex ) = $d;
                        if ( !$regex ) {
                                $matchmask = '#' . str_replace( '___wildcard___', '(.+)', preg_quote( str_replace( '*', '___wildcard___', $matchmask ), '#' ) ) . '#i';
                                $matchmask = preg_replace( '|^#http\\\://|', '#https?\://', $matchmask );
                        }
                        if ( preg_match( $matchmask, $url ) ) {
                                $provider = str_replace( '{format}', 'json', $providerurl ); // JSON is easier to deal with than XML
                                break;
                        }
                }
				if ( empty( $provider ) ) {
					$provider = $wp_oembed->discover( $url );
                }
				if ( !empty( $provider ) ) {
					$data = $wp_oembed->fetch( $provider, $url, Array( 'discover' => true ) );
					if ( $data && 'video' !== $data->type ) {
						// Exclude everything but video embeds.
						$data = array();
					}

                    // if its a wordpress.tv url, it will resolve into a videopress.com video
                    // but the oEmbed does not give a thumnbnail so we have to manipulate this to get it to parse as a videopress video instead
                    if ( $data && strpos( $url, 'wordpress.tv' ) !== false && strpos( $data->html, 'videopress.com' ) !== false ) {
                        $data   = $this->parse_video_opts( array( 'html' => $data->html ) );
                        if ( is_array( $data ) && isset( $data[0]['video:player_loc'] ) && strpos( $data[0]['video:player_loc'], 'videopress.com' ) !== false ) {
                            $data   = $this->oembed_discover_url( $data[0]['video:player_loc'] );
                        }
                    }
                }
			}
			return $data;
		}

        /** do we need to change the url in any way so that the oEmbed provider can get the correct information? **/
        function massage_oembed_url( $url ) {
            $providers  = array(
                // videopress iframe embeds have a url structure like /embed/ but the oEmbed endpoint only recognizes /v/ type urls
                'videopress.com/embed/' => 'videopress.com/v/',
                // funnyordie iframe embeds have a url structure like /embed/ but the oEmbed endpoint only recognizes /videos/ type urls
                'funnyordie.com/embed/' => 'funnyordie.com/videos/',
                // viddler iframe embeds have a url structure like /embed/ but the oEmbed endpoint only recognizes /v/ type urls
                'viddler.com/embed/' => 'viddler.com/v/',
                // youtube iframe embeds have a url structure like /embed/ but the oEmbed endpoint only recognizes /watch?v= type urls
                'youtube.com/embed/' => 'youtube.com/watch?v=',
            );

            foreach( $providers as $orig => $new ) {
                if ( strpos( $url, $orig ) !== false ) {
                    // if the target URL has the structure of a query string then, to ensure the final URL does not look like www.xxx.com?a=b?c=d
                    // lets change the existing query string to start with an & instead so that it reads www.xxx.com?a=b&c=d
                    if ( strpos( $new, '?' ) !== false ) {
                        $url    = str_replace( '?', '&', $url );
                    }
                    return str_replace( $orig, $new, $url );
                }
            }
            return $url;
        }

		/** oEmbed discovery - save in post meta **/
		function oembed_discovery( $html, $url, $c, $id, $data=null ) {
			$opts = get_post_meta( $id, '_aioseop_oembed_info', true );
			if ( empty( $opts ) ) $opts = Array();
			if ( !empty( $opts[$url] ) ) return $html;

            // if we have custom parsed the HTML and determined all attributes ourselves, don't let ombed do it
            if ( is_null( $data ) || ! isset( $data['custom'] ) ) {
    			$info = $this->oembed_discover_url( $url );
            } else {
                $info   = (object) $data['custom'];
            }
			if ( !empty( $info ) ) {
				$opts[$url] = $info;
				update_post_meta( $id, '_aioseop_oembed_info', $opts );
			}
			return $html;
		}

		function oembed_cache( $id ) {
			global $wp_embed;
			global $post;
			$old_post = $post;
			delete_post_meta( (int)$id, '_aioseop_oembed_info' );
		//	$wp_embed->cache_oembed( (int)$id );
			$post = get_post( (int)$id );
            $contents   = $this->get_post_content( (int)$id, $post );
			if ( ! empty( $contents ) ) {
				$wp_embed->post_ID = (int)$post->ID;
				$wp_embed->usecache = false;
				$content = $wp_embed->run_shortcode( $contents );
				$wp_embed->autoembed( $content );
				$wp_embed->usecache = true;
			}
			$post = $old_post;
		}

        /** get the post content + excerpt + (if enabled) all the post meta data **/
        function get_post_content( $id, $post = null ) {
            if ( ! $post ) {
                $post   = get_post( $id );
            }

			$content	= $post->post_content;
            if ( ! empty( $post->post_excerpt ) ) {
				$content	.= ' <br /> ' . $post->post_excerpt;
			}
			// enclose tags with <p> tags after changing all newlines to <br>s
			$content	.= '<p>' . str_replace( '<br />', '</p><p>', nl2br( $content ) ) . '</p>';
			// get the non-tag content and enclose each word with <p> tags (for the case where embeddable content is provided in the text)
			$content	.= '<p>' . implode( '</p><p>', explode( ' ', strip_tags( $content ) ) ) . '</p>';
            if ( $this->option_isset( 'custom_fields' ) ) {
                $meta       = get_post_meta( $id );
                if ( $meta ) {
                    foreach ( $meta as $key => $value ) {
                        // ignore the keys that start with _wp and _oembed
                        if ( ! ( strpos( $key, '_wp' ) === 0 || strpos( $key, '_oembed' ) === 0 ) ) {
                            $content    .= ' <p>' . html_entity_decode( $value[0] ) . '</p>';
                        }
                    }
                }
            }
            return $content;
        }

	}
}
