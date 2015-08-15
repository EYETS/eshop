<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
  * This is the Home controller
  *
  * The Home controller responsible for displaying the home page view
  *
  * @author Ebrahim Elsawy <elsawy_2020@hotmail.com>
  * @copyright 2015 Eng. Mahmoud Mosalam
  * @version 1.0
  */
  
class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->global_model->config();
    }

    public function index() {
        $data['main_content'] = 'home_view';
        $data['pageTitle'] = 'الرئيسية';
        $this->load->view('includes/template', $data);
    }

}

