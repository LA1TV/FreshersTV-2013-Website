<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apply extends CI_Controller {

	public function index()
	{
		$form = array(
			"name"					=>	"",
			"email"					=>	"",
			"email_confirmation"	=>	"",
			// LOGO UPLOADS
			"participation_type"	=>	FALSE,
			"preferred_time"		=>	"",
			"resolution"			=>	"",
			"bitrate"				=>	"",
			"stream_extra"			=>	"",
			"overlay_details"		=>	"",
			"password"				=>	"",
			"password_confirmation"	=>	""
		);
		$html = $this->load->view('page/apply', array("form"=>$form, "form_errors"=>array()), TRUE);
		$this->load->view('page', array("current_page"=>"apply", "css"=>array(), "js"=>array("apply"), "html"=>$html), FALSE);
	}
	
	public function submit()
	{
		if ($this->input->post("form_submitted") !== "1") {
			redirect(base_url()."apply");
		}
		
		
		$form = array(
		
		
		
		
		);
		$form_errors = array(
		
		
		
		
		);
		
		$this->load->model("applications");
		
		
		$html = $this->load->view('page/apply', array("form"=>$form, "form_errors"=>$form_errors), TRUE);
		$this->load->view('page', array("current_page"=>"apply", "css"=>array(), "js"=>array("apply"), "html"=>$html), FALSE);
	}
}