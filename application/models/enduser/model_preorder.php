<?php

class Model_preorder extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
				
	}

	function get_product_preorder(){
		return $this->db->select('p.name name,p.id id,i.file image')
						->where('c.toko_id',$_SESSION['bonobo']['id'])
						->where('stock_type',0)
						->join('tb_toko_category_product c','c.id=p.toko_category_product_id')
						->join('tb_product_image i','i.product_id=p.id','left')
						->get('tb_product p');
	}
	
	function get_belum_selesai($id){
		return $this->db->where('i.status_pre_order',0)
						->where('p.id',$id)
						->join('tb_invoice_product ip','ip.invoice_id=i.id')
						->join('tb_product_varian v','v.id=ip.product_varian_id')
						->join('tb_product p','p.id=v.product_id')
						->get('tb_invoice i');
	}
}