<?php
/*
Template Name: Homepage - Slider
*/
get_header(); ?>

<?php 
    // Declare initial vars
    $counter = 1;

    // Get Sticky Posts, Number, Slideshow Declared in Options Panel
    $sticky = get_option('sticky_posts');
    if ( !($stickyoption = of_get_option('of_sticky_posts') ) ) { $stickyoption = '2'; } 
    if ( $thumbnum = of_get_option('of_thumbnail_number') ) { $thumbnum = ($thumbnum + 1); } else { $thumbnum = 7;}
	if ( !($homeslideshow = of_get_option('of_home_autoplay'))) { $homeslideshow = 'true';}
	if ( !($columns = of_get_option('of_home_column_number') ) ) { $columns = 'twocol'; } else { $columns = of_get_option('of_home_column_number'); } 

    // Get News Category Name, ID and number to display
    $newscat = of_get_option('of_news_category'); //Cat ID.
    $newscatname = get_cat_name( $newscat ); //Cat Name
    if ( !($homeposts = of_get_option('of_home_posts') ) ) { $homeposts = '6'; } 

    // Get Review Style and Review Number
    if ( !($reviewstyle = of_get_option('of_review_style') ) ) { $reviewstyle = 'percentage'; } else { $reviewstyle = of_get_option('of_review_style'); }
    if ( !($reviewnum = of_get_option('of_review_number') ) ) { $reviewnum = '5'; } else { $reviewnum = of_get_option('of_review_number'); }
?>

<div class="blogindex">

    <!-- Page Content
      ================================================== -->
    <div class="container clearfix">
        <div class="maincontent slidercontent">
        <div class="clear"></div><!-- for IE7 -->

            <!-- Slideshow
            ================================================== -->
            <div class="homepageslideshow featuredimage">
                <div class="slider-wrapper theme-default">
                    <div class="slider nivoSlider">

                        <?php 

                        // First loop to display only my single, most recent sticky post
                        $most_recent_sticky_post = new WP_Query(array(
                            // Only sticky posts
                            'post__in' => $sticky,
                            // Treat them as sticky posts
                            'ignore_sticky_posts' => 1,
                            // Get only the most recent
                            'posts_per_page' => $stickyoption
                        ));
                        $postids = array();


                        while ($most_recent_sticky_post->have_posts()) : $most_recent_sticky_post->the_post(); ?>

                        <?php $postids [] = $post->ID; //store the sticky post IDs in the array so we can exclude them below ?>

                        <?php $thumb = get_post_meta($id,'_thumbnail_id',false); 
                              $image = wp_get_attachment_image_src($thumb[0], 'post', false);  // URL of Featured first slide ?>

						<?php if ($image) { ?>
                                <a href="<?php the_permalink();?>"><img src="<?php echo $image[0] ?>" title="&lt;a href='<?php the_permalink();?>'&gt; &lt;h3 class='title' &gt;<?php the_title(); ?>&lt;/h3&gt; &lt;p&gt;<?php global $more; $more=0; echo htmlspecialchars (get_the_content_unformatted()); ?>&lt;/p&gt;&lt;/a&gt;"></a>
                        <?php } ?>
                        <?php $counter++; endwhile;  wp_reset_query(); // Reset Query?>

                    </div><!-- End nivoSlider -->
                </div><!-- End slider-wrapper -->
            </div><!-- End homepageslideshow -->
            
            <div class="maincontent noborder">
            <?php the_content(); ?>
            </div>

            <!-- Ajax Load Headlines Dropdown
            ================================================== -->
            <div class="ajax-select">
                <ul class="sf-menu">
                    <li id="news_list">
                        <a id="news_select" href="#"><?php echo ($newscatname) ? $newscatname : __('Latest Posts', 'framework'); ?></a>
                        <div class="tooltip">&larr; <?php _e('More Headlines', 'framework'); ?></div>
                        <ul> 
                            <li class="segment-2"><a href="#" data-value="all" title="<?php _e('Latest Posts', 'framework'); ?>"><?php _e('Latest Posts', 'framework'); ?></a></li>
                            <?php wp_list_categories(array('title_li' => '', 'walker' => new Walker_Cat_Filter())); ?>
                        </ul>
                    </li>
                </ul>
                <div class="clear"></div>
            </div><!-- End ajax-select -->

            <div class="articlecontainer nonfeatured homepage maincontent">
                
                <span class="smallloading"></span>
                
                    <?php 
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        query_posts( array('ignore_sticky_posts' => 1, 'cat' => $newscat, 'posts_per_page' => $homeposts, 'paged' => $paged, 'post__not_in' => $postids));
                    ?>
                
                    <?php 
					//Two Column or One Column Layout
					switch ($columns) {
						case ('twocol'):
							// Two Column Layout
							get_template_part('functions/twocol'); 
						break;
						case ('onecol'):
							// One Column Layout
							get_template_part('functions/onecol');
						break;
						default:
							// Two Column Layout
							get_template_part('functions/twocol'); 
						break;
		
					} ?>
                
                <div class="paginationbutton">
                    <?php $posts_page_id = get_option('page_for_posts');
                    $posts_page_url = get_permalink( $posts_page_id ); ?>
                    <a href="<?php echo $posts_page_url; ?>" class="button"><?php _e('More Headlines', 'framework'); ?></a>
                </div>  
                          
            </div><!-- End articlecontainer -->
        </div><!-- End maincontent -->

        <!-- Sidebar
        ================================================== -->  
        <div class="sidebar">
            <?php   /* Widget Area */   if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Home Sidebar') ) ?>
        </div>
        <div class="clear"></div>

    </div><!-- End Container -->
</div><!-- End Blogwrap -->
<?php get_footer(); ?>