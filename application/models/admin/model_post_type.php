<?php
class Model_post_type extends CI_Model {

	function get_post_type_all($limit=1000000,$offset=0){
        return $this->db->order_by('post_type.id','desc')->limit($limit,$offset)->get('tb_post_type post_type');
    }
	function get_post_type_by_id($id,$limit=1000000,$offset=0){
        return $this->db->where('post_type.id',$id)->limit($limit,$offset)->get('tb_post_type post_type');
    }
    public function get_filter($filter,$limit=1000000,$offset=0){
        return $this->db->like('name',$filter)->limit($limit,$offset)->get('tb_post_type');
    }
    public function get_one($id){
		return $this->db->where('id',$id)->get('tb_post_type');
	}
	
}

?>