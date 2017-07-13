<?php

/*
* MODEL TOKO COURIER
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 30 Juni 2015 by Heri Siswanto, Create function : get_by_shop
*/

class Model_toko_courier extends CI_Model {
	
	public function get_by_shop($shop){
		return $this->db
					->select("ttc.*, mc.name as courier_name")
					->join("ms_courier mc","mc.id = ttc.courier_id")
					->where("ttc.toko_id",$shop)
					->get("tb_toko_courier ttc");
	}
	
	public function get_by_shop_courier($shop,$courier){
		return $this->db
					->select("ttc.*, mc.name as courier_name")
					->join("ms_courier mc","mc.id = ttc.courier_id")
					->where("ttc.toko_id",$shop)
					->where("ttc.courier_id",$courier)
					->get("tb_toko_courier ttc");
	}
	
}

?>