<?php
class Model_admin_feed extends CI_Model {

	function get_all($limit=1000000,$offset=0){
        return $this->db
			->select('a.*, b.email')
			->join('tb_user b','b.id = a.user_id')
            ->order_by('id','desc')
            ->where('b.user_group_id',1)
            ->limit($limit,$offset)
            ->get('tb_feed a');
    }
	function get_post_type_by_id($id,$limit=1000000,$offset=0){
        return $this->db->where('post_type.id',$id)->limit($limit,$offset)->get('tb_post_type post_type');
    }
    public function get_filter($filter,$limit=1000000,$offset=0){
        return $this->db
			->select('a.*, b.email')
			->join('tb_user b','b.id = a.user_id')
			->where("(b.user_group_id like 1 and (email like '%$filter%' or title  like '%$filter%' ))", null)
			->order_by('id','desc')
            ->limit($limit,$offset)
			->get('tb_feed a');
    }
    public function get_one($id){
		return $this->db->where('id',$id)->get('tb_feed');
	}
    
	function get_cat_parent($id){
		return $this->db->where('parent_id',$id)->get('tb_category')->result();
	}
	
    function get_cat($level){
		return $this->db->where('level',$level)->get('tb_category');
	}
    
    function get_category($id){
		return $this->db
            ->select('a.id as cat, b.parent_names, b.id')
            ->join('tb_category b','b.id = a.category_id')
            ->where('a.feed_id',$id)
            ->get('tb_feed_category a')->result();
	}
    
    function get_post(){
        return $this->db->get('tb_post_type')->result();
    }
	
    function get_country(){
        return $this->db->order_by('name','asc')->get('tb_country')->result();
    }
	
	function get_image($id){
		return $this->db->where('feed_id',$id)->get('tb_feed_image')->result();
	}
}

?>