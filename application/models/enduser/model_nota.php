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

	function get_image($id){
		return $this->db->where('id',$id)->get('tb_member');
	}

	function get_rekening(){
		return $this->db->select('t.id id,m.name name')
						->where('t.toko_id',$_SESSION['bonobo']['id'])
						->join('ms_bank m','m.id=t.bank_id')
						->get('tb_toko_bank t');
	}

}