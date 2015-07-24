<?php

/*
* MODEL TOKO
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 Juni 2015 by Adi Setyo, Create function : get_all_toko, delt_byid
*/

class Model_toko extends CI_Model {
	 
	  public function get_all_toko($limit=1000000,$offset=0){
		$this->db->limit($limit,$offset);
		return $this->db->get('tb_toko');
	  }
	  
	  public function delt_byid($data){
		$this->db->where('id',$data['id_dt']);
		return $this->db->delete('tb_toko');
	  }

}

?>