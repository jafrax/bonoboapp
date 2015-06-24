<?php

/*
* MODEL TOKO MEMBER
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Heri Siswanto, Create function : get_members_by_shop
*/

class Model_toko_member extends CI_Model {
	
	public function get_members_by_shop($shop){
		return $this->db->select('tm.*')
						->where("tm.id IN (SELECT ttm.member_id FROM tb_toko_member ttm WHERE ttm.toko_id = ".$shop.")")
						->get("tb_member tm");
	}
	
}

?>