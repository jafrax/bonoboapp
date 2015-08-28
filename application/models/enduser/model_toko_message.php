<?php

/*
* MODEL TOKO MESSAGE
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 25 Juni 2015 by Heri Siswanto, Create function : get_by_id, get_by_shop, get_by_shop_member, get_by_shop_grouping, get_by_shop_member_new, get_by_shop_member_last
*/

class Model_toko_message extends CI_Model {
	
	public function get_by_id($id){
		return $this->db->select("ttm.*, tm.message as message")
						->join("tb_message tm","ttm.message_id = tm.id")
						->where("ttm.id",$id)
						->get("tb_toko_message ttm");
	}
	
	public function get_by_shop($shop,$keyword=""){
		return $this->db->select("ttm.*, tm.message as message, tmm.id as qmember_id, tmm.name as qmember_name, tmm.image as qmember_image")
						->join("tb_message tm","ttm.message_id = tm.id")
						->join("tb_member tmm","ttm.member_id = tmm.id")
						->where("ttm.toko_id",$shop)
						->like("tmm.name",$keyword)
						->get("tb_toko_message ttm");
	}
	
	public function get_by_shop_grouping($shop,$keyword=""){
		return $this->db->select("ttm.*, tm.message as message, tmm.id as qmember_id, tmm.name as qmember_name, tmm.image as qmember_image")
						->join("tb_message tm","ttm.message_id = tm.id")
						->join("tb_member tmm","ttm.member_id = tmm.id")
						->where("ttm.toko_id",$shop)
						->like("tmm.name",$keyword)
						->group_by("ttm.member_id")
						->order_by("max(ttm.id)","DESC")
						->get("tb_toko_message ttm");
	}
	
	public function get_by_shop_member($shop,$member,$limit=1000000,$offset=0){
		return $this->db->select("ttm.*, tm.message as message, tm.product_id as product_id")
						->join("tb_message tm","ttm.message_id = tm.id")
						->where("ttm.toko_id",$shop)
						->where("ttm.member_id",$member)
						->order_by("tm.id","DESC")
						->limit($limit,$offset)
						->get("tb_toko_message ttm");
	}
	
	public function get_by_shop_member_new($shop,$member){
		return $this->db->select("ttm.*, tm.message as message")
						->join("tb_message tm","ttm.message_id = tm.id")
						->where("ttm.toko_id",$shop)
						->where("ttm.member_id",$member)
						->where("ttm.flag_read",0)
						->get("tb_toko_message ttm");
	}
	
	public function get_by_shop_member_last($shop,$member){
		return $this->db->select("ttm.*, tm.message as message")
						->join("tb_message tm","ttm.message_id = tm.id")
						->where("ttm.toko_id",$shop)
						->where("ttm.member_id",$member)
						->limit(1,0)
						->order_by("ttm.id","DESC")
						->get("tb_toko_message ttm");
	}

	public function get_product_image($value=''){
		return $this->db->join("tb_product_image pi","pi.product_id = p.id")
						->where("p.id",$value)						
						->get("tb_product p");
	}
	
}

?>