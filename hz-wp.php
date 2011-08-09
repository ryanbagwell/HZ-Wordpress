<?php
/*
Plugin Name: HZWP
Plugin URI: http://www.hzdg.com
Description: A library of Wordpress functions
Version: 1.0
Author: Ryan Bagwell
Author URI: http://www.ryanbagwell.com
License: GPL2
*/

$hzwp = new HZWP();

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
		
	public function HZWP() {

				
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
			$this->$property_name = new $class_name;
		}
	}

	function hzwp_activate() {
	
		$hzwp = new HZWP();
		
		$i = new HZInstall();
		$i->hz_install();		
	}
	
}



register_activation_hook(__FILE__,array('HZWP','hzwp_activate'));

	
