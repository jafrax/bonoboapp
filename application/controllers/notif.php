
<?php
/*
 * Author : dinarwahyu13@gmail.com
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notif extends CI_Controller {
    function __construct(){
        parent::__construct();        	
    }
    
	public function index(){
        if(isset($_SESSION['bonobo'])){
            $notif = $this->db->where('toko_id',$_SESSION['bonobo']['id'])->where('flag_read',0)->get('tb_toko_message')->num_rows();            
            //echo $notif;
            $this->response->send(array("result"=>1,"message"=>$notif));
        }else{
            $this->response->send(array("result"=>0,"message"=>'No Login'));
        }
		
	}

    public function nota()
    {
        if(isset($_SESSION['bonobo'])){
            $notif = $this->db->where('toko_id',$_SESSION['bonobo']['id'])->where('status',0)->get('tb_invoice')->num_rows();            
            //echo $notif;
            $this->response->send(array("result"=>1,"message"=>$notif));
        }else{
            $this->response->send(array("result"=>0,"message"=>'No Login'));
        }
    }

}
