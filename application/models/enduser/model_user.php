<?php
class Model_user extends CI_Model {
	
	public function get_company($company){
		return $this->db->select('tb_company.*, a.name province,b.name country,c.name city')
						->join('tb_province a','a.id=province_id')
						->join('tb_country b','b.id=tb_company.country_id')
						->join('tb_city c','c.id=tb_company.city_id')
						->where("tb_company.id",$company)
						->get("tb_company");
	}
	public function get_company_id($id){
		return $this->db->where('id',$id)->get('tb_user');
	}
	public function get_catalogue($company){
		return $this->db->where("company_id",$company)->get("tb_catalog");
	}
	public function get_product($id){
		return $this->db->select('p.*,a.image image')
						->where("message_user_id",$id)
						->join('tb_product_image a','a.product_id=p.id','left')
						->group_by('p.id')
						->get("tb_product p");
	}
	public function get_follower($id){
		return $this->db->where("tb_follow_company.company_id",$id)->join('tb_user','tb_user.id=user_id')->get("tb_follow_company");
	}
	public function get_following($id){
		return $this->db->where("user_id",$id)->get("tb_follow_company");
	}
	public function get_name($id){
		return $this->db->where('id',$id)->get('tb_user');
	}
	public function get_contact($id,$id2){
		return $this->db->where('user_child_id',$id)->where('user_parent_id',$id2)->get('tb_user_contact');	
	}
	public function get_follow($id,$id2){
		return $this->db->where('company_id',$id)->where('user_id',$id2)->get('tb_follow_company');	
	}
	public function get_user_contact($id){
		return $this->db->where('user_id',$id)->get('tb_user_attribut');
	}
	public function get_id($email){
		return $this->db->where('email',$email)->get('tb_user');
	}
	public function get_username($username){
		return $this->db->where('username',$username)->get('tb_user');
	}
	
	public function save($user){
		return $this->db->where("id",$user["id"])->update("tb_user",$user);
	}
}

?>