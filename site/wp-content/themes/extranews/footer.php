</div>
</div>
<!-- Close Mainbody and Sitecontainer and start footer
  ================================================== -->
<div class="clear"></div>
<div id="footer">
    <div class="container clearfix">
        <div class="footerwidgetwrap">
            <div class="footerwidget"><?php	/* Widget Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Left') ) ?></div>
            <div class="footerwidget"><?php	/* Widget Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Center') ) ?></div>
            <div class="footerwidget"><?php	/* Widget Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Right') ) ?></div>
            <div class="clear"></div>

<!-- Theme Hook -->
<?php wp_footer(); ?>


<?php if ( get_post_meta( get_the_ID(), 'quita-hotw', true ) ) { ?>
<!-- Sin Hotwords --> 
<?php }else{ ?>
<!-- Hotwords --> 
<!-- Hotwords -->
<script src='http://ads7531.hotwords.com.mx/show.jsp?id=7531&cor=2163e6'></script>
<?php } ?>
<!-- Close Site Container
  ================================================== -->

<!-- Quick and dirty overlap fix -->
<script type="text/javascript">
jQuery('img').load(function() {
    jQuery(window).trigger('resize');
});
jQuery(window).load(function() {
    jQuery(window).trigger('resize');
})
</script>
</body>
</html>