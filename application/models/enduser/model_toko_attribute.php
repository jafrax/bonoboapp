<?php

/*
* MODEL TOKO ATTRIBUTE
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 29 Juni 2015 by Heri Siswanto, Create function : get_by_shop
*/

class Model_toko_attribute extends CI_Model {
	
	public function get_by_shop($shop){
		return $this->db
					->where("toko_id",$shop)
					->get("tb_toko_attribute");
	}
	
}

?>