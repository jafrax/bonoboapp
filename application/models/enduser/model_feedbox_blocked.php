<?php class Model_feedbox_blocked extends CI_model{
    
	function get_blocked_by_parent($parent_id,$keyword){
		return $this->db
				->select("tfb.id as blocked_id,user.id as user_id, user.fullname as user_name, user.image as user_image, company.id as company_id, company.name as company_name")
				->join("tb_user user","tfb.user_child_id = user.id")
				->join("tb_company company","user.company_id = company.id")
				->where("tfb.user_parent_id",$parent_id)
				->where("user.fullname like", "%".$keyword."%")
				->get("tb_feedbox_blocked tfb");
	}
	
	function get_blocked_by_parent_child($parent_id,$child_id){
		return $this->db
				->select("tfb.id as blocked_id,user.id as user_id, user.fullname as user_name, user.image as user_image, company.id as company_id, company.name as company_name")
				->join("tb_user user","tfb.user_child_id = user.id")
				->join("tb_company company","user.company_id = company.id")
				->where("tfb.user_parent_id",$parent_id)
				->where("tfb.user_child_id",$child_id)
				->get("tb_feedbox_blocked tfb");
	}
	
	function do_blocked($parent_id,$child_id){
		$data = array(
					"user_parent_id"=>$parent_id,
					"user_child_id"=>$child_id,
					"create_user"=>$_SESSION["vertibox"]["username"],
					"create_date"=>date("Y-m-d h:i:s"),
					"update_user"=>$_SESSION["vertibox"]["username"],
				);
		
		return $this->db->insert("tb_feedbox_blocked",$data);
			
	}
	
	function do_delete($id){
		return $this->db->where("id",$id)->delete("tb_feedbox_blocked");
	}
}
