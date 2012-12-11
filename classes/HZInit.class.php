<?php
class HZInit extends HZWP {
	
	private $options;
	
	function HZInit($options) {

		$this->options = $options;

		$this->utilities = new HZUtilities();
		
		if ($this->options->use_jquery_google_cdn)
			$this->set_jquery_cdn();
		
		$this->remove_generator_meta();
		
		if ($this->options->print_author_tag)
			add_action('wp_head', 
				array($this,'print_author_tag'), null, null);
				
		add_theme_support('post-thumbnails');
		add_theme_support('post-formats');
			
	}

  /**
   *
   * Set jQuery CDN
   *
   * Loads jQuery from cdn instead of from the local wordpress install
   *
   * @author Ryan Bagwell <ryan@ryanbagwell.com>
   * @return void
	 *
  */	
	function set_jquery_cdn() {
		wp_deregister_script('jquery');
		wp_register_script('jquery',
			'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
	}

  /**
   *
   * CSS directory setter
   *
   * Specifies the new CSS Directory
   *
   * @author Ryan Bagwell <ryan@ryanbagwell.com>
   * @return void
	 *
  */
	function set_stylesheet_dir($stylesheet_uri = null,$theme_name){
		
		if (is_null($stylesheet_uri))
			$stylesheet_uri = TEMPLATEPATH."/css";
		
		return $stylesheet_uri.'/css';
	
	}


  /**
   *
   * Generator meta tag remover
   *
   * Removes the generator meta tag from the head section
   *
   * @author Ryan Bagwell <ryan@ryanbagwell.com>
   * @return void
	 *
  */	
	function remove_generator_meta() {
		remove_action('wp_head', 'wp_generator');
	}

  /**
   *
   * Author Setter
   *
   * Adds an author tag to the 
   *
   * @author Ryan Bagwell <ryan@ryanbagwell.com>
   * @return void
	 *
  */	
	function print_author_tag() {
		
		echo "<meta name='author' content='{$this->options->site_author}' />\r\n";
	}
	
}

?>
