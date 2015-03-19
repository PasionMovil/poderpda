<?php
global $post, $display_content;
$page_content = get_post_field( 'post_content', $post->ID );
if ( !empty( $page_content ) ) {
	$page_content = apply_filters( 'the_content', $page_content );
	$style_class = $display_content['style'] == 'wrap' ? ' vce-post' : '';
	$width_class = $display_content['width'] == 'full' ? '-full' : '';
	$bottom_class = $display_content['position'] == 'down' ? ' vce-content-bottom' : '';
	echo '<div class="container'.$width_class.$bottom_class.'"><div class="vce-custom-content'.$style_class.'">'.$page_content.'</div></div>';
}
?>