<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		if (!$this->authentication->get_logged_in()) {
			// not logged in
			$login_next_uri = "dashboard";
			$this->session->set_userdata('my_next_uri', $login_next_uri);
			redirect(base_url()."login?next_uri=".$login_next_uri);
		}
		else {
			
			$this->load->model("applications");
			$row = $this->applications->get_row($this->authentication->get_id());
			$live_time = $row !== FALSE && (int) $row->host === 0 ? (int) $row->live_time : FALSE;
			output_page("dashboard", array(), array(), $this->load->view('page/dashboard', array("live_time"=>$live_time), TRUE));
		}
	}
}