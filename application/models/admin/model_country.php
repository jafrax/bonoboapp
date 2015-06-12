<?php
class Model_country extends CI_Model {

	public function get_list_all(){
		return $this->db->get('countries');
	}
	
	public function getCountryAll($limit=1000000,$offset=0){
		return $this->db->limit($limit,$offset)->order_by("name", "asc")->get('countries');
	}

	public function get_filter($filter,$limit=1000000,$offset=0){
        return $this->db->like('name',$filter)->limit($limit,$offset)->get('countries');
    }
	
	public function get_by_search_type($keyword,$type=null,$limit=1000000,$offset=0){
		if($type != null){
			return $this->db->like('name',$keyword)->where("interest",$type)->limit($limit,$offset)->get('countries');
		}else{
			return $this->db->like('name',$keyword)->limit($limit,$offset)->get('countries');
		}
    }
	
	public function get_by_type($type=1,$limit=10,$offset=0){
		return $this->db->where("interest",$type)->limit($limit,$offset)->get('countries');
    }

    public function get_one($id){
		return $this->db->where('code',$id)->get('countries');
	}
	public function get_image($id){
        return $this->db->select('image')->where('code',$id)->get('countries')->row();
    }

}

?>