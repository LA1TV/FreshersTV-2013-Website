<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apply extends CI_Controller {

	public function index()
	{
		$form = array(
			"name"					=>	"",
			"contact"				=>	"",
			"email"					=>	"",
			"email_confirmation"	=>	"",
			"postcode"				=>	"",
			"phone"					=>	"",
			"main_logo"				=>	"",
			"secondary_logo"		=>	"",
			"email_confirmation"	=>	"",
			"participation_type"	=>	FALSE,
			"participation_time"		=>	"",
			"resolution"			=>	"",
			"bitrate"				=>	"",
			"stream_url"			=>	"",
			"stream_extra"			=>	"",
			"overlay_details"		=>	"",
			"cinebeat"				=>	"",
			"password"				=>	"",
			"password_confirmation"	=>	""
		);
		
		$this->load->library("recaptcha");
		output_page("apply", array(), array("apply"), $this->load->view('page/apply', array("form"=>$form, "form_errors"=>array(), "recaptcha_lib"=>$this->recaptcha), TRUE));
	}
	
	public function submit()
	{
		if ($this->input->post("form_submitted") !== "1") {
			redirect(base_url()."apply");
		}
		
		
		$form = array(
			"name"					=>	$this->_get_post_str("name"),
			"contact"				=>	$this->_get_post_str("contact"),
			"email"					=>	$this->_get_post_str("email"),
			"email_confirmation"	=>	$this->_get_post_str("email_confirmation"),
			"postcode"				=>	$this->_get_post_str("postcode"),
			"phone"					=>	$this->_get_post_str("phone"),
			"main_logo"				=>	$this->_get_post_str("main_logo"),
			"secondary_logo"		=>	$this->_get_post_str("secondary_logo"),
			"participation_type"	=>	$this->_get_post_str("participation_type"),
			"participation_time"	=>	$this->_get_post_str("participation_time"),
			"resolution"			=>	$this->_get_post_str("resolution"),
			"bitrate"				=>	$this->_get_post_str("bitrate"),
			"stream_url"			=>	$this->_get_post_str("stream_url"),
			"stream_extra"			=>	$this->_get_post_str("stream_extra"),
			"overlay_details"		=>	$this->_get_post_str("overlay_details"),
			"cinebeat"				=>	$this->_get_post_str("cinebeat"),
			"password"				=>	$this->_get_post_str("password"),
			"password_confirmation"	=>	$this->_get_post_str("password_confirmation")
		);
		
	
		// do validation
		$form_errors = array();
		$participation_type_ids = array("live", "vt");
		$participation_time_ids = array("1800", "1815", "1830", "1845", "1900", "1915", "1930", "1945", "2000", "2015", "2030", "2045", "2100", "2115", "2130", "2145");
		
		// check that required fields
		$fields_to_check = array("name", "contact", "email", "email_confirmation", "postcode", "phone", "main_logo", "password", "password_confirmation");
		if ($form['participation_type'] === "live") {
			$fields_to_check = array_merge($fields_to_check, array("resolution", "bitrate"));
		}
		foreach($fields_to_check as $a) {
			if (strlen($form[$a]) === 0) {
				if (!in_array($a, array("password", "password_confirmation"))) {
					$form_errors[$a] = "This field is required.";
				}
				else {
					$form_errors[$a] = "This field was required.";
				}
			}
		}
		
		// check that fields not over character limit
		$fields_to_check = array("name", "contact", "email", "email_confirmation", "postcode", "phone", "main_logo", "cinebeat", "secondary_logo", "overlay_details", "password", "password_confirmation");
		if ($form['participation_type'] === "live") {
			$fields_to_check = array_merge($fields_to_check, array("resolution", "bitrate", "stream_url", "stream_extra"));
		}
		foreach($fields_to_check as $a) {
			if (strlen($form[$a]) > 1000) {
				$form_errors[$a] = "You are not allowed more than 1000 characters.";
			}
		}
		
		if (!in_array($form['participation_type'], $participation_type_ids)) {
			$form_errors["participation_type"] = "This field is required.";
		}
		if ($form['participation_type'] === "live") {
			if (!in_array($form['participation_time'], $participation_time_ids)) {
				$form_errors["participation_time"] = "This field is required.";
			}
		}
		
		// perform other checks
		if (!isset($form_errors['email'])) {
			if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
				$form_errors["email"] = "This is not a valid e-mail address.";
			}
		}
		if (!isset($form_errors['email']) && !isset($form_errors['email_confirmation'])) {
			if ($form['email'] !== $form['email_confirmation']) {
				$form_errors["email_confirmation"] = "This does not match the e-mail address you entered above.";
			}
		}
		
		if (!isset($form_errors['main_logo'])) {
			if (!filter_var($form['main_logo'], FILTER_VALIDATE_URL)) {
				$form_errors["main_logo"] = "This is not a valid url.";
			}
		}
		if (!isset($form_errors['secondary_logo']) && strlen($form['secondary_logo']) > 0) {
			if (!filter_var($form['main_logo'], FILTER_VALIDATE_URL)) {
				$form_errors["main_logo"] = "This is not a valid url.";
			}
		}
		
		if (!isset($form_errors['stream_url']) && $form['participation_type'] === "live" && strlen($form['stream_url']) > 0) {
			if (!filter_var($form['stream_url'], FILTER_VALIDATE_URL)) {
				$form_errors["stream_url"] = "This is not a valid url.";
			}
		}
		
		if (!isset($form_errors['cinebeat']) && strlen($form['cinebeat']) > 0) {
			if (!filter_var($form['cinebeat'], FILTER_VALIDATE_URL)) {
				$form_errors["cinebeat"] = "This is not a valid url.";
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
		
		if (count($form_errors) === 0) {
			// everything valid. write to database and send verification e-mail
			$this->load->model("applications");
			$email_verification_code = $this->applications->generate_verification_code();
			$data = array(
				"name"					=>	$form['name'],
				"contact"				=>	$form['contact'],
				"email"					=>	$form['email'],
				"postcode"				=>	$form['postcode'],
				"phone"					=>	$form['phone'],
				"main_logo"				=>	$form['main_logo'],
				"secondary_logo"		=>	strlen($form['secondary_logo']) !== 0 ? $form['secondary_logo'] : NULL,
				"participation_type"	=>	$form['participation_type'] === "live" ? 0 : 1,
				"participation_time"	=>	$form['participation_type'] === "live" ? (int) $this->_get_post_str("participation_time") : NULL,
				"resolution"			=>	$form['participation_type'] === "live" ? $form['resolution'] : NULL,
				"bitrate"				=>	$form['participation_type'] === "live" ? $form['bitrate'] : NULL,
				"stream_url"			=>	$form['participation_type'] === "live" ? strlen($form['stream_url']) !== 0 ? $form['stream_url'] : NULL : NULL,
				"stream_extra"			=>	$form['participation_type'] === "live" ? strlen($form['stream_extra']) !== 0 ? $form['stream_extra'] : NULL : NULL,
				"overlay_details"		=>	strlen($form['overlay_details']) !== 0 ? $form['overlay_details'] : NULL,
				"cinebeat"				=>	strlen($form['cinebeat']) !== 0 ? $form['cinebeat'] : NULL,
				"vt"					=>	NULL,
				"password"				=>	$this->applications->get_hash($form['password']),
				"email_verification_hash"	=>	$this->applications->get_hash($email_verification_code),
				"email_verified"		=>	FALSE,
				"application_accepted"	=>	FALSE,
				"time_created"			=>	time()
			);
			
			// at the moment even if an application has been sent and email verified the form will still be submitted successfully. When they try and validate the email it will fail
			// might as well leave this so that the info still makes it into the database instead of just rejecting it
			
			// write the application to the db
			$this->applications->add_application($data);
			
			// send the verification email
			$this->load->library("send_email");
			$this->send_email->send_activate_email(array("to_address"=>$data['email'], "email_data"=>array("link"=> base_url()."apply/verifyemail?code=".$email_verification_code)));
			
			// show the application received view
			output_page("application_received", array(), array(), $this->load->view('page/application_received', array("email"=>$data['email'], "from_email"=>$this->config->item('automated_email')), TRUE), TRUE);
		}
		else {
			// there are problems. show the form again.
			output_page("apply", array(), array("apply"), $this->load->view('page/apply', array("form"=>$form, "form_errors"=>$form_errors, "recaptcha_lib"=>$this->recaptcha), TRUE), TRUE);
		}
	}
	
	function verifyemail() {
	
		$this->load->model("applications");
		$code = $this->input->get("code");
		if ($code === FALSE) {
			$state = 2;
		}
		else {
			$state = $this->applications->verify_email($code);
		}
		
		if ($state === 0) {
			$application_id = $this->applications->get_id_from_verification_code($code);
			$this->load->library("send_email");
			$email = $this->applications->get_email($application_id);
			$this->send_email->send_email_verified_email($email);
			if ($this->config->item('admin_notification_email_address') !== FALSE) {
				foreach(explode(";", $this->config->item('admin_notification_email_address')) as $email) {
					$email = trim($email);
					if ($email == "") {
						continue;
					}
					$this->send_email->send_notification_email(array("to_address"=>$email, "subject"=> "Application Received", "email_data"=>array("msg"=>"There is a new application waiting to be activated.")));
				}
			}
		}	
		
		output_page("email_verification", array(), array(), $this->load->view('page/email_verification', array("state"=>$state), TRUE), TRUE);
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