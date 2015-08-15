<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MX_Controller {

	public function index()
	{
		return $this->load->view('test_view','',true);
	}
}

