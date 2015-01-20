<?php get_header(); ?>
<?php if ( get_post_meta( get_the_ID(), 'quita-hotw', true ) ) { ?>
<!-- Sin Hotwords --> 
<?php }else{ ?>

<?php //Publicidad tras un párrafo concreto
add_filter( 'the_content', 'publicidad_tras_parrafo' );
function publicidad_tras_parrafo( $content ) {
        if( !is_single() )
            return $content;
 
            $paragraphAfter = 0; //Este es el número del párrafo tras el que irá la publicidad
            $content = explode ( "</p>", $content );
            $new_content = '';
                for ( $i = 0; $i < count ( $content ); $i ++ ) {
                    if ( $i == $paragraphAfter ) {
                    $new_content .= '<div class="alignleft" style="margin-right:10px;">';
                    $new_content .= '<script type="text/javascript">
    var width = window.innerWidth 
        || document.documentElement.clientWidth 
        || document.body.clientWidth;
 
    google_ad_client = "ca-pub-0579069280875606";
 
    if (width > 800) {
/* PoderPDA BoxBanner Articles 2014 */
google_ad_slot = "4816090673";
google_ad_width = 300;
google_ad_height = 250;

    } else if (width < 800) { 
/* PoderPDA BoxBanner Tablets 2014 */
google_ad_slot = "4397288273";
google_ad_width = 200;
google_ad_height = 200;
    } 
 
</script>
<script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
                    $new_content .= '</div>';
                    }
            $new_content .= $content[$i] . "</p>";
            }
            return $new_content;
    }
?>
<?php } ?>

<?php 
  /* Get All Initial Variables */
  $review_post = get_post_meta(get_the_ID(), 'ag_review_post', true);  // check if review post 
  $auto_play = get_post_meta(get_the_ID(), 'ag_auto_play', true);  // check for autoplay
  $review_place = get_post_meta(get_the_ID(), 'ag_review_place', true);  // check review placement
  $author_style = get_post_meta(get_the_ID(), 'ag_author_style', true);  // check author style
  $share_style = get_post_meta(get_the_ID(), 'ag_share_style', true);  // check share style
  $slide_crop = get_post_meta(get_the_ID(), 'ag_slide_crop', true); if ($slide_crop == 'Yes') { $slide_crop = 'post'; } else { $slide_crop = 'postnc'; } // check if review post 
  if ( !($related = of_get_option('of_related_posts') ) ) { $related = 'no'; } else { $related = of_get_option('of_related_posts'); } 
  setPostViews(get_the_ID());  // count the number of views for popular posts
?>

<script type="text/javascript">
  (function () {
    var tagjs = document.createElement("script");
    var s = document.getElementsByTagName("script")[0];
    tagjs.async = true;
    tagjs.src = "//s.btstatic.com/tag.js#site=63UCMvc";
    s.parentNode.insertBefore(tagjs, s);
  }());
</script>
<noscript>
  <iframe src="//s.thebrighttag.com/iframe?c=63UCMvc" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</noscript>

<!-- Page Content
  ================================================== -->

<div class="container clearfix">
  <div class="blogpost maincontent"><div class="clear"></div> <!-- for stupid ie7 -->
    <?php if (have_posts()) : while (have_posts()) : the_post();  ?>


      <!-- Post Image, Video, Content
        ================================================== -->        

        <div itemscope itemtype="http://schema.org/Review" <?php post_class(); ?> id="<?php echo get_the_ID(); ?>">
        <!-- Page Title, Category, Post Information
          ================================================== -->
        <div class="categories">
            <?php echo ag_get_cats(3); ?>
        </div>

         <?php if ( comments_open() ) : ?>
        <a class="bubble comments" href=" <?php comments_link(); ?> ">
                 <?php comments_number( __('No Comments', 'framework'), __('One Comment', 'framework'), __('% Comments', 'framework') ); ?> 
        </a>
        <div class="clear"></div>
     

        <?php endif; ?>

        <div class="clear"></div>

        <h1 class="blogtitle entry-title" itemprop="itemReviewed" itemscope itemtype="http://schema.org/Thing">
          <span itemprop="name"> 
          <?php wp_title("",true); ?>
          </span>
        </h1>
        <div class="clear"></div>

        
        
                    
      <div class="blogcontent"> 

        <div class="leftblogcontent">

          <?php 
          /* Author
      /*-----------------------------------------------------------------------------------*/
          if ($author_style == 'Avatar Box') { ?>
            <div class="details">
              <?php $author_id = get_the_author_meta('ID');
              $author_name = get_the_author_meta('display_name'); 
              $author_url = get_the_author_meta('user_url'); 
               echo get_avatar( $author_id, 64, '', $author_name ); 
               ?>

              <ul class="authorinfo">

                <meta itemprop="datePublished" content="<?php the_time('Y'); ?>-<?php the_time('d'); ?>-<?php the_time('m'); ?>">
               <li class="name vcard author" itemprop="author"><strong class="fn"><?php the_author_posts_link();?></strong></li>


               <li class="date">Publicada el <span class="updated"><?php the_time('j'); ?> de <?php the_time('F'); ?> del <?php the_time('Y'); ?></span> </li> 
               <li class="url"><?php echo $author_url; ?></li>
             </ul>

      <div class="social_buttons"> 

            <div class="social_buttons_facebook">
<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FPoderPDA&amp;width=90&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px;" allowTransparency="true"></iframe>
            </div>
            
            <div class="social_buttons_twitter">
            <a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php post_permalink(); ?>" data-count="horizontal" data-via="poderpda" data-lang="en">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
            </div> 
        
             <div class="social_buttons_google"> 
       <script type="text/javascript" src="https://apis.google.com/js/plusone.js"> 
            {lang: 'es'}
          </script> 
          <g:plusone size="medium"></g:plusone>

        </div>        

        
        <!--<div class="social_buttons_sharethis">
          <span class='st_sharethis_button' displayText='Compartir'></span>
        </div>--> 
                
                      
        
      </div> 



               <div class="clear"></div>
           </div>     
      <?php } ?>
          


          <?php 
          /* Review
          /*-----------------------------------------------------------------------------------*/
          if ($review_post == 'Yes') {
            if ($review_place == 'Top of Post' || $review_place == 'Both') {
              get_template_part('functions/review'); 
            }
          } ?>    
    
        </div>   
 

<div id="HOTWordsTxt" name="HOTWordsTxt">




         <!-- Content
           ================================================== -->   



          <?php the_content(); ?> <div class="clear"></div> 
          <?php edit_post_link( __('Edit Post', 'framework'), '', '' ); ?>
          <?php $args = array(
          'before'           => '<div class="linkpagebutton"><span class="pagelabel">' . __('Pages:', 'framework') . '</span>',
          'after'            => '<div class="clear"></div></div><div class="clear"></div>',
          'link_before'      => '<span class="page-numbers">',
          'link_after'       => '</span>',
          'next_or_number'   => 'number',
          'nextpagelink'     => __('Next page', 'framework'),
          'previouspagelink' => __('Previous page', 'framework'),
          'pagelink'         => '%',
          'echo'             => 1
        ); ?>
           <?php wp_link_pages( $args ); ?> 
          
          <?php 
          /* Review
          /*-----------------------------------------------------------------------------------*/
          if ($review_post == 'Yes') {
            if ($review_place == 'Bottom of Post' || $review_place == 'Both') { ?>
              <div class="bottomreview">
              <?php get_template_part('functions/review'); ?>
              </div>
            <?php }
          } ?>  
                    
                    
    
        
        <div class="clear"></div>
      </div> <!-- End Post Div -->
  </div>

<center>

</br></br>
<script type="text/javascript">
    var width = window.innerWidth 
        || document.documentElement.clientWidth 
        || document.body.clientWidth;
 
    google_ad_client = "ca-pub-0579069280875606";
 
    if (width > 800) {
/* PoderPDA BIG BoxBanner */
google_ad_slot = "8101546434";
google_ad_width = 336;
google_ad_height = 280;

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

</center>

</div>


       <!-- Tags
         ================================================== -->                      
        <?php the_tags('<div class="tagcloud"><h5>'.__("Tags", "framework"). '</h5>', ' ', '</div><div class="clear"></div>'); ?>
        
        <div class="clear"></div>




          <!-- Share Links
          ================================================== -->
          <?php 
          if ($share_style != 'None') {
            if ($share_style == 'Box Count') {
              get_template_part('functions/countshare');
            } else {
              get_template_part('functions/minimalshare');
            } 
          } 
          ?>

          <?php the_previousnextlinks(); // declared in extra-functions.phg 

          if ($related == 'yes')  ag_get_related_post_args($post->ID); // get info for related posts
                
          endwhile; // end loop

          ?> 


   <!-- SEO Tags
   ================================================== -->
<?php seoqueries_get_page_terms($plain_text = false); ?> 

          <?php

          if ($related == 'yes')  get_template_part('functions/related'); 
          ?>


<center>


</p>
</center>




          <?php
          if (have_posts()) : while (have_posts()) : the_post(); 
            comments_template('', true); // comments
          endwhile; endif;
            
    endif;  ?>




    </div>

    <div class="sidebar">
        <?php /* Widget Area */ if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Single Post Sidebar') ) ?>
    </div>
    <div class="clear"></div>
</div>
<!-- Begin Footer -->
<?php get_footer(); ?>
