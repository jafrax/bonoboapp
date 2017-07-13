<?php

/*
* MODEL TOKO
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 Juni 2015 by Adi Setyo, Create function : get_user_admin
* 2. Change 22 Juni 2015 by Dinar W W, Change function : get_user_admin
*/

class Model_index extends CI_Model {
	 
	  public function get_user_admin($data){
		$this->db->where('email',$data['email']);
		$this->db->where('password',md5($data['password']));
		return $this->db->get('tb_admin');
	  }

}

?>