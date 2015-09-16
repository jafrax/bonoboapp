<?php

class Model_preorder extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
				
	}

	function get_product_preorder($limit=1000000,$offset=0){
		return $this->db->select('p.name name,p.id id,i.file image,p.create_date create_date')
						->limit($limit,$offset)
						->where('c.toko_id',$_SESSION['bonobo']['id'])
						->where('stock_type',0)
						->where('p.active',1)
						->join('tb_toko_category_product c','c.id=p.toko_category_product_id')
						->join('tb_product_image i','i.product_id=p.id','left')
						->group_by('p.id')
						->get('tb_product p');
	}
	
	
	function get_belum_selesai($id){
		return $this->db->where('i.status_pre_order',0)
						->where('p.id',$id)
						->join('tb_invoice_product ip','ip.invoice_id=i.id')
						->join('tb_invoice_varian iv','iv.invoice_product_id=ip.id')
						->join('tb_product_varian v','v.id=iv.product_varian_id')
						->join('tb_product p','p.id=v.product_id')
						->get('tb_invoice i');
	}

	function get_nota($id){
		 $this->db->select('i.*')
						->where('p.id',$id)
						->join('tb_invoice_product ip','ip.invoice_id=i.id')
						->join('tb_invoice_varian iv','iv.invoice_product_id=ip.id')
						->join('tb_product_varian v','v.id=iv.product_varian_id')
						->join('tb_product p','p.id=v.product_id');
		if (isset($_SESSION['keyword'])) {
			$this->db->like($_SESSION['search'],$_SESSION['keyword']);
		}
		if (isset($_SESSION['selesai'])) {
			$this->db->where('status_pre_order',$_SESSION['selesai']);
		}
		if (isset($_SESSION['sort'])) {
			$this->db->order_by('i.create_date',$_SESSION['sort']);
		}else{
			$this->db->order_by('i.create_date','DESC');
		}
		return	$this->db->get('tb_invoice i');
	}

	function get_image($id){
		return $this->db->where('id',$id)->get('tb_member');
	}


}