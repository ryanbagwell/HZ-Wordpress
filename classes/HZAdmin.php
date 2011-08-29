<?php


class HZAdmin {

	/**
   *
   * Create Username
   *
   * Creates a username from the given first name and last name. Format is first initial and last name. If username exists, adds an integer to the end of the username.
   *
   * @author Ryan Bagwell <ryan@ryanbagwell.com>
   * @param string $first the person's first name
   * @param string $last the person's last name
   * @return the user name
   *
  */
	function create_username($first = null,$last = null) {
	
		$name = strtolower(substr($first,0,1) . $last);
	
		//if it's a valid combintion of their first initial and last name, return that
		if (validate_username($name))
			return $name;
		
		//now loop through and add a number at the end until we find a valid name
		$i = 0;
		while($i < 10000) {
			if (validate_username($name + $i))
				return $name + $i;
			$i++;	
		}
	
	
	}


	/**
   *
   * Get Meta Box Fields
   *
   * Creates
   *
   * @author Ryan Bagwell <ryan@ryanbagwell.com>
   * @param obj $post the post on which to show the meta box
   * @param array $field_labels an array of field display names
   * @param string $prefix a prefix to give each field name. Defaults to hz_
   * @return the meta box markup
   *
  */
	function get_metabox_fields($post,$field_labels = array(),$prefix = 'hz_') {

		$html = "";
	
		foreach($field_labels as $field) {

			$field_name = str_replace(' ','_',strtolower($prefix . $field));
			$field_id = str_replace('_','-',$field_name);

			$field_value = get_post_meta($post->ID,$field_name,true);
	
		
			$html .= "<div class='hz-admin-field-wrapper'>	
				<label>$field</label>
				<input name='$field_name' id='$field_id' value='$field_value' />
			</div>";	

		}
		
		return $html;

	}
	
}




?>