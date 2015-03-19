<?php
/*-----------------------------------------------------------------------------------*/
/*	Register widgets
/*-----------------------------------------------------------------------------------*/ 

if(!function_exists('vce_register_widgets')) :
	function vce_register_widgets(){
			
			//Include widget classes
	 		require_once('widgets/posts.php');
	 		require_once('widgets/video.php');
	 		require_once('widgets/adsense.php');

			register_widget('VCE_Posts_Widget');
			register_widget('VCE_Video_Widget');
			register_widget('VCE_Adsense_Widget');
	}
endif;

?>