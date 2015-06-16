<?php get_header(); ?>

<div id="content" class="container site-content">

	<?php global $vce_sidebar_opts; ?>
	<?php if ( $vce_sidebar_opts['use_sidebar'] == 'left' ) { get_sidebar(); } ?>

	<div id="primary" class="vce-main-content">

		<main id="main" class="main-box main-box-single">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'sections/content',get_post_format()); ?>

		<?php endwhile; ?>

		<?php if(vce_get_option('show_prev_next')) : ?>
			<?php get_template_part('sections/prev-next'); ?>
		<?php endif; ?>

		</main>

		<?php if(vce_get_option('show_author_box') && vce_get_option('author_box_position') == 'up') : ?>
			<?php get_template_part('sections/author-box'); ?>
		<?php endif; ?>

		<?php if(vce_get_option('show_related')) : ?>
			<?php get_template_part('sections/related-box'); ?>
		<?php endif; ?>

        <!-- SEO Tags -->
        <?php seoqueries_get_page_terms($plain_text = false); ?>

		<?php if(vce_get_option('show_author_box') && vce_get_option('author_box_position') == 'down') : ?>
			<?php get_template_part('sections/author-box'); ?>
        <?php endif; ?>

        <!-- Begins hardcoded "Related from the web" -->


        <div id="_CI_widget_34009"></div>
        <script type='text/javascript'>
        (function() {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'http://widget.crowdignite.com/widgets/34009?v=2&_ci_wid=_CI_widget_34009';
        script.async = true;
        document.getElementsByTagName('head')[0].appendChild(script);
        })();
        </script>
        <style>
        #_ci_widget_div_34009{-moz-box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);-ms-box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);-o-box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);-webkit-box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);display:inline-block;height:auto;line-height:.8em;width:100%;}
        #_ci_widget_div_34009 .ci_text{-moz-box-sizing:border-box;-ms-box-sizing:border-box;-o-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;display:block;margin:12px 0 4px;padding:0 20px;}
        #_ci_widget_div_34009 .ci_text > a{-moz-transition:all .2s ease-in-out;-ms-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;color:#232323;font-family:Roboto,sans-serif;font-size:22px;font-weight:500;line-height:28px;text-decoration:none;text-transform:uppercase;transition:all .2s ease-in-out;}
        #_ci_widget_div_34009 .ci_text > a:hover{-moz-transition:all .2s ease-in-out;-ms-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;color:#1e73be;transition:all .2s ease-in-out;}
        #_ci_widget_div_34009 ul{-moz-box-sizing:border-box;-ms-box-sizing:border-box;-o-box-sizing:border-box;-webkit-box-sizing:border-box;-webkit-margin-after:0;-webkit-margin-before:0;-webkit-padding-start:0;box-sizing:border-box;display:inline-block;list-style-type:none;margin:0;padding:20px 20px 0;width:100%;}
        #_ci_widget_div_34009 ul li{-moz-box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);-ms-box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);-o-box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);-webkit-box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);background:#fff;box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);float:left;height:327px;line-height:.8em;list-style-type:none;margin:0 0 3% 3%;vertical-align:top;width:48.5%;}
        #_ci_widget_div_34009 ul li > a{display:block;height:auto;overflow:hidden;width:100%;}
        #_ci_widget_div_34009 ul li > a img{-moz-transition:0 .3s ease-in-out;-ms-transition:0 .3s ease-in-out;-o-transition:0 .3s ease-in-out;-webkit-transition:0 .3s ease-in-out;backface-visibility:hidden;display:block;height:auto;transition:transform .3s ease-in-out;width:100%;}
        #_ci_widget_div_34009 ul li > a img:hover{-moz-transform:scale(1.1);-moz-transition:0 .3s ease-in-out;-ms-transform:scale(1.1);-ms-transition:0 .3s ease-in-out;-o-transform:scale(1.1);-o-transition:0 .3s ease-in-out;-webkit-transform:scale(1.1);-webkit-transition:0 .3s ease-in-out;transform:scale(1.1);}
        #_ci_widget_div_34009 ul li:first-child{margin-left:0;}
        #_ci_widget_div_34009 ul li:nth-child(3){clear:left;margin-left:0;}
        #_ci_widget_div_34009:before{-moz-box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);-ms-box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);-o-box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);-webkit-box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);-webkit-font-smoothing:antialiased;background:#fff;box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);color:#232323;content:'Desde la web';display:block;font-family:Roboto,sans-serif;font-size:22px;font-weight:500;line-height:25px;padding:15px 15px 18px;text-align:center;text-decoration:none;text-transform:none;}
        @media only screen and (min-width:220px) and (max-width:669px) {#_ci_widget_div_34009 ul{padding:10px 10px 0;}#_ci_widget_div_34009 ul li{clear:none;margin-left:0;width:100%;}#_ci_widget_div_34009:before{font-size:18px;line-height:22px;padding:10px 10px 12px;}}
        </style>

        <!-- Ends hardcoded "Related from the web" -->

		<?php comments_template(); ?>

	</div>

	<?php if ( $vce_sidebar_opts['use_sidebar'] == 'right' ) { get_sidebar(); } ?>

</div>

<?php get_footer(); ?>
