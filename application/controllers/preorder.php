<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER PREORDER WEBSITE
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 8 Juli 2015 by Dinar Wahyu Wibowo, Create controller
*/

class Preorder extends CI_Controller {

	function __construct(){
        parent::__construct();
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			redirect('index/signin/');
			return;
		}

		$this->load->model("enduser/model_preorder");		
    }
	
	public function index(){
		unset($_SESSION['sort']);
		unset($_SESSION['tipe_bayar']);
		unset($_SESSION['tipe_stok']);
		unset($_SESSION['flagger']);
		unset($_SESSION['search']);
		unset($_SESSION['keyword']);
		
		$data['nota']		= $this->model_preorder->get_nota();
		$data['rekening']	= $this->model_preorder->get_rekening();
		$data['toko']		= $this->model_preorder->get_toko()->row();		

		$this->template->bonobo('preorder/bg_preorder',$data);
	}	
}

