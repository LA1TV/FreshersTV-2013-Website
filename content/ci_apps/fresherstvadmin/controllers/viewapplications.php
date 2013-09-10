<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Viewapplications extends CI_Controller {

	public function index()
	{
		if (!$this->admin_authentication->get_logged_in()) {
			redirect(base_url()."login");
		}
		
		$this->load->model("applications");
		
		$dbrows = $this->applications->get_all();
		$rows = array();
		foreach($dbrows as $a) {
			$rows[] = array(
				"name"	=>	$a->name,
				"email"	=>	$a->email,
				"contact"	=>	$a->contact,
				"phone"	=>	$a->phone,
				"participation_type"	=> (int) $a->participation_type === 0 ? "Live" : "VT",
				"verified"	=>	$a->email_verified ? '<span class="text-success">Yes</span>' : '<span class="text-warning">No</span>',
				"accepted"	=>	$a->application_accepted ? '<span class="text-success">Yes</span>' : '<span class="text-warning">No</span>',
				"id"		=>	(int) $a->id
			);
		}
		
		
		$data = array(
			"table_rows"	=>	$rows
		);
		
		output_page("applications", array(), array(), $this->load->view('page/applications', $data, TRUE));
	}
	
	public function view() {
		if (!$this->admin_authentication->get_logged_in()) {
			redirect(base_url()."login");
		}
		
		$this->load->model("applications");
		$id = $this->input->get("id");
		if ($id === FALSE || !$this->applications->exists($id)) {
			redirect(base_url()."viewapplications");
		}
		
		$info_txt = FALSE;
		if ($this->input->post("form_submitted") == "1" && $this->input->post("action") == "accept") {
			$accept_id = $this->input->post("id");
			if ($accept_id !== FALSE && $this->applications->exists($accept_id) && $this->applications->get_verified($accept_id) && !$this->applications->get_activated($accept_id)) {
				$this->applications->set_application_accepted($accept_id);
				$this->load->library("send_email");
				$this->send_email->send_account_activated_email($this->applications->get_email($accept_id));
				$info_txt = "Application accepted. The station will be notified by e-mail and they will now be able to log in.";
			}
		
		}
		
		$table_rows = array();
		$db_row = $this->applications->get_row($id);
		
		$this->load->helper("security");
		$this->load->helper("format");
		
		$table_rows[] = array("Time received", htmlent(format_date($db_row->time_created)));
		foreach(array(array("Name", "name"), array("Contact", "contact")) as $a) {
			$table_rows[] = array($a[0], htmlent($db_row->$a[1]));
		}
		$table_rows[] = array("Email", '<a href="mailto:'.htmlent($db_row->email).'" target="_blank">'.htmlent($db_row->email).'</a>');
		foreach(array(array("Postcode", "postcode"), array("Phone", "phone")) as $a) {
			$table_rows[] = array($a[0], htmlent($db_row->$a[1]));
		}
		$table_rows[] = array("Main logo", '<a href="'.htmlent($db_row->main_logo).'" target="_blank">'.htmlent($db_row->main_logo).'</a>');
		$tmp = $db_row->secondary_logo === NULL ? '<span class="text-muted">[Not Provided]</span>' : '<a href="'.htmlent($db_row->secondary_logo).'" target="_blank">'.htmlent($db_row->secondary_logo).'</a>';
		$table_rows[] = array("Secondary logo", $tmp);
		$table_rows[] = array("Participation type", (int) $db_row->participation_type === 0 ? "Live" : "VT");
		if ((int) $db_row->participation_type === 0) {
			if ($db_row->participation_time === "1800"){$tmp=htmlent("18:00 - 18:15");}
			else if ($db_row->participation_time === "1815"){$tmp=htmlent("18:15 - 18:30");}
			else if ($db_row->participation_time === "1830"){$tmp=htmlent("18:30 - 18:45");}
			else if ($db_row->participation_time === "1845"){$tmp=htmlent("18:45 - 19:00");}
			else if ($db_row->participation_time === "1900"){$tmp=htmlent("19:00 - 19:15");}
			else if ($db_row->participation_time === "1915"){$tmp=htmlent("19:15 - 19:30");}
			else if ($db_row->participation_time === "1930"){$tmp=htmlent("19:30 - 19:45");}
			else if ($db_row->participation_time === "1945"){$tmp=htmlent("19:45 - 20:00");}
			else if ($db_row->participation_time === "2000"){$tmp=htmlent("20:00 - 20:15");}
			else if ($db_row->participation_time === "2015"){$tmp=htmlent("20:15 - 20:30");}
			else if ($db_row->participation_time === "2030"){$tmp=htmlent("20:30 - 20:45");}
			else if ($db_row->participation_time === "2045"){$tmp=htmlent("20:45 - 21:00");}
			else if ($db_row->participation_time === "2100"){$tmp=htmlent("21:00 - 21:15");}
			else if ($db_row->participation_time === "2115"){$tmp=htmlent("21:15 - 21:30");}
			else if ($db_row->participation_time === "1230"){$tmp=htmlent("21:30 - 21:45");}
			else if ($db_row->participation_time === "2145"){$tmp=htmlent("21:45 - 22:00");}
			else {$tmp="";}
			$table_rows[] = array("Preferred time", $tmp);
			foreach(array(array("Resolution", "resolution"), array("Bitrate", "bitrate")) as $a) {
				$table_rows[] = array($a[0], htmlent($db_row->$a[1]));
			}
			if ($db_row->stream_url !== NULL) {
				$table_rows[] = array("Stream url", htmlent($db_row->stream_url));
			}
			if ($db_row->stream_extra !== NULL) {
				$table_rows[] = array("Stream extra info", nl2br(htmlent($db_row->stream_extra)));
			}
		}
		$table_rows[] = array("Overlay details", $db_row->overlay_details === NULL ? '<span class="text-muted">[Not Provided]</span>' : nl2br(htmlent($db_row->overlay_details)));
		$table_rows[] = array("Cinebeat url", '<a href="'.htmlent($db_row->cinebeat).'" target="_blank">'.htmlent($db_row->cinebeat).'</a>');
		$table_rows[] = array("VT", $db_row->vt === NULL ? '<span class="text-muted">[Not Provided]</span>' : '<a href="'.htmlent($db_row->vt).'" target="_blank">'.htmlent($db_row->vt).'</a>');
		$table_rows[] = array("E-mail verified", $db_row->email_verified ? "Yes" : "No");
		$table_rows[] = array("Application accepted", $db_row->application_accepted ? "Yes" : "No");
		
		
		$data = array(
			"table_rows"	=>	$table_rows,
			"info_txt"		=>	$info_txt,
			"show_accept_button"	=>	$this->applications->get_verified($id) && !$this->applications->get_activated($id),
			"id"			=>	$id
		);
		
		output_page("viewapplication", array(), array("viewapplication"), $this->load->view('page/view_application', $data, TRUE));
	}
}