<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// THIS CONFIG FILE IS USED FOR BOTH THE MAIN AND ADMIN SITE!!!!

$config['automated_email']		= 'do-not-reply@freshers.tv';
$config['automated_email_name']	= 'FreshersTV Automated Support';
$config['admin_notification_email_address']	= "development@la1tv.co.uk; c.osborn@la1tv.co.uk; r.hughes@la1tv.co.uk";

$config['session_idle_time']	= 300; //minutes

$config['no_login_attempts_trigger']		= 5; // number of failed attempts that enforce a captcha
$config['no_login_attempts_remember_time']	= 5; // time in minutes before the system forgets a failed login

$config['applications_open']	= FALSE;
$config['map_enabled']	= TRUE;
$config['broadcasting_live']	= FALSE;
$config['load_balancer_url']	= "http://la1tv-wowza1.lancs.ac.uk:1935/loadbalancer?serverInfoXML";
$config['low_latency_stream_url']	= "rtmp://la1tv-wowza1.lancs.ac.uk/low-lat/FreshersTV";

// unix timestamp of planned start time
$config['broadcast_start_time']	= 1382634000;