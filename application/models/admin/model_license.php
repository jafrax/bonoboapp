<?php

/*
* MODEL TOKO
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juli 2015 by Dinar Wahyu Wibbowo, Create function : get_config
*/

class Model_license extends CI_Model {
	 
	public function get_config($config){      
      	$this->db->where('name',$config);
		return $this->db->get('tb_config');
	}


	function get_toko(){
	  	return $this->db->get('tb_toko');
	}

	public function get_license($limit=1000000,$offset=0){
	  	$this->db->limit($limit,$offset);
		$this->db->order_by('id','desc');
		if (isset($_SESSION['option'])) {
	    	$this->db->where('validity',$_SESSION['option']);
	    }
	  	return $this->db->get('tb_activation_code');	
	}

	public function search($search,$limit=1000000,$offset=0){
	    if($search != "all-search"){
	        $this->db->like("email",$search);
	    }
		$this->db->limit($limit,$offset);
	    $this->db->order_by("id","desc");
	    if (isset($_SESSION['option'])) {
	    	$this->db->where('validity',$_SESSION['option']);
	    }
	    
		return $this->db->get('tb_activation_code');
	}
}

?>