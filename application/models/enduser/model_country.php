<?php class Model_country extends CI_model{
    
	function get_all(){
		return $this->db->get("tb_country");
	}
	function get_follow_country($id,$id2){
		return $this->db->where('country_id',$id)->where('user_id',$id2)->get('tb_feedbox_country');
	}
}
