<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Recaptcha {

	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	function get_html() {
		require_once(dirname(__FILE__) . '/../includes/recaptchalib.php');
		$publickey = "6Lfy8uYSAAAAAMbqcoZnriQEp2fpEyEZQrR16W1O";
		return recaptcha_get_html($publickey);
	}
	
	function is_response_valid() {
		require_once(dirname(__FILE__) . '/../includes/recaptchalib.php');
		$privatekey = "6Lfy8uYSAAAAAE4i8xoG5yeTDqJIVEUixJU5DqbH";
		$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $this->CI->input->post("recaptcha_challenge_field"), $this->CI->input->post("recaptcha_response_field"));
		return $resp->is_valid;
	}
	
}