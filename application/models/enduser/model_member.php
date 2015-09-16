<?php

/*
* MODEL MEMBER
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Heri Siswanto, Create function : get_by_id
*/

class Model_member extends CI_Model {
	
	public function get_by_id($id){
		return $this->db->select("tm.*")
						->where("tm.id",$id,false)
						->get("tb_member tm");
	}
	public function get_by_email($id){
		return $this->db->select("tm.*")
						->where("tm.email",$id)
						->get("tb_member tm");
	}
	public function get_by_member($member){
		return $this->db->select("tma.*")
						->where("tma.member_id",$member)
						->get("tb_member_attribute tma");
	}
	public function get_by_member_location($member){
		return $this->db->select("tml.*, ml.postal_code as location_postal, ml.kecamatan as location_kecamatan, ml.city as location_city, ml.province as location_province")
						->join("ms_location ml","ml.id = tml.location_id")
						->where("tml.member_id",$member)
						->get("tb_member_location tml");
	}

	public function get_join_by_id($id){
		return $this->db
					->select('tji.*, tm.name as member_name')
					->join("tb_member tm","tji.member_id = tm.id")
					->where("tji.id",$id)
					->order_by("tji.id","DESC")
					->get("tb_join_in tji");
	}
	
	public function get_join_by_shop($shop){
		return $this->db
					->select('tji.*, tm.name as member_name')
					->join("tb_member tm","tji.member_id = tm.id")
					->where("tji.toko_id",$shop)
					->where("tji.member_id  not in (select distinct b.member_id from tb_toko_blacklist b where  b.toko_id='$shop')")
					->order_by("tji.id","DESC")
					->get("tb_join_in tji");
	}
	
	public function get_join_limit_by_shop($shop,$limit=10,$offset=0){
		return $this->db
					->select('tji.*, tm.name as member_name')
					->join("tb_member tm","tji.member_id = tm.id")
					->where("tji.toko_id",$shop)
					->where("tji.member_id  not in (select distinct b.member_id from tb_toko_blacklist b where  b.toko_id='$shop')")
					->limit($limit,$offset)
					->order_by("tji.id","DESC")
					->get("tb_join_in tji");
	}
	
	public function get_join_news($shop){
		return $this->db
					->select('tji.*, tm.name as member_name')
					->join("tb_member tm","tji.member_id = tm.id")
					->where("tji.status",0)
					->where("tji.toko_id",$shop)
					->where("tji.member_id  not in (select distinct b.member_id from tb_toko_blacklist b where  b.toko_id='$shop')")
					->order_by("tji.id","DESC")
					->get("tb_join_in tji");
	}
	public function get_bl_by_id($id){
		return $this->db
					->select("ttb.*")
					->where("ttb.id",$id)
					->get("tb_toko_blacklist ttb");
	}
	
	public function get_bl_member_by_shop($shop,$keyword="",$limit=1000000,$offset=0){
		return $this->db->select("tm.*")
						->where("tm.id IN (SELECT ttb.member_id FROM tb_toko_blacklist ttb WHERE ttb.toko_id = ".$shop.")",null)
						->like("tm.name",$keyword)
						->limit($limit,$offset)
						->get("tb_member tm");
	}
	
	public function get_bl_by_shop_member($shop,$member){
		return $this->db
					->select("ttb.*")
					->where("ttb.toko_id",$shop)
					->where("ttb.member_id",$member)
					->get("tb_toko_blacklist ttb");
	}

	public function get_tm_by_id($id){
		return $this->db
					->select("ttm.*")
					->where("ttm.id",$id)
					->get("tb_toko_member ttm");
	}
	
	public function get_tm_member_by_shop($shop,$keyword="",$limit=1000000,$offset=0){
		return $this->db->select("tm.*")
						->where("tm.id IN (SELECT ttm.member_id FROM tb_toko_member ttm WHERE ttm.toko_id = ".$shop.")",null)
						->like("tm.name",$keyword)
						->limit($limit,$offset)
						->get("tb_member tm");
	}
	
	public function get_tm_member_by_emails($shop,$emails){
		return $this->db->select("tm.*")
						->where("tm.id IN (SELECT ttm.member_id FROM tb_toko_member ttm WHERE ttm.toko_id = ".$shop.")",null)
						->where("tm.email IN (".$emails.")",null)
						->get("tb_member tm");
	}
	
	public function get_tm_by_shop_member($shop,$member){
		return $this->db
					->select("ttm.*")
					->where("ttm.toko_id",$shop)
					->where("ttm.member_id",$member)
					->get("tb_toko_member ttm");
	}

	public function get_toko_by_id($id){
		return $this->db->select('tt.*, mc.name as category_name, ml.kecamatan as location_kecamatan, ml.city as location_city, ml.province as location_province')
						->join("ms_location ml","tt.location_id = ml.id","LEFT")
						->join("ms_category mc","tt.category_id = mc.id","LEFT")
						->where("tt.id",$id)
						->get("tb_toko tt");
	}
	
	
}

?>