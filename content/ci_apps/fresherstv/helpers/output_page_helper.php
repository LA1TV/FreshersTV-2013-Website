<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function output_page($page_name, $css, $js, $html, $no_index=FALSE) {
	$CI =& get_instance();
	$CI->load->library("recaptcha");
	$CI->load->view('page', array("current_page"=>$page_name, "css"=>$css, "js"=>$js, "logged_in"=>$CI->authentication->get_logged_in(), "recaptcha_lib"=>$CI->recaptcha, "html"=>$html, "no_index"=>$no_index), FALSE);
}