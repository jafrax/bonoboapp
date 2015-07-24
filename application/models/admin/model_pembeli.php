<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* MODEL PEMBELI
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 Juni 2015 by Adi Setyo, Create function : get_all_pembeli
*/

class Model_pembeli extends CI_Model {
	 
	  public function get_all_pembeli($limit=1000000,$offset=0){
		$this->db->limit($limit,$offset);
		$this->db->order_by('name','ASC');
		return $this->db->get('tb_member');
	  }

}

?>