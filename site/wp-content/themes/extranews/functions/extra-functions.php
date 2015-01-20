<?php
/*-----------------------------------------------------------------------------------*/
/*	Extra Functions
/*  Created to avoid having to edit functions.php for common theme alterations.
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Get Featured Homepage Posts Layout
/*-----------------------------------------------------------------------------------*/

function ag_featured_posts_layout ($stickyoption, $counter) {
	
		global 	$stickyoption, 
				$fcol, 
				$fsize;
		
		/* Create the formats */
		
		switch ($stickyoption) {

			case '2': 

			if ( ($counter == 1) ) {
					$fcol = 'two_col';
					$fsize = '';
				} else {
					$fcol = 'one_col';
					$fsize = '';
				}
			break;
			
			case '3':  
				$fcol = 'one_col';
				$fsize = '';
			break;
			
			case '4':
			if ( ($counter == 3 || $counter == 4) ) {
					$fcol = 'one_col';
					$fsize = 'half';
				} else {
					$fcol = 'one_col';
					$fsize = '';
				}
			break;
			
			case '5':
			if ( ($counter == 1) ) {
					$fcol = 'two_col';
					$fsize = '';
				} else {
					$fcol = 'one_col';
					$fsize = '';
				}
			break;
			
			case '6':
			if ( $counter == 5 || $counter == 6 ) {
					$fcol = 'one_col';
					$fsize = 'half';
				} else {
					if ( $counter == 1 ) {
					  $fcol = 'two_col';
					} else {
					$fcol = 'one_col';
					}
					$fsize = '';
				}
			break;
			
			case '7':
			if (  $counter == 4 || $counter == 5 || $counter == 6 || $counter == 7 || $counter == 8 ) {
					$fcol = 'one_col';
					$fsize = 'half';
				} else {
					if ( $counter == 1 ) {
					  $fcol = 'two_col';
					} else {
					$fcol = 'one_col';
					}
					$fsize = '';
				}
			break;
			
			case '8':
			if (  $counter == 2 || $counter == 4 || $counter == 5 || $counter == 8) {
					$fcol = 'one_col';
					$fsize = 'half';
				} else {
					$fcol = 'one_col';
					$fsize = '';
				}
			break;
			
			case '9':
				if (($counter % 2 == 0) || ($counter % 3 == 0) || ($counter % 4 == 0)) {
					$fcol = 'one_col';
					$fsize = 'half';
				} else {
					$fcol = 'one_col';
					$fsize = '';
				}
			break;
		
		}
}

/*-----------------------------------------------------------------------------------*/
/* Get Featured Index Posts Layout
/*-----------------------------------------------------------------------------------*/

function ag_featured_index_layout ($stickyoption, $counter) {
	
		global 	$stickyoption, 
				$fcol, 
				$fsize;
		
		/* Create the formats */
		
		switch ($stickyoption) {

			case '1':
				$fcol = 'two_col';
				$fsize = '';
			break;

			case '2': 
				$fcol = 'one_col';
				$fsize = '';
			break;
			
			case '3':  
			if ( $counter == 1 ) {
					$fcol = 'one_col';
					$fsize = '';
				} else {
					$fcol = 'one_col';
					$fsize = 'half';
				}
			break;
			
			case '4':
			if ( ($counter == 3 || $counter == 4) ) {
					$fcol = 'one_col';
					$fsize = 'half';
				} else {
					$fcol = 'one_col';
					$fsize = '';
				}
			break;
			
			case '5':
			if ( ($counter == 1) ) {
					$fcol = 'two_col';
					$fsize = '';
				} else {
					$fcol = 'one_col';
					$fsize = '';
				}
			break;
			
			case '6':
			if ( $counter == 5 || $counter == 6 ) {
					$fcol = 'one_col';
					$fsize = 'half';
				} else {
					if ( $counter == 1 ) {
					  $fcol = 'two_col';
					} else {
					$fcol = 'one_col';
					}
					$fsize = '';
				}
			break;
			
			case '7':
			if (  $counter == 4 || $counter == 5 || $counter == 6 || $counter == 7 || $counter == 8 ) {
					$fcol = 'one_col';
					$fsize = 'half';
				} else {
					if ( $counter == 1 ) {
					  $fcol = 'two_col';
					} else {
					$fcol = 'one_col';
					}
					$fsize = '';
				}
			break;
			
			case '8':
			if (  $counter == 2 || $counter == 4 || $counter == 5 || $counter == 8) {
					$fcol = 'one_col';
					$fsize = 'half';
				} else {
					$fcol = 'one_col';
					$fsize = '';
				}
			break;
			
			case '9':
				if (($counter % 2 == 0) || ($counter % 3 == 0) || ($counter % 4 == 0)) {
					$fcol = 'one_col';
					$fsize = 'half';
				} else {
					$fcol = 'one_col';
					$fsize = '';
				}
			break;

			default:
				if (($counter % 2 == 0) || ($counter % 3 == 0) || ($counter % 4 == 0)) {
					$fcol = 'one_col';
					$fsize = 'half';
				} else {
					$fcol = 'one_col';
					$fsize = '';
				}
			break;
		
		}
}

/*-----------------------------------------------------------------------------------*/
/*	New category walker for posts filter
/*-----------------------------------------------------------------------------------*/

class Walker_Cat_Filter extends Walker_Category {
   function start_el(&$output, $category, $depth, $args) {

      extract($args);
      $cat_name = esc_attr( $category->name);
      $cat_name = apply_filters( 'list_cats', $cat_name, $category );
      $link = '<a href="#" data-value="'.strtolower(preg_replace('/\s+/', '-', $category->term_id)).'" ';
      if ( $use_desc_for_title == 0 || empty($category->description) )
         $link .= 'title="' . sprintf(__( 'View all projects filed under %s', 'framework'), $cat_name) . '"';
      else
         $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
      $link .= '>';
      // $link .= $cat_name . '</a>';
      $link .= $cat_name;
      /*if(!empty($category->description)) {
         $link .= ' <span>'.$category->description.'</span>';
      }*/
      $link .= '</a>';
      if ( (! empty($feed_image)) || (! empty($feed)) ) {
         $link .= ' ';
         if ( empty($feed_image) )
            $link .= '(';
         $link .= '<a href="' . get_category_feed_link($category->term_id, $feed_type) . '"';
         if ( empty($feed) )
            $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s', 'framework'), $cat_name ) . '"';
         else {
            $title = ' title="' . $feed . '"';
            $alt = ' alt="' . $feed . '"';
            $name = $feed;
            $link .= $title;
         }
         $link .= '>';
         if ( empty($feed_image) )
            $link .= $name;
         else
            $link .= "<img src='$feed_image'$alt$title" . ' />';
         $link .= '</a>';
         if ( empty($feed_image) )
            $link .= ')';
      }
      if ( isset($show_count) && $show_count )
         $link .= ' (' . intval($category->count) . ')';
      if ( isset($show_date) && $show_date ) {
         $link .= ' ' . gmdate('Y-m-d', $category->last_update_timestamp);
      }
      if ( isset($current_category) && $current_category )
         $_current_category = get_category( $current_category );
      if ( 'list' == $args['style'] ) {
          $output .= '<li class="segment-2"';
          $class = 'cat-item cat-item-'.$category->term_id;
          if ( isset($current_category) && $current_category && ($category->term_id == $current_category) )
             $class .=  ' current-cat';
          elseif ( isset($_current_category) && $_current_category && ($category->term_id == $_current_category->parent) )
             $class .=  ' current-cat-parent';
          $output .=  '';
          $output .= ">$link\n";
       } else {
          $output .= "\t$link<br />\n";
       }
   }
}

/*-----------------------------------------------------------------------------------*/
/* Ajax Posts Function
/*-----------------------------------------------------------------------------------*/

// ajax: generate a list of posts from a list of post types

  function ag_get_posts()
  {
    //permission_check();    <-- check nonce and permissions here
    global $post, $reviewstyle;

    if ( !($homeposts = of_get_option('of_home_posts') ) ) { $homeposts = '6'; } 
	
    // get the category ID we need to load from
    $cat_id = $_POST['cat'];
	$reviewstyle  = $_POST['review'];

    // show only published posts
    $args = array(
      'post_type' => 'post',
	  'numberposts'     => $homeposts,
      'post_status' => 'publish',
      'nopaging' => false, // show only 6 posts in one go
      'cat' => $cat_id // load only from this category
    );

    $posts =  get_posts($args);

    // put the posts into an array
    $arr = array();

    foreach ($posts as $post)
    {

	  setup_postdata($post);
      $entry = array();

      // get the post's ID
      $entry['id'] = $post->ID;
	  
	  // get the post's title
      $entry['title'] = $post->post_title;
	  
	  // get the post link
      $entry['link'] = get_permalink($post->ID);
	  
	  // get the post image, alt text
	  if(has_post_thumbnail($post->ID)) {
			$thumb = get_post_meta($post->ID,'_thumbnail_id',false); // Get Image ID 
			$alt = get_post_meta($thumb, '_wp_attachment_image_alt', true); // Alt text of image
			$thumb1 = wp_get_attachment_image_src($thumb[0], 'blog', false);  // URL of Featured Full Image
			$thumbone = wp_get_attachment_image_src($thumb[0], 'blogonecol', false);  // URL of Featured Full Image
      $entry['img'] = $thumb1[0];
	  $entry['imgcol'] = $thumbone[0];
	  }
	  
	  // get the post content, read more tag
			$content = get_the_content('<span class="more-link">' . __('Read More', 'framework') . '</span>');
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
	  $entry['content'] = $content;

	  // get the post comments
	  $num_comments = get_comments_number($post->ID); // get_comments_number returns only a numeric value
      if ( comments_open($post->ID) && ($num_comments != 0) ) {
      	$entry['comments'] = $num_comments;
      }
	  
	  // get the post date, using the wordpress date format
	  $entry['date'] = get_the_time(get_option('date_format'));
	  
	  // get the first 3 post categories
	  		$cats = ag_get_cats(3);
	  $entry['cats'] = $cats;
	  
	  //get the review option
		if ($reviewstyle) {
			if ( !($reviewnum = of_get_option('of_review_number') ) ) { $reviewnum = '5'; } 
			$review = ag_review_post_home($post->ID, $reviewnum, $reviewstyle);
	  		$entry['review'] = $review;
		}
	  
	  // get the author
	  $entry['author'] = '<a href="' . get_author_posts_url(get_the_author_meta( "ID" )) . '">'.get_the_author_meta("display_name").'</a>';
	  
	  // store the array as a variable
      $arr[] = $entry;

    }
    
    // then output in json format
    header("Content-Type: application/json");
    echo json_encode($arr);

    exit;
  }

  // add into the ajax action chains

  // this is for logged in users
  add_action('wp_ajax_ag_get_posts', 'ag_get_posts');

  // this is for the rest
  add_action('wp_ajax_nopriv_ag_get_posts', 'ag_get_posts');
  
  
/*-----------------------------------------------------------------------------------*/
/* Admin Area Styling
/*-----------------------------------------------------------------------------------*/

function custom_css() {
	echo '<style type="text/css">
	.ui-slider { 
		position: relative; 
		text-align: left; 
		background: #555; 
		border-bottom: 1px solid #fff; 
		border-top: 1px solid #000; 
		float:left; 
		width:45%; 
		margin-top:14px; 
		margin-bottom:10px; 
		border-radius: 16px;
	}
	.ui-slider .ui-slider-handle { 
		position: absolute; 
		z-index: 2; 
		width: 3.2em; 
		height: 1.2em; 
		cursor: pointer; 
		background-color: #F1F1F1;
		background-image: -ms-linear-gradient(top,#F9F9F9,#ECECEC);
		background-image: -moz-linear-gradient(top,#F9F9F9,#ECECEC);
		background-image: -o-linear-gradient(top,#F9F9F9,#ECECEC);
		background-image: -webkit-gradient(linear,left top,left bottom,from(#F9F9F9),to(#ECECEC));
		background-image: -webkit-linear-gradient(top,#F9F9F9,#ECECEC);
		background-image: linear-gradient(top,#F9F9F9,#ECECEC);
		border-top: 1px solid #ADADAD;
		border-right: 1px solid #8D8D8D;
		border-bottom: 1px solid #747474;
		border-left: 1px solid #A3A3A3;
		-webkit-border-radius: 16px;
		-moz-border-radius: 16px;
		border-radius: 16px;
		-webkit-box-shadow: inset 0 1px 0 0 #e3e3e3, 0 1px 2px 0 rgba(0,0,0,.3);
		-moz-box-shadow: inset 0 1px 0 0 #e3e3e3, 0 1px 2px 0 rgba(0,0,0,.3);
		box-shadow: inset 0 1px 0 0 #e3e3e3, 0 1px 2px 0 rgba(0,0,0,.3);
		line-height: 1;
		-webkit-background-clip: padding-box;
	}
	.ui-slider .ui-slider-range { 
		position: absolute; 
		z-index: 1; 
		font-size: .7em; 
		display: block; 
		border: 0; 
		background-position: 0 0; 
	}
	.ui-slider-horizontal { height: .8em; }
	.ui-slider-horizontal .ui-slider-handle { top: -.4em; margin-left: -1.2em; margin-right:0.6em; }
	.ui-slider-horizontal .ui-slider-range { top: 0; height: 100%; }
	.ui-slider-horizontal .ui-slider-range-min { left: 0; }
	.ui-slider-horizontal .ui-slider-range-max { right: 0; }
	</style>';
}

add_action('admin_head', 'custom_css', 10);

/*-----------------------------------------------------------------------------------*/
/* Get Categories with a limit function
/*-----------------------------------------------------------------------------------*/

function ag_get_cats($num){
	
    $t=get_the_category();
    $count=count($t); 
	
	if ($count < $num) $num = $count;
	
	$cat_string = '';
    for($i=0; $i<$num; $i++){
        $cat_string.= '<a href="'.get_category_link( $t[$i]->cat_ID  ).'">'.$t[$i]->cat_name.'</a>';
    }
	
	if ($cat_string) return $cat_string;
}

function ag_get_cats_nolink($num){
	
    $t=get_the_category();
    $count=count($t); 
	
	if ($count < $num) $num = $count;
	
	$cat_string = '';
    for($i=0; $i<$num; $i++){
        $cat_string.= '<span>'.$t[$i]->cat_name.'</span>';
    }
	
	if ($cat_string) return $cat_string;
}

/*-----------------------------------------------------------------------------------*/
/* Review Posts Function for Single Pages
/*-----------------------------------------------------------------------------------*/

function ag_review_post($id, $reviewnum, $reviewstyle) {
	
	global $id, $reviewstyle, $overview, $finalscore, $starscore, $rating_text, $rating_summary;
	
	$r = 0;
	
	if (!($rating_text = get_post_meta($id, 'ag_rating_text', true))) { $rating_text = 'Rating'; }
	if ( $rating_summary = get_post_meta($id, 'ag_rating_summary', true));
	$reviewpost = get_post_meta($id, 'ag_review_post', true); //find out if it's a review post
	
	
	while ($r <= ($reviewnum)) {
		
		global ${"score" . $r};
		global ${"scorebar" . $r};
		global ${"criteria" . $r};
		
		$r++;
		
	}
	
	if ($reviewpost == 'Yes') { //if it's a review post
	
	$i = 0;
	$scoretotal = 0;
	$scorestring = '';
	$scoretotalcount = 0;
	

	//get all scores, and average them
	while ($i <= ($reviewnum)) {
	
		${"score" . $i} = get_post_meta($id, 'ag_score' . $i, true);

		if (empty(${"score" .$i})) ${"score" .$i} = 0;

		${"criteria" . $i} = get_post_meta($id, 'ag_criteria' . $i, true);
		
		${"scorebar" . $i} = ${"score" . $i} *10;
		
		if(!empty(${"criteria" . $i})) {
			$scoretotal += ${"score" . $i};
			$scoretotalcount++;
		}
		
		$i++;
		
		}
		
		if ($scoretotalcount && $scoretotalcount != 0) {
			$finalscore = round($scoretotal/$scoretotalcount, 1);
		}
		
		if ( !($reviewstyle) ) { $reviewstyle = 'points'; } 
		
		switch ($reviewstyle) {
			
			case 'points': //points score
				$overview = '<div class="reviewsection"><div class="rating points"><span itemprop="ratingValue">' . $finalscore . '</span><p class="ratingtext">' . $rating_text . '</p></div></div><div class="clear"></div>';
			break;
			
			case 'percentage': //percent score
				$originalscore = $finalscore;
				$finalscore = $finalscore * 10;
				$overview = '<div class="reviewsection"><div class="rating percent"><meta itemprop="ratingValue" content="' . $originalscore . '">' . $finalscore . '<span class="percent">%</span><p class="ratingtext">' . $rating_text . '</p></div></div><div class="clear"></div>';
			break;
			
			case 'stars': //stars score 
				$originalscore = $finalscore;
				$starscore = $finalscore / 2;
				$finalscore = $finalscore * 10;
				
				$finalscore = round($finalscore/10)*10; //round finalscore to nearest 5th
				$starscore = round($starscore/.5)*.5; //round starscore to nearest half
				
				$overview = '<meta itemprop="ratingValue" content="' . $originalscore . '"><div class="reviewsection"><div class="rating stars"><div class="singlestarswrapper"><div class="starswhite"  style="width: ' . $finalscore . '%; margin-left:' . (100 - $finalscore) / 2 . '%;"></div><p class="ratingtext">' . $rating_text . '</p></div></div></div><div class="clear"></div>';
			break;
		
		}// end switch
	
	} // end if it's a review post
	
} //end function ag_review_post

/*-----------------------------------------------------------------------------------*/
/* Review posts function for homepage
/*-----------------------------------------------------------------------------------*/

function ag_review_post_home($id, $reviewnum, $reviewstyle) {
	
	global $id, $reviewstyle;
	
	$reviewpost = get_post_meta($id, 'ag_review_post', true); //find out if it's a review post
	if (!($rating_text = get_post_meta($id, 'ag_rating_text', true))) { $rating_text = 'Rating'; }
	if ( !($reviewstyle = of_get_option('of_review_style') ) ) { $reviewstyle = 'percentage'; } 
	
	if ($reviewpost == 'Yes') { //if it's a review post
	
	$i = 0;
	$scoretotal = 0;
	$scoretotalcount = 0;
	

	//get all scores, and average them
	while ($i <= ($reviewnum)) {
	
		${"score" . $i} = get_post_meta($id, 'ag_score' . $i, true);

		if (empty(${"score" .$i})) ${"score" .$i} = 0;

		${"criteria" . $i} = get_post_meta($id, 'ag_criteria' . $i, true);
		
		if(!empty(${"criteria" . $i})) {
		$scoretotal += ${"score" . $i};
		$scoretotalcount++;
		}
		
		$i++;
		
		}
		
		if ($scoretotalcount && $scoretotalcount != 0) {
			$finalscore = round($scoretotal/$scoretotalcount, 1);
		}

		if ( !($reviewstyle) ) { $reviewstyle = 'points'; } 
		
		switch ($reviewstyle) {
			
			case 'points': //points score
				return '<a href="'.get_permalink($id) .'" class="rating points">' . $finalscore . '<p class="ratingtext">' . $rating_text . '</p></a>';
			break;
			
			case 'percentage': //percent score
				$finalscore = $finalscore * 10;
				return '<a href="'.get_permalink($id) .'" class="rating percent">' . $finalscore . '<span class="percent">%</span><p class="ratingtext">' . $rating_text . '</p></a>';
			break;
			
			case 'stars': //stars score 
				$starscore = $finalscore / 2;
				$finalscore = $finalscore * 10;
				
				$finalscore = round($finalscore/10)*10; //round finalscore to nearest 5th
				$starscore = round($starscore/.5)*.5; //round starscore to nearest half
				
				return '<div class="starswrapperwrapper"><div class="starswrapper"  style="width: ' . $finalscore . '%;"><div class="rating stars"><div class="starswidth"></div></div></div></div>';
			break;
		
		}// end switch
	
	} // end if it's a review post
	
} //end function ag_review_post_home


/*-----------------------------------------------------------------------------------*/
/* Get Post Slide Images
/*-----------------------------------------------------------------------------------*/

function get_post_info ($image_size, $id, $crop, $thumbnum) {
	
		global $thumb, $full, $alt, $caption, $image_title, $id;
		
		$i = 2;
		
		while ($i < ($thumbnum)) {
		
		global ${"thumb" . $i};
		global ${"caption" . $i};
		global ${"full" . $i};
		global ${"alt" . $i};
		
		$i++;
		
		}
		
			  $counter = 2; //start counter at 2			  

			  $full = get_post_meta($id,'_thumbnail_id',false); // Get Image ID 
			  $caption = get_post($full[0])->post_excerpt; 

			  $alt = get_post_meta($full, '_wp_attachment_image_alt', true); // Alt text of image
			  $full = wp_get_attachment_image_src($full[0], 'full', false);  // URL of Featured Full Image
			  			  
			   if ( $crop ) {  if ($crop == 'No Crop') {
				 
			  $thumb = get_post_meta($id,'_thumbnail_id',false); 
			  $thumb = wp_get_attachment_image_src($thumb[0], false);  // URL of Featured first slide
			  
			   } else {
				   
			  $thumb = get_post_meta($id,'_thumbnail_id',false); 
			  $thumb = wp_get_attachment_image_src($thumb[0], $image_size, false);  // URL of Featured first slide
				   
			   } } else {
				   
			  $thumb = get_post_meta($id,'_thumbnail_id',false); 
			  $thumb = wp_get_attachment_image_src($thumb[0], $image_size, false);  // URL of Featured first slide
			  
			   }
			
			while ($counter < ($thumbnum)) {
				
					if ($counter == 2) { $countername = 'second';
					} else
					if ($counter == 3) { $countername = 'third'; 
					} else
					if ($counter == 4) { $countername = 'fourth';
					} else
					if ($counter == 5) { $countername = 'fifth';
					} else
					if ($counter == 6) { $countername = 'sixth';
					} else {
					$countername = $counter;	
					}

				 ${"full" . $counter} = MultiPostThumbnails::get_post_thumbnail_id('post', $countername . '-slide', $id); // Get Image ID
				 // The thumbnail caption:
				 ${"caption" . $counter} = get_post(${"full" . $counter})->post_excerpt;
				 ${"alt" . $counter} = get_post_meta(${"full" . $counter} , '_wp_attachment_image_alt', true); // Alt text of image			 
				 ${"full" . $counter} = wp_get_attachment_image_src(${"full" . $counter}, false); // URL of Second Slide Full Image
						
				
			 
			 if ( $crop ) {  if ($crop == 'No Crop') {
			  
    		  ${"thumb" . $counter} = MultiPostThumbnails::get_post_thumbnail_id('post',  $countername . '-slide', $id); 
			  ${"thumb" . $counter} = wp_get_attachment_image_src(${"thumb" . $counter}, false); // URL of next Slide 
		
				 
			 } else {
			  
    		  ${"thumb" . $counter} = MultiPostThumbnails::get_post_thumbnail_id('post', $countername . '-slide', $id); 
			  ${"thumb" . $counter} = wp_get_attachment_image_src(${"thumb" . $counter}, $image_size, false); // URL of next Slide 
	 
			 } } else {
			  
    		  ${"thumb" . $counter} = MultiPostThumbnails::get_post_thumbnail_id('post', $countername . '-slide', $id); 
			  ${"thumb" . $counter} = wp_get_attachment_image_src(${"thumb" . $counter}, $image_size, false); // URL of next Slide 
			 
			 }
			 
			 $counter++;

		}

	}

/*-----------------------------------------------------------------------------------*/
/* Get Post Slide Images
/*-----------------------------------------------------------------------------------*/

function get_homepage_info ($image_size, $id, $crop, $thumbnum) {
	
		global $thumb, $full, $alt, $caption, $image_title;
		
		$i = 2;
		
		while ($i < ($thumbnum)) {
		
		global ${"thumb" . $i};
		global ${"caption" . $i};
		global ${"full" . $i};
		global ${"alt" . $i};
		
		$i++;
		
		}
		
			  $counter = 2; //start counter at 2
			  
			  $args = array( 'post_type' => 'attachment', 'orderby' => 'menu_order', 'order' => 'ASC', 'post_mime_type' => 'image' ,'post_status' => null, 'numberposts' => null, 'post_parent' => $id);


			  $thumbnail_image = get_posts($args);
			  if ($thumbnail_image) {
			  $caption = $thumbnail_image[0]->post_excerpt;
			  }


			  $full = get_post_meta($id,'_thumbnail_id',false); // Get Image ID 
			  
			  $alt = get_post_meta($full, '_wp_attachment_image_alt', true); // Alt text of image
			  $full = wp_get_attachment_image_src($full[0], 'blog', false);  // URL of Featured Full Image
			  			  
			   if ( $crop ) {  if ($crop == 'No Crop') {
				 
			  $thumb = get_post_meta($id,'_thumbnail_id',false); 
			  $thumb = wp_get_attachment_image_src($thumb[0], false);  // URL of Featured first slide
			  
			   } else {
				   
			  $thumb = get_post_meta($id,'_thumbnail_id',false); 
			  $thumb = wp_get_attachment_image_src($thumb[0], $image_size, false);  // URL of Featured first slide
				   
			   } } else {
				   
			  $thumb = get_post_meta($id,'_thumbnail_id',false); 
			  $thumb = wp_get_attachment_image_src($thumb[0], $image_size, false);  // URL of Featured first slide
			  
			   }
			
			while ($counter < ($thumbnum)) {
				
					if ($counter == 2) { $countername = 'second';
					} else
					if ($counter == 3) { $countername = 'third'; 
					} else
					if ($counter == 4) { $countername = 'fourth';
					} else
					if ($counter == 5) { $countername = 'fifth';
					} else
					if ($counter == 6) { $countername = 'sixth';
					} else {
					$countername = $counter;	
					}

				 ${"full" . $counter} = MultiPostThumbnails::get_post_thumbnail_id('post', $countername . '-slide', $id); // Get Image ID
				 // The thumbnail caption:
				 ${"caption" . $counter} = get_post(${"full" . $counter})->post_excerpt;
				 ${"alt" . $counter} = get_post_meta(${"full" . $counter} , '_wp_attachment_image_alt', true); // Alt text of image			 
				 ${"full" . $counter} = wp_get_attachment_image_src(${"full" . $counter}, false); // URL of Second Slide Full Image
						
				
			 
			 if ( $crop ) {  if ($crop == 'No Crop') {
			  
    		  ${"thumb" . $counter} = MultiPostThumbnails::get_post_thumbnail_id('post',  $countername . '-slide', $id); 
			  ${"thumb" . $counter} = wp_get_attachment_image_src(${"thumb" . $counter}, false); // URL of next Slide 
		
				 
			 } else {
			  
    		  ${"thumb" . $counter} = MultiPostThumbnails::get_post_thumbnail_id('post', $countername . '-slide', $id); 
			  ${"thumb" . $counter} = wp_get_attachment_image_src(${"thumb" . $counter}, $image_size, false); // URL of next Slide 
	 
			 } } else {
			  
    		  ${"thumb" . $counter} = MultiPostThumbnails::get_post_thumbnail_id('post', $countername . '-slide', $id); 
			  ${"thumb" . $counter} = wp_get_attachment_image_src(${"thumb" . $counter}, $image_size, false); // URL of next Slide 
			 
			 }
			 
			 $counter++;

		}

	}

/*-----------------------------------------------------------------------------------*/
/* Get Popular Posts
/*-----------------------------------------------------------------------------------*/

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "<span>0</span> Views";
    }
    return '<span>'. $count.'</span> '. __('Views', 'framework');
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


/*-----------------------------------------------------------------------------------*/
/* Previous/Next Links Function
/*-----------------------------------------------------------------------------------*/

function the_previousnextlinks() {
    global $post;

    $next_post = get_adjacent_post(false, '', false);
    $prev_post = get_adjacent_post(false, '', true);

	if ($next_post) {
	 $next_post_id = $next_post->ID;
	 $next_post_link = get_permalink($next_post_id);
	} 

	if ($prev_post) {
	$prev_post_id = $prev_post->ID;
	$prev_post_link = get_permalink($prev_post_id);
	}


	if( $next_post || $prev_post ) { 
	 	echo '<div class="post_neighbors_container_wrapper"><div class="post_neighbors_container">';
        
        if ($prev_post) { 
			echo '<a href="'. $prev_post_link .'" class="neighbors_link previous_post"><h5>' . __('Previous Story', 'framework') . '</h5><h3>' . get_the_title($prev_post_id) . '</h3></a>'; 
        } else {
			echo '<span class="neighbors_link previous_post grey"><h5>' . __('Previous Story', 'framework') . '</h5><h3>'. __('There are no older stories.', 'framework') . '</h3></span>'; 
        } 
        
        if ($next_post) { 
        	echo '<a href="'. $next_post_link .'" class="neighbors_link next_post"><h5>' . __('Next Story', 'framework') . '</h5><h3>' . get_the_title($next_post_id) . '</h3></a>'; 
        } else {
        	echo '<span class="neighbors_link next_post grey"><h5>' . __('Next Story', 'framework') . '</h5><h3>'. __('This is the most recent story.', 'framework') . '</h3></span>'; 
        }  
        
        echo '<div class="clear"></div></div></div>';
    } 
}

/*-----------------------------------------------------------------------------------*/
/* Add PrettyPhoto to Gallery Insert
/*-----------------------------------------------------------------------------------*/

add_filter( 'wp_get_attachment_link', 'ag_prettyadd');
 
function ag_prettyadd ($content) {
	$content = preg_replace("/<a/","<a rel=\"prettyPhoto[slides]\"",$content,1);
	return $content;
}

/*-----------------------------------------------------------------------------------*/
/* Breadcrumbs Function
/*-----------------------------------------------------------------------------------*/

function the_breadcrumb() {
	$posts_page_id = get_option( 'page_for_posts');
	$posts_page_url = get_page_uri($posts_page_id); 
	if (!is_home()) {
		echo '<a href="';
		echo $posts_page_url;
		echo '">';
		_e('News', 'framework');
		echo "</a> &raquo; ";
		if (is_category() || is_single()) {
			the_category(' ');
			if (is_single()) {
				echo " &raquo; ";
				the_title();
			}
		} elseif (is_page()) {
			echo the_title();
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Get Attachment ID from the source
/*-----------------------------------------------------------------------------------*/

function get_attachment_id_from_src ($image_src) {

		global $wpdb;
		$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
		$id = $wpdb->get_var($query);
		return $id;

	}

/*------------------------------------------------------------------------------*/
/*	Get Attachment ID from URL function
/*------------------------------------------------------------------------------*/

function get_attachment_id( $url ) {

    $dir = wp_upload_dir();
    $dir = trailingslashit($dir['baseurl']);

    if( false === strpos( $url, $dir ) )
        return false;

    $file = basename($url);

    $query = array(
        'post_type' => 'attachment',
        'fields' => 'ids',
        'meta_query' => array(
            array(
                'value' => $file,
                'compare' => 'LIKE',
            )
        )
    );

    $query['meta_query'][0]['key'] = '_wp_attached_file';
    $ids = get_posts( $query );

    foreach( $ids as $id )
        if( $url == array_shift( wp_get_attachment_image_src($id, 'full') ) )
            return $id;

    $query['meta_query'][0]['key'] = '_wp_attachment_metadata';
    $ids = get_posts( $query );

    foreach( $ids as $id ) {

        $meta = wp_get_attachment_metadata($id);

        foreach( $meta['sizes'] as $size => $values )
            if( $values['file'] == $file && $url == array_shift( wp_get_attachment_image_src($id, $size) ) ) {
				if(isset($id->attachment_size)){
                $id->attachment_size = $size;
				}
                return $id;
            }
    }

    return false;
}

/*-----------------------------------------------------------------------------------*/
/* Add Class to Edit Button
/*-----------------------------------------------------------------------------------*/

function custom_edit_post_link($output) {
 $output = str_replace('class="post-edit-link"', 'class="post-edit-link button"', $output);
 return $output;
}
add_filter('edit_post_link', 'custom_edit_post_link');

/*-----------------------------------------------------------------------------------*/
/* Get Plain Text Content
/*-----------------------------------------------------------------------------------*/

function get_the_content_unformatted(){
	ob_start();
	 the_content(' ');
	$old_content = ob_get_clean();
	$new_content = strip_tags($old_content);
	return $new_content;
}

function get_the_content_unformatted_more(){
	ob_start();
	 the_content('');
	$old_content = ob_get_clean();
	$new_content = '<p>';
	$new_content .= strip_tags($old_content);
	$new_content .= '</p><span class="more-link">' . __('Read More', 'framework') . '</span>';
	return $new_content;
}
								
/*-----------------------------------------------------------------------------------*/
/* Remove Dimensions from Thumbnails (for responsivity) and Gallery
/*-----------------------------------------------------------------------------------*/

function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );

function remove_img_width_height($html) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

add_filter('wp_get_attachment_link', 'remove_img_width_height', 10, 1);
/*-----------------------------------------------------------------------------------*/
/* Format Tag Clouds
/*-----------------------------------------------------------------------------------*/

function ag_tag_cloud_args(){
	return 'smallest=10&amp;largest=12&amp;number=25&amp;orderby=name&amp;unit=px';
}

add_filter( 'widget_tag_cloud_args', 'ag_tag_cloud_args' );


/*-----------------------------------------------------------------------------------*/
/* Related Posts Function
/*-----------------------------------------------------------------------------------*/

function ag_get_related_post_args($id){

	global $relatedcatargs, $relatedargs;
    
    $rel_tagnames = '';
    $rel_catnames = '';

    if ( !($relatednumber = of_get_option('of_related_number') ) ) { $relatednumber = '2'; } else { $relatednumber = of_get_option('of_related_number'); } 

    // Get related post tag names
    $rel_tags = get_the_tags($id);
  	
  	if ($rel_tags) {
	    // Get list of tag names and set arguments for loop
	    foreach($rel_tags as $rel_tag) {
	      $rel_tagnames .= $rel_tag->name . ',';
	    }
	    $relatedargs = array(
	      'ignore_sticky_posts' => 1,
	      'tag' => $rel_tagnames,
	      'post__not_in' => array($id),
	      'showposts' => $relatednumber,
	      'orderby' => 'rand'
	    );
	}

    // Get list of category names and set arguments for loop
    $post_cats = wp_get_post_categories($id);

    foreach($post_cats as $post_cat) {
      $rel_catnames .= get_cat_name( $post_cat ) .',';
    }
  
    $relatedcatargs = array(
      'ignore_sticky_posts' => 1,
      'cat' => $rel_catnames,
      'post__not_in' => array($id),
      'showposts' => $relatednumber,
      'orderby' => 'rand'
    );

}

function load_custom_scripts() {
	global $wp_version;

	if (version_compare($wp_version, '3.4.2', '>')) {
		wp_register_script('my-jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js', 'jquery');
        } else {
		wp_register_script('my-jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js', 'jquery');
	} 


	wp_enqueue_script( 'my-jquery-ui' );
}

add_action('admin_init', 'load_custom_scripts');

/*-----------------------------------------------------------------------------------*/
/* Add Social Fields to Edit Post Page
/*-----------------------------------------------------------------------------------*/

/**
 * Adds a form field to the edit profile page.
 *
 * @author Thomas Scholz http://toscho.de
 * @version 1.2
 * @license GPL
 *
 */
class T5_User_Profile_Addon
{

    public $settings = array (
    /* The name attribute. */
        'name'        => ''
    ,   'label'       => ''
    ,   'description' => ''

    /* You may use the following placeholder:
     * %name%        - name attribute
     * %label%       - label text
     * %description% - additional text
     * To use more placeholders, extend markup_filter().
     */
    ,   'markup'      => ''
    /* If both are not FALSE, they will replace the 'markup', and a
     * table will be created. Uses the same placeholders as 'markup'.
     */
    ,   'th'          => FALSE
    ,   'td'          => FALSE
    /* Capabilities to show and edit the field.
     * Useful, if want to add a field that only administrators or editors
     * may edit or view.
     */
    ,   'cap_show'    => 'read'
    ,   'cap_save'    => 'edit_user'
    );

    /**
     * Constructor
     *
     * @param array $args See settings. 'name' and 'markup' required.
     */
    public function __construct( $args )
    {
        $this->settings = array_merge( $this->settings, $args );

        // The id attribute should be different to name, otherwise it doesn’t
        // work in Opera.
        empty ( $this->settings['id'] )
            and $this->settings['id'] = $this->settings['name'] . '_id';

        FALSE !== $this->settings['th'] and FALSE !== $this->settings['td']
            and $this->settings['markup'] = '<table class="form-table"><tr><th>'
                . $this->settings['th'] . '</th><td>' . $this->settings['td']
                . '</td></tr></table>';

        add_action( 'show_user_profile',        array ( $this, 'show' ) );
        add_action( 'edit_user_profile',        array ( $this, 'show' ) );
        add_action( 'personal_options_update',  array ( $this, 'save' ) );
        add_action( 'edit_user_profile_update', array ( $this, 'save' ) );
    }

    /**
     * Prints the form.
     *
     * @param  object $user
     * @return void
     */
    public function show( $user )
    {
        if ( ! current_user_can( $this->settings['cap_show'], $user->ID ) )
        {
            return;
        }

        $label   = "<label for='{$this->settings['id']}'>{$this->settings['label']}</label>";
        $markup  = strtr( $this->settings['markup'],
            array (
                '%name%'        => $this->settings['name']
            ,   '%id%'          => $this->settings['id']
            ,   '%label%'       => $label
            ,   '%description%' => $this->settings['description']
            )
        );
        $old_val = trim( get_the_author_meta( $this->settings['name'], $user->ID ) );
        $markup  = $this->markup_filter( $markup, $old_val );

        print $markup;
    }

    /**
     * Saves the data.
     *
     * @param  int $user_id
     * @return void
     */
    public function save( $user_id )
    {
        if ( ! current_user_can( $this->settings['cap_save'], $user_id ) )
        {
            return;
        }

        $input = empty ( $_POST[ $this->settings['name'] ] )
            ? '' : $_POST[ $this->settings['name'] ];
        $input = $this->prepare_input( $input );

        update_user_meta( $user_id, $this->settings['name'], $input );
    }

    /**
     * Prepares the user input. For extensions.
     *
     * @param  string $input
     * @return string
     */
    public function prepare_input( $input )
    {
        return $input;
    }

    /**
     * Prepares the form markup.
     *
     * @param  string $markup
     * @param  string $old_val
     * @return string
     */
    public function markup_filter( $markup, $old_val )
    {
        $old_val = htmlspecialchars( $old_val, ENT_QUOTES, 'utf-8', FALSE );
        return str_replace( '%content%', $old_val, $markup );
    }
}

add_action( 'init', 'init_profile_addons' );
function init_profile_addons()
{
    $GLOBALS['facebook_url'] = new T5_User_Profile_Addon(
        array (
            'name' => 'facebook_url',
            'label' => 'Facebook URL',   
            'markup' => '<table class="form-table"><tr><th>%label%<br /><br />%description%</th>
            <td><input type="text" name="%name%" id="%id%" value="%content%" class="regular-text" /></td></tr></table>'
        )
    );
    $GLOBALS['twitter_url'] = new T5_User_Profile_Addon(
        array (
            'name' => 'twitter_url',
            'label' => 'Twitter URL',   
            'markup' => '<table class="form-table"><tr><th>%label%<br /><br />%description%</th>
            <td><input type="text" name="%name%" id="%id%" value="%content%" class="regular-text" /></td></tr></table>'
        )
    );
    $GLOBALS['google_url'] = new T5_User_Profile_Addon(
        array (
            'name' => 'google_url',
            'label' => 'Google Plus URL',   
            'markup' => '<table class="form-table"><tr><th>%label%<br /><br />%description%</th>
            <td><input type="text" name="%name%" id="%id%" value="%content%" class="regular-text" /></td></tr></table>'
        )
    );
    $GLOBALS['linkedin_url'] = new T5_User_Profile_Addon(
        array (
            'name' => 'linkedin_url',
            'label' => 'LinkedIn URL',   
            'markup' => '<table class="form-table"><tr><th>%label%<br /><br />%description%</th>
            <td><input type="text" name="%name%" id="%id%" value="%content%" class="regular-text" /></td></tr></table>'
        )
    );
    $GLOBALS['pinterest_url'] = new T5_User_Profile_Addon(
        array (
            'name' => 'pinterest_url',
            'label' => 'Pinterest URL',   
            'markup' => '<table class="form-table"><tr><th>%label%<br /><br />%description%</th>
            <td><input type="text" name="%name%" id="%id%" value="%content%" class="regular-text" /></td></tr></table>'
        )
    );
    $GLOBALS['youtube_url'] = new T5_User_Profile_Addon(
        array (
            'name' => 'youtube_url',
            'label' => 'YouTube URL',   
            'markup' => '<table class="form-table"><tr><th>%label%<br /><br />%description%</th>
            <td><input type="text" name="%name%" id="%id%" value="%content%" class="regular-text" /></td></tr></table>'
        )
    );


}

function ag_parse_url($urlStr) {
	if ($urlStr) {
	$parsed = parse_url($urlStr);
		if (empty($parsed['scheme'])) $urlStr = "http://$urlStr"; 
	return $urlStr;
	}
}

function ag_social_links($userId) {

	$sociallinks = '';

	$facebook_url = ag_parse_url(get_the_author_meta('facebook_url', $userId));
	$twitter_url = ag_parse_url(get_the_author_meta('twitter_url', $userId));
	$google_url = ag_parse_url(get_the_author_meta('google_url', $userId));
	$linkedin_url = ag_parse_url(get_the_author_meta('linkedin_url', $userId));
	$pinterest_url = ag_parse_url(get_the_author_meta('pinterest_url', $userId));
	$youtube_url = ag_parse_url(get_the_author_meta('youtube_url', $userId));

	if ($facebook_url) {
	$sociallinks .= '<a href="'. $facebook_url .'" class="facebook authorlink" target="_blank">' . __('Facebook', 'framework') .'</a>';
	}
	if ($twitter_url) {
	$sociallinks .= '<a href="'. $twitter_url .'" class="twitter authorlink" target="_blank">' . __('Twitter', 'framework') .'</a>';
	}
	if ($google_url) {
	$sociallinks .= '<a href="'. $google_url .'" class="google authorlink" target="_blank">' . __('Google Plus', 'framework') .'</a>';
	}
	if ($linkedin_url) {
	$sociallinks .= '<a href="'. $linkedin_url .'" class="linkedin authorlink" target="_blank">' . __('LinkedIn', 'framework') .'</a>';
	}
	if ($pinterest_url) {
	$sociallinks .= '<a href="'. $pinterest_url.'" class="pinterest authorlink" target="_blank">' . __('Pinterest', 'framework') .'</a>';
	}
	if ($youtube_url) {
	$sociallinks .= '<a href="'. $youtube_url .'" class="youtube authorlink" target="_blank">' . __('YouTube', 'framework') .'</a>';
	}

	return $sociallinks;
}
function ag_is_default($font) {
      if ($font == 'Arial' || $font == 'Georgia' || $font == 'Tahoma' || $font == 'Verdana' || $font == 'Helvetica') {
        $font = 'Droid Sans';
      }
      return $font;
    }
?>