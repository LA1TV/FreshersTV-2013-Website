<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fresherstv2012 extends CI_Controller {

	public function index()
	{
		$html = $this->load->view('page/fresherstv2012', array(), TRUE);
		$this->load->view('page', array("current_page"=>"fresherstv2012", "css"=>array(), "js"=>array(), "logged_in"=>$this->authentication->get_logged_in(), "recaptcha_lib"=>$this->recaptcha, "html"=>$html), FALSE);
	}
}