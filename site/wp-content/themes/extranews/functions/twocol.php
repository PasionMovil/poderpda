<?php 
    /* Get All Initial Variables */
    if ( !($reviewstyle = of_get_option('of_review_style') ) ) { $reviewstyle = 'percentage'; } else { $reviewstyle = of_get_option('of_review_style'); }
    if ( !($reviewnum = of_get_option('of_review_number') ) ) { $reviewnum = '5'; } else { $reviewnum = of_get_option('of_review_number'); } 
    if ( !($sidebar = of_get_option('of_sidebar_width') ) ) { $sidebar = 'default'; } else { $sidebar = of_get_option('of_sidebar_width'); } 

?>
<div id="isonormal">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                
    <div class="one_col isobrick">
        <div class="articleinner">

            <div class="categories">
                <?php echo ag_get_cats(3); ?>
            </div>

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
                        <a class="bubble" href="<?php comments_link(); ?>"><?php comments_number('0', '1', '%'); ?></a>
                    <?php endif; 
                ?>
            </span>

                <!-- Post Image
                ================================================== -->
                <?php /* if the post has a WP 2.9+ Thumbnail */
                    if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) : ?>
                        <div class="thumbnailarea">
                                <?php echo ag_review_post_home($post->ID, $reviewnum, $reviewstyle); ?>
                            <a class="thumblink" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>" href="<?php the_permalink(); ?>">
                                <?php if ($sidebar == 'extended') {
                                the_post_thumbnail('blogonecol', array('class' => 'scale-with-grid')); /* post thumbnail settings configured in functions.php */ 
                                } else {
                                the_post_thumbnail('blog', array('class' => 'scale-with-grid')); /* post thumbnail settings configured in functions.php */ 
                                } ?>
                            </a>
                        </div>
                    <?php endif; 
                ?>
                
                <?php if ( (!function_exists('has_post_thumbnail')) || (!has_post_thumbnail()) ) : ?>
                    <a title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>" href="<?php the_permalink(); ?>">
                        <?php echo ag_review_post_home($post->ID, 3, $reviewstyle); ?>
                    </a>






                <?php endif; ?>

                <!-- Post Content
                ================================================== -->
                <?php 
                global $more; $more=0;
                the_excerpt(); 
                ?>
                <p> <a href="<?php the_permalink(); ?>" class="more-link"><span class="more-link">Leer mas...</span></a></p>
               


             <div class="clear"></div>

        </div> <!-- End articleinner -->
    </div> <!-- End full_col -->


    <?php if ($count == 4) : ?>

    <div class="one_col isobrick">
        <div class="articleinner">
            <div class="categories"></div>
            <h2 class="indextitle">&nbsp;</h2>
                        <div class="thumbnailarea">

<script type="text/javascript"><!--
google_ad_client = "ca-pub-0579069280875606";
/* PoderPDA BoxBanner Home/Pages 2014 */
google_ad_slot = "3618559079";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

                        </div>
                <p>&nbsp;</p>
             <div class="clear"></div>
        </div> <!-- End articleinner -->
    </div> <!-- End full_col -->

<?php endif; $count++; ?>



    <?php endwhile; endif; wp_reset_query(); ?>
    <div class="clear"></div>

</div><!-- End isonormal -->