<?php

/*

Template Name: Homepage - Grid

*/

get_header(); ?>



<div class="container  featuredcontainer clearfix ">

    <div class="featured articlecontainer" id="isofeatured">



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

        if ( !($homeposts = of_get_option('of_home_posts') ) ) { $homeposts = '6'; } else { $homeposts = of_get_option('of_home_posts'); }



        // Get Review Style and Review Number

        if ( !($reviewstyle = of_get_option('of_review_style') ) ) { $reviewstyle = 'percentage'; } else { $reviewstyle = of_get_option('of_review_style'); }

        if ( !($reviewnum = of_get_option('of_review_number') ) ) { $reviewnum = '5'; } else { $reviewnum = of_get_option('of_review_number'); }

       

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



        <?php ag_featured_posts_layout($stickyoption, $counter); ?>

            		

                    <a href="<?php the_permalink(); ?>" class="<?php echo $fcol . ' ' . $fsize; ?> isobrick">

                <div class="featuredinner">

                    <?php 

                    $num_comments = get_comments_number(); // get_comments_number returns only a numeric value

                    if ( comments_open() && ($num_comments != 0) ) : ?>

                        <span class="bubblewrap">

                            <span class="bubble"><?php comments_number('0', '1', '%'); ?></span>

                        </span>

                    <?php endif; ?>



                        <h2>

                         <?php 

                            if (strlen($post->post_title) > 40) {

                                echo substr(the_title($before = '', $after = '', FALSE), 0, 80) . '...'; 

                            } else {

                                the_title();

                            }  ?>

                       

                            <span class="date"><?php the_time(get_option('date_format')); ?> | <?php echo get_the_author(); ?></span></h2>

                            <div class="featuredoverlay"></div>

                            <div <?php if( (MultiPostThumbnails::get_the_post_thumbnail('post', 'second-slide', NULL,  'portfoliolarge') != '') && $homeslideshow == 'false' ) { echo 'class="homeslider"'; }?>>

            					<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) :  /* if the post has a WP 2.9+ Thumbnail */ 

            						



                                    if ( $fsize == 'half') { get_post_info('smallrecfeatured', $post->ID, 'Yes', $thumbnum); 

                                    

            						} else if ($fcol == 'two_col') {  get_post_info('largefeatured', $post->ID, 'Yes', $thumbnum);

                                    

                                    } else {  get_post_info('smallfeatured', $post->ID, 'Yes', $thumbnum); 

                                    

            						} ?>



                                    <img src="<?php  echo $thumb[0]; ?>" alt="<?php if ($alt) { echo str_replace('"', "", $alt); } else { echo the_title(); } ?>" title="<?php echo $caption;?>" class="scale-with-grid" data-thumb="<?php  echo $thumb[0]; ?>"/>

                                   

                                   <?php if( (MultiPostThumbnails::get_the_post_thumbnail('post', 'second-slide', NULL,  'portfoliolarge') != '') && $homeslideshow == 'false' ) { ?>

                                    <?php $tcounter = 2;

                                        while ($tcounter < ($thumbnum)) :

                                            if ( ${'thumb' . $tcounter}) : ?>

                                                <img src="<?php  echo ${'thumb' . $tcounter}[0]; ?>" alt="<?php if (${'alt' . $tcounter}) { echo str_replace('"', "", ${'alt' . $tcounter}); } ?>" class="scale-with-grid" data-thumb="<?php  echo ${'thumb' . $tcounter}[0]; ?>"/>

                                            <?php endif; $tcounter++;

                                        endwhile; ?>

                                    <?php } ?>



            					 <?php endif; ?> 

                             </div>                    

                    </div>

                    </a>

                    

                    

        <?php $counter++; endwhile;  wp_reset_query(); // Reset Query?>

        <div class="clear"></div>

    </div>


<center>

</br></br>
<script type="text/javascript">
    var width = window.innerWidth 
        || document.documentElement.clientWidth 
        || document.body.clientWidth;
 
    google_ad_client = "ca-pub-0579069280875606";
 
    if (width > 800) {
/* PoderPDA Large Banner 2014 */
google_ad_slot = "2281426674";
google_ad_width = 728;
google_ad_height = 90;

    } else if (width < 800) { 
/* PoderPDA BoxBanner Articles 2014 */
google_ad_slot = "4816090673";
google_ad_width = 300;
google_ad_height = 250;
    } 
 
</script>
<script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

</br></br>
</br></br>
</center>




</div>

<div class="maincontent noborder full">

<?php the_content(); ?>

</div>



<div class="container clearfix">

    <!-- Ajax Load Headlines Dropdown

    ================================================== -->





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

            <a href="<?php echo $posts_page_url; ?>" class="button"><?php _e('Más Noticias', 'framework'); ?></a>

        </div>  

                  

    </div><!-- End articlecontainer -->



    <!-- Sidebar

    ================================================== -->  

    <div class="sidebar">

        <?php   /* Widget Area */   if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Home Sidebar') ) ?>

    </div>

    <div class="clear"></div>

    

</div><!-- End container -->



<?php get_footer(); ?>