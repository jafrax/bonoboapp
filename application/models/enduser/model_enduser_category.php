<?php
class Model_enduser_category extends CI_Model {
	
	function get_by_level_all($level){
        return $this->db->where("category.level",$level)->order_by('category.name','asc')->get('tb_category category');
    }
	
	function get_by_parent_all($parent){
        return $this->db->where("category.parent_id",$parent)->order_by('category.name','asc')->get('tb_category category');
    }
	
	function get_by_parent_limit($parent,$offset,$limit){
        return $this->db->where("category.parent_id",$parent)->order_by('category.name','asc')->limit($limit,$offset)->get('tb_category category');
    }
	
	function get_by_id($id){
		   return $this->db->where("category.id",$id)->get('tb_category category');
	}
	
}

?>