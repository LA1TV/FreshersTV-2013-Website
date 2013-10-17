<?php

class Applications extends CI_Model {

	var $table = 'applications';
	var $hash_salt = "auYQzTsiLwsIubTlr2M9HpgJbSxn3fq97u2xM2CiDWuxfL11zlb73wQJBJMj2hk";
	
	function get_row($id)
	{
		$query = $this->db->get_where($this->table, array('id'=>$id));
		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}
		return $query->row();
	}
	
	function add_application($data)
	{
		// data should be validated in controller before it gets here. should technically check everything here as well but can't be bothered
		$this->db->insert($this->table, $data);
		$this->updateSha256Pass($id);
		
		
	}
	
	function exists($id) {
		$query = $this->db->get_where($this->table, array('id'=>$id));
		return $query->num_rows() === 1;
	}
	
	function is_correct_email_verification_code($id, $code) {
		// should really only select the required field but can't be bothered
		$query = $this->db->get_where($this->table, array('id'=>$id));
		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}
		$row = $query->row();
		return ($row->email_verification_hash === $this->get_hash($code));
	}
	
	function get_activated($id) {
		$query = $this->db->get_where($this->table, array('id'=>$id));
		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}
		$row = $query->row();
		return $row->application_accepted ? TRUE : FALSE;
	}
	
	function get_verified($id) {
		$query = $this->db->get_where($this->table, array('id'=>$id));
		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}
		$row = $query->row();
		return $row->email_verified ? TRUE : FALSE;
	}
	
	function get_email($id) {
		$query = $this->db->get_where($this->table, array('id'=>$id));
		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}
		$row = $query->row();
		return $row->email;
	}
	
	function set_application_accepted($id, $val=TRUE) {
		if ($val) {
			// if any others have been accepted with the same email unaccept them
			$row = $this->get_row($id);
			$this->db->update($this->table, array("application_accepted"=>FALSE), array('email'=>$row->email, 'application_accepted'=>TRUE));
		}
		$this->db->update($this->table, array('application_accepted'=>$val), array("id"=>$id));
	}
	
	function get_hashed_password($id) {
		$query = $this->db->get_where($this->table, array('id'=>$id));
		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}
		$row = $query->row();
		return $row->password;
	}
	
	function get_hash($input) {
		return sha1(hash('sha512', $this->hash_salt.$input));
	}
	
	function update_vt($id, $url) {
		$this->db->update($this->table, array('vt'=>$url), array("id"=>$id));
	}
	
	function get_vt_received($id) {
		$row = $this->get_row($id);
		if ($row === FALSE) {
			return FALSE;
		}
		return $row->vt !== NULL;
	}
	
	// gets the id of the ACCEPTED APPLICATION account with the email or false otherwise
	function get_id_from_email($email) {
		$query = $this->db->get_where($this->table, array('email'=>$email, "application_accepted"=>TRUE));
		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}
		$row = $query->row();
		return (int) $row->id;
	}
	
	function generate_verification_code() {
		$found = FALSE;
		while(!$found) {
			$code = $this->get_hash(rand());
			$query = $this->db->get_where($this->table, array('email_verification_hash'=>$this->get_hash($code)));
			$found = $query->num_rows === 0;
		}
		return $code;
	}
	
	function update_email_verification_hash($id, $val) {
		$this->db->update($this->table, array('email_verification_hash'=>$this->get_hash($val)), array("id"=>$id));
	}
	
	// returns 0 if email was verified, 1 if email was already verified or 2 if link invalid or link not allowed because another one already used
	function verify_email($code) {
	
		// check if key exists
		$query = $this->db->get_where($this->table, array('email_verification_hash'=>$this->get_hash($code)));
		if ($query->num_rows() !== 1)
		{
			return 2;
		}
		$row = $query->row();
		if ($row->email_verified) {
			return 1;
		}
		// check if the email corresponding to the key is not already verified with a different key
		$query2 = $this->db->get_where($this->table, array('email'=>$row->email, 'email_verified'=>TRUE));
		if ($query2->num_rows() !== 0)
		{
			return 2;
		}
		// update db
		$this->db->update($this->table, array('email_verified'=>TRUE), array("id"=>$row->id));
		return 0;
	}
	
	function get_id_from_verification_code($code) {
		$query = $this->db->get_where($this->table, array('email_verification_hash'=>$this->get_hash($code)));
		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}
		$row = $query->row();
		return $row->id;
	}
	
	function create_password_reset_code($id) {
	
		$found = FALSE;
		while(!$found) {
			$code = $this->get_hash(rand());
			$query = $this->db->get_where($this->table, array('password_reset_hash'=>$this->get_hash($code)));
			$found = $query->num_rows === 0;
		}
	
		// write the hashed version of the code in the db
		$this->db->update($this->table, array('password_reset_hash'=>$this->get_hash($code)), array("id"=>$id));
		$this->db->update($this->table, array('password_reset_hash_creation_time'=>time()), array("id"=>$id));
		return $code;
	}
	
	// returns 0 if code correct, 1 if code expired or 2 if incorrect code
	function verify_password_reset_code($code) {
		
		// check if key exists
		$query = $this->db->get_where($this->table, array('password_reset_hash'=>$this->get_hash($code)));
		if ($query->num_rows() !== 1)
		{
			return 2;
		}
		$row = $query->row();
		$creation_time = (int) $row->password_reset_hash_creation_time;
		if ($creation_time < time()-(60*60)) { // more than an hour old
			return 1;
		}
		return 0;
	}
	
	function get_id_from_password_reset_code($code) {
		$query = $this->db->get_where($this->table, array('password_reset_hash'=>$this->get_hash($code)));
		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}
		$row = $query->row();
		return $row->id;
	}
	
	// clear password reset code for id
	function remove_password_reset_code($id) {
		$this->db->update($this->table, array('password_reset_hash'=>NULL, 'password_reset_hash_creation_time'=>NULL), array("id"=>$id));
	}
	
	// pass in the unhashed password
	function set_password($id, $new_pass) {
		$this->db->update($this->table, array('password'=>$this->get_hash($new_pass)), array("id"=>$id));
		$this->updateSha256Pass($id);
	}
	
	function updateSha256Pass($id) {
		$query = $this->db->get_where($this->table, array('id'=>$id));
		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}
		$row = $query->row();
		$this->db->update($this->table, array('pass_sha256'=>hash('sha256', $row->password)), array("id"=>$id));
	}
	
	function does_pass_meet_requirments($pass) {
		return !(strlen($pass) < 8 || !preg_match('#[0-9]#', $pass) || !preg_match('#[a-z]#', $pass) || !preg_match('#[A-Z]#', $pass));
	}
	
	function get_all() {
		$this->db->from($this->table);
		$this->db->order_by("application_accepted", "asc");
		$this->db->order_by("email_verified", "desc");
		$this->db->order_by("name", "asc");
		$this->db->order_by("contact", "asc");
		$this->db->order_by("email", "asc");
		$this->db->order_by("postcode", "asc");
		$this->db->order_by("participation_type", "asc");
		$query = $this->db->get();
		$rows = array();
		foreach ($query->result() as $row)
		{
			$rows[] = $row;
		}
		return $rows;
	}
	
	// returns array of stations with start times sorted by time ignoring the host station
	function get_times_data() {
		$this->db->from($this->table);
		$this->db->where("application_accepted", TRUE);
		$this->db->where("ready", TRUE);
		$this->db->where("host", FALSE);
		$this->db->order_by("live_time", "asc");
		$query = $this->db->get();
		$rows = array();
		$i = 0;
		foreach ($query->result() as $row)
		{
			$rows[] = array(
				"index"	=> $i,
				"id"	=> (int) $row->id,
				"name"	=> $row->name,
				"live_time"	=> (int) $row->live_time,
				"live_time_html"	=> Date("Y-m-d\TH:i:s", intVal($row->live_time, 10)),
				"participation_type"	=> $row->participation_type,
				"participation_type_str"	=> (int) $row->participation_type === 0 ? "Live" : "VT"
			);
			$i++;
		}
		return $rows;
	}
	
	function update_time($id, $time) {
		$this->db->update($this->table, array('live_time'=>$time), array("id"=>$id));
	}
	
	// return the array (which can be converted to json) of all the data for the map
	function get_map_data() {
		$data = array();
		$this->db->from($this->table);
		$this->db->where("ready", TRUE);
		$this->db->order_by("host", "desc");
		$this->db->order_by("name");
		$this->db->order_by("live_time");
		$query = $this->db->get();
		foreach ($query->result() as $row) {
			if ($row->lat === NULL || $row->lng === NULL || $row->logo_name === NULL || $row->live_time === NULL) {
				continue;
			}
			$image_details = getimagesize(FCPATH . $application_folder . 'assets/img/station_logos/medium/' . $row->logo_name);
			$logo_width = intval(strval($image_details[0]), 10);
			$logo_height = intval(strval($image_details[1]), 10);
			$image_details = getimagesize(FCPATH . $application_folder . 'assets/img/station_logos/small/' . $row->logo_name);
			$s_logo_width = intval(strval($image_details[0]), 10);
			$s_logo_height = intval(strval($image_details[1]), 10);
			$timestamp = (int) $row->live_time;
			
			$data[] = array(
				"id"=>(int) $row->id,
				"lat"=>(float) $row->lat,
				"lng"=>(float) $row->lng,
				"logo_name"=> $row->logo_name,
				"full_logo_w"=> $logo_width,
				"full_logo_h"=> $logo_height,
				"small_logo_w"=> $s_logo_width,
				"small_logo_h"=> $s_logo_height,
				"live_time"=> $timestamp,
				"participation_type"=>(int) $row->participation_type,
				"name"=> $row->name,
				"host"=> $row->host == "1"
			);
		}
		return $data;
	}
	
	function get_comms_details($id) {
		$query = $this->db->get_where($this->table, array('id'=>$id));
		if ($query->num_rows() !== 1)
		{
			return FALSE;
		}
		$row = $query->row();
		return array(
			"username"	=> $row->username,
			"password"	=> $row->sip_pass
		);
	}
}