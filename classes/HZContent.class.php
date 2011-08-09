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
	function get_excerpt($length = 52, $text = null, $readmore = true, $readmore_link = null) {
		global $post;

		$defaults = array(
			'length'=>52,
			'text'=>null,
			'readmore'=>true,
			'readmore_link'=>null,
		);
		
		if (is_array($length)) {		
			$options = array_merge($defaults,$length);
			extract($options)	;
		}

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
	function get_fb_like_button($url = null,$width = '90px', $height = '22px',$layout='standard') {

		if (is_null($url))
			return;
			
		$url = urlencode($url);

		return "<iframe class='fb-like' src='https://www.facebook.com/plugins/like.php?href=$url&amp;layout=$layout' scrolling='no' frameborder='0' style='height: $height; width: $width allowTransparency='true'></iframe>";

	
	}
	
	
	
	/**
	 *
	 * Print FB OpenGraph Meta Data
	 *
	 * Returns markup for a FB like button 
	 *
	 * @options array an array of meta values whose keys are OpenGraph meta properties
	 *	
	 */	
	function print_fb_meta($options = array()) {
		global $post, $cat;

		$defaults = array(
			'og:title'=>'',
			'og:type'=>'blog',
			'og:image'=>'/favicon.ico',
			'og:url'=>$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
			'og:site_name'=>get_bloginfo('name'),
			'fb:admins'=>'',
			'og:description'=>'',
		);
		
		//set the title		
		if (is_category()):
			$defaults['og:title'] = get_cat_name($cat);
		elseif(is_single()):
			$defaults['og:title'] = $post->post_title;
		else:
			$defaults['og:title'] = get_bloginfo('name');
		endif;
		
		//set the description
		if(is_single()):
			$defaults['og:description'] = $this->get_excerpt(array('readmore'=>false));
		else:
			$defaults['og:description'] = get_bloginfo('description');
		endif;		
		
		$options = array_merge($defaults,$options);
		
		foreach($options as $key => $value)
			echo "<meta property='$key' content='$value' />\n";
		
	}

		
	
}






