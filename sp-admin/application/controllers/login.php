<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
  * This is the Login controller
  *
  * The Login controller responsible for displaying the login view if the user not logged in
  * and load main view if logged in
  *
  * @author Ebrahim Elsawy <elsawy_2020@hotmail.com>
  * @copyright 2015 Eng. Mahmoud Mosalam
  * @version 1.0
  */
  
class Login extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->global_model->config();
        $this->load->model('login_model');
        $this->load->library('form_validation');
        $this->load->helper('captcha');
    }

    public function index() {

        $session = $this->session->all_userdata();
        //Check if is loged in
        if (isset($session['is_logged_in']) && $session['is_logged_in'] == true) {
            redirect('main');
        }

        //Check if is set login error counter and > 3 times
        if (isset($session['error_login']) && $session['error_login'] > 3) {
            //create capatcha
            $vals = array(
                'img_path' => './captcha/',
                'img_url' => base_url() . 'captcha/',
                'img_width' => 120,
                'expiration' => 3600,
                'border' => 0,
                'img_height' => 30
            );
            $cap = create_captcha($vals);
            $data = array(
                'captcha_time' => $cap['time'],
                'ip_address' => $this->input->ip_address(),
                'word' => $cap['word']
            );

            $query = $this->db->insert_string('captcha', $data);
            $this->db->query($query);
            $data['cap'] = $cap;
            //load login view with capatcha
            $data['main_content'] = 'login/login_cap';
        } else {
            //load login view without capatcha
            $data['main_content'] = 'login/login';
        }
        //load javascript files
        //$data['javascripts'] = $this->_javascript();
        //set page title
        $data['pageTitle'] = 'تسجيل الدخول';
        //initialize the validation class
        $this->form_validation->set_rules('adminEmail', 'البريد الإلكترونى', 'required|strip_tags');
        $this->form_validation->set_rules('adminPwd', 'كلمة المرور', 'required|strip_tags');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {
            if (isset($session['error_login']) && $session['error_login'] > 3) {
                $check = $this->login_model->validate_cap();
                if ($check) {
                    redirect('main');
                } else {
                    $this->load->view('includes/template', $data);
                }
            } else {
                $check = $this->login_model->validate();
                if ($check) {
                    redirect('main');
                } else {
                    $this->load->view('includes/template', $data);
                }
            }
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

}

?>
