<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clock extends CI_Controller {

	public function index()
	{
		output_page("clock", array("clock"), array("clock"), $this->load->view('page/clock', array(), TRUE));
	}
}