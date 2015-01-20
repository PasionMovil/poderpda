<?php

/*******************************************************
*
*	Custom Social Counter Widget
*	By: Andre Gagnon
*	http://www.designcirc.us
*
*******************************************************/

// Initialize widget
add_action( 'widgets_init', 'ag_social_widgets' );

// Register widget
function ag_social_widgets() {
	register_widget( 'AG_Social_Widget' );
}

// Widget class
class ag_social_widget extends WP_Widget {

/*----------------------------------------------------------*/
/*	Set up the Widget
/*----------------------------------------------------------*/
	
	function AG_Social_Widget() {
	
		/* General widget settings */
		$widget_ops = array( 'classname' => 'ag_social_widget', 'description' => __('A widget that displays social links.', 'framework') );

		/* Widget control settings */
		$control_ops = array( 'width' => 400, 'height' => 350, 'id_base' => 'ag_social_widget' );

		/* Create widget */
		$this->WP_Widget( 'ag_social_widget', __('Custom Social Counter Widget', 'framework'), $widget_ops, $control_ops );
	}

/*----------------------------------------------------------*/
/*	Display The Widget 
/*----------------------------------------------------------*/
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );

		/* Variables from settings. */
		$twitter = $instance['twitter'];
		$facebook = $instance['facebook'];
		$rss = $instance['rss'];
		$rssurl = $instance['rssurl'];
		
		/* Before widget (defined in functions.php). */
		echo $before_widget;

		/* Display The Widget */
		?>
        
        <?php 
		// Get Manual RSS Stats, sanitize
		if ($rss) {
			if (!is_numeric ($rss)) {
			$rss = 0;	
			}	
		}
		?>

 <?php 
/* Display the widget title & subtitle if one was input (before and after defined by themes). */
if ( $title ) echo '<h3 class="widget-title">'.$title.'</h3>' ?>
		
<div class="socialwrap">	

<?php if ($facebook) { ?>
<a href="http://facebook.com/<?php echo $facebook; ?>" class="fb"></a>

<?php } if ($twitter) { ?>
<a href="http://twitter.com/<?php echo $twitter; ?>" class="tw"></a>

<?php } if ($rss) { ?>
<a href="http://feeds.feedburner.com/<?php echo $rssurl; ?>" class="rss"></a>

<?php } ?>

</div><div class="clear"></div>

<script type="text/javascript">
    jQuery(document).ready(function($){
		<?php if ($facebook) { ?>
        $('.fb').koottam({
            'id'            : '<?php echo $facebook; ?>',
            'method'        : 'api',
            'count_style'   : 'static',
            'theme'         : 'facebook-blue',
            'icon_url'      : '<?php echo get_template_directory_uri(); ?>/images/icons/social/fb_light.png',
			'service'		: 'facebook',
			'nameology'		: 'Fans'
        });
		<?php } if ($twitter) { ?>
		 $('.tw').koottam({
            'id'            : '<?php echo $twitter; ?>',
            'method'        : 'api',
            'count_style'   : 'static',
            'theme'         : 'twitter-blue',
            'icon_url'      : '<?php echo get_template_directory_uri(); ?>/images/icons/social/twitter.png',
			'service'		: 'twitter',
			'nameology'		: 'Followers'
        });
		<?php } if ($rss) { ?>
		$('.rss').koottam({
			'id'			: '<?php echo $rss; ?>',
			'method'		: 'custom',
			'count_style'	: 'static',
			'theme'         : 'rss-orange',
			'icon_url'      : '<?php echo get_template_directory_uri(); ?>/images/icons/social/rss.png',
			'size'          : 'default',
			'service'       : 'RSS',
			'count'         : <?php echo $rss; ?>,
			'nameology'		: 'Subscribers'
		});
		<?php } ?>
    });
</script>

<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}

/*----------------------------------------------------------*/
/*	Update the Widget
/*----------------------------------------------------------*/
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		/* Remove HTML: */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['rss'] = strip_tags( $new_instance['rss'] );		
		$instance['rssurl'] = strip_tags( $new_instance['rssurl'] );	

		return $instance;
	}
	

/*----------------------------------------------------------*/
/*	Widget Settings
/*----------------------------------------------------------*/
	 
	function form( $instance ) {

		/* Default widget settings */
		$defaults = array(
		'title' => '',
		'facebook' => 'envato',
		'twitter' => 'ajgagnon',
		'rss' => '0',
		'rssurl' => 'wptuts'
		
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

<p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>">
        <?php _e('Counter Widget Title (Optional):', 'framework') ?>
    </label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'facebook' ); ?>">
        <?php _e('Facebook ID (the end of your custom url):', 'framework') ?>
    </label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $instance['facebook']; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'twitter' ); ?>">
        <?php _e('Twitter ID (without the @):', 'framework'); ?>
    </label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $instance['twitter']; ?>" /> 
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'rssurl' ); ?>">
        <?php _e('Feedburner ID (end of your feedburner url):', 'framework'); ?>
    </label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'rssurl' ); ?>" name="<?php echo $this->get_field_name( 'rssurl' ); ?>" value="<?php echo $instance['rssurl']; ?>" /> 
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'rss' ); ?>">
        <?php _e('RSS Count: (Feedburner API deprecated, manual entry required)', 'framework'); ?>
    </label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" value="<?php echo $instance['rss']; ?>" /> 
</p>
<?php
	}
}
?>