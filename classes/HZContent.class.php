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
	 * @param int $height the iframe height
	 * @param string $layout the button style. Can be "standard," "button_count," "box_count." Defaults to "standard."
	 *	
	 */	
	function get_fb_like_button($url = null,$width = '90px', $height = '22px',$layout='button_count') {
		global $post;

		if (is_null($url))
			$url = $this->get_tiny_url(get_permalink($post->ID));
			
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
		global $post, $cat, $wp_query;

		$defaults = array(
			'og:title'=>'',
			'og:type'=>'blog',
			'og:image'=>'/favicon.ico',
			'og:url'=>'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
			'og:site_name'=>get_bloginfo('name'),
			'fb:admins'=>'',
			'og:description'=> htmlspecialchars(get_bloginfo('description'),ENT_QUOTES),
		);
		
		//set the image		
		if(is_single()):
			$img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID));
			$defaults['og:image'] = $img[0];
		elseif(is_author()):
			$author = $wp_query->get_queried_object();
			$image = get_avatar($author->ID);
			$url = '';
			preg_match("/src='([^']*)'/",$image,$url);
			$defaults['og:image'] = $url[1];
		endif;
		
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
			$defaults['og:description'] = htmlspecialchars($this->get_excerpt(array('readmore'=>false)),ENT_QUOTES);
		elseif (is_author()):	
			$auth = $wp_query->get_queried_object();
			$excerpt = $this->get_excerpt(array('readmore'=>false,'text'=>$auth->user_description));
			$defaults['og:description'] = htmlspecialchars($excerpt." ...",ENT_QUOTES);
		endif;		
		
		$options = array_merge($defaults,$options);
		
		foreach($options as $key => $value)
			echo "<meta property='$key' content='$value' />\n";
		
	}
	
	
	/**
	 *
	 * Print ShareThis buttons with post-specific attributes
	 *
	 * Returns markup for ShareThis button tags with post titles, images, etc.
	 *
	 * @param string $button_name the name of the ShareThis button (ex: st_fblike_hcount)
	 * @param int $post_id the post id to share. Optional.
	 *	
	 */
	
	 function get_sharethis_button($button_name,$post_id = null) {
		global $post, $hzwp;
		
		if (!is_null($post_id))
			$post = get_post($post_id);
		
		$title = htmlspecialchars($post->post_title,ENT_QUOTES);
		$url = get_permalink($post->ID);
		
		$thumb_id = get_post_thumbnail_id($post->ID);
		$image = wp_get_attachment_image_src($thumb_id);
		$summary = htmlspecialchars($this->get_excerpt(25,null,false),ENT_QUOTES); 
	
					
		 return "<span class='$button_name' st_title='$post->post_title' st_url='$url' st_image='{$image[0]}' st_summary='$summary'></span>";

		
	}
	

	/**
	 *
	 * Get Tweet Button
	 *
	 * Returns markup for a Tweet button
	 *
	 * @param array $options an array of options (url=>post_url,via=>null,text=>post_title,related=>null,count=>null,lang=>'en',counturl=>null)
	 * @param int $post_id the post id to share. Optional. Defaults to global $post value.
	 *	
	 */
	function get_tweet_button($options = array(),$post_id = null,$width="97",$height="23") {
		global $post;

		if (!is_null($post_id))
			$post = get_post($post_id);

		$title = htmlspecialchars($post->post_title,ENT_QUOTES);
		$url = $this->get_tiny_url(get_permalink($post->ID));
		
		$thumb_id = get_post_thumbnail_id($post->ID);
		$image = wp_get_attachment_image_src($thumb_id);
		$summary = htmlspecialchars($this->get_excerpt(25,null,false),ENT_QUOTES);				
		
		
		$defaults = array(
			'url'=>$url,
			'via'=> get_bloginfo('name'),
			'text'=>$title,
			'related'=>null,
			'count'=>null,
			'lang'=>'en',
			'counturl'=>null,
		);
	
		$options = array_merge($defaults,$options);
		
		$src = "//platform.twitter.com/widgets/tweet_button.html?";
		
		foreach($options as $key => $value) {
			if (!is_null($value))
				$src .= "$key=$value&";
		}
		
		$src = rtrim($src,'&');
	
		
		$html = "<iframe class='hz-tweet-button' allowtransparency='true' width='$width' height='$height' frameborder='0' scrolling='no' src='$src'></iframe>";
		
		return $html;
		
		
	}


	/**
	 *
	 * Get Tiny Url
	 *
	 * Returns a url shortened version of $url via TinyURL
	 *
	 * @param array $url the url to shorten (url=>post_url,via=>null,text=>post_title,related=>null,count=>null,lang=>'en',counturl=>null)
	 *	
	 */	
	function get_tiny_url($url = null) {
		if (is_null($url))
			return $url;
		
		return file_get_contents("http://tinyurl.com/api-create.php?url=".$url);
	}
		
	
}






