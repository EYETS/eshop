<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  * This is the Offline controller
  *
  * The Offline controller responsible for displaying the offline template if the admin 
  * set the web site to closed.
  *
  * @author Ebrahim Elsawy <elsawy_2020@hotmail.com>
  * @copyright 2015 Eng. Mahmoud Mosalam
  * @version 1.0
  */

class Offline extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->global_model->config_offline();
	}
	
	function index()
	{
			$this->load->view('site_offline');
			$this->CI =& get_instance(); 
			$this->CI->output->_display();
			die();
	}	

}
