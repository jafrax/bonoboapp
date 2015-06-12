<?php
class BoUser extends CI_Model {

	public function getByLogin($username, $password){
		$User = $this->db
					->where("email",$username)
					->where("password",$password)
					->get("tb_user")
					->row();
		return $User;
	}
	
	public function getByAdminLogin($username, $password){
		$User = $this->db
					->where("email",$username)
					->where("password",$password)
					->where("user_group_id",1)
					->get("tb_user")
					->row();
		return $User;
	}
	
	public function getById($id){
		$User = $this->db
					->where("id",$id)
					->get("tb_user")
					->row();
		return $User;
	}
	
	public function getByEmail($email){
		$User = $this->db
					->where("email",$email)
					->get("tb_user")
					->row();
					
		return $User;
	}
	
	public function getListAllAdmins($key){
		$Users = $this->db
				->select("tu.*")
				->join("tb_user_group tug","tu.user_group_id = tug.id")
				->where("tu.company_id",null)
				->where("tug.name","ROOT")
				->where("(tu.fullname LIKE '%".$key."%' OR tu.email LIKE '%".$key."%')")
				->get("tb_user tu");
		
		return $Users;
	}
	
	public function getListAdmins($key,$offset,$start){
		if(empty($start)){
			$start = 0;
		}
		
		if(empty($offset)){
			$offset = 20;
		}
		
		$Users = $this->db
				->select("tu.*")
				->join("tb_user_group tug","tu.user_group_id = tug.id")
				->where("tu.company_id",null)
				->where("tug.name","ROOT")
				->where("(tu.fullname LIKE '%".$key."%' OR tu.email LIKE '%".$key."%')")
				->limit($offset,$start)
				->get("tb_user tu")->result();
		
		return $Users;
	}
	
	public function doAdminSave($user){
		if(!empty($user["id"])){
			$this->db->where("id",$user["id"])->update("tb_user",$user);
		}else{
			$this->db->insert("tb_user",$user);
		}
		return true;
	}
	
	public function doUnSuspend($id){
		$this->db->set("status",1)->where("id",$id)->update("tb_user");
	}

	public function doSuspend($id){
		$this->db->set("status",2)->where("id",$id)->update("tb_user");
	}
	
	public function doResetPassword($user){
		$this->db
			->set("password",$user["password"])
			->where("id",$user["id"])
			->update("tb_user");
		return true;
	}
	
}

?>