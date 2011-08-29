<?php 
/*
This class has been deprecated, and included in the HZAdmin class.
*/

class HZMeta {

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