<?php

define( 'MULTIADS_VERSION', '1.0.6' );

add_filter( 'wptouch_setting_defaults_addons', 'wptouch_addon_advertising_settings_defaults' );
add_filter( 'wptouch_founction_advertising_enabled', 'wptouch_addon_advertising_disable_default' );
add_filter( 'wptouch_body_classes', 'wptouch_addon_advertising_body_classes' );

add_action( 'wptouch_body_top_second', 'wptouch_addon_advertising_render_header_ad' );
add_action( 'wptouch_body_bottom', 'wptouch_addon_advertising_render_footer_ad' );
add_filter( 'the_content', 'wptouch_addon_advertising_render_content_ads', 99 );

add_filter( 'wptouch_addon_options', 'wptouch_addon_advertising_render_settings' );

define( 'ADDON_MULTI_ADS_PAGENAME', 'Multi-Ads' );

function wptouch_addon_advertising_get_units() {
	return array( 'header', 'footer', 'pre_content', 'post_content', 'mid_content' );
}

function wptouch_addon_advertising_body_classes( $classes ) {
	$classes[] = 'wptouch-multiads';

	$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );

	if ( $settings->advertising_header_enabled ) {
		$classes[] = 'wptouch-multiads-header';

		$classes[] = 'header-ad';
	}

	return $classes;
}

function wptouch_addon_check_and_render_ad( $name, $code1, $ab_enabled, $code2, $show_blog = false, $show_single = false, $show_pages = false, $show_tax = false, $show_search = false ) {

	$should_show_ad = false;
	$advertising_blob = '';

	if ( $show_blog ) {
		$should_show_ad = $should_show_ad || is_home() || is_archive();
	}

	if ( $show_single ) {
		$should_show_ad = $should_show_ad || is_single();
	}

	if ( $show_pages ) {
		$should_show_ad = $should_show_ad || is_page();
	}

	if ( $show_tax ) {
		$should_show_ad = $should_show_ad || is_category() || is_tag() || is_tax();
	}

	if ( $show_search ) {
		$should_show_ad = $should_show_ad || is_search();
	}

	global $wptouch_pro;
	$is_mobile = ( $wptouch_pro->is_mobile_device && $wptouch_pro->showing_mobile_theme );

	$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );
	if ( $settings->advertising_exclude_urls ) {
		$server_url = strtolower( $_SERVER['REQUEST_URI'] );
		$url_list = explode( "\n", trim( strtolower( $settings->advertising_exclude_urls ) ) );
		foreach( $url_list as $url ) {
			if ( !strpos( $url, '%' ) && strpos( $server_url, '%' ) ) {
				$url = strtolower( urlencode( substr( $url, 1) ) );
				$server_url = substr( strtolower( $server_url ), 1 );
			}
			if ( strpos( $server_url, trim( $url ) ) !== false ) {
				$should_show_ad = false;
				break;
			}
		}
	}

	if ( $should_show_ad && $is_mobile ) {
		// Check for A/B testing
		if ( $ab_enabled && $code2 ) {
			// Do A/B test
			$which_ad = ( mt_rand( 0, 999 ) < 500 ) ? 1 : 2;

			$advertising_blob =  '<div class="wptouch-ad ad-location-' . $name . ' ab-test-' . $which_ad . '">';
			if ( $which_ad == 1 ) {
				$advertising_blob .= $code1;
			} else {
				$advertising_blob .= $code2;
			}

			$advertising_blob .= '</div>';
		} else {
			$advertising_blob = '<div class="wptouch-ad ad-location-' . $name . '">';
			$advertising_blob .= $code1;
			$advertising_blob .= '</div>';
		}
	}

	$advertising_blob = do_shortcode( $advertising_blob );

	return $advertising_blob;
}

function wptouch_addon_advertising_render_header_ad() {
	$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );

	if ( $settings->advertising_header_enabled ) {
		echo wptouch_addon_check_and_render_ad(
			'header',
			$settings->advertising_header_code_1,
			$settings->advertising_header_ab_enabled,
			$settings->advertising_header_code_2,
			$settings->advertising_header_show_blog,
			$settings->advertising_header_show_single_posts,
			$settings->advertising_header_show_pages,
			$settings->advertising_header_show_taxonomy,
			$settings->advertising_header_show_search
		);
	}
}

function wptouch_addon_advertising_render_footer_ad() {
	$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );

	if ( $settings->advertising_footer_enabled ) {
		echo wptouch_addon_check_and_render_ad(
			'footer',
			$settings->advertising_footer_code_1,
			$settings->advertising_footer_ab_enabled,
			$settings->advertising_footer_code_2,
			$settings->advertising_footer_show_blog,
			$settings->advertising_footer_show_single_posts,
			$settings->advertising_footer_show_pages,
			$settings->advertising_footer_show_taxonomy,
			$settings->advertising_footer_show_search
		);
	}
}

function wptouch_addon_advertising_render_content_ads( $content ) {
	$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );

	if ( $settings->advertising_pre_content_enabled ) {
		$content = wptouch_addon_check_and_render_ad(
			'pre_content',
			$settings->advertising_pre_content_code_1,
			$settings->advertising_pre_content_ab_enabled,
			$settings->advertising_pre_content_code_2,
			$settings->advertising_pre_content_show_blog,
			$settings->advertising_pre_content_show_single_posts,
			$settings->advertising_pre_content_show_pages,
			$settings->advertising_pre_content_show_taxonomy,
			$settings->advertising_pre_content_show_search
		) . $content;
	}

	if ( $settings->advertising_mid_content_enabled ) {
		$ad_content = wptouch_addon_check_and_render_ad(
			'mid_content',
			$settings->advertising_mid_content_code_1,
			$settings->advertising_mid_content_ab_enabled,
			$settings->advertising_mid_content_code_2,
			$settings->advertising_mid_content_show_blog,
			$settings->advertising_mid_content_show_single_posts,
			$settings->advertising_mid_content_show_pages,
			$settings->advertising_mid_content_show_taxonomy,
			$settings->advertising_mid_content_show_search
		);

		if ( $settings->advertising_mid_content_minimum_characters < 1 || ( strlen( wp_strip_all_tags( $content ) ) >= $settings->advertising_mid_content_minimum_characters ) ) {
			// Find paragraphs
			$expanded_content = explode( '</p>', $content );
			$total_paragraphs = count( $expanded_content );
			if ( $total_paragraphs > 2 ) {
				$where_to_insert = floor( $total_paragraphs / 2 );

				// If we've detected three elements to content, but the first is an ad or the sharing tools, skip the first element before injecting the ad.
				if ( $where_to_insert == 1 && ( strstr( $expanded_content[ 0 ], 'wptouch-ad' ) || strstr( $expanded_content[ 0 ], 'sharing-options' ) ) ) {
					$where_to_insert = 2;
				}

				$content = str_replace( $expanded_content[ $where_to_insert ] . '</p>', $ad_content . $expanded_content[ $where_to_insert ] . '</p>', $content );
			}
		}
	}

	if ( $settings->advertising_post_content_enabled ) {
		$content = $content . wptouch_addon_check_and_render_ad(
			'post_content',
			$settings->advertising_post_content_code_1,
			$settings->advertising_post_content_ab_enabled,
			$settings->advertising_post_content_code_2,
			$settings->advertising_post_content_show_blog,
			$settings->advertising_post_content_show_single_posts,
			$settings->advertising_post_content_show_pages,
			$settings->advertising_post_content_show_taxonomy,
			$settings->advertising_post_content_show_search
		);
	}

	return $content;
}

function wptouch_addon_advertising_settings_defaults( $settings ) {
	$settings->advertising_exclude_urls = false;

	$units = wptouch_addon_advertising_get_units();

	foreach( $units as $unit ) {
		$name1 = 'advertising_' . $unit . '_type';

		$name2a = 'advertising_' . $unit . '_code_1';
		$name2b = 'advertising_' . $unit . '_code_2';

		$name3 = 'advertising_' . $unit . '_enabled';
		$name3b = 'advertising_' . $unit . '_ab_enabled';

		$name4 = 'advertising_' . $unit . '_show_blog';
		$name5 = 'advertising_' . $unit . '_show_single_posts';
		$name6 = 'advertising_' . $unit . '_show_pages';
		$name7 = 'advertising_' . $unit . '_show_taxonomy';
		$name8 = 'advertising_' . $unit . '_show_search';

		$settings->$name1 = 'custom';
		$settings->$name2a = '';
		$settings->$name2b = '';
		$settings->$name3 = false;
		$settings->$name3b = false;

		$settings->$name4 = true;
		$settings->$name5 = true;
		$settings->$name6 = true;
		$settings->$name7 = true;
		$settings->$name8 = true;
	}

	$settings->advertising_mid_content_minimum_characters = 0;

	return $settings;
}

function wptouch_addon_advertising_disable_default() {
	return false;
}

function wptouch_addon_get_section_name( $i ) {
	switch( $i ) {
		case 'header':
			return __( 'Header Ad', 'wptouch-pro' );
		case 'footer':
			return __( 'Footer Ad', 'wptouch-pro' );
		case 'pre_content':
			return __( 'Pre-content Ad', 'wptouch-pro' );
		case 'post_content':
			return __( 'Post-content Ad', 'wptouch-pro' );
		case 'mid_content':
			return __( 'Mid-content Ad', 'wptouch-pro' );
	}
}

function wptouch_addon_advertising_render_settings( $page_options ) {
	wptouch_add_sub_page(
		ADDON_MULTI_ADS_PAGENAME,
		'wptouch-addon-multi-ads',
		$page_options
	);

	wptouch_add_page_section(
		ADDON_MULTI_ADS_PAGENAME,
		__( 'Ignored URLs', 'wptouch-pro' ),
		'addon-ad-exclude',
		array(
			wptouch_add_pro_setting(
				'textarea',
				'advertising_exclude_urls',
				__( 'Do not show ads on these URLs', 'wptouch-pro' ),
				__( 'Each permalink URL fragment should be on its own line and relative, e.g. "/about" or "/products/store"', 'wptouch-pro' ),
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
		),
		$page_options,
		ADDON_SETTING_DOMAIN
	);

	$units = wptouch_addon_advertising_get_units();
	foreach ( $units as $unit) {
		wptouch_add_page_section(
			ADDON_MULTI_ADS_PAGENAME,
			wptouch_addon_get_section_name( $unit ),
			'addon-ad-' . $unit,
			array(
				wptouch_add_pro_setting(
					'checkbox',
					'advertising_' . $unit . '_enabled',
					__( 'Enabled', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0'
				),
				wptouch_add_pro_setting(
					'checkbox',
					'advertising_' . $unit . '_ab_enabled',
					__( 'Perform A/B test with secondary advertising unit', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_ADVANCED,
					'1.0'
				),
				wptouch_add_pro_setting(
					'textarea',
					'advertising_' . $unit . '_code_1',
					__( 'Primary Advertising Unit', 'wptouch-pro' ),
					__( 'HTML, CSS and JS are all accepted.', 'wptouch-pro' ),
					WPTOUCH_SETTING_BASIC,
					'1.0'
				),
				wptouch_add_pro_setting(
					'textarea',
					'advertising_' . $unit . '_code_2',
					__( 'Secondary Advertising Unit', 'wptouch-pro' ),
					__( 'If defined, secondary advertising code will be shown 50% of the time.', 'wptouch-pro' ),
					WPTOUCH_SETTING_ADVANCED,
					'1.0'
				),
				wptouch_add_pro_setting(
					( $unit != 'pre_content' && $unit != 'mid_content' && $unit != 'post_content' ) ? 'checkbox' : 'hidden',
					'advertising_' . $unit . '_show_blog',
					__( 'Display on archive/post listings', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0'
				),
				wptouch_add_pro_setting(
					'checkbox',
					'advertising_' . $unit . '_show_single_posts',
					__( 'Display on single posts', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0'
				),
				wptouch_add_pro_setting(
					'checkbox',
					'advertising_'. $unit . '_show_pages',
					__( 'Display on static pages', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0'
				),
				wptouch_add_pro_setting(
					( $unit != 'pre_content' && $unit != 'mid_content' && $unit != 'post_content' ) ? 'checkbox' : 'hidden',
					'advertising_' . $unit . '_show_taxonomy',
					__( 'Display on taxonomy listings', 'wptouch-pro' ),
					'', WPTOUCH_SETTING_BASIC,
					'1.0'
				),
				wptouch_add_pro_setting(
					( $unit != 'pre_content' && $unit != 'mid_content' && $unit != 'post_content' ) ? 'checkbox' : 'hidden',
					'advertising_' . $unit . '_show_search',
					__( 'Display in search results', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_BASIC,
					'1.0'
				),
				wptouch_add_pro_setting(
					( $unit != 'mid_content' ) ? 'hidden' : 'text',
					'advertising_' . $unit . '_minimum_characters',
					__( 'Minimum characters in post/page to show ad.', 'wptouch-pro' ),
					'',
					WPTOUCH_SETTING_ADVANCED,
					'1.0'
				)
			),
			$page_options,
			ADDON_SETTING_DOMAIN
		);
	}

	return $page_options;
}
