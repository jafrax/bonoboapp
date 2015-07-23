<?php

/*
* MODEL TOKO
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 Juni 2015 by Adi Setyo, Create function : get_all_toko
*/

class Model_pembeli extends CI_Model {
	 
	  public function get_all_pembeli($limit=1000000,$offset=0){
		$this->db->limit($limit,$offset);
		return $this->db->get('tb_member');
	  }

}

?>