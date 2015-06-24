<?php

/*
* MODEL MEMBER
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Heri Siswanto, Create function : get_by_id
*/

class Model_member extends CI_Model {
	
	public function get_by_id($id){
		return $this->db->select("tm.*")
						->where("tm.id",$id,false)
						->get("tb_member tm");
	}
	
}

?>