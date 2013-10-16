<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scheduling extends CI_Controller {

	public function index()
	{
		if (!$this->admin_authentication->get_logged_in()) {
			redirect(base_url()."login");
		}
		
		$this->load->model("applications");
		$data = $this->applications->get_times_data();
		
		output_page("scheduling", array("scheduling"), array(), $this->load->view('page/scheduling', array("stations"=>$data), TRUE));
	}
	
	public function submit()
	{
		if (!$this->admin_authentication->get_logged_in()) {
			redirect(base_url()."login");
		}
	
		$this->load->model("applications");
		
		$i = 0;
		
		while($this->input->post("station-".$i."-id") !== FALSE) {
			$id = intVal($this->input->post("station-".$i."-id"), 10);
			if ($this->applications->exists($id) && $this->input->post("station-".$i."-time") !== FALSE) {
				$time = strtotime($this->input->post("station-".$i."-time"));
				if ($time !== FALSE) {
					$this->applications->update_time($id, $time);
				}
			}
			$i++;
		}
		$data = $this->applications->get_times_data();
		output_page("scheduling", array("scheduling"), array(), $this->load->view('page/scheduling', array("stations"=>$data), TRUE));
	}
}