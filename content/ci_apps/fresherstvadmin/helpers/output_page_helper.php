<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function output_page($page_name, $css, $js, $html) {
	$CI =& get_instance();
	$CI->load->view('page', array("current_page"=>$page_name, "css"=>$css, "js"=>$js, "logged_in"=>$CI->admin_authentication->get_logged_in(), "html"=>$html), FALSE);
}