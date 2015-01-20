<?php get_header(); ?>

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

        
        
        <?php
        /* If Video Post
        /*-----------------------------------------------------------------------------------
        $video_url = get_post_meta(get_the_ID(), 'ag_video_url', true);	

        if ($video_url != '') : $vendor = parse_url($video_url); ?>
        <div class="featuredimage">        
            <div class="videocontainer">
                <?php if ($vendor['host'] == 'www.youtube.com' || $vendor['host'] == 'youtu.be' || $vendor['host'] == 'www.youtu.be' || $vendor['host'] == 'youtube.com'){ // If from Youtube.com ?>
                    
                    <?php if ($vendor['host'] == 'www.youtube.com') { parse_str( parse_url( $video_url, PHP_URL_QUERY ), $my_array_of_vars ); ?>
                        <iframe width="620" height="350" src="http://www.youtube.com/embed/<?php echo $my_array_of_vars['v']; ?>?modestbranding=1;rel=0;showinfo=0;autoplay=0;autohide=1;yt:stretch=16:9;wmode=transparent;" frameborder="0" allowfullscreen></iframe>
                    <?php } else { ?>
                        <iframe width="620" height="350" src="http://www.youtube.com/embed<?php echo parse_url($video_url, PHP_URL_PATH);?>?modestbranding=1;rel=0;showinfo=0;autoplay=0;autohide=1;yt:stretch=16:9;wmode=transparent;" frameborder="0" allowfullscreen></iframe>
                    <?php } } ?>
    
                <?php if ($vendor['host'] == 'vimeo.com'){ // If from Vimeo.com ?>
                    <iframe src="http://player.vimeo.com/video<?php echo parse_url($video_url, PHP_URL_PATH);?>?title=0&amp;byline=0&amp;portrait=0" width="620" height="350" frameborder="0"></iframe>
                <?php } ?>
            </div>
		</div>

        <?php else :

        /* If Not a Video Post
        /*-----------------------------------------------------------------------------------*					
            
        $crop = get_option('of_slide_crop');
        $popup = get_option('of_slideshow_popup');

        // Get number of slides or set the default
        if ( $thumbnum = of_get_option('of_thumbnail_number') ) { $thumbnum = ($thumbnum + 1); } else { $thumbnum = 7;}

          if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) : // if the post has a WP 2.9+ Thumbnail  
          get_post_info($slide_crop, $post->ID, $crop, $thumbnum); ?>
          
          <div class="featuredimage">     
              <div class="slider-wrapper theme-default">
                <div <?php 
                  if( MultiPostThumbnails::get_the_post_thumbnail('post', 'second-slide', NULL,  'portfoliolarge') != '' ) { 
                    echo ($auto_play == 'No') ? 'class="slider nivoSlider"' : 'class="sliderautoplay nivoSlider"';
                  }?> >
    
                <?php if ($popup == 'On') { ?><a href="<?php echo $full[0]; ?>" rel="prettyPhoto[pp_gal]" title="<?php if ($alt) { echo str_replace('"', "", $alt);  } else { echo the_title(); } ?>"><?php }?><img src="<?php  echo $thumb[0]; ?>" alt="<?php if ($alt) { echo str_replace('"', "", $alt); } else { echo the_title(); } ?>" title="<?php print_r($caption); ?>" class="scale-with-grid" data-thumb="<?php  echo $thumb[0]; ?>"/><?php if ($popup == 'On') { ?></a><?php }?>
                  <?php $counter = 2;
                  while ($counter < ($thumbnum)) :
                    if ( ${'thumb' . $counter}) : ?>
                      <?php if ($popup == 'On') { ?><a href="<?php echo ${'full' . $counter}[0]; ?>" rel="prettyPhoto[pp_gal]" title="<?php if (${'alt' . $counter}) { echo str_replace('"', "", ${'alt' . $counter}); } else { echo the_title(); } ?>"><?php }?><img src="<?php  echo ${'thumb' . $counter}[0]; ?>" alt="<?php if (${'alt' . $counter}) { echo str_replace('"', "", ${'alt' . $counter}); } ?>" title="<?php if (${'caption' . $counter}) { echo str_replace('"', "", ${'caption' . $counter}); } ?>" class="scale-with-grid" data-thumb="<?php  echo $thumb[0]; ?>"/><?php if ($popup == 'On') { ?></a><?php }?>
                    <?php endif; $counter++;
                  endwhile; ?>
                </div>
              </div>
		  </div>
          <?php endif; 

        endif; */ ?>
                    
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
        
        <?php /*
            <div class="social_buttons_facebook">
<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2FPoderPDA&amp;layout=standard&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:80px; height:30px"></iframe>
            </div>

            */ ?>
            
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


      <center><script type="text/javascript"><!--
google_ad_client = "ca-pub-0579069280875606";
/* PoderPDA Top BoxBanner */
google_ad_slot = "9422813493";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></center><br></br>



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


<center><script type="text/javascript"><!--
google_ad_client = "ca-pub-0579069280875606";
/* PoderPDA BIG BoxBanner */
google_ad_slot = "8101546434";
google_ad_width = 336;
google_ad_height = 280;
//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</center>

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



   <!-- Banner single post, parte inferior junto a busqueda tag
   ================================================== -->
<center>
<br>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-0579069280875606";
/* Enlaces Header PoderPDA 2013 */
google_ad_slot = "1220869209";
google_ad_width = 180;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</p>
 </center>


         <?php

          if ($related == 'yes')  get_template_part('functions/related'); 


          ?>



           <h3>Visitantes llegan a esta pagina buscando: </h3>
 <br /><center>




   <!-- Banner single post, parte inferior junto a busqueda tag
   ================================================== -->


<script type="text/javascript"><!--
google_ad_client = "ca-pub-0579069280875606";
/* Enlaces Header PoderPDA 2013 */
google_ad_slot = "1220869209";
google_ad_width = 180;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-0579069280875606";
/* Enlaces Header PoderPDA 2013 */
google_ad_slot = "1220869209";
google_ad_width = 180;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</p>

 </center><br><br>

            <?php seoqueries_get_page_terms($plain_text = false); ?>

            
          <?php 
     	  	if (have_posts()) : while (have_posts()) : the_post(); 
  					comments_template('', true); // comments
          endwhile; endif;
            
    endif;  ?>

    </div>

    <div class="sidebar">
        <?php	/* Widget Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Single Post Sidebar') ) ?>
    </div>
    <div class="clear"></div>
</div>
<!-- Begin Footer -->
<?php get_footer(); ?>