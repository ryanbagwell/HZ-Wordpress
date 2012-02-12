<?php
/**
 * Plugin Name: HZ Wordpress
 * Plugin URI: http://www.hzdg.com
 * Description: A library of Wordpress functions
 * Version: 1.0
 * Author: Ryan Bagwell
 * Author URI: http://www.ryanbagwell.com
 * License: GPL2
 * @package HZ Wordpress
 * @author Ryan Bagwell 
 *
*/

$hzwp = new stdClass();

/**
 * A library of functions commonly used in WordPress development
 *
 * @link http://www.ryanbagwell.com
 * @link http://www.hzdg.com
 *
 * @package HZWordpress
 * @author Ryan Bagwell <ryan@ryanbagwell.com>
 * @version 1.0
 * @abstract
 * @copyright none  
 */
class HZWP {

	private $options;
		
	public function HZWP($options = array()) {

		$this->set_options($options);
				
		$this->require_files();
		
		$this->load_classes();
	
		$GLOBALS['hzwp'] == $this;	

	}
	
	private function require_files() {
		
		$handle = opendir(dirname(__FILE__).'/classes');
		
		while(false != ($file = readdir($handle))) {
			
			//ignore system files
			if (substr($file,0,1) == '.' )
				continue;
			
			require_once(dirname(__FILE__)."/classes/$file");
		}		
		
	}
	
	private function load_classes() {
		
		$handle = opendir(dirname(__FILE__).'/classes');
		
		while(false != ($file = readdir($handle))) {

			//ignore system files
			if (substr($file,0,1) == '.' )
				continue;
				
			$parts = explode('.',$file);
			$class_name = $parts[0];
			$property_name = strtolower(substr($parts[0],2));
			$this->$property_name = new $class_name($this->options);
		}
	}

	function hzwp_activate() {
	
		$hzwp = new HZWP();
		
		$i = new HZInstall();
		$i->hz_install();		
	}
	
	function set_options($options = array()) {

		$defaults = array(
			'site_author' => 'Hirshorn Zuckerman Design Group',
			'print_author_tag' => true,
			'load_swf_object' => false,
			'use_jquery_google_cdn' => true,
			'use_jquery_ui_google_cdn' => true,
			'load_jquery_ui' => false,
			'load_moderinzr' => false
		);
		
		$options = array_merge($defaults,$options);

		$this->options = new stdClass();
	
		
		foreach($options as $key => $value) {
			$this->options->$key = $value;
		}
		
	}	
	
	
	function hzwp_create() {
		global $hzwp;
		
		$hzwp = new HZWP($hzwp->options);
	
	}
	
}

add_action('init',array('HZWP','hzwp_create'));

register_activation_hook(__FILE__,array('HZWP','hzwp_activate'));

	
