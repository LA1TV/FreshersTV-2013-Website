<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function format_date($timestamp)
{
	return date("d-m-Y", $timestamp)." at ".date("H:i", $timestamp);
}
