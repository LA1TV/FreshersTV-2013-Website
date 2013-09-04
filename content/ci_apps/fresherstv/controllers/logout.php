<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index()
	{
		if (!$this->authentication->get_logged_in()) {
			// already logged out
			$already_logged_out = TRUE;
		}
		else {
			$already_logged_out = FALSE;
			// log out
			$this->authentication->log_out();
		}
		
		$html = $this->load->view('page/logged_out', array("already_logged_out"=>$already_logged_out), TRUE);
		$this->load->view('page', array("current_page"=>"logged_out", "css"=>array(), "js"=>array(), "no_index"=>TRUE, "logged_in"=>$this->authentication->get_logged_in(), "html"=>$html), FALSE);
	}
}