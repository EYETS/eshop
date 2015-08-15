<?php

class Credit_model extends CI_Model {

    function getCreditByID($id) {
        $q = $this->db->get_where('credit', array('user_uid' => $id));
        if ($q->num_rows() > 0) {
            $row = $q->row();
            return $row;
        } else {
            return 0;
        }
    }

    function getCreditHistoryByID($id) {
        $this->db->order_by("credit_history_uid", "desc");
        $q = $this->db->get_where('credit_history', array('user_uid' => $id));
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }

    function getCreditFullHistory() {
        $this->db->order_by("credit_history_uid", "desc");
        $q = $this->db->get('credit_history');
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }

    function getAllUsers() {
        $q = $this->db->get_where('dx_users', array('group_uid !=' => 1));

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
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

    function getAll($limit, $offsit) {
		$this->db->order_by("credit_request_uid", "desc");
        $q = $this->db->get_where('credit_request', array('credit_request_statue' => 0), $limit, $offsit);
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
        $user_uid = $this->input->post('user_uid');

        $credit_amount = $this->input->post('credit_amount');
        $current_credit = $this->credit_model->getCreditByID($user_uid)->credit_amount;

        $credit_history_type = $this->input->post('credit_history_type');
        $done = true;
        switch ($credit_history_type) {
            case 1:
                $total = $current_credit + $credit_amount;
                $data = array(
                    'credit_amount' => $total
                );
                $this->db->where('user_uid', $user_uid);
                $this->db->update('credit', $data);

                $data = array(
                    'user_uid' => $user_uid,
                    'user_uid_from' => $this->session->userdata('admin_uid'),
                    'credit_history_amount' => $credit_amount,
                    'credit_history_type' => $credit_history_type
                );
                $this->db->insert('credit_history', $data);

                break;

            case 2:
                $credit_history_reason = $this->input->post('credit_history_reason');
                $total = $current_credit - $credit_amount;

                $data = array(
                    'credit_amount' => $total
                );
                $this->db->where('user_uid', $user_uid);
                $this->db->update('credit', $data);

                $data = array(
                    'user_uid' => $user_uid,
                    'user_uid_from' => $this->session->userdata('admin_uid'),
                    'credit_history_amount' => $credit_amount,
                    'credit_history_reason' => $credit_history_reason,
                    'credit_history_type' => $credit_history_type
                );
                $this->db->insert('credit_history', $data);
                break;

            case 3:
                $user_uid_from = $this->input->post('user_uid_from');
                $user_uid_from_credit = $this->getCreditByID($user_uid_from)->credit_amount;

                if ($user_uid_from_credit < $credit_amount) {
                    echo $credit_amount;
                    $this->messages->add("العضو المراد التحويل منه رصيده لا يكفى لأجراء العملية.", "error");
                    $done = false;
                    break;
                }
                $user_uid_from_total = $user_uid_from_credit - $credit_amount;
                $data = array(
                    'credit_amount' => $user_uid_from_total
                );
                $this->db->where('user_uid', $user_uid_from);
                $this->db->update('credit', $data);


                $total = $current_credit + $credit_amount;

                $data = array(
                    'credit_amount' => $total
                );
                $this->db->where('user_uid', $user_uid);
                $this->db->update('credit', $data);


                $data = array(
                    'user_uid' => $user_uid,
                    'user_uid_from' => $user_uid_from,
                    'credit_history_amount' => $credit_amount,
                    'credit_history_type' => $credit_history_type
                );
                $this->db->insert('credit_history', $data);

                $data = array(
                    'user_uid' => $user_uid_from,
                    'user_uid_from' => $user_uid,
                    'credit_history_amount' => $credit_amount,
                    'credit_history_reason' => 'تحويل رصيد للعضو <a href="' . site_url("users/users_view/" . $user_uid) . '">' . $this->getUserNameByID($user_uid) . '</a>',
                    'credit_history_type' => 2
                );
                $this->db->insert('credit_history', $data);
                break;
        }

        if ($this->db->affected_rows() > 0) {
            if ($done != false)
                $this->messages->add("لقد تم اجراء العملية بنجاح.", "success");
        }else {
            $this->messages->add("لقد حدث خطأ أثناء اجراء العملية.", "error");
        }
    }

    function add_action_credit() {
        $user_uid = $this->input->post('user_uid');

        $credit_amount = $this->input->post('credit_amount');
        $current_credit = $this->credit_model->getCreditByID($user_uid)->credit_amount;

        $credit_history_type = $this->input->post('credit_history_type');
        $done = true;
        switch ($credit_history_type) {
            case 1:
                $total = $current_credit + $credit_amount;
                $data = array(
                    'credit_amount' => $total
                );
                $this->db->where('user_uid', $user_uid);
                $this->db->update('credit', $data);

                $data = array(
                    'user_uid' => $user_uid,
                    'user_uid_from' => $this->session->userdata('admin_uid'),
                    'credit_history_amount' => $credit_amount,
                    'credit_history_type' => $credit_history_type
                );
                $this->db->insert('credit_history', $data);

                break;

            case 2:
                $credit_history_reason = $this->input->post('credit_history_reason');
                $total = $current_credit - $credit_amount;

                $data = array(
                    'credit_amount' => $total
                );
                $this->db->where('user_uid', $user_uid);
                $this->db->update('credit', $data);

                $data = array(
                    'user_uid' => $user_uid,
                    'user_uid_from' => $this->session->userdata('admin_uid'),
                    'credit_history_amount' => $credit_amount,
                    'credit_history_reason' => $credit_history_reason,
                    'credit_history_type' => $credit_history_type
                );
                $this->db->insert('credit_history', $data);
                break;

            case 3:
                $user_uid_from = $this->input->post('user_uid_from');
                $user_uid_from_credit = $this->getCreditByID($user_uid_from)->credit_amount;

                if ($user_uid_from_credit < $credit_amount) {

                    echo "العضو المراد التحويل منه رصيده لا يكفى لأجراء العملية";
                    $done = false;
                    break;
                }
                $user_uid_from_total = $user_uid_from_credit - $credit_amount;
                $data = array(
                    'credit_amount' => $user_uid_from_total
                );
                $this->db->where('user_uid', $user_uid_from);
                $this->db->update('credit', $data);


                $total = $current_credit + $credit_amount;

                $data = array(
                    'credit_amount' => $total
                );
                $this->db->where('user_uid', $user_uid);
                $this->db->update('credit', $data);


                $data = array(
                    'user_uid' => $user_uid,
                    'user_uid_from' => $user_uid_from,
                    'credit_history_amount' => $credit_amount,
                    'credit_history_type' => $credit_history_type
                );
                $this->db->insert('credit_history', $data);

                $data = array(
                    'user_uid' => $user_uid_from,
                    'user_uid_from' => $user_uid,
                    'credit_history_amount' => $credit_amount,
                    'credit_history_reason' => 'تحويل رصيد للعضو <a href="' . site_url("users/users_view/" . $user_uid) . '">' . $this->getUserNameByID($user_uid) . '</a>',
                    'credit_history_type' => 2
                );
                $this->db->insert('credit_history', $data);
                break;
        }

        if ($this->db->affected_rows() > 0) {
            if ($done != false)
                echo"لقد تم اجراء العملية بنجاح.";
        }else {
            echo "لقد حدث خطأ أثناء اجراء العملية.";
        }
    }

    function addCreditByRequetId($id) {
        $q = $this->db->get_where('credit_request', array('credit_request_uid' => $id));
        if ($q->num_rows() > 0) {
            $row = $q->row();
            $current_credit = $this->credit_model->getCreditByID($row->user_uid)->credit_amount;

            $total = $current_credit + $row->credit_request_amount;
            $data = array(
                'credit_amount' => $total
            );
            $this->db->where('user_uid', $row->user_uid);
            $this->db->update('credit', $data);

            $data = array(
                'user_uid' => $row->user_uid,
                'user_uid_from' => $this->session->userdata('admin_uid'),
                'credit_history_amount' => $row->credit_request_amount,
                'credit_history_type' => 1
            );
            $this->db->insert('credit_history', $data);

            if ($this->db->affected_rows() > 0) {
                $this->db->delete('credit_request', array('credit_request_uid' => $id));
                $this->messages->add("تم أضافة عدد " . $row->credit_request_amount . " نقطة للعضو " . $this->global_model->getUserByID($row->user_uid) . " بنجاح", "success");
            } else {
                $this->messages->add("لقد حدث خطأ أثناء اجراء العملية.", "error");
            }
        } else {
            return false;
        }
    }

    function refuseCreditByRequetId($id) {
        $q = $this->db->get_where('credit_request', array('credit_request_uid' => $id));
        if ($q->num_rows() > 0) {
            $row = $q->row();

            $this->db->delete('credit_request', array('credit_request_uid' => $id));
            if ($this->db->affected_rows() > 0) {
                $this->messages->add("تم رفض عملية أضافة عدد " . $row->credit_request_amount . " نقطة للعضو " . $this->global_model->getUserByID($row->user_uid), "error");
            } else {
                $this->messages->add("لقد حدث خطأ أثناء اجراء العملية.", "error");
            }
        } else {
            return false;
        }
    }

    function getUserByID($id) {
        $q = $this->db->get_where('dx_users', array('user_uid' => $id));
        if ($q->num_rows() > 0) {
            $row = $q->row();
            return $row->user_uname;
        } else {
            return false;
        }
    }

    function changeRequestStatue($id) {

        $data = array(
            'credit_request_statue' => 1
        );

        $this->db->where('credit_request_uid', $id);
        $this->db->update('credit_request', $data);

        if ($this->db->affected_rows() > 0) {
            //$this->messages->add("تم تنفيذ العملية بنجاح.", "success");
        } else {
            //$this->messages->add("حدث خطأ أثناء تنفيذ العملية.", "error");
        }
    }

    function changeRequestStatueRefused($id) {

        $data = array(
            'credit_request_statue' => 2
        );

        $this->db->where('credit_request_uid', $id);
        $this->db->update('credit_request', $data);

        if ($this->db->affected_rows() > 0) {
            //$this->messages->add("تم تنفيذ العملية بنجاح.", "success");
        } else {
            //$this->messages->add("حدث خطأ أثناء تنفيذ العملية.", "error");
        }
    }

}

?>