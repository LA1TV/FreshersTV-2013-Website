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
		return; // TEMP
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
	
	function get_hash($input) {
		return hash('sha512', $this->hash_salt.$input);
	}
	
	function generate_verification_code() {
		$found = FALSE;
		while(!$found) {
			$code = $this->get_hash(rand());
		//	$query = $this->db->get_where($this->table, array('email_verification_hash'=>$this->get_hash($code)));
		//	$found = $query->num_rows === 0;
			$found = TRUE; // TEMP
		}
		return $code;
	}
	
	// returns 0 if email was verified, 1 if email was already verified or 2 if link invalid or link not allowed because another one already used
	function verify_email($code) {
		
		//TEMP
		return 2;
	
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
}