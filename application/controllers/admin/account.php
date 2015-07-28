<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Admin CONTROLLER master_account
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 July 2015 by Adi Setyo, Create controller : Coding index, delete, seearch, add, edit, reset,change_password, rules_password, rules_username
*/
class Account extends CI_Controller {
    var $data = array('scjav'=>'assets/jController/admin/CtrlAccount.js');
	var $limit = 10;
	var $offset = 0;
    function __construct(){
        parent::__construct();
        $this->load->model("admin/model_account");
		if(empty($_SESSION['bonobo_admin']) || empty($_SESSION['bonobo_admin']->id)){
			redirect('admin/index/signin');
            return;
		}
    }
    
    public function index(){      
        $page	= $this->uri->segment(4);
		$uri	= 4;
		$limit	= $this->limit;
		if(!$page){
			$offset = $this->offset;
		}else{
			$offset = $page;
		}
        
		$pg		            = $this->model_account->read();
		$url	            = 'admin/account/index';
		$this->data['pagination']	= $this->template->paging2($pg,$uri,$url,$limit);
		$this->data['Account']		= $this->model_account->read($limit,$offset);
		if ($this->input->post('ajax')) {
			$this->load->view('admin/account/bg_account_ajax', $this->data);
		}else{
			$this->template->bonobo_admin("account/bg_account",$this->data);
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
			$pg		            	= $this->model_account->search($_SESSION['search']);
			$url	           		= 'admin/account/search';
			$this->data['pagination']	= $this->template->paging2($pg,$uri,$url,$limit);
			$this->data['Account']		= $this->model_account->search($_SESSION['search'],$limit,$offset);
			$this->load->view('admin/account/bg_account_ajax', $this->data);
		}
	}
    
    function add(){
        $this->form_validation->set_rules('name', '', 'required|max_length[50]');
        $this->form_validation->set_rules('username', '', 'required|max_length[50]|is_unique[tb_admin.email]');
        $this->form_validation->set_rules('password', '', 'required|min_length[5]|max_length[50]');
        $this->form_validation->set_rules('repassword', '', 'required|matches[password]');
        $msg    = "error";
        $notif  = "";
        if ($this->form_validation->run() == TRUE){
            
            $name    	= $this->db->escape_str($this->input->post('name'));
            $username   = $this->db->escape_str($this->input->post('username'));
            $password   = $this->db->escape_str($this->input->post('password'));
            $repassword = $this->db->escape_str($this->input->post('repassword'));
            $param  = array(
                'name'          => $name,
                'email'         => $username,
                'password'      => md5($password),
                'create_user'   => $_SESSION['bonobo_admin']->email,
				'create_date'	=> date("Y-m-d H:i:s")
            );
            
            $insert = $this->db->insert('tb_admin',$param);
            if($insert){
                $msg    = "success";
                $notif  = "Berhasil";
            }
        }else{
            
        }
        echo json_encode(array("msg"=>$msg,"notif"=>$notif));
    }
    
    public function edit(){
        $getid = $this->input->post("getid");
        if($getid){
            $cek   = $this->model_account->edit($getid);
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
                
                $insert = $this->db->where("id",$idedit)->update('tb_admin',$param);
                if($insert){
                    $msg    = "success";
                    $notif  = "Berhasil";
                }
            }
            echo json_encode(array("msg"=>$msg,"notif"=>$notif));
        }
    }
	
	
	function reset(){
        $id 	= $this->input->post('id');
        $cek	= $this->model_account->edit($id);
		$msg    = "error";
        $notif  = "";
        if(count($cek) > 0){
            foreach($cek as $row){
                $new = rand();
				 $param  = array(
					'password'      => md5($new),
					'update_user'   => $_SESSION['bonobo_admin']->email
				);
            
				$this->db->where("id",$id)->update('tb_admin',$param);
				$message ="Hi ".$row->name.",
                    Password anda telah berhasil di reset! <br>
                    Gunakan password baru anda untuk login. <br>
                    Password baru anda adalah:
                    password: <b>$new</b><br>
                    
                    Terimakasih,
                ";
                $this->template->send_email($row->email,'Reset Password Admin',$message);
                $msg    = "success";
				$notif	= $new;
            }
        }
		echo json_encode(array("msg"=>$msg,"notif"=>$notif));
    }
    
    function delete(){
        if($_POST != null){
			$delete = $this->input->post('delete');
			$delete	= explode(",",$delete);
			$del	= array('');
			
			for($i=0;$i<count($delete);$i++) {
				$del[] = $delete[$i];
            }
			$deleteConfirm = $this->db->where_in('id',$delete)->delete('tb_admin');

            $this->db->where_in('id',$delete)->delete('tb_admin');
		}
    }
	
	
	function rules_username(){
		$email 	= $_REQUEST['username'];
	    $cek	= $this->db->where('email',$email)->get('tb_admin');
	    if(count($cek->result())>0){
			$valid = "false";
	    }else{
			$valid = "true";
	    }
	    echo $valid;
	}
	
	function rules_password(){
		$pass 	= $_REQUEST['oldpass'];
		$id   	= $_SESSION['bonobo_admin']->id;
	    $cek	= $this->db->where('password',md5($pass))->where("id",$id)->get('tb_admin');
	    if(count($cek->result())>0){
			$valid = "true";
	    }else{
			$valid = "false";
	    }
	    echo $valid;
	}
	
	function change_password(){
		$this->form_validation->set_rules('oldpass', '', 'required|max_length[11]');
		$this->form_validation->set_rules('newpass', '', 'trim|required|min_length[4]|max_length[50]');
        $this->form_validation->set_rules('renewpass', '', 'trim|required|matches[newpass]');
		
        $msg    = "error";
        $notif  = "";
        if ($this->form_validation->run() == TRUE){
            $id   		= $_SESSION['bonobo_admin']->id;
            $password   = $this->db->escape_str($this->input->post('newpass'));
            $repassword = $this->db->escape_str($this->input->post('renewpass'));
            $param  = array(
                'password'      => md5($password),
                'update_user'   => $_SESSION['bonobo_admin']->email
            );
            
            $insert = $this->db->where("id",$id)->update('tb_admin',$param);
            if($insert){
                $msg    = "success";
                $notif  = "Berhasil";
            }
        }else{
            
        }
        echo json_encode(array("msg"=>$msg,"notif"=>$notif));
	}
	
}
