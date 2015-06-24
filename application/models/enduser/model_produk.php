<?php

class Model_produk extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
				
	}
	
	function get_kategori($id){
		return $this->db->where('toko_id',$id)->get('tb_toko_category_product');
	}
	

}