<?php

class Model_nota extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
				
	}

	function get_nota($limit=1000000,$offset=0){
		$this->db->limit($limit,$offset);
		$this->db->where('toko_id',$_SESSION['bonobo']['id']);
		
		if (isset($_SESSION['date_from'])) {
			$this->db->where('DATE(create_date) >=', $_SESSION['date_from']);
		}elseif(isset($_SESSION['date_to'])) {
			$this->db->where('DATE(create_date) <=', $_SESSION['date_to']);
		}else{
		$where = "DATE(create_date) BETWEEN '".$_SESSION['date_from']."' AND '".$_SESSION['date_to']."' ";
		$this->where($where);
		}
		
		if (isset($_SESSION['tipe_bayar'])) {
			$this->db->where('status',$_SESSION['tipe_bayar']);
		}
		if (isset($_SESSION['tipe_stok'])) {
			$this->db->where('stock_type',$_SESSION['tipe_stok']);
		}
		if (isset($_SESSION['flagger'])) {
			$this->db->where('member_confirm',1);
		}
		if (isset($_SESSION['search'])) {
			if ($_SESSION['search'] == 'semua') {
				$this->db->where("(member_name like '%".$_SESSION['keyword']."%' OR invoice_no like '%".$_SESSION['keyword']."%' OR price_total like '%".$_SESSION['keyword']."%') AND id != ",0,true);
			}else{
				$this->db->like($_SESSION['search'],$_SESSION['keyword']);				
			}
		}
		if (isset($_SESSION['sort'])) {
			$this->db->order_by('create_date',$_SESSION['sort']);
		}else{
			$this->db->order_by('create_date','DESC');
		}
			
		return $this->db->get('tb_invoice');
	}

	function get_nota_by_id($id){
		return $this->db->where('id',$id)->get('tb_invoice');
	}
	function get_nota_invoice($id){
		return $this->db->where('invoice_no',$id)->where('toko_id',$_SESSION['bonobo']['id'])->get('tb_invoice');
	}
	function get_nota_product($id){
		return $this->db->select('p.*')->where('i.toko_id',$_SESSION['bonobo']['id'])->where('i.invoice_no',$id)->join('tb_invoice i','i.id=p.invoice_id')->get('tb_invoice_product p');
	}

	function get_nota_product_image($id){
		return $this->db->where('ip.id',$id)->get('tb_invoice_product ip');
	}

	function get_nota_product_by_id($id){
		return $this->db->where('ip.invoice_id',$id)
						->join('tb_invoice_product ip','ip.id=iv.invoice_product_id')
						->get('tb_invoice_varian iv');
	}

	function get_image($id){
		return $this->db->where('id',$id)->get('tb_member');
	}

	function get_rekening(){
		return $this->db->select('t.id id,t.bank_name name, acc_name acc, acc_no no')
						->where('t.toko_id',$_SESSION['bonobo']['id'])
						->get('tb_toko_bank t');
	}
	

	function get_toko_bank($id){
		return $this->db->where('id',$id)->get('tb_toko_bank');
	}
	
	
	function get_tranfer($id){
		return $this->db->where('invoice_id',$id)->get('tb_invoice_transfer_confirm');
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

	function get_varian_product($id)
	{
		return $this->db->where('invoice_product_id',$id)->get('tb_invoice_varian');
	}
	
	
}