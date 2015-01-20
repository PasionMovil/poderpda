<?php 
    /* Get All Initial Variables */
    if ( !($reviewstyle = of_get_option('of_review_style') ) ) { $reviewstyle = 'percentage'; } else { $reviewstyle = of_get_option('of_review_style'); }
    if ( !($reviewnum = of_get_option('of_review_number') ) ) { $reviewnum = '5'; } else { $reviewnum = of_get_option('of_review_number'); } 
?>
<div id="fullcolumn">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <div class="fullarticle">
        <div class="articleinner">

            <!-- Post Image
            ================================================== -->
            <?php /* if the post has a WP 2.9+ Thumbnail */
                if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) : ?>
                    <div class="thumbnailarea alignleft">
                            <?php echo ag_review_post_home($post->ID, $reviewnum, $reviewstyle); ?>
                        <a class="thumblink" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>" href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('blogonecol', array('class' => 'scale-with-grid')); /* post thumbnail settings configured in functions.php */ ?>
                        </a>
                    </div>
                <?php endif; 
            ?>
            
            <?php if ( (!function_exists('has_post_thumbnail')) || (!has_post_thumbnail()) ) : ?>
                    <?php echo ag_review_post_home($post->ID, 3, $reviewstyle); ?>
            <?php endif; ?>

            <div class="fullcontent <?php if ( (!function_exists('has_post_thumbnail')) || (!has_post_thumbnail()) ) echo 'full'; ?>">
                
                <h2 class="indextitle">
                    <a href="<?php the_permalink(); ?>" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>

                <span class="date">
                    <?php 
                        the_time(get_option('date_format')); ?> | <?php the_author_posts_link(); 
                        
                        $num_comments = get_comments_number(); // get_comments_number returns only a numeric value
                        if ( comments_open() && ($num_comments != 0) ) : ?>
                             | <a href="<?php comments_link(); ?>"><?php comments_number('No Comments', 'One Comment', '% Comments'); ?></a>
                        <?php endif; 
                    ?>
                </span>

                    <!-- Post Content
                    ================================================== -->
                    <?php 
                    global $more; $more=0;
                    the_content('<span class="more-link">' . __('Read More', 'framework') . '</span>'); 
                    ?>

                 <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div> <!-- End articleinner -->
    </div> <!-- End full_col -->
    <?php endwhile; endif; wp_reset_query(); ?>
    <div class="clear"></div>

</div><!-- End fullcolumn -->