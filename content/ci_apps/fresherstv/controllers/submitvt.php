<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Submitvt extends CI_Controller {

	public function index()
	{
		if (!$this->authentication->get_logged_in()) {
			// not logged in
			output_page("vt_login_required", array(), array(), $this->load->view('page/vt_login_required', array(), TRUE), TRUE);
		}
		else {
			$this->load->model("applications");
			$application_id = $this->authentication->get_id();
			if ($this->applications->get_vt_received($application_id)) {
				// already have VT
				output_page("vt_received", array(), array(), $this->load->view('page/vt_received', array("already_received"=>TRUE), TRUE), TRUE);
			}
			else {
				$form = array(
					"vt"	=>	""
				);
				output_page("submitvt", array(), array(), $this->load->view('page/submitvt', array("form"=>$form, "form_errors"=>array()), TRUE));
			}
		}
	}
	
	public function submit()
	{
		// redirect back if not logged in or form not submitted
		if (!$this->authentication->get_logged_in() || $this->input->post("form_submitted") !== "1") {
			redirect(base_url()."submitvt");
		}
		
		$this->load->model("applications");
		$application_id = $this->authentication->get_id();
		if ($this->applications->get_vt_received($application_id)) {
			// already have VT
			output_page("vt_received", array(), array(), $this->load->view('page/vt_received', array("already_received"=>TRUE), TRUE), TRUE);
		}
		else {
			
			$form = array(
				"vt"	=>	$this->_get_post_str("vt")
			);
			
		
			// do validation
			$form_errors = array();
			
			// check that required fields
			$fields_to_check = array("vt");
			foreach($fields_to_check as $a) {
				if (strlen($form[$a]) === 0) {
					$form_errors[$a] = "This field is required.";
				}
			}
			
			// check that fields not over character limit
			$fields_to_check = array("vt");
			foreach($fields_to_check as $a) {
				if (strlen($form[$a]) > 1000) {
					$form_errors[$a] = "You are not allowed more than 1000 characters.";
				}
			}
			
			
			if (!isset($form_errors['vt'])) {
				if (!filter_var($form['vt'], FILTER_VALIDATE_URL)) {
					$form_errors["vt"] = "This is not a valid url.";
				}
			}
			
			if (count($form_errors) === 0) {
				// everything valid. write to database and send verification e-mail
				$this->load->model("applications");
				$application_id = $this->authentication->get_id();
				$this->applications->update_vt($applicaton_id, $form['vt']);
				
				// send the notification email
				$this->load->library("send_email");
				$this->send_email->send_notification_email(array("to_address"=>$this->applications->get_email($application_id), "subject"=>"VT Received", "email_data"=>array("msg"=>"This is confirmation that we have received your VT.")));
				
				// show the vt received view
				output_page("vt_received", array(), array(), $this->load->view('page/vt_received', array("already_received"=>FALSE), TRUE), TRUE);
			}
			else {
				// there are problems. show the form again.
				output_page("submitvt", array(), array(), $this->load->view('page/submitvt', array("form"=>$form, "form_errors"=>$form_errors), TRUE), TRUE);
			}
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