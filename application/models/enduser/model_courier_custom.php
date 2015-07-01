<?php

/*
* MODEL COURIER
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 30 Juni 2015 by Heri Siswanto, Create function : get
*/

class Model_courier_custom extends CI_Model {
	
	public function get_by_shop($shop){
		return $this->db->where("toko_id",$shop)->get("tb_courier_custom");
	}
	
	public function get_by_id($id){
		return $this->db->where("id",$id)->get("tb_courier_custom");
	}
}

?>