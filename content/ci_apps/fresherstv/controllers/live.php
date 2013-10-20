<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Live extends CI_Controller {

	public function index()
	{
		if ($this->input->get("test") === FALSE) {
			show_404();
			return;
		}
		output_page("live", array(), array(), $this->load->view('page/live', array(), TRUE), TRUE); // REMOVE LAST TRUE
	}
}