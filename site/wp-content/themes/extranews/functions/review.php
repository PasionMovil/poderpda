<?php 
/*************************************************************/
/* Review Section Template
/*************************************************************/

// Global Variables
  global $id, 
         $reviewstyle, 
         $overview, 
         $finalscore, 
         $starscore, 
         $rating_text, 
         $rating_summary;

  // Get Information on Review
  if ( !($reviewnum = of_get_option('of_review_number') ) ) { $reviewnum = '5'; } else { $reviewnum = of_get_option('of_review_number'); }
  if ( !($reviewstyle = of_get_option('of_review_style') ) ) { $reviewstyle = 'percentage'; } else { $reviewstyle = of_get_option('of_review_style'); }

  $r = 0;  
  
  // Get Declare Remaining Clobal Variables
  while ($r <= ($reviewnum)) {
    
    global ${"score" . $r};
    global ${"scorebar" . $r};
    global ${"criteria" . $r};
    
    $r++;  }?>

<div class="reviewbox">
    <div class="reviewboxtitle">
      <h4><?php _e('Review Overview', 'framework'); ?></h4>
    </div>
    <div class="clear"></div>

    <?php ag_review_post($post->ID, $reviewnum, $reviewstyle); ?>
    
   <!-- Scores
     ================================================== -->                               
    <div class="scores">
    <?php $counter = 1;
          while ($counter <= ($reviewnum)) : 

    if (${'criteria' . $counter}) :?>
      <div class="score score<?php echo $counter; ?>">
      <h5><?php echo ${'criteria' . $counter}; ?></h5><span><?php echo ${'score' . $counter};  ?></span><div class="clear"></div>
      <div class="scorebarwrapper"><div class="scorebar" style="width:<?php echo ${'scorebar' . $counter};  ?>%"></div></div>
      </div>
    <?php endif; $counter++;?>
              
         <?php endwhile; ?>
    </div>
    
   <!-- Summary
     ================================================== -->     
    <div class="summarywrap">  
    	<div class="summarywrapinner" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">  
      <meta itemprop="worstRating" content = "1"/>
      <meta itemprop="bestRating" content = "10"/>                    
            <div class="summary">
                <?php echo $overview; ?>
                <div class="clear"></div>
            </div>
            <div class="ratingsummary" itemprop="description">
                <?php echo htmlspecialchars_decode($rating_summary); ?>
            </div>
            <div class="clear"></div>
        </div>
      <div class="clear"></div>
    </div>
    
    
</div>