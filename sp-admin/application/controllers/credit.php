<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
  * This is the Credit controller
  *
  * The Users controller responsible for managing the users
  *
  * @author Ebrahim Elsawy <elsawy_2020@hotmail.com>
  * @copyright 2015 Eng. Mahmoud Mosalam
  * @version 1.0
  */
class Credit extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->global_model->config();
        $this->load->model('credit_model');
        $this->load->library('form_validation');
    }

    /**
     * This method list all credit requests sent by users from frontend.
     *
     * @return void
     */
    function credit_requests() {
        //$this->global_model->have_permission('credit_add');

        //start pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('credit/credit_requests');
        $config['total_rows'] = $this->db->get_where('credit_request', array('credit_request_statue' => 0))->num_rows();
        $config['per_page'] = $this->session->userdata('sitePerPagePagination');
        $config['num_links'] = 5;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = false;
        $config['full_tag_open'] = '<ul class="pagination">';
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
        $data['rows'] = $this->credit_model->getAll($config['per_page'], $this->uri->segment(3));
        $data['history'] = $this->credit_model->getCreditFullHistory();
        $data['javascripts'] = $this->_javascript("credit_list");
        $data['init'] = $this->_init();
        $data['breadcrumbs'] = array("إدارة الرصيد" => '#',"طلبات شحن الرصيد" => site_url('credit/credit_requests'));
        $data['main_content'] = 'credit/credit_requests';
        $data['pageTitle'] = 'طلبات شحن الرصيد';
        $this->load->view('includes/template', $data);
    }

    function credit_add() {
        //$this->global_model->have_permission('credit_add');
        $data['users'] = $this->credit_model->getAllUsers();

        $data['javascripts'] = $this->_javascript("credit_list");
        $data['init'] = $this->_init();
        $config['total_rows'] = $this->db->get_where('credit_request', array('credit_request_statue' => 0))->num_rows();
        $data['breadcrumbs'] = array("إدارة الرصيد" => '#', "إضافة رصيد" => site_url('credit/credit_add'));
        $data['main_content'] = 'credit/credit_add';
        $data['pageTitle'] = "إضافة رصيد";

        $this->form_validation->set_rules('user_uid', 'العضو المحول إليه', 'required|min_length[1]|strip_tags');
        $this->form_validation->set_rules('credit_amount', 'قيمة الرصيد', 'required|strip_tags');
        $this->form_validation->set_rules('credit_history_type', 'نوع العملية', 'required|min_length[1]|strip_tags');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {
            $this->credit_model->add_action();
            redirect('credit/credit_requests');
        }
    }

    function credit_add_from_request() {
        $this->global_model->have_permission('credit_add');
        $this->credit_model->add_action();
        $this->credit_model->changeRequestStatue($this->input->post('credit_request_uid'));
        redirect('credit/credit_requests');
    }

    function credit_add_from_main($id) {
        $this->global_model->have_permission('credit_add');
        $this->credit_model->addCreditByRequetId($id);
        redirect();
    }

    function credit_refuse_from_main($id) {
        $this->global_model->have_permission('credit_add');
        $this->credit_model->refuseCreditByRequetId($id);
        redirect();
    }

    function credit_refuse() {
        $this->global_model->have_permission('credit_add');
        $this->credit_model->add_action();
        $this->credit_model->changeRequestStatueRefused($this->input->post('credit_request_uid'));
        redirect('credit/credit_requests');
    }

    function credit_restore($ca_uid) {
        $this->global_model->have_permission('credit_add');
        $this->credit_model->restore_action($ca_uid);
        redirect('reports/reports_view/' . $ca_uid);
    }

    function credit_del() {
        $this->global_model->have_permission('credit_del');
        $id_arr = $this->input->post('delete');
//        var_dump($id_arr);
        if ($id_arr == true) {
            if (is_array($id_arr)) {
                foreach ($id_arr as $id) {

                    $result = $this->global_model->delete_selected_items("credit_request", "credit_request_uid", $id, FALSE, FALSE);
                }
            }
            if ($result == true) {
                $this->messages->add("تم الحذف بنجاح....", "success");
            }
        } else {
            $this->messages->add("لم تقم بالتحديد...", "error");
        }
        redirect("credit/credit_requests/");
    }

    public function credit_process() {
        $this->global_model->have_permission('credit_edit');

        if (isset($_POST['tnfez'])) {
            $id = $this->input->post('credit_request_uid');
            $this->credit_model->add_action();
            $this->credit_model->changeRequestStatue($this->input->post('credit_request_uid'));
            redirect('credit/credit_requests');
        } elseif (isset($_POST['delete'])) {

            $id = $this->input->post('credit_request_uid');
            $id_arr = $this->input->post('delete');
            if ($id_arr == true) {
                if (is_array($id_arr)) {
                    foreach ($id_arr as $id) {
                        $result = $this->global_model->delete_selected_items("credit", "credit_uid", $id, FALSE, FALSE);
                    }
                }
                if ($result == true) {
                    $this->messages->add("تم الحذف بنجاح....", "success");
                }
            } else {
                $this->messages->add("لم تقم بالتحديد...", "error");
            }
            redirect("credit/credit_requests");
        } else {

            $id = $this->input->post('credit_request_uid');
            $result = $this->global_model->delete_selected_items("credit_request", "credit_request_uid", $id, FALSE, FALSE);
            if ($result == true) {
                $this->messages->add("تم الحذف بنجاح....", "success");
            } else {
                $this->messages->add("لم تقم بالتحديد...", "error");
            }
            redirect("credit/credit_requests");
        }
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
            case 'credit_list':
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
                    "'" . base_url() . "../assets/global/plugins/bootstrap-select/bootstrap-select.min.js'",
                    "'" . base_url() . "../assets/global/plugins/select2/select2.min.js'",
                    "'" . base_url() . "../assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js'",
                    "'" . base_url() . "../assets/global/scripts/metronic.js'",
                    "'" . base_url() . "../assets/admin/layout/scripts/layout.js'",
                    "'" . base_url() . "../assets/admin/layout/scripts/quick-sidebar.js'",
                    "'" . base_url() . "../assets/admin/layout/scripts/demo.js'",
                    "'" . base_url() . "../assets/admin/pages/scripts/index.js'",
                    "'" . base_url() . "../assets/admin/pages/scripts/tasks.js'",
                    "'" . base_url() . "../assets/admin/pages/scripts/components-dropdowns.js'"
					
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
			"ComponentsDropdowns.init();"
		);
		return $init;
	}

}

