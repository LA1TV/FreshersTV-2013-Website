<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {

	public function index()
	{
		redirect("http://blog.freshers.tv/", "location", 301);
	}
}