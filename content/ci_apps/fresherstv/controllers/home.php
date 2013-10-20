<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		if ($this->config->item('broadcasting_live')) {
			redirect('/live', 'location', 302);
			return;
		}
		output_page("home", array("home"), array("home"), $this->load->view('page/home', array("show_animated_apply_button"=>$this->config->item('applications_open')), TRUE));
	}
}