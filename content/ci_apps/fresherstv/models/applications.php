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
		return $row->application_accepted;
	}
	
	function set_application_accepted($id, $val=TRUE) {
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
		return hash('sha512', $this->hash_salt.$input);
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
		$query = $this->db->get_where($this->table, array('email'=>"email", "application_accepted"=>TRUE));
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
	
	// returns 0 if email was verified, 1 if email was already verified or 2 if link invalid or link not allowed because another one already used
	function verify_email($code) {
	
		// check if key exists
		$query = $this->db->get_where($this->table, array('email_verification_hash'=>$this->get_hash($code)));
		if ($query->num_rows() !== 1)
		{
			return 2;
		}
		$row = $query->row();
		if ($row->verified) {
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
	}
	
	function does_pass_meet_requirments($pass) {
		return !(strlen($pass) < 8 || !preg_match('#[0-9]#', $pass) || !preg_match('#[a-zA-Z]#', $pass));
	}
}