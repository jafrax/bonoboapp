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
		$data['produk']		= $this->model_preorder->get_product_preorder();

		$this->template->bonobo('preorder/bg_preorder',$data);
	}

	public function detail($id){
		$id = base64_decode($id);

		$data['nota']	= $this->model_preorder->get_nota($id);
		$this->template->bonobo('preorder/bg_preorder_detail',$data);
	}
}

