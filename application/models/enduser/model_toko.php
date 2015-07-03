<?php

/*
* MODEL TOKO
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 23 Juni 2015 by Heri Siswanto, Create function : get_by_login, get_by_email
* 2. Update 24 Juni 2015 by Heri Siswanto, Create function : get_by_id
* 3. Create 03 Juli 2015 by Adi Setyo, Create function : get_by_verf
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
	public function get_by_verf($uri_mail,$uri_veri){
		return	$this->db->select('tt.*')
						 ->where('tt.email',$uri_mail)
						 ->where('tt.verified_code',$uri_veri)
						 ->get('tb_toko tt');
	}
}

?>