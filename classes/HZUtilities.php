<?php

class HZUtilities {

  /**
   *
   * Variable Dumper
   *
   * Prints a variable in an easy to read format
   *
   * @author Ryan Bagwell <ryan@ryanbagwell.com>
   * @param string $var variable to dump
   * @return none
   *
  */
  public function dumpit($var = null) {

    if(is_null($var))
    	return false;

    echo "<pre>";
    var_dump($var);
    echo "</pre>";
  }
	
  /**
   *
   * Flash Message Getter
   *
   * Gets a flash message stored in the session
   *
   * @author Ryan Bagwell <ryan@ryanbagwell.com>
   * @return string $msg the message
   *
  */
	function get_flash_message() {
		if(!is_set($_SESSION))
			session_start();
		
		$msg = $_SESSION['flash_message'];

		if ($msg == '') {
			return false; 
		} else {
			unset($_SESSION['flash_message']);
			return $msg;
		}

	}
	
  /**
   *
   * Flash Message Setter
   *
   * Sets a flash message to be stored in the session
   *
   * @author Ryan Bagwell <ryan@ryanbagwell.com>
   * @param string $msg the message
   * @return mixed true on success, mixed on error
	 *
  */
	function set_flash_message($msg = null) {
		if (headers_sent())
			return "Headers already sent. Can't modify session";
			
		if (!is_set($_SESSION))
			session_start();		
		
		if (!is_null($msg)) {
			$_SESSION['flash_message'] = $msg;
			return true;
		} else {
			return false;
		}
	
	}	
	
	
  /**
   *
   * IE Check
   *
   * Checks if the user agent is Internet Explorer
   *
   * @author Ryan Bagwell <ryan@ryanbagwell.com>
   * @return string the browser version if IE, or false if not IE
	 *
  */	
	function is_ie() {
		$agent = $_SERVER['HTTP_USER_AGENT'];
		
		if (stripos($agent,"MSIE 6"))
			return "IE6";
			
		if (stripos($agent,"MSIE 7"))
			return "IE7";
			
		if (stripos($agent,"MSIE 8"))
			return "IE8";
			
		return false;
	
	}
	
	
}


?>