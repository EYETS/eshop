<?php

class Users_model extends CI_Model {

    function getBy($key, $value) {
        $query = $this->db->get_where('dx_users', array($key => $value));
        return ($query->num_rows()) ? array_shift($query->result()) : false;
    }

    function userCampaign($id) {
        $this->db->order_by("ca_uid", "desc");
        $this->db->where('ca_user_uid', $id);
        $result = $this->db->get('campaign', 15);
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }

    function userSearchBy($value) {
        $this->db->where('user_email', $value);
        $this->db->or_where('user_uname', $value);
        $query = $this->db->get('dx_users');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->user_uid;
        } else {
            return false;
        }
    }

    function activate($user) {
        $this->db->where('user_uid', $user->user_uid);
        $this->db->update('dx_users', array('user_actived' => 1));
    }

    function ban($user) {
        $this->db->where('user_uid', $user->user_uid);
        $this->db->update('dx_users', array('user_banned' => 1));
    }

    function unban($user) {
        $this->db->where('user_uid', $user->user_uid);
        $this->db->update('dx_users', array('user_banned' => 0));
    }

    function getAll($limit, $offsit) {
        $array = array('user_uid', 'user_full_name', 'user_uname', 'user_actived', 'user_banned', 'group_uid');
        if ($this->session->userdata('order_by') != '' && in_array($this->session->userdata('order_by'), $array, true)) {
            $this->db->order_by($this->session->userdata('order_by'), $this->session->userdata('order_type'));
        } else {
            $this->session->unset_userdata('order_by');
            $this->session->unset_userdata('order_type');
            $this->db->order_by("user_uid", "desc");
        }
        $this->db->where('group_uid !=', 1);
        $q = $this->db->get('dx_users', $limit, $offsit);

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $row->group_count = $this->db->get_where('users_groups', array('user_uid' => $row->user_uid))->num_rows();
                $data[] = $row;
            }
            foreach ($data as $r) {
                $group_uid = $r->group_uid;
                $m = $this->db->query("SELECT group_name FROM dx_groups WHERE group_uid = $group_uid");
                if ($m->num_rows() > 0) {
                    foreach ($m->result() as $mrow) {
                        $r->group_uid = $mrow->group_name;
                    }
                }
            }
            return $data;
        } else {
            return false;
        }
    }

    function getAllAdmins($limit, $offsit) {
        $this->db->where('group_uid', 1);
        $q = $this->db->get('dx_users', $limit, $offsit);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $row->group_count = $this->db->get_where('users_groups', array('user_uid' => $row->user_uid))->num_rows();
                $data[] = $row;
            }
            foreach ($data as $r) {
                $group_uid = $r->group_uid;
                $m = $this->db->query("SELECT group_name FROM dx_groups WHERE group_uid = $group_uid");
                if ($m->num_rows() > 0) {
                    foreach ($m->result() as $mrow) {
                        $r->group_uid = $mrow->group_name;
                    }
                }
            }
            return $data;
        } else {
            return false;
        }
    }

    function getAllNotActive($limit, $offsit) {
        $this->db->where('user_actived', 0);
        $this->db->where('user_banned', 0);
        $this->db->where('group_uid !=', 1);

        $q = $this->db->get('dx_users', $limit, $offsit);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $row->group_count = $this->db->get_where('users_groups', array('user_uid' => $row->user_uid))->num_rows();
                $data[] = $row;
            }
            foreach ($data as $r) {
                $group_uid = $r->group_uid;
                $m = $this->db->query("SELECT group_name FROM dx_groups WHERE group_uid = $group_uid");
                if ($m->num_rows() > 0) {
                    foreach ($m->result() as $mrow) {
                        $r->group_uid = $mrow->group_name;
                    }
                }
            }
            return $data;
        } else {
            return false;
        }
    }

    function getAllActive($limit, $offsit) {
        $this->db->where('user_actived', 1);
        $this->db->where('user_banned', 0);
        $this->db->where('group_uid !=', 1);

        $q = $this->db->get('dx_users', $limit, $offsit);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $row->group_count = $this->db->get_where('users_groups', array('user_uid' => $row->user_uid))->num_rows();
                $data[] = $row;
            }
            foreach ($data as $r) {
                $group_uid = $r->group_uid;
                $m = $this->db->query("SELECT group_name FROM dx_groups WHERE group_uid = $group_uid");
                if ($m->num_rows() > 0) {
                    foreach ($m->result() as $mrow) {
                        $r->group_uid = $mrow->group_name;
                    }
                }
            }
            return $data;
        } else {
            return false;
        }
    }

    function getAllBanned($limit, $offsit) {
        $this->db->where('user_banned', 1);

        $q = $this->db->get('dx_users', $limit, $offsit);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $row->group_count = $this->db->get_where('users_groups', array('user_uid' => $row->user_uid))->num_rows();
                $data[] = $row;
            }
            foreach ($data as $r) {
                $group_uid = $r->group_uid;
                $m = $this->db->query("SELECT group_name FROM dx_groups WHERE group_uid = $group_uid");
                if ($m->num_rows() > 0) {
                    foreach ($m->result() as $mrow) {
                        $r->group_uid = $mrow->group_name;
                    }
                }
            }
            return $data;
        } else {
            return false;
        }
    }

    function getAllGroups() {
        $this->db->order_by("group_uid", "desc");
        $q = $this->db->get('dx_groups');
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }

    function getAllCountries() {
        $this->db->order_by("countryID", "desc");
        $q = $this->db->get('country');
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }

    function add_action() {

        //$config['upload_path'] = USERS_FILES;
        //$config['allowed_types'] = 'gif|jpg|jpeg|png';
        //$config['encrypt_name'] = TRUE;
        //$this->load->library('upload', $config);
        //if ( !$this->upload->do_upload())
        //{
//            $this->messages->add($this->upload->display_errors()." وتم تعيين الصورة الأفتراضية للعضو", "alert");
        $this->messages->add(" وتم تعيين الصورة الأفتراضية للعضو", "alert");
        $profile_img = 'default.jpg';
        //}
        //else
//		{
//			$fInfo = $this->upload->data();
//			$this->_createThumbnail($fInfo['file_name']); 
//			$profile_img = $fInfo['profile_img'];
//		}

        $user_full_name = $this->input->post('user_full_name');
        $user_uname = $this->input->post('user_uname');
        $user_pwd = $this->input->post('user_pwd');
        $country_uid = $this->input->post('country_uid');

        $user_pwd = md5($user_pwd);
        $user_email = $this->input->post('user_email');
        $user_actived = $this->input->post('user_actived');
        $user_banned = $this->input->post('user_banned');
        $user_ban_reason = $this->input->post('user_ban_reason');
        $group_uid = $this->input->post('group_uid');

        $profile_about = $this->input->post('profile_about');
        $profile_facebook = $this->input->post('profile_facebook');
        $profile_twitter = $this->input->post('profile_twitter');
        $profile_google = $this->input->post('profile_google');


        $data = array(
            'user_full_name' => $user_full_name,
            'user_uname' => $user_uname,
            'user_pwd' => $user_pwd,
            'user_email' => $user_email,
            'user_actived' => $user_actived,
            'user_banned' => $user_banned,
            'user_ban_reason' => $user_ban_reason,
            'group_uid' => $group_uid,
            'country_uid' => $country_uid
        );
        $this->db->insert('dx_users', $data);

        $user_uid = $this->db->insert_id();

        $data = array(
            'user_uid' => $user_uid,
            'profile_img' => $profile_img,
            'profile_about' => $profile_about,
            'profile_facebook' => $profile_facebook,
            'profile_twitter' => $profile_twitter,
            'profile_google' => $profile_google
        );
        $this->db->insert('dx_profiles', $data);

        $data = array(
            'user_uid' => $user_uid,
            'credit_amount' => $this->session->userdata('siteDefaultCredit')
        );
        $this->db->insert('credit', $data);

        if ($this->db->affected_rows() > 0) {
            $this->messages->add("لقد تم أضافة العضو بنجاح.", "success");
        } else {
            $this->messages->add("لقد حدث خطأ أثناء الأضافة.", "error");
        }
    }

    function getByID($id) {
        $q = $this->db->get_where('dx_users', array('user_uid' => $id));
        if ($q->num_rows() > 0) {
            $row = $q->row();
            $group_uid = $row->group_uid;
//            $row->country = $this->db->query("SELECT countryName FROM country WHERE countryID = $row->country_uid");
            $m = $this->db->query("SELECT group_name FROM dx_groups WHERE group_uid = $group_uid");
            if ($m->num_rows() > 0) {
                foreach ($m->result() as $mrow) {

                    $row->group_uid = $mrow->group_name;
                }
            }
            return $row;
        } else {
            return false;
        }
    }

    function userCountry($id) {
        $country_uid = $this->db->query("SELECT country_uid FROM dx_users WHERE user_uid = $id")->row();
        $countryName = $this->db->query("SELECT countryName FROM country WHERE countryID = $country_uid->country_uid")->row();
        if ($this->db->affected_rows() > 0) {
            return $countryName->countryName;
        } else {
            return false;
        }
    }

    function getProfileByID($id) {
        $q = $this->db->get_where('dx_profiles', array('user_uid' => $id));
        if ($q->num_rows() > 0) {
            $row = $q->row();
            return $row;
        } else {
            return false;
        }
    }

    function getCreditByID($id) {
        $q = $this->db->get_where('credit', array('user_uid' => $id));
        if ($q->num_rows() > 0) {
            $row = $q->row();
            return $row->credit_amount;
        } else {
            return 0;
        }
    }

    function edit_action($id) {

        //		$config['upload_path'] = USERS_FILES;
        //		$config['allowed_types'] = 'gif|jpg|jpeg|png';
        //		$config['encrypt_name'] = TRUE;
        //		$this->load->library('upload', $config);
        //		if ( !$this->upload->do_upload())
        //		{
        //			$this->messages->add("لم تقوم برفع صورة جديدة.", "alert");
        //	$profile_img = $this->input->post('profile_img');
        //}
        //else
        //		//{
        //			$fInfo = $this->upload->data();
        //			$this->_createThumbnail($fInfo['file_name']); 
        //			$profile_img = $fInfo['file_name'];
        //		}

        $user_full_name = $this->input->post('user_full_name');
        $user_uname = $this->input->post('user_uname');
        $user_pwd = $this->input->post('user_pwd');
        $user_email = $this->input->post('user_email');
        $user_actived = $this->_if_null_input($this->input->post('user_actived'));
        $user_banned = $this->_if_null_input($this->input->post('user_banned'));
        $user_ban_reason = $this->input->post('user_ban_reason');
        $group_uid = $this->input->post('group_uid');
        $country_uid = $this->input->post('country_uid');

        $profile_about = $this->input->post('profile_about');
        $profile_facebook = $this->input->post('profile_facebook');
        $profile_twitter = $this->input->post('profile_twitter');
        $profile_google = $this->input->post('profile_google');

        if ($user_pwd != null) {
            $user_pwd = md5($user_pwd);
            $data = array(
                'user_full_name' => $user_full_name,
                'user_uname' => $user_uname,
                'user_pwd' => $user_pwd,
                'user_email' => $user_email,
                'user_actived' => $user_actived,
                'user_banned' => $user_banned,
                'user_ban_reason' => $user_ban_reason,
                'group_uid' => $group_uid,
                'country_uid' => $country_uid
            );
        } else {
            $data = array(
                'user_full_name' => $user_full_name,
                'user_uname' => $user_uname,
                'user_email' => $user_email,
                'user_actived' => $user_actived,
                'user_banned' => $user_banned,
                'user_ban_reason' => $user_ban_reason,
                'group_uid' => $group_uid
            );
        }


        $this->db->where('user_uid', $id);
        $this->db->update('dx_users', $data);
        if ($this->db->affected_rows() > 0) {
            $this->messages->add("لقد تم تحديث بيانات العضو بنجاح.", "success");
        }

        $data = array(
            //					   'profile_img' => $profile_img,
            'profile_about' => $profile_about,
            'profile_facebook' => $profile_facebook,
            'profile_twitter' => $profile_twitter,
            'profile_google' => $profile_google
        );

        $this->db->where('user_uid', $id);
        $this->db->update('dx_profiles', $data);

        if ($this->db->affected_rows() > 0) {
            $this->messages->add("لقد تم تحديث الملف الشخصى بنجاح.", "success");
        } else {
            //$this->messages->add("لم تقوم بتغيير بيانات العضو.", "alert");
        }
    }

    function _if_null_input($input) {
        if ($input == null) {
            $input = 0;
        }
        return $input;
    }

    function _createThumbnail($fileName) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = USERS_FILES . $fileName;
        $config['create_thumb'] = false;
        $config['new_image'] = 'thumb_' . $fileName;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 100;
        $config['height'] = 100;
        $this->load->library('image_lib', $config);
        if (!$this->image_lib->resize()) {
            $this->messages->add($this->image_lib->display_errors(), "error");
        }
    }

    function getAllToExport() {
        $result = $this->db->get('dx_users');
        return $result;
    }

    function getAllUserMail($type) {
        $this->db->select('user_email');
        $result = $this->db->get('dx_users')->result();

        foreach ($result as $row) {
            $data[] = $row->user_email;
        }
//        json_decode($data, true);
        return $data;
    }

    function getSelectedUserMail() {
        $this->db->select('user_email');

        if (isset($_POST['active_users_check'])) {
            $this->db->or_where('user_actived', 1);
            $this->db->where('group_uid !=', 1);
        }
        if (isset($_POST['ban_users_check'])) {
            $this->db->or_where('user_banned', 1);
        }
        if (isset($_POST['nonactive_users_check'])) {
            $this->db->or_where('user_actived', 0);
            $this->db->where('group_uid !=', 1);
        }

        $result = $this->db->get('dx_users')->result();

        foreach ($result as $row) {
            $data[] = $row->user_email;
        }
//        json_decode($data, true);
        return $data;
    }

    function getSelectedUserNumbers() {
        $this->db->select('user_uname');
//        $this->db->where('1', 1);
        if (isset($_POST['active_users_check'])) {
            $this->db->or_where('user_actived', 1);
        }
        if (isset($_POST['ban_users_check'])) {
            $this->db->or_where('user_banned', 1);
        }
        if (isset($_POST['nonactive_users_check'])) {
            $this->db->or_where('user_actived', 0);
        }

        $result = $this->db->get('dx_users')->result();

        foreach ($result as $row) {
            $data[] = $row->user_uname;
        }
//        json_decode($data, true);
        return $data;
    }

    function getAllAdsGroups() {
        $this->db->order_by("ads_group_uid", "desc");
        $q = $this->db->get('ads_groups');
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }

    function user_assign_group($data) {
        $this->db->insert('ads_groups_users', $data);
        $this->messages->add("تم تخصيص المجموعة بنجاح", "success");
    }

    function userCampaignCount($id) {
        $q = $this->db->get_where('campaign', array('ca_user_uid' => $id));
        return $q->num_rows();
    }

    function userTicketsCount($id) {
        $q = $this->db->get_where('tickets', array('user_uid' => $id));
        return $q->num_rows();
    }

    function userCreditReqCount($id) {
        $q = $this->db->get_where('credit_request', array('user_uid' => $id));
        return $q->num_rows();
    }

    function insert_campagin_and_get_last_id($data) {
        $this->db->insert('campaign', $data);
        return $this->db->insert_id();
    }

    function insert_campagin_log($data) {
        $this->db->insert('campaign_log', $data);
    }

    function getSelectedAdsGroupContacts($ads_groups_uid) {
        $this->db->where('ads_groups_uid', $ads_groups_uid);
        $q = $this->db->get('ads_groups_contacts');
        foreach ($q->result() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    function getAdsGroupContactCountById($id) {
        
        $this->db->where('ads_groups_uid', $id);
        $q = $this->db->get('ads_groups_contacts');
        foreach ($q->result() as $row) {
            $data[] = $row;
        }
        return count($data);
    }

}

?>