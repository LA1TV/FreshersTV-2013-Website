<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	public function index()
	{
		if (!$this->authentication->get_logged_in()) {
			// not logged in
			$login_next_uri = "account";
			$this->session->set_userdata('my_next_uri', $login_next_uri);
			redirect(base_url()."login?next_uri=".$login_next_uri);
		}
		else {
			output_page("account", array(), array(), $this->load->view('page/account', array(), TRUE));
		}
	}
}