<?php

/*
* MODEL BANK
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 01 Juli 2015 by Heri Siswanto, Create function : get
*/

class Model_bank extends CI_Model {
	
	public function get(){
		return $this->db->get("ms_bank");
	}
	
}

?>