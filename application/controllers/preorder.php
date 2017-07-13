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
		$this->template->cek_license();
		$this->load->model("enduser/model_preorder");		
    }

	var $limit = 10;
	var $offset = 0;
	public function index(){
		unset($_SESSION['search']);
		unset($_SESSION['keyword']);		
		unset($_SESSION['sort']);
		unset($_SESSION['selesai']);
		$page 	= $this->uri->segment(3);        
        $limit 	= $this->limit;
        if(!$page){
        	$offset = $this->offset;
        }else{
            $offset = $page;
        }
		
        $data['produk'] = $this->model_preorder->get_product_preorder($limit,$offset);
        $data['opset'] = $offset;
        $data['limit']= $limit;
        
		if ($this->input->post('ajax')) {
			if ($data['produk']->num_rows() > 0){
                $this->load->view('enduser/preorder/bg_preorder_ajax', $data,$offset);
            }
        } else {
            	$this->template->bonobo('preorder/bg_preorder', $data);
        }
        
      
	}

	public function detail($id){
		$id = base64_decode($id);
		unset($_SESSION['search']);
		unset($_SESSION['keyword']);
		unset($_SESSION['sort']);
		unset($_SESSION['selesai']);
	
			$data['nota']	= $this->model_preorder->get_nota($id);
			$this->template->bonobo('preorder/bg_preorder_detail',$data);
		
	}

	public function selesai_semua(){
		$id = $this->input->post('id');

		$this->db->where('id',$id)->set('status_pre_order',1)->update('tb_invoice');
	}

	public function selesai_semuanya(){
		$id = $this->input->post('id');		

		$nota	= $this->model_preorder->get_nota($id);
		foreach ($nota->result() as $row) {
			$update = $this->db->where('id',$row->id)->set('status_pre_order',1)->update('tb_invoice');				
		}		
	}

	public function ajax_load($id){	
		$id = base64_decode($id);			
		$data['nota']	= $this->model_preorder->get_nota($id);

		$this->load->view('enduser/preorder/bg_preorder_detail_ajax',$data);
	}

	public function search(){

		$keyword 	= $this->input->post('keyword');
		$search 	= $this->input->post('search');
		$id 		= $this->input->post('id');

		if ($keyword != '') {
			$_SESSION['search'] = $search;
			$_SESSION['keyword'] = $keyword;
		}else{
			unset($_SESSION['search']);
			unset($_SESSION['keyword']);
		}
		
		$this->ajax_load($id);
	}

	public function sort(){
		$code 	= $this->input->post('code');
		$id 	= $this->input->post('id');

		if ($code == 2) {
			$_SESSION['sort'] = 'ASC';
		}elseif ($code == 1) {
			$_SESSION['sort'] = 'DESC';
		}

		$this->ajax_load($id);
	}

	public function selesai(){
		$code 	= $this->input->post('code');
		$id 	= $this->input->post('id');

		if ($code == 1) {
			$_SESSION['selesai'] = 0;
		}elseif ($code == 2) {
			$_SESSION['selesai'] = 1;
		}elseif ($code == 3) {
			unset($_SESSION['selesai']);
		}

		$this->ajax_load($id);
	}
	
public function selesai_satu(){
		$id = $this->input->post('id');
		$this->db->where('id',$id)->set('status_pre_order',1)->update('tb_invoice');
	}
	
	
}

