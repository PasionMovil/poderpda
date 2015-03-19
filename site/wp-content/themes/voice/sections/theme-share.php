<?php
	$theme_url = 'http://themeforest.net/item/voice-clean-newsmagazine-wordpress-theme/9646105';
	$theme_title = 'Voice - Simple News/Magazine WordPress Theme';
?>
<?php if(!empty($theme_url) && !empty($theme_title)) : ?>
<script type="text/javascript">
	(function(w, d, s) {
		function go(){
		var js, fjs = d.getElementsByTagName(s)[0], load = function(url, id) {
		if (d.getElementById(id)) {return;}
	  	js = d.createElement(s); js.src = url; js.id = id;
	  	fjs.parentNode.insertBefore(js, fjs);
		};
		load('//connect.facebook.net/en_US/all.js#xfbml=1', 'fbjssdk');
		load('https://apis.google.com/js/plusone.js', 'gplus1js');
		load('//platform.twitter.com/widgets.js', 'tweetjs');
		load('//assets.pinterest.com/js/pinit.js', 'pinitjs');
	}
	if (w.addEventListener) { w.addEventListener("load", go, false); }
		else if (w.attachEvent) { w.attachEvent("onload",go); }
	}(window, document, 'script'));
</script> 
<ul id="vce_share">
				<li class="twitter"><a class="twitter-share-button" data-count="horizontal" data-via="mekshq" data-text="<?php echo $theme_title; ?>" data-url="<?php echo $theme_url; ?>"></a></li>
				<li class="facebook"><div class="fb-like" data-send="false" data-layout="button_count" data-width="50" data-show-faces="false" data-href="<?php echo $theme_url.'?ref=meks'; ?>"></div></li>
				<li class="gplus"><g:plusone size="medium" href="<?php echo $theme_url; ?>"></g:plusone></li>
				<li class="pinterest"><a href="http://pinterest.com/pin/create/button/?url=<?php echo $theme_url; ?>&description=<?php echo urlencode($theme_title); ?>" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></li>
</ul>

<?php endif; ?>