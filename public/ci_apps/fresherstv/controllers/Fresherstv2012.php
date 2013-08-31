<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fresherstv2012 extends CI_Controller {

	public function index()
	{
		$html = $this->load->view('page/Fresherstv2012', array(), TRUE);
		$this->load->view('page', array("current_page"=>"Fresherstv2012", "css"=>array(), "js"=>array(), "html"=>$html), FALSE);
	}
}