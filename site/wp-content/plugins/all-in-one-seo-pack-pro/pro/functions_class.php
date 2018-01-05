<?php

/**
 * @package All-in-One-SEO-Pack
 */
/**
 * The general functions class for Pro.
 */
if ( ! class_exists( 'AIO_ProGeneral' ) ) {
	class AIO_ProGeneral extends All_in_One_SEO_Pack_Module {

		function __construct() {
			//		$this->name = __('Performance', 'all-in-one-seo-pack');		// Human-readable name of the plugin
			//		$this->prefix = 'aiosp_performance_';						// option prefix
			$this->file = __FILE__;                                    // the current file
			parent::__construct();
		}


		/*
		*from get_current_options in aioseop_module_class.php
		*/
		static public function getprotax( $get_opts = '', $prefix = null, $location = null ) {

			if ( is_admin() && isset( $_GET['tag_ID'] ) ) {
				$get_opts = get_term_meta( $_GET['tag_ID'], '_' . $prefix . $location, true );
			} else {
				$queried_object = get_queried_object();
				if ( ! empty( $queried_object ) && ! empty( $queried_object->term_id ) ) {
					$get_opts = get_term_meta( $queried_object->term_id, '_' . $prefix . $location, true );
				}
			}

			return $get_opts;
		}


		/*
		*from $this->layout in construct of aioseop_class.php
		*/
		static public function getprooptions( $opts ) {

			$opts['cpt']['options'] = array(
				"enablecpost",
				"cpostactive",
				"taxactive",
				"cpostadvanced",
				"cposttitles",
			);

			return $opts;

		}


		static public function aioseop_embed_handler_html( $return, $url, $attr ) {
			global $aioseop_modules;
			global $post;
			if ( ! empty( $url ) ) {
				$module = $aioseop_modules->return_module( "All_in_One_SEO_Pack_Video_Sitemap" );
				$module->oembed_discovery( $return, $url, null, $post->ID );
			}

			return $return;
		}


		static public function aioseop_ajax_update_oembed() {
			aioseop_ajax_init();
			$output  = '';
			$options = Array();
			parse_str( $_POST['options'], $options );
			foreach ( $options as $k => $v ) {
				$_POST[ $k ] = $v;
			}
			$_POST['action'] = 'aiosp_update_module';
			global $aiosp, $aioseop_modules;
			aioseop_load_modules();
			$aiosp->admin_menu();
			$module            = $aioseop_modules->return_module( "All_in_One_SEO_Pack_Video_Sitemap" );
			$_POST['location'] = null;
			$_POST['Submit']   = 'ajax';
			$module->add_page_hooks();
			$options    = $module->get_current_options( Array(), null );
			$prefix     = $module->get_prefix();
			$ids        = $_POST['options'];
			$post_types = $options["{$prefix}posttypes"];
			if ( ! empty( $ids ) ) {
				$ids = explode( ',', $ids );
				$ids = get_posts( Array(
					'numberposts' => $ids[1] - $ids[0],
					'offset'      => $ids[0],
					'post_type'   => $post_types,
					'post_status' => 'publish',
					'fields'      => 'ids',
				) );
				add_filter( 'embed_oembed_html', Array( $module, 'oembed_discovery' ), 10, 4 );
				add_filter( 'embed_handler_html', 'aioseop_embed_handler_html', 10, 3 );

				foreach ( $ids as $id ) {
					$module->oembed_cache( (int) $id );
					$post = get_post( $id );
					if ( ! empty( $post ) ) {
                        $html   = $module->get_post_content( $id, $post );
						$parse  = $module->parse_video_opts( array( 'id' => $id, 'html' => $html ) ); // try to detect manual embed codes
                        if ( ! empty( $parse ) ) {
                            foreach( $parse as $datum ) {
                                if ( ! empty( $datum['video:player_loc'] ) ) {
                                    $module->oembed_discovery( $html, $datum['video:player_loc'], null, $id, $datum );
                                }
                            }
						}

					}
				}
			}
			$output .= sprintf( __( "Finished scanning posts.", 'all-in-one-seo-pack' ) );
			$output = str_replace( "'", "\'", $output );
			$output = str_replace( "\n", '\n', $output );
			die( sprintf( AIOSEOP_AJAX_MSG_TMPL, $output ) );
		}


	}


}
