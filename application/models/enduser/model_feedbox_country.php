<?php class Model_feedbox_country extends CI_model{
    
	function get_all_by_user($user){
		return $this->db
				->where("tfc.user_id",$user)
				->get("tb_feedbox_country tfc");
	}
	
	function get_all_by_user_country($user,$country){
		return $this->db
				->where("tfc.user_id",$user)
				->where("tfc.country_id",$country)
				->get("tb_feedbox_country tfc");
	}
	
	function do_insert($data){
		return $this->db->insert("tb_feedbox_country",$data);
	}
	
	function do_delete($id){
		return $this->db->where("id",$id)->delete("tb_feedbox_country");
	}
	
	function do_delete_by_user_country($user,$country){
		return $this->db
				->where("user_id",$user)
				->where("country_id",$country)
				->delete("tb_feedbox_country");
	}
}
