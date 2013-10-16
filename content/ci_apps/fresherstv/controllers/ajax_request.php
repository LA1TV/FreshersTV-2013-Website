<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_request extends CI_Controller {

	public function index()
	{
		$response = array("success" => TRUE, "response" => FALSE);
		if ($this->input->get("action") === "get_show_login_captcha") {
			$response['response'] = $this->authentication->get_show_captcha();
		}
		else if ($this->input->get("action") === "get_station_times") {
			$this->load->model("applications");
			$response['response'] = $this->applications->get_times_data();
		}
		else {
			$response['success'] = FALSE;
		}
		$this->output->set_header('Cache-Control: no-cache, must-revalidate');
		$this->output->set_header('Content-type: application/json');
		$this->output->set_output(json_encode($response));
	}
}