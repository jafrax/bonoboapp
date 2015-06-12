<?php 

class Model_follow_company extends CI_model{
    
	function get_following_all($user){
		return $this->db
			->where("follow.user_id",$user)
			->get("tb_follow_company follow");
	}
	
	function get_following_limit($user,$limit,$offset){
		return $this->db
			->select("company.gold_date gold_date,user.id user_id,company.hastag hastag,follow.id as follow_id, user.fullname as user_name, user.image as user_image, company.id as company_id, company.name as company_name, company.image_logo as company_image, company.advantages as company_advantages, company.verified as company_verified, company_user.id as company_user_id, company_user.advantages as company_user_advantages")
			->join("tb_company company","follow.company_id = company.id")
			->join("tb_user user","follow.user_id = user.id")
			->join("tb_company company_user","user.company_id = company_user.id","left")
			->where("follow.user_id",$user)
			->limit($limit,$offset)
			->get("tb_follow_company follow");
	}
	
	function get_follower_all($company){
		return $this->db
			->where("follow.company_id",$company)
			->get("tb_follow_company follow");
	}
	
	function get_follower_limit($company,$limit,$offset){
		return $this->db
			->select("user.id user_id,company.hastag hastag,follow.id as follow_id, user.fullname as user_name, user.image as user_image, user.email, company.id as company_id, company.name as company_name, company.image_banner as company_image, company.advantages as company_advantages, company.verified as company_verified, company_user.id as company_user_id, company_user.advantages as company_user_advantages")
			->join("tb_company company","follow.company_id = company.id")
			->join("tb_user user","follow.user_id = user.id")
			->join("tb_company company_user","user.company_id = company_user.id","left")
			->where("follow.company_id",$company)
			->limit($limit,$offset)
			->get("tb_follow_company follow");
	}
	
	function get_by_user_company($user_id,$company_id){
		return $this->db
			->select("follow.id as follow_id, user.fullname as user_name, user.image as user_image, company.id as company_id, company.name as company_name, company.image_banner as company_image, company.advantages as company_advantages, company.verified as company_verified")
			->join("tb_company company","follow.company_id = company.id")
			->join("tb_user user","follow.user_id = user.id")
			->where("follow.user_id",$user_id)
			->where("follow.company_id",$company_id)
			->get("tb_follow_company follow");
	}
	
	function do_insert($user_id,$company_id){
		$data = array(
					"user_id"=>$user_id,
					"company_id"=>$company_id,
					"create_user"=>$_SESSION["vertibox"]["username"],
					"create_date"=>date("Y-m-d"),
					"update_user"=>$_SESSION["vertibox"]["username"]
				);
				
		return $this->db->insert("tb_follow_company",$data);
	}
	
	function do_delete($id){
		return $this->db->where("id",$id)->delete("tb_follow_company");
	}
	
	function do_delete_by_user_company($user_id,$company_id){
		return $this->db->where("user_id",$user_id)->where("company_id",$company_id)->delete("tb_follow_company");
	}

	function get_follow_company($id){
		return $this->db->select('company_id')->where("company_id",$id)->get("tb_follow_company")->num_rows();
	}

	function get_following_company($id){
		return $this->db->select('user_id')->where("user_id",$id)->get("tb_follow_company")->num_rows();
	}

}

?>