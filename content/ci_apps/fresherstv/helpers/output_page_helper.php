<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function output_page($page_name, $css, $js, $html, $no_index=FALSE) {
	$CI =& get_instance();
	$CI->load->library("recaptcha");
	$login_next_uri = $CI->uri->rsegment(1) !== FALSE ? $CI->uri->rsegment(1) : FALSE;
	$CI->session->set_userdata('my_next_uri', $login_next_uri);
	$login_dialog_html = $CI->load->view("jsdialogs/login", array("form"=>array("next_uri"=>$login_next_uri), "recaptcha_lib"=>$CI->recaptcha), TRUE);
	$CI->load->view('page', array("current_page"=>$page_name, "css"=>$css, "js"=>$js, "logged_in"=>$CI->authentication->get_logged_in(), "recaptcha_lib"=>$CI->recaptcha, "html"=>$html, "login_dialog_html"=>$login_dialog_html, "no_index"=>$no_index), FALSE);
}