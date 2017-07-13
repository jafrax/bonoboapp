<?php

/*
* MODEL TOKO anggota
*
*
*/

class Model_toko_anggota extends CI_Model {
	
	public function get_member_blacklist($shop,$member){
		return $this->db->select("ttb.member_id")
						->join("tb_member tm","tm.id = ttb.member_id")
						->where("tm.email",$member)
						->where("ttb.toko_id",$shop)
						->get("tb_toko_blacklist ttb");
	}
	
	
	public function get_member_toko($shop,$member){
		return $this->db->select("ttm.member_id")
					->join("tb_member tm","tm.id = ttm.member_id")
					->where("tm.email",$member)
					->where("ttm.toko_id",$shop)
					->get("tb_toko_member ttm");
	}
	
	public function get_member_join($shop,$member){
		return $this->db->select("tji.member_id")
						->join("tb_member tm","tm.id = tji.member_id")
						->where("tm.email",$member)
						->where("tji.status",0)
						->where("tji.toko_id",$shop)
						->get("tb_join_in tji");
	}
	
}

?>