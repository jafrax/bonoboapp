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

	function get_toko($id){
		return $this->db->where('id',$id)->get('tb_toko');
	}
	
	function get_produk_by_id($id){
		return $this->db->select('p.id id,p.name name,p.stock_type stock_type,p.active active')
						->where('c.toko_id',$id)
						->join('tb_toko_category_product c','c.id=p.toko_category_product_id')
						->get('tb_product p');
	}

	function get_one_image($id){
		return $this->db->where('product_id',$id)->get('tb_product_image');
	}

	function get_varian_produk($id){
		return $this->db->where('product_id',$id)->get('tb_product_varian');	
	}

}