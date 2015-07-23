<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Admin CONTROLLER INDEX
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 July 2015 by Adi Setyo, Create controller : Coding index, Coding signin
*/
class Index extends CI_Controller {
	var $data = array('scjav'=>'');
    function __construct(){
        parent::__construct();
        $this->load->model("admin/model_index");
    }
    
    public function index(){
        if(empty($_SESSION['bonobo_admin']) || empty($_SESSION['bonobo_admin']->id)){
            redirect('admin/index/signin');
            
            
        }else{
            redirect('admin/index/dashboard');
        }

    }

    public function signin (){
		if(!$_POST){
			$this->load->view('admin/login/bg_login');
		}else{
			$this->form_validation->set_rules('email', '', 'email|trim|required|');
			$this->form_validation->set_rules('password', '', 'trim|required');

			$username 	= $this->response->post('email');
			$password 	= $this->response->post('password');

			

			if ($this->form_validation->run() == TRUE) {

				$validate 	= $this->db->where('email',$username)->where('password',md5($password))->get('tb_admin');
				
				if ($validate->num_rows() > 0) {
					
					$_SESSION['bonobo_admin'] = $validate->row();
					redirect('admin');					
				}else{
					$_SESSION['login_error']='Username or password is wrong';
				}
			}else{
				$_SESSION['login_error']='Your input data is wrong';
			}
			redirect('admin');
		} 
    }
	
	public function dashboard(){
	 if(empty($_SESSION['bonobo_admin']) || empty($_SESSION['bonobo_admin']->id)){
            redirect('admin/index/signin');
            return;
        }else{
            $this->template->bonobo_admin('dashboard/bg_dashboard',$this->data);
        }
	}
	
	public function logout(){
		 unset($_SESSION['bonobo_admin']);
         session_destroy();
		 redirect('admin');
	}

}
