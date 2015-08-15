<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
  * This is the Users controller
  *
  * The Users controller responsible for managing the users
  *
  * @author Ebrahim Elsawy <elsawy_2020@hotmail.com>
  * @copyright 2015 Eng. Mahmoud Mosalam
  * @version 1.0
  */

class Users extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->global_model->config();
        $this->load->model('users_model');
        $this->load->library('form_validation');
		
    }

    /**
     * This method search for user by mobile number.
     *
     * @return void
     */
    function users_search() {
        $this->global_model->have_permission('users_search');
        if (count($_POST) != 0) {
            $searchWord = $this->input->post("searchWord");

            $data['row'] = $this->users_model->userSearchBy($searchWord);
            if ($data['row'] == false) {
                //redirect('error/no_data');
            }
        }
        $data['javascripts'] = $this->_javascript('user_list');
        $data['breadcrumbs'] = array("الأعضاء" => site_url('users/users_list'));
        $data['main_content'] = 'users/users_search';
        $data['pageTitle'] = 'البحث عن عضو';
        $this->load->view('includes/template', $data);
    }

    /**
     * This method list all Not active users.
     *
     * @return void
     */
    function users_not_active() {
        //$this->global_model->have_permission('client');
        //start pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('users/users_not_active');
        $config['total_rows'] = $this->db->get_where('dx_users', array('group_uid !=' => 1, 'user_actived' => 0, 'user_banned' => 0))->num_rows();
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
        $data['rows'] = $this->users_model->getAllNotActive($config['per_page'], $this->uri->segment(3));
        $data['javascripts'] = $this->_javascript('user_list');
        $data['init'] = $this->_init();
        $data['breadcrumbs'] = array("إدارة الأعضاء" => '#', "الأعضاء غير المفعلين" => site_url('users/users_not_active'));
        $data['main_content'] = 'users/users_list';
        $data['pageTitle'] = 'الأعضاء غير المفعلين';
        $this->load->view('includes/template', $data);
    }
	
    /**
     * This method list all active users.
     *
     * @return void
     */
    function users_active() {
        //$this->global_model->have_permission('client');
        //start pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('users/users_active');
        $config['total_rows'] = $this->db->get_where('dx_users', array('group_uid !=' => 1, 'user_actived' => 1, 'user_banned' => 0))->num_rows();
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
        $data['rows'] = $this->users_model->getAllActive($config['per_page'], $this->uri->segment(3));
        if ($data['rows'] == false) {
            //redirect('error/no_data');
        }
        $data['javascripts'] = $this->_javascript('user_list');
        $data['init'] = $this->_init();
        $data['breadcrumbs'] = array("إدارة الأعضاء" => '#', "الأعضاء المفعلين" => site_url('users/users_active'));
        $data['main_content'] = 'users/users_list';
        $data['pageTitle'] = 'الأعضاء المفعلين';
        $this->load->view('includes/template', $data);
    }
	
    /**
     * This method list all Banned users.
     *
     * @return void
     */
    function users_banned() {
        //$this->global_model->have_permission('users_list');
        //start pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('users/users_banned');
        $config['total_rows'] = $this->db->get_where('dx_users', array('user_banned' => 1))->num_rows();
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
        $data['rows'] = $this->users_model->getAllBanned($config['per_page'], $this->uri->segment(3));
        if ($data['rows'] == false) {
            //redirect('error/no_data');
        }
        $data['javascripts'] = $this->_javascript('user_list');
        $data['init'] = $this->_init();
        $data['breadcrumbs'] = array("إدارة الأعضاء" => '#', "الأعضاء المحظورين" => site_url('users/users_banned'));
        $data['main_content'] = 'users/users_list';
        $data['pageTitle'] = 'الأعضاء المحظورين';
        $this->load->view('includes/template', $data);
    }
	
    /**
     * This method list all Admins.
     *
     * @return void
     */
    function admins_list() {
        //$this->global_model->have_permission('users_list');
        //start pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('users/admins_list');
        $config['total_rows'] = $this->db->get_where('dx_users', array('group_uid' => 1))->num_rows();
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
        $data['rows'] = $this->users_model->getAllAdmins($config['per_page'], $this->uri->segment(3));
        $data['total_rows'] = $config['total_rows'];
        $data['javascripts'] = $this->_javascript('user_list');
        $data['init'] = $this->_init();
        $data['breadcrumbs'] = array("المديرين" => site_url('users/admins_list'));
        $data['main_content'] = 'users/users_list';
        $data['pageTitle'] = 'المديرين';
        $this->load->view('includes/template', $data);
    }
	
    /**
     * This load add new user view if form_validation->run() == false 
	 * else it will insert the submitted data to users table and redirect to users list.
     *
     * @return void
     */
    function users_add() {
        //$this->global_model->have_permission('users_add');
        $data['javascripts'] = $this->_javascript('user_list');
        $data['init'] = $this->_init();
        $data['breadcrumbs'] = array("إدارة الأعضاء" => '#', "أضافة عضو" => site_url('users/users_add'));
        $data['main_content'] = 'users/users_add';
        $data['pageTitle'] = "أضافة عضو";
        $data['countries'] = $this->users_model->getAllCountries();
        $data['groups'] = $this->users_model->getAllGroups();

        $this->form_validation->set_rules('user_full_name', 'الأسم بالكامل', 'required|strip_tags');
        $this->form_validation->set_rules('user_uname', 'أسم المستخدم', 'required|is_unique[dx_users.user_uname]|strip_tags');
        $this->form_validation->set_rules('user_pwd', 'كلمة المرور', 'required|strip_tags');
        $this->form_validation->set_rules('user_pwd1', 'تأكيد كلمة المرور', 'required|matches[user_pwd]|strip_tags');
        $this->form_validation->set_rules('user_email', 'البريد الإلكترونى', 'required|is_unique[dx_users.user_email]|valid_email|strip_tags');
        $this->form_validation->set_rules('user_actived', 'حالة التفعيل', 'strip_tags');
        $this->form_validation->set_rules('user_banned', 'حالة الحظر', 'strip_tags');
        $this->form_validation->set_rules('group_uid', 'المجموعة', 'required|strip_tags');
        $this->form_validation->set_rules('country_uid', 'الدولة', 'required|strip_tags');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {
            $this->users_model->add_action();

            if (isset($_POST['user_banned']))
			{
                redirect('users/users_banned');
			}
            else if (isset($_POST['user_actived'])) 
			{
                if ($_POST['group_uid'] == 1)
				{
                    redirect('users/admins_list');
				}
				else
				{
                    redirect('users/users_active');
				}
			}
            else if (isset($_POST['user_banned']))
			{
                redirect('users/users_banned');
			}
			else
			{
                redirect('users/users_active');
            }
        }
    }
	
    /**
     * This load edit user view if form_validation->run() == false 
	 * else it will edit the submitted data to users row and redirect to users list.
     *
     * @return void
     */
    function users_edit($id) {
        //$this->global_model->have_permission('users_edit');
        $data['groups'] = $this->users_model->getAllGroups();
        $data['row'] = $this->users_model->getByID($id);
        $data['countries'] = $this->users_model->getAllCountries();
        $this->row = $data['row'];
        if ($data['row'] == true) {
            $data['profile'] = $this->users_model->getProfileByID($data['row']->user_uid);
        }
        $data['javascripts'] = $this->_javascript('user_list');
        $data['init'] = $this->_init();
        $data['breadcrumbs'] = array("الأعضاء" => site_url('users/users_list'), "تعديل بيانات العضو ( " . $data['row']->user_full_name . " )" => site_url('users/users_view/' . $data['row']->user_uid));
        $data['main_content'] = 'users/users_edit';
        $data['pageTitle'] = "تعديل عضو ( " . $data['row']->user_full_name . " )";

        $this->form_validation->set_rules('user_full_name', 'الأسم بالكامل', 'required|strip_tags');
        $this->form_validation->set_rules('user_uname', 'أسم المستخدم', 'required|strip_tags');
        $this->form_validation->set_rules('user_pwd', 'كلمة المرور', 'strip_tags');
        $this->form_validation->set_rules('user_pwd1', 'تأكيد كلمة المرور', 'matches[user_pwd]|strip_tags');
        $this->form_validation->set_rules('user_email', 'البريد الإلكترونى', 'required|valid_email|strip_tags');
        $this->form_validation->set_rules('user_actived', 'حالة التفعيل', 'strip_tags');
        $this->form_validation->set_rules('user_banned', 'حالة الحظر', 'strip_tags');
        $this->form_validation->set_rules('group_uid', 'المجموعة', 'required|strip_tags');
        $this->form_validation->set_rules('country_uid', 'الدولة', 'required|strip_tags');
        $this->form_validation->set_rules('profile_about', '', 'strip_tags');
        $this->form_validation->set_rules('profile_facebook', '', 'strip_tags');
        $this->form_validation->set_rules('profile_twitter', '', 'strip_tags');
        $this->form_validation->set_rules('profile_google', '', 'strip_tags');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/template', $data);
        } else {
            $this->users_model->edit_action($id);
            if (isset($_POST['user_banned']))
                redirect('users/users_banned');

            else if (isset($_POST['user_actived'])) {
                if ($_POST['group_uid'] == 1)
                    redirect('users/admins_list');
                else
                    redirect('users/users_active');
            }
            else if (isset($_POST['user_banned']))
                redirect('users/users_banned');
            else {
                redirect('users/users_active');
            }
        }
    }


    function users_del($id) {
        //$this->global_model->have_permission('users_del');
        $result = $this->global_model->delete_selected_items("dx_users", "user_uid", $id, 'dx_profiles', 'user_uid');
        if ($result == true) {
            $this->messages->add("تم الحذف بنجاح.", "success");
        } else {
            $this->messages->add("لم تقم بالتحديد.", "error");
        }
		redirect("users/users_active");
    }

    /**
     * This method export all users detailes in Excel file.
     *
     * @return void
     */
    function users_all_export() {
        //$this->global_model->have_permission('users_edit');

        $query = $this->users_model->getAllToExport();

        $this->load->library('excel');
        $this->excel->getActiveSheet()->setTitle('test worksheet');
        $count = $query->num_rows();
        $this->excel->getActiveSheet()
                ->getColumnDimension('A')
                ->setWidth(15);
        $this->excel->getActiveSheet()
                ->getColumnDimension('B')
                ->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $this->excel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('0000000');


        $this->excel->getActiveSheet()->setCellValue('A' . 1, 'أسم المستخدم');
        $this->excel->getActiveSheet()->setCellValue('B' . 1, 'رقم التليفون');
        $this->excel->getActiveSheet()->setCellValue('C' . 1, 'الحالة');
        $this->excel->getActiveSheet()->setCellValue('D' . 1, 'البريد الإلكترونى');
        $this->excel->getActiveSheet()->setCellValue('E' . 1, 'آخر IP');
        $this->excel->getActiveSheet()->setCellValue('F' . 1, 'تاريخ آخر دخول');
        $this->excel->getActiveSheet()->setCellValue('G' . 1, 'عدد النقاط');
        $this->excel->getActiveSheet()->setCellValue('H' . 1, 'عدد المجموعات');

        $i = 2;
        foreach ($query->result() as $row => $res) {

            $UserGroupCount = $this->db->get_where('users_groups', array('user_uid' => $res->user_uid))->num_rows();

            $this->excel->getActiveSheet()->setCellValue('A' . $i, $res->user_full_name);
            $this->excel->getActiveSheet()->setCellValue('B' . $i, $res->user_uname);
            if ($res->user_actived == 1)
                $this->excel->getActiveSheet()->setCellValue('C' . $i, 'active');
            else if ($res->user_actived == 0)
                $this->excel->getActiveSheet()->setCellValue('C' . $i, 'not active');
            if ($res->user_banned == 1)
                $this->excel->getActiveSheet()->setCellValue('C' . $i, 'banned');
//            else
//                $this->excel->getActiveSheet()->setCellValue('D' . $i, 'not banned');
//            $this->excel->getActiveSheet()->setCellValue('E' . $row, $res->group_uid);

            $this->excel->getActiveSheet()->setCellValue('D' . $i, $res->user_email);
            $this->excel->getActiveSheet()->setCellValue('E' . $i, $res->user_last_ip);
            $this->excel->getActiveSheet()->setCellValue('F' . $i, $res->user_last_login);
            $this->excel->getActiveSheet()->setCellValue('G' . $i, $this->users_model->getCreditByID($res->user_uid));
            $this->excel->getActiveSheet()->setCellValue('H' . $i, $UserGroupCount);
            $i++;
        }
//        $row++;
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $filename = time() . "-all.xlsx"; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
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
            case 'user_list':
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

