<?php

/*
* MODEL KATEGORI
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Adi Setyo, Create function : get_all_kategori, 
*/

class Model_kategori extends CI_Model {
	 
	  public function get_all_kategori ($limit=1000000,$offset=0){
		$this->db->limit($limit,$offset);
		$this->db->order_by('name','asc');
		return $this->db->get('ms_category');
	  }
	  
	  public function search($search,$limit=1000000,$offset=0){
        if($search != "all-search"){
            $this->db->like("name",$search);
			$this->db->or_like("email",$search);
        }
		$this->db->limit($limit,$offset);
        $this->db->order_by("name","asc");
		return $this->db->get('ms_category');
    }


}

?>