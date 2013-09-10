<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index()
	{
		if (!$this->admin_authentication->get_logged_in()) {
			// already logged out
			$already_logged_out = TRUE;
		}
		else {
			$already_logged_out = FALSE;
			// log out
			$this->admin_authentication->log_out();
		}
		
		output_page("logged_out", array(), array(), $this->load->view('page/logged_out', array("already_logged_out"=>$already_logged_out), TRUE), TRUE);
	}
}