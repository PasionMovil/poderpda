<!-- Show this box once the theme is updated -->
<?php 
		$protocol = isset( $_SERVER['https'] ) ? 'https://' : 'http://';
		$vce_ajax_url = admin_url( 'admin-ajax.php', $protocol );
?>
<script>
	(function($) {
		$(document).ready(function() {
				$("body").on('click', '#vce_update_box_hide',function(e){
	    			e.preventDefault();
	    			$(this).parent().parent().remove();
	    			$.post('<?php echo $vce_ajax_url; ?>', {action: 'vce_update_version'}, function(response) {});
    			});

				$("body").on('click', '#vce_feedback a',function(e){
	    			e.preventDefault();
	    			var wrap_id = $(this).attr("data-wrap");
	    			$('.vce_feedback_wrap').hide();
	    			$('#vce_feedback').hide();
	    			$('#'+wrap_id).show();
	    			$('#vce_feedback a').removeClass('selected');
	    			$(this).toggleClass('selected');
    			});

         /*-----------------------------------------------------------------------------------*/
        /* Open popup on post share links
        /*-----------------------------------------------------------------------------------*/
        $('body').on('click', '.mks-twitter-share-button', function(e) {
            e.preventDefault();
            var data = $(this).attr('data-url');
            vce_social_share(data);
        });

        function vce_social_share(data) {
            window.open(data, "Share", 'height=500,width=760,top=' + ($(window).height() / 2 - 250) + ', left=' + ($(window).width() / 2 - 380) + 'resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0');
        }

		});
	})(jQuery);

</script> 

<h3>Congratulations, your website just got better!</h3>
<p><strong><?php echo THEME_NAME; ?></strong> theme has been successfully updated to <strong>version <?php echo THEME_VERSION; ?>.</strong></p>
<p><a href="http://demo.mekshq.com/voice/documentation/#changelog" target="_blank" class="button-primary">View changelog</a></p>
<div class="feedback_wrapper">

<h3>How do you feel about Voice theme so far?</h3>
<ul id="vce_feedback">
	<li><a href="" class="happy_link" data-wrap="vce_happy_wrap">Happy</a></li>
	<li><a href="" class="sad_link" data-wrap="vce_sad_wrap">Sad</a></li>
</ul>
<div id="vce_happy_wrap" class="vce_feedback_wrap">
	<p><strong>Great! That's why we have to work hard every day! <br/> Let more people know about Voice and help us make our products better!</strong></p>
<?php 
$tweet_text = "I'm very happy using Voice WordPress theme for my website! Check out this great #WordPress theme by @meksHQ";
$tweet_url = "http://mekshq.com/demo/voice";
?>
	<a class="mks-twitter-share-button" href="javascript:void(0);" data-url="http://twitter.com/intent/tweet?url=<?php echo $tweet_url; ?>&amp;text=<?php echo urlencode($tweet_text); ?>"><i class="el-icon-twitter"></i> Tweet about Voice</a>
</div>

<div id="vce_sad_wrap" class="vce_feedback_wrap">
	<p><strong>Yikes! Sorry to hear that.</strong></p>
	<p>If you have any issues with the theme or any ideas how we can improve it, do not hesitate to <a href="http://mekshq.com/contact" target="_blank">contact our support</a>.</p>
	<p>Also, if you find this theme hard to use, please <a href="http://demo.mekshq.com/voice/documentation" target="_blank">visit our documentation</a> in order to find some answers about the setup.</p>
</div>
</div>
<p class="description"><a href="#" id="vce_update_box_hide">Hide this message</a></p>