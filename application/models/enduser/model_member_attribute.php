<?php

/*
* MODEL MEMBER ATTRIBUTE
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Heri Siswanto, Create function : get_by_member
*/

class Model_member_attribute extends CI_Model {
	
	public function get_by_member($member){
		return $this->db->select("tma.*")
						->where("tma.member_id",$member)
						->get("tb_member_attribute tma");
	}
	
}

?>