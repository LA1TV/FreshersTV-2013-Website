<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Admin_authentication {
	
	private $password = "41d823d8b7bd451fba7446e0d087eb198994e7e1";
	private $cookie_expire_time = 1; // days (of no activity because updates when logged in)
	
	function __construct()
	{
		$this->CI =& get_instance();
		$this->update_session(); // this library auto loads so this will always run before anything else
	}
	
	function authenticate($pass)
	{
		$this->log_out(); // make sure logged out before trying to authenticate again
		
		if (sha1($pass) === $this->password)
		{
			// correct login
			$this->log_in(sha1($pass)); // always use the hash from this points on.
		}
		else
		{
			// incorrect login
		}
		return;
	}
	
	function update_autologon_cookie()
	{
		if (!$this->get_logged_in())
		{
			return FALSE;
		}
		$salt = "cHoaT3OucIAkauejlebrIENoabIaBRlu";
		$current_time = time();
		$cookie_content = $salt . ":" . $this->get_pass() . ":" . $current_time;
		$cookie_content = $current_time . "-" . hash('sha256', $cookie_content);
		$this->CI->input->set_cookie('admin_autologin', $cookie_content, 60*60*24*$this->cookie_expire_time);
	}
	
	// log in from cookie
	function do_cookie_login()
	{
		if ($this->CI->input->cookie("admin_autologin") === FALSE)
		{
			return;
		}
		if($this->CI->input->cookie("admin_autologin") == '')
		{
			$this->clear_login_cookie();
			return;
		}
		
		$cookie_contents = explode('-', $this->CI->input->cookie("admin_autologin"));
		if (!isset($cookie_contents[0]) or !isset($cookie_contents[1]))
		{
			$this->clear_login_cookie();
			return;
		}
		$cookie_contents[0] = (int) $cookie_contents[0];
		
		$current_time = time();
		if ($current_time - $cookie_contents[0] > 60*60*24*$this->cookie_expire_time)
		{
			$this->clear_login_cookie();
			return;
		}
		$salt = "cHoaT3OucIAkauejlebrIENoabIaBRlu";
		$contents = hash('sha256', $salt . ":" . $this->password . ":" . $cookie_contents[0]);
		if ($contents !== $cookie_contents[1])
		{
			$this->clear_login_cookie();
			return;
		}
		$this->log_in($this->password);
	}
	
	function clear_login_cookie() {
		if ($this->CI->input->cookie("admin_autologin") !== FALSE)
		{
			$this->CI->input->set_cookie('admin_autologin');
		}
	}
	
	function update_session() //automatically called before anything else because in construct
	{
		if (!$this->get_logged_in()) {
			$this->do_cookie_login();
		}
		$this->update_autologon_cookie();
		
		if ($this->get_pass() !== $this->password)
		{
			$this->log_out('You have been logged out automatically as your password has changed.');
		}
		$time = time();
		$data = array(
						'my_admin_last_activity'	=> $time,
						'my_admin_ip'				=> $this->CI->input->ip_address(),
						'my_admin_initialized'		=> TRUE
		);
		
		$this->CI->session->set_userdata($data);
	}
	
	function log_in($pass)
	{
		$this->CI->session->set_userdata('my_admin_logged_in', TRUE);
		$this->CI->session->set_userdata('my_admin_pass', $pass);
		$this->update_autologon_cookie();
	}
	function log_out($reason = FALSE)
	{
		$this->CI->session->set_userdata('my_admin_logged_in', FALSE);
		$this->CI->session->unset_userdata('my_admin_pass');
		$this->CI->session->set_userdata('my_admin_logout_reason', $reason);
		$this->clear_login_cookie();
	}
	
	function get_log_out_reason()
	{
		$reason = $this->CI->session->userdata('my_admin_logout_reason');
		$this->CI->session->unset_userdata('my_admin_logout_reason');
		return $reason;
	}
	
	function get_logged_in()
	{
		return $this->CI->session->userdata('my_admin_logged_in');
	}
	
	function get_last_active()
	{
		return $this->CI->session->userdata('my_admin_last_activity');
	}
	
	function get_ip()
	{
		return $this->CI->session->userdata('my_admin_ip');
	}
	
	function get_pass()
	{
		return $this->CI->session->userdata('my_admin_pass');
	}

	function get_initialized()
	{
		return $this->CI->session->userdata('my_admin_initialized');
	}

}
	