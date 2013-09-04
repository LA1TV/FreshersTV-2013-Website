<?php

class Incorrect_logins extends CI_Model {

	var $table = 'login_invalid_attempts';
	
	function add_failed_attempt($assoc_id)
	{
		$this->db->insert($this->table, array('time'=>time()));
	}
	
	
	function clean_up()
	{
		$cut_time = time() - ($this->config->item('no_login_attempts_remember_time')*60);
		$this->db->delete($this->table, array('time <'=>$cut_time));
	}

	function is_over_limit($assoc_id)
	{
		$cut_time = time() - ($this->config->item('no_login_attempts_remember_time')*60);
		$this->db->from($this->table);
		$this->db->where(array("time >="=>$cut_time));
		$query = $this->db->get();
		return $query->num_rows() >= $this->config->item('no_login_attempts_trigger');
	}
	
}