<?php 

class Model_catalog extends CI_model{

    function get_data($id,$limit=1000000,$offset=0){
	   return $this->db->where('company_id',$id)->order_by('name','asc')->limit($limit,$offset)->get('tb_catalog');
	}
    
    function get_one($id){
        return $this->db->where('id',$id)->get('tb_catalog')->result();
    }
    
}