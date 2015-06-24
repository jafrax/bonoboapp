<?php

/*
* MODEL JOIN-IN
* 
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Heri Siswanto, Create function : get_by_shop
*/

class Model_joinin extends CI_Model {
	
	public function get_by_id($id){
		return $this->db
					->select('tji.*, tm.name as member_name')
					->join("tb_member tm","tji.member_id = tm.id")
					->where("tji.id",$id)
					->order_by("tji.id","DESC")
					->get("tb_join_in tji");
	}
	
	public function get_by_shop($shop){
		return $this->db
					->select('tji.*, tm.name as member_name')
					->join("tb_member tm","tji.member_id = tm.id")
					->where("tji.toko_id",$shop)
					->order_by("tji.id","DESC")
					->get("tb_join_in tji");
	}
	
	public function get_limit_by_shop($shop,$limit=10,$offset=0){
		return $this->db
					->select('tji.*, tm.name as member_name')
					->join("tb_member tm","tji.member_id = tm.id")
					->where("tji.toko_id",$shop)
					->limit($limit,$offset)
					->order_by("tji.id","DESC")
					->get("tb_join_in tji");
	}
	
	public function get_news($shop){
		return $this->db
					->select('tji.*, tm.name as member_name')
					->join("tb_member tm","tji.member_id = tm.id")
					->where("tji.status",0)
					->where("tji.toko_id",$shop)
					->order_by("tji.id","DESC")
					->get("tb_join_in tji");
	}
}

?>