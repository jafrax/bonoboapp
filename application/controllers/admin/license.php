<?php
/*
 * Author : dinarwahyu13@gmail.com
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class License extends CI_Controller {
    var $data = array('scjav' => 'assets\jController\admin\CtrlLicense.js');

    function __construct(){
        parent::__construct();

        //$this->load->model("enduser/model_code");
    }
    
	public function index(){
        $redirect('license/daftar');
	}

    public function generator(){
        
    }

    public function setting(){
        $this->template->bonobo_admin('license/bg_setting',$this->data);
    }

    public function daftar(){
        
    }

}
