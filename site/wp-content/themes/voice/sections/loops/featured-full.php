<div class="vce-featured">

    <div class="vce-featured-header">
        <div class="vce-featured-info">
            <div class="vce-hover-effect">

                <?php if ( vce_get_option( 'lay_fa_big_cat' ) ) : ?>
                    <div class="vce-featured-section">
                        <?php echo vce_get_category(); ?>
                    </div>
                <?php endif; ?>

                <h2 class="vce-featured-title">
                    <a class="vce-featured-link-article" href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>"><?php the_title(); ?></a>        
                </h2>

                <?php if ( $meta = vce_get_meta_data( 'lay-fa-big' ) ) : ?>
                    <div class="entry-meta"><?php echo $meta; ?></div>
                <?php endif; ?>

            </div>
        </div>
        
        <a href="<?php echo esc_url(get_permalink()); ?>" class="vce-featured-header-background"></a>
    </div>


    <?php if($fimage = vce_featured_image('vce-fa-full')): ?>         
            <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
                <?php echo $fimage; ?>
            </a>
    <?php endif; ?> 


</div>