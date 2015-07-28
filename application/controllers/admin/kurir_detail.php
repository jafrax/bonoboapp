<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Admin CONTROLLER Kurir_detail
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 28 July 2015 by Adi Setyo, Create controller : Coding index, delete, search, edit, add
*/
class Kurir_detail extends CI_Controller {
    var $data = array('scjav'=>'assets/jController/admin/CtrlDkurir.js');
	var $limit = 10;
	var $offset = 0;
    function __construct(){
        parent::__construct();
        $this->load->model("admin/model_dkurir");
		if(empty($_SESSION['bonobo_admin']) || empty($_SESSION['bonobo_admin']->id)){
			redirect('admin/index/signin');
            return;
		}
    }
    
    public function index(){
		$id_kurir=base64_decode($this->uri->segment(3));
        $page=$this->uri->segment(5);
        $uri=5;
        $limit=$this->limit;
        if(!$page):
        $offset = $this->offset;
            else:
            $offset = $page;
        endif;
        $pg=$this->model_dkurir->get_all_kurir($id_kurir);
        $url='admin/master_kurir_detail/index';
        $this->data['pagination'] = $this->template->paging2($pg,$uri,$url,$limit);        
        $this->data['allDKurir']=$this->model_dkurir->get_all_kurir($limit,$offset);
        
		if ($this->input->post('ajax')) {
            $this->load->view('admin/master_kurir_detail/master_kurir_detail_ajax', $this->data);
        } else {
            $this->template->bonobo_admin('master_kurir_detail/master_kurir_detail', $this->data);
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
            
			$this->db->where_in('id',$delete)->delete('ms_courier');
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
			$pg		            	= $this->model_dkurir->search($_SESSION['search']);
			$url	           		= 'admin/master_kurir_detail/search';
			$this->data['pagination']	= $this->template->paging2($pg,$uri,$url,$limit);
			$this->data['allDKurir']		= $this->model_dkurir->search($_SESSION['search'],$limit,$offset);
			$this->load->view('admin/master_kurir_detail/master_kurir_detail', $this->data);
		}
	}
	
	public function edit(){
        $getid = $this->input->post("getid");
        if($getid){
            $cek   = $this->model_dkurir->edit($getid);
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
                
                $insert = $this->db->where("id",$idedit)->update('ms_courier',$param);
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
			$insert = $this->db->insert('ms_courier',$data_add);
            if($insert){
                $msg    = "success";
                $notif  = "Berhasil";
            }
		}else{
		
		}
		echo json_encode(array("msg"=>$msg,"notif"=>$notif));
	}
	
}
