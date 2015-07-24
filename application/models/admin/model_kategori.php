<?php

/*
* MODEL KATEGORI
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Adi Setyo, Create function : get_all_kategori, delk_byid
*/

class Model_kategori extends CI_Model {
	 
	  public function get_all_kategori ($limit=1000000,$offset=0){
		$this->db->limit($limit,$offset);
		return $this->db->get('ms_category');
	  }
	  
	  public function delk_byid($data){
		$this->db->where('id',$data['id_ca']);
		return $this->db->delete('ms_category');
	  }

}

?>