<?php

		global $post,  $redux_builder_amp;
		do_action('ampforwp_above_related_post',$this); //Above Related Posts
		$string_number_of_related_posts = $redux_builder_amp['ampforwp-number-of-related-posts'];		$int_number_of_related_posts = round(abs(floatval($string_number_of_related_posts)));

		// declaring this variable here to prevent debug errors
		$args = null;
		$orderby = 'ID';
		// Check for the order of related posts
		if( isset( $redux_builder_amp['ampforwp-single-order-of-related-posts'] ) && $redux_builder_amp['ampforwp-single-order-of-related-posts'] ){
			$orderby = 'rand';
		}
		// Custom Post types 
       if( $current_post_type = get_post_type( $post )) {
            // The query arguments
       		if($current_post_type != 'page'){
                $args = array(
                    'posts_per_page'=> $int_number_of_related_posts,
                    'order' => 'DESC',
                    'orderby' => $orderby,
                    'post_type' => $current_post_type,
                    'post__not_in' => array( $post->ID )

                );  
            } 			
		}//end of block for custom Post types

		if($redux_builder_amp['ampforwp-single-select-type-of-related']==2){
		    $categories = get_the_category($post->ID);
					if ($categories) {
							$category_ids = array();
							foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
							$args=array(
							    'category__in'		 => $category_ids,
							    'post__not_in'		 => array($post->ID),
							    'posts_per_page'	 => $int_number_of_related_posts,
							    'ignore_sticky_posts'=> 1,
								'has_password' 		 => false ,
								'post_status'		 => 'publish',
								'orderby' 			 => $orderby,
							);
						}
			} //end of block for categories
			//code block for tags
		 if($redux_builder_amp['ampforwp-single-select-type-of-related']==1) {
					$ampforwp_tags = get_the_tags($post->ID);
						if ($ampforwp_tags) {
								$tag_ids = array();
								foreach($ampforwp_tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
									$args=array(
									   'tag__in' 			 => $tag_ids,
									    'post__not_in' 		 => array($post->ID),
									    'posts_per_page'	 => $int_number_of_related_posts,
									    'ignore_sticky_posts'=> 1,
											'has_password' 	 => false ,
											'post_status'	 => 'publish',
											'orderby' 		 => $orderby,
									);
					}
			}//end of block for tags
			if( $redux_builder_amp['ampforwp-single-select-type-of-related'] ){
			$my_query = new wp_query( $args );
				if( $my_query->have_posts() ) { ?>
					<div class="amp-wp-content relatedpost">
					    <div class="related_posts">
							<ol class="clearfix">
								<span class="related-title"><?php echo ampforwp_translation( $redux_builder_amp['amp-translator-related-text'], 'Related Post' ); ?></span>
								<?php
						    	while( $my_query->have_posts() ) {
								    $my_query->the_post();
									$related_post_permalink = "";
									$related_post_permalink = ampforwp_url_controller( get_permalink() );?>
									<li class="<?php if ( ampforwp_has_post_thumbnail() ) { echo'has_related_thumbnail'; } else { echo 'no_related_thumbnail'; } ?>">
										<div class="related-post_image">
                                        <a href="<?php echo esc_url( $related_post_permalink ); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
									<?php if ( ampforwp_has_post_thumbnail() ) { 
									$thumb_url = ampforwp_get_post_thumbnail();
									$thumb_width  	= ampforwp_get_post_thumbnail('width');
									$thumb_height 	= ampforwp_get_post_thumbnail('height');
									if( $thumb_url && true == $redux_builder_amp['ampforwp-single-related-posts-image'] ) { ?>
						            	<amp-img src="<?php echo esc_url( $thumb_url ); ?>" width=<?php echo $thumb_width; ?> height=<?php echo $thumb_height; ?> layout="responsive"></amp-img>
									<?php } 
									}?>
                              		</a>
                              	</div>
					                <div class="related_link">
					                    <a href="<?php echo esc_url( $related_post_permalink ); ?>"><?php the_title(); ?></a>
					                    <?php if ( isset($redux_builder_amp['ampforwp-single-related-posts-excerpt']) && true == $redux_builder_amp['ampforwp-single-related-posts-excerpt'] ) {
						                     if(has_excerpt()){
													$content = get_the_excerpt();
												}else{
													$content = get_the_content();
												} ?>
						                    <p><?php echo wp_trim_words( strip_shortcodes( $content ) , '15' ); ?></p>
						                <?php } ?>    
					                </div>
				            		</li>
				            <?php } ?>
							</ol>
					    </div>
					</div> <?php
	      wp_reset_postdata();
	  			}
	  		} ?>
<?php do_action('ampforwp_below_related_post_hook',$this);
