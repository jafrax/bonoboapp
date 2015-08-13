<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notif extends CI_Controller {
    function __construct(){
        parent::__construct();        	
    }
    
	public function index(){
        //set_time_limit(10000);
        header("Connection: close", true);
        
        if(isset($_SESSION['bonobo'])){
            $notif = $this->db->where('toko_id',$_SESSION['bonobo']['id'])->where('flag_read',0)->get('tb_toko_message')->num_rows();            
            $notif2 = $this->db->where('toko_id',$_SESSION['bonobo']['id'])->where('status',0)->get('tb_invoice')->num_rows(); 

            $this->response->send(array("result"=>1,"message"=>$notif,"message2"=>$notif2),false);
        }else{
            $this->response->send(array("result"=>0,"message"=>'No Login',"message2"=>'No Login'),false);
        }
        //flush();


       // session_write_close();
	}
/*
    public function nota()
    {
        if(isset($_SESSION['bonobo'])){
                       

            $this->response->send(array("result"=>1,"message"=>$notif));
        }else{
            $this->response->send(array("result"=>0,"message"=>'No Login'));
        }
    }
*/
}
