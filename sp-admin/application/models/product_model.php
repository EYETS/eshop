<?php


class Product_model extends CI_Model {

    /**
     * this method to get all product records by limit
     * 
     * @return array of records
     */
    function getAll($limit, $offsit) {

		$this->db->order_by("pro_uid", "desc");
        $q = $this->db->get('product', $limit, $offsit);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }

    /**
     * this method to get all categories records
     * 
     * @return array of records
     */
    function getAllCategories() {
        $this->db->order_by("cat_uid", "desc");
        $q = $this->db->get('category');
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }


    /**
     * this method to add record
     * 
     * @return void
     */
    function add_action() {

        $config['upload_path'] = PRODUCT_FILES;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            $this->messages->add($this->upload->display_errors(), "error");
        } else {
            $fInfo = $this->upload->data();
            $this->_createThumbnail(strtolower($fInfo['file_name']));

            $pro_title = $this->input->post('pro_title');
            $pro_pic = strtolower($fInfo['file_name']);
            $pro_short_desc = htmlspecialchars($this->input->post('pro_short_desc'));
            $pro_desc = $this->input->post('pro_desc');
            $pro_price = $this->input->post('pro_price');
            $cat_uid = $this->input->post('cat_uid');


            $data = array(
                'pro_title' => $pro_title,
                'pro_pic' => $pro_pic,
                'pro_short_desc' => $pro_short_desc,
                'pro_desc' => $pro_desc,
                'pro_price' => $pro_price,
                'cat_uid' => $cat_uid
            );
            $this->db->insert('product', $data);

            if ($this->db->affected_rows() > 0) {
                $this->messages->add("لقد تم أضافة المنتج بنجاح.", "success");
            } else {
                $this->messages->add("لقد حدث خطأ أثناء الأضافة.", "error");
            }
        }
    }

    /**
     * this method to retrive artical
     * 
     * @return array of a record
     */
    function getByID($id) {
        $q = $this->db->get_where('product', array('productID' => $id));
        if ($q->num_rows() > 0) {
            $row = $q->row();
            return $row;
        } else {
            return false;
        }
    }


    /**
     * this method to retrive a category name
     * 
     * @return string
     */
    function getCategory($id) {
        $this->db->select('cat_name');
        $q = $this->db->get_where('category', array('cat_uid' => $id));
        if ($q->num_rows() > 0) {
            $row = $q->row();
            return $row->cat_name;
        } else {
            return false;
        }
    }

    /**
     * this method to edit an product
     * 
     * @return void
     */
    function edit_action($id) {
        $config['upload_path'] = PRODUCT_FILES;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            $this->messages->add("لم تقوم برفع صورة جديدة.", "alert");
            $pro_pic = strtolower($this->input->post('pro_pic'));
        } else {
            $fInfo = $this->upload->data();
            $this->_createThumbnail(strtolower($fInfo['file_name']));
            $pro_pic = strtolower($fInfo['file_name']);
        }

		$pro_title = $this->input->post('pro_title');
		$pro_short_desc = htmlspecialchars($this->input->post('pro_short_desc'));
		$pro_desc = $this->input->post('pro_desc');
		$pro_price = $this->input->post('pro_price');
		$cat_uid = $this->input->post('cat_uid');


		$data = array(
			'pro_title' => $pro_title,
			'pro_pic' => $pro_pic,
			'pro_short_desc' => $pro_short_desc,
			'pro_desc' => $pro_desc,
			'pro_price' => $pro_price,
			'cat_uid' => $cat_uid
		);

        $this->db->where('pro_uid', $id);
        $this->db->update('product', $data);

        if ($this->db->affected_rows() > 0) {
            $this->messages->add("لقد تم تحديث المنتج بنجاح.", "success");
        } else {
            $this->messages->add("لم تقوم بتغيير بيانات المنتج.", "alert");
        }
    }

    /**
     * this method to edit a image
     * 
     * @return void
     */
    function _createThumbnail($fileName) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = PRODUCT_FILES . $fileName;
        $config['create_thumb'] = false;
        $config['new_image'] = 'thumb_' . $fileName;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 204;
        $config['height'] = 272;
        $this->load->library('image_lib', $config);
        if (!$this->image_lib->resize()) {
            $this->messages->add($this->image_lib->display_errors(), "error");
        }
    }

}

?>