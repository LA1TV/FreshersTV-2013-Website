<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fresherstv2012 extends CI_Controller {

	public function index()
	{
		output_page("fresherstv2012", array(), array(), $this->load->view('page/fresherstv2012', array(), TRUE));
	}
}