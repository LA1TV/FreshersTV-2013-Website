<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apply extends CI_Controller {

	public function index()
	{
		$html = $this->load->view('page/apply', array(), TRUE);
		$this->load->view('page', array("current_page"=>"apply", "css"=>array(), "js"=>array("apply"), "html"=>$html), FALSE);
	}
}