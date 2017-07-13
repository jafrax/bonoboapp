<?php

/*
* MODEL CATEGORY
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 26 Juni 2015 by Heri Siswanto, Create function : get
*/

class Model_category extends CI_Model {
	
	public function get(){
		return $this->db->get("ms_category");
	}
	
	public function get_by_id($e){
		return $this->db->where("id",$e)->get("ms_category");
	}
}

?>