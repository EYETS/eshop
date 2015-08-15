<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
  * This is the product controller
  *
  * The product controller responsible for the CRUD functions for product
  *
  * @author Ebrahim Elsawy <elsawy_2020@hotmail.com>
  * @copyright 2015 Eng. Mahmoud Mosalam
  * @version 1.0
  */

class Product extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->global_model->config();
        $this->load->model('product_model');
        $this->load->library('form_validation');
    }

    /**
     * This method list all categories.
     *
     * @return void
     */
    function product_list() {
        //$this->global_model->have_permission('product_list');

        if (count($_POST) != 0) {
            $this->session->set_userdata('order_by', $this->input->post('order_by'));
            $this->session->set_userdata('order_type', $this->input->post('order_type'));
        }

        //start pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('product/product_list');
        $config['total_rows'] = $this->db->get('product')->num_rows();
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
        $data['rows'] = $this->product_model->getAll($config['per_page'], $this->uri->segment(3));
        $data['total_rows'] = $config['total_rows'];
        $data['main_content'] = 'product/product_list';
        $data['javascripts'] = $this->_javascript('product_list');
        $data['init'] = $this->_init();
        $data['breadcrumbs'] = array("المنتجات" => site_url('product/product_list'));
        $data['pageTitle'] = 'المنتجات';
        $this->load->view('includes/template', $data);
    }

    /**
     * This load add new product view if form_validation->run() == false 
	 * else it will insert the submitted data to product table and redirect to categories list.
     *
     * @return void
     */
    function product_add() {
        //$this->global_model->have_permission('product_add');

        $data['breadcrumbs'] = array("المنتجات" => site_url('product/product_list'), "أضافة منتج" => site_url('product/product_add'));
        $data['javascripts'] = $this->_javascript('product_list');
        $data['init'] = $this->_init();
        $data['main_content'] = 'product/product_add';
        $data['pageTitle'] = "أضافة منتج";
        $data['categories'] = $this->product_model->getAllCategories();

        $this->form_validation->set_rules('pro_title', 'أسم المنتج', 'required|strip_tags');
        $this->form_validation->set_rules('pro_short_desc', 'وصف قصير', 'required|strip_tags');
        $this->form_validation->set_rules('pro_desc', 'وصف المنتج', 'required|strip_tags');
        $this->form_validation->set_rules('pro_price', 'السعر', 'required|strip_tags');
        $this->form_validation->set_rules('cat_uid', 'القسم', 'required|strip_tags');

        if($this->form_validation->run() == FALSE) 
		{
            $this->load->view('includes/template', $data);
        } 
		else 
		{
            $this->product_model->add_action();
            redirect('product/product_list');
        }
    }
	
    /**
     * This load edit product view if form_validation->run() == false 
	 * else it will edit the submitted data to product row and redirect to product list.
    
     * @return void
     */
    function product_edit($id) {
        //$this->global_model->have_permission('product_edit');
        $data['row'] = $this->product_model->getByID($id);
        $data['breadcrumbs'] = array("المنتجات" => site_url('product/product_list'), "تعديل منتج" => site_url('product/product_edit/'. $data['row']->pro_uid));
        $data['javascripts'] = $this->_javascript('product_list');
        $data['init'] = $this->_init();
        $data['categories'] = $this->product_model->getAllCategories();

        $data['main_content'] = 'product/product_edit';
        $data['pageTitle'] = "تعديل منتج";

        $this->form_validation->set_rules('pro_title', 'أسم المنتج', 'required|strip_tags');
        $this->form_validation->set_rules('pro_short_desc', 'وصف قصير', 'required|strip_tags');
        $this->form_validation->set_rules('pro_desc', 'وصف المنتج', 'required|strip_tags');
        $this->form_validation->set_rules('pro_price', 'السعر', 'required|strip_tags');
        $this->form_validation->set_rules('cat_uid', 'القسم', 'required|strip_tags');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {
            $this->product_model->edit_action($id);
            redirect('product/product_list');
        }
    }

    /**
     * This method delete product.
     *
     * @return void
     */
    function product_del($id) {
        //$this->global_model->have_permission('product_del');
		$result = $this->global_model->delete_selected_items("product", "pro_uid", $id, false, false);
		if ($result == true) 
		{
			$this->messages->add("تم الحذف بنجاح....", "success");
        } 
		else 
		{
            $this->messages->add("لم تقم بالتحديد...", "error");
        }
        redirect("product/product_list/");
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
            case 'product_list':
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
                    "'" . base_url() . "../assets/global/plugins/ckeditor/ckeditor.js'",
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

