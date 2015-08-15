<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



$CI =& get_instance();
$q = $CI->db->query("SELECT `siteProfileIdGanalytics`,`siteEmailGanalytics`,`sitePasswordGanalytics` FROM `config` WHERE `siteID` = 0");
if($q->num_rows() > 0) {
	$row = $q->row();
}

$config['profile_id']	= $row->siteProfileIdGanalytics; // GA profile id
$config['email']		= $row->siteEmailGanalytics; // GA Account mail
$config['password']		= $row->sitePasswordGanalytics; // GA Account password
$config['cache_data']	= false; // request will be cached
$config['cache_folder']	= '/cache'; // read/write
$config['clear_cache']	= array('date', '1 day ago'); // keep files 1 day
$config['debug']		= false; // print request url if true



