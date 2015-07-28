<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* MODEL KATEGORI
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 28 Juni 2015 by Adi Setyo, Create function : get_all_kategori, 
*/
class Model_account extends CI_Model {
    function read($limit=1000000,$offset=0){
        $this->db->order_by("name","asc");
		$this->db->limit($limit,$offset);
		return $this->db->get('tb_admin');
    }
    
    function edit($id){
        $this->db->where("id",$id);
		return $this->db->get('tb_admin')->result();
    }
    
    public function search($search,$limit=1000000,$offset=0){
        if($search != "all-search"){
            $this->db->like("name",$search);
			$this->db->or_like("email",$search);
        }
		$this->db->limit($limit,$offset);
        $this->db->order_by("name","asc");
		return $this->db->get('tb_admin');
    }
}