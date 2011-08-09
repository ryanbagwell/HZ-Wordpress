<?php 

class HZMeta {

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
	}
		
	
}