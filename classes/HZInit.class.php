<?php
class HZInit extends HZWP {
	
	function HZInit() {

		$this->utilities = new HZUtilities();

		$this->add_stylesheets();
		
		if (!is_admin())
			$this->add_javascript();
				
		$this->remove_generator_meta();
		
		add_action('wp_head',array('HZInit','print_author_tag'),null,null);

		add_theme_support('post-thumbnails');
		add_theme_support('post-formats');
			
	}

	function add_stylesheets() {

				
		if(!is_admin())
			wp_enqueue_style('main-styles',get_bloginfo('template_url').'/css/style.css');		
				
		wp_enqueue_style('jquery-ui-lightness',get_bloginfo('template_url').'/css/jquery-ui-lightness.css');

		if ($this->utilities->is_ie() == 'IE6')
			wp_enqueue_style('ie6',get_bloginfo('template_url').'/css/ie6.css','main-styles');
		
		if ($this->utilities->is_ie() == 'IE7')
			wp_enqueue_style('ie7',get_bloginfo('template_url').'/css/ie7.css','main-styles');

		if ($this->utilities->is_ie() == 'IE8')
			wp_enqueue_style('ie8',get_bloginfo('template_url').'/css/ie8.css','main-styles');
			
		add_action('login_head',create_function(null,"echo '<link rel=\"stylesheet\" type=\"text/css\" href=\"" . get_bloginfo('stylesheet_directory') . "/hz-admin.css\" />';"));		
	
		if(is_admin())
			wp_enqueue_style('hz-admin',get_bloginfo('template_url').'/css/hz-admin.css');			
			
	}


	function add_javascript() {
		if (!is_admin()) {
			wp_deregister_script('jquery');
			wp_enqueue_script('jquery',get_bloginfo('template_url').'/js/jquery-latest.min.js'); 
			wp_enqueue_script('jquery-ui',get_bloginfo('template_url').'/js/jquery-ui-latest.min.js','jquery');
			wp_enqueue_script('swfobject',get_bloginfo('template_url').'/js/swfobject-latest.js','jquery');
			wp_enqueue_script('global-scripts',get_bloginfo('template_url').'/js/global-scripts.js','jquery',null,true);  		  
		}
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
	function print_author_tag($author = "Hirshorn Zuckerman Design Group") {
		
		echo "<meta name='author' content='$author' />\r\n";
	}
	
}

?>
