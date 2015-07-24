<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Admin CONTROLLER daftar_toko
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 July 2015 by Adi Setyo, Create controller : Coding index, Delete_daftar_toko
*/
class Daftar_toko extends CI_Controller {
    var $data = array('scjav'=>'assets/jController/admin/CtrlDtoko.js');
	var $limit = 10;
	var $offset = 0;
    function __construct(){
        parent::__construct();
        $this->load->model("admin/model_toko");
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
        $pg=$this->model_toko->get_all_toko();
        $url='admin/daftar_toko/index';
        $this->data['pagination'] = $this->template->paging2($pg,$uri,$url,$limit);        
        $this->data['allToko']=$this->model_toko->get_all_toko($limit,$offset);

        if ($this->input->post('ajax')) {
            $this->load->view('admin/daftar_toko/bg_daftartoko_ajax', $this->data);
        } else {
            $this->template->bonobo_admin('daftar_toko/bg_daftartoko', $this->data);
        } 
    }

	public function d_daftar_toko(){
		$data['id_dt']=$this->input->post('id');
		$result		  = $this->model_toko->delt_byid($data);
		if($result){
			echo "1";
		}

	
	}
	
}
