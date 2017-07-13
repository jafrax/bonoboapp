<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Admin CONTROLLER INDEX
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 July 2015 by Adi Setyo, Create controller : Coding index, Coding signin
*/
class Index extends CI_Controller {
	var $data = array('scjav'=>'');
    function __construct(){
        parent::__construct();
        $this->load->model("admin/model_index");
        $this->load->model("admin/model_account");
    }
    
    public function index(){
        if(empty($_SESSION['bonobo_admin']) || empty($_SESSION['bonobo_admin']->id)){
            redirect('admin/index/signin');
            
            
        }else{
            redirect('admin/index/dashboard');
        }

    }

    public function signin (){
		if(!$_POST){
			$this->load->view('admin/login/bg_login');
		}else{
			$this->form_validation->set_rules('email', '', 'email|trim|required|');
			$this->form_validation->set_rules('password', '', 'trim|required');

			$username 	= $this->response->post('email');
			$password 	= $this->response->post('password');

			

			if ($this->form_validation->run() == TRUE) {

				$validate 	= $this->db->where('email',$username)->where('password',md5($password))->get('tb_admin');
				
				if ($validate->num_rows() > 0) {
					
					$_SESSION['bonobo_admin'] = $validate->row();
					redirect('admin');					
				}else{
					$_SESSION['login_error']='Username or password is wrong';
				}
			}else{
				$_SESSION['login_error']='Your input data is wrong';
			}
			redirect('admin');
		} 
    }
	
public function forgot_password(){
		if(!$_POST){
			$data['capcha']=$this->recaptcha->render();
			$this->load->view('admin/login/bg_forgot_password');
		}else{
			$this->form_validation->set_rules('email', '', 'email|trim|required|');
			

			//$username 	= $this->response->post('email');
					
			$data['email_user']=$this->response->post("email");
		if($data['email_user'] == ""){
			$_SESSION['login_error']='Email harus diisi';
			redirect('admin/index/forgot_password');
		}
				
		
		$Qadmin = $this->model_account->get_by_email($this->response->post("email"))->row();
		if(!empty($Qadmin)){
			// start kirim kode ke email
			
			$key 		= $this->config->item('saltkey');
			
			
			$string 	= $key."#".$data['email_user'];
			
			$token		= $this->template->encrypt($string);
			//echo $ex_date;
			$Data = array(
						"token"=>$token
					);
			
			$Save = $this->db->where("id",$Qadmin->id)->update("tb_admin",$Data);
			if($Save){
				$message ="
					Hi ".$Qadmin->name.",<br><br>

					Silakan klik link (URL) berikut ini untuk mereset password. URL akan kadaluarsa dalam waktu
					1 x 24 jam.<br><br>
					".site_url("admin/index/reset_password/".$data['email_user']."/".$token."")."
					<br><br>
					Terima Kasih,<br>

					Tim Bonobo
					";
					
				$this->template->send_email($Qadmin->email,'[BONOBO] Lupa Password', $message);
				// end email send
				$_SESSION['login_error']='Silahkan lihat pesan kami di email anda!';
			//	$this->response->send(array("result"=>1,"message"=>"Silahkan lihat pesan kami di email anda!","messageCode"=>1));
			}else{
				$_SESSION['login_error']='Password anda gagal diatur ulang !';
				//$this->response->send(array("result"=>0,"message"=>"Password anda gagal diatur ulang !","messageCode"=>1));
			}
		}else{
			$_SESSION['login_error']='Email yang anda masukkan tidak terdaftar !';
			//$this->response->send(array("result"=>0,"message"=>"Email yang anda masukkan tidak terdaftar !","messageCode"=>1));
		}

			redirect('admin/index/forgot_password');
		} 
    }

    public function reset_password(){
			$data['email']=$this->uri->segment(4);
		//	$_SESSION['bonobo']['email']=$data['email'];
			$data['token']=$this->uri->segment(5);
			$result = $this->model_account->reset_akun($data)->result();
			if(count($result)>0 ){
				$string = $this->template->decrypt($data['token']);
				//$pcs = explode('#',$string);
				
				//$date = $pcs[2];
				
				//if (date("Y-m-d H:i:s") < $date){
					$this->load->view("admin/cp/bg_rp",$data);
				// }else{
				// 	$data['pesanreset']='URL yang anda gunakan tidak valid';
				// 	$data['capcha']=$this->recaptcha->render();
				// 	$this->load->view("enduser/login/bg_login",$data);
				// }
				
				//echo $date;
			}else{
				//echo $this->uri->segment(3).'+'.$this->uri->segment(4);
			
				
				//$_POST=null;
				//$this->signin();
				echo "<script>alert('URL yang anda gunakan tidak valid !!!');
				window.location = '".site_url('admin/index')."';
				</script>";
				//redirect('admin/index');
			}
	}
	
		// diabuat oleh adi 04-08-2015
	public function new_password(){
			$this->form_validation->set_rules('newpass', '', 'trim|required|min_length[5]|max_length[50]');
			$this->form_validation->set_rules('renewpass', '', 'trim|required|matches[newpass]');
			$msg    = "error";
			$notif  = "";
			$email   		= $this->input->post('email');
		if(strlen($this->input->post('newpass')) >= 5  ){	
			if ($this->form_validation->run() == TRUE){
				
				$password   = $this->db->escape_str($this->input->post('newpass'));
				$cek	= $this->db->where("email",$email)->get('tb_admin');
				
				if(count($cek->result())>0){
					
					$key 		= $this->config->item('saltkey');
					
					$string 	= $key."#".$key;
					$token		= $this->template->encrypt($string);							
					
					$param  = array(
					"token"=>$token,
					'password'      => md5($password),
					'update_user'   => $email
					);
				
				$insert = $this->db->where("email",$email)->update('tb_admin',$param);
					if($insert){
						$msg    = 'success';
						$notif  = "Berhasil";
						//$_SESSION['bonobo']['notifikasi']='Password telah di perbaharui';

						$Qadmin  = $this->model_account->get_by_email($email)->row();

						// $_SESSION['bonobo']['id'] = $Qadmin->id;
						// $_SESSION['bonobo']['name'] = $Qadmin->name;	
						// $_SESSION['bonobo']['email'] = $email;				
										}
				}else{
					$msg    = "zero";
					$notif  = "Password yang anda masukkan salah";
					$_SESSION['login_error']='Password yang anda masukkan salah !';
										
				}
			}else{
            $msg    = "zero";
					$notif  = "tidak valid";
					$_SESSION['login_error']=' Password tidak sama!';
					
				}
		}else{
			$msg    = "zero";
					$notif  = "password salah";
					$_SESSION['login_error']='Password tidak boleh kurang dari 5 karakter !';
		}


			echo json_encode(array("msg"=>$msg,"notif"=>$notif));
				
	}
	

	public function dashboard(){
	 if(empty($_SESSION['bonobo_admin']) || empty($_SESSION['bonobo_admin']->id)){
            redirect('admin/index/signin');
            return;
        }else{
            $this->template->bonobo_admin('dashboard/bg_dashboard',$this->data);
        }
	}
	
	public function logout(){
		 unset($_SESSION['bonobo_admin']);
		 unset($_SESSION['login_error']);
        // session_destroy();
		 redirect('admin');
	}

}
