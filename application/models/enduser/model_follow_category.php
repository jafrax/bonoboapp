<?php
class Model_follow_category extends CI_Model {
	
	public function get($user,$category){
		return $this->db
				->select("tfc.id as follow_id, category.id as category_id, category.code as category_code, category.level as category_level")
				->join("tb_category category","tfc.category_id = category.id")
				->where("tfc.user_id",$user)
				->where("tfc.category_id",$category)
				->get("tb_follow_category tfc");
	}
	
	public function get_by_user($user){
		return $this->db->where("user_id",$user)->get("tb_follow_category")->row();
	}
	
	public function doSave($user,$category){
		$data = array(
					"user_id"=>$user,
					"category_id"=>$category,
					"create_user"=>$_SESSION["vertibox"]['username'],
					"create_date"=>date("Y-m-d"),
					"update_user"=>$_SESSION["vertibox"]['username'],
				);
				
		return $this->db->insert("tb_follow_category",$data);
	}
	
	public function doDelete($user,$category){
		return $this->db->where("user_id",$user)->where("category_id",$category)->delete("tb_follow_category");
	}
	public function get_category_follow($user,$level){
		return $this->db
				->select("category.id as category_id, category.name as category_name")
				->join("tb_category category","tfc.category_id = category.id")
				->where("tfc.user_id",$user)
				->where("category.level",$level)
				->get("tb_follow_category tfc");
	}
}

?>