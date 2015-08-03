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
				$_SESSION['bonobo']['expired_on'] = $end_date;
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
		if (!$_POST) {
			$data['captcha']=$this->recaptcha->render();
			$this->load->view('enduser/license/bg_minta',$data);
		}else{
			$nama = $this->input->post('nama');
			$telp = $this->input->post('telp');
			$hp   = $this->input->post('hp');
			$id   = $_SESSION['bonobo']['id'];

			$this->form_validation->set_rules('nama', '', 'required|min_length[5]|max_length[50]');
			$this->form_validation->set_rules('telp', '', 'required|max_length[20]');
			$this->form_validation->set_rules('hp', '', 'required|max_length[20]');
			
			$captcha_answer = $this->response->post("captcha");
			$response	= $this->recaptcha->verifyResponse($captcha_answer);
			if(!empty($response['error-codes'])){
				$this->response->send(array("result"=>0,"message"=>"You are spammer","messageCode"=>1));
				return;
			}

			if ($this->form_validation->run() == TRUE){

				$request = $this->db->where('toko_id',$id)->where('validity',2)->get('tb_activation_code')->num_rows();
				if ($request == 0) {
					$insert = $this->db->set('toko_id',$id)								
									->set('validity',2)
									->set('email',$_SESSION['bonobo']['email'])
									->set('create_user',$_SESSION['bonobo']['email'])
									->set('create_date',date('Y-m-d'))
									->insert('tb_activation_code');
					if ($insert) {
						$message1 ="Hallo ".$nama.", terima kasih telah mengajukan permohonan lisensi kepada Kami<br>Berikut adalah data Anda <br>
								Nama : ".$nama."<br>
								No. Telp : ".$telp."<br>
								No. HP : ".$hp."<br><br>
								Regards,<br> Bonobo.com
							";
						$message2 ="Berikut adalah data pengajuan lisensi baru member Anda <br>
								Nama : ".$nama."<br>
								No. Telp : ".$telp."<br>
								No. HP : ".$hp."<br><br>
								Regards,<br> Bonobo.com
							";
							
						$this->template->send_email($_SESSION['bonobo']['email'],'no-reply@bonobo.com', $message1);
						$this->template->send_email($this->config->item('email_admin'),'no-reply@bonobo.com', $message2);
						$this->response->send(array("result"=>1,"message"=>"Permintaan telah dikirim","messageCode"=>1));
					}
				}else{
					$this->response->send(array("result"=>1,"message"=>"Anda sudah pernah mengajukan Permintaan","messageCode"=>1));
				}
				
			}
		}		
	}

	public function faq()
	{
		$this->load->view('enduser/license/bg_faq');
	}
	
}

