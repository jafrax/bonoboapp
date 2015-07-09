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
	
}