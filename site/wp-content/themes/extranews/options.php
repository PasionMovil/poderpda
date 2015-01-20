<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = 'ExtraNews';
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	$shortname = 'of';
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	$options_categories[''] = 'Latest Posts';
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/admin/images/';
		
	// Set the Options Array
$options = array();
$options[] = array( "name" => __("General", "framework"),				 
					"type" => "heading");
					

$options[] = array( "name" => __("Custom Logo", "framework"),
					"desc" => "Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png).<br /><br /> Image-size should be 300px x 65px.",
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload");
					
$options[] = array( "name" => __("Custom Favicon", "framework"),
					"desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload"); 

                                               
$options[] = array( "name" => __("Tracking Code", "framework"),
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea");    					
					
$options[] = array( "name" => __("Customize", "framework"),				 
					"type" => "heading"); 

$url =  get_template_directory_uri() .'/images/skins/textures/';
$options[] = array( "name" => __("Background Texture", "framework"),
					"desc" => "Choose a texture overlay for your background.",
					"id" => $shortname."_texture_bg",
					"std" => "",
					"type" => "images",
					"options" => array(
						'none' => $url . 'call-none.png',
						$url . 'grain.png' => $url . 'grainthumb.png',
						$url . 'canvas.png' => $url . 'canvasthumb.png',
						$url . 'linen.png' => $url . 'linenthumb.png',
						$url . 'graphy.png' => $url . 'graphythumb.png',
						$url . 'vertical-stripes.png' => $url . 'vertical-stripesthumb.png',
						$url . 'cubes.png' => $url . 'cubesthumb.png'
						));

$options[] = array( "name" => __("Custom Background Image", "framework"),
					"desc" => "Upload a custom background image for your theme, or specify the image address of your online background image. (http://yoursite.com/background.png).<br /><br /> Image will be centered and horizontally tile in the featured background area.",
					"id" => $shortname."_background_image",
					"std" => "",
					"type" => "upload");

$options[] = array( "name" => __("Background Color", "framework"),
					"desc" => "Select your background color for your theme.",
					"id" => $shortname."_background_color",
					"std" => "#fff",
					"type" => "color"); 

$options[] = array( "name" => __("Layout Option", "framework"),
					"desc" => "Select weather you want a white background on your content (boxed) or no background (stretched). ",
					"id" => $shortname."_layout_option",
					"std" => "stretched",
					"type" => "radio",
					"options" =>  array(
						'stretched' => 'Stretched',
						'boxed' => 'Boxed'
						));

$options[] = array( "name" => __("Padding Above Logo", "framework"),
					"desc" => "Top Padding for the Logo Section.",
					"id" => $shortname."_logo_padding",
					"std" => "35",
					"type" => "text"); 

$options[] = array( "name" => __("Padding Above Navigation", "framework"),
					"desc" => "Top Padding for the Navigation Section.",
					"id" => $shortname."_content_padding",
					"std" => "35",
					"type" => "text"); 


$options[] = array( "name" => __("Dropdown Menu Text", "framework"),
					"desc" => "Default Text Displayed in the Mobile Dropdown Menu",
					"id" => $shortname."_menu_text",
					"std" => "Select a Page:",
					"type" => "text");

$options[] = array( "name" => __("Top Panel", "framework"),
					"desc" => "Select whether you want a Top Panel to display the Date, Sitename and Secondary Menu",
					"id" => $shortname."_top_bar",
					"std" => "On",
					"type" => "radio",
					"options" =>  array(
						'On' => 'On',
						'Off' => 'Off'
						));

$options[] = array( "name" => __("Sidebar Width", "framework"),
					"desc" => "Select the width of your sidebar. Either slim to show more content, or extended to fit more types of ads.",
					"id" => $shortname."_sidebar_width",
					"std" => "default",
					"type" => "radio",
					"options" =>  array(
						'default' => 'Default (Slim Sidebar)',
						'extended' => 'Extended (300px Width)'
						));
					
$options[] = array( "name" => __("Custom CSS", "framework"),
                    "desc" => "Quickly add some CSS to your theme by adding it to this block.",
                    "id" => $shortname."_custom_css",
                    "std" => "",
                    "type" => "textarea");

$options[] = array( "name" => __("Links &amp; Highlight", "framework"),				 
					"type" => "heading");   

$options[] = array( "name" => __("Highlight Color", "framework"),
					"desc" => "Select Your Theme Highlight Color",
					"id" => $shortname."_highlight_color",
					"std" => "#00a498",
					"type" => "color"); 

$options[] = array( "name" => __("Button Color", "framework"),
					"desc" => "Select Your Top Section Font Color. Overwrites theme color.",
					"id" => $shortname."_button_color",
					"std" => "#00a498",
					"type" => "color"); 

$options[] = array( "name" => __("Button Hover Color", "framework"),
					"desc" => "Select Your Top Section Font Color. Overwrites theme color.",
					"id" => $shortname."_button_hover_color",
					"std" => "#333333",
					"type" => "color"); 

$options[] = array( "name" => __("Link Color", "framework"),
					"desc" => "Select Your Top Section Font Color. Overwrites theme color.",
					"id" => $shortname."_link_color",
					"std" => "#333333",
					"type" => "color"); 

$options[] = array( "name" => __("Link Hover Color", "framework"),
					"desc" => "Select Your Top Section Font Color. Overwrites theme color.",
					"id" => $shortname."_link_hover_color",
					"std" => "#00a498",
					"type" => "color"); 

$options[] = array( "name" => __("Homepage", "framework"),				 
					"type" => "heading");

$options[] = array( "name" => __("Number of Sticky Posts on Homepage", "framework"),
					"desc" => "Select the number of sticky posts you want on the homepage in either your Grid or Slider.",
					"id" => $shortname."_sticky_posts",
					"std" => "9",
					"type" => "select",
					"options" =>  array(
						'3' => '3',
						'4' => '4',
						'5' => '5',						
						'6' => '6',
						'7' => '7',
						'8' => '8',						
						'9' => '9',
						));

$options[] = array( "name" => __("Homepage Slider Autoplay", "framework"),
                    "desc" => "Choose your slideshow autoplay choice.",
                    "id" => $shortname."_home_autoplay",
                    "std" => "true",
                    "type" => "select",
                    "options" =>  array(
                        'false' => 'Autoplay',
                        'true' => "No Autoplay"
                    ));

$options[] = array( "name" => __("Homepage Slideshow Default Autoplay Speed", "framework"),
                    "desc" => "This is for the SLIDER HOMEPAGE ONLY since the grid is random. Speed of the slideshow autoplay in seconds. Whole numbers only. ",
                    "id" => $shortname."_home_autoplay_delay",
                    "std" => "7",
                    "type" => "text");  


$options[] = array( "name" => __("Homepage Slideshow Transitions", "framework"),
                    "desc" => "This is for the SLIDER HOMEPAGE ONLY since the grid is always 'fade' for memory reasons. Choose your slideshow transition style for the Slider Homepage only.",
                    "id" => $shortname."_home_slideshow_trans",
                    "std" => "random",
                    "type" => "select",
                    "options" =>  array(
                        'random' => 'Random',
                        'fade' => 'Fade',
                        'fold' => 'Fold',
                        'sliceDown' => 'Slice Down',
                        'sliceDownLeft' => 'Slide Down Left',
                        'sliceUp' => 'Slice Up',
                        'sliceUpLeft' => 'Slice Up Left',
                        'sliceUpDown' => 'Slice Up Down',
                        'sliceUpDownLeft' => 'Slice Up Down Left',
                        'slideInRight' => 'Slide In Right',
                        'slideInLeft' => 'Slide In Left',
                        'boxRandom' => 'Box Random',
                        'boxRain' => 'Box Rain',
                        'boxRainReverse' => 'Box Rain Reverse',
                        'boxRainGrow' => 'Box Rain Grow',
                        'boxRainGrowReverse' => 'Box Rain Grow Reverse'
                    )); 

$options[] = array( "name" => __("Homepage Non-Featured Category", "framework"),
                    "desc" => "Display news from a specific category.",
                    "id" => $shortname."_news_category",
                    "std" => "",
                    "type" => "select",
                    "options" => $options_categories); 

$options[] = array( "name" => __("Number of Non-Featured Homepage Articles", "framework"),
                    "desc" => "Enter the number of non-featured homepage articles you want to show.",
                    "id" => $shortname."_home_posts",
                    "std" => "4",
                    "type" => "text"); 

$options[] = array( "name" => __("Homepage Non-Featured Category Columns", "framework"),
					"desc" => "Choose post the number of post columns you want to have.",
					"id" => $shortname."_home_column_number",
					"std" => "twocol",
					"type" => "radio",
					"options" =>  array(
						'twocol' => 'Two Columns',
						'onecol' => 'One Column',
					)); 


$options[] = array( "name" => __("Posts", "framework"),				 
					"type" => "heading");

$options[] = array( "name" => __("Post Columns", "framework"),
					"desc" => "Choose post the number of post columns you want to have.",
					"id" => $shortname."_column_number",
					"std" => "twocol",
					"type" => "radio",
					"options" =>  array(
						'twocol' => 'Two Columns',
						'onecol' => 'One Column',
					)); 


$options[] = array( "name" => __("Review Posts Style", "framework"),
					"desc" => "Choose your review posts style.",
					"id" => $shortname."_review_style",
					"std" => "points",
					"type" => "radio",
					"options" =>  array(
						'points' => 'Points',
						'percentage' => 'Percentage',
						'stars' => 'Stars'
					)); 


$options[] = array( "name" => __("Number of Review Criteria per Post", "framework"),
					"desc" => "Keep this as low as you can for memory reasons to keep your load time fast.",
					"id" => $shortname."_review_number",
					"std" => "5",
					"type" => "text");



$options[] = array( "name" => __("Number of Image Slides per Post", "framework"),
					"desc" => "Keep this as low as you can for memory reasons to keep your load time fast.",
					"id" => $shortname."_thumbnail_number",
					"std" => "6",
					"type" => "text"); 

$options[] = array( "name" => __("Slideshow Transitions", "framework"),
                    "desc" => "Choose your slideshow transition style.",
                    "id" => $shortname."_slideshow_trans",
                    "std" => "random",
                    "type" => "select",
                    "options" =>  array(
                        'random' => 'Random',
                        'fade' => 'Fade',
                        'fold' => 'Fold',
                        'sliceDown' => 'Slice Down',
                        'sliceDownLeft' => 'Slide Down Left',
                        'sliceUp' => 'Slice Up',
                        'sliceUpLeft' => 'Slice Up Left',
                        'sliceUpDown' => 'Slice Up Down',
                        'sliceUpDownLeft' => 'Slice Up Down Left',
                        'slideInRight' => 'Slide In Right',
                        'slideInLeft' => 'Slide In Left',
                        'boxRandom' => 'Box Random',
                        'boxRain' => 'Box Rain',
                        'boxRainReverse' => 'Box Rain Reverse',
                        'boxRainGrow' => 'Box Rain Grow',
                        'boxRainGrowReverse' => 'Box Rain Grow Reverse'
                    )); 


$options[] = array( "name" => __("Post Slideshow Default Autoplay Speed", "framework"),
					"desc" => "Speed of the slideshow autoplay in seconds. Whole numbers only. Autoplay is controlled on a via your edit post page.",
					"id" => $shortname."_post_autoplay_delay",
					"std" => "7",
					"type" => "text"); 

$options[] = array( "name" => __("Related Posts", "framework"),
					"desc" => "Do you want to show the latest posts section on your post page?",
					"id" => $shortname."_related_posts",
					"std" => "no",
					"type" => "radio",
					"options" =>  array(
						'no' => 'No',
						'yes' => 'Yes'
					)); 

$options[] = array( "name" => __("Number of Related Posts", "framework"),
                    "desc" => "Choose your number of related posts.",
                    "id" => $shortname."_related_number",
                    "std" => "2",
                    "type" => "select",
                    "options" =>  array(
                        '2' => '2',
                        '4' => '4',
                        '6' => '6',
                        '8' => '8',
                        '10' => '10',
                        '12' => '12'                        
                    )); 


/*
//This is a little "buggy" at the moment.
$options[] = array( "name" => "Post Slideshow Lightbox", "framework"),
					"desc" => "Select whether you want full-size lightbox images to display upon clicking of slide images.",
					"id" => $shortname."_slideshow_popup",
					"std" => "Off",
					"type" => "radio",
					"options" =>  array(
						'On' => 'On',
						'Off' => 'Off'
						));
*/
$options[] = array( "name" => __("PrettyPhoto Skin", "framework"),
					"desc" => "Choose the skin for your PrettyPhoto popups.",
					"id" => $shortname."_prettyphoto_skin",
					"std" => "pp_default",
					"type" => "select",
					"options" => array(
					'pp_default' => 'Default',	
					'facebook' => 'Facebook',	
					'dark_rounded' => 'Dark Rounded',	
					'dark_square' => 'Dark Square',	
					'light_rounded' => 'Light Rounded',	
					'light_square' => 'Light Square'	
					));

$options[] = array( "name" => __("Forms", "framework"),			 
					"type" => "heading");

$options[] = array( "name" => __("Contact Email Address", "framework"),
					"desc" => "Type in the email address you want the contact and quote request forms to mail to.",
					"id" => $shortname."_mail_address",
					"std" => "",
					"type" => "text"); 

$options[] = array( "name" => __("Successfully Sent Heading", "framework"),
					"desc" => "Heading for a successfully sent contact or quote form.",
					"id" => $shortname."_sent_heading",
					"std" => "Thank you for your email.",
					"type" => "text"); 

$options[] = array( "name" => __("Successfully Sent Description", "framework"),
					"desc" => "Heading for a successfully sent contact or quote form.",
					"id" => $shortname."_sent_description",
					"std" => "It will be answered as soon as possible.",
					"type" => "text"); 

$options[] = array( "name" => __("Fonts", "framework"),				 
					"type" => "heading");


$options[] = array( "name" => __("Navigation Font", "framework"),
					"desc" => "Font Settings for sitewide fonts excluding the Top Featured Area. For previews, visit <a href='http://www.google.com/webfonts' target='_blank'>The Google Fonts Homepage</a>",
					"id" => $shortname."_nav_font",
					"std" => array('face' => 'Droid Sans','style' => 'bold','color' => '#fff', 'style2' => 'normal'),
					"type" => "typography_nosize");

$options[] = array( "name" => __("Primary Heading Font", "framework"),
					"desc" => "Font Settings for sitewide primary heading fonts. Page Titles, Portfolio Titles, h1, h2 fonts. For previews, visit <a href='http://www.google.com/webfonts' target='_blank'>The Google Fonts Homepage</a>",
					"id" => $shortname."_heading_font",
					"std" => array('face' => 'Bitter','style' => 'normal','color' => '#333', 'style2' => 'normal'),
					"type" => "typography_nosize");

$options[] = array( "name" => __("Secondary Heading Font", "framework"),
					"desc" => "Font Settings for sitewide secondary heading fonts. Article Titles, Smaller Titles, h3, h4, h5 fonts. For previews, visit <a href='http://www.google.com/webfonts' target='_blank'>The Google Fonts Homepage</a>",
					"id" => $shortname."_secondary_font",
					"std" => array('face' => 'Bitter','style' => 'normal','color' => '#333', 'style2' => 'normal'),
					"type" => "typography_nosize");

$options[] = array( "name" => __("Tiny Details Font", "framework"),
					"desc" => "Font Settings for sitewide fonts excluding the Top Featured Area. For previews, visit <a href='http://www.google.com/webfonts' target='_blank'>The Google Fonts Homepage</a>",
					"id" => $shortname."_tiny_font",
					"std" => array('face' => 'PT Sans Narrow','style' => 'bold','color' => '#123456', 'style2' => 'uppercase'),
					"type" => "typography_nosize");

$options[] = array( "name" => __("Paragraph Font", "framework"),
					"desc" => "Font Settings for sitewide fonts excluding the Top Featured Area. For previews, visit <a href='http://www.google.com/webfonts' target='_blank'>The Google Fonts Homepage</a>",
					"id" => $shortname."_p_font",
					"std" => array('size' => '12px','face' => 'Droid Sans','style' => 'normal','color' => '#123456', 'style2' => 'normal'),
					"type" => "typography_nosize");	


$options[] = array( "name" => __("Latin/Cyrillic Character Support", "framework"),
					"desc" => "Select whether you want Latin/Cyrillic characters in your fonts. Note that some Google fonts don't have these characters, so you'll need to choose ones that do.",
					"id" => $shortname."_cyrillic_chars",
					"std" => "No",
					"type" => "radio",
					"options" =>  array(
						'No' => 'No',
						'Yes' => 'Yes'
						));

$options[] = array( "name" => __("FAQ", "framework"),				 
					"type" => "heading");

$options[] = array( "name" => "How do I set up the homepage?",
					"desc" => "To set up the homepage you must create a new page. Navigate to Pages > Add New. You can give this page any title and you do not have to include any content. Select from 'Homepage - Grid' or 'Homepage - Slider' from the 'Page Attributes' section. Once you've selected the template for the 'Page Attributes' section, click publish. Now that you have created your new page which uses a homepage template, navigate to Settings > Reading and configure the 'Front Page Displays' setting. Select the static page option and choose the page you just created as your front page. Your homepage is now created and can be viewed by visiting your root URL.",
					"id" => $shortname."_info_homepage",
					"std" => "",
					"type" => "info"); 

$options[] = array( "name" => "How do I feature a post on the homepage in either the grid or slider?",
					"desc" => "To feature a post on the homepage you must create a new post. Navigate to Posts > Add New. You can give this page any title, and include any content you'd like. Then, before you click 'publish', click on the 'Edit' button next to Visibility', in the Publish section. Check the box that says 'Stick this post to the front page'. That post will now appear on the homepage in the 'featured' grid or slider area.",
					"id" => $shortname."_info_sticky",
					"std" => "",
					"type" => "info"); 

$options[] = array( "name" => "How do I add the 'Read More' buttons?",
					"desc" => "The 'read more' button is just created by inserting the 'more' tag in the WYSIWYG editor of your post. It's part of wordpress default functionality - just look for the button on the top row near the end of the WYSIWYG editor. That will automatically create the break between the post overview and single post with a 'read more' button that links the two.",
					"id" => $shortname."_info_readmore",
					"std" => "",
					"type" => "info"); 

$options[] = array( "name" => "Additional Questions",
					"desc" => "To provide you with more efficient, searchable support topics, I've set up an <a href='http://themewich.com/forum' target='_blank'>Online Support Forum</a>. Feel free to start a new thread over there and I'd be happy to assist!  </p><p>
<a href='http://themewich.com/forum' target='_blank'>Support Forum</a> |  <a href='http://themewich.com/account/create/' target='_blank'>Create an Account</a> | <a href='http://dl.dropbox.com/u/32356665/item-code.jpg' target='_blank'>Find your Item 'Purchase  Code'</a>",
					"id" => $shortname."_info_questions",
					"std" => "",
					"type" => "info"); 


	return $options;
}