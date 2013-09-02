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
	
	function get_hash($input) {
		return hash('sha512', $salt.$input);
	}
}