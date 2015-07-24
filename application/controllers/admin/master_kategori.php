<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Admin CONTROLLER master_kategori
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 July 2015 by Adi Setyo, Create controller : Coding index
*/
class Master_kategori extends CI_Controller {
    var $data = array('scjav'=>'assets/jController/admin/CtrlMkategori.js');
	var $limit = 10;
	var $offset = 0;
    function __construct(){
        parent::__construct();
        $this->load->model("admin/model_kategori");
		if(empty($_SESSION['bonobo_admin']) || empty($_SESSION['bonobo_admin']->id)){
			redirect('admin/index/signin');
            return;
		}
    }
    
    public function index(){
        $page=$this->uri->segment(4);
        $uri=4;
        $limit=$this->limit;
        if(!$page):
        $offset = $this->offset;
            else:
            $offset = $page;
        endif;
        $pg=$this->model_kategori->get_all_kategori();
        $url='admin/master_kategori/index';
        $this->data['pagination'] = $this->template->paging2($pg,$uri,$url,$limit);        
        $this->data['allMKategori']=$this->model_kategori->get_all_kategori($limit,$offset);
        
		if ($this->input->post('ajax')) {
            $this->load->view('admin/master_kategori/bg_kategori_ajax', $this->data);
        } else {
            $this->template->bonobo_admin('master_kategori/bg_kategori', $this->data);
        } 
    }
		
	public function d_master_kategori(){
		$data['id_dt']=$this->input->post('id');
		$result		  = $this->model_kategori->delt_byid($data);
		if($result){
			echo "1";
		}
	}
	
}
