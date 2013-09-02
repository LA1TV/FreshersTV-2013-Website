<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apply extends CI_Controller {

	public function index()
	{
		$form = array(
			"name"					=>	"",
			"email"					=>	"",
			"email_confirmation"	=>	"",
			"participation_type"	=>	FALSE,
			"participation_time"		=>	"",
			"resolution"			=>	"",
			"bitrate"				=>	"",
			"stream_extra"			=>	"",
			"overlay_details"		=>	"",
			"password"				=>	"",
			"password_confirmation"	=>	"",
			"show_main_logo_input"	=>	TRUE,
			"show_secondary_logo_input"	=>	TRUE
		);
		
		$this->session->unset_userdata('my_main_logo_tmp_file_name');
		$this->session->unset_userdata('my_secondary_logo_tmp_file_name');
		
		$html = $this->load->view('page/apply', array("form"=>$form, "form_errors"=>array()), TRUE);
		$this->load->view('page', array("current_page"=>"apply", "css"=>array(), "js"=>array("apply"), "html"=>$html), FALSE);
	}
	
	public function submit()
	{
		if ($this->input->post("form_submitted") !== "1") {
			redirect(base_url()."apply");
		}
		
		
		$form = array(
			"name"					=>	$this->_get_post_str("name"),
			"email"					=>	$this->_get_post_str("email"),
			"email_confirmation"	=>	$this->_get_post_str("email_confirmation"),
			"participation_type"	=>	$this->_get_post_str("participation_type"),
			"participation_time"	=>	$this->_get_post_str("participation_time"),
			"resolution"			=>	$this->_get_post_str("resolution"),
			"bitrate"				=>	$this->_get_post_str("bitrate"),
			"stream_extra"			=>	$this->_get_post_str("stream_extra"),
			"overlay_details"		=>	$this->_get_post_str("overlay_details"),
			"password"				=>	"",
			"password_confirmation"	=>	"",
			"show_main_logo_input"	=>	TRUE,
			"show_secondary_logo_input"	=>	TRUE
		);
		
		//process uploaded files first and get their temporarily names or check that the tmp file still exists
		if (array_key_exists("main_logo", $_FILES) && $this->_valid_logo_upload($_FILES['main_logo'])) {
			// they have just uploaded the file
			$this->session->set_userdata('my_main_logo_tmp_file_name', $_FILES['main_logo']['tmp_name']);	
			$form['show_main_logo_input'] = FALSE;
		}
		if ($this->session->userdata('my_main_logo_tmp_file_name') !== FALSE && is_uploaded_file($this->session->userdata('my_main_logo_tmp_file_name'))) {
			// we have their file already in the tmp dir ready for when the form validates and is submitted
			echo("success: ".$this->session->userdata('my_main_logo_tmp_file_name'));
			$form['show_main_logo_input'] = FALSE;
		}
		else {
			echo("failed: ".$this->session->userdata('my_main_logo_tmp_file_name'));
			// the file no longer exists in the tmp dir or is not valid
			$this->session->unset_userdata('my_main_logo_tmp_file_name');
		}
		
		if (array_key_exists("secondary_logo", $_FILES) && $this->_valid_logo_upload($_FILES['secondary_logo'])) {
			$this->session->set_userdata('my_secondary_logo_tmp_file_name', $_FILES['secondary_logo']['tmp_name']);
			$form['show_secondary_logo_input'] = FALSE;
		}
		if ($this->session->userdata('my_secondary_logo_tmp_file_name') !== FALSE && is_uploaded_file($this->session->userdata('my_secondary_logo_tmp_file_name'))) {
			// we have their file already in the tmp dir ready for when the form validates and is submitted
			$form['show_secondary_logo_input'] = FALSE;
		}
		else {
			// the file no longer exists in the tmp dir or is not valid
			$this->session->unset_userdata('my_secondary_logo_tmp_file_name');
		}
		
		// now do validation
		$form_errors = array();
		
		
		
		
	//	$this->load->model("applications");
		
		
		$html = $this->load->view('page/apply', array("form"=>$form, "form_errors"=>$form_errors), TRUE);
		$this->load->view('page', array("current_page"=>"apply", "css"=>array(), "js"=>array("apply"), "html"=>$html), FALSE);
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
	
	private function _valid_logo_upload($file)
	{
		if ($file['size'] === 0 || !is_uploaded_file($file['tmp_name'])) {
			return FALSE;
		}
		
		if ($file['size'] > 3000000) { // 3mb
			return FALSE;
		}
		return TRUE;
	}
}