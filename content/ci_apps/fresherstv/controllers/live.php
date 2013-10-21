<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Live extends CI_Controller {

	public function index()
	{
		// prevent page being cached
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");
		
		if (!$this->config->item("broadcasting_live") && $this->input->get("override") === FALSE) {
			$this->output_not_live_page();
		}
		else {
		
			require_once(APPPATH . 'third_party/mobile_detect.php');
			
			$detect = new Mobile_Detect();
			$device = $detect->isMobile() ? "mobile" : "pc";
			
			if ($this->input->get("deviceoverride") == "pc") {
				$device = "pc";
			}
			else if ($this->input->get("deviceoverride") == "mobile") {
				$device = "mobile";
			}
			
			$xmlInfo = simplexml_load_file($this->config->item("load_balancer_url"));
			if ($xmlInfo === FALSE) {
				$this->output_not_live_page();
				return;
			}
			else if ($xmlInfo->LoadBalancerServer->status != "RUNNING") {
				$this->output_not_live_page();
				return;
			}
			
			$stream_base_url = "rtmp://".$xmlInfo->LoadBalancerServer->redirect;
			
			$qualities = array(
				// txt, url, chosen
				"160p"	=> array("160p", ":1935/live-edge/FreshersTV_160p", FALSE),
				"240p"	=> array("240p", ":1935/live-edge/FreshersTV_240p", FALSE),
				"360p"	=> array("360p", ":1935/live-edge/FreshersTV_360p", FALSE),
				"720p"	=> array("720p", ":1935/live-edge/FreshersTV_720p", FALSE)
			);
			
						
			$chosen_quality = $device == "mobile" ? "360p" : "720p"; // default quality
			
			if (array_key_exists($this->input->get("q"), $qualities)) {
				$chosen_quality = $this->input->get("q");
			}
			
			$qualities[$chosen_quality][2] = TRUE;
			
			
			$data = array(
				"live"	=> TRUE,
				"device"	=> $device,
				"map_enabled"	=>	$this->config->item('map_enabled'),
				"stream_base_url"	=>	$stream_base_url,
				"chosen_quality"	=>	$qualities[$chosen_quality],
				"complete_stream_url"	=> $stream_base_url . $qualities[$chosen_quality][1],
				"qualities"	=> $qualities
			);
			
			output_page("live", array("live"), array(), $this->load->view('page/live', $data, TRUE), TRUE); // REMOVE LAST TRUE
		}
	}
	
	private function output_not_live_page() {
		$time_txt = time() <= $this->config->item("broadcast_start_time") ? Date("H:i", $this->config->item("broadcast_start_time"))." on ".Date("D dS F Y", $this->config->item("broadcast_start_time")) : FALSE;
		output_page("live", array(), array(), $this->load->view('page/live', array("live"=>FALSE, "time_txt"=>$time_txt), TRUE));
	}
}