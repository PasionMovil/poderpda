<?php
/*-----------------------------------------------------------------------------------*/
/*	Adsense Widget Class
/*-----------------------------------------------------------------------------------*/

class VCE_Adsense_Widget extends WP_Widget { 

	var $defaults;

	function VCE_Adsense_Widget() {
		$widget_ops = array( 'classname' => 'vce_adsense_widget', 'description' => __('You can place Google AdSense or any JavaScript related code inside this widget', THEME_SLUG) );
		$control_ops = array( 'id_base' => 'vce_adsense_widget' );
		$this->WP_Widget( 'vce_adsense_widget', __('Voice Adsense', THEME_SLUG), $widget_ops, $control_ops );

		$this->defaults = array( 
				'title' => __('Adsense', THEME_SLUG),
				'adsense_code' => '',
				'expand' => 0
			);
	}

	
	function widget( $args, $instance ) {
		extract( $args );
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		if($instance['expand']){
			$before_widget = preg_replace('/class="(.*)"/', 'class="$1 vce_adsense_expand"', $before_widget);
		}

		echo $before_widget;

		if ( !empty($title) ) {
			echo $before_title . $title . $after_title;
		}
		
		$adsense_code = !empty( $instance['adsense_code'] ) ? $instance['adsense_code'] : '';

		?>
		<div class="vce_adsense_wrapper">
			<?php echo $adsense_code; ?>
		</div>
	
		<?php
			echo $after_widget;
	}

	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['adsense_code'] = current_user_can('unfiltered_html') ? $new_instance['adsense_code'] : stripslashes( wp_filter_post_kses( addslashes($new_instance['adsense_code']) ) );
		$instance['expand'] = isset($new_instance['expand']) ? 1 : 0;
		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, $this->defaults ); ?>
			
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', THEME_SLUG); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
			<small class="howto"><?php _e('Leave empty for no title', THEME_SLUG); ?></small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'adsense_code' ); ?>"><?php _e('Adsense Code', THEME_SLUG); ?>:</label>
			<textarea id="<?php echo $this->get_field_id( 'adsense_code' ); ?>" type="text" name="<?php echo $this->get_field_name( 'adsense_code' ); ?>" class="widefat" rows="10"><?php echo $instance['adsense_code']; ?></textarea>
			<small class="howto"><?php _e('Place your Google Adsense code or any JavaScript related advertising code.', THEME_SLUG); ?></small>
		</p>

		<p>
			<input id="<?php echo $this->get_field_id( 'expand' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'expand' ); ?>" value="1" <?php checked(1, $instance['expand']); ?>/>
			<label for="<?php echo $this->get_field_id( 'expand' ); ?>"><?php _e('Expand widget area to 300px', THEME_SLUG); ?></label>
			<small class="howto"><?php _e('Check this option if you are using 300px wide adsense so it can fit your widget area', THEME_SLUG); ?></small>
		</p>
				
	<?php
	}
}

?>