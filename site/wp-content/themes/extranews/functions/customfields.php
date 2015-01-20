<?php

function xxxx_add_edit_form_multipart_encoding() {

    echo ' enctype="multipart/form-data"';

}
add_action('post_edit_form_tag', 'xxxx_add_edit_form_multipart_encoding');

$prefix = 'ag_';
$url =  get_template_directory_uri() .'/admin/images/';

$i=1;
if ( !($reviewnum = of_get_option('of_review_number') ) ) { $reviewnum = '5'; } else { $reviewnum = of_get_option('of_review_number'); }
	
 
$meta_box_review = array(
	'id' => 'ag-meta-box-review',
	'title' => __('Review Post Options', 'framework'),
	'page' => 'post',
	'context' => 'normal',
	'priority' => 'core',	
	'fields' => array(
		array(
			'name' => __('Is this a Review Post?', 'framework'),
			'desc' => __('Select whether you want this post to be a review post.', 'framework'),
			'id' => $prefix . 'review_post',
			'type' => 'radiohide',
			'std' => 'No',
			'options' => array('Yes','No'),
			)
	
	),
);

while ($i <= ($reviewnum)) {
	
	$fieldsarray = array(
					'name' => __('Review Criteria '.$i , 'framework'),
					'desc' => __('Enter your review criteria.', 'framework'),
					'id' => $prefix . 'criteria'.$i,
					'type' => 'text',
					'std' => ''
					);
	$fieldsarray2 = array(
					'name' => __('Criteria Score'.$i, 'framework'),
					'desc' => __('Enter your first criteria score.', 'framework'),
					'id' => $prefix . 'score'.$i,
					'type' => 'textslider',
					'std' => '0'
					);
					
	array_push($meta_box_review['fields'], $fieldsarray);
	array_push($meta_box_review['fields'], $fieldsarray2);

	             
		$i++;
	}
	
	array_push($meta_box_review['fields'], 
		array(
			'name' => __('Review Placement', 'framework'),
			'desc' => __('Select the placement of your homepage slide caption.', 'framework'),
			'id' => $prefix . 'review_place',
			'type' => 'select',
			'std' => 'Bottom of Post',
			'options' =>   array('Top of Post','Bottom of Post','Both'),
		),
		array(
			'name' => __('Overall Rating Text', 'framework'),
			'desc' => __('Enter a word for your overall rating, like "Superb" or "Poor"', 'framework'),
			'id' => $prefix . 'rating_text',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __('Rating Summary', 'framework'),
			'desc' => __('Enter a rating summary here. You can do a short summary, or even a pros and cons list.', 'framework'),
			'id' => $prefix . 'rating_summary',
			'type' => 'textarea',
			'std' => ''
		)
		); 

$meta_box_video = array(
	'id' => 'ag-meta-box-video',
	'title' => __('Video Post Options', 'framework'),
	'page' => 'post',
	'context' => 'normal',
	'priority' => 'core',
	'fields' => array(
		    array(
			'name' => __('YouTube or Vimeo Video URL', 'framework'),
			'desc' => __('If you want to use a YouTube or Vimeo video, please enter in the URL here.', 'framework'),
			'id' => $prefix . 'video_url',
			'type' => 'textvisible',
			'std' => ''
		)
	)
	);

$meta_box_ad_options = array(
	'id' => 'ag-meta-box-ad_options',
	'title' => __('Additional Options', 'framework'),
	'page' => 'post',
	'context' => 'normal',
	'priority' => 'core',
	'fields' => array(
		    array(
			'name' => __('Crop Slideshow Images?', 'framework'),
			'desc' => __('Select "Yes" if you want all the images to have the same height.', 'framework'),
			'id' => $prefix . 'slide_crop',
			'type' => 'select',
			'std' => 'Yes',
			'options' => array('Yes','No'),
		),
		    array(
			'name' => __('Autoplay Slideshow?', 'framework'),
			'desc' => __('Select "Yes" if you want your slideshow to automatically play.', 'framework'),
			'id' => $prefix . 'auto_play',
			'type' => 'select',
			'std' => 'No',
			'options' => array('Yes','No'),
		),
		array(
			'name' => __('Share Style', 'framework'),
			'desc' => __('Select a sharing section style for your post.', 'framework'),
			'id' => $prefix . 'share_style',
			'type' => 'select',
			'std' => 'Minimal',
			'options' => array('Minimal','Box Count', 'None'),
		),
		array(
			'name' => __('Author Style', 'framework'),
			'desc' => __('Where style do you want the author information?', 'framework'),
			'id' => $prefix . 'author_style',
			'type' => 'select',
			'std' => 'Avatar Box',
			'options' =>   array('Avatar Box','Simple','Do not display on this page'),
		)
	)
	);

$meta_box_page = array(
	'id' => 'ag-meta-box-page',
	'title' => __('Title Options', 'framework'),
	'page' => 'page',
	'context' => 'normal',
	'priority' => 'core',
	'fields' => array(
		    array(
			'name' => __('Optional Title Description', 'framework'),
			'desc' => __('Write a description for your title.', 'framework'),
			'id' => $prefix . 'page_desc',
			'type' => 'textvisible',
			'std' => ''
		)
	)
	);



add_action('admin_menu', 'ag_add_box');

 
// Add meta box
function ag_add_box() {
	global $meta_box_review;
	global $meta_box_video;
	global $meta_box_ad_options;
	global $meta_box_page;
 
	add_meta_box($meta_box_review['id'], $meta_box_review['title'], 'ag_show_review_box', $meta_box_review['page'], $meta_box_review['context'], $meta_box_review['priority']);
	add_meta_box($meta_box_video['id'], $meta_box_video['title'], 'ag_show_video_box', $meta_box_video['page'], $meta_box_video['context'], $meta_box_video['priority']);
	add_meta_box($meta_box_ad_options['id'], $meta_box_ad_options['title'], 'ag_show_options_box', $meta_box_ad_options['page'], $meta_box_ad_options['context'], $meta_box_ad_options['priority']);
	add_meta_box($meta_box_page['id'], $meta_box_page['title'], 'ag_show_page_box', $meta_box_page['page'], $meta_box_page['context'], $meta_box_page['priority']);

}
 
// Callback function to show fields in meta box
function ag_show_video_box() {
	global $meta_box_video, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="ag_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 	 
	echo '<table class="form-table">';
 
	foreach ($meta_box_video['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		switch ($field['type']) {
 
			//If Text Visible	
			case 'textvisible':
			
			echo '<tr style="border-top:1px solid #eeeeee;" class="visible">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="line-height:20px; display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'],'" size="30" style="width:75%; margin-right: 20px; float:left;" />';
			
			break;
						
		}

	}
 
	echo '</table>';
}
 
// Callback function to show fields in meta box
function ag_show_review_box() {
	global $meta_box_review, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="ag_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
	echo '<table class="form-table">';
	
	echo "<script>
	jQuery(document).ready(function() {
									
	var hidestart = jQuery('.nohide:checked').val();
	
	
	if (hidestart == 'Yes') {
		jQuery('tr.hidden').css('display', 'table-row');
	}
	
		jQuery('.nohide').click( function() {
				jQuery('tr.hidden').css('display', 'table-row');
		});
		jQuery('.hide').click( function() {
				jQuery('tr.hidden').css('display', 'none');
		});
		
	});
	</script>";
 
	foreach ($meta_box_review['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true); 

		switch ($field['type']) {
 
			
			//If Text		
			case 'text':
			
			echo '<tr style="border-top:1px solid #dcdcdc; box-shadow: inset 0 -10px 10px #F9F9F9, inset 0 10px 10px white;" class="hidden">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="line-height:20px; display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'],'" size="20" style="width:75%; margin-right: 20px; float:left; padding:10px;" />';
			
			break;
			
						//If Text		
			case 'textslider':
			
			echo '<script>
				jQuery(document).ready(function($) {
					$( "#slider_', $field['id'], '" ).slider({
						value:', $meta ? $meta : 0,',
						min: 0,
						max: 10,
						step: 0.5,
						slide: function( event, ui ) {
							$( "#', $field['id'], '" ).val(ui.value );
						}
					});
					$( "#', $field['id'], '").val($( "#slider_', $field['id'], '" ).slider( "value" ) );
				});
				</script>';
			
			echo '<tr class="hidden">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="line-height:20px; display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : 0,'" size="30" style=" margin-right: 20px; float:left;font-size: 14px;font-weight: bold;border-radius: 24px;width: 37px;text-align: center;padding: 0;height: 37px;" />';
			
			echo '<div id="slider_', $field['id'], '"></div><div class="clear"></div>';
			
			break;
			
			//If Text Visible	
			case 'textvisible':
			
			echo '<tr style="border-top:1px solid #dcdcdc;" class="visible">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="line-height:20px; display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'],'" size="30" style="width:75%; margin-right: 20px; float:left;" />';
			
			break;
			
			//If textarea		
			case 'textarea':
			
			echo '<tr style="border-top:1px solid #dcdcdc;" class="hidden">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="line-height:18px; display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<textarea name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" rows="8" cols="5" style="width:100%; margin-right: 20px; float:left;">', $meta ? $meta : $field['std'], '</textarea>';
			
			break;
 
			//If Button	
			case 'button':
				echo '<input style="float: left;" type="button" class="button" name="', $field['id'], '" id="', $field['id'], '"value="', $meta ? $meta : $field['std'], '" />';
				echo 	'</td>',
			'</tr>';
			
			break;
			
			
			//If Select	
			case 'select':
			
				echo '<tr style="border-top:1px solid #dcdcdc;" class="hidden">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			
				echo'<select name="'.$field['id'].'">';
			
				foreach ($field['options'] as $option) {
					
					echo'<option';
					if ($meta == $option ) { 
						echo ' selected="selected"'; 
					}
					echo'>'. $option .'</option>';
				
				} 
				
				echo'</select>';
			
			break;
			
			//If Radio Hide Button
			case 'radiohide':
			
				echo '<tr style="border-top:1px solid #dcdcdc;" class="visible">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			
				foreach ($field['options'] as $option) {
					if ($option == 'Yes') {
					echo'<input type="radio"';
						if ($meta == $option ) { 
					echo 'checked ';
					}	
					echo 'name="'.$field['id'].'" class="nohide" value="'.$option .'">' . $option .' <br />';
					} else {
					echo'<input type="radio"';
					if ($meta == $option ) { 
					echo 'checked ';
					}	
					echo 'name="'.$field['id'].'" class="hide" value="'.$option .'">' . $option .' <br />';	
					}
				} 
			
			break;
			
				
			//If Radio Button
			case 'radio':
			
				echo '<tr style="border-top:1px solid #dcdcdc;" class="hidden">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			
				foreach ($field['options'] as $option) {
					echo'<input type="radio"';
						if ($meta == $option ) { 
					echo 'checked ';
					}	
					echo 'name="'.$field['name'].'" value="'.$option .'">' . $option .' <br />';
						
					
				} 
			
			break;
		}

	}
 
	echo '</table>';
}

// Callback function to show fields in meta box
function ag_show_options_box() {
	global $meta_box_ad_options, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="ag_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 	 
	echo '<table class="form-table">';
 
	foreach ($meta_box_ad_options['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		switch ($field['type']) {
 
			
			//If Text		
			case 'text':
			
			echo '<tr style="border-top:1px solid #eeeeee;" class="visible">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="line-height:20px; display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'],'" size="30" style="width:75%; margin-right: 20px; float:left;" />';
			
			break;
			
			//If Text Visible	
			case 'textvisible':
			
			echo '<tr style="border-top:1px solid #eeeeee;" class="visible">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="line-height:20px; display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'],'" size="30" style="width:75%; margin-right: 20px; float:left;" />';
			
			break;
			
			//If textarea		
			case 'textarea':
			
			echo '<tr style="border-top:1px solid #eeeeee;" class="visible">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="line-height:18px; display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<textarea name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" rows="8" cols="5" style="width:100%; margin-right: 20px; float:left;">', $meta ? $meta : $field['std'], '</textarea>';
			
			break;
 
			//If Button	
			case 'button':
				echo '<input style="float: left;" type="button" class="button" name="', $field['id'], '" id="', $field['id'], '"value="', $meta ? $meta : $field['std'], '" />';
				echo 	'</td>',
			'</tr>';
			
			break;
			
			
			//If Select	
			case 'select':
			
				echo '<tr style="border-top:1px solid #eeeeee;" class="visible">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			
				echo'<select name="'.$field['id'].'">';
			
				foreach ($field['options'] as $option) {
					
					echo'<option';
					if ($meta == $option ) { 
						echo ' selected="selected"'; 
					}
					echo'>'. $option .'</option>';
				
				} 
				
				echo'</select>';
			
			break;
			
			//If Radio Hide Button
			case 'radiohide':
			
				echo '<tr style="border-top:1px solid #eeeeee;" class="visible">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			
				foreach ($field['options'] as $option) {
					if ($option == 'Yes') {
					echo'<input type="radio"';
						if ($meta == $option ) { 
					echo 'checked ';
					}	
					echo 'name="'.$field['id'].'" class="nohide" value="'.$option .'">' . $option .' <br />';
					} else {
					echo'<input type="radio"';
					if ($meta == $option ) { 
					echo 'checked ';
					}	
					echo 'name="'.$field['id'].'" class="hide" value="'.$option .'">' . $option .' <br />';	
					}
				} 
			
			break;
			
				
			//If Radio Button
			case 'radio':
			
				echo '<tr style="border-top:1px solid #eeeeee;" class="visible">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			
				foreach ($field['options'] as $option) {
					echo'<input type="radio"';
						if ($meta == $option ) { 
					echo 'checked ';
					}	
					echo 'name="'.$field['name'].'" value="'.$option .'">' . $option .' <br />';
						
					
				} 
			
			break;
		}

	}
 
	echo '</table>';
}

// Callback function to show fields in meta box
function ag_show_page_box() {
	global $meta_box_page, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="ag_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 	 
	echo '<table class="form-table">';
 
	foreach ($meta_box_page['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		switch ($field['type']) {
 
			//If Text Visible	
			case 'textvisible':
			
			echo '<tr style="border-top:1px solid #eeeeee;" class="visible">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="line-height:20px; display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'],'" size="30" style="width:75%; margin-right: 20px; float:left;" />';
			
			break;
						
		}

	}
 
	echo '</table>';
}
 
add_action('save_post', 'ag_save_data');
 
// Save data from meta box
function ag_save_data($post_id) {
	global $meta_box_review, $meta_box_video, $meta_box_ad_options, $meta_box_page;
 	
	if ( isset($_POST['ag_meta_box_nonce'])) {
	// verify nonce
	if (!wp_verify_nonce($_POST['ag_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}  
	
 
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
 
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	
foreach ($meta_box_review['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
 
		if (($new && $new != $old) || ($new && $new == 0)) {
			update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
		} elseif (empty($new) && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}

foreach ($meta_box_video['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
 
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}

foreach ($meta_box_ad_options['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
 
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}

foreach ($meta_box_page['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
 
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}
}

function my_enqueue($hook) {
	global $wp_version;
	
    if( 'post.php' != $hook )
        return;	
		if (version_compare($wp_version, '3.4.2', '>')) {
			wp_register_script('adminjqueryui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js', 'jquery');
        } else {
			wp_register_script('adminjqueryui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js', 'jquery');
		}   
    wp_enqueue_script( 'adminjqueryui');
}
add_action( 'admin_enqueue_scripts', 'my_enqueue' );


function my_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_register_script('my-upload', get_template_directory_uri() . '/functions/js/portfolio-upload.js', array('jquery','media-upload','thickbox'));
wp_enqueue_script('my-upload');
}
function my_admin_styles() {
wp_enqueue_style('thickbox');
}
add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');
?>