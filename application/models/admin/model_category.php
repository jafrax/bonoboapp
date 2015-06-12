<?php
class Model_category extends CI_Model {

	function get_category_all($limit=1000000,$offset=0){
        return $this->db->order_by('category.id','desc')->limit($limit,$offset)->get('tb_category category');
    }
    function get_category_all_lvl($level){
        return $this->db->order_by('category.id','desc')->where('level',$level)->get('tb_category category');
    }
    function get_category_all_asc($limit=1000000,$offset=0){
        return $this->db->order_by('category.id','asc')->limit($limit,$offset)->get('tb_category category');
    }
	function get_category_by_id($id,$limit=1000000,$offset=0){
        return $this->db->where('category.id',$id)->limit($limit,$offset)->get('tb_category category');
    }
	function get_category_by_npl($name,$parent,$level,$limit=1000000,$offset=0){
        return $this->db->where('category.name',$name)->where('category.parent_id',$parent)->where('category.level',$level)->limit($limit,$offset)->get('tb_category category');
    }
	public function get_filter($filter,$limit=1000000,$offset=0){
        return $this->db->like('name',$filter)->limit($limit,$offset)->get('tb_category');
    }
}

?>