<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Admin CONTROLLER daftar_pembeli
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 July 2015 by Adi Setyo, Create controller : Coding index
*/
class Daftar_pembeli extends CI_Controller {
    var $data = array('scjav'=>'assets/jController/admin/CtrlDpembeli.js');
	var $limit = 10;
	var $offset = 0;
    function __construct(){
        parent::__construct();
        $this->load->model("admin/model_pembeli");
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
        $pg=$this->model_pembeli->get_all_pembeli();
        $url='admin/daftar_pembeli/index';
        $this->data['pagination'] = $this->template->paging2($pg,$uri,$url,$limit);        
        $this->data['allPembeli']=$this->model_pembeli->get_all_pembeli($limit,$offset);
        if ($this->input->post('ajax')) {
            $this->load->view('admin/daftar_pembeli/bg_daftar_pembeli_ajax', $this->data);
        } else {
            $this->template->bonobo_admin('daftar_pembeli/bg_daftar_pembeli', $this->data);
        } 

    }    
	
}
