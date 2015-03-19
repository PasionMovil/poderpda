<?php

/* Font styles */
$main_font = vce_get_font_option('main_font');
$h_font = vce_get_font_option('h_font');
$nav_font = vce_get_font_option('nav_font');

/* Background */
$body_style = vce_get_bg_styles('body_style');

/* Header styling */
$color_top_bar_bg = vce_get_option('color_top_bar_bg');
$color_top_bar_txt = vce_get_option('color_top_bar_txt');

$header_height = absint(vce_get_option('header_height'));
$logo_position = vce_get_option('logo_position');
$logo_top = isset($logo_position['padding-bottom']) ? absint( $logo_position['padding-bottom']) : 0;
$logo_left = isset($logo_position['padding-right']) ? absint( $logo_position['padding-right']) : 0;
$color_website_title = vce_get_option('color_website_title');
$color_website_desc = vce_get_option('color_website_desc');
$color_header_bg = vce_get_option('color_header_bg');
$color_header_nav_bg = vce_get_option('color_header_nav_bg');
$color_header_txt = vce_get_option('color_header_txt');
$color_header_acc = vce_get_option('color_header_acc');
$color_header_submenu_bg = vce_get_option('color_header_submenu_bg');

/* Single post/page width */
$single_content_width = vce_get_option( 'single_content_width' );
$single_content_width_full = vce_get_option( 'single_content_width_full' );
$page_content_width = vce_get_option( 'page_content_width' );
$page_content_width_full = vce_get_option( 'page_content_width_full' );

/* Content styling */
$color_box_title_bg = vce_get_option('color_box_title_bg');
$color_box_title_txt = vce_get_option('color_box_title_txt');
$color_box_bg = vce_get_option('color_box_bg');
$color_content_bg = vce_get_option('color_content_bg');
$color_content_title_txt = vce_get_option('color_content_title_txt');
$color_content_txt = vce_get_option('color_content_txt');
$color_content_acc = vce_get_option('color_content_acc');
$color_content_meta = vce_get_option('color_content_meta');
$color_pagination_bg = vce_get_option('color_pagination_bg');

/* Sidebar styling */
$color_widget_title_bg = vce_get_option('color_widget_title_bg');
$color_widget_title_txt = vce_get_option('color_widget_title_txt');
$color_widget_bg = vce_get_option('color_widget_bg');
$color_widget_txt = vce_get_option('color_widget_txt');
$color_widget_acc = vce_get_option('color_widget_acc');
$color_widget_sub = vce_get_option('color_widget_sub');

/*Footer styling */
$color_footer_bg = vce_get_option('color_footer_bg');
$color_footer_title_txt = vce_get_option('color_footer_title_txt');
$color_footer_txt = vce_get_option('color_footer_txt');
$color_footer_acc = vce_get_option('color_footer_acc');
?>

body {
	<?php echo $body_style; ?>
}
body,
.mks_author_widget h3,
.site-description,
.meta-category a,
textarea {
	font-family: <?php echo $main_font['font-family']; ?>;
	font-weight: <?php echo $main_font['font-weight']; ?>;
	<?php if(isset($main_font['font-style']) && !empty($main_font['font-style'])):?>
	font-style: <?php echo $main_font['font-style']; ?>;
	<?php endif; ?>
}
h1,h2,h3,h4,h5,h6,
blockquote,
.vce-post-link,
.site-title,
.site-title a,
.main-box-title,
.comment-reply-title,
.entry-title a,
.vce-single .entry-headline p,
.vce-prev-next-link,
.author-title,
.mks_pullquote,
.widget_rss ul li .rsswidget {
	font-family: <?php echo $h_font['font-family']; ?>;
	font-weight: <?php echo $h_font['font-weight']; ?>;	
	<?php if(isset($h_font['font-style']) && !empty($h_font['font-style'])):?>
	font-style: <?php echo $h_font['font-style']; ?>;
	<?php endif; ?>
}
.main-navigation a,
.sidr a{
	font-family: <?php echo $nav_font['font-family']; ?>;
	font-weight: <?php echo $nav_font['font-weight']; ?>;	
	<?php if(isset($nav_font['font-style']) && !empty($nav_font['font-style'])):?>
		font-style: <?php echo $nav_font['font-style']; ?>;
	<?php endif; ?>	
}

.vce-single .entry-content,
.vce-single .entry-headline,
.vce-single .entry-footer {
	width: <?php echo $single_content_width; ?>px;
}

.vce-page .entry-content,
.vce-page .entry-title-page {
	width: <?php echo $page_content_width; ?>px;
}

.vce-sid-none .vce-single .entry-content,
.vce-sid-none .vce-single .entry-headline,
.vce-sid-none .vce-single .entry-footer {
	width: <?php echo $single_content_width_full; ?>px;
}

.vce-sid-none .vce-page .entry-content,
.vce-sid-none .vce-page .entry-title-page,
.error404 .entry-content {
	width: <?php echo $page_content_width_full; ?>px;
	max-width: <?php echo $page_content_width_full; ?>px;
}
body, button, input, select, textarea{
	color: <?php echo $color_content_txt; ?>;		
}
h1,
h2,
h3,
h4,
h5,
h6,
.entry-title a,
.prev-next-nav a{
	color: <?php echo $color_content_title_txt; ?>;	
}
a,
.entry-title a:hover,
.vce-prev-next-link:hover,
.vce-author-links a:hover,
.required,
.error404 h4,
.prev-next-nav a:hover{
	color: <?php echo $color_content_acc; ?>;	
}
.vce-square,
.vce-main-content .mejs-controls .mejs-time-rail .mejs-time-current,
button,
input[type="button"],
input[type="reset"],
input[type="submit"],
.vce-button,
.pagination-wapper a,
#vce-pagination .next.page-numbers,
#vce-pagination .prev.page-numbers,
#vce-pagination .page-numbers,
#vce-pagination .page-numbers.current,
.vce-link-pages a,
#vce-pagination a,
.vce-load-more a,
.vce-slider-pagination .owl-nav > div,
.comment-reply-link:hover,
.vce-featured-section a,
.vce-lay-g .vce-featured-info .meta-category a,
.vce-404-menu a,
.vce-post.sticky .meta-image:before,
#vce-pagination .page-numbers:hover{
	background-color: <?php echo $color_content_acc; ?>;
}
#vce-pagination .page-numbers{
	background: transparent;
	color: <?php echo $color_content_acc; ?>;
	border: 1px solid <?php echo $color_content_acc; ?>;
}
#vce-pagination .page-numbers.current{
	border: 1px solid <?php echo $color_content_acc; ?>;	
}
.widget_categories .cat-item:before,
.widget_categories .cat-item .count{
	background: <?php echo $color_content_acc; ?>;
}
.comment-reply-link{
	border: 1px solid <?php echo $color_content_acc; ?>; 
}
.entry-meta div, 
.entry-meta div a,
.comment-metadata a,
.meta-category span,
.meta-author-wrapped,
.wp-caption .wp-caption-text,
.widget_rss .rss-date,
.sidebar cite,
.site-footer cite,
.sidebar .vce-post-list .entry-meta div, 
.sidebar .vce-post-list .entry-meta div a, 
.sidebar .vce-post-list .fn, 
.sidebar .vce-post-list .fn a,
.site-footer .vce-post-list .entry-meta div, 
.site-footer .vce-post-list .entry-meta div a, 
.site-footer .vce-post-list .fn, 
.site-footer .vce-post-list .fn a{
	color: <?php echo $color_content_meta; ?>; 
}
.main-box-title, .comment-reply-title, .main-box-head{
	background: <?php echo $color_box_title_bg; ?>;
	color: <?php echo $color_box_title_txt; ?>;
}
.sidebar .widget .widget-title a{
	color: <?php echo $color_box_title_txt; ?>;
}
.main-box,
.comment-respond,
.prev-next-nav{
	background: <?php echo $color_box_bg; ?>;
}
.vce-post,
ul.comment-list > li.comment,
.main-box-single,
.ie8 .vce-single,
#disqus_thread,
.vce-author-card,
.vce-author-card .vce-content-outside{
	background: <?php echo $color_content_bg; ?>;
}
.mks_tabs.horizontal .mks_tab_nav_item.active{
	border-bottom: 1px solid <?php echo $color_content_bg; ?>; 
}
.mks_tabs.horizontal .mks_tab_item,
.mks_tabs.vertical .mks_tab_nav_item.active,
.mks_tabs.horizontal .mks_tab_nav_item.active{
	background: <?php echo $color_content_bg; ?>;
}
.mks_tabs.vertical .mks_tab_nav_item.active{
	border-right: 1px solid <?php echo $color_content_bg; ?>; 
}

#vce-pagination, 
.vce-slider-pagination .owl-controls,
.vce-content-outside{
	background: <?php echo $color_pagination_bg; ?>;
}
.sidebar .widget-title{
	background: <?php echo $color_widget_title_bg; ?>; 
	color: <?php echo $color_widget_title_txt; ?>; 
}
.sidebar .widget{
	background: <?php echo $color_widget_bg; ?>; 	
}
.sidebar .widget,
.sidebar .widget li a,
.sidebar .mks_author_widget h3 a,
.sidebar .mks_author_widget h3,
.sidebar .vce-search-form .vce-search-input, 
.sidebar .vce-search-form .vce-search-input:focus{
	color: <?php echo $color_widget_txt; ?>; 
}
.sidebar .widget li a:hover,
.sidebar .widget a,
.widget_nav_menu li.menu-item-has-children:hover:after,
.widget_pages li.page_item_has_children:hover:after{
	color: <?php echo $color_widget_acc; ?>; 
}
.sidebar .tagcloud a {
	border: 1px solid <?php echo $color_widget_acc; ?>; 
}
.sidebar .mks_author_link,
.sidebar .tagcloud a:hover, 
.sidebar .mks_themeforest_widget .more,
.sidebar button,
.sidebar input[type="button"],
.sidebar input[type="reset"],
.sidebar input[type="submit"],
.sidebar .vce-button{
	background-color: <?php echo $color_widget_acc; ?>; 
}
.sidebar .mks_author_widget .mks_autor_link_wrap, 
.sidebar .mks_themeforest_widget .mks_read_more{
	background: <?php echo $color_widget_sub; ?>; 	
}
.sidebar #wp-calendar caption,
.sidebar .recentcomments,
.sidebar .post-date,
.sidebar #wp-calendar tbody{
	color: <?php echo vce_hex2rgba($color_widget_txt, 0.7); ?>; 
}
.site-footer{
	background: <?php echo $color_footer_bg; ?>; 		
}
.site-footer .widget-title{
	color: <?php echo $color_footer_title_txt; ?>; 	
}
.site-footer,
.site-footer .widget,
.site-footer .widget li a,
.site-footer .mks_author_widget h3 a,
.site-footer .mks_author_widget h3,
.site-footer .vce-search-form .vce-search-input, 
.site-footer .vce-search-form .vce-search-input:focus{
	color: <?php echo $color_footer_txt; ?>; 	
}
.site-footer .widget li a:hover,
.site-footer .widget a,
.site-info a{
	color: <?php echo $color_footer_acc; ?>; 
}
.site-footer .tagcloud a {
	border: 1px solid <?php echo $color_footer_acc; ?>; 
}
.site-footer .mks_author_link, 
.site-footer .mks_themeforest_widget .more,
.site-footer button,
.site-footer input[type="button"],
.site-footer input[type="reset"],
.site-footer input[type="submit"],
.site-footer .vce-button,
.site-footer .tagcloud a:hover
{
	background-color: <?php echo $color_footer_acc; ?>; 
}
.site-footer #wp-calendar caption,
.site-footer .recentcomments,
.site-footer .post-date,
.site-footer #wp-calendar tbody,
.site-footer .site-info{
	color: <?php echo vce_hex2rgba($color_footer_txt, 0.7); ?>; 
}

.top-header{
	background: <?php echo $color_top_bar_bg; ?>; 
}
.top-header,
.top-header a{
	color: <?php echo $color_top_bar_txt; ?>; 
}

.header-1-wrapper{
	height: <?php echo $header_height; ?>px;  
	padding-top: <?php echo $logo_top; ?>px;
}
.header-2-wrapper,
.header-3-wrapper{
	height: <?php echo $header_height; ?>px;  
}
.header-2-wrapper .site-branding,
.header-3-wrapper .site-branding{
	top: <?php echo $logo_top; ?>px;
	<?php if(vce_get_option('rtl_mode')): ?>
	right: <?php echo $logo_left; ?>px;
	<?php else: ?>
	left: <?php echo $logo_left; ?>px;
	<?php endif;?>
}

.site-title a, .site-title a:hover{
	color: <?php echo $color_website_title;?>;
}

.site-description{
	color: <?php echo $color_website_desc;?>;
}
.main-header{
	background-color: <?php echo $color_header_bg; ?>;
}
.header-bottom-wrapper{
	background: <?php echo $color_header_nav_bg; ?>;
}
.vce-header-ads{
	margin: <?php echo ($header_height-90)/2; ?>px 0;
}
.header-3-wrapper .nav-menu > li > a{
	padding: <?php echo ($header_height-20)/2; ?>px 15px;	
}

.header-sticky,
.sidr{
<?php if(vce_get_option('header_layout') == 3):?>
	background: <?php echo vce_hex2rgba($color_header_bg, 0.95); ?>;
<?php else: ?>
	background: <?php echo vce_hex2rgba($color_header_nav_bg, 0.95); ?>;
<?php endif; ?>
}
.ie8 .header-sticky{
	background: <?php echo $color_header_bg; ?>;
}

.main-navigation a,
.nav-menu .vce-mega-menu > .sub-menu > li > a,
.sidr li a,
.vce-menu-parent{
	color: <?php echo $color_header_txt; ?>;
}
.nav-menu > li:hover > a, 
.nav-menu > .current_page_item > a, 
.nav-menu > .current-menu-item > a, 
.nav-menu > .current-menu-ancestor > a, 
.main-navigation a.vce-item-selected,
.main-navigation ul ul li:hover > a,
.nav-menu ul .current-menu-item a,
.nav-menu ul .current_page_item a,
.vce-menu-parent:hover,
.sidr li a:hover{
	color: <?php echo $color_header_acc; ?>;
}

.nav-menu > li:hover > a, 
.nav-menu > .current_page_item > a, 
.nav-menu > .current-menu-item > a, 
.nav-menu > .current-menu-ancestor > a, 
.main-navigation a.vce-item-selected,
.main-navigation ul ul,
.header-sticky .nav-menu > .current_page_item:hover > a, 
.header-sticky .nav-menu > .current-menu-item:hover > a, 
.header-sticky .nav-menu > .current-menu-ancestor:hover > a, 
.header-sticky .main-navigation a.vce-item-selected:hover{
	background-color: <?php echo $color_header_submenu_bg; ?>;
}
.search-header-wrap ul{
	border-top: 2px solid <?php echo $color_header_acc; ?>;
}
.vce-border-top .main-box-title{
	border-top: 2px solid <?php echo $color_content_acc; ?>;
}

.tagcloud a:hover,
.sidebar .widget .mks_author_link,
.sidebar .widget.mks_themeforest_widget .more,
.site-footer .widget .mks_author_link,
.site-footer .widget.mks_themeforest_widget .more,
.vce-lay-g .entry-meta div,
.vce-lay-g .fn, 
.vce-lay-g .fn a{
	color: #FFF;
}

<?php
/* Generate css for category colors */
$cat_colors = get_option( 'vce_cat_colors' );
if ( !empty( $cat_colors ) ) {
	foreach ( $cat_colors as $cat => $color ) {
		echo 'a.category-'.$cat.'{ color: '.$color.';}';
		echo 'body.category-'.$cat.' .main-box-title, .main-box-title.cat-'.$cat.' { border-top: 2px solid '.$color.';}';
		echo '.widget_categories li.cat-item-'.$cat.' .count { background: '.$color.';}';
		echo '.widget_categories li.cat-item-'.$cat.':before { background:'.$color.';}';
		echo '.vce-featured-section .category-'.$cat.'{ background: '.$color.';}';
		echo '.vce-lay-g .vce-featured-info .meta-category a.category-'.$cat.'{ background-color: '.$color.';}';
		if(vce_get_option('color_navigation_cat')){
			echo '.main-navigation li.vce-cat-'.$cat.' a:hover { color: '.$color.';}';
		}
		
	}
}

/* Apply uppercase options */
	$text_upper = vce_get_option('text_upper');
	if(!empty($text_upper)){
		foreach($text_upper as $text_class => $val){
			if($val)
			 echo '.'.$text_class.'{text-transform: uppercase;}';
		}
	}
?>