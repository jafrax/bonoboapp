<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* MODEL lokasi
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 Juni 2015 by Adi Setyo, Create function : get_all_lokasi, dell_byid
*/

class Model_lokasi extends CI_Model {
	 
	  public function get_all_lokasi($limit=1000000,$offset=0){
		$this->db->limit($limit,$offset);
		$this->db->order_by('province','ASC');
		return $this->db->get('ms_location');
	  }
	  
	  public function dell_byid($data){
		$this->db->where('id',$data['id_dt']);
		return $this->db->delete('ms_location');
	  }

}

?>