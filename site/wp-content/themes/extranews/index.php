<?php get_header(); ?>

<?php 
    /* Get All Initial Variables */
    if ( !($columns = of_get_option('of_column_number') ) ) { $columns = 'twocol'; } else { $columns = of_get_option('of_column_number'); } 
?>

<div class="blogindex">

    <!-- Page Title
    ================================================== -->
    <div class="container clearfix titlecontainer">
        <div class="pagetitlewrap">
            <h3 class="pagetitle">
                <?php wp_title("",true);
                if(!wp_title("",false)) { echo bloginfo( 'title');} ?>
            </h3>
            <div class="mobileclear"></div>
            <span class="description">
                <?php $posts_page_id = get_option('page_for_posts');
                if ($tagline_text = get_post_meta($posts_page_id, 'ag_page_desc', $single = true)) { echo '<p>' . $tagline_text . '</p>'; } ?>
            </span>
        </div>
    </div> 

    <div class="clear"></div> 


    <!-- Page Content
    ================================================== -->
    <div class="container clearfix">
        <div class="articlecontainer nonfeatured maincontent"><div class="clear"></div><!-- for IE7 -->
            <?php         
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $postsperpage = get_option('posts_per_page');

            query_posts( 
                array(
                    'ignore_sticky_posts' => 1, 
                    'posts_per_page' => $postsperpage, 
                    'paged' => $paged
                )
            );
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