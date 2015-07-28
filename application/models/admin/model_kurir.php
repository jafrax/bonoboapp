<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* MODEL KURIR
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 28 Juni 2015 by Adi Setyo, Create function : get_all_kurir, search, edit
*/

class Model_kurir extends CI_Model {
	 
	  public function get_all_kurir ($limit=1000000,$offset=0){
		$this->db->limit($limit,$offset);
		$this->db->order_by('name','asc');
		return $this->db->get('ms_courier');
	  }
	  
	  public function search($search,$limit=1000000,$offset=0){
        if($search != "all-search"){
            $this->db->like("name",$search);
        }
		$this->db->limit($limit,$offset);
        $this->db->order_by("name","asc");
		return $this->db->get('ms_courier');
    }
	function edit($id){
        $this->db->where("id",$id);
		return $this->db->get('ms_courier')->result();
    }


}

?>