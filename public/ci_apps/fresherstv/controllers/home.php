<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$html = $this->load->view('page/home', array(), TRUE);
		$this->load->view('page', array("current_page"=>"home", "css"=>array("home"), "js"=>array("home"), "html"=>$html), FALSE);
	}
}