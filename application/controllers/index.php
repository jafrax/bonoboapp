<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER INDEX WEBSITE
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
. 1. Create 12 Juni 2015 by Heri Siswanto, Create controller
. 2. Change 22 Juni 2015 by Dinar Wahyu Wibowo, Change Index
*/

class Index extends CI_Controller {

	function __construct(){
        parent::__construct();
		$this->load->model('Facebook_Model', 'fb');
        $this->load->library('recaptcha');
		
		$this->getFbUser = $this->fb->getUser();
        $this->data['getFbUser'] = $this->getFbUser;
		
		set_time_limit (99999999999);
    }
	
	public function index(){
		if(!$_POST){
			$this->load->view("login/bg_login");
        }else{
            $this->form_validation->set_rules('uname', '', 'required');
            $this->form_validation->set_rules('passwd', '', 'required');
            $email      = mysql_real_escape_string($this->input->post('uname'));
            $password   = mysql_real_escape_string($this->input->post('passwd'));
            $cek = $this->get_user($password,$email);
            if($cek->num_rows > 0){
				foreach($cek->result() as $row){
					if($row->status == 0){
						echo $this->template->notif("account_not_verified")." To resend email verification <a onclick=javascript:to_resend_email('$email','".base64_encode($password)."') style='cursor:pointer'>click here</a>";
					}elseif($row->status == 2){
						echo $this->template->notif("account_suspended");;
					}else{
						$_SESSION['bonobo']['id']				= $row->id;
						$_SESSION['bonobo']['username']			= $row->email;
						$_SESSION['bonobo']['email']			= $row->email;
						$_SESSION['bonobo']['facebook']			= 0;
						echo 'sukses';
					}
				}
			}else{
				echo $this->template->notif("email_password_failed");
			}          
        }			
	}

	private function get_user($password,$email){
        return $this->db->select('a.*, b.name as company, b.hastag')
            ->join('tb_company b','b.id = a.company_id','left')
			->where('password',md5($password))
			->where('email',$email)
			->where('user_group_id',2)
            ->get('tb_user a');
    }
	
	private function get_user_fb($email){
        return $this->db->select('a.*, b.name as company, b.hastag')
            ->join('tb_company b','b.id = a.company_id','left')
			->where('email',$email)
			->where('user_group_id',2)
            ->get('tb_user a');
    }

	public function signup(){
		if(!$_POST){
			if(isset($_SESSION['bononbo'])){
				redirect('home');
			}
			$this->load->view("login/bg_signup");
		}else{
			$this->form_validation->set_rules('name', '', 'max_length[50]');			
			$this->form_validation->set_rules('email', '', 'required|max_length[50]|valid_email|is_unique[tb_user.email]');
			$this->form_validation->set_rules('password', '', 'required|min_length[5]|max_length[50]');
			$this->form_validation->set_rules('repassword', '', 'required|matches[password]');			
			
			if ($this->form_validation->run() == TRUE){
				$name    	= mysql_real_escape_string($this->input->post('name'));				
				$email      = mysql_real_escape_string($this->input->post('email'));
				$password   = mysql_real_escape_string($this->input->post('password'));
				$repassword = mysql_real_escape_string($this->input->post('repassword'));				
				$verify 	= $this->template->rand(20);
				$param  = array(					
					'name'  	=> $name,					
					'email'     	=> $email,
					'password'  	=> md5($password),					
					'verified_code'	=>$verify,
					'create_date'	=>date('Y-m-d'),
					'status'		=> 0
				);
				
				$insert = $this->db->insert('tb_user',$param);
				if($insert){
					$_SESSION['sign_email']	= $email;
					$_SESSION['sign_pass']	= $password;
					$_SESSION['sign_name']	= $name;
					$_SESSION['sign_key'] 	= $verify;
					$message ="Hi $name,
						Thank you for registering on vertibox <br>
						To activate your account, you can access this link below:<br>
						<a href='".base_url()."login/verification/$email/$verify'>".base_url()."login/verification/$email/$verify</a><br>
						And then use your email or username to login. <br>
						
						
						Thanks, vertibox.com
					";
					$email = $this->template->send_email($email,'Verification vertibox account',$message);
					echo 'sukses';
					//redirect('login/direct_signup');
					
				}else{
					echo $this->template->notif("signup_failed_try");
				}
			}else{
				echo $this->template->notif("signup_failed_form");
			}
			//redirect('login/signup');
		}
	}
}

