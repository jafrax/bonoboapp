<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER INDEX WEBSITE
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 12 Juni 2015 by Heri Siswanto, Create controller
* 2. Change 22 Juni 2015 by Dinar Wahyu Wibowo, Change Index
* 3. Change 23 Juni 2015 by Heri Siswanto, Coding Signup, Coding Signin, Signup Facebook, Signin Facebook
*/

class Index extends CI_Controller {

	function __construct(){
        parent::__construct();
		
		$this->load->model("enduser/model_toko");
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
			if(empty($_SESSION['bonobo'])){
				redirect('index/signin');
			}
			
			$this->load->view("enduser/login/bg_signup");
		}else{
			$this->form_validation->set_rules('name', '', 'max_length[50]');
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
					"status"=> 0,
					"create_date"=>date("Y-m-d H:i:s"),
					"create_user"=>$email,
					"update_date"=>date("Y-m-d H:i:s"),
					"update_user"=>$email,
				);
				
				
				$Save = $this->db->insert('tb_toko',$param);
				if($Save){
					$message ="Hi ".$name.", Thank you for registering on vertibox <br>
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
				$this->response->send(array("result"=>0,"message"=>"Terdapat data yang tidak valid","messageCode"=>1));
			}
		}
	}
	
	public function signin(){
		if(!$_POST){
			$this->load->view("enduser/login/bg_login");
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
		$email          = $fb_profile->email;
        $uid			= $this->fb->getUser();
		
		$Save = $this->signup_facebook($fb_profile,$uid);
		if($Save){
			$this->signup();
		}else{
			$this->signup();
		}
	}
	
	public function signin_fb(){
		$fb_profile     = $this->fb->userProfile();
        $SignedRequest  = $this->fb->getSignedRequest();
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
		$QShop  = $this->model_toko->get_by_email($email)->row();
		
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
				
                $Save = $this->db->set('email',$email)
					->set('name',$contact)
					->set('image',$uid.'.jpg')
					->set('facebook',1)
					->set('status',2)
					->set('create_date',date('Y-m-d'))
					->insert('tb_toko');
					
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
	
}

