<?php 
/*
 * Author : dinarwahyu13@gmail.com
 */

class Model_interest extends CI_model{
    
    //get all data
	function get_all_country($limit=1000000,$offset=0){
		$this->db->select('code,icon,countries.name name,count(code) cnt')->limit($limit,$offset)->join('tb_feed','tb_feed.country_id=countries.code','left')->group_by('code')->order_by('cnt','desc');
		if (isset($_SESSION['keyword_interest'])){
			$this->db->like('name',$_SESSION['keyword_interest']);
		}

		return $this->db->get("countries");
	}
	function get_all_country_asc($limit=1000000,$offset=0,$top_ten){
		$this->db->select('code,icon,countries.name name,count(code) cnt')->where_not_in('code',$top_ten)->limit($limit,$offset)->join('tb_feed','tb_feed.country_id=countries.code','left')->group_by('code')->order_by('name','asc');
		if (isset($_SESSION['keyword_interest'])){
			$this->db->like('name',$_SESSION['keyword_interest']);
		}

		return $this->db->get("countries");
	}
	function get_all_category($level){
		return $this->db->where('level',$level)->get('tb_category');
	}
	function get_all_category_parent($id){
		return $this->db->where('parent_id',$id)->get('tb_category');
	}

	// get follow
	function get_follow_country($user_id,$country_id){
		return $this->db->where('user_id',$user_id)->where('country_id',$country_id)->get('tb_feedbox_country');
	}

	function get_follow_category($user_id,$category_id){
		return $this->db->where('user_id',$user_id)->where('category_id',$category_id)->get('tb_follow_category ');
	}

	function get_follow_country2($user_id){
		return $this->db->where('a.user_id',$user_id)->join('countries b','b.code=a.country_id')->order_by("name", "asc")->get('tb_feedbox_country a');
	}

	function get_follow_category2($id){
		return $this->db->where('user_id',$id)->where('level',2)->join('tb_category a','a.id=b.category_id')->order_by("name", "asc")->get('tb_follow_category b');
	}

	//get all data
	function get_search_country($key){
		return $this->db->like('name',$key)->get("tb_country");
	}
	function get_search_category($key){
		return $this->db->like('name',$key)->get('tb_category');
	}
	function get_search_category_parent($id,$key){
		return $this->db->where('parent_id',$id)->like('name',$key)->get('tb_category');
	}
}
