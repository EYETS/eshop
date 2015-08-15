<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
  * This is the Contact controller
  *
  * The Contact controller responsible for displaying the contact us information
  * and the client can send an email to our company if he want to ask for something not clear
  *
  * @author Ebrahim Elsawy <elsawy_2020@hotmail.com>
  * @copyright 2015 Eng. Mahmoud Mosalam
  * @version 1.0
  */

class Contact extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->global_model->config();
        $this->load->model('global_model');
        $this->load->helper('captcha');
        $this->load->library('form_validation');
    }

    public function index() {

        $this->form_validation->set_rules('con_name', 'الأسم بالكامل', 'required|strip_tags');
        $this->form_validation->set_rules('con_email', 'البريد الإلكترونى', 'required|valid_email|strip_tags');
        $this->form_validation->set_rules('con_msg', 'محتوى الرسالة', 'required|strip_tags');
        $data['main_content'] = 'contact_view';
        $data['pageTitle'] = 'اتصل بنا';
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {
            $this->global_model->send_contactus_action();
            redirect('contact');
        }
    }


}

