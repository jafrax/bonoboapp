<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Admin CONTROLLER Master_lokasi
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 July 2015 by Adi Setyo, Create controller : Coding index
*/
class Master_lokasi extends CI_Controller {
    var $data = array('scjav'=>'assets/jController/admin/CtrlMlokasi.js');
	var $limit = 10;
	var $offset = 0;
    function __construct(){
        parent::__construct();
        $this->load->model("admin/model_lokasi");
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
        $pg=$this->model_lokasi->get_all_lokasi();
        $url='admin/master_lokasi/index';
        $this->data['pagination'] = $this->template->paging2($pg,$uri,$url,$limit);        
        $this->data['allMLokasi']=$this->model_lokasi->get_all_lokasi($limit,$offset);

        if ($this->input->post('ajax')) {
            $this->load->view('admin/master_lokasi/bg_masterlokasi_ajax', $this->data);
        } else {
            $this->template->bonobo_admin('master_lokasi/bg_masterlokasi', $this->data);
        } 

    }    
	
	public function search(){
		$search=$this->input->post('search');
        $page=$this->uri->segment(4);
        $uri=4;
        $limit=$this->limit;
        if(!$page):
        $offset = $this->offset;
            else:
            $offset = $page;
        endif;
        $pg=$this->model_lokasi->get_all_lokasi();
        $url='admin/master_lokasi/search';
        $this->data['pagination'] = $this->template->paging2($pg,$uri,$url,$limit);        
        $this->data['allSMLokasi']=$this->model_lokasi->get_all_lokasi($limit,$offset);

        if ($this->input->post('ajax')) {
            $this->load->view('admin/master_lokasi/bg_smasterlokasi_ajax', $this->data);
        } else {
            $this->template->bonobo_admin('master_lokasi/bg_smasterlokasi', $this->data);
        } 

    } 
	
}
