  <div class="minimalsharewrapper">
   <!-- <p class="sharetitle"><?php _e('Share This:', 'framework');?></p> -->
    <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'postnc' ); ?>
    <div class="minimalshare">
      <a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" title="<?php _e('Share on Facebook', 'framework');?>" class="facebook tooltip-top"><?php _e('Share on Facebook', 'framework');?></a>
      <a target="_blank" href="http://twitter.com/home?status=<?php the_permalink(); ?>" title="<?php _e('Tweet This', 'framework');?>" class="twitter tooltip-top"><?php _e('Tweet This', 'framework');?></a>
      <a target="_blank" href="http://plus.google.com/share?url=<?php the_permalink(); ?>" title="<?php _e('Share on Google Plus', 'framework');?>" class="google tooltip-top"><?php _e('Share on Google Plus', 'framework');?></a>
      <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink();?>&media=<?php echo $thumb[0]; ?>&description=<?php echo rawurlencode(get_the_title()); ?>" onclick="window.open(this.href); return false;" title="<?php _e('Pin This', 'framework');?>" class="pinterest tooltip-top"><?php _e('Pin This', 'framework');?></a>
      <a target="_blank" href="mailto:?subject=<?php echo rawurlencode(get_the_title()); ?>&body=<?php _e("Check out", "framework"); ?>&#39;<?php echo rawurlencode(get_the_title()); ?>&#39;:%0D%0A<?php the_permalink(); ?>" title="<?php _e('Email This', 'framework');?>" class="email tooltip-top"><?php _e('Email This', 'framework');?></a>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
  </div>