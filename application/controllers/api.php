<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER API BONOBO
* This Api system for tranfers data using external apps, support for android, ios, windows mobile
*
* Log Activity : ~ Create your log if change this controller ~
. 1. Create 12 Juni 2015 by Heri Siswanto, Create controller
*/



class Api extends CI_Controller {

	function __construct(){
        parent::__construct();
    }
	
	private function isValidApi($api_key){
		if($api_key == "BONOBO-APP-01"){
			return true;
		}else{
			$this->response->send(array("result"=>0,"message"=>"Applikasi anda tidak terdaftar.","messageCode"=>01), true);
			return false;
		}
	}
	
	public function index(){
		/*
		*	------------------------------------------------------------------------------
		*	Validation POST data
		*	------------------------------------------------------------------------------
		*/
		if(!$this->isValidApi($this->response->postDecode("api_key"))){
			return;
		}

		/*
		*	------------------------------------------------------------------------------
		*	Get data products
		*	------------------------------------------------------------------------------
		*/
		$Products = array();
		$QProducts = $this->db
						->select("id")
						->limit(0,10)
						->get("tb_product")
						->result();
		
		foreach($QProducts as $QProduct){
			array_push($Products,$QProduct->id);
		}
		
		
		if($this->response->post("user") != ""){
			/*
			*	------------------------------------------------------------------------------
			*	Get data carts
			*	------------------------------------------------------------------------------
			*/
			$Carts = array();
			$QCarts = $this->db
						->select("id")
						->where("member_id",$this->response->postDecode("user"))
						->limit(0,10)
						->get("tb_cart")
						->result();
		
			foreach($QCarts as $QCart){
				array_push($Carts,$QCart->id);
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Get data message 
			*	------------------------------------------------------------------------------
			*/
			$Messages = array();
			$QCarts = $this->db
						->select("id")
						->where("member_id",$this->response->postDecode("user"))
						->limit(0,10)
						->get("tb_cart")
						->result();
		
			foreach($QCarts as $QCart){
				array_push($Carts,$QCart->id);
			}
		
			$this->response->send(array("result"=>1,"products"=>$Products,"carts"=>$Carts,"messages"=>$Messages), true);
		}else{
			$this->response->send(array("result"=>1,"products"=>$Products), true);
		}
	}
	
	public function doLogin(){
		/*
		*	------------------------------------------------------------------------------
		*	Validation POST data
		*	------------------------------------------------------------------------------
		*/
		if(!$this->isValidApi($this->response->postDecode("api_key"))){
			return;
		}
		
		if($this->response->post("email") == "" || $this->response->postDecode("email") == ""){
			$this->response->send(array("result"=>0,"message"=>"Email masih kosong","messageCode"=>01), true);
			return;
		}
		
		if($this->response->post("password") == "" || $this->response->postDecode("password") == ""){
			$this->response->send(array("result"=>0,"message"=>"Password masih kosong","messageCode"=>01), true);
			return;
		}
		
		$QUser = $this->db
			->where("email",$this->response->postDecode("email"))
			->where("password",md5($this->response->postDecode("password")))
			->get("tb_member")
			->row();
			
		if(!empty($QUser)){
			if(@getimagesize(base_url("assets/pic/user/".$QUser->image))){
					$UserImageUrl = base_url("image.php?q=50&ff=".base64_encode(base_url("assets/pic/user/".$QUser->image)));
				}else{
					$UserImageUrl = base_url("image.php?q=50&ff=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	get data member banks
				*	------------------------------------------------------------------------------
				*/
				
				$QBanks = $this->db
						->select("mb.id, tmb.acc_name as acc_name, tmb.acc_no as acc_no, mb.id as bank_id, mb.name as bank_name")
						->join("ms_bank mb","tmb.bank_id = mb.id")
						->where("tmb.member_id",$QUser->id)
						->get("tb_member_bank tmb")
						->result();
				
				$Banks = array();
				foreach($QBanks as $QBank){
					if(@getimagesize(base_url("assets/pic/bank/".$QBank->image))){
						$BankImageUrl = base_url("image.php?q=50&ff=".base64_encode(base_url("assets/pic/bank/".$QBank->image)));
					}else{
						$BankImageUrl = base_url("image.php?q=50&ff=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
					}
				
					$Bank = array(
							"id"=>$QBank->id,
							"accName"=>$QBank->acc_name,
							"accNo"=>$QBank->acc_no,
							"bank_name"=>$QBank->bank_name,
							"imageUrl"=>$BankImageUrl,
						);
						
					array_push($Banks,$Bank);
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	get data member locations
				*	------------------------------------------------------------------------------
				*/
				
				$QLocations = $this->db
						->select("ml.*")
						->join("ms_location ml","tml.location_id = ml.id")
						->where("tml.member_id",$QUser->id)
						->get("tb_member_location tml")
						->result();
				
				$Locations = array();
				foreach($QLocations as $QLocation){
					$Location = array(
							"id"=>$QLocation->id,
							"postal"=>$QLocation->postal_code,
							"kelurahan"=>$QLocation->kelurahan,
							"kecamatan"=>$QLocation->kecamatan,
							"city"=>$QLocation->city,
							"province"=>$QLocation->province,
						);
						
					array_push($Locations,$Location);
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	set data member
				*	------------------------------------------------------------------------------
				*/
				
				$User = array(
						"id"=>$QUser->id,
						"name"=>$QUser->name,
						"email"=>$QUser->email,
						"phone"=>$QUser->phone,
						"imageUrl"=>$UserImageUrl,
						"banks"=>$Banks,
						"locations"=>$Locations,
						"messages"=>$Locations,
					);
				
				$this->response->send(array("result"=>1,"user"=>$User), true);
		}else{
			$this->response->send(array("result"=>0,"message"=>"Email / password anda tidak sesuai","messageCode"=>01), true);
		}
	}
	
	public function doSignup(){
		/*
		*	------------------------------------------------------------------------------
		*	Validation POST data
		*	------------------------------------------------------------------------------
		*/
		if(!$this->isValidApi($this->response->postDecode("api_key"))){
			return;
		}
		
		if($this->response->post("name") == "" || $this->response->postDecode("name") == ""){
			$this->response->send(array("result"=>0,"message"=>"Nama masih kosong","messageCode"=>01), true);
			return;
		}
		
		if($this->response->post("email") == "" || $this->response->postDecode("email") == ""){
			$this->response->send(array("result"=>0,"message"=>"Email masih kosong","messageCode"=>01), true);
			return;
		}
		
		if($this->response->post("password") == "" || $this->response->postDecode("password") == ""){
			$this->response->send(array("result"=>0,"message"=>"Password masih kosong","messageCode"=>01), true);
			return;
		}
		
		if($this->response->post("password_re") == "" || $this->response->postDecode("password_re") == ""){
			$this->response->send(array("result"=>0,"message"=>"Ulangi password masih kosong","messageCode"=>01), true);
			return;
		}
		
		if($this->response->postDecode("password") != $this->response->postDecode("password_re")){
			$this->response->send(array("result"=>0,"message"=>"Password tidak sesuai","messageCode"=>01), true);
			return;
		}
		
		$QUser = $this->db->where("email",$this->response->postDecode("email"))->get("tb_member")->row();
		if(!empty($QUser)){
			$this->response->send(array("result"=>0,"message"=>"Email tidak valid, gunakan email yang lain","messageCode"=>01), true);
			return;
		}

		/*
		*	------------------------------------------------------------------------------
		*	Save new member
		*	------------------------------------------------------------------------------
		*/
		$OUser = array(
					"name"=>$this->response->postDecode("name"),
					"email"=>$this->response->postDecode("email"),
					"password"=>md5($this->response->postDecode("password")),
					"create_date"=>date("Y-m-d H:i:s"),
					"create_user"=>$this->response->postDecode("email"),
					"update_date"=>date("Y-m-d H:i:s"),
					"update_user"=>$this->response->postDecode("email"),
				);
				
		$Save = $this->db->insert("tb_member",$OUser);
		if($Save){
			/*
			*	------------------------------------------------------------------------------
			*	get data new member
			*	------------------------------------------------------------------------------
			*/

			$QUser = $this->db
					->where("email",$this->response->postDecode("email"))
					->get("tb_member")
					->row();
			
			if(!empty($QUser)){
				if(@getimagesize(base_url("assets/pic/user/".$QUser->image))){
					$UserImageUrl = base_url("image.php?q=50&ff=".base64_encode(base_url("assets/pic/user/".$QUser->image)));
				}else{
					$UserImageUrl = base_url("image.php?q=50&ff=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	get data member banks
				*	------------------------------------------------------------------------------
				*/
				
				$QBanks = $this->db
						->select("mb.id, tmb.acc_name as acc_name, tmb.acc_no as acc_no, mb.id as bank_id, mb.name as bank_name")
						->join("ms_bank mb","tmb.bank_id = mb.id")
						->where("tmb.member_id",$QUser->id)
						->get("tb_member_bank tmb")
						->result();
				
				$Banks = array();
				foreach($QBanks as $QBank){
					if(@getimagesize(base_url("assets/pic/bank/".$QBank->image))){
						$BankImageUrl = base_url("image.php?q=50&ff=".base64_encode(base_url("assets/pic/bank/".$QBank->image)));
					}else{
						$BankImageUrl = base_url("image.php?q=50&ff=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
					}
				
					$Bank = array(
							"id"=>$QBank->id,
							"accName"=>$QBank->acc_name,
							"accNo"=>$QBank->acc_no,
							"bank_name"=>$QBank->bank_name,
							"imageUrl"=>$BankImageUrl,
						);
						
					array_push($Banks,$Bank);
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	get data member locations
				*	------------------------------------------------------------------------------
				*/
				
				$QLocations = $this->db
						->select("ml.*")
						->join("ms_location ml","tml.location_id = ml.id")
						->where("tml.member_id",$QUser->id)
						->get("tb_member_location tml")
						->result();
				
				$Locations = array();
				foreach($QLocations as $QLocation){
					$Location = array(
							"id"=>$QLocation->id,
							"postal"=>$QLocation->postal_code,
							"kelurahan"=>$QLocation->kelurahan,
							"kecamatan"=>$QLocation->kecamatan,
							"city"=>$QLocation->city,
							"province"=>$QLocation->province,
						);
						
					array_push($Locations,$Location);
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	set data member
				*	------------------------------------------------------------------------------
				*/
				
				$User = array(
						"id"=>$QUser->id,
						"name"=>$QUser->name,
						"email"=>$QUser->email,
						"phone"=>$QUser->phone,
						"imageUrl"=>$UserImageUrl,
						"banks"=>$Banks,
						"locations"=>$Locations,
						"messages"=>$Locations,
					);
				
				$this->response->send(array("result"=>1,"user"=>$User), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Pendaftaran tidak berhasil","messageCode"=>01), true);
			}
		}else{
			$this->response->send(array("result"=>0,"message"=>"Pendaftaran tidak berhasil","messageCode"=>01), true);
		}
	}
	
	public function doForgotPassword(){
		/*
		*	------------------------------------------------------------------------------
		*	Validation POST data
		*	------------------------------------------------------------------------------
		*/
		if(!$this->isValidApi($this->response->postDecode("api_key"))){
			return;
		}
		
		if($this->response->post("email") == "" || $this->response->postDecode("email") == ""){
			$this->response->send(array("result"=>0,"message"=>"Email masih kosong","messageCode"=>01), true);
			return;
		}
		
		$QUser = $this->db
				->where("email",$this->response->postDecode("email"))
				->get("tb_member")
				->row();
		
		if(!empty($QUser)){
			$verify_code 	= $this->template->rand(20);
			$save	= $this->db->set('verified_code',$verify_code)->where('id',$QUser->id)->update('tb_member');
					
			$message ="
					Hi ".$QUser->name.", To reset your password, <br>
					Click this link below or copy and paste this link in your browser:<br>
					<a href='".base_url("api/doForgotPasswordProcess/".base64_encode($QUser->email)."/".base64_encode($verify_code))."'>".base_url("api/doForgotPasswordProcess/".base64_encode($QUser->email)."/".base64_encode($verify_code))."</a><br><br>		
					Thanks, Bonobo.com
				";
			
			$sendEmail = $this->template->send_email($QUser->email,'Reset password bonobo account',$message);
			
			$this->response->send(array("result"=>1,"message"=>"Kami telah mengirimkan email konfirmasi, silahkan buka email anda dan aktivasi akun anda.","messageCode"=>01), true);
		}else{
			$this->response->send(array("result"=>0,"message"=>"Email anda belum terdaftar.","messageCode"=>01), true);
		}
	}
	
	public function doForgotPasswordProcess(){
		if($this->uri->segment(3) == null){
			$this->response->send(array("result"=>0,"message"=>"Invalid data","messageCode"=>01), false);
			return;
		}
		
		if($this->uri->segment(4) == null){
			$this->response->send(array("result"=>0,"message"=>"Invalid data validation","messageCode"=>01), false);
			return;
		}
		
		$email	= base64_decode($this->uri->segment(3));
		$verify_code	= base64_decode($this->uri->segment(4));
		
		$QUser = $this->db
				->where("email", $email)
				->where("verified_code", $verify_code)
				->get("tb_member")
				->row();
		
		if(!empty($QUser)){
			$this->response->send(array("result"=>1,"message"=>"Password telah direset","messageCode"=>01), false);
		}else{
			$this->response->send(array("result"=>0,"message"=>"Akun tidak terdaftar.","messageCode"=>01), false);
		}
	}
	
	
	
}

