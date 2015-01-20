<?php

global $relatedargs, $relatedcatargs;
// Query Posts by tag
$my_query = new WP_Query($relatedargs);

// If no related posts by tag, query by category
if ( !($my_query->have_posts()) ) {
wp_reset_query(); $my_query = new WP_Query($relatedcatargs);
}

//If there are posts
if( $my_query->have_posts()) { ?>

<!-- Related Posts -->
<div class="relatedposts">
  <h3><?php _e('Related Posts', 'framework'); ?></h3>
    
    <?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
      
  <a href="<?php the_permalink();?>" class="one_col half">
    <div class="featuredinner">
          <h2><?php 
              if (strlen($post->post_title) > 40) {
                  echo substr(the_title($before = '', $after = '', FALSE), 0, 80) . '...'; 
              } else {
                  the_title();
              }  ?>                      
              <span class="date"><?php the_time(get_option('date_format')); ?> | <?php echo get_the_author(); ?></span></h2>
              <div class="featuredoverlay"></div>
              <?php the_post_thumbnail('blogonecol', array('class' => 'scale-with-grid')); /* post thumbnail settings configured in functions.php */ ?>
    </div>
  </a>
  
    <?php endwhile;  ?>

  <div class="clear"></div>
</div>
<?php } wp_reset_query(); // end if there are posts and reset the query?>