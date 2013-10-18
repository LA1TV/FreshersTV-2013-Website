<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {

	public function index()
	{
		if (!$this->admin_authentication->get_logged_in()) {
			redirect(base_url()."login");
		}
		
		output_page("chat", array(), array(), $this->load->view('page/chat', array(), TRUE));
	}
}