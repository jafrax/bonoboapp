<?php class Model_message extends CI_model{
    
	function get_by_user($user,$keyword){
		return $this->db
				->select("message.update_date as message_update,message.id as message_id, SUBSTR(message.message, 1, 25) as message_text, message.status as message_status, message.create_date as message_date, userfrom.id as userfrom_id, SUBSTR(userfrom.fullname, 1, 20) as userfrom_name, userfrom.image as userfrom_image, SUBSTR(userto.fullname, 1, 20) as userto_name, userto.id as userto_id, userto.image as userto_image", FALSE)
				->join("tb_user userfrom","message.user_from_id = userfrom.id")
				->join("tb_user userto","message.user_to_id = userto.id")
				->where("(message.user_to_id = '".$user."' OR message.user_from_id = '".$user."')")
				->where("(userfrom.fullname LIKE '%".$keyword."%' OR userto.fullname LIKE '%".$keyword."%')")
				->where("message.user_id", $user)
				//->where("message.message LIKE", "%".$keyword."%")
				->order_by("message.id","desc")
				->get("tb_message message");
	}
	
	function get_by_user_friend($user,$friend){
		return $this->db
				->select("c.hastag hastag,c.name company_name,message.update_date as message_update,message.id as message_id, message.message as message_text, message.status as message_status, message.create_date as message_date, userfrom.id as userfrom_id, userfrom.fullname as userfrom_name, userfrom.image as userfrom_image, userto.fullname as userto_name, userto.id as userto_id", FALSE)
				->join("tb_user userfrom","message.user_from_id = userfrom.id")
				->join("tb_user userto","message.user_to_id = userto.id")
				->join("tb_company c","userfrom.company_id = c.id",'left')
				->where("(message.user_to_id = '".$friend."' OR message.user_from_id = '".$friend."')")
				->where("message.user_id", $user)
				->order_by("message.id","asc")
				->get("tb_message message");
	}
	
	function get_new_message($user){
		return $this->db
				->where("message.user_id", $user)
				->where("message.status", 0)
				->get("tb_message message");
	}
	
	function do_delete_by_user_friend($user_parent_id,$user_from_id){
		return $this->db
				->where("(user_to_id = '".$user_from_id."' OR user_from_id = '".$user_from_id."')")
				->where("user_id", $user_parent_id)
				->delete("tb_message");
	}
	
	function do_delete_by_user($user_parent_id){
		return $this->db
				->where("user_id", $user_parent_id)
				->delete("tb_message");
	}
	
	function insert($data){
		return $this->db->insert("tb_message",$data);
	}
	
	function update($data){
		return $this->db->where("id",$data["id"])->update("tb_message",$data);
	}

	function markAllMesssage($id){
		$data = array(
			'status' => 1
			);
		return $this->db->where('user_id',$id)->update("tb_message",$data);
	}

	function get_attribute($user){
		return $this->db
				->where("user_id", $user)
				->get("tb_user_attribut");
	}

	function cek_durasi(){
		return $this->db->get("tb_setting");
	}

	function get_last_message($to_id){
		return $this->db->where('user_from_id',$_SESSION["vertibox"]["id"])
						->where('user_to_id',$to_id)
						->where('user_id',$to_id)
						->order_by('update_date','desc')
						->limit(1,0)
						->get('tb_message');
	}

	function get_rung_ditonton($id){
		return $this->db
				->select("c.name company_name,message.update_date as message_update,message.id as message_id, message.message as message_text, message.status as message_status, message.create_date as message_date, userfrom.id as userfrom_id, userfrom.fullname as userfrom_name, userfrom.image as userfrom_image, userto.fullname as userto_name, userto.id as userto_id", FALSE)
				->join("tb_user userfrom","message.user_from_id = userfrom.id")
				->join("tb_user userto","message.user_to_id = userto.id")
				->join("tb_company c","userfrom.company_id = c.id",'left')
				->where("(message.user_to_id = '".$id."' AND message.user_from_id = '".$_SESSION["vertibox"]["id"]."')")
				->where("message.user_id", $id)
				->where('message.status',0)
				->order_by("message.id","asc")
				->get("tb_message message");
	}
}