<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Admin CONTROLLER INDEX
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 July 2015 by Adi Setyo, Create controller : Coding index, Coding signin
*/
class Index extends CI_Controller {
 public $data = array( 'scjav'=>'' );
    function __construct(){
        parent::__construct();
        $this->load->model("admin/model_index");
    }
    
    public function index(){
        if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id_super'])){
            redirect('admin/index/signin');
            return;
        }else{
            redirect('admin/index/dashboard');
            return;
        }

    }

    public function signin (){
		if(!$_POST){
			$this->load->view('admin/login/bg_login');
		}else{
			$this->form_validation->set_rules('email','required');
			$this->form_validation->set_rules('password', 'required');
			$data['email']      = mysql_real_escape_string($this->input->post('email'));
			$data['password']   = mysql_real_escape_string($this->input->post('password'));
			/*$result 	= $this->model_index->get_user_admin($data)->row();
			if(!empty($result)){
				$_SESSION['bonobo']['id_super'] = $result->id;
				$this->response->send(array("result"=>1,"message"=>"Selamat datang ".$result->name,"messageCode"=>3));
			}else{
				$this->response->send(array("result"=>0,"message"=>$this->template->notif("email_password_failed"),"messageCode"=>3));
			}*/
			if($data['email']=='admin@mail.com' and  $data['password']=='admin@mail.com'){
				$_SESSION['bonobo']['id_super'] = '198';
				redirect('admin/index/dashboard');
			}else{
				redirect('admin/index/signin');
			}
		} 
    }
	
	public function dashboard(){
		$this->template->bonobo_admin('admin/dashboard/bg_dashboard',$this->data);
	}

}
