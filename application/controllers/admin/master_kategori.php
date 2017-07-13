<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Admin CONTROLLER master_kategori
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 July 2015 by Adi Setyo, Create controller : Coding index, delete, seearch
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
		
	public function delete(){
		if($_POST != null){
			$delete = $this->input->post('delete');
			$delete	= explode(",",$delete);
			$del	= array('');
			
			for($i=0;$i<count($delete);$i++) {
				$del[] = $delete[$i];
            }
            
			$this->db->where_in('id',$delete)->delete('ms_category');
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
			$pg		            	= $this->model_kategori->search($_SESSION['search']);
			$url	           		= 'admin/master_kategori/search';
			$this->data['pagination']	= $this->template->paging2($pg,$uri,$url,$limit);
			$this->data['allMKategori']		= $this->model_kategori->search($_SESSION['search'],$limit,$offset);
			$this->load->view('admin/master_kategori/bg_kategori_ajax', $this->data);
		}
	}
	
	public function edit(){
        $getid = $this->input->post("getid");
        if($getid){
            $cek   = $this->model_kategori->edit($getid);
            $msg    = "error";
            if(count($cek)>0){
                $msg    = "success";
            }
            $msg    = array("msg"=>$msg);
            $data   = array_merge($msg,$cek);
            echo json_encode($data);
        }else{
            $this->form_validation->set_rules('namaedit', '', 'required');
            $this->form_validation->set_rules('idedit', '', 'required');
            $msg    = "error";
            $notif  = "";
            if ($this->form_validation->run() == TRUE){
                
                $name    	= $this->db->escape_str($this->input->post('namaedit'));
                $idedit     = $this->db->escape_str($this->input->post('idedit'));
                $param  = array(
                    'name'          => $name,
					'update_user'   => $_SESSION['bonobo_admin']->email
                );
                
                $insert = $this->db->where("id",$idedit)->update('ms_category',$param);
                if($insert){
                    $msg    = "success";
                    $notif  = "Berhasil";
                }
            }
            echo json_encode(array("msg"=>$msg,"notif"=>$notif));
        }
    }
	
	public function add (){
		$this->form_validation->set_rules('namaadd', '', 'required');
		$msg    = "error";
		$notif  = "";
		if ($this->form_validation->run() == TRUE){
            $name    	= $this->db->escape_str($this->input->post('namaadd'));
			 $data_add  = array(
								'name'          => $name,
								'create_date'	=> date("Y-m-d H:i:s"),
								'create_user'   => $_SESSION['bonobo_admin']->email
            );
			$insert = $this->db->insert('ms_category',$data_add);
            if($insert){
                $msg    = "success";
                $notif  = "Berhasil";
            }
		}else{
		
		}
		echo json_encode(array("msg"=>$msg,"notif"=>$notif));
	}
	
}
