<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {

	public function index()
	{
		output_page("about", array(), array(), $this->load->view('page/about', array(), TRUE));
	}
}