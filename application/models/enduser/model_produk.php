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
	
	function get_produk_by_id($id,$active=1){
		$this->db->select('p.id id,p.name name,p.stock_type stock_type,p.active active,c.name kategori,p.sku_no sku_no')->where('c.toko_id',$id);
				if (isset($_SESSION['keyword'])) {$this->db->like('p.name',$_SESSION['keyword']);}
		return	$this->db->where('p.active',$active)->join('tb_toko_category_product c','c.id=p.toko_category_product_id')->get('tb_product p');
	}

	function get_one_produk($id){
		$this->db->select('*')->where('p.id',$id);				
		return	$this->db->join('tb_toko_category_product c','c.id=p.toko_category_product_id')->get('tb_product p');
	}

	function get_one_image($id){
		return $this->db->where('product_id',$id)->get('tb_product_image');
	}

	function get_varian_produk($id){
		return $this->db->where('product_id',$id)->get('tb_product_varian');	
	}

}