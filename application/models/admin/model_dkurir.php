<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* MODEL Detail KURIR
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 28 Juni 2015 by Adi Setyo, Create function : get_all_dkurir, search, edit
*/

class Model_dkurir extends CI_Model {
	 
	  public function get_all_dkurir ($id_kurir,$limit=1000000,$offset=0){
		$this->db->where('courier_id',$id_kurir);
		$this->db->limit($limit,$offset);
		$this->db->order_by('location_from_province','asc');
		return $this->db->get('tb_courier_rate');
	  }
	  
	  public function search($search,$id_kurir,$limit=1000000,$offset=0){
        if($search != "all-search"){
            $this->db->like("location_from_province",$search);
            $this->db->or_like("location_from_city",$search);
            $this->db->or_like("location_from_kecamatan",$search);
            $this->db->or_like("location_to_province",$search);
            $this->db->or_like("location_to_city",$search);
            $this->db->or_like("location_to_kecamatan",$search);
        }
		$this->db->where('courier_id',$id_kurir);
		$this->db->limit($limit,$offset);
        $this->db->order_by("location_from_province","asc");
		return $this->db->get('tb_courier_rate');
    }
	function name_id($id){
        $this->db->where("id",$id);
		return $this->db->get('ms_courier')->result();
    }
	function edit($id){
        $this->db->where("id",$id);
		return $this->db->get('tb_courier_rate')->result();
    }
	function get_province(){
		$this->db->group_by('province');
		return $this->db->get('ms_location');
	}
	function get_kota($id){
		$this->db->where('province',$id);
		$this->db->group_by('city');
		return $this->db->get('ms_location');
	}
	function get_kecamatan($id){
		$this->db->where('city',$id);
		$this->db->group_by('kecamatan');
		return $this->db->get('ms_location');
	}
	function get_allkota(){
		$this->db->group_by('city');
		return $this->db->get('ms_location');
	}
	function get_allkecamatan(){
		$this->db->group_by('kecamatan');
		return $this->db->get('ms_location');
	}






}

?>