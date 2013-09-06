<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		if ($this->authentication->get_logged_in()) {
			// already logged in
			output_page("logged_in", array(), array(), $this->load->view('page/logged_in', array("already_logged_in"=>TRUE, "next_uri"=>FALSE), TRUE));
		}
		else {
	
			// for security reasons (eg xss) only use the next_uri value if it has been generated from the server.
			if (in_array($this->input->get("next_uri"), array($this->session->userdata('my_next_uri'), $this->session->userdata('my_next_uri_at_previous_attempt')), TRUE)) {
				$next_uri = $this->input->get("next_uri");
			}
			else {
				$next_uri = FALSE;
			}
			$this->session->set_userdata('my_next_uri_at_previous_attempt', $next_uri);
			
			$data = array(
				"login_required_msg"	=> $next_uri !== FALSE ? "You are required to log in in order to access that page." : "",
				"login_error_msg"		=> "",
				"form"					=> array("email" => "", "next_uri"=>$next_uri),
				"captcha_required"		=> $this->authentication->get_show_captcha(),
			);
			
			$this->load->library("recaptcha");
			$data['recaptcha_lib'] = $this->recaptcha;
			output_page("login", array(), array("login"), $this->load->view('page/login', $data, TRUE));
		}
	}
	
	public function submit()
	{
		if ($this->authentication->get_logged_in() || $this->input->post("form_submitted") !== "1") {
			redirect(base_url()."login");
		}
		
		$entered_email = $this->_get_post_str("email");
		$entered_pass = $this->_get_post_str("password");
		
		// for security reasons (eg xss) only use the next_uri value if it has been generated from the server.
		if (in_array($this->input->post("next_uri"), array($this->session->userdata('my_next_uri'), $this->session->userdata('my_next_uri_at_previous_attempt')), TRUE)) {
			$next_uri = $this->input->post("next_uri");
		}
		else {
			$next_uri = FALSE;
		}
		$this->session->set_userdata('my_next_uri_at_previous_attempt', $next_uri);
		
		$data = array(
			"login_required_msg"	=> "",
			"login_error_msg"		=> "Something was incorrect. Please try again. Are you sure your account has been activated yet?",
			"form"					=> array("email"=>$entered_email, "next_uri"=>$next_uri),
			"captcha_required"		=> $this->authentication->get_show_captcha()
		);
		
		$success = FALSE;
		
		$this->load->library("recaptcha");
		
		if((!$this->authentication->get_show_captcha() || $this->recaptcha->is_response_valid()) && strlen($entered_email) !== 0 && strlen($entered_pass) !== 0) {
			$this->authentication->authenticate($entered_email, $entered_pass);
			$success = $this->authentication->get_logged_in();
		}
		
		if (!$success) {
			// failed login
			$this->load->library("recaptcha");
			$data['recaptcha_lib'] = $this->recaptcha;
			output_page("login", array(), array("login"), $this->load->view('page/login', $data, TRUE), TRUE);
		}
		else {
			// login successful
			output_page("logged_in", array(), array(), $this->load->view('page/logged_in', array("already_logged_in"=>FALSE, "next_uri"=>$next_uri), TRUE), TRUE);
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