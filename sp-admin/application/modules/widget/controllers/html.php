<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Html extends MX_Controller {

	public function index()
	{
		return $this->load->view('html_view','',true);
	}
}

