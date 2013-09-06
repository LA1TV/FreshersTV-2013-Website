<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Recaptcha {

	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	function get_noscript_html() {
		$publickey = "6Lfy8uYSAAAAAMbqcoZnriQEp2fpEyEZQrR16W1O";
		return '<noscript><iframe src="http://www.google.com/recaptcha/api/noscript?k='.$publickey.'" height="300" width="500" frameborder="0"></iframe><br><textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea><input type="hidden" name="recaptcha_response_field" value="manual_challenge"></noscript>';
	}
	
	function is_response_valid() {
		require_once(dirname(__FILE__) . '/../includes/recaptchalib.php');
		$privatekey = "6Lfy8uYSAAAAAE4i8xoG5yeTDqJIVEUixJU5DqbH";
		$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $this->CI->input->post("recaptcha_challenge_field"), $this->CI->input->post("recaptcha_response_field"));
		return $resp->is_valid;
	}
	
}