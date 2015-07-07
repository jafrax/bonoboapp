<?php

class Model_nota extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
				
	}

	function get_nota(){
		return $this->db->where('toko_id',$_SESSION['bonobo']['id'])->get('tb_invoice');
	}

	function get_nota_by_id($id){
		return $this->db->where('id',$id)->get('tb_invoice');
	}
	function get_nota_invoice($id){
		return $this->db->where('invoice_no',$id)->get('tb_invoice');
	}
	function get_nota_product($id){
		return $this->db->where('i.invoice_no',$id)->join('tb_invoice i','i.id=p.invoice_id')->get('tb_invoice_product p');
	}

	function get_nota_product_by_id($id){
		return $this->db->where('invoice_id',$id)->get('tb_invoice_product');
	}

	function get_image($id){
		return $this->db->where('id',$id)->get('tb_member');
	}

	function get_rekening(){
		return $this->db->select('t.id id,m.name name')
						->where('t.toko_id',$_SESSION['bonobo']['id'])
						->join('ms_bank m','m.id=t.bank_id')
						->get('tb_toko_bank t');
	}
	function get_toko(){
		return $this->db->where('id',$_SESSION['bonobo']['id'])->get('tb_toko');
	}
	function get_rek_tujuan($id){
		return $this->db->where('invoice_id',$id)->get('tb_invoice_transfer_confirm');
	}

	function get_toko_kurir($id){
		return $this->db->select('m.name name')->where('t.toko_id',$id)->join('ms_courier m','m.id=t.courier_id')->get('tb_toko_courier t');	
	}

	function get_kustom_kurir($id){
		return $this->db->where('toko_id',$id)->get('tb_courier_custom');
	}

	function get_province(){
		return $this->db->group_by('province')->get('ms_location');
	}

	function get_city($id=''){
		return $this->db->where('province',$id)->group_by('city')->get('ms_location');
	}

	function get_kecamatan($id=''){
		return $this->db->where('city',$id)->group_by('kecamatan')->get('ms_location');
	}

	function get_location($postal){
		return $this->db->where('postal_code',$postal)->get('ms_location');	
	}

}