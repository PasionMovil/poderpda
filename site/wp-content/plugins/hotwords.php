<?php
/*
Plugin Name: Hotwords
Description: Integra facil Hotwords en tu Wordpress
Author: Silviu Daniel Eftimie
Author URI: http://www.silviueftimie.com
Version: 2.0
*/
	function my_function($text)
	{
 		 //$meta_values = get_post_meta(the_ID(), "hotwords", true);
		 $meta=get_post_custom($post_id);
		 if ($meta[hotwords][0]=="false")
		 {
		 	 $text=$text;
		 }
		 else
		 {
		 	$text="<div id=\"HOTWordsTxt\">". $text. "</div>";
		 }
		 
		 return $text;
	}
	
	function my_footer()
	{
		 $idhotwords = get_option('hotwords_partner_id');
		 $linkColor = get_option('hotwords_linkcolor');
		 $content = "
		 <!-- start hotwords v2.0 -->
		 <script src=\"http://ads".trim($idhotwords).".hotwords.com/show.jsp?id=".trim($idhotwords)."&amp;tag=div&amp;atr=id&amp;vatr=HOTWordsTxt&amp;cor=".trim($linkColor)."\"></script>
		 <!-- end hotwords v2.0 -->

		 ";
	     echo $content;
	}
	
	function hotwords_menu() 
	{
		add_options_page('HOTWords Settings', 'HOTWords', 8, __FILE__, 'hotwords_options_menu');
	}
	
	function hotwords_options_menu()
	{
		$partner_id = get_option('hotwords_partner_id');
		$linkColor = get_option('hotwords_linkcolor');
		
		if ($_POST['action'] == 'update')
		{
			update_option('hotwords_partner_id', $_POST['partner_id']);
			$partner_id = $_POST['partner_id'];
			$linkColor = $_POST['linkColor'];
			$linkColor = str_replace("#", "", $linkColor);
			update_option('hotwords_linkcolor', $linkColor);
		}
		
		echo("<div class=\"wrap\">");
		echo("<h2> HOTWords </h2>");
	
		echo("<form method=\"post\" name=\"tcp_test\" action=\"\">");
		echo("<p>");
		echo("IdSite: <input type=\"text\" name=\"partner_id\" value='");
		echo($partner_id);
		echo("' />");
		echo("</p>");
		
		
		echo("<script language=JavaScript src='http://includes.canalmail.com/js/paleta.js' ></script>");
		echo("<p> Color: ");

		for($i=0; $i < count($lingua); $i++) {
			if($urlGravada == $lingua[$i]["url"]) {  echo("<p>".$lingua[$i]["txt4"]." :"); } 
		}

		echo("<a href=\"javascript:pickColor('tcptestinput2');\" id=\"tcptestinput2\" style=\"border: 1px solid #000000; font-family:Verdana; font-size:10px; text-decoration: none;\">&nbsp;&nbsp;&nbsp;</a>");
		echo("<input id=\"tcptestinput2field\" size=\"7\" name='linkColor' value='#");
		echo($linkColor);
		echo("'>");
		echo("<div id=colorpicker></div>");
		echo("<script language=\"javascript\">relateColor('tcptestinput2', getObj('tcptestinput2field').value);</script>");
    	echo("</p>");

		echo("<input type=\"hidden\" name=\"action\" value='update' />");
		echo("<input type=\"submit\" name=\"Submit\" value=\"");
		echo(_e('Update Options &gt;&gt;'));
		echo("\" />");
		echo("</p>");
		echo("</form>");
	}

	add_filter('the_content', 'my_function');
	add_filter('comment_text', 'my_function');
	add_filter('the_excerpt', 'my_function');
	add_action('wp_footer', 'my_footer');
	add_action('admin_menu', 'hotwords_menu');
?>