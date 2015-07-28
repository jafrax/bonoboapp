<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* MODEL PEMBELI
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 Juni 2015 by Adi Setyo, Create function : get_all_pembeli,search
*/

class Model_pembeli extends CI_Model {
	 
	  public function get_all_pembeli($limit=1000000,$offset=0){
		$this->db->limit($limit,$offset);
		$this->db->order_by('name','ASC');
		return $this->db->get('tb_member');
	  }
	  
	  public function search($search,$limit=1000000,$offset=0){
        if($search != "all-search"){
            $this->db->like("name",$search);
			$this->db->or_like("email",$search);
        }
		$this->db->limit($limit,$offset);
        $this->db->order_by("name","asc");
		return $this->db->get('tb_member');
    }
}

?>