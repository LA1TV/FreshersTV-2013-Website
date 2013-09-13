<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// THIS CONFIG FILE IS USED FOR BOTH THE MAIN AND ADMIN SITE!!!!

$config['automated_email']		= 'do-not-reply@freshers.tv';
$config['automated_email_name']	= 'FreshersTV Automated Support';
$config['admin_notification_email_address']	= 'exec@la1tv.co.uk';

$config['session_idle_time']	= 30; //minutes

$config['no_login_attempts_trigger']		= 5; // number of failed attempts that enforce a captcha
$config['no_login_attempts_remember_time']	= 5; // time in minutes before the system forgets a failed login
