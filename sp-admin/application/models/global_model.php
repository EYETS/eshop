<?php

class Global_model extends CI_Model {

    function config() {

        $config = $this->db->get('config');
        $query = $config->row();

        // check if status is opened and time exceed the notification period 

        $data = array(
            'siteName' => $query->siteName,
            'siteDefaultDate' => $query->siteDefaultDate,
            'sitePerPagePagination' => $query->sitePerPagePagination,
            'siteMetaDesc' => $query->siteMetaDesc,
            'siteMetaKW' => $query->siteMetaKW,
            'siteDefaultCredit' => $query->siteDefaultCredit
        );
        $this->session->set_userdata($data);
    }

    function have_permission($field) {
        $group_uid = $this->session->userdata('admin_group');
        if ($group_uid == null) {
            redirect('login');
        }

        $q = $this->db->query("SELECT * FROM permission WHERE group_uid = $group_uid");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $user_group = $row->$field;
            }
        }

        if (!isset($user_group) || $user_group != true) {
            redirect('error');
        }
    }

    function have_permission_menu($field) {
        $group_uid = $this->session->userdata('admin_group');
        if ($group_uid != null || $group_uid != '') {
            $q = $this->db->query("SELECT * FROM permission WHERE group_uid = $group_uid");
            if ($q->num_rows() > 0) {
                foreach ($q->result() as $row) {
                    $user_group = $row->$field;
                }
            }

            if (!isset($user_group) || $user_group != true) {
                return false;
            } else {
                return true;
            }
        } else {
            redirect('login/logout');
        }
    }

    function delete_selected_items($table, $id_field, $id, $table2, $id_field2) {
        $this->db->where($id_field, $id);
        $del = $this->db->delete($table);
        if ($table2 !== false && $id_field2 !== false) {
            $this->db->where($id_field2, $id);
            $del2 = $this->db->delete($table2);
        }
        if ($del) {
            return TRUE;
        } else {

            return FALSE;
        }
    }

    function getUserNameByID($id) {
        $q = $this->db->get_where('dx_users', array('user_uid' => $id));
        if ($q->num_rows() > 0) {
            $row = $q->row();
            return $row->user_full_name;
        } else {
            return false;
        }
    }

    function getUserByID($id) {
        $q = $this->db->get_where('dx_users', array('user_uid' => $id));
        if ($q->num_rows() > 0) {
            $row = $q->row();
            return $row;
        } else {
            return false;
        }
    }

}

?>