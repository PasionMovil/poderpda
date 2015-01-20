/* CSS Document */
/***************Top Margin *******************/
.logo h1 { <?php 
// Get padding
if ( $contentpadding = $data['of_content_padding'] ) { echo 'padding-bottom:'.$contentpadding.'px;'; } else { echo 'padding-bottom:35px;';} 
?>	
}

.logo h1 { <?php 
// Get padding
if ( $logopadding = $data['of_logo_padding'] ) { echo 'padding-top:'.$logopadding.'px;'; } else { echo 'padding-top:35px;';} 
?>	
}

/*******************BG Image*******************/ 
body { 
<?php if ( $backgroundimage = $data['of_background_image'] ) {  
echo 'background-image:url('.$backgroundimage.');';  
} else { 
if ($backgroundtexture = $data['of_texture_bg'] ) { 
if($backgroundtexture != 'none') { 
echo 'background-image:url('.$backgroundtexture.');'; 
} 
} } ?> 
    background-repeat:repeat; 
    background-position:center top; 
    } 
/*******************BG Color*******************/ 
body { 
<?php if ( $backgroundcolor = $data['of_background_color'] ) {  
echo 'background-color:' . $backgroundcolor.';';  
} else { 
echo 'background-color: #fff;';
}?>
}

/*******************Layout Mode*******************/ 
<?php if ( $layoutmode = $data['of_layout_option'] ) {  
	if ($layoutmode == 'boxed') { ?>
.sitecontainer { 
	padding: 0 25px;
	background: #fff;
	box-shadow: 0 0 30px rgba(0,0,0,.1);
	-moz-box-shadow: 0 0 30px rgba(0,0,0,.1);
	-webkit-box-shadow: 0 0 30px rgba(0,0,0,.1);	
}
/* Get Rid of Padding on Boxed Layout*/
@media only screen and (max-width: 342px) {

.sitecontainer {
	padding:0 !important;
	box-shadow: none;
	-moz-box-shadow:none;
	-webkit-box-shadow: none;
}
body {
	background:#fff !important;
}
}

/*  Portrait size to standard 960 (devices and browsers) */
@media only screen and (min-width: 959px) and (max-width: 1009px) {
.sitecontainer {
	padding:0 !important;
	box-shadow: none;
	-moz-box-shadow:none;
	-webkit-box-shadow: none;
}
body {
	background:#fff !important;
}
}
/* Mobile Landscape Size to Portrait (devices and browsers) */
@media only screen and (min-width: 767px) and (max-width: 805px) {
.sitecontainer {
	padding:0 !important;
	box-shadow: none;
	-moz-box-shadow:none;
	-webkit-box-shadow: none;
}
body {
	background:#fff !important;
}
}
<?php } }?>




/****************Button Colors***********************/

.button:hover, a.button:hover, span.more-link:hover, .cancel-reply p a:hover {
		   
<?php 
// Get Button Color
if ( $buttonhover = $data['of_button_hover_color'] ) { echo 'background:'.$buttonhover.'!important;'; }
?>	
color:#fff;
}

.button, a.button, span.more-link, #footer .button, #footer a.button, #footer span.more-link, .cancel-reply p a {
		   
<?php 
// Get Button Color
if ( $buttoncolor = $data['of_button_color'] ) { echo 'background:'.$buttoncolor.';'; }
?>	
color:#fff;
}
.summary, .rating.stars, .rating.points, .rating.percent, .scorebar, 
.categories a:hover, .tagcloud a, .single .categories a, .single .sidebar .categories a:hover, 
.tabswrap ul.tabs li a.active, .tabswrap ul.tabs li a:hover, #footer .tabswrap ul.tabs li a:hover, #footer .tabswrap ul.tabs li a.active, .sf-menu li a:hover, .sf-menu li.sfHover a, 
.pagination a.button.share:hover, #commentsubmit #submit, #cancel-comment-reply-link  {
<?php 
// Get Highlight Color
if ( $highlight = $data['of_highlight_color'] ) { echo 'background:'.$highlight.';'; }
?>	
color:#fff !important;
}

blockquote, .tabswrap .tabpost a:hover, .articleinner h2 a:hover, span.date a:hover {
<?php 
// Get Highlight Color
if ( $highlight ) { echo 'color:'.$highlight.' !important;'; }
?>	
}

h3.pagetitle, h1.pagetitle, .pagetitlewrap span.description {
<?php 
// Get Highlight Color
if ( $highlight ) { echo 'border-color:'.$highlight.';'; }
?>	
}

/****************Link Colors***********************/
p a, a {
<?php 
// Get Link Color
if ( $linkcolor = $data['of_link_color'] ) { echo 'color:'.$linkcolor.';'; } 
?>	
}

h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, p a:hover, 
#footer h1 a:hover, #footer h2 a:hover, #footer h3 a:hover, #footer h3 a:hover, #footer h4 a:hover, #footer h5 a:hover, a:hover, #footer a:hover, .blogpost h2 a:hover, .blogpost .smalldetails a:hover {
<?php 
// Get Link Hover Color
if ( $linkhover = $data['of_link_hover_color'] ) { echo 'color:'.$linkhover.';'; } 
?>	
}

/****************Selection Colors***********************/
::-moz-selection {
<?php 
if ( $highlight = $data['of_highlight_color'] ) { echo 'background:'.$highlight.'; color:#fff;'; } 
?>	
}

::selection {
<?php 
if ( $highlight = $data['of_highlight_color'] ) { echo 'background:'.$highlight.'; color:#fff;'; } 
?>	
}

::selection {
<?php 
if ( $highlight = $data['of_highlight_color'] ) { echo 'background:'.$highlight.'; color:#fff;'; } 
?>	
}

.recent-project:hover {
<?php 
// Get heading font choices
if ( $linkhover = $data['of_link_hover_color'] ) { echo 'border-color:'.$linkhover.' !important;'; } 
?>	
}
/***************Typographic User Values *********************************/

h1, h2, h1 a, h2 a, .blogpost h2 a, h3, .ag_projects_widget h3, h3 a, .aj_projects_widget h3 a, .ajax-select ul.sf-menu a, .pagination .button, .nivo-caption h3.title {
<?php 
// Get heading font choices
if ( $headingfont = $data['of_heading_font'] ) { 

	echo 'font-family:"'.$headingfont['face'].'", arial, sans-serif;'; 

	if ($headingfont['style'] == 'bold italic') {
		echo 'font-weight:bold; font-style:italic;'; // If Bold Italic, Do Separate CSS Calls
	} else if ($headingfont['style'] == 'bold'){
		echo 'font-weight: bold;';
	} else {
		echo 'font-weight:'. $headingfont['style']. ';';	
	}

	echo 'text-transform:'. $headingfont['style2']. ';';

}?>
}

h5, h5 a, .widget h3, .widget h2, .widget h4, .reviewbox h4, .reviewbox .score span, .ajax-select a#news_select, .authorposts h4, h4.widget-title {  
<?php 
// Get tiny font option
if ( $tinyfont = $data['of_tiny_font'] ) { 
	echo 'font-family:"'.$tinyfont['face'].'", arial, sans-serif;';  

	if ($tinyfont['style'] == 'bold italic') {
		echo 'font-weight:bold; font-style:italic;'; // If Bold Italic, Do Separate CSS Calls
	} else if ($tinyfont['style'] == 'bold'){
		echo 'font-weight: bold;';
	} else {
		echo 'font-weight:'. $tinyfont['style']. ';';	
	}

	echo 'text-transform:'. $tinyfont['style2']. ' !important;';

}?>
}

h4, h4 a, .footer .note h4, .footer h4.subheadline, .newspost h4, .paginationbutton .button, .articleinner h2.indextitle, .widget .articleinner h2.indextitle, .articleinner h2.indextitle a, .widget artileinner h2.indextitle a {
<?php 

// Get subfont option
if ($secondaryfont = $data['of_secondary_font'] ) { 
	echo 'font-family:"'.$secondaryfont['face'].'", arial, sans-serif;;'; 

	if ($secondaryfont['style'] == 'bold italic') {
		echo 'font-weight:bold !important; font-style:italic !important;'; // If Bold Italic, Do Separate CSS Calls
	} else if ($secondaryfont['style'] == 'bold'){
		echo 'font-weight: bold !important;';
	} else {
		echo 'font-weight:'. $secondaryfont['style']. ';';	
	}

	echo 'text-transform:'. $secondaryfont['style2']. ' !important;';

}?>
}

.sf-menu a, .ajax-select ul.sf-menu li li a  {
<?php 
// Get nav option
if ($sffont = $data['of_nav_font']) { 
	echo 'font-family:"'.$sffont['face'].'", arial, sans-serif;'; 

	if ($sffont['style'] == 'bold italic') {
		echo 'font-weight:bold; font-style:italic;'; // If Bold Italic, Do Separate CSS Calls
	} else if ($sffont['style'] == 'bold'){
		echo 'font-weight: bold;';
	} else {
		echo 'font-weight:'. $sffont['style']. ';';	
	}

	echo 'text-transform:'. $sffont['style2']. ';';

} ?>
font-size:13px;
}

body, input, p, ul, ol, .button, .ui-tabs-vertical .ui-tabs-nav li a span.text,
.footer p, .footer ul, .footer ol, .footer.button, .credits p,
.credits ul, .credits ol, .credits.button, .footer textarea, .footer input, .testimonial p, 
.contactsubmit label, .contactsubmit input[type=text], .contactsubmit textarea, h2 span.date, .articleinner h1,
.articleinner h2, .articleinner h3, .articleinner h4, .articleinner h5, .articleinner h6, .nivo-caption h1,
.nivo-caption h2, .nivo-caption h3, .nivo-caption h4, .nivo-caption h5, .nivo-caption h6, .nivo-caption h1 a,
.nivo-caption h2 a, .nivo-caption h3 a, .nivo-caption h4 a, .nivo-caption h5 a, .nivo-caption h6 a,
#cancel-comment-reply-link {
<?php 

// Get paragraph option
if ($pfont = $data['of_p_font']) { 
	echo 'font-family:"'.$pfont['face'].'", arial, sans-serif;'; 

	if ($pfont['style'] == 'bold italic') {
		echo 'font-weight:bold; font-style:italic;'; // If Bold Italic, Do Separate CSS Calls
	} else if ($pfont['style'] == 'bold'){
		echo 'font-weight: bold;';
	} else {
		echo 'font-weight:'. $pfont['style']. ';';	
	}

	echo 'text-transform:'. $pfont['style2']. ';';

} ?>
}

<?php if ($sidebar = $data['of_sidebar_width']) { 
	if ($sidebar == 'extended') {
		echo '
		.sidebar {
		width: 300px;
		}
		.maincontent {
		width: 624px;
		}
		.one_col {
		width: 296px;
		}
		#isonormal {
		width: 652px;
		}
		.fullarticle .thumbnailarea {
			width:304px;
		}
		.fullcontent {
			width:300px;
		}

		/*  Portrait size to standard 960 (devices and browsers) */
		@media only screen and (min-width: 768px) and (max-width: 959px) {

		.articlecontainer.nonfeatured, .maincontent {
		width: 423px;
		}
		.nonfeatured .one_col {
		width: 420px;
		}
		#isonormal {
		width: 445px;
		}
		.fullcontent {
		width: 100%;
		}
		#fullcolumn .thumbnailarea {
		width: 420px;
		}
		}

		/* All Mobile Sizes (devices and browser) */
		@media only screen and (max-width: 767px) {
		.maincontent, .sidebar, .fullcontent, #fullcolumn .thumbnailarea {
		width:100%;
		}
		#isonormal {
		width: 436px;
		}

		}

		@media only screen and (max-width: 479px) {	     
		 #isonormal {
	         width:300px;
	     }
		}';
	}
}	?>