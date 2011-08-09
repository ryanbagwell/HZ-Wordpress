<?php

class HZContent {


	/**
	 *
	 * Get Excerpt
	 *
	 * Returns the excerpt based on provided text string
	 *
	 * @param int the $length the number of words to return
	 * @param string $text a text string with which to replace the excerpt
	 * @param	bool $readmore add a readmore link to the end of the excerpt
	 * @param	string $readmore_link the url of the readmore link link
	 * @return bool returns the excerpt on success, false on failure
	 *	
	 */
	function get_excerpt($length = 52,$text = null,$readmore = true, $readmore_link = null) {
		global $post;

		//use the current post body if a text value is not specified
		if (is_null($text))
			$text = $post->post_content;

		//remove any shortcode tags
		$text = preg_replace('/\[[^\]]*\]/', '', $text);

		//replace line breaks with spaces
		$text = str_replace("\n",' ',$text);

		//remove html tags
		$text = strip_tags($text);

		//explode it between spaces
		$words = explode(' ',$text);

		//chunk it
		$words = array_chunk($words,$length);

		//glue them back together
		$excerpt = implode(' ',$words[0]);
		
		$excerpt = rtrim(trim($excerpt),'.');

		if(!$readmore_link && $post)
			$readmore_link = get_permalink($post->ID);
		
		if ($readmore)
			$excerpt .= " ... <a class='read-more' href='$readmore_link'>Read more</a>";
		
		return rtrim($excerpt,',.');

	}
	
	/**
	 *
	 * Get FB Like Button
	 *
	 * Returns markup for a FB like button 
	 *
	 * @param string the $url the url of the page. defaults to null.
	 * @param int $width the iframe width
	 * @param	int $height the iframe height
	 * @param	string $layout the button style. Can be "standard," "button_count," "box_count." Defaults to "standard."
	 *	
	 */	
	function get_fb_like_button($url = null,$width = 90, $height = 20,$layout='standard') {

		if (is_null($url))
			return;
			
		$url = urlencode($url);

		return 	"<iframe class='fb-like' src='http://www.facebook.com/plugins/like.php?app_id=133916296698900&amp;href=$url&amp;layout=$layout&amp;width=$width&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=$height' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width:$width"."px; height:$height"."px; allowTransparency='true'></iframe>";
	
	}
	
	


		
	
}






