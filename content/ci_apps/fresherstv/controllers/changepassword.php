<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Changepassword extends CI_Controller {

	public function index()
	{
		if (!$this->authentication->get_logged_in()) {
			// not logged in
			$login_next_uri = "changepassword";
			$this->session->set_userdata('my_next_uri', $login_next_uri);
			redirect(base_url()."login?next_uri=".$login_next_uri);
		}
		else {
			$form = array(
				"current_password"		=>	"",
				"password"				=>	"",
				"password_confirmation"	=>	""
			);
			$this->load->library("recaptcha");
			output_page("changepassword", array(), array("changepassword"), $this->load->view('page/change_password', array("form"=>$form, "form_errors"=>array(), "recaptcha_lib"=>$this->recaptcha), TRUE));
		}
	}
	
	public function submit()
	{
		if (!$this->authentication->get_logged_in() || $this->input->post("form_submitted") !== "1") {
			redirect(base_url()."changepassword");
		}
		
		
		$form = array(
			"current_password"		=>	$this->_get_post_str("current_password"),
			"password"				=>	$this->_get_post_str("password"),
			"password_confirmation"	=>	$this->_get_post_str("password_confirmation")
		);
		
	
		// do validation
		$form_errors = array();
		
		// check that required fields
		$fields_to_check = array("current_password", "password", "password_confirmation");
		foreach($fields_to_check as $a) {
			if (strlen($form[$a]) === 0) {
				$form_errors[$a] = "This field was required.";
			}
		}
		
		// check that fields not over character limit
		$fields_to_check = array("current_password", "password", "password_confirmation");
		foreach($fields_to_check as $a) {
			if (strlen($form[$a]) > 1000) {
				$form_errors[$a] = "You are not allowed more than 1000 characters.";
			}
		}
		
		if (!isset($form_errors['password'])) {
			$this->load->model("applications");
			if (!$this->applications->does_pass_meet_requirments($form['password'])) {
				$form_errors["password"] = "The password you entered did not meet the password requirments.";
			}
		}
		
		if (!isset($form_errors['password']) && !isset($form_errors['password_confirmation'])) {
			if ($form['password'] !== $form['password_confirmation']) {
				$form_errors["password_confirmation"] = "The passwords you entered didn't match.";
			}
		}
		
		// check captcha
		$this->load->library("recaptcha");
		if (!$this->recaptcha->is_response_valid()) {
			$form_errors["captcha"] = "This was invalid.";
		}
		
		// don't let the user know if the current password was incorrect if the captcha was incorrect to prevent bruteforcing if already logged in
		if (!isset($form_errors['current_password']) && !isset($form_errors["captcha"])) {
			$this->load->model("applications");
			if ($this->applications->get_hashed_password($this->authentication->get_id()) !== $this->applications->get_hash($form['current_password'])) {
				$form_errors["current_password"] = "This was incorrect.";
			}
		}
		
		if (count($form_errors) === 0) {
			// everything valid.
			$this->load->model("applications");
			$this->applications->set_password($this->authentication->get_id(), $form['password']);
			// update password in session so that don't get logged out
			$this->authentication->update_password($this->applications->get_hash($form['password']));
			// send notification email
			$this->load->library("send_email");
			$this->send_email->send_password_changed_email($this->applications->get_email($this->authentication->get_id()));
			output_page("password_changed", array(), array(), $this->load->view('page/password_changed', array(), TRUE), TRUE);
		}
		else {
			// there are problems. show the form again.
			$this->load->library("recaptcha");
			output_page("changepassword", array(), array("changepassword"), $this->load->view('page/change_password', array("form"=>$form, "form_errors"=>$form_errors, "recaptcha_lib"=>$this->recaptcha), TRUE), TRUE);
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