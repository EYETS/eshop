<?php

class Category_model extends CI_Model {
	
	function getAll($limit, $offsit) {

		$q = $this->db->get('category',$limit, $offsit);
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$data[] = $row;
			}
			return $data; 
		}else{
			return false;	
		}
	}
	

	function add(){
		$cat_name = $this->input->post('cat_name');
		$this->db->set('cat_name',$cat_name); 
        $this->db->insert('category'); 
		if($this->db->affected_rows() > 0){
			$this->messages->add("لقد تم أضافة القسم بنجاح.", "success");
		}else{
			$this->messages->add("لقد حدث خطأ أثناء الأضافة.", "error");
		}
	}
	
	function getByID($id) {
		$q =  $this->db->get_where('category', array('cat_uid' => $id));
		if($q->num_rows() > 0) {
			$row = $q->row();
			return $row; 
		}else{
			return false;	
		}
	}

	function edit_action($id){
		
		$cat_name = $this->input->post('cat_name');
		
		$data = array(
					   'cat_name' => $cat_name,
					);
		
		$this->db->where('cat_uid', $id);
		$this->db->update('category', $data); 
		
		if($this->db->affected_rows() > 0){
			$this->messages->add("لقد تم تحديث القسم بنجاح.", "success");
		}else{
			$this->messages->add("لم تقوم بتغيير بيانات الرقم.", "alert");
		}
		
	}
}


?>