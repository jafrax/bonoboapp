<?php

/*
* MODEL TOKO MEMBER
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 25 Juni 2015 by Heri Siswanto, Create function : get_members_by_shop, get_by_shop_member
*/

class Model_toko_blacklist extends CI_Model {
	
	public function get_by_id($id){
		return $this->db
					->select("ttb.*")
					->where("ttb.id",$id)
					->get("tb_toko_blacklist ttb");
	}
	
	public function get_member_by_shop($shop,$keyword=""){
		return $this->db->select("tm.*")
						->where("tm.id IN (SELECT ttb.member_id FROM tb_toko_blacklist ttb WHERE ttb.toko_id = ".$shop.")",null)
						->like("tm.name",$keyword)
						->get("tb_member tm");
	}
	
	public function get_by_shop_member($shop,$member){
		return $this->db
					->select("ttb.*")
					->where("ttb.toko_id",$shop)
					->where("ttb.member_id",$member)
					->get("tb_toko_blacklist ttb");
	}
	
}

?>