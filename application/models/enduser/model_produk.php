<?php

class Model_produk extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
				
	}
	
	function get_kategori($id,$limit=1000000,$offset=0){
		$this->db->limit($limit,$offset);
		$this->db->where('toko_id',$id);
		if (isset($_SESSION['search_kategori'])) {
		 	$this->db->like('name',$_SESSION['search_kategori']);
		 }
		 return $this->db->get('tb_toko_category_product');
	}

	function get_toko($id){
		return $this->db->where('id',$id)->get('tb_toko');
	}
	
	function get_produk_by_id($id,$stok=1,$active=1,$limit=1000000,$offset=0){		
		$this->db->select('p.id id,p.name name,p.unit unit,p.end_date end_date,p.stock_type stock_type,p.stock_type_detail stock_type_detail,p.active active,c.name kategori,p.sku_no sku_no')->where('c.toko_id',$id)->where('p.stock_type',$stok);
				if (isset($_SESSION['keyword'])) {$this->db->where("(p.name like '%".$_SESSION['keyword']."%' OR sku_no like '%".$_SESSION['keyword']."%')",null, false);}
				if (isset($_SESSION['filter_kategori'])) {$this->db->where('c.id',$_SESSION['filter_kategori']);}
				$this->db->limit($limit,$offset);
		return	$this->db->where('p.active',$active)->join('tb_toko_category_product c','c.id=p.toko_category_product_id')->order_by('p.id','DESC')->get('tb_product p');
	}

	function get_produk_ready_stock_by_id($id,$stok=1,$active=1,$limit=1000000,$offset=0){		
		$this->db->select('p.id id,p.name name,p.unit unit,p.end_date end_date,p.stock_type stock_type,p.stock_type_detail stock_type_detail,p.active active,c.name kategori,p.sku_no sku_no')->where('c.toko_id',$id)->where('p.stock_type',$stok);
				if (isset($_SESSION['keyword_ready_stock'])) {$this->db->where("(p.name like '%".$_SESSION['keyword_ready_stock']."%' OR sku_no like '%".$_SESSION['keyword_ready_stock']."%')",null, false);}
				if (isset($_SESSION['filter_kategori'])) {$this->db->where('c.id',$_SESSION['filter_kategori']);}
				$this->db->limit($limit,$offset);
		return	$this->db->where('p.active',$active)->join('tb_toko_category_product c','c.id=p.toko_category_product_id')->order_by('p.id','DESC')->get('tb_product p');
	}
	

	function get_one_produk($id){
		$this->db->select('p.id id,p.name name,p.end_date end_date,p.stock_type stock_type,p.active active,c.name kategori,p.sku_no sku_no,p.toko_category_product_id kategori,p.weight berat,p.unit satuan,p.min_order min_order,p.description description,p.stock_type_detail tipe_stok,p.price_base harga_pembelian,p.price_1 harga_1,p.price_2 harga_2,p.price_3 harga_3,p.price_4 harga_4,p.price_5 harga_5')
		->where('p.id',$id);				
		return	$this->db->join('tb_toko_category_product c','c.id=p.toko_category_product_id')->get('tb_product p');
	}

	function get_one_image($id){
		return $this->db->where('product_id',$id)->get('tb_product_image');
	}

	function get_varian_produk($id){
		return $this->db->where('product_id',$id)->get('tb_product_varian');	
	}



	function get_varian_produk_null($id){
		return $this->db->where('product_id',$id)->where('name','null')->get('tb_product_varian');
	}

	function count_product_by_category($id){
		return $this->db->where('toko_category_product_id',$id)->get('tb_product')->num_rows();
	}

	function delete_produk_by_category($id,$shop){
		return $this->db->where('toko_category_product_id',$id)
					//	->where('toko_id',$shop)
						->delete('tb_toko_category_product');
	}

}