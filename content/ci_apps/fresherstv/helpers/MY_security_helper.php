<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function htmlent($string, $encoding='utf-8')
{
	return htmlspecialchars($string, ENT_QUOTES, $encoding);
}
