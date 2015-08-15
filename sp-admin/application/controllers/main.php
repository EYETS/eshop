<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
  * This is the Main controller
  *
  * The Main controller responsible for displaying the dashboard view
  *
  * @author Ebrahim Elsawy <elsawy_2020@hotmail.com>
  * @copyright 2015 Eng. Mahmoud Mosalam
  * @version 1.0
  */

class Main extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->global_model->config();
        $this->load->model('login_model');
        $this->load->library('form_validation');
        $this->load->helper('captcha');
    }

    /**
     * This method load the dashboard view.
     *
     * @return void
     */
    public function index() {
        $data['breadcrumbs'] = array("الرئيسية" => site_url('main'));
        $data['main_content'] = 'main/dashboard';
        $data['pageTitle'] = 'الرئيسية';
        $data['javascripts'] = $this->_javascript('main');
        $data['init'] = $this->_init();
        $this->load->view('includes/template', $data);
    }
	
    /**
     * This method create an array of required js plugins.
     *
     * @return $java array
     */
    function _javascript($view) {
        switch ($view) {
            case 'main':
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