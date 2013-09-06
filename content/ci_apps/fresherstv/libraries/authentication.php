<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Authentication {
	
	function __construct()
	{
		$this->CI =& get_instance();
		$this->update_session(); // this library auto loads so this will always run before anything else
	}
	
	function authenticate($email, $pass)
	{
		// TEMP
		return;
		$this->log_out(); // make sure logged out before trying to authenticate again
		$this->CI->load->model("applications");
		$id = $this->CI->applications->get_id_from_email($email);
		
		if ($id !== FALSE && $this->CI->applications->get_hashed_password($id) === $this->CI->applications->get_hash($pass))
		{
			// correct login
			$this->update_incorrect_logins(TRUE);
			$this->log_in($id, $this->CI->applications->get_hash($pass)); // always use the hash from this points on. (same as what's stored in db)
		}
		else
		{
			// incorrect login
			$this->update_incorrect_logins(FALSE);
		}
		return;
	}
	
	function update_incorrect_logins($logged_in)
	{
		$this->CI->load->model("incorrect_logins");
		if (!$logged_in)
		{
			$this->CI->incorrect_logins->add_failed_attempt();
		}
		$this->CI->incorrect_logins->clean_up();
	}
	
	function get_show_captcha()
	{
		// TEMP
		return TRUE;
		$this->CI->load->model("incorrect_logins");
		return $this->CI->incorrect_logins->is_over_limit();
	}
	
	function update_password($pass)
	{
		$this->CI->session->set_userdata('my_pass', $pass);
		return;
	}
	
	function update_session() //automatically called before anything else because in construct
	{
		// TEMP
		return;
		
		$time = time();
		$this->CI->load->model("applications");
		if ($this->get_initialized() and $this->get_logged_in())
		{
			if (!$this->CI->applications->exists($this->get_id()))
			{
				$this->log_out('You have been logged out automatically as you account has been deleted.');
			}
			else if ($this->get_pass() !== $this->CI->applications->get_hashed_password($this->get_id()))
			{
				$this->log_out('You have been logged out automatically as your password has changed.');
			}
			else if ($this->get_last_active() <= $time-($this->CI->config->item('session_idle_time')*60))
			{
				$this->log_out('You have been logged out automatically as you were inactive for too long.');
			}
		}
		$data = array(
						'my_last_activity'	=> $time,
						'my_ip'				=> $this->CI->input->ip_address(),
						'my_initialized'	=> TRUE
		);
		
		$this->CI->session->set_userdata($data);
	}
	
	function log_in($id, $pass)
	{
		$this->CI->session->set_userdata('my_logged_in', TRUE);
		$this->CI->session->set_userdata('my_id', $id);
		$this->CI->session->set_userdata('my_pass', $pass);
	}
	function log_out($reason = FALSE)
	{
		$this->CI->session->set_userdata('my_logged_in', FALSE);
		$this->CI->session->unset_userdata('my_id');
		$this->CI->session->unset_userdata('my_pass');
		$this->CI->session->set_userdata('my_logout_reason', $reason);
	}
	
	function log_out_reason()
	{
		$reason = $this->CI->session->userdata('my_logout_reason');
		$this->CI->session->unset_userdata('my_logout_reason');
		return $reason;
	}
	
	function get_logged_in()
	{
	// TEMP
	return FALSE;
		return $this->CI->session->userdata('my_logged_in');
	}
	
	function get_last_active()
	{
		return $this->CI->session->userdata('my_last_activity');
	}
	
	function get_ip()
	{
		return $this->CI->session->userdata('my_ip');
	}
	
	function get_id()
	{
		return $this->CI->session->userdata('my_id');
	}

	function get_initialized()
	{
		return $this->CI->session->userdata('my_initialized');
	}
	
	// returns pass hash as stored in database
	function get_pass()
	{
		return $this->CI->session->userdata('my_pass');
	}

}
	