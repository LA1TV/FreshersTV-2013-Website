<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		if ($this->authentication->get_logged_in()) {
			// already logged in
			$html = $this->load->view('page/logged_in', array("already_logged_in"=>TRUE, "next_uri"=>FALSE), TRUE);
			$this->load->view('page', array("current_page"=>"logged_in", "css"=>array(), "js"=>array(), "no_index"=>TRUE, "logged_in"=>$this->authentication->get_logged_in(), "html"=>$html), FALSE);
		}
		else {
	
			// for security reasons (eg xss) only use the next_uri value if it has been generated from the server.
			if ($this->input->get("next_uri") === $this->session->userdata('my_next_uri')) {
				$next_uri = $this->session->userdata('my_next_uri');
			}
			else {
				$next_uri = FALSE;
			}
			
			$data = array(
				"login_required_msg"	=> $next_uri !== FALSE ? "You are required to log in in order to access this page." : "",
				"login_error_msg"		=> "",
				"form"					=> array("email" => "", "next_uri"=>$next_uri),
				"captcha_required"		=> $this->authentication->get_show_captcha(),
			);
			
			$this->load->library("recaptcha");
			$data['recaptcha_lib'] = $this->recaptcha;
			$html = $this->load->view('page/login', $data, TRUE);
			$this->load->view('page', array("current_page"=>"login", "css"=>array(), "js"=>array(), "logged_in"=>$this->authentication->get_logged_in(), "html"=>$html), FALSE);
		}
	}
	
	public function submit()
	{
		if ($this->input->post("form_submitted") !== "1") {
			redirect(base_url()."login");
		}
		
		$entered_email = $this->_get_post_str("email");
		$entered_pass = $this->_get_post_str("password");
		
		// for security reasons (eg xss) only use the next_uri value if it has been generated from the server.
		if ($this->input->post("next_uri") === $this->session->userdata('my_next_uri')) {
			$next_uri = $this->session->userdata('my_next_uri');
		}
		else {
			$next_uri = "";
		}
		
		$data = array(
			"login_required_msg"	=> "",
			"login_error_msg"		=> "Something was incorrect. Please try again.",
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
			
			$html = $this->load->view('page/login', $data, TRUE);
			$this->load->view('page', array("current_page"=>"login", "css"=>array(), "js"=>array(), "no_index"=>TRUE, "logged_in"=>$this->authentication->get_logged_in(), "html"=>$html), FALSE);
		}
		else {
			// login successful
			$html = $this->load->view('page/logged_in', array("already_logged_in"=>FALSE, "next_uri"=>$next_uri === "" ? FALSE : $next_uri), TRUE);
			$this->load->view('page', array("current_page"=>"logged_in", "css"=>array(), "js"=>array(), "no_index"=>TRUE, "logged_in"=>$this->authentication->get_logged_in(), "html"=>$html), FALSE);
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