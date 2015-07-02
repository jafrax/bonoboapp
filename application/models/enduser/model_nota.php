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

}