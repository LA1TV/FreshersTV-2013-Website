<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Send_email {

	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	
	function send_pass_reset_email($data)
	{
		$title = 'FreshersTV: Password Reset Request';
		
		$body_html = $this->CI->load->view('emails/pass_reset', $data['email_data'], TRUE);
		$html = $this->CI->load->view('emails/page', array('title'=>$title, 'html'=>$body_html), TRUE);
		return $this->send($data['to_address'], $title, $html);
	}
	
	function send_activate_email($data)
	{
		$title = 'FreshersTV: E-mail Verification Required';
		
		$body_html = $this->CI->load->view('emails/activate_email', $data['email_data'], TRUE);
		$html = $this->CI->load->view('emails/page', array('title'=>$title, 'html'=>$body_html), TRUE);
		return $this->send($data['to_address'], $title, $html);
	}
	
	function send_vt_received_email($to)
	{
		return $this->send_notification_email(array(
			"to_address"=>$to,
			"subject"=>"FreshersTV: VT Received",
			"email_data"=>array(
				"msg"=>"This is confirmation that we have received your VT."
			)
		));
	}
	
	function send_password_changed_email($to)
	{
		return $this->send_notification_email(array(
			"to_address"=>$to,
			"subject"=>"FreshersTV: Password Changed",
			"email_data"=>array(
				"msg"=>"Your password for your FreshersTV account has been changed."
			)
		));
	}
	
	function send_email_verified_email($to)
	{
		return $this->send_notification_email(array(
			"to_address"=>$to,
			"subject"=>"FreshersTV: E-mail Address Verified",
			"email_data"=>array(
				"msg"=>"Your e-mail address has been verified. This will become your login when your application has been accepted. You will be notified when this happens."
			)
		));
	}
	
	function send_account_activated_email($to)
	{
		$title = 'FreshersTV: Application Accepted and Account Activated';
		
		$body_html = $this->CI->load->view('emails/account_activated_email', array(), TRUE);
		$html = $this->CI->load->view('emails/page', array('title'=>$title, 'html'=>$body_html), TRUE);
		return $this->send($to, $title, $html);
	}
	
	function send_notification_email($data)
	{
		$title = 'FreshersTV: '.$data['subject'];
		
		$body_html = $this->CI->load->view('emails/notification_email', $data['email_data'], TRUE);
		$html = $this->CI->load->view('emails/page', array('title'=>$title, 'html'=>$body_html), TRUE);
		return $this->send($data['to_address'], $title, $html);
	}
		
	
	function send($to, $subject, $html)
	{
		$this->CI->load->library('email');
		$this->CI->email->initialize(array('mailtype'=>'html'));
		$this->CI->email->from($this->CI->config->item('automated_email'), $this->CI->config->item('automated_email_name'));
		$this->CI->email->to($to); 
					
		$this->CI->email->subject($subject);
		$this->CI->email->message($html);	
				
		return $this->CI->email->send();
	}

}