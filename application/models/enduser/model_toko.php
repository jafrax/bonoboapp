<?php

/*
* MODEL TOKO
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 23 Juni 2015 by Heri Siswanto, Create model : get_by_login, get_by_email
*/

class Model_toko extends CI_Model {
	
	public function get_by_login($email,$password){
		return $this->db->select('tt.*')
						->where("tt.email",$email)
						->where("tt.password",$password)
						->get("tb_toko tt");
	}
	
	public function get_by_email($email){
		return $this->db->select('tt.*')
						->where("tt.email",$email)
						->get("tb_toko tt");
	}
}

?>