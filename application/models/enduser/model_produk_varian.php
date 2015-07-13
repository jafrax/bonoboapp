<?php

class Model_produk_varian extends CI_Model {
	function __construct(){
		parent::__construct();			
	}
	
	function get_by_id($id){
		return $this->db->where("id",$id)->get("tb_product_varian");
	}

}