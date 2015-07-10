<?php

/*
* MODEL TOKO
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 23 Juni 2015 by Heri Siswanto, Create function : get_by_login, get_by_email
* 2. Update 24 Juni 2015 by Heri Siswanto, Create function : get_by_id
* 3. Create 03 Juli 2015 by Adi Setyo, Create function : get_by_verf,update_level_toko4,update_level_toko3,update_level_toko2,update_level_toko
* 														 cek_member_use4,cek_member_use3,cek_member_use2,cek_member_use1,cek_status_level_toko
*/

class Model_toko extends CI_Model {
	
	public function get_by_login($email,$password){
		return $this->db->select('tt.*')
						->where("tt.email",$email)
						->where("tt.password",$password)
						->get("tb_toko tt");
	}
	
	public function get_by_email($email){
		return $this->db->select('tt.*')
						->where("tt.email",$email)
						->get("tb_toko tt");
	}
	
	public function get_by_id($id){
		return $this->db->select('tt.*, mc.name as category_name, ml.kecamatan as location_kecamatan, ml.city as location_city, ml.province as location_province')
						->join("ms_location ml","tt.location_id = ml.id","LEFT")
						->join("ms_category mc","tt.category_id = mc.id","LEFT")
						->where("tt.id",$id)
						->get("tb_toko tt");
	}
	public function get_by_verf($email,$uri_veri){
		return	$this->db->select('tt.*')
						 ->where('tt.email',$email)
						 ->where('tt.verified_code',$uri_veri)
						 ->get('tb_toko tt');
	}
	public function update_status($email,$uri_veri){
		return	$this->db->select('tt.*')
						 ->where('tt.email',$email)
						 ->where('tt.verified_code',$uri_veri)
						 ->get('tb_toko tt');
	}
	public function cek_status_level_toko($data){
		$this->db->where('tt.id',$data['id_toko']);
		$return = $this->db->get('tb_toko tt');
		return $return;
	}
	public function cek_member_use1($id){
		$this->db->where('tt.toko_id',$id);
		$this->db->where('tt.price_level',1);
		$return = $this->db->get('tb_toko_member tt');
		return $return;
	}
	public function cek_member_use2($id){
		$this->db->where('tt.toko_id',$id);
		$this->db->where('tt.price_level',2);
		$return = $this->db->get('tb_toko_member tt');
		return $return;
	}
	public function cek_member_use3($id){
		$this->db->where('tt.toko_id',$id);
		$this->db->where('tt.price_level',3);
		$return = $this->db->get('tb_toko_member tt');
		return $return;
	}
	public function cek_member_use4($id){
		$this->db->where('tt.toko_id',$id);
		$this->db->where('tt.price_level',4);
		$return = $this->db->get('tb_toko_member tt');
		return $return;
	}
	public function cek_member_use5($id){
		$this->db->where('tt.toko_id',$id);
		$this->db->where('tt.price_level',5);
		$return = $this->db->get('tb_toko_member tt');
		return $return;
	}
	public function update_level_toko2($data,$data_update){
		$this->db->set('level_2_active',$data_update);
		$this->db->where('tt.id',$data['id_toko']);
		$this->db->update('tb_toko tt');
		$return=$this->db->affected_rows();
		return $return;
	}
	public function update_level_toko3($data,$data_update){
		$this->db->set('level_3_active',$data_update);
		$this->db->where('tt.id',$data['id_toko']);
		$this->db->update('tb_toko tt');
		$return=$this->db->affected_rows();
		return $return;
	}
	public function update_level_toko4($data,$data_update){
		$this->db->set('level_4_active',$data_update);
		$this->db->where('tt.id',$data['id_toko']);
		$this->db->update('tb_toko tt');
		$return=$this->db->affected_rows();
		return $return;
	}
	public function update_level_toko5($data,$data_update){
		$this->db->set('level_5_active',$data_update);
		$this->db->where('tt.id',$data['id_toko']);
		$this->db->update('tb_toko tt');
		$return=$this->db->affected_rows();
		return $return;
	}
}

?>