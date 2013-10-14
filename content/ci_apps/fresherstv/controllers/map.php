<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Map extends CI_Controller {

	public function index()
	{
		if ($this->input->get("test") === FALSE) {
			show_404();
			return;
		}
		$map_data = $this->applications->get_map_data();
		$map_data_json = json_encode($map_data);
		output_page("map", array("map"), array("map"), $this->load->view('page/map', array("map_data_json"=>$map_data_json), TRUE));
	}
}