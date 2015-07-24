<?php

/*
* MODEL TOKO
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juli 2015 by Dinar Wahyu Wibbowo, Create function : get_config
*/

class Model_license extends CI_Model {
	 
	  public function get_config($config){      
      $this->db->where('name',$config);
		  return $this->db->get('tb_config');
	  }

}

?>