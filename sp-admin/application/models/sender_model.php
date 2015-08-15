<?php

class Sender_model extends CI_Model {
	
	function getAll($limit, $offsit) {

		$q = $this->db->get('senders',$limit, $offsit);
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
		$sender_number = $this->input->post('sender_number');
		$this->db->set('sender_number',$sender_number); 
        $this->db->insert('senders'); 
		if($this->db->affected_rows() > 0){
			$this->messages->add("لقد تم أضافة الرقم بنجاح.", "success");
		}else{
			$this->messages->add("لقد حدث خطأ أثناء الأضافة.", "error");
		}
	}
	
	function getByID($id) {
		$q =  $this->db->get_where('senders', array('sender_uid' => $id));
		if($q->num_rows() > 0) {
			$row = $q->row();
			return $row; 
		}else{
			return false;	
		}
	}

	function edit_action($id){
		
		$sender_number = $this->input->post('sender_number');
		
		$data = array(
					   'sender_number' => $sender_number,
					);
		
		$this->db->where('sender_uid', $id);
		$this->db->update('senders', $data); 
		
		if($this->db->affected_rows() > 0){
			$this->messages->add("لقد تم تحديث الرقم بنجاح.", "success");
		}else{
			$this->messages->add("لم تقوم بتغيير بيانات الرقم.", "alert");
		}
		
	}
}


?>