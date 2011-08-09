<?php 
class HZInstall {

	function hz_install() {
		
		ini_set('memory_limit','100000000000MB');
	
		$m = get_class_methods($this);
			
		foreach($m as $method) {
			if ($method == 'hz_install' || $method == 'HZInstall')
				continue;
			
			$this->$method();
		}

	}

	function make_css_dir() {
		if (!is_dir(TEMPLATEPATH."/css"))
			mkdir(TEMPLATEPATH."/css",0775);
	}

	function make_js_dir() {
		if (!is_dir(TEMPLATEPATH."/js"))
			mkdir(TEMPLATEPATH."/js",0775);		
	}
	
	function save_jquery() {
		$code = file_get_contents('https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
		$handle = fopen(TEMPLATEPATH."/js/jquery-latest.min.js","w");
		fwrite($handle,$code);
		fclose($handle);
	}
	
	function save_swfobject() {
		$code = file_get_contents('https://ajax.googleapis.com/ajax/libs/swfobject/2/swfobject.js');
		$handle = fopen(TEMPLATEPATH."/js/swfobject-latest.js","w");
		fwrite($handle,$code);
		fclose($handle);
	}	

	function save_jquery_ui() {
		$code = file_get_contents('https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js');
		$handle = fopen(TEMPLATEPATH."/js/jquery-ui-latest.min.js","w");
		fwrite($handle,$code);
		fclose($handle);
	}
	
	function save_jquery_ui_css() {
		$code = file_get_contents('https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css');
		$handle = fopen(TEMPLATEPATH."/css/jquery-ui-lightness.css","w");
		fwrite($handle,$code);
		fclose($handle);
	}


	function create_global_js() {
		
		if (file_exists(TEMPLATEPATH."/js/global-scripts.js"))
			return;
		
		$handle = fopen(TEMPLATEPATH."/js/global-scripts.js","w");
		fwrite($handle,'');
		fclose($handle);
		
	}

	function create_main_stylesheet() {
		
		if (file_exists(TEMPLATEPATH."/css/style.css")) {
			return;
			
		} else if (file_exists(TEMPLATEPATH."/style.css")) {
			$handle = fopen(TEMPLATEPATH."/css/style.css","w");
			fwrite($handle,file_get_contents(TEMPLATEPATH."/style.css"));
			fclose($handle);
		} else {
			$handle = fopen(TEMPLATEPATH."/css/style.css","w");
			fwrite($handle,'');
			fclose($handle);			
		}
	
	}


	function create_admin_css() {
		
		if (file_exists(TEMPLATEPATH."/css/hz-admin.css"))
			return;
		
		$handle = fopen(TEMPLATEPATH."/css/hz-admin.css","w");
		fwrite($handle,'');
		fclose($handle);			
		
	}
	
	function create_ie_css() {
		
		if (!file_exists(TEMPLATEPATH."/css/ie6.css")) {
			$handle = fopen(TEMPLATEPATH."/css/ie6.css","w");
			fwrite($handle,'');
			fclose($handle);			
		}
		

		if (!file_exists(TEMPLATEPATH."/css/ie7.css")) {		
			$handle = fopen(TEMPLATEPATH."/css/ie7.css","w");
			fwrite($handle,'');
			fclose($handle);
		}
		
		if (!file_exists(TEMPLATEPATH."/css/ie8.css")) {		
			$handle = fopen(TEMPLATEPATH."/css/ie8.css","w");
			fwrite($handle,'');
			fclose($handle);
		}
		
	}

}


?>