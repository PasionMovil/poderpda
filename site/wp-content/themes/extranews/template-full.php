<?php 
/*
Template Name: Page - Full
*/
get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="container clearfix titlecontainer">
  
    <!-- Page Title
    ================================================== -->
    <div class="pagetitlewrap">
        <h3 class="pagetitle">
            <?php wp_title("",true);
            if(!wp_title("",false)) { echo bloginfo( 'title');} ?>
        </h3>
        <div class="mobileclear"></div>
        <span class="description">
          <?php if ($tagline_text = get_post_meta($post->ID, 'ag_page_desc', $single = true)) { echo '<p>' . $tagline_text . '</p>'; } ?>
        </span>
    </div>
    <div class="clear"></div>

    <!-- Page Content
      ================================================== -->
    <div class="maincontent page full">
        <?php the_content(); ?>
        <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

        <?php endwhile; else :?>
        <!-- Else nothing found -->
        <h2><?php _e('Error 404 - Not found.', 'framework'); ?></h2>
        <p><?php _e("Sorry, but you are looking for something that isn't here.", 'framework'); ?></p>
       <!--BEGIN .navigation .page-navigation -->
        <?php endif; ?>
        
        <div class="clear"></div>
    </div>

    <div class="clear"></div>

</div>
<?php get_footer(); ?>