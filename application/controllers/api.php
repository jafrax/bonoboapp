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
			$this->response->send(array("result"=>0,"message"=>"Applikasi anda tidak terdaftar.","messageCode"=>0), true);
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
			$this->response->send(array("result"=>0,"message"=>"Email masih kosong","messageCode"=>1), true);
			return;
		}
		
		if($this->response->post("password") == "" || $this->response->postDecode("password") == ""){
			$this->response->send(array("result"=>0,"message"=>"Password masih kosong","messageCode"=>2), true);
			return;
		}
		
		$QUser = $this->db
			->where("email",$this->response->postDecode("email"))
			->where("password",md5($this->response->postDecode("password")))
			->get("tb_member")
			->row();
			
		if(!empty($QUser)){
			if(@getimagesize(base_url("assets/pic/user/".$QUser->image))){
					$UserImageUrl = base_url("image.php?q=50&fe=".base64_encode(base_url("assets/pic/user/".$QUser->image)));
				}else{
					$UserImageUrl = base_url("image.php?q=50&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	get data member attribute
				*	------------------------------------------------------------------------------
				*/
				
				$QAttributes = $this->db
						->where("tma.member_id",$QUser->id)
						->get("tb_member_attribute tma")
						->result();
				
				$Attributes = array();
				foreach($QAttributes as $QAttribute){
					$Attribute = array(
							"id"=>$QAttribute->id,
							"name"=>$QAttribute->name,
							"value"=>$QAttribute->value,
						);
						
					array_push($Attributes,$Attribute);
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
						$BankImageUrl = base_url("image.php?q=50&fe=".base64_encode(base_url("assets/pic/bank/".$QBank->image)));
					}else{
						$BankImageUrl = base_url("image.php?q=50&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
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
						"contacts"=>$Attributes,
						"banks"=>$Banks,
						"locations"=>$Locations,
					);
				
				$this->response->send(array("result"=>1,"user"=>$User), true);
		}else{
			$this->response->send(array("result"=>0,"message"=>"Email / password anda tidak sesuai","messageCode"=>3), true);
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
			$this->response->send(array("result"=>0,"message"=>"Nama masih kosong","messageCode"=>1), true);
			return;
		}
		
		if($this->response->post("email") == "" || $this->response->postDecode("email") == ""){
			$this->response->send(array("result"=>0,"message"=>"Email masih kosong","messageCode"=>2), true);
			return;
		}
		
		if($this->response->post("password") == "" || $this->response->postDecode("password") == ""){
			$this->response->send(array("result"=>0,"message"=>"Password masih kosong","messageCode"=>3), true);
			return;
		}
		
		if($this->response->post("password_re") == "" || $this->response->postDecode("password_re") == ""){
			$this->response->send(array("result"=>0,"message"=>"Ulangi password masih kosong","messageCode"=>4), true);
			return;
		}
		
		if($this->response->postDecode("password") != $this->response->postDecode("password_re")){
			$this->response->send(array("result"=>0,"message"=>"Password tidak sesuai","messageCode"=>5), true);
			return;
		}
		
		$QUser = $this->db->where("email",$this->response->postDecode("email"))->get("tb_member")->row();
		if(!empty($QUser)){
			$this->response->send(array("result"=>0,"message"=>"Email tidak valid, gunakan email yang lain","messageCode"=>6), true);
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
					$UserImageUrl = base_url("image.php?q=50&fe=".base64_encode(base_url("assets/pic/user/".$QUser->image)));
				}else{
					$UserImageUrl = base_url("image.php?q=50&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	get data member attribute
				*	------------------------------------------------------------------------------
				*/
				
				$QAttributes = $this->db
						->where("tma.member_id",$QUser->id)
						->get("tb_member_attribute tma")
						->result();
				
				$Attributes = array();
				foreach($QAttributes as $QAttribute){
					$Attribute = array(
							"id"=>$QAttribute->id,
							"name"=>$QAttribute->name,
							"value"=>$QAttribute->value,
						);
						
					array_push($Attributes,$Attribute);
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
						"contacts"=>$Attributes,
						"banks"=>$Banks,
						"locations"=>$Locations,
					);
				
				$this->response->send(array("result"=>1,"user"=>$User), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Pendaftaran tidak berhasil","messageCode"=>7), true);
			}
		}else{
			$this->response->send(array("result"=>0,"message"=>"Pendaftaran tidak berhasil","messageCode"=>8), true);
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
			$this->response->send(array("result"=>0,"message"=>"Email masih kosong","messageCode"=>1), true);
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
			
			$this->response->send(array("result"=>1,"message"=>"Kami telah mengirimkan email konfirmasi, silahkan buka email anda dan aktivasi akun anda.","messageCode"=>2), true);
		}else{
			$this->response->send(array("result"=>0,"message"=>"Email anda belum terdaftar.","messageCode"=>3), true);
		}
	}
	
	public function doForgotPasswordProcess(){
		if($this->uri->segment(3) == null){
			$this->response->send(array("result"=>0,"message"=>"Invalid data","messageCode"=>1), false);
			return;
		}
		
		if($this->uri->segment(4) == null){
			$this->response->send(array("result"=>0,"message"=>"Invalid data validation","messageCode"=>2), false);
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
			$this->response->send(array("result"=>1,"message"=>"Password telah direset","messageCode"=>3), false);
		}else{
			$this->response->send(array("result"=>0,"message"=>"Akun tidak terdaftar.","messageCode"=>4), false);
		}
	}
	
	public function getProducts(){
		/*
		*	------------------------------------------------------------------------------
		*	Validation POST data
		*	------------------------------------------------------------------------------
		*/
		if(!$this->isValidApi($this->response->postDecode("api_key"))){
			return;
		}
		
		if($this->response->post("user") == "" || $this->response->postDecode("user") == ""){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>2), true);
			return;
		}
		
		$QUser = $this->db->where("id",$this->response->postDecode("user"))->get("tb_member")->row();
		if(empty($QUser)){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>3), true);
			return;
		}
		
		/*
		*	------------------------------------------------------------------------------
		*	Query mengambil data produk berdasarkan filter dan paging
		*	------------------------------------------------------------------------------
		*/
		$QProduct = $this->db;
		$QProduct = $QProduct->select("tp.*,tkcp.id as category_id, tkcp.name as category_name, tkcp.toko_id as toko_id");
		$QProduct = $QProduct->join("tb_toko_category_product tkcp","tkcp.id = tp.toko_category_product_id");
		
		if($this->response->post("keyword") != "" && $this->response->postDecode("keyword") != ""){
			$QProduct = $QProduct->like("tp.name",$this->response->postDecode("keyword"));
		}
		
		if($this->response->post("stock_type") != "" && $this->response->postDecode("stock_type") != ""){
			$QProduct = $QProduct->where("tp.stock_type",$this->response->postDecode("stock_type"));
		}
		
		if($this->response->post("page") != "" && $this->response->postDecode("page") != ""){
			$QProduct = $QProduct->limit(10,$this->response->postDecode("page"));
		}else{
			$QProduct = $QProduct->limit(10,0);
		}
		
		$QProduct = $QProduct->get("tb_product tp");
		$QProducts = $QProduct->result();
		
		if(sizeOf($QProducts) > 0){
			$Products = array();
			foreach($QProducts as $QProduct){
				/*
				*	------------------------------------------------------------------------------
				*	Query mengambil data produk image 
				*	------------------------------------------------------------------------------
				*/
				$QProductImages = $this->db
								->where("product_id", $QProduct->id)
								->get("tb_product_image")
								->result();
								
				$ProductImages = array();
				foreach($QProductImages as $QProductImage){
					$ProductImage = array(
								"id"=>$QProductImage->id,
								"imageUrl"=>base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/product/".$QProductImage->file))),
							);
									
					array_push($ProductImages,$ProductImage);
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	Query mengambil data produk varian 
				*	------------------------------------------------------------------------------
				*/
				$ProductVarians = $this->db
								->where("product_id", $QProduct->id)
								->get("tb_product_varian")
								->result();
				
				/*
				*	------------------------------------------------------------------------------
				*	Query mengambil data produk toko 
				*	------------------------------------------------------------------------------
				*/
				$QProductShop = $this->db
								->select("tk.*, ml.id as location_id, ml.kecamatan as location_kecamatan, ml.city as location_city, ml.province as location_province, ml.postal_code as location_postal, mc.id as category_id, mc.name as category_name")
								->join("ms_location ml","ml.id = tk.location_id")
								->join("ms_category mc","mc.id = tk.category_id")
								->where("tk.id",$QProduct->toko_id)
								->get("tb_toko tk")
								->row();
								
				$ProductShop = array(
								"id"=>$QProductShop->id,
								"name"=>$QProductShop->name,
								"description"=>$QProductShop->description,
								"phone"=>$QProductShop->phone,
								"tag_name"=>$QProductShop->tag_name,
								"keyword"=>$QProductShop->keyword,
								"location"=>array(
										"id"=>$QProductShop->location_id,
										"kecamatan"=>$QProductShop->location_kecamatan,
										"city"=>$QProductShop->location_city,
										"province"=>$QProductShop->location_province,
										"postal"=>$QProductShop->location_postal,
									),
								"category"=>array(
										"id"=>$QProductShop->category_id,
										"name"=>$QProductShop->category_name,
									),
							);
			
				/*
				*	------------------------------------------------------------------------------
				*	Membuat object produk
				*	------------------------------------------------------------------------------
				*/
				$Product = array(
						"id"=>$QProduct->id,
						"name"=>$QProduct->name,
						"description"=>$QProduct->description,
						"sku_no"=>$QProduct->sku_no,
						"weight"=>$QProduct->weight,
						"unit"=>$QProduct->unit,
						"min_order"=>$QProduct->min_order,
						"stock_type"=>$QProduct->stock_type,
						"stock_type_detail"=>$QProduct->stock_type_detail,
						"active"=>$QProduct->active,
						"price_base"=>$QProduct->price_base,
						"price_1"=>$QProduct->price_1,
						"price_2"=>$QProduct->price_2,
						"price_3"=>$QProduct->price_3,
						"price_4"=>$QProduct->price_4,
						"price_5"=>$QProduct->price_5,
						"images"=>$ProductImages,
						"varians"=>$ProductVarians,
						"shop"=>$ProductShop,
					);
						
				array_push($Products,$Product);
			}
		
			$this->response->send(array("result"=>1,"total"=>sizeOf($QProducts),"size"=>sizeOf($QProducts),"products"=>$Products), true);
		}else{
			$this->response->send(array("result"=>0,"message"=>"Tidak ada produk yang ditemukan","messageCode"=>4), true);
		}
	}
	
	public function doProductFavorite(){
		/*
		*	------------------------------------------------------------------------------
		*	Validation POST data
		*	------------------------------------------------------------------------------
		*/
		if(!$this->isValidApi($this->response->postDecode("api_key"))){
			return;
		}
		
		if($this->response->post("product") == "" || $this->response->postDecode("product") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada produk yang dipilih","messageCode"=>1), true);
			return;
		}
		
		if($this->response->post("user") == "" || $this->response->postDecode("user") == ""){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>2), true);
			return;
		}
		
		$QUser = $this->db->where("id",$this->response->postDecode("user"))->get("tb_member")->row();
		if(empty($QUser)){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>3), true);
			return;
		}
		
		$QProduct = $this->db->where("id",$this->response->postDecode("product"))->get("tb_product")->row();
		if(empty($QProduct)){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada produk yang ditemukan","messageCode"=>4), true);
			return;
		}
		
		/*
		*	------------------------------------------------------------------------------
		*	Check produk sudah dan user sudah favorite belum ?
		*	------------------------------------------------------------------------------
		*/
		
		$QFavorite = $this->db
				->where("product_id",$this->response->postDecode("product"))
				->where("member_id",$this->response->postDecode("user"))
				->get("tb_product")
				->row();
					
		if(empty($QFavorite)){
			$Favorite = array(
					"product_id"=>$this->response->postDecode("product"),
					"member_id"=>$this->response->postDecode("user"),
					"create_date"=>date("Y-m-d H:i:s"),
					"create_user"=>$QUser->email,
					"update_date"=>date("Y-m-d H:i:s"),
					"update_user"=>$QUser->email,
				);
					
			$Save = $this->db->insert("tb_favorite",$Favorite);
			
			if($Save){
				$this->response->send(array("result"=>1,"message"=>"Produk telah menjadi favorite anda","messageCode"=>5), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Produk tidak dapat dijadikan favorite","messageCode"=>6), true);
			}
		}else{
			$Delete = $this->db->where("id",$QFavorite->id)->delete("tb_favorite");
			
			if($Delete){
				$this->response->send(array("result"=>1,"message"=>"Produk sudah tidak menjadi favorite anda","messageCode"=>7), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Produk tidak dapat di un-favorite","messageCode"=>8), true);
			}
		}
	}
	
	public function getShops(){
		/*
		*	------------------------------------------------------------------------------
		*	Validation POST data
		*	------------------------------------------------------------------------------
		*/
		if(!$this->isValidApi($this->response->postDecode("api_key"))){
			return;
		}
		
		if($this->response->post("user") == "" || $this->response->postDecode("user") == ""){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>1), true);
			return;
		}
		
		$QUser = $this->db->where("id",$this->response->postDecode("user"))->get("tb_member")->row();
		if(empty($QUser)){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>2), true);
			return;
		}
		
		
		/*
		*	------------------------------------------------------------------------------
		*	Query data-data toko
		*	------------------------------------------------------------------------------
		*/
		$QShops = $this->db;
		
		if($this->response->post("keyword") != "" && $this->response->postDecode("keyword") != ""){
			$QShops = $QShops->like("tt.name",$this->response->postDecode("keyword"));
		}
		
		if($this->response->post("follow") != "" && $this->response->postDecode("follow") != ""){
			if($this->response->postDecode("follow") == 1){
				$QShops = $QShops->where("tt.id in (SELECT id FROM tb_toko_member WHERE member_id = ".$QUser->id.")",true);
			}
		}
		
		if($this->response->post("page") != "" && $this->response->postDecode("page") != ""){
			$QShops = $QShops->limit(10,$this->response->postDecode("page"));
		}else{
			$QShops = $QShops->limit(10,0);
		}
		
		$QShops = $QShops->get("tb_toko tt");
		$QShops = $QShops->result();
		
		if(sizeOf($QShops) > 0){
			$Shops = array();
			foreach($QShops as $QShop){
				$QShopBanks = $this->db
							->select("ttb.id,ttb.acc_name,ttb.acc_no,mb.id as bank_id, mb.name as bank_name")
							->join("ms_bank mb","mb.id = ttb.bank_id")
							->where("ttb.toko_id",$QShop->id)
							->get("tb_toko_bank ttb")
							->result();
							
				$ShopBanks = array();
				foreach($QShopBanks as $QShopBank){
					$ShopBank = array(
							"id"=>$QShopBank->id,
							"acc_name"=>$QShopBank->acc_name,
							"acc_no"=>$QShopBank->acc_no,
							"bank"=>array(
									"id"=>$QShopBank->bank_id,
									"name"=>$QShopBank->bank_name,
								),
						);
					
					array_push($ShopBanks,$ShopBank);
				}
							
				$ShopAttributes = $this->db
							->select("id,name,value")
							->where("toko_id",$QShop->id)
							->get("tb_toko_attribute")
							->result();
				
				$Shop = array(
						"id"=>$QShop->id,
						"name"=>$QShop->name,
						"tag_name"=>$QShop->tag_name,
						"keyword"=>$QShop->keyword,
						"description"=>$QShop->description,
						"phone"=>$QShop->phone,
						"privacy"=>$QShop->privacy,
						"pm_store_payment"=>$QShop->pm_store_payment,
						"pm_transfer"=>$QShop->pm_transfer,
						"dm_pick_up_store"=>$QShop->dm_pick_up_store,
						"dm_store_delivery"=>$QShop->dm_store_delivery,
						"dm_expedition"=>$QShop->dm_expedition,
						"level_1_name"=>$QShop->level_1_name,
						"level_2_name"=>$QShop->level_2_name,
						"level_3_name"=>$QShop->level_3_name,
						"level_4_name"=>$QShop->level_4_name,
						"level_5_name"=>$QShop->level_5_name,
						"status"=>$QShop->status,
						"imageUrl"=>base_url("image.php?q=100&fe=".base64_encode($QShop->image)),
						"shopBanks"=>$ShopBanks,
						"attributes"=>$ShopAttributes,
					);
				
				array_push($Shops,$Shop);
			}
			
			$this->response->send(array("result"=>1,"total"=>sizeOf($QShops),"size"=>sizeOf($QShops),"shops"=>$Shops), true);
		}else{
			$this->response->send(array("result"=>0,"message"=>"Tidak ada toko yang ditemukan","messageCode"=>3), true);
		}
	}
	
	public function getShop(){
		/*
		*	------------------------------------------------------------------------------
		*	Validation POST data
		*	------------------------------------------------------------------------------
		*/
		if(!$this->isValidApi($this->response->postDecode("api_key"))){
			return;
		}
		
		if($this->response->post("user") == "" || $this->response->postDecode("user") == ""){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>1), true);
			return;
		}
		
		$QUser = $this->db->where("id",$this->response->postDecode("user"))->get("tb_member")->row();
		if(empty($QUser)){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>2), true);
			return;
		}
		
		if($this->response->post("shop") == "" || $this->response->postDecode("shop") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data toko yang dipilih","messageCode"=>3), true);
			return;
		}
		
		$QShop = $this->db->where("id",$this->response->postDecode("shop"))->get("tb_toko")->row();
		if(empty($QShop)){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada toko yang ditemukan","messageCode"=>4), true);
			return;
		}
		
		/*
		*	------------------------------------------------------------------------------
		*	Query data bank toko
		*	------------------------------------------------------------------------------
		*/
		
		$QShopBanks = $this->db
					->select("ttb.id,ttb.acc_name,ttb.acc_no,mb.id as bank_id, mb.name as bank_name")
					->join("ms_bank mb","mb.id = ttb.bank_id")
					->where("ttb.toko_id",$QShop->id)
					->get("tb_toko_bank ttb")
					->result();
					
		$ShopBanks = array();
		foreach($QShopBanks as $QShopBank){
			$ShopBank = array(
					"id"=>$QShopBank->id,
					"acc_name"=>$QShopBank->acc_name,
					"acc_no"=>$QShopBank->acc_no,
					"bank"=>array(
							"id"=>$QShopBank->bank_id,
							"name"=>$QShopBank->bank_name,
						),
				);
			
			array_push($ShopBanks,$ShopBank);
		}
		
		/*
		*	------------------------------------------------------------------------------
		*	Query data attribute toko
		*	------------------------------------------------------------------------------
		*/
		$ShopAttributes = $this->db
					->select("id,name,value")
					->where("toko_id",$QShop->id)
					->get("tb_toko_attribute")
					->result();
					
		/*
		*	------------------------------------------------------------------------------
		*	Query data count toko follower
		*	------------------------------------------------------------------------------
		*/
		$ShopFollowers = $this->db
					->select("id")
					->where("toko_id",$QShop->id)
					->get("tb_toko_member")
					->result();
					
		/*
		*	------------------------------------------------------------------------------
		*	Query data count toko product
		*	------------------------------------------------------------------------------
		*/
		$ShopProducts = $this->db
					->select("tp.id")
					->join("tb_toko_category_product ttcp","ttcp.id = tp.toko_category_product_id")
					->where("ttcp.toko_id",$QShop->id)
					->get("tb_product tp")
					->result();
		
		/*
		*	------------------------------------------------------------------------------
		*	Query data lengkap toko
		*	------------------------------------------------------------------------------
		*/
		$Shop = array(
			"id"=>$QShop->id,
			"name"=>$QShop->name,
			"tag_name"=>$QShop->tag_name,
			"keyword"=>$QShop->keyword,
			"description"=>$QShop->description,
			"phone"=>$QShop->phone,
			"privacy"=>$QShop->privacy,
			"pm_store_payment"=>$QShop->pm_store_payment,
			"pm_transfer"=>$QShop->pm_transfer,
			"dm_pick_up_store"=>$QShop->dm_pick_up_store,
			"dm_store_delivery"=>$QShop->dm_store_delivery,
			"dm_expedition"=>$QShop->dm_expedition,
			"level_1_name"=>$QShop->level_1_name,
			"level_2_name"=>$QShop->level_2_name,
			"level_3_name"=>$QShop->level_3_name,
			"level_4_name"=>$QShop->level_4_name,
			"level_5_name"=>$QShop->level_5_name,
			"status"=>$QShop->status,
			"countFollower"=>sizeOf($ShopFollowers),
			"countProduct"=>sizeOf($ShopProducts),
			"imageUrl"=>base_url("image.php?q=100&fe=".base64_encode($QShop->image)),
			"banks"=>$ShopBanks,
			"attributes"=>$ShopAttributes,
		);
			
		$this->response->send(array("result"=>1,"shop"=>$Shop), true);
	}
	
	public function getShopProducts(){
		/*
		*	------------------------------------------------------------------------------
		*	Validation POST data
		*	------------------------------------------------------------------------------
		*/
		if(!$this->isValidApi($this->response->postDecode("api_key"))){
			return;
		}
		
		if($this->response->post("user") == "" || $this->response->postDecode("user") == ""){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>1), true);
			return;
		}
		
		$QUser = $this->db->where("id",$this->response->postDecode("user"))->get("tb_member")->row();
		if(empty($QUser)){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>2), true);
			return;
		}
		
		if($this->response->post("shop") == "" || $this->response->postDecode("shop") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data toko yang dipilih","messageCode"=>3), true);
			return;
		}
		
		$QShop = $this->db->where("id",$this->response->postDecode("shop"))->get("tb_toko")->row();
		if(empty($QShop)){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada toko yang ditemukan","messageCode"=>4), true);
			return;
		}
		
		/*
		*	------------------------------------------------------------------------------
		*	Query mengambil data produk berdasarkan filter dan paging
		*	------------------------------------------------------------------------------
		*/
		$QProduct = $this->db;
		$QProduct = $QProduct->select("tp.*,tkcp.id as category_id, tkcp.name as category_name, tkcp.toko_id as toko_id");
		$QProduct = $QProduct->join("tb_toko_category_product tkcp","tkcp.id = tp.toko_category_product_id");
		$QProduct = $QProduct->where("tk.id",$QShop->id);
		
		if($this->response->post("keyword") != "" && $this->response->postDecode("keyword") != ""){
			$QProduct = $QProduct->like("tp.name",$this->response->postDecode("keyword"));
		}
		
		if($this->response->post("stock_type") != "" && $this->response->postDecode("stock_type") != ""){
			$QProduct = $QProduct->where("tp.stock_type",$this->response->postDecode("stock_type"));
		}
		
		if($this->response->post("page") != "" && $this->response->postDecode("page") != ""){
			$QProduct = $QProduct->limit(10,$this->response->postDecode("page"));
		}else{
			$QProduct = $QProduct->limit(10,0);
		}
		
		$QProduct = $QProduct->get("tb_product tp");
		$QProducts = $QProduct->result();
		
		if(sizeOf($QProducts) > 0){
			$Products = array();
			foreach($QProducts as $QProduct){
				/*
				*	------------------------------------------------------------------------------
				*	Query mengambil data produk image 
				*	------------------------------------------------------------------------------
				*/
				$QProductImages = $this->db
								->where("product_id", $QProduct->id)
								->get("tb_product_image")
								->result();
								
				$ProductImages = array();
				foreach($QProductImages as $QProductImage){
					$ProductImage = array(
								"id"=>$QProductImage->id,
								"imageUrl"=>base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/product/".$QProductImage->file))),
							);
									
					array_push($ProductImages,$ProductImage);
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	Query mengambil data produk varian 
				*	------------------------------------------------------------------------------
				*/
				$ProductVarians = $this->db
								->where("product_id", $QProduct->id)
								->get("tb_product_varian")
								->result();
				
			
				/*
				*	------------------------------------------------------------------------------
				*	Membuat object produk
				*	------------------------------------------------------------------------------
				*/
				$Product = array(
						"id"=>$QProduct->id,
						"name"=>$QProduct->name,
						"description"=>$QProduct->description,
						"sku_no"=>$QProduct->sku_no,
						"weight"=>$QProduct->weight,
						"unit"=>$QProduct->unit,
						"min_order"=>$QProduct->min_order,
						"stock_type"=>$QProduct->stock_type,
						"stock_type_detail"=>$QProduct->stock_type_detail,
						"active"=>$QProduct->active,
						"price_base"=>$QProduct->price_base,
						"price_1"=>$QProduct->price_1,
						"price_2"=>$QProduct->price_2,
						"price_3"=>$QProduct->price_3,
						"price_4"=>$QProduct->price_4,
						"price_5"=>$QProduct->price_5,
						"images"=>$ProductImages,
						"varians"=>$ProductVarians,
					);
						
				array_push($Products,$Product);
			}
		
			$this->response->send(array("result"=>1,"total"=>sizeOf($QProducts),"size"=>sizeOf($QProducts),"products"=>$Products), true);
		}else{
			$this->response->send(array("result"=>0,"message"=>"Tidak ada produk yang ditemukan","messageCode"=>4), true);
		}
	}
	
	public function doShopFollow(){
		/*
		*	------------------------------------------------------------------------------
		*	Validation POST data
		*	------------------------------------------------------------------------------
		*/
		if(!$this->isValidApi($this->response->postDecode("api_key"))){
			return;
		}
		
		if($this->response->post("user") == "" || $this->response->postDecode("user") == ""){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>1), true);
			return;
		}
		
		$QUser = $this->db->where("id",$this->response->postDecode("user"))->get("tb_member")->row();
		if(empty($QUser)){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>2), true);
			return;
		}
		
		if($this->response->post("shop") == "" || $this->response->postDecode("shop") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data toko yang dipilih","messageCode"=>3), true);
			return;
		}
		
		$QShop = $this->db->where("id",$this->response->postDecode("shop"))->get("tb_toko")->row();
		if(empty($QShop)){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada toko yang ditemukan","messageCode"=>4), true);
			return;
		}
		
		/*
		*	------------------------------------------------------------------------------
		*	Check produk sudah dan user sudah follow belum ?
		*	------------------------------------------------------------------------------
		*/ 
		
		$QFollow = $this->db
				->where("toko_id",$this->response->postDecode("shop"))
				->where("member_id",$this->response->postDecode("user"))
				->get("tb_toko_member")
				->row();
					
		if(empty($QFollow)){
			if($QShop->privacy == 0){
				$Follow = array(
					"toko_id"=>$this->response->postDecode("shop"),
					"member_id"=>$this->response->postDecode("user"),
					"create_date"=>date("Y-m-d H:i:s"),
					"create_user"=>$QUser->email,
					"update_date"=>date("Y-m-d H:i:s"),
					"update_user"=>$QUser->email,
				);
					
				$Save = $this->db->insert("tb_toko_member",$Follow);
				
				$Join = array(
					"toko_id"=>$this->response->postDecode("shop"),
					"member_id"=>$this->response->postDecode("user"),
					"status"=>1,
					"create_date"=>date("Y-m-d H:i:s"),
					"create_user"=>$QUser->email,
					"update_date"=>date("Y-m-d H:i:s"),
					"update_user"=>$QUser->email,
				);
					
				$Save = $this->db->insert("tb_join_in",$Join);
				
				if($Save){
					$this->response->send(array("result"=>1,"message"=>"Anda telah tergabung dengan toko ini","messageCode"=>5), true);
				}else{
					$this->response->send(array("result"=>0,"message"=>"Anda tidak dapat bergabung dengan toko ini","messageCode"=>6), true);
				}
			}else{
				$Join = array(
					"toko_id"=>$this->response->postDecode("shop"),
					"member_id"=>$this->response->postDecode("user"),
					"status"=>0,
					"create_date"=>date("Y-m-d H:i:s"),
					"create_user"=>$QUser->email,
					"update_date"=>date("Y-m-d H:i:s"),
					"update_user"=>$QUser->email,
				);
					
				$Save = $this->db->insert("tb_join_in",$Join);
				
				if($Save){
					$this->response->send(array("result"=>1,"message"=>"Permintaan beganbung anda telah dikirim","messageCode"=>7), true);
				}else{
					$this->response->send(array("result"=>0,"message"=>"Anda tidak dapat bergabung dengan toko ini","messageCode"=>8), true);
				}
			}
		}else{
			$Delete = $this->db->where("id",$QFollow->id)->delete("tb_toko_member");
			
			if($Delete){
				$this->response->send(array("result"=>1,"message"=>"Produk sudah tidak menjadi favorite anda","messageCode"=>9), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Produk tidak dapat di un-favorite","messageCode"=>10), true);
			}
		}
	}
	
	
	public function getFavoriteProducts(){
		/*
		*	------------------------------------------------------------------------------
		*	Validation POST data
		*	------------------------------------------------------------------------------
		*/
		if(!$this->isValidApi($this->response->postDecode("api_key"))){
			return;
		}
		
		if($this->response->post("user") == "" || $this->response->postDecode("user") == ""){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>1), true);
			return;
		}
		
		$QUser = $this->db->where("id",$this->response->postDecode("user"))->get("tb_member")->row();
		if(empty($QUser)){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>2), true);
			return;
		}
		
		/*
		*	------------------------------------------------------------------------------
		*	Query mengambil data produk berdasarkan filter dan paging
		*	------------------------------------------------------------------------------
		*/
		$QProduct = $this->db;
		$QProduct = $QProduct->select("tp.*,tkcp.id as category_id, tkcp.name as category_name, tkcp.toko_id as toko_id");
		$QProduct = $QProduct->join("tb_toko_category_product tkcp","tp.toko_category_product_id = tkcp.id");
		$QProduct = $QProduct->where("tp.id IN (SELECT id FROM tb_favorite WHERE member_id = ".$QUser->id.")");
		
		if($this->response->post("keyword") != "" && $this->response->postDecode("keyword") != ""){
			$QProduct = $QProduct->like("tp.name",$this->response->postDecode("keyword"));
		}
		
		if($this->response->post("stock_type") != "" && $this->response->postDecode("stock_type") != ""){
			$QProduct = $QProduct->where("tp.stock_type",$this->response->postDecode("stock_type"));
		}
		
		if($this->response->post("page") != "" && $this->response->postDecode("page") != ""){
			$QProduct = $QProduct->limit(10,$this->response->postDecode("page"));
		}else{
			$QProduct = $QProduct->limit(10,0);
		}
		
		$QProduct = $QProduct->get("tb_product tp");
		$QProducts = $QProduct->result();
		
		if(sizeOf($QProducts) > 0){
			$Products = array();
			foreach($QProducts as $QProduct){
				/*
				*	------------------------------------------------------------------------------
				*	Query mengambil data produk image 
				*	------------------------------------------------------------------------------
				*/
				$QProductImages = $this->db
								->where("product_id", $QProduct->id)
								->get("tb_product_image")
								->result();
								
				$ProductImages = array();
				foreach($QProductImages as $QProductImage){
					$ProductImage = array(
								"id"=>$QProductImage->id,
								"imageUrl"=>base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/product/".$QProductImage->file))),
							);

					array_push($ProductImages,$ProductImage);
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	Query mengambil data produk varian 
				*	------------------------------------------------------------------------------
				*/
				$ProductVarians = $this->db
								->where("product_id", $QProduct->id)
								->get("tb_product_varian")
								->result();
				
				/*
				*	------------------------------------------------------------------------------
				*	Query mengambil data produk toko 
				*	------------------------------------------------------------------------------
				*/
				$QProductShop = $this->db
								->select("tk.*, ml.id as location_id, ml.kecamatan as location_kecamatan, ml.city as location_city, ml.province as location_province, ml.postal_code as location_postal, mc.id as category_id, mc.name as category_name")
								->join("ms_location ml","ml.id = tk.location_id")
								->join("ms_category mc","mc.id = tk.category_id")
								->where("tk.id",$QProduct->toko_id)
								->get("tb_toko tk")
								->row();
								
				$ProductShop = array(
								"id"=>$QProductShop->id,
								"name"=>$QProductShop->name,
								"description"=>$QProductShop->description,
								"phone"=>$QProductShop->phone,
								"tag_name"=>$QProductShop->tag_name,
								"keyword"=>$QProductShop->keyword,
								"location"=>array(
										"id"=>$QProductShop->location_id,
										"kecamatan"=>$QProductShop->location_kecamatan,
										"city"=>$QProductShop->location_city,
										"province"=>$QProductShop->location_province,
										"postal"=>$QProductShop->location_postal,
									),
								"category"=>array(
										"id"=>$QProductShop->category_id,
										"name"=>$QProductShop->category_name,
									),
							);
			
				/*
				*	------------------------------------------------------------------------------
				*	Membuat object produk
				*	------------------------------------------------------------------------------
				*/
				$Product = array(
						"id"=>$QProduct->id,
						"name"=>$QProduct->name,
						"description"=>$QProduct->description,
						"sku_no"=>$QProduct->sku_no,
						"weight"=>$QProduct->weight,
						"unit"=>$QProduct->unit,
						"min_order"=>$QProduct->min_order,
						"stock_type"=>$QProduct->stock_type,
						"stock_type_detail"=>$QProduct->stock_type_detail,
						"active"=>$QProduct->active,
						"price_base"=>$QProduct->price_base,
						"price_1"=>$QProduct->price_1,
						"price_2"=>$QProduct->price_2,
						"price_3"=>$QProduct->price_3,
						"price_4"=>$QProduct->price_4,
						"price_5"=>$QProduct->price_5,
						"images"=>$ProductImages,
						"varians"=>$ProductVarians,
						"shop"=>$ProductShop,
					);
						
				array_push($Products,$Product);
			}
		
			$this->response->send(array("result"=>1,"total"=>sizeOf($QProducts),"size"=>sizeOf($QProducts),"products"=>$Products), true);
		}else{
			$this->response->send(array("result"=>0,"message"=>"Tidak ada produk yang ditemukan","messageCode"=>3), true);
		}
	}
	
	public function getProduct(){
		/*
		*	------------------------------------------------------------------------------
		*	Validation POST data
		*	------------------------------------------------------------------------------
		*/
		if(!$this->isValidApi($this->response->postDecode("api_key"))){
			return;
		}
		
		if($this->response->post("user") == "" || $this->response->postDecode("user") == ""){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>1), true);
			return;
		}
		
		$QUser = $this->db->where("id",$this->response->postDecode("user"))->get("tb_member")->row();
		if(empty($QUser)){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>2), true);
			return;
		}
		
		if($this->response->post("product") == "" || $this->response->postDecode("product") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada produk yang dipilih","messageCode"=>3), true);
			return;
		}
		
		$QProduct = $this->db
				->select("tp.*, tkcp.id as category_id, tkcp.name as category_name, tkcp.toko_id as toko_id")
				->join("tb_toko_category_product tkcp","tp.toko_category_product_id = tkcp.id")
				->where("tp.id",$this->response->postDecode("product"))
				->get("tb_product tp")
				->row();
				
		if(empty($QProduct)){
			$this->response->send(array("result"=>0,"message"=>"Produk tidak ditemukan ","messageCode"=>4), true);
			return;
		}
		
		/*
		*	------------------------------------------------------------------------------
		*	Query mengambil data produk image 
		*	------------------------------------------------------------------------------
		*/
		$QProductImages = $this->db
						->where("product_id", $QProduct->id)
						->get("tb_product_image")
						->result();
						
		$ProductImages = array();
		foreach($QProductImages as $QProductImage){
			$ProductImage = array(
						"id"=>$QProductImage->id,
						"imageUrl"=>base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/product/".$QProductImage->file))),
					);
							
			array_push($ProductImages,$ProductImage);
		}
		
		/*
		*	------------------------------------------------------------------------------
		*	Query mengambil data produk varian 
		*	------------------------------------------------------------------------------
		*/
		$ProductVarians = $this->db
						->where("product_id", $QProduct->id)
						->get("tb_product_varian")
						->result();
		
		/*
		*	------------------------------------------------------------------------------
		*	Query mengambil data produk toko 
		*	------------------------------------------------------------------------------
		*/
		$QProductShop = $this->db
						->select("tk.*, ml.id as location_id, ml.kecamatan as location_kecamatan, ml.city as location_city, ml.province as location_province, ml.postal_code as location_postal, mc.id as category_id, mc.name as category_name")
						->join("ms_location ml","ml.id = tk.location_id")
						->join("ms_category mc","mc.id = tk.category_id")
						->where("tk.id",$QProduct->toko_id)
						->get("tb_toko tk")
						->row();
						
		$ProductShop = array(
						"id"=>$QProductShop->id,
						"name"=>$QProductShop->name,
						"description"=>$QProductShop->description,
						"phone"=>$QProductShop->phone,
						"tag_name"=>$QProductShop->tag_name,
						"keyword"=>$QProductShop->keyword,
						"location"=>array(
								"id"=>$QProductShop->location_id,
								"kecamatan"=>$QProductShop->location_kecamatan,
								"city"=>$QProductShop->location_city,
								"province"=>$QProductShop->location_province,
								"postal"=>$QProductShop->location_postal,
							),
						"category"=>array(
								"id"=>$QProductShop->category_id,
								"name"=>$QProductShop->category_name,
							),
					);
	
		/*
		*	------------------------------------------------------------------------------
		*	Membuat object produk
		*	------------------------------------------------------------------------------
		*/
		$Product = array(
				"id"=>$QProduct->id,
				"name"=>$QProduct->name,
				"description"=>$QProduct->description,
				"sku_no"=>$QProduct->sku_no,
				"weight"=>$QProduct->weight,
				"unit"=>$QProduct->unit,
				"min_order"=>$QProduct->min_order,
				"stock_type"=>$QProduct->stock_type,
				"stock_type_detail"=>$QProduct->stock_type_detail,
				"active"=>$QProduct->active,
				"price_base"=>$QProduct->price_base,
				"price_1"=>$QProduct->price_1,
				"price_2"=>$QProduct->price_2,
				"price_3"=>$QProduct->price_3,
				"price_4"=>$QProduct->price_4,
				"price_5"=>$QProduct->price_5,
				"images"=>$ProductImages,
				"varians"=>$ProductVarians,
				"shop"=>$ProductShop,
			);
			
		$this->response->send(array("result"=>1,"product"=>$Product), true);
	}
	
	public function getUser(){
		/*
		*	------------------------------------------------------------------------------
		*	Validation POST data
		*	------------------------------------------------------------------------------
		*/
		if(!$this->isValidApi($this->response->postDecode("api_key"))){
			return;
		}
		
		if($this->response->post("user") == "" || $this->response->postDecode("user") == ""){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>1), true);
			return;
		}
		
		/*
		*	------------------------------------------------------------------------------
		*	Query mencari data user
		*	------------------------------------------------------------------------------
		*/
		$QUser = $this->db
			->where("id",$this->response->postDecode("user"))
			->get("tb_member")
			->row();
			
		if(empty($QUser)){
			$this->response->send(array("result"=>0,"message"=>"User belum terdaftar.","messageCode"=>2), true);
		}else{
			if(@getimagesize(base_url("assets/pic/user/".$QUser->image))){
				$UserImageUrl = base_url("image.php?q=50&fe=".base64_encode(base_url("assets/pic/user/".$QUser->image)));
			}else{
				$UserImageUrl = base_url("image.php?q=50&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
			}
				
			/*
			*	------------------------------------------------------------------------------
			*	get data member attribute
			*	------------------------------------------------------------------------------
			*/
			
			$QAttributes = $this->db
					->where("tma.member_id",$QUser->id)
					->get("tb_member_attribute tma")
					->result();
			
			$Attributes = array();
			foreach($QAttributes as $QAttribute){
				$Attribute = array(
						"id"=>$QAttribute->id,
						"name"=>$QAttribute->name,
						"value"=>$QAttribute->value,
					);
					
				array_push($Attributes,$Attribute);
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
					$BankImageUrl = base_url("image.php?q=50&fe=".base64_encode(base_url("assets/pic/bank/".$QBank->image)));
				}else{
					$BankImageUrl = base_url("image.php?q=50&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
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
					"countShop"=>10,
					"countProduct"=>10,
					"imageUrl"=>$UserImageUrl,
					"contacts"=>$Attributes,
					"banks"=>$Banks,
					"locations"=>$Locations,
				);
			
			$this->response->send(array("result"=>1,"user"=>$User), true);
		}
	}
	
}

