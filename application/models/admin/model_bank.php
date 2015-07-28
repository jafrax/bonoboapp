<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* MODEL BANK
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 28 Juni 2015 by Adi Setyo, Create function : get_all_bank, search, edit

*/

class Model_bank extends CI_Model {
	 
	  public function get_all_bank ($limit=1000000,$offset=0){
		$this->db->limit($limit,$offset);
		$this->db->order_by('name','asc');
		return $this->db->get('ms_bank');
	  }
	  
	  public function search($search,$limit=1000000,$offset=0){
        if($search != "all-search"){
            $this->db->like("name",$search);
        }
		$this->db->limit($limit,$offset);
        $this->db->order_by("name","asc");
		return $this->db->get('ms_bank');
    }
	function edit($id){
        $this->db->where("id",$id);
		return $this->db->get('ms_bank')->result();
    }


}

?>