<?php

class Global_model extends CI_Model {

    function config() {
        $config = $this->db->get('config');
        $query = $config->row();

        $data = array(
            'siteName' => $query->siteName,
            'siteDefaultDate' => $query->siteDefaultDate,
            'siteStatue' => $query->siteStatue,
            'siteMetaDesc' => $query->siteMetaDesc,
            'siteMetaKW' => $query->siteMetaKW,
            'siteAnalytics' => $query->siteAnalytics,
            'siteAlexa' => $query->siteAlexa,
            'siteTimeZone' => $query->siteTimeZone,
            'siteDayLight' => $query->siteDayLight
        );
        $this->session->set_userdata($data);
        $this->is_online();
    }

    function is_online() {
        if (!$this->session->userdata('siteStatue')) {
            redirect('offline');
        }
    }


    function have_permission($field) {
        $group_uid = $this->session->userdata('user_group');
        if ($group_uid == null) {
            redirect('client');
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
	
	function getLatestProducts(){	
        $this->db->order_by("pro_uid", "desc");
        $q = $this->db->get('product',10);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
	}
	
	function getAllCategories(){	
        $this->db->order_by("cat_name", "desc");
        $q = $this->db->get('category',10);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
	}
	
	
	
	
}

?>