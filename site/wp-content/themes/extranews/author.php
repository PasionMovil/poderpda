<?php get_header(); ?>

<?php 
    /* Get All Initial Variables */
    if ( !($columns = of_get_option('of_column_number') ) ) { $columns = 'twocol'; } else { $columns = of_get_option('of_column_number'); } 
?>

<div class="blogindex">

    <?php if ( have_posts() ) : the_post();   
                $author_id = get_the_author_meta('ID');
              $author_name = get_the_author_meta('display_name'); 
              $author_url = get_the_author_meta('user_url'); 
    ?>

    <!-- Page Title
    ================================================== -->
    <div class="container clearfix titlecontainer">
        <div class="pagetitlewrap">
            <h3 class="pagetitle">
                <?php if ( get_the_author_meta( 'description' ) || ag_social_links($author_id) ) : 
                _e('About', 'framework'); wp_title("",true); 
                else :
                _e('Posts By', 'framework'); wp_title("",true); 
                endif; ?>
            </h3>
            <div class="mobileclear"></div>
        </div>
    </div> 

    <?php rewind_posts(); ?>
    <div class="clear"></div> 


    <!-- Page Content
    ================================================== -->
    <div class="container clearfix">
        

        <div class="articlecontainer nonfeatured maincontent"><div class="clear"></div><!-- for IE7 -->
        <?php  if ( get_the_author_meta( 'description' ) || ag_social_links($author_id) ) : ?>
        <div class="authorboxfull">
            <div class="details">
            <?php  echo get_avatar( $author_id, 96, '', $author_name ); ?>
            </div>
            <h4><?php echo $author_name; ?></h4>
            <?php the_author_meta( 'description' ); ?>
            <div class="authorsocial">
                <?php echo ag_social_links($author_id); ?>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>

        <?php endif; endif;?>

        <?php if ( get_the_author_meta( 'description' ) || ag_social_links($author_id)) : ?>
        <div class="authorposts">
            <div class="authorpoststitle">
                <h4><?php _e('Posts By', 'framework'); echo ' '.$author_name;  ?></h4>
            </div>
            <div class="clear"></div>
        </div>
        <?php endif; ?>

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


            <!-- Pagination
            ================================================== -->        
            <div class="pagination">
                <?php
                    global $wp_query;

                    $big = 999999999; // need an unlikely integer

                    echo paginate_links( array(
                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, get_query_var('paged') ),
                        'total' => $wp_query->max_num_pages
                    ) );
                ?>   
                <div class="clear"></div>
            </div> <!-- End pagination -->                
                  
        </div><!-- End articlecontainer -->

        <!-- Sidebar
        ================================================== -->  
        <div class="sidebar">
            <?php   /* Widget Area */   if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Blog Sidebar') ) ?>
        </div>
        <div class="clear"></div>

    </div><!-- End Container -->
</div><!-- End Blogwrap -->
<?php get_footer(); ?>