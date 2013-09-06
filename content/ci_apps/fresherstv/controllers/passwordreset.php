<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Passwordreset extends CI_Controller {

	public function index()
	{
		if ($this->authentication->get_logged_in()) {
			// already logged in
			output_page("logged_in", array(), array(), $this->load->view('page/logged_in', array("already_logged_in"=>TRUE, "next_uri"=>FALSE), TRUE));
		}
		else {
	
			
			$data = array(
				"error_msg"		=> "",
				"form"			=> array("email" => "")
			);
			
			$this->load->library("recaptcha");
			$data['recaptcha_lib'] = $this->recaptcha;
			output_page("passwordreset", array(), array("passwordreset"), $this->load->view('page/password_reset', $data, TRUE));
		}
	}
	
	public function submit()
	{
		if ($this->authentication->get_logged_in() || $this->input->post("form_submitted") !== "1") {
			redirect(base_url()."passwordreset");
		}
		
		$entered_email = $this->_get_post_str("email");
		
		$data = array(
			"error_msg"		=> "Something was incorrect. Please try again. Are you sure you have created an account?",
			"form"			=> array("email"=>$entered_email),
		);
		
		$success = FALSE;
		
		$this->load->library("recaptcha");
		$this->load->model("applications");
		
		if((!$this->authentication->get_show_captcha() || $this->recaptcha->is_response_valid()) && strlen($entered_email) !== 0 && $this->applications->get_id_from_email($entered_email) !== FALSE) {
			// success
			$application_id = $this->applications->get_id_from_email($entered_email);
			// create a password reset code
			$code = $this->applications->create_password_reset_code($application_id);
			
			
			// send the password reset email
			$this->load->library("send_email");
			$this->send_email->send_pass_reset_email(array("to_address"=>$entered_email, "email_data"=>array("link"=> base_url()."passwordreset/change?code=".$code)));
			// show the reset link sent view
			output_page("passwordresetsent", array(), array(), $this->load->view('page/password_reset_sent', array("email"=>$data['email'], "from_email"=>$this->config->item('automated_email')), TRUE), TRUE);
		}
		else {
			// failed
			$this->load->library("recaptcha");
			$data['recaptcha_lib'] = $this->recaptcha;
			output_page("passwordreset", array(), array("passwordreset"), $this->load->view('page/password_reset', $data, TRUE), TRUE);
		}
	}
	
	public function change()
	{
		// note that the user may actually be logged in as a different account while resetting the password for another. this is fine.
		// if they are logged into the same account that they then reset the password for, they will then automatically get logged out as the system would detect the password changing
	
		$tmp = $this->_get_reset_state();
		$state = $tmp['state'];
		$application_id = $tmp['application_id'];
		
		// at this point $state will be 0 if person allowed to change password, 1 if the link they used has now expired so no longer allowed to change password, and 2 if the link was/now is invalid
		// $application_id will contain the id of the application the password should be changed for
		
		$data = array(
			"state"	=>	$state
		);
		
		if ($state === 0) {
			$data['form_errors'] = array();
		}
		output_page("passwordresetchange", array(), array(), $this->load->view('page/password_reset_change', $data, TRUE), TRUE);
	
	
	}
	
	public function changesubmit() {
		
		if ($this->input->post("form_submitted") !== "1") {
			redirect(base_url()."passwordreset/change");
		}
		
		$tmp = $this->_get_reset_state();
		$state = $tmp['state'];
		$application_id = $tmp['application_id'];
		
		if ($state === 1 || $state === 2) {
			// link no longer valid
			$data = array(
				"state"	=>	$state
			);
			output_page("passwordresetchange", array(), array(), $this->load->view('page/password_reset_change', $data, TRUE), TRUE);
		}
		else {
			// user is still allowed to change password, do form validation
			$entered_password = $this->_get_post_str("password");
			$entered_password_confirmation = $this->_get_post_str("password_confirmation");
			
			$data = array(
				"state"	=>	$state,
				"form_errors"	=> array()
			);
			
			if (strlen($entered_password) === 0) {
				$data['form_errors']['password'] = "This field was required.";
			}
			
			if (strlen($entered_password_confirmation) === 0) {
				$data['form_errors']['password_confirmation'] = "This field was required.";
			}
			
			if (!isset($data['form_errors']['password']) && strlen($entered_password) > 1000) {
				$data['form_errors']['password'] = "You are not allowed more than 1000 characters.";
			}
			
			if (!isset($data['form_errors']['password_confirmation']) && strlen($entered_password_confirmation) > 1000) {
				$data['form_errors']['password_confirmation'] = "You are not allowed more than 1000 characters.";
			}
			
			if (!isset($data['form_errors']['password'])) {
				$this->load->model("applications");
				if (!$this->applications->does_pass_meet_requirments($entered_password)) {
					$data['form_errors']["password"] = "The password you entered did not meet the password requirments.";
				}
			}
			
			if (!isset($data['form_errors']['password']) && !isset($data['form_errors']['password_confirmation'])) {
				if ($entered_password !== $entered_password_confirmation) {
					$$data['form_errors']["password_confirmation"] = "The passwords you entered didn't match.";
				}
			}
			
			if (count($data['form_errors']) !== 0) {
				// invalid form response
				output_page("passwordresetchange", array(), array(), $this->load->view('page/passwordresetchange', $data, TRUE), TRUE);
			}
			else {
				// form valid. change password 
				$this->session->unset_userdata("my_resetting_password_id");
				$this->session->unset_userdata("my_resetting_password_time");
				// set the new password
				$this->load->model("applications");
				$this->applications->set_password($application_id, $entered_password);
				output_page("passwordchanged", array(), array(), $this->load->view('page/password_changed', array(), TRUE), TRUE);
			}
		}
	
	}
	
	private function _get_reset_state() {
		$this->load->model("applications");
		$code = $this->input->get("code");
		if ($code === FALSE) {
			if ($this->session->userdata("my_resetting_password_id") !== FALSE) {
				// they have already clicked a link and it was valid.
				if ($this->session->set_userdata('my_resetting_password_time') < time() - (60*5)) {
					// their time to change the pasword has expired.
					$state = 1;
					$this->session->unset_userdata("my_resetting_password_id");
					$this->session->unset_userdata("my_resetting_password_time");
					$application_id = FALSE;
				}
				else {
					// everything is still valid
					$state = 0;
					$application_id = $this->session->userdata("my_resetting_password_id");
				}
			}
			else {
				// code invalid
				$state = 2;
				$application_id = FALSE;
			}
		}
		else {
			$this->session->unset_userdata("my_resetting_password_id");
			$this->session->unset_userdata("my_resetting_password_time");
			$state = $this->applications->verify_password_reset_code($code);
			if ($state === 0 || $state === 1) {
				$application_id = (int) $this->applications->get_id_from_password_reset_code($code);
				// now clear the code from the db
				$this->applications->remove_password_reset_code($application_id);
				if ($state === 0) {
					$this->session->set_userdata('my_resetting_password_id', $application_id); // a flag to tell the system that the user is resetting a password for the application with this id.
					$this->session->set_userdata('my_resetting_password_time', time()); // the last time the user accessed the link to change the password.
				}
			}
			else {
				$application_id = FALSE;
			}
		}
		return array("state"=>$state, "application_id"=>$application_id);
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