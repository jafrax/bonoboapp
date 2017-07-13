<?php

/*
* MODEL LOCATION
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 26 Juni 2015 by Heri Siswanto, Create function : get
*/

class Model_location extends CI_Model {
	
	public function get_provinces(){
		return $this->db
					->group_by("province")
					->get("ms_location");
	}
	
	public function get_cities(){
		return $this->db
					->group_by("city")
					->get("ms_location");
	}
	
	public function get_kecamatans(){
		return $this->db
					->group_by("kecamatan")
					->get("ms_location");
	}
	
	public function get_by_filter($postal="",$kecamatan="",$city="",$province=""){
		if($postal != null && $postal != ""){
			return $this->db
					->where("postal_code",$postal)
					->where("kecamatan",$kecamatan)
					->where("city",$city)
					->where("province",$province)
					->get("ms_location");
		}else{
			return $this->db
					->where("kecamatan",$kecamatan)
					->where("city",$city)
					->where("province",$province)
					->get("ms_location");
		}
	}
	
	public function get_cities_by_province($p,$z=null){
		return $this->db
					->where("province",$p)
					->where("postal_code",$z)
					->group_by("city")
					->get("ms_location");
	}
	public function get_cities_by_provincee($p){
		return $this->db
					->where("province",$p)
					->group_by("city")
					->get("ms_location");
	}
	public function get_provinces_by_zipcode($p){
		return $this->db
					->where("postal_code",$p)
					->group_by("province")
					->get("ms_location");
	}
	
	public function get_kecamatans_by_city_province($c,$p,$z=null){
		if($z==null){
				return $this->db
					->where("city",$c)
					->where("province",$p)
					->group_by("kecamatan")
					->get("ms_location");
		}else{
		return $this->db
					->where("city",$c)
					->where("postal_code",$z)
					->where("province",$p)
					->group_by("kecamatan")
					->get("ms_location");
		}
	}
	public function get_kecamatans_by_city_provincee($c,$p){
		return $this->db
					->where("city",$c)
					->where("province",$p)
					->group_by("kecamatan")
					->get("ms_location");
	}
	
}

?>