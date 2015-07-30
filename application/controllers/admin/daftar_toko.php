<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Admin CONTROLLER daftar_toko
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 July 2015 by Adi Setyo, Create controller : Coding index, delete, search, suspend
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
	
	public function delete(){
		if($_POST != null){
			$delete = $this->input->post('delete');
			$delete	= explode(",",$delete);
			$del	= array('');
			
			for($i=0;$i<count($delete);$i++) {
				$del[] = $delete[$i];
            }
            
			$this->db->where_in('id',$delete)->delete('tb_toko');
		}
	}
	
	public function search(){
		if(isset($_POST['search'])  ){
			$search = $this->db->escape_str($this->input->post('search'));
			
			if(empty($search)){$search ='all-search';}
			$_SESSION['search']	= $search;
		}	
		if(isset($_SESSION['search'])){			
			$page	= $this->uri->segment(4);
			$uri	= 4;
			$limit	= $this->limit;
			if(!$page){
				$offset = $this->offset;
			}else{
				$offset = $page;
			}
			
			$this->data["search"]	= $_SESSION['search'];
			$pg		            	= $this->model_toko->search($_SESSION['search']);
			$url	           		= 'admin/daftar_toko/search';
			$this->data['pagination']	= $this->template->paging2($pg,$uri,$url,$limit);
			$this->data['allToko']		= $this->model_toko->search($_SESSION['search'],$limit,$offset);
			$this->load->view('admin/daftar_toko/bg_daftartoko_ajax', $this->data);
		}
	}
	public function suspend(){
		$id 	= $this->input->post('id');
		$msg    = "error";
        $notif  = "";
		if($id){
			$cek	= $this->model_toko->edit($id);
			if(count($cek) > 0){
				$this->db->set('status',3)->where('id',$id)->update('tb_toko');
				$msg    = "success";
			}
		}
		echo json_encode(array("msg"=>$msg,"notif"=>$notif));
    }
	function unsuspend(){
        $id 	= $this->input->post('id');
		$msg    = "error";
        $notif  = "";
		if($id){
			$cek	= $this->model_toko->edit($id);
			if(count($cek) > 0){
				$this->db->set('status',2)->where('id',$id)->update('tb_toko');
				$msg    = "success";
			}
		}
		echo json_encode(array("msg"=>$msg,"notif"=>$notif));
    }
	
}
