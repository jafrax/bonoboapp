<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Admin CONTROLLER INDEX
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 July 2015 by Adi Setyo, Create controller : Coding index, Coding signin
*/
class Index extends CI_Controller {
    function __construct(){
        parent::__construct();

        //$this->load->model("enduser/model_code");
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
        $this->load->view('admin/login/bg_login');
    }

}
