<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* MODEL TOKO
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 Juni 2015 by Adi Setyo, Create function : get_all_toko, search, edit
*/

class Model_toko extends CI_Model {
	 
	  public function get_all_toko($limit=1000000,$offset=0){
		$this->db->limit($limit,$offset);
		$this->db->order_by('name','asc');
		return $this->db->get('tb_toko');
	  }
	  

	  public function search($search,$limit=1000000,$offset=0){
        if($search != "all-search"){
            $this->db->like("name",$search);
			$this->db->or_like("email",$search);
        }
		$this->db->limit($limit,$offset);
        $this->db->order_by("name","asc");
		return $this->db->get('tb_toko');
    }
	
	public function edit($id){
        return $this->db->where("id",$id)->get('tb_toko')->result();
    }

}

?>