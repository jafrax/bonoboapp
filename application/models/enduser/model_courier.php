<?php

/*
* MODEL COURIER
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 30 Juni 2015 by Heri Siswanto, Create function : get
*/

class Model_courier extends CI_Model {
	
	public function get(){
		return $this->db->get("ms_courier");
	}
	
}

?>