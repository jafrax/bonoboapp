<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
/*
* CONTROLLER INDEX WEBSITE
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 12 Juni 2015 by Heri Siswanto, Create controller
* 2. Change 22 Juni 2015 by Dinar Wahyu Wibowo, Change Index
* 3. Change 23 Juni 2015 by Heri Siswanto, Coding Signup, Coding Signin, Signup Facebook, Signin Facebook
* 4. Create 03 Juli 2015 by adi Setyo, Cek Mail
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
			redirect('toko/');
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
					"pm_transfer"=>1,
					"status"=> 0,
					"create_date"=>date("Y-m-d H:i:s"),
					"create_user"=>$email,
					"update_date"=>date("Y-m-d H:i:s"),
					"update_user"=>$email,
				);
				
				
				$Save = $this->db->insert('tb_toko',$param);
				if($Save){
					$message ="Hi ".$name.", Thank you for registering on bonobo <br>
						To verified your account, you can access this link below :<br><br>
						<a href='".base_url("index/signup_verification/".$email."/".$verify)."'>".base_url("index/signup_verification/".$email."/".$verify)."</a><br><br>
						And then use your email or username to login. <br><br>
						Thanks, Bonobo.com
					";
					
					$send_email = $this->template->send_email($email,'Verified bonobo account', $message);
					
					$this->response->send(array("result"=>1,"message"=>"Pendaftaran berhasil, kami telah mengirimkan pesan verifikasi ke alamat email anda.","messageCode"=>1));
				}else{
					$this->response->send(array("result"=>0,"message"=>"Pendaftaran anda tidak berhasil, coba ulangi lagi","messageCode"=>1));
				}
			}else{
				$this->response->send(array("result"=>0,"message"=>"Periksa kembali field anda","messageCode"=>1));//json error
			}
		}
	}
	
	public function signup_verification(){
		$uri_mail	=	$this->uri->segment(3);
		$uri_veri	=	$this->uri->segment(4);
		$ftv		= 	$this->model_toko->get_by_verf($uri_mail,$uri_veri);
		$_SESSION['bonobo']['notifikasi']=null;
		if($ftv->num_rows()>0){
			$_SESSION['bonobo']['notifikasi']="<div id='notifikasi' class='notif-error'><i class='fa fa-warning'></i>Verifikasi Email sukses</div>";
			$Data=array('status'=> '2');
			$Update = $this->db->where("verified_code",$uri_veri)->update("tb_toko",$Data);
		}else{
			$_SESSION['bonobo']['notifikasi']="<div id='notifikasi' class='notif-error'><i class='fa fa-warning'></i>Verifikasi email failed</div>";
		}
		redirect('index/signin');
	
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
			$data["captcha"] = $this->recaptcha->recaptcha_get_html();
			$this->load->view("enduser/login/bg_login", $data);
        }else{
            $this->form_validation->set_rules('email', '', 'required');
            $this->form_validation->set_rules('password', '', 'required');
            
			$email      = mysql_real_escape_string($this->input->post('email'));
            $password   = md5(mysql_real_escape_string($this->input->post('password')));
			
            $QShop = $this->model_toko->get_by_login($email,$password)->row();
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
					
					$this->response->send(array("result"=>1,"message"=>"Selamat datang ".$QShop->name,"messageCode"=>3));
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
		
		
		$Save = $this->signup_facebook($fb_profile,$uid);
		$QShop  = $this->model_toko->get_by_email($email)->row();		
		if(!empty($QShop)){				
			$_SESSION['bonobo']['id'] = $QShop->id;
			$_SESSION['bonobo']['name'] = $QShop->name;
			$_SESSION['bonobo']['email'] = $QShop->email;
			$_SESSION['bonobo']['image'] = $QShop->image;				
			$_SESSION['bonobo']['facebook'] = $QShop->facebook;
			
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
						"pm_transfer"=>1,
						"facebook"=>1,
						"status"=>2,
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
		if($this->response->post("email") == ""){
			$this->response->send(array("result"=>0,"message"=>"Email harus diisi !","messageCode"=>1));
			return;
		}
		$this->recaptcha->recaptcha_check_answer($_SERVER["REMOTE_ADDR"],$this->input->post("recaptcha_challenge_field"), $this->input->post("recaptcha_response_field"));
		if(!$this->recaptcha->getIsValid()){
			$this->response->send(array("result"=>0,"message"=>"Kode keamanan tidak sesuai"));
			return;
		}
		
		
		$QShop = $this->model_toko->get_by_email($this->response->post("email"))->row();
		if(!empty($QShop)){
			$NewPassword = $this->template->rand(6);
			$Data = array(
						"password"=>md5($NewPassword)
					);
			
			$Save = $this->db->where("id",$QShop->id)->update("tb_toko",$Data);
			if($Save){
				$message ="Hi ".$QShop->name.", this is your new password in Bonobo.com<br>
						Email : ".$QShop->email."<br>
						Password : ".$NewPassword."<br><br>
						Thanks, Bonobo.com
					";
					
				$this->template->send_email($QShop->email,'New Password Account Bonobo', $message);
				
				$this->response->send(array("result"=>1,"message"=>"Password anda telah diatur ulang, silahkan lihat pesan kami di email anda!","messageCode"=>1));
			}else{
				$this->response->send(array("result"=>0,"message"=>"Password anda gagal diatur ulang !","messageCode"=>1));
			}
		}else{
			$this->response->send(array("result"=>0,"message"=>"Email yang anda masukkan tidak terdaftar !","messageCode"=>1));
		}
	}
	
}

