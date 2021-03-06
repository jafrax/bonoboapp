<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
/*
* CONTROLLER INDEX WEBSITE
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 12 Juni 2015 by Heri Siswanto, Create controller
* 2. Change 22 Juni 2015 by Dinar Wahyu Wibowo, Change Index
* 3. Change 23 Juni 2015 by Heri Siswanto, Coding Signup, Coding Signin, Signup Facebook, Signin Facebook
* 4. Create 03 Juli 2015 by adi Setyo, Cek Mail, signup_verification
* 5. Update 09 Juli 2015 by adi setyo, Coding doForgotPassword
*/

class Index extends CI_Controller {

	function __construct(){
        parent::__construct();
		
		$this->load->model("enduser/model_toko");
		$this->load->model('Facebook_Model', 'fb');
    }
	
	public function index(){
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			redirect('index/signin/');
			return;
		}else{
				$this->template->cek_license();
				$step=$_SESSION['bonobo']['step'];
				if($step == 1){
					redirect('toko');					
				}else if($step == 0){
					redirect('nota');
				}else{
					redirect('toko/step'.$step.'');
				}
			
			return;
		}

	}
	
	public function signup(){
		if(!$_POST){
			$this->load->view("enduser/login/bg_signup");
		}else{
			$this->form_validation->set_rules('name', '', 'min_length[5]|max_length[50]');
			$this->form_validation->set_rules('email', '', 'required|max_length[50]|valid_email|is_unique[tb_toko.email]');
			$this->form_validation->set_rules('password', '', 'required|min_length[5]|max_length[50]');
			$this->form_validation->set_rules('rePassword', '', 'required|matches[password]');
			
			if ($this->form_validation->run() == TRUE){
				$name    	= mysql_real_escape_string($this->input->post('name'));
				$email      = mysql_real_escape_string($this->input->post('email'));
				$password   = mysql_real_escape_string($this->input->post('password'));
				$repassword = mysql_real_escape_string($this->input->post('rePassword'));
				$verify 	= $this->template->rand(20);

				$param  = array(					
					"name"=>$name,
					"email"=>$email,
					"password"=> md5($password),
					"verified_code"=>$verify,
					"pm_store_payment"=>1,
					"level_1_name"=>'Harga Member Umum',
					"level_2_name"=>'Harga Member Langganan',
					"level_3_name"=>'Harga Khusus-1',
					"level_4_name"=>'Harga Khusus-2',
					"level_5_name"=>'Harga Khusus-3',
					"pm_transfer"=>0,
					"level_1_active"=>1,
					"status"=> 2,
					"step"=>1,
					"stock_adjust"=>1,
					"invoice_seq_alphabet"=>'A',
					"invoice_seq_no"=>1,
					"dm_pick_up_store"=>1,
					"create_date"=>date("Y-m-d H:i:s"),
					"create_user"=>$email,
					"update_date"=>date("Y-m-d H:i:s"),
					"update_user"=>$email,
				);
				
				
				$Save = $this->db->insert('tb_toko',$param);
				if($Save){
					
					$message ="
					Hi ".$name.",<br><br>
					Email anda telah berhasil didaftarkan di bonoboapp.com. Anda bisa melakukan login melalui URL: <a href='http://bonoboapp.com'>http://bonoboapp.com</a> dengan menggunakan email dan password yang sudah Anda buat.
					<br><br>
					Jika Anda merasa tidak mendaftarkan email Anda ke Bonobo App, maka segera ganti password Bonobo Anda, dengan mengeklik tautan \"Lupa Password\" yang ada di <a href='http://bonoboapp.com'>http://bonoboapp.com</a>
					<br><br>
					Jika Anda merasa tidak memiliki kepentingan didalam Bonobo Apps, mohon kirimkan email ke <a href='mailto:cs@bonoboapp.com'>cs@bonoboapp.com</a>
					<br><br>
					Terima Kasih,
					<br>
					Tim Bonobo
					";
					
					$send_email = $this->template->send_email($email,'Konfirmasi pendaftaran bonoboapp.com', $message);
					
					$this->signup_login($email,$password);
					
					$this->response->send(array("result"=>1,"message"=>"Pendaftaran berhasil.","messageCode"=>1));
				}else{
					$this->response->send(array("result"=>0,"message"=>"Pendaftaran anda tidak berhasil, coba ulangi lagi","messageCode"=>1));
				}
			}else{
				$this->response->send(array("result"=>0,"message"=>"Periksa kembali field anda","messageCode"=>1));//json error
			}
		}
	}
	
	public function signup_verification(){
		$email	=	$this->uri->segment(3);
		$uri_veri	=	$this->uri->segment(4);
		$ftv		= 	$this->model_toko->get_by_verf($email,$uri_veri);
		$_SESSION['bonobo']['notifikasi']=null;
		if($ftv->num_rows()>0){
			$_SESSION['bonobo']['notifikasi']=null;
			$Data=array('status'=> '2');
			$Update = $this->db->where("verified_code",$uri_veri)->update("tb_toko",$Data);
		}else{
			$_SESSION['bonobo']['notifikasi']="<div id='notifikasi' class='notif-error'><i class='fa fa-warning'></i>Verifikasi email failed</div>";
		}
		$QShop=$ftv->row();
		if($QShop>0){
				$_SESSION['bonobo']['id'] = $QShop->id;
				$_SESSION['bonobo']['name'] = $QShop->name;
				$_SESSION['bonobo']['email'] = $QShop->email;
				$_SESSION['bonobo']['image'] = $QShop->image;				
				$_SESSION['bonobo']['facebook'] = $QShop->facebook;
				$_SESSION['bonobo']['step'] = $QShop->step;
				$_SESSION['bonobo']['expired_on'] = $QShop->expired_on;
				redirect('index');
		}else{
				redirect('index');
		}
	}
	public function signup_login($email,$password){
		$default_auto_add_license 	= $this->get_config($this->config->item('default_auto_add_license'));
		$default_duration_type 		= $this->get_config($this->config->item('default_duration_type'));
		$default_duration 			= $this->get_config($this->config->item('default_duration'));
		$default_code 				= $this->get_config($this->config->item('default_code'));

		
		$QShop = $this->model_toko->get_by_login($email,md5($password))->row();
		if(!empty($QShop)){
			if ($default_auto_add_license == 1) {
				$this->db->set('toko_id',$QShop->id)
						->set('code',$default_code)
						->set('email',$email)
						->set('duration',$default_duration)
						->set('duration_type',$default_duration_type)
						->set('validity',1)
						->set('create_user',$email)
						->set('create_date',date('Y-m-d'))
						->insert('tb_activation_code');
			}
			$_SESSION['bonobo']['id'] = $QShop->id;
			$_SESSION['bonobo']['name'] = $QShop->name;
			$_SESSION['bonobo']['email'] = $QShop->email;
			$_SESSION['bonobo']['image'] = $QShop->image;				
			$_SESSION['bonobo']['facebook'] = $QShop->facebook;
			$_SESSION['bonobo']['step'] = $QShop->step;
			$_SESSION['bonobo']['expired_on'] = $QShop->expired_on;
			
		}
	}

	private function get_config($name){		
		return $this->db->where('name',$name)->get('tb_config')->row()->value;
	}

	public function cek_mail(){
		$email 		= 	$_REQUEST['email'];
		$cek_mail	=	$this->model_toko->get_by_email($email)->num_rows();
		if($cek_mail>0){
			$valid="false";
		}else{
			$valid="true";
		}
		echo $valid;
	}
	
	public function signin(){
		if(!$_POST){
			$data['capcha']=$this->recaptcha->render();
			$this->load->view("enduser/login/bg_login",$data);
        }else{
            $this->form_validation->set_rules('email', '', 'required');
            $this->form_validation->set_rules('password', '', 'required');
            
			$email      = mysql_real_escape_string($this->input->post('email'));
            $password   = md5(mysql_real_escape_string($this->input->post('password')));
			
            $QShop = $this->model_toko->get_by_login($email,$password)->row();
            if(!empty($QShop)){
				/*if($QShop->status == 0){
					$this->response->send(array("result"=>0,"message"=>$this->template->notif("account_not_verified"),"messageCode"=>1));
				}elseif($QShop->status == 1){
					$this->response->send(array("result"=>0,"message"=>$this->template->notif("account_not_activated"),"messageCode"=>2));
				}else*/
				if($QShop->status == 3){
					$this->response->send(array("result"=>0,"message"=>$this->template->notif("account_suspended"),"messageCode"=>3));
				}else{
					$_SESSION['bonobo']['id'] = $QShop->id;
					$_SESSION['bonobo']['name'] = $QShop->name;
					$_SESSION['bonobo']['email'] = $QShop->email;
					$_SESSION['bonobo']['image'] = $QShop->image;				
					$_SESSION['bonobo']['facebook'] = $QShop->facebook;
					$_SESSION['bonobo']['step'] = $QShop->step;
					$_SESSION['bonobo']['expired_on'] = $QShop->expired_on;
					
					$date1 = date("Y-m-d");
					$date2 = $_SESSION['bonobo']['expired_on'];

					$diff = abs(strtotime($date2) - strtotime($date1));

					$years = floor($diff / (365*60*60*24));
					$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
					$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
					
					if ($months == 0 && $years == 0 && $days <=30 && date('Y-m-d') <= $_SESSION['bonobo']['expired_on']) {
						$this->response->send(array("result"=>2,"message"=>"Selamat datang ".$QShop->name,"messageCode"=>3));
					}else{
						$this->response->send(array("result"=>1,"message"=>"Selamat datang ".$QShop->name,"messageCode"=>3));	
					}
					
				}
			}else{
				$this->response->send(array("result"=>0,"message"=>$this->template->notif("email_password_failed"),"messageCode"=>3));
			}   
        }
	}
	
	public function signup_fb(){
		$fb_profile     = $this->fb->userProfile();
        $SignedRequest  = $this->fb->getSignedRequest();
		
		if(empty($fb_profile->email)){
			$_SESSION['bonobo']['notifikasi']="<div class='notif-error'><label class='error'><i class='fa fa-warning'></i>Response dari akun facebook anda tidak valid.</label></div>";
			$this->signup();
			return;
		}
		
		$email          = $fb_profile->email;
        $uid			= $this->fb->getUser();

		$default_auto_add_license 	= $this->get_config($this->config->item('default_auto_add_license'));
		$default_duration_type 		= $this->get_config($this->config->item('default_duration_type'));
		$default_duration 			= $this->get_config($this->config->item('default_duration'));
		$default_code 				= $this->get_config($this->config->item('default_code'));
		
		$Save = $this->signup_facebook($fb_profile,$uid);
		$QShop  = $this->model_toko->get_by_email($email)->row();		
		if(!empty($QShop)){				
			$_SESSION['bonobo']['id'] = $QShop->id;
			$_SESSION['bonobo']['name'] = $QShop->name;
			$_SESSION['bonobo']['email'] = $QShop->email;
			$_SESSION['bonobo']['image'] = $QShop->image;				
			$_SESSION['bonobo']['facebook'] = $QShop->facebook;
			$_SESSION['bonobo']['step'] = $QShop->step;
			$_SESSION['bonobo']['expired_on'] = $QShop->expired_on;

			if ($default_auto_add_license == 1) {
				$this->db->set('toko_id',$QShop->id)
						->set('code',$default_code)
						->set('email',$email)
						->set('duration',$default_duration)
						->set('duration_type',$default_duration_type)
						->set('validity',1)
						->insert('tb_activation_code');
			}
			
			$this->index();
		}else{
			$_SESSION['bonobo']['notifikasi']="<div class='notif-error'><label class='error'><i class='fa fa-warning'></i>Akun Facebook tidak dapat didaftarkan</label></div>";
			$this->signup();
		}
	}
	
	public function signin_fb(){
		$fb_profile     = $this->fb->userProfile();
        $SignedRequest  = $this->fb->getSignedRequest();
		
		if(empty($fb_profile->email)){
			echo "Respon API facebook tidak valid <a href='".base_url("index/signin")."'>[ Ulangi Login ]</a>";
			return;
		}
		
		$email          = $fb_profile->email;
        $uid			= $this->fb->getUser();
		
		$QShop  = $this->model_toko->get_by_email($email)->row();
		
        if(!empty($QShop)){
			if($QShop->status == 0){
				$this->response->send(array("result"=>0,"message"=>$this->template->notif("account_not_verified"),"messageCode"=>1));
			}elseif($QShop->status == 1){
				$this->response->send(array("result"=>0,"message"=>$this->template->notif("account_not_activated"),"messageCode"=>2));
			}elseif($QShop->status == 3){
				$this->response->send(array("result"=>0,"message"=>$this->template->notif("account_suspended"),"messageCode"=>3));
			}else{
				$_SESSION['bonobo']['id'] = $QShop->id;
				$_SESSION['bonobo']['name'] = $QShop->name;
				$_SESSION['bonobo']['email'] = $QShop->email;
				$_SESSION['bonobo']['image'] = $QShop->image;				
				$_SESSION['bonobo']['facebook'] = $QShop->facebook;
				$_SESSION['bonobo']['step'] = $QShop->step;
				$_SESSION['bonobo']['expired_on'] = $QShop->expired_on;
				
				$this->index();
			}
		}else{
			$this->signup_facebook($fb_profile,$uid);
			$this->signin_fb();
		}
	}
	
	public function logout(){
		$_SESSION['bonobo']['id'] = null;
		$_SESSION['bonobo']['name'] = null;
		$_SESSION['bonobo']['email'] = null;
		$_SESSION['bonobo']['image'] = null;				
		$_SESSION['bonobo']['facebook'] = null;
		$_SESSION['bonobo']['step'] = null;
		$_SESSION['bonobo']['expired_on'] = null;
		
		redirect('index/');
	}
	
	private function signup_facebook($fb_profile,$uid){
		$QShop  = $this->model_toko->get_by_email($fb_profile->email)->row();
		
        if(empty($QShop)){
            if(isset($fb_profile->email)){
                $email      = $fb_profile->email;
                $contact    = $fb_profile->name;
				$profile_pic =  "http://graph.facebook.com/".$uid."/picture?type=large";
				
				$img 	= file_get_contents('https://graph.facebook.com/'.$uid.'/picture?type=large');
				$img2 	= file_get_contents('https://graph.facebook.com/'.$uid.'/picture');
				
				$file 	= 'assets/pic/shop/'.$uid.'.jpg';
				$file2 	= 'assets/pic/shop/resize/'.$uid.'.jpg';
				
				file_put_contents($file, $img);
				file_put_contents($file2, $img2);
				
				$Data = array(
						"name"=>$contact,
						"email"=>$email,
						"image"=>$uid.'.jpg',
						"pm_store_payment"=>1,
						"pm_transfer"=>0,
						"facebook"=>1,
						"status"=>2,
						"step"=>1,
						"stock_adjust"=>1,
						"create_date"=>date("Y-m-d H:i:s"),
						"create_user"=>$email,
						"update_date"=>date("Y-m-d H:i:s"),
						"update_user"=>$email,
					);
				
                $Save = $this->db->insert('tb_toko',$Data);
					
				if($Save){
					return true;
				}else{
					return false;
				}
            }else{
				return false;
			}
        }else{
			return false;
		}
	}
	
	function doForgotPassword(){
		$data['email_user']=$this->response->post("email");
		if($data['email_user'] == ""){
			$this->response->send(array("result"=>0,"message"=>"Email harus diisi !","messageCode"=>1));
			return;
		}
		$cek=$this->model_toko->cek_user_active($data);
		if($cek->num_rows()>0){
			$this->response->send(array("result"=>0,"message"=>"Reset Password Gagal dikirim. Silahkan hubungi Admin","messageCode"=>1));
			return;
		}
		$captcha_answer = $this->response->post("rechapcha");
		$response	= $this->recaptcha->verifyResponse($captcha_answer);
		if(!empty($response['error-codes'])){
			$this->response->send(array("result"=>0,"message"=>"You are spammer","messageCode"=>1));
			return;
		}
		
		
		$QShop = $this->model_toko->get_by_email($this->response->post("email"))->row();
		if(!empty($QShop)){
			// start kirim kode ke email
			
			$key 		= $this->config->item('saltkey');
			$date = new DateTime();
			$date->modify('+1 day');
			$ex_date = $date->format('Y-m-d H:i:s');
			
			$string 	= $key."#".$data['email_user']."#".$ex_date;
			
			$token		= $this->template->encrypt($string);
			//echo $ex_date;
			$Data = array(
						"token"=>$token
					);
			
			$Save = $this->db->where("id",$QShop->id)->update("tb_toko",$Data);
			if($Save){
				$message ="
					Hi ".$QShop->name.",<br><br>

					Silakan klik link (URL) berikut ini untuk mereset password. URL akan kadaluarsa dalam waktu
					1 x 24 jam.<br><br>
					".site_url("index/reset_password/".$data['email_user']."/".$token."")."
					<br><br>
					Terima Kasih,<br>

					Tim Bonobo
					";
					
				$this->template->send_email($QShop->email,'[BONOBO] Lupa Password', $message);
				// end email send
				$this->response->send(array("result"=>1,"message"=>"Silahkan lihat pesan kami di email anda!","messageCode"=>1));
			}else{
				$this->response->send(array("result"=>0,"message"=>"Password anda gagal diatur ulang !","messageCode"=>1));
			}
		}else{
			$this->response->send(array("result"=>0,"message"=>"Email yang anda masukkan tidak terdaftar !","messageCode"=>1));
		}
	}
	
	// diabuat oleh adi 06-08-2015
	public function reset_password(){
			$data['email']=$this->uri->segment(3);
			$_SESSION['bonobo']['email']=$data['email'];
			$data['token']=$this->uri->segment(4);
			$result=$this->model_toko->reset_akun($data)->result();
			if(count($result)>0 ){
				$string = $this->template->decrypt($data['token']);
				$pcs = explode('#',$string);
				
				$date = $pcs[2];
				
				if (date("Y-m-d H:i:s") < $date){
					$this->load->view("enduser/cp/bg_rp",$data);
				}else{
					$data['pesanreset']='URL yang anda gunakan tidak valid';
					$data['capcha']=$this->recaptcha->render();
					$this->load->view("enduser/login/bg_login",$data);
				}
				
				//echo $date;
			}else{
				//echo $this->uri->segment(3).'+'.$this->uri->segment(4);
				$_SESSION['bonobo']['notifikasi']='URL yang anda gunakan tidak valid ';
				redirect('index/signin');
			}
	}
	
		// diabuat oleh adi 04-08-2015
	public function new_password(){
			$this->form_validation->set_rules('newpass', '', 'trim|required|min_length[5]|max_length[50]');
			$this->form_validation->set_rules('renewpass', '', 'trim|required|matches[newpass]');
			$msg    = "error";
			$notif  = "";
			if ($this->form_validation->run() == TRUE){
				//$email   		= $this->uri->segment(3);
				$password   = $this->db->escape_str($this->input->post('newpass'));
				$cek	= $this->db->where("email",$_SESSION['bonobo']['email'])->get('tb_toko');
				if(count($cek->result())>0){
					
					$key 		= $this->config->item('saltkey');
					$date = new DateTime();
					$date->modify('+1 day');
					$ex_date = $date->format('Y-m-d H:i:s');
					$string 	= $key."#".$key."#".$ex_date;
					$token		= $this->template->encrypt($string);							
					
					$param  = array(
					"token"=>$token,
					'password'      => md5($password),
					'update_user'   => $_SESSION['bonobo']['email']
					);
				
				$insert = $this->db->where("email",$_SESSION['bonobo']['email'])->update('tb_toko',$param);
					if($insert){
						$msg    = "success";
						$notif  = "Berhasil";
						$_SESSION['bonobo']['notifikasi']='Password telah di perbaharui';

						$QShop  = $this->model_toko->get_by_email($_SESSION['bonobo']['email'])->row();

						$_SESSION['bonobo']['id'] = $QShop->id;
						$_SESSION['bonobo']['name'] = $QShop->name;						
						$_SESSION['bonobo']['image'] = $QShop->image;				
						$_SESSION['bonobo']['facebook'] = $QShop->facebook;
						$_SESSION['bonobo']['step'] = $QShop->step;
						$_SESSION['bonobo']['expired_on'] = $QShop->expired_on;
					}
				}else{
					$msg    = "zero";
					$notif  = "Password yang anda masukkan salah";
				}
			}else{
            
				}
			echo json_encode(array("msg"=>$msg,"notif"=>$notif));
				
	}

	public function tos($value='')
	{
		$this->load->view('enduser/bg_tos');
	}

	public function pp($value='')
	{
		$this->load->view('enduser/bg_pp');
	}
	
	
}

