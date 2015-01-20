<?php 
/*
Template Name: Page - Full comments no titulo
*/
get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="container clearfix titlecontainer">


    
    
  
 
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
        
        <?php comments_template('', true); // comments ?>


        <div class="clear"></div>
    </div>

    <div class="clear"></div>

</div>
<?php get_footer(); ?>