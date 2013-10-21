<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		if (!$this->authentication->get_logged_in()) {
			// not logged in
			$login_next_uri = "dashboard";
			$this->session->set_userdata('my_next_uri', $login_next_uri);
			redirect(base_url()."login?next_uri=".$login_next_uri);
		}
		else {
			// prevent page being cached
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
			$this->output->set_header("Pragma: no-cache");
		
			$this->load->model("applications");
			$row = $this->applications->get_row($this->authentication->get_id());
			$live_time = $row !== FALSE && (int) $row->host === 0 ? Date("H:i:s", (int) $row->live_time) : FALSE;
			
			$stream_url = $this->config->item("low_latency_stream_url");
			$show_stream = $this->config->item("broadcasting_live") || $this->input->get("override") !== FALSE;
			
			require_once(APPPATH . 'third_party/mobile_detect.php');
			$detect = new Mobile_Detect();
			$device = $detect->isMobile() ? "mobile" : "pc";
			
			if ($this->input->get("deviceoverride") == "pc") {
				$device = "pc";
			}
			else if ($this->input->get("deviceoverride") == "mobile") {
				$device = "mobile";
			}
			
			$chat_settings = array(
				"username"	=> $row->username,
				"password"	=> $row->pass_sha256,
				"channel"	=> "#chat"
			);
			output_page("dashboard", array("dashboard"), array("dashboard"), $this->load->view('page/dashboard', array("live_time"=>$live_time, "station_id"=>$this->authentication->get_id(), "device"=>$device, "stream_url"=>$stream_url, "show_stream"=>$show_stream, "chat_settings"=>$chat_settings), TRUE));
		}
	}
}