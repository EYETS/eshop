<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  * This is the Error controller
  *
  * The Error controller responsible for displaying error page when the user trying to 
  * access a page which is not allowed to him to go throw or if the page not found
  *
  * @author Ebrahim Elsawy <elsawy_2020@hotmail.com>
  * @copyright 2015 Eng. Mahmoud Mosalam
  * @version 1.0
  */

class Error extends CI_Controller {

	public function index()
	{
		$data['main_content'] = 'no_data';
		$data['pageTitle'] = 'عفواً لم يتم العثور على الصفحة برجاء التأكد والمحاولة مرة أخرى.';
		$this->load->view('includes/template', $data);
	}
	
	public function no_data()
	{
		$data['main_content'] = 'error_pages/dont_have_permission_view';
		$data['pageTitle'] = 'ليس لديك صلاحية لهذا القسم';
		$this->load->view('includes/template', $data);

	}
	
	

}

