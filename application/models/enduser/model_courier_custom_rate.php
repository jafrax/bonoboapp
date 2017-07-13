<?php

/*
* MODEL COURIER
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 1 Juli 2015 by Heri Siswanto, Create function : get
*/

class Model_courier_custom_rate extends CI_Model {
	
	public function get_by_courier($courier){
		return $this->db->where("courier_custom_id",$courier)->get("tb_courier_custom_rate");
	}
	
	public function get_by_id($id){
		return $this->db->where("id",$id)->get("tb_courier_custom_rate");
	}
}

?>