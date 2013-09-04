<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {

	public function index()
	{
		$html = $this->load->view('page/about', array(), TRUE);
		$this->load->view('page', array("current_page"=>"about", "css"=>array(), "js"=>array(), "logged_in"=>$this->authentication->get_logged_in(), "html"=>$html), FALSE);
	}
}