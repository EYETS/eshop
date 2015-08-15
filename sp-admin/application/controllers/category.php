<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
  * This is the category controller
  *
  * The Category controller responsible for the CRUD functions for products category
  *
  * @author Ebrahim Elsawy <elsawy_2020@hotmail.com>
  * @copyright 2015 Eng. Mahmoud Mosalam
  * @version 1.0
  */

class Category extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->global_model->config();
        $this->load->model('category_model');
        $this->load->library('form_validation');
    }

    /**
     * This method list all categories.
     *
     * @return void
     */
    function category_list() {
        //$this->global_model->have_permission('category_list');

        if (count($_POST) != 0) {
            $this->session->set_userdata('order_by', $this->input->post('order_by'));
            $this->session->set_userdata('order_type', $this->input->post('order_type'));
        }

        //start pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('category/category_list');
        $config['total_rows'] = $this->db->get('category')->num_rows();
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
        $data['rows'] = $this->category_model->getAll($config['per_page'], $this->uri->segment(3));
        $data['total_rows'] = $config['total_rows'];
        $data['main_content'] = 'category/category_list';
        $data['javascripts'] = $this->_javascript('category_list');
        $data['init'] = $this->_init();
        $data['breadcrumbs'] = array("الأقسام" => site_url('category/category_list'));
        $data['pageTitle'] = 'الأقسام';
        $this->load->view('includes/template', $data);
    }

    /**
     * This load add new category view if form_validation->run() == false 
	 * else it will insert the submitted data to category table and redirect to categories list.
     *
     * @return void
     */
    function category_add() {
        //$this->global_model->have_permission('category_add');

        $data['breadcrumbs'] = array("الأقسام" => site_url('category/category_list'), "أضافة قسم" => site_url('category/category_add'));
        $data['javascripts'] = $this->_javascript('category_list');
        $data['init'] = $this->_init();
        $data['main_content'] = 'category/category_add';
        $data['pageTitle'] = "أضافة قسم";

        $this->form_validation->set_rules('cat_name', 'القسم', 'required|strip_tags');

        if($this->form_validation->run() == FALSE) 
		{
            $this->load->view('includes/template', $data);
        } 
		else 
		{
            $this->category_model->add();
            redirect('category/category_list');
        }
    }
	
    /**
     * This load edit category view if form_validation->run() == false 
	 * else it will edit the submitted data to category row and redirect to category list.
    
     * @return void
     */
    function category_edit($id) {
        //$this->global_model->have_permission('category_edit');
        $data['row'] = $this->category_model->getByID($id);
        $data['breadcrumbs'] = array("الأقسام" => site_url('category/category_list'), "تعديل قسم" => site_url('category/category_edit/'. $data['row']->cat_uid));
        $data['javascripts'] = $this->_javascript('category_list');
        $data['init'] = $this->_init();

        $data['main_content'] = 'category/category_edit';
        $data['pageTitle'] = "تعديل قسم";

        $this->form_validation->set_rules('cat_name', 'القسم', 'required|strip_tags');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {
            $this->category_model->edit_action($id);
            redirect('category/category_list');
        }
    }

    /**
     * This method delete category.
     *
     * @return void
     */
    function category_del($id) {
        //$this->global_model->have_permission('category_del');
		$result = $this->global_model->delete_selected_items("category", "cat_uid", $id, false, false);
		if ($result == true) 
		{
			$this->messages->add("تم الحذف بنجاح....", "success");
        } 
		else 
		{
            $this->messages->add("لم تقم بالتحديد...", "error");
        }
        redirect("category/category_list/");
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
            case 'category_list':
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

