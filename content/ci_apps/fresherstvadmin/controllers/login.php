<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		if ($this->admin_authentication->get_logged_in()) {
			// already logged in
			output_page("logged_in", array(), array(), $this->load->view('page/logged_in', array("already_logged_in"=>TRUE), TRUE));
		}
		else {
	
			$data = array(
				"login_error_msg"		=> "",
				"form"					=> array()
			);
			
			$this->load->library("recaptcha");
			$data['recaptcha_lib'] = $this->recaptcha;
			output_page("login", array(), array("login"), $this->load->view('page/login', $data, TRUE));
		}
	}
	
	public function submit()
	{
		if ($this->admin_authentication->get_logged_in() || $this->input->post("form_submitted") !== "1") {
			redirect(base_url()."login");
		}
		
		$entered_pass = $this->_get_post_str("password");

		
		$data = array(
			"login_error_msg"		=> "Something was incorrect. Please try again.",
			"form"					=> array()
		);
		
		$success = FALSE;
		
		$this->load->library("recaptcha");
		
		if($this->recaptcha->is_response_valid() && strlen($entered_pass) !== 0) {
			$this->admin_authentication->authenticate($entered_pass);
			$success = $this->admin_authentication->get_logged_in();
		}
		
		if (!$success) {
			// failed login
			$this->load->library("recaptcha");
			$data['recaptcha_lib'] = $this->recaptcha;
			output_page("login", array(), array("login"), $this->load->view('page/login', $data, TRUE), TRUE);
		}
		else {
			// login successful
			output_page("logged_in", array(), array(), $this->load->view('page/logged_in', array("already_logged_in"=>FALSE), TRUE));
		}
	}
	
	private function _get_post_str($field)
	{
		if ($this->input->post($field) === FALSE) {
			return "";
		}
		else {
			return trim($this->input->post($field));
		}
	}
}