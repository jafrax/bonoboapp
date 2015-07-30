<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
/*
* CONTROLLER INDEX WEBSITE
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 30 Juli 2015 by Dinar Wahyu Wibowo, Create controller
*/

class License extends CI_Controller {

	function __construct(){
        parent::__construct();
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			redirect('index/');
			return;
		}		

    }
	
	public function index(){
		$this->load->view("enduser/license/bg_license");
	}
	
	public function submit_verification()
	{
		$id = $this->input->post('id');

		$code = base64_decode($this->input->post('code'));
		$msg    = "error";
        $notif  = "";

		$active_code = $this->db->where('toko_id',$id)->where('validity',1)->where('code',$code)->get('tb_activation_code');
		if ($active_code->num_rows() > 0) {
			$get_date 	= $this->db->where('id',$id)->get('tb_toko')->row();
			$code_date 	= $active_code->row();
			if (date('Y-m-d') >= $get_date->expired_on) {
				$end_date = $this->license_add($code_date->duration_type,$code_date->duration);
			}else{
				$end_date = $this->license_add($code_date->duration_type,$code_date->duration,$get_date->expired_on);
			}

			//echo $end_date;
			$update = $this->db->where('id',$id)->set('activation_code',$code)->set('expired_on',$end_date)->update('tb_toko');
			if ($update) {
				$this->db->where('toko_id',$id)->where('code',$code)->set('validity',0)->update('tb_activation_code');
				$msg    = "success";
                $msg    = array("msg"=>$msg,"end_date"=>$end_date);
	            $data   = array_merge($msg,$active_code->result());
	            echo json_encode($data);
			}
		}else{
			$notif = "License code tidak berlaku !";
			echo json_encode(array("msg"=>$msg,"notif"=>$notif));
		}
	}

	private function license_add($type,$value,$start_date=null){
		if ($start_date == null) {
			$date = new DateTime();
		}else{
			$date = new DateTime($start_date);
		}

		if ($type == 'y') {			
			$date->modify('+'.$value.' year');			
		}elseif ($type == 'm') {			
			$date->modify('+'.$value.' month');
		}elseif ($type == 'd') {			
			$date->modify('+'.$value.' day');
		}

		return $date->format('Y-m-d');
	}

	public function minta_disini()
	{
		$id = $this->input->post('id');
		$update = $this->db->where('toko_id',$id)->where('code',$code)->set('validity',0)->update('tb_activation_code');
	}
	
}

