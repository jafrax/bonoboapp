<?php class Model_user_contact extends CI_model{
    
	function get_by_user($user_id){
		return $this->db
				->select("company.id company_id,parent.id as parent_id, parent.fullname as parent_name, parent.image as parent_image, child.id as child_id, child.fullname as child_name, child.image as child_image, company.name as company_name",false)
				->join("tb_user parent","contact.user_parent_id = parent.id")
				->join("tb_user child","contact.user_child_id = child.id")
				->join("tb_company company","child.company_id = company.id","left")
				->where("contact.user_parent_id",$user_id)
				->get("tb_user_contact contact");
	}
	
	function get_contact($mode,$user_id,$limit=1000000,$offset=0){
		if($mode == 1){
			$this->db->order_by("fullname", "asc");
		}else{
			$this->db->order_by("id", "desc");
		}
		return $this->db
			->select("a.*,b.id user_id, b.email, b.image, b.fullname,c.name, c.hastag, c.id company_id")
			->join("tb_user b","a.user_child_id = b.id")
			->join("tb_company c","b.company_id = c.id","left")
			->where("a.user_parent_id",$user_id)
			
			->limit($limit,$offset)
			->get("tb_user_contact a")
			->result();
	}
	
	function get_contact_filter($filter,$user_id,$limit=1000000,$offset=0){
		$where	= "";
		if($filter != 'all-search'){
			$this->db->like("fullname",$filter);
		}
        return $this->db
			->select("a.*,b.id user_id, b.email, b.image, b.fullname,c.name, c.hastag, c.id company_id")
			->join("tb_user b","a.user_child_id = b.id")
			->join("tb_company c","b.company_id = c.id","left")
			->where("a.user_parent_id",$user_id)
			->limit($limit,$offset)
			->get("tb_user_contact a")
			->result();
	}
	
	function get_contact_by_user($user_id,$keyword=""){
		return $this->db
				->select("company.id company_id,company.hastag hastag,child.fullname name,child.position position,child.phone phone,child.email email,contact.id id,parent.id as parent_id, SUBSTR(parent.fullname, 1, 25) as parent_name, parent.image as parent_image, child.id as child_id, SUBSTR(child.fullname, 1, 25) as child_name, child.image as child_image, SUBSTR(company.name, 1, 25) as company_name",false)
				->join("tb_user parent","contact.user_parent_id = parent.id")
				->join("tb_user child","contact.user_child_id = child.id")
				->join("tb_company company","child.company_id = company.id","left")
				->where("contact.user_parent_id",$user_id)
				->where("child.fullname LIKE ", "%".$keyword."%")
				->order_by("child_name", "asc")
				->get("tb_user_contact contact");
	}
	
	function get_contact_by_email($user_id,$keyword=""){
		return $this->db
				->select("company.id company_id,company.hastag hastag,child.fullname name,child.position position,child.phone phone,child.email email,contact.id id,parent.id as parent_id, SUBSTR(parent.fullname, 1, 25) as parent_name, parent.image as parent_image, child.id as child_id, SUBSTR(child.fullname, 1, 25) as child_name, child.image as child_image, SUBSTR(company.name, 1, 25) as company_name",false)
				->join("tb_user parent","contact.user_parent_id = parent.id")
				->join("tb_user child","contact.user_child_id = child.id")
				->join("tb_company company","child.company_id = company.id","left")
				->where("contact.user_parent_id",$user_id)
				->where("child.email", $keyword)
				->order_by("child_name", "asc")
				->get("tb_user_contact contact");
	}
	
	function get_recent_by_user($user_id,$keyword="",$dateBegin,$dateEnd){
		return $this->db
				->select("company.id company_id,company.hastag hastag,child.fullname name,child.position position,child.phone phone,child.email email,contact.id id,contact.create_date as contact_create_date, parent.id as parent_id, SUBSTR(parent.fullname, 1, 25) as parent_name, parent.image as parent_image, child.id as child_id, SUBSTR(child.fullname, 1, 25) as child_name, child.image as child_image, SUBSTR(company.name, 1, 25) as company_name",false)
				->join("tb_user parent","contact.user_parent_id = parent.id")
				->join("tb_user child","contact.user_child_id = child.id")
				->join("tb_company company","child.company_id = company.id","left")
				->where("contact.user_parent_id",$user_id)
				->where("child.fullname LIKE ", "%".$keyword."%")
				->where("contact.create_date >=",$dateBegin)
				->where("contact.create_date <=",$dateEnd)
				->order_by("contact.create_date", "desc")
				->get("tb_user_contact contact");
	}
	
	function get_by_user_friend($user_id,$friend_id){
		return $this->db
				->select("user.id as user_id, user.fullname as user_name")
				->join("tb_user user","contact.user_child_id = user.id")
				->where("contact.user_parent_id",$user_id)
				->where("contact.user_child_id",$friend_id)
				->get("tb_user_contact contact");
	}
	
	function insert($data){
		return $this->db->insert("tb_user_contact",$data);
	}
	
	function do_delete_by_user_friend($user_id,$friend_id){
		return $this->db
				->where("user_parent_id",$user_id)
				->where("user_child_id",$friend_id)
				->delete("tb_user_contact");
	}

	function get_user($id){
		return $this->db->where('id',$id)->get('tb_user');
	}
}
