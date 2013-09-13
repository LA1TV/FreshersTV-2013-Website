<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends CI_Controller {

	public function index()
	{
		if (!$this->admin_authentication->get_logged_in()) {
			redirect(base_url()."login");
		}
		
		
		output_page("schedule", array("schedule"), array("schedule"), $this->load->view('page/schedule', array(), TRUE));
	}
}