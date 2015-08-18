<?php

/*
* MODEL TOKO BANK
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 01 Juli 2015 by Heri Siswanto, Create function : get_by_id, get_by_shop
*/

class Model_toko_bank extends CI_Model {
	
	public function get_by_id($id){
		return $this->db
					->where("ttb.id",$id)
					->get("tb_toko_bank ttb");
	}
	
	public function get_by_shop($shop){
		return $this->db
					->where("ttb.toko_id",$shop)
					->get("tb_toko_bank ttb");
	}
	
}

?>