<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* MODEL lokasi
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 Juni 2015 by Adi Setyo, Create function : get_all_lokasi,search
*/

class Model_lokasi extends CI_Model {
	 
	  public function get_all_lokasi($limit=1000000,$offset=0){
		$this->db->limit($limit,$offset);
		$this->db->order_by('province','ASC');
		return $this->db->get('ms_location');
	  }
	  
	  public function search($search,$limit=1000000,$offset=0){
        if($search != "all-search"){
            $this->db->like("postal_code",$search);
			$this->db->or_like("kelurahan",$search);
			$this->db->or_like("kecamatan",$search);
			$this->db->or_like("city",$search);
			$this->db->or_like("province",$search);
        }
		$this->db->limit($limit,$offset);
        $this->db->order_by("postal_code","asc");
		return $this->db->get('ms_location');
    }
	  


}

?>