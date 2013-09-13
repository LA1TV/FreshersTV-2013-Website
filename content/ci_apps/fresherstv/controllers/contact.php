<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function index()
	{
		output_page("contact", array("contact"), array(), $this->load->view('page/contact', array(), TRUE));
	}
}