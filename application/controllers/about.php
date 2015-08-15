<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
  * This is the Pricing controller
  *
  * The Pricing controller responsible for displaying the price of our service
  * and the client can ask for credit from here if he is logged in or must login first
  *
  * @author Ebrahim Elsawy <elsawy_2020@hotmail.com>
  * @copyright 2015 Eng. Mahmoud Mosalam
  * @version 1.0
  */

class Pricing extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->global_model->config();
    }

    public function index() {

        $data['main_content'] = 'pricing_view';
        $data['pageTitle'] = 'الأسعار';
        $this->load->view('includes/template', $data);
    }

}

