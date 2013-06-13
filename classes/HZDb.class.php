<?php

class HZDb {

	/**
	 *
	 * Wordpress Database Migration Helper
	 *
	 * Provides a standard method to search for domain names in urls in the 
	 * WP database, and replace it with the new 
	 *
	 * @param string $search the domain to search for
	 * @param string $replace the domain replacement. defaults to SERVER_NAME
	 * @param	array $db an associative array of db connection params to use ($host,$username,$password,$dbname) if migrating a db outside of wordpress 
	 * @return bool returns true on success, false on failure
	 *	
	 */
	 public function db_migrate($search, $replace = null, $db_params = array()) {
	
		if (is_null($replace))
			$replace = $_SERVER['SERVER_NAME'];
	
		if (count($db) != 0) {
			extract($db_params);
			$db = mysqli_connect($host,$username,$password,$dbname);
		} else {
			global $wpdb;
		}
		
	
		if (is_null($search) || is_null($replace))
			return false;
	
		$statements = array(
			"UPDATE wp_options SET option_value = replace(option_value, '$search', '$replace') WHERE option_name = 'home' OR option_name = 'siteurl';",
			"UPDATE wp_posts SET guid = replace(guid, '$search','$replace');",
			"UPDATE wp_posts SET post_content = replace(post_content, '$search', '$replace');",
		); 
	
		foreach($statements as $s) {
	
			if (!is_null($wpdb)) {
				$result = $wpdb->query($s);
				if(!$result)
					return false;
			} else {
				mysqli_query($db,$s);
			}
	
		}
	
		return "success";
		
	}


}


?>
