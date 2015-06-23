<?php
class Model_toko extends CI_Model {
	
	public function get_by_login($email,$password){
		return $this->db->select('tt.*')
						->where("tt.email",$email)
						->where("tt.password",$password)
						->get("tb_toko tt");
	}
	
}

?>