<?php

/*******************************************************
*
*	Custom 480px Ad Widget
*	By: Andre Gagnon
*	http://www.designcirc.us
*
*******************************************************/

// Initialize widget
add_action( 'widgets_init', 'ag_480ad_widgets' );

// Register widget
function ag_480ad_widgets() {
	register_widget( 'AG_480Ad_Widget' );
}

// Widget class
class ag_480ad_widget extends WP_Widget {

/*----------------------------------------------------------*/
/*	Set up the Widget
/*----------------------------------------------------------*/
	
	function AG_480Ad_Widget() {
	
		/* General widget settings */
		$widget_ops = array( 'classname' => 'ag_480ad_widget', 'description' => __('A widget that displays 480px by 60px ads.', 'framework') );

		/* Widget control settings */
		$control_ops = array( 'width' => 400, 'height' => 350, 'id_base' => 'ag_480ad_widget' );

		/* Create widget */
		$this->WP_Widget( 'ag_480ad_widget', __('Custom 480px by 60px Ad Widget', 'framework'), $widget_ops, $control_ops );
	}

/*----------------------------------------------------------*/
/*	Display The Widget 
/*----------------------------------------------------------*/
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );

		/* Variables from settings. */
		$ad1 = $instance['ad1'];
		$adlink1 = $instance['adlink1'];

		/* Before widget (defined in functions.php). */
		echo $before_widget;

		/* Display The Widget */
		?>
        
        <?php 

        // Store all ads in an array
        $allads = array();

		/* Display the widget title & subtitle if one was input (before and after defined by themes). */
		if ( $title )
		echo $before_title . $title . $after_title; ?>
		
		<div class="ads480">

				<?php if ( $adlink1 && $ad1 )
					$ad = '<a href="' . $adlink1 . '" target="_blank"><img src="'. $ad1 .'" width="480" height="80" alt="" /></a>';

				//Display ads
					echo $ad; ?>

			<div class="clear"></div>		
		</div>

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

		/* Variables from settings. */
		$instance['ad1'] = $new_instance['ad1'] ;
		$instance['adlink1'] = $new_instance['adlink1'];				
	
		return $instance;
	}
	

/*----------------------------------------------------------*/
/*	Widget Settings
/*----------------------------------------------------------*/
	 
	function form( $instance ) {

		/* Default widget settings */
		$defaults = array(
		'title' => 'Sponsor',
		'ad1' => get_template_directory_uri()."/images/480x80.gif",
		'adlink1' => 'http://themeforest.net/user/2winFactor/portfolio?ref=2winfactor'
		
		);

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

<p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>">
        <?php _e('Ad Title (Optional):', 'framework') ?>
    </label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'ad1' ); ?>">
        <?php _e('Ad 1 Image URL:', 'framework') ?>
    </label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'ad1' ); ?>" name="<?php echo $this->get_field_name( 'ad1' ); ?>" value="<?php echo $instance['ad1']; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'adlink1' ); ?>">
        <?php _e('Ad 1 Link:', 'framework') ?>
    </label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'adlink1' ); ?>" name="<?php echo $this->get_field_name( 'adlink1' ); ?>" value="<?php echo $instance['adlink1']; ?>" />
</p>
<?php
	}
}
?>