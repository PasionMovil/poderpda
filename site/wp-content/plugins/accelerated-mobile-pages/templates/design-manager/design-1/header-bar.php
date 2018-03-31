<?php global $redux_builder_amp; ?>
<header id="#top" class="amp-wp-header">
  <div class="ampforwp-logo-area" >
    <?php do_action('ampforwp_header_top_design1'); ?>
    <?php amp_logo(); ?>
        <?php $site_icon_url = $this->get( 'site_icon_url' );
            if ( $site_icon_url ) : ?>
            <amp-img src="<?php echo esc_url( $site_icon_url ); ?>" width="32" height="32" class="amp-wp-site-icon"></amp-img>
        <?php endif; ?>
    </a>
    <?php if(isset($redux_builder_amp['ampforwp-amp-menu']) && $redux_builder_amp['ampforwp-amp-menu']){ ?>
    <div on='tap:sidebar.toggle' role="button" tabindex="0" class="nav_container">
        <a href="#" class="toggle-text">
            <span></span>
            <span></span>
            <span></span>
        </a>
    </div>
    <?php } ?>
    <?php do_action('ampforwp_header_search'); ?>
    <?php do_action('ampforwp_call_button');
    do_action('ampforwp_header_bottom_design1'); ?>



  </div>
</header>
<?php if(isset($redux_builder_amp['ampforwp-amp-menu']) && $redux_builder_amp['ampforwp-amp-menu']){ ?>
<amp-sidebar id='sidebar'
    layout="nodisplay"
    side="right">
  <div class="toggle-navigationv2">
      <div role="button" tabindex="0" on='tap:sidebar.close' class="close-nav">X</div> <?php
       // schema.org/SiteNavigationElement missing from menus #1229 ?>
      <nav id ="primary-amp-menu" itemscope="" itemtype="https://schema.org/SiteNavigationElement">
         <?php
         $menu_html_content = wp_nav_menu( array(
                                  'theme_location' => 'amp-menu' ,
                                  'link_before'     => '<span itemprop="name">',
                                  'link_after'     => '</span>',
                                  'menu'=>'ul',
                                  'echo' => false,
                                  'menu_class' => 'menu amp-menu'
                                ) );
        $menu_html_content = apply_filters('ampforwp_menu_content', $menu_html_content);
        $sanitizer_obj = new AMPFORWP_Content( $menu_html_content, array(), apply_filters( 'ampforwp_content_sanitizers', array( 'AMP_Img_Sanitizer' => array(), 'AMP_Style_Sanitizer' => array(), ) ) );
        $sanitized_menu =  $sanitizer_obj->get_amp_content();
        echo $sanitized_menu;
        ?>
    </nav>
  </div>
</amp-sidebar>
<?php }
do_action('ampforwp_design_1_after_header');