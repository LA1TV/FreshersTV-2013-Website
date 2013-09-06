<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Send_email {

	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	
	function send_pass_reset($data)
	{
		$title = 'FreshersTV Password Reset Request';
		
		$body_html = $this->CI->load->view('emails/pass_reset', $data['email_data'], TRUE);
		$html = $this->CI->load->view('emails/page', array('title'=>$title, 'html'=>$body_html), TRUE);
		return $this->send($data['to_address'], $title, $html);
	}
	
	function send_activate_email($data)
	{
		$title = 'FreshersTV E-mail Verification Required';
		
		$body_html = $this->CI->load->view('emails/activate_email', $data['email_data'], TRUE);
		$html = $this->CI->load->view('emails/page', array('title'=>$title, 'html'=>$body_html), TRUE);
		return $this->send($data['to_address'], $title, $html);
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