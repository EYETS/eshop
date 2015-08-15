<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
  * This is the Sender controller
  *
  * The Sender controller responsible for the CRUD functions for sender numbers
  *
  * @author Ebrahim Elsawy <elsawy_2020@hotmail.com>
  * @copyright 2015 Eng. Mahmoud Mosalam
  * @version 1.0
  */

class Sender extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->global_model->config();
        $this->load->model('sender_model');
        $this->load->library('form_validation');
    }

    /**
     * This method list all sender numbers.
     *
     * @return void
     */
    function sender_list() {
        //$this->global_model->have_permission('sender_list');

        if (count($_POST) != 0) {
            $this->session->set_userdata('order_by', $this->input->post('order_by'));
            $this->session->set_userdata('order_type', $this->input->post('order_type'));
        }

        //start pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('sender/sender_list');
        $config['total_rows'] = $this->db->get('senders')->num_rows();
        $config['per_page'] = $this->session->userdata('sitePerPagePagination');
        $config['num_links'] = 5;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = false;
        $config['full_tag_open'] = '<ul class="pagination margin-none">';
        $config['full_tag_close'] = '</div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '»';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['first_link'] = 'الأول';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['last_link'] = 'الأخير';
        $this->pagination->initialize($config);
        //end pagination
        $data['rows'] = $this->sender_model->getAll($config['per_page'], $this->uri->segment(3));
        $data['total_rows'] = $config['total_rows'];
        $data['main_content'] = 'sender/sender_list';
        $data['javascripts'] = $this->_javascript('sender_list');
        $data['init'] = $this->_init();
        $data['breadcrumbs'] = array("أرقام الأرسال" => site_url('sender/sender_list'));
        $data['pageTitle'] = 'أرقام الأرسال';
        $this->load->view('includes/template', $data);
    }

    /**
     * This load add new sender number view if form_validation->run() == false 
	 * else it will insert the submitted data to sender table and redirect to sender numbers list.
     *
     * @return void
     */
    function sender_add() {
        //$this->global_model->have_permission('sender_add');

        $data['breadcrumbs'] = array("أرقام الأرسال" => site_url('sender/sender_list'), "أضافة رقم" => site_url('sender/sender_add'));
        $data['javascripts'] = $this->_javascript('sender_list');
        $data['init'] = $this->_init();
        $data['main_content'] = 'sender/sender_add';
        $data['pageTitle'] = "أضافة رقم";

        $this->form_validation->set_rules('sender_number', 'الرقم', 'required|strip_tags');

        if($this->form_validation->run() == FALSE) 
		{
            $this->load->view('includes/template', $data);
        } 
		else 
		{
            $this->sender_model->add();
            redirect('sender/sender_list');
        }
    }
	
    /**
     * This load edit sender number view if form_validation->run() == false 
	 * else it will edit the submitted data to sender number row and redirect to sender number list.
     *
     * @return void
     */
    function sender_edit($id) {
        //$this->global_model->have_permission('sender_edit');
        $data['row'] = $this->sender_model->getByID($id);
        $data['breadcrumbs'] = array("أرقام الأرسال" => site_url('sender/sender_list'), "تعديل رقم" => site_url('sender/sender_edit/'. $data['row']->sender_uid));
        $data['javascripts'] = $this->_javascript('sender_list');
        $data['init'] = $this->_init();

        $data['main_content'] = 'sender/sender_edit';
        $data['pageTitle'] = "تعديل رقم";

        $this->form_validation->set_rules('sender_number', 'الرقم', 'required|strip_tags');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {
            $this->sender_model->edit_action($id);
            redirect('sender/sender_list');
        }
    }

    /**
     * This method delete sender number.
     *
     * @return void
     */
    function sender_del($id) {
        //$this->global_model->have_permission('sender_del');
		$result = $this->global_model->delete_selected_items("senders", "sender_uid", $id, false, false);
		if ($result == true) 
		{
			$this->messages->add("تم الحذف بنجاح....", "success");
        } 
		else 
		{
            $this->messages->add("لم تقم بالتحديد...", "error");
        }
        redirect("sender/sender_list/");
    }
	
	
    /**
     * This method create an array of required js plugins.
	 * by this way we can choose to load only the required plugins in  
	 * this page which will increase the performance of the application.
     *
     * @return $java array
     */
    function _javascript($view) {
        switch ($view) {
            case 'sender_list':
                $java = array(
                    "'" . base_url() . "../assets/global/plugins/jquery.min.js'",
                    "'" . base_url() . "../assets/global/plugins/jquery-migrate.min.js'",
                    "'" . base_url() . "../assets/global/plugins/jquery-ui/jquery-ui.min.js'",
                    "'" . base_url() . "../assets/global/plugins/bootstrap/js/bootstrap.min.js'",
                    "'" . base_url() . "../assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js'",
                    "'" . base_url() . "../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js'",
                    "'" . base_url() . "../assets/global/plugins/jquery.blockui.min.js'",
                    "'" . base_url() . "../assets/global/plugins/jquery.cokie.min.js'",
                    "'" . base_url() . "../assets/global/plugins/uniform/jquery.uniform.min.js'",
                    "'" . base_url() . "../assets/global/plugins/flot/jquery.flot.min.js'",
                    "'" . base_url() . "../assets/global/plugins/flot/jquery.flot.resize.min.js'",
                    "'" . base_url() . "../assets/global/plugins/flot/jquery.flot.categories.min.js'",
                    "'" . base_url() . "../assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js'",
                    "'" . base_url() . "../assets/global/plugins/jquery.sparkline.min.js'",
                    "'" . base_url() . "../assets/global/scripts/metronic.js'",
                    "'" . base_url() . "../assets/admin/layout/scripts/layout.js'",
                    "'" . base_url() . "../assets/admin/layout/scripts/quick-sidebar.js'",
                    "'" . base_url() . "../assets/admin/layout/scripts/demo.js'",
                    "'" . base_url() . "../assets/admin/pages/scripts/index.js'",
                    "'" . base_url() . "../assets/admin/pages/scripts/tasks.js'"
                );
                break;
        }
        return $java;
    }
	
    /**
     * This method create an array of required init js files.
     *
     * @return $init array
     */
    function _init() {
		$init = array(
			"Metronic.init();",
			"Layout.init();",
			"Demo.init();",
			"Index.init();",
			"Index.initCharts();",
			"Index.initMiniCharts();",
			"Tasks.initDashboardWidget();"
		);
		return $init;
	}

}

