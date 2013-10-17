<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comms extends CI_Controller {

	public function index()
	{
		if (!$this->authentication->get_logged_in()) {
			// not logged in
			$login_next_uri = "comms";
			$this->session->set_userdata('my_next_uri', $login_next_uri);
			redirect(base_url()."login?next_uri=".$login_next_uri);
		}
		else {
			
			$this->load->model("applications");
			$comms_settings = $this->applications->get_comms_details($this->authentication->get_id());
			$settings = array(
				"username"	=> $comms_settings['username'],
				"password"	=> $comms_settings['password'],
				"sip_address"	=> $comms_settings['username'] . "@comms.freshers.tv",
				"domain"	=> "comms.freshers.tv",
				"caller_id"	=> $comms_settings['username']
			);
			output_page("comms", array(), array(), $this->load->view('page/comms_details', array("settings"=>$settings), TRUE));
		}
	}
}