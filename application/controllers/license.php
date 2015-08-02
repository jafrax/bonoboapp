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

		$active_code = $this->db->where('toko_id',$id)->where('validity',0)->where('code',$code)->get('tb_activation_code');
		if ($active_code->num_rows() > 0) {
			$this->db->where('id',$id)->set('activation_code',$code)->set('expired_on',$date)->update('tb_toko');
			echo "1";			
		}else{

		}
	}
	
}

