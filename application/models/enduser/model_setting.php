<?php 

class Model_setting extends CI_model{
   
   function get(){
		return $this->db->get("tb_setting");
   }
}
