<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		output_page("home", array("home"), array("home"), $this->load->view('page/home', array(), TRUE));
	}
}