<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER API BONOBO
* This Api system for tranfers data using external apps, support for android, ios, windows mobile
*
* Log Activity : ~ Create your log if change this controller ~
. 1. Create 12 Juni 2015 by Heri Siswanto, Create controller
*/

set_time_limit (99999999999);

class Api extends CI_Controller {

	var $quality = 25;
	
	function __construct(){
        parent::__construct();
    }
	
	private function isValidApi($api_key){
		if($api_key == "BONOBO-APP-01"){
			return true;
		}else{
			$this->response->send(array("result"=>0,"message"=>"Applikasi anda tidak terdaftar","messageCode"=>0), true);
			return false;
		}
	}
	
	private function getUserById($id){
		/*
		*	------------------------------------------------------------------------------
		*	Query mencari data user
		*	------------------------------------------------------------------------------
		*/
		$QUser = $this->db
			->where("id",$id)
			->get("tb_member")
			->row();
			
		if(empty($QUser)){
			return null;
		}else{
			if(@getimagesize(base_url("assets/pic/user/".$QUser->image))){
				$UserImageUrl = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/user/".$QUser->image)));
			}else{
				$UserImageUrl = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
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
					"image_url"=>$UserImageUrl,
				);
				
			return $User;
		}
	}
	
	private function getShopById($id,$user=null){
		/*
		*	------------------------------------------------------------------------------
		*	Query mencari data shop
		*	------------------------------------------------------------------------------
		*/
		$QShop = $this->db
			->select("tk.*, ml.id as location_id, ml.kecamatan as location_kecamatan, ml.city as location_city, ml.province as location_province, ml.postal_code as location_postal, mc.id as category_id, mc.name as category_name")
			->join("ms_location ml","ml.id = tk.location_id","left")
			->join("ms_category mc","mc.id = tk.category_id","left")
			->where("tk.id",$id)
			->get("tb_toko tk")
			->row();
			
		if(empty($QShop)){
			return null;
		}else{
			if(@getimagesize(base_url("assets/pic/shop/".$QShop->image))){
				$ShopImageUrl = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/shop/".$QShop->image)));
			}else{
				$ShopImageUrl = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
			}
			$join = 0;
			$price_level = 1;
			
			if(!empty($user)){
				$ShopMember = $this->db->where("toko_id",$id)->where("member_id",$user)->get("tb_toko_member")->row();
				
				if(!empty($ShopMember)){
					$join = 1;
					$price_level = $ShopMember->price_level >= 1 ? $ShopMember->price_level : 1;
				}
			}
			
			$Shop = array(
				"id"=>$QShop->id,
				"name"=>$QShop->name,
				"description"=>$QShop->description,
				"phone"=>$QShop->phone,
				"tag_name"=>$QShop->tag_name,
				"keyword"=>$QShop->keyword,
				"image_url"=>$ShopImageUrl,
				"join"=>$join,
				"price_level"=>$price_level,
				"location"=>array(
						"id"=>$QShop->location_id,
						"kecamatan"=>$QShop->location_kecamatan,
						"city"=>$QShop->location_city,
						"province"=>$QShop->location_province,
						"postal"=>$QShop->location_postal,
					),
				"category"=>array(
						"id"=>$QShop->category_id,
						"name"=>$QShop->category_name,
					),
			);
			
			return $Shop;
		}
	}
	
	private function getProductById($id,$user = null){
		/*
		*	------------------------------------------------------------------------------
		*	Query mencari data shop
		*	------------------------------------------------------------------------------
		*/
		
		$QProduct = $this->db
					->select("tp.*, tkcp.id as category_id, tkcp.name as category_name, tkcp.toko_id as toko_id")
					->join("tb_toko_category_product tkcp","tp.toko_category_product_id = tkcp.id")
					->where("tp.id",$id)
					->get("tb_product tp")
					->row();
					
		if(empty($QProduct)){
			return null;
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
						"image_url"=>base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/product/resize/".$QProductImage->file))),
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
						
		$ProductShop = $this->getShopById($QProduct->toko_id);
		
		/*
		*	------------------------------------------------------------------------------
		*	Query check data produk favorite
		*	------------------------------------------------------------------------------
		*/
		
		if($user != null){
			$QFavorite = $this->db->where("product_id",$QProduct->id)->where("member_id",$user)->get("tb_favorite")->row();
			if(!empty($QFavorite)){
				$isFavorite = "true";
			}else{
				$isFavorite = "false";
			}
		}else{
			$isFavorite = "false";
		}
	
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
				"favorite"=>$isFavorite,
				"images"=>$ProductImages,
				"varians"=>$ProductVarians,
				"shop"=>$ProductShop,
			);
				
		return $Product;
	}
	
	private function getCartsByUser($user){
		/*
		*	------------------------------------------------------------------------------
		*	Mengambil query data carts
		*	------------------------------------------------------------------------------
		*/
		$Carts = array();
		
		$QCarts = $this->db
				->where("tc.member_id",$user)
				->get("tb_cart tc")
				->result();
		
		foreach($QCarts as $QCart){
			/*
			*	------------------------------------------------------------------------------
			*	Mengambil query data cart products
			*	------------------------------------------------------------------------------
			*/
			$CartProducts = array();
		
			$QCartProducts = $this->db
				->where("tcp.cart_id",$QCart->id)
				->get("tb_cart_product tcp")
				->result();
		
			foreach($QCartProducts as $QCartProduct){
				/*
				*	------------------------------------------------------------------------------
				*	Mengambil data cart varian berdasarkan cart product
				*	------------------------------------------------------------------------------
				*/
				$CartVarians = array();
				$QCartVarians = $this->db
									->where("cart_product_id",$QCartProduct->id)
									->get("tb_cart_varian")
									->result();
									
				foreach($QCartVarians as $QCartVarian){
					/*
					*	------------------------------------------------------------------------------
					*	Mengambil data cart varian berdasarkan cart product
					*	------------------------------------------------------------------------------
					*/
					$QProductVarian = $this->db
										->where("id",$QCartVarian->product_varian_id)
										->get("tb_product_varian")
										->row();
					
					$ProductVarian = array(
									"id"=>$QProductVarian->id,
									"name"=>$QProductVarian->name,
									"stock_qty"=>$QProductVarian->stock_qty,
									"product"=>$this->getProductById($QProductVarian->product_id),
								);
					
					$CartVarian = array(
								"id"=>$QCartVarian->id,
								"quantity"=>$QCartVarian->quantity,
								"product_varian"=>$ProductVarian,
							);
							
					array_push($CartVarians,$CartVarian);
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	Membuat object Cart Product
				*	------------------------------------------------------------------------------
				*/
				$CartProduct = array(
							"id"=>$QCartProduct->id,
							"price_product"=>$QCartProduct->price_product,
							"product"=>$this->getProductById($QCartProduct->product_id,$user),
							"cart_varians"=>$CartVarians,
						);
				
				array_push($CartProducts,$CartProduct);
			}
		
			/*
			*	------------------------------------------------------------------------------
			*	Membuat object Cart
			*	------------------------------------------------------------------------------
			*/
			$Cart = array(
					"id"=>$QCart->id,
					"price_total"=>$QCart->price_total,
					"shop"=>$this->getShopById($QCart->toko_id),
					"cart_products"=>$CartProducts,
				);
			
			array_push($Carts,$Cart);
		}
		
		return $Carts;
	}
	
	
	public function index(){
		try {
		
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
							->where("active",1)
							->limit(10,0)
							->order_by("id","DESC")
							->get("tb_product")
							->result();
			
			foreach($QProducts as $QProduct){
				$Product = $this->getProductById($QProduct->id);
				array_push($Products,$Product);				
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Get data couriers
			*	------------------------------------------------------------------------------
			*/
			
			$Couriers = array();
			$QCouriers = $this->db->get("ms_courier")->result();
			
			foreach($QCouriers as $QCourier){
				$Courier = array(
						"id"=>$QCourier->id,
						"name"=>$QCourier->name,
					);
					
				array_push($Couriers,$Courier);
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Get data province
			*	------------------------------------------------------------------------------
			*/
			
			$Provinces = array();
			$QProvinces = $this->db->group_by("province")->order_by("province","ASC")->get("ms_location")->result();
			
			foreach($QProvinces as $QProvince){
				$Province = array(
						"id"=>$QProvince->id,
						"name"=>$QProvince->province,
					);
				
				array_push($Provinces,$Province);
			}
			
			$Cities = array();
			$Kecamatans = array();
			if(sizeOf($Provinces) > 0){
				$QCities = $this->db->where("province",$Provinces[0]["name"])->group_by("city")->order_by("city","ASC")->get("ms_location")->result();
			
				foreach($QCities as $QCity){
					$City = array(
							"id"=>$QCity->id,
							"name"=>$QCity->city,
						);
						
					array_push($Cities,$City);
				}
				
				if(sizeOf($Cities) > 0){
					$QKecamatans = $this->db->where("city",$Cities[0]["name"])->where("province",$Provinces[0]["name"])->group_by("kecamatan")->order_by("kecamatan","ASC")->get("ms_location")->result();
				
					foreach($QKecamatans as $QKecamatan){
						$Kecamatan = array(
								"id"=>$QKecamatan->id,
								"name"=>$QKecamatan->kecamatan,
							);
							
						array_push($Kecamatans,$Kecamatan);
					}
				}
			}
			
			$this->response->send(array("result"=>1,"products"=>$Products,"couriers"=>$Couriers,"provinces"=>$Provinces,"cities"=>$Cities,"kecamatans"=>$Kecamatans), true);
		
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doLogin(){
		try {
			
			/*
			*	------------------------------------------------------------------------------
			*	Validation POST data
			*	------------------------------------------------------------------------------
			*/
			if(!$this->isValidApi($this->response->postDecode("api_key"))){
				return;
			}
			
			if($this->response->post("username") == "" || $this->response->postDecode("username") == ""){
				$this->response->send(array("result"=>0,"message"=>"Username masih kosong","messageCode"=>1), true);
				return;
			}
			
			if($this->response->post("password") == "" || $this->response->postDecode("password") == ""){
				$this->response->send(array("result"=>0,"message"=>"Password masih kosong","messageCode"=>2), true);
				return;
			}
			
			$QUser = $this->db
				->where("email",$this->response->postDecode("username"))
				->where("password",md5($this->response->postDecode("password")))
				->get("tb_member")
				->row();
				
			if(!empty($QUser)){
				$User = $this->getUserById($QUser->id);
				$this->response->send(array("result"=>1,"user"=>$User), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Email / password anda tidak sesuai","messageCode"=>3), true);
			}
		
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doSignup(){
		try {
		
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
					$User = $this->getUserById($QUser->id);
					$this->response->send(array("result"=>1,"user"=>$User), true);
				}else{
					$this->response->send(array("result"=>0,"message"=>"Pendaftaran tidak berhasil","messageCode"=>7), true);
				}
			}else{
				$this->response->send(array("result"=>0,"message"=>"Pendaftaran tidak berhasil","messageCode"=>8), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doLoginFacebook(){
		try {
		
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
			
			if($this->response->post("id") == "" || $this->response->postDecode("id") == ""){
				$this->response->send(array("result"=>0,"message"=>"Password masih kosong","messageCode"=>3), true);
				return;
			}
			
			$QUser = $this->db->where("email",$this->response->postDecode("email"))->get("tb_member")->row();
			if(empty($QUser)){
				/*
				*	------------------------------------------------------------------------------
				*	Save new member
				*	------------------------------------------------------------------------------
				*/
				$OUser = array(
							"name"=>$this->response->postDecode("name"),
							"email"=>$this->response->postDecode("email"),
							"facebook_id"=>$this->response->postDecode("id"),
							"facebook_flag"=>1,
							"create_date"=>date("Y-m-d H:i:s"),
							"create_user"=>$this->response->postDecode("email"),
							"update_date"=>date("Y-m-d H:i:s"),
							"update_user"=>$this->response->postDecode("email"),
						);
						
				$this->db->insert("tb_member",$OUser);
			}

			
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
				$User = $this->getUserById($QUser->id);
				$this->response->send(array("result"=>1,"user"=>$User), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Login tidak berhasil","messageCode"=>7), true);
			}
			
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doForgotPassword(){
		try {
			
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
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doForgotPasswordProcess(){
		try {
		
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
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getUserData(){
		try {
			
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
					->select("tmb.id, tmb.acc_name as acc_name, tmb.acc_no as acc_no, mb.id as bank_id, mb.name as bank_name")
					->join("ms_bank mb","tmb.bank_id = mb.id")
					->where("tmb.member_id",$QUser->id)
					->get("tb_member_bank tmb")
					->result();
			
			$Banks = array();
			foreach($QBanks as $QBank){
				if(@getimagesize(base_url("assets/pic/bank/".$QBank->image))){
					$BankImageUrl = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/bank/".$QBank->image)));
				}else{
					$BankImageUrl = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
				}
			
				$Bank = array(
						"id"=>$QBank->id,
						"acc_name"=>$QBank->acc_name,
						"acc_no"=>$QBank->acc_no,
						"bank_name"=>$QBank->bank_name,
						"image_url"=>$BankImageUrl,
					);
					
				array_push($Banks,$Bank);
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	get data member locations
			*	------------------------------------------------------------------------------
			*/
			
			$QLocations = $this->db
					->select("tml.*, ml.kelurahan, ml.kecamatan, ml.city, ml.province, ml.postal_code, ml.id as location_id")
					->join("ms_location ml","tml.location_id = ml.id")
					->where("tml.member_id",$QUser->id)
					->get("tb_member_location tml")
					->result();
			
			$Locations = array();
			foreach($QLocations as $QLocation){
				$Location = array(
						"id"=>$QLocation->id,
						"location_id"=>$QLocation->location_id,
						"name"=>$QLocation->name,
						"address"=>$QLocation->address,
						"phone"=>$QLocation->phone,
						"postal"=>$QLocation->postal,
						"kelurahan"=>$QLocation->kelurahan,
						"kecamatan"=>$QLocation->kecamatan,
						"city"=>$QLocation->city,
						"province"=>$QLocation->province,
					);
					
				array_push($Locations,$Location);
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	get data member product favorite
			*	------------------------------------------------------------------------------
			*/
			
			$QFavorites = $this->db
					->join("tb_product tp","tf.product_id = tp.id")
					->where("tp.active",1)
					->where("tf.member_id",$QUser->id)
					->get("tb_favorite tf")
					->result();
			
			$Favorites = array();
			foreach($QFavorites as $QFavorite){
				$Favorite = $this->getProductById($QFavorite->product_id,$QUser->id);
				if(!empty($Favorite)){
					array_push($Favorites,$Favorite);
				}
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	get data member shops
			*	------------------------------------------------------------------------------
			*/
			
			$QShopMembers = $this->db
					->where("ttm.member_id",$QUser->id)
					->get("tb_toko_member ttm")
					->result();
			
			$Shops = array();
			foreach($QShopMembers as $QShopMember){
				$Shop = $this->getShopById($QShopMember->toko_id);
				if(!empty($Shop)){
					array_push($Shops,$Shop);
				}
			}
			
			
			/*
			*	------------------------------------------------------------------------------
			*	get data member carts
			*	------------------------------------------------------------------------------
			*/
			
			$Carts = $this->getCartsByUser($QUser->id);
			
			/*
			*	------------------------------------------------------------------------------
			*	create object user data to response
			*	------------------------------------------------------------------------------
			*/
			$Object = array(
					"result"=>1,
					"contacts"=>$Attributes, 
					"banks"=>$Banks, 
					"locations"=>$Locations, 
					"products"=>$Favorites,
					"shops"=>$Shops,
					"carts"=>$Carts,
				);
			
			$this->response->send($Object, true);
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getProducts(){
		try {
			
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
			$QProduct = $QProduct->where("tp.active",1);
			
			if($this->response->post("keyword") != "" && $this->response->postDecode("keyword") != ""){
				$QProduct = $QProduct->where("tp.name LIKE ","%".$this->response->postDecode("keyword")."%");
			}
			
			if($this->response->post("stock_type") != "" && $this->response->postDecode("stock_type") != ""){
				$QProduct = $QProduct->where("tp.stock_type",$this->response->postDecode("stock_type"));
			}
			
			if($this->response->post("lastId") != "" && $this->response->postDecode("lastId") != "" && $this->response->postDecode("lastId") > "0"){
				$QProduct = $QProduct->where("tp.id < ",$this->response->postDecode("lastId"));
			}else if($this->response->post("currentId") != "" && $this->response->postDecode("currentId") != ""){
				$QProduct = $QProduct->where("tp.id > ",$this->response->postDecode("currentId"));
			}
			
			$QProduct = $QProduct->limit(10,0);
			$QProduct = $QProduct->order_by("tp.id","Desc");
			$QProduct = $QProduct->get("tb_product tp");
			$QProducts = $QProduct->result();
			
			if(sizeOf($QProducts) > 0){
				$Products = array();
				
				foreach($QProducts as $QProduct){
					$Product = $this->getProductById($QProduct->id);
					array_push($Products,$Product);
				}
				
				$this->response->send(array("result"=>1,"total"=>sizeOf($QProducts),"size"=>sizeOf($QProducts),"products"=>$Products), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak ada produk yang ditemukan","messageCode"=>4), true);
			}
		
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		} 
	}
	
	public function doProductFavorite(){
		try {
		
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
					->get("tb_favorite")
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
		
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getShops(){
		try {
		
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
				$QShops = $QShops->where("tt.name LIKE ","%".$this->response->postDecode("keyword")."%");
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
							"image_url"=>base_url("image.php?q=100&fe=".base64_encode($QShop->image)),
							"shopBanks"=>$ShopBanks,
							"attributes"=>$ShopAttributes,
						);
					
					array_push($Shops,$Shop);
				}
				
				$this->response->send(array("result"=>1,"total"=>sizeOf($QShops),"size"=>sizeOf($QShops),"shops"=>$Shops), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak ada toko yang ditemukan","messageCode"=>3), true);
			}
		
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getShop(){
		try {
		
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
				"image_url"=>base_url("image.php?q=100&fe=".base64_encode($QShop->image)),
				"banks"=>$ShopBanks,
				"attributes"=>$ShopAttributes,
			);
				
			$this->response->send(array("result"=>1,"shop"=>$Shop), true);
		
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getShopProducts(){
		try {
		
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
				$QProduct = $QProduct->where("tp.name LIKE ","%".$this->response->postDecode("keyword")."%");
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
									"image_url"=>base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/product/".$QProductImage->file))),
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
		
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	
	
	public function doShopFollow(){
		try {
		
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
		
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	
	public function getFavoriteProducts(){
		try {
		
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
			$QProduct = $QProduct->where("tp.active",1);
			
			if($this->response->post("keyword") != "" && $this->response->postDecode("keyword") != ""){
				$QProduct = $QProduct->where("tp.name LIKE ","%".$this->response->postDecode("keyword")."%");
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
					$Product = $this->getProductById($QProduct->id);
							
					array_push($Products,$Product);
				}
			
				$this->response->send(array("result"=>1,"total"=>sizeOf($QProducts),"size"=>sizeOf($QProducts),"products"=>$Products), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak ada produk yang ditemukan","messageCode"=>3), true);
			}
		
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getProduct(){
		try {
		
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
			
			/*
			*	------------------------------------------------------------------------------
			*	Query mengambil data produk
			*	------------------------------------------------------------------------------
			*/
			
			$Product = $this->getProductById($this->response->postDecode("product"));
			if($Product != null){
				$this->response->send(array("result"=>1,"product"=>$Product), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Produk tidak ditemukan ","messageCode"=>4), true);
			}
		
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getUser(){
		try {
		
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
				$this->response->send(array("result"=>0,"message"=>"User tidak ditemukan","messageCode"=>2), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Query mencari data user
			*	------------------------------------------------------------------------------
			*/
			$User = $this->getUserById($QUser->id);
			$this->response->send(array("result"=>1,"user"=>$User), true);
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doUserProfileSave(){
		try{
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
			*	Simpan data user
			*	------------------------------------------------------------------------------
			*/
			$Data = array(
					"name"=>$this->response->postDecode("name"),
					"email"=>$this->response->postDecode("email"),
					"phone"=>$this->response->postDecode("phone"),
				);
			
			$Save = $this->db->where("id",$QUser->id)->update("tb_member",$Data);
			if($Save){
				$User = $this->getUserById($QUser->id);
				$this->response->send(array("result"=>1,"message"=>"Data user telah diubah","messageCode"=>4,"user"=>$User), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Data user tidak dapat disimpan","messageCode"=>5), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doUserAttributeSave(){
		try{
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
			*	Simpan data kontak user
			*	------------------------------------------------------------------------------
			*/
			
			$id = $this->response->postDecode("contact_id");
			if(empty($id)){
				$date = date("Y-m-d H:i:s");
				
				$Data = array(
					"member_id"=>$QUser->id,
					"name"=>$this->response->postDecode("contact_name"),
					"value"=>$this->response->postDecode("contact_value"),
					"create_date"=>$date,
					"create_user"=>$QUser->email,
					"update_date"=>$date,
					"update_user"=>$QUser->email,
				);
				
				$Save = $this->db->insert("tb_member_attribute",$Data);
				if($Save){
					$Contact = $this->db
						->where("member_id",$QUser->id)
						->where("name",$this->response->postDecode("contact_name"))
						->where("value",$this->response->postDecode("contact_value"))
						->where("create_date",$date)
						->where("create_user",$QUser->email)
						->where("update_date",$date)
						->where("update_user",$QUser->email)
						->get("tb_member_attribute")
						->row();
									
					if(!empty($Contact)){
						$this->response->send(array("result"=>1,"message"=>"Kontak telah disimpan","messageCode"=>3,"contact"=>$Contact), true);
					}else{
						$this->response->send(array("result"=>0,"message"=>"Kontak tidak dapat disimpan : ","messageCode"=>4), true);
					}
				}else{
					$this->response->send(array("result"=>0,"message"=>"Kontak tidak dapat disimpan aaa","messageCode"=>5), true);
				}
			}else{
				$Data = array(
					"name"=>$this->response->postDecode("contact_name"),
					"value"=>$this->response->postDecode("contact_value"),
					"update_date"=>date("Y-m-d H:i:s"),
					"update_user"=>$QUser->email,
				);
				
				$Save = $this->db->where("id",$id)->update("tb_member_attribute",$Data);
				if($Save){
					$Contact = $this->db
								->where("id",$id)
								->get("tb_member_attribute")
								->row();
								
					if(!empty($Contact)){
						$this->response->send(array("result"=>1,"message"=>"Kontak telah disimpan","messageCode"=>6,"contact"=>$Contact), true);
					}else{
						$this->response->send(array("result"=>0,"message"=>"Kontak tidak dapat disimpan","messageCode"=>7), true);
					}
				}else{
					$this->response->send(array("result"=>0,"message"=>"Kontak tidak dapat disimpan","messageCode"=>8), true);
				}
			}
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doUserAttributeDelete(){
		try{
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
			
			if($this->response->post("contact") == "" || $this->response->postDecode("contact") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada kontak user yang dipilih","messageCode"=>3), true);
				return;
			}
			
			$QUserContact = $this->db->where("id",$this->response->postDecode("contact"))->get("tb_member_attribute")->row();
			if(empty($QUserContact)){
				$this->response->send(array("result"=>0,"message"=>"Data kontak user tidak ditemukan","messageCode"=>4), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Delete data kontak
			*	------------------------------------------------------------------------------
			*/
			
			$Delete = $this->db->where("id",$this->response->postDecode("contact"))->delete("tb_member_attribute");
			if($Delete){
				$this->response->send(array("result"=>1,"message"=>"Data kontak user telah dihapus","messageCode"=>5), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Data kontak user tidak dapat dihapus","messageCode"=>6), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doUserShipmentSave(){
		try{
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
			*	Simpan data shipment
			*	------------------------------------------------------------------------------
			*/
			$Save = false;
			
			if($this->response->post("user_location_id") == "" || $this->response->postDecode("user_location_id") == ""){
				$Data = array(
						"location_id"=>$this->response->postDecode("kecamatan"),
						"member_id"=>$QUser->id,
						"name"=>$this->response->postDecode("name"),
						"address"=>$this->response->postDecode("address"),
						"phone"=>$this->response->postDecode("phone"),
						"create_date"=>date("Y-m-d H:i:s"),
						"create_user"=>$QUser->email,
						"update_date"=>date("Y-m-d H:i:s"),
						"update_user"=>$QUser->email,
					);
				
				$Save = $this->db->insert("tb_member_location",$Data);
			}else{
				$Data = array(
						"location_id"=>$this->response->postDecode("kecamatan"),
						"member_id"=>$QUser->id,
						"name"=>$this->response->postDecode("name"),
						"address"=>$this->response->postDecode("address"),
						"phone"=>$this->response->postDecode("phone"),
						"update_date"=>date("Y-m-d H:i:s"),
						"update_user"=>$QUser->email,
					);
				$Save = $this->db->where("id",$this->response->postDecode("user_location_id"))->update("tb_member_location",$Data);
			}
			
			if($Save){
				$this->response->send(array("result"=>1,"message"=>"Data shipment telah diubah","messageCode"=>4), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Data shipment tidak dapat disimpan","messageCode"=>5), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doUserShipmentDelete(){
		try{
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
			
			if($this->response->post("user_location_id") == "" || $this->response->postDecode("user_location_id") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada lokasi user yang dipilih","messageCode"=>3), true);
				return;
			}
			
			$QUserLocation = $this->db->where("id",$this->response->postDecode("user_location_id"))->get("tb_member_location")->row();
			if(empty($QUserLocation)){
				$this->response->send(array("result"=>0,"message"=>"Data lokasi user tidak ditemukan","messageCode"=>4), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Delete data shipment
			*	------------------------------------------------------------------------------
			*/
			
			$Delete = $this->db->where("id",$this->response->postDecode("user_location_id"))->delete("tb_member_location");
			if($Delete){
				$this->response->send(array("result"=>1,"message"=>"Data lokasi user telah dihapus","messageCode"=>5), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Data lokasi user tidak dapat dihapus","messageCode"=>6), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doUserBankSave(){
		try{
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
			*	Simpan data shipment
			*	------------------------------------------------------------------------------
			*/
			$Save = false;
			
			if($this->response->post("user_bank_id") == "" || $this->response->postDecode("user_bank_id") == ""){
				$Data = array(
						"bank_id"=>$this->response->postDecode("bank_id"),
						"member_id"=>$QUser->id,
						"acc_name"=>$this->response->postDecode("acc_name"),
						"acc_no"=>$this->response->postDecode("acc_no"),
						"create_date"=>date("Y-m-d H:i:s"),
						"create_user"=>$QUser->email,
						"update_date"=>date("Y-m-d H:i:s"),
						"update_user"=>$QUser->email,
					);
				
				$Save = $this->db->insert("tb_member_location",$Data);
			}else{
				$Data = array(
						"bank_id"=>$this->response->postDecode("bank_id"),
						"member_id"=>$QUser->id,
						"acc_name"=>$this->response->postDecode("acc_name"),
						"acc_no"=>$this->response->postDecode("acc_no"),
						"update_date"=>date("Y-m-d H:i:s"),
						"update_user"=>$QUser->email,
					);
				$Save = $this->db->where("id",$this->response->postDecode("user_bank_id"))->update("tb_member_bank",$Data);
			}
			
			if($Save){
				$this->response->send(array("result"=>1,"message"=>"Data bank telah diubah","messageCode"=>3), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Data bank tidak dapat disimpan","messageCode"=>4), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doUserBankDelete(){
		try{
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
			
			if($this->response->post("user_bank_id") == "" || $this->response->postDecode("user_bank_id") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada bank user yang dipilih","messageCode"=>3), true);
				return;
			}
			
			$QUserBank = $this->db->where("id",$this->response->postDecode("user_bank_id"))->get("tb_member_bank")->row();
			if(empty($QUserBank)){
				$this->response->send(array("result"=>0,"message"=>"Data bank user tidak ditemukan","messageCode"=>4), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Delete data shipment
			*	------------------------------------------------------------------------------
			*/
			
			$Delete = $this->db->where("id",$this->response->postDecode("user_bank_id"))->delete("tb_member_bank");
			if($Delete){
				$this->response->send(array("result"=>1,"message"=>"Data bank user telah dihapus","messageCode"=>5), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Data bank user tidak dapat dihapus","messageCode"=>6), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doUserPasswordSave(){
		try{
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
			
			if($this->response->post("password_old") == "" || $this->response->postDecode("password_old") == ""){
				$this->response->send(array("result"=>0,"message"=>"Masukkan password lama anda","messageCode"=>3), true);
				return;
			}
			
			if($this->response->post("password_new") == "" || $this->response->postDecode("password_new") == ""){
				$this->response->send(array("result"=>0,"message"=>"Masukkan password baru anda","messageCode"=>4), true);
				return;
			}
			
			if($this->response->post("password_renew") == "" || $this->response->postDecode("password_renew") == ""){
				$this->response->send(array("result"=>0,"message"=>"Masukkan ulangi password baru anda","messageCode"=>5), true);
				return;
			}
			
			if(md5($this->response->postDecode("password_old")) != $QUser->password){
				$this->response->send(array("result"=>0,"message"=>"Password lama anda tidak sesuai","messageCode"=>6), true);
				return;
			}
			
			if($this->response->post("password_new") != $this->response->post("password_renew")){
				$this->response->send(array("result"=>0,"message"=>"Password baru anda tidak sesuai","messageCode"=>7), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Delete data shipment
			*	------------------------------------------------------------------------------
			*/
			$Data = array(
					"password"=>md5($this->response->postDecode("password_old")),
				);
			
			$Save = $this->db->where("id",$QUser->id)->update("tb_member",$Data);
			
			if($Save){
				$this->response->send(array("result"=>1,"message"=>"Password anda telah diubah","messageCode"=>8), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Password anda tidak dapat diubah","messageCode"=>9), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getCarts(){
		try{
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
			*	Query mengambil data carts
			*	------------------------------------------------------------------------------
			*/
			
			$QCarts = $this->db;
			$QCarts = $QCarts->where("tc.member_id",$QUser->id);
			
			if($this->response->post("page") != "" && $this->response->postDecode("page") != ""){
				$QCarts = $QCarts->limit(10,$this->response->postDecode("page"));
			}else{
				$QCarts = $QCarts->limit(10,0);
			}
			
			$QCarts = $QCarts->get("tb_cart tc");
			$QCarts = $QCarts->result();
			
			if(sizeOf($QCarts) <= 0){
				$this->response->send(array("result"=>0,"message"=>"Anda tidak memiliki daftar belanja","messageCode"=>3), true);
			}else{
				$Carts = array();
				foreach($QCarts as $QCart){
					$Shop = $this->getShopById($QCart->toko_id);
					
					/*
					*	------------------------------------------------------------------------------
					*	Query mengambil data cart products
					*	------------------------------------------------------------------------------
					*/
					$QCartProducts = $this->db
									->select("tcp.*,tp.id as product_id, tp.name as product_name, tpv.id as product_varian_id, tpv.name as product_varian_name")
									->join("tb_product_varian tpv","tpv.id = tcp.product_varian_id")
									->join("tb_product tp","tp.id = tpv.product_id")
									->where("tcp.cart_id",$QCart->id)
									->get("tb_cart_product tcp")
									->result();
					
					$CartProducts = array();
					foreach($QCartProducts as $QCartProduct){
						$CartProduct = array(
									"id"=>$QCartProduct->id,
									"price_product"=>$QCartProduct->price_product,
									"quantity"=>$QCartProduct->quantity,
									"product_id"=>$QCartProduct->product_id,
									"product_name"=>$QCartProduct->product_name,
									"product_varian_id"=>$QCartProduct->product_varian_id,
									"product_varian_name"=>$QCartProduct->product_varian_name,
								);
						
						array_push($CartProducts,$CartProduct);
					}
					
					/*
					*	------------------------------------------------------------------------------
					*	Membentuk object cart
					*	------------------------------------------------------------------------------
					*/
					$Cart = array(
							"id"=>$QCart->id,
							"price_total"=>$QCart->price_total,
							"shop"=>$Shop,
							"cart_products"=>$CartProducts,
						);
					
					array_push($Carts,$Cart);
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	Menampilkan response API
				*	------------------------------------------------------------------------------
				*/
				$this->response->send(array(
						"result"=>0,
						"total"=>sizeOf($QCarts),
						"size"=>sizeOf($QCarts),
						"count_product"=>100,
						"count_shop"=>10,
						"carts"=>$Carts,
					), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getNotas(){
		try{
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
			*	Query mengambil data invoice
			*	------------------------------------------------------------------------------
			*/
			
			$QInvoices = $this->db;
			$QInvoices = $QInvoices->where("ti.member_id",$QUser->id);
			
			if($this->response->post("page") != "" && $this->response->postDecode("page") != ""){
				$QInvoices = $QInvoices->limit(10,$this->response->postDecode("page"));
			}else{
				$QInvoices = $QInvoices->limit(10,0);
			}
			
			$QInvoices = $QInvoices->get("tb_invoice ti");
			$QInvoices = $QInvoices->result();
			
			if(sizeOf($QInvoices) <= 0){
				$this->response->send(array("result"=>0,"message"=>"Anda tidak memiliki daftar nota","messageCode"=>3), true);
			}else{
				$Invoices = array();
				foreach($QInvoices as $QInvoice){
					$Shop = $this->getShopById($QInvoice->toko_id);
					
					$QInvoiceProducts = $this->db
									->select("tip.*,tp.id as product_id, tp.name as product_name, tpv.id as product_varian_id, tpv.name as product_varian_name")
									->join("tb_product_varian tpv","tpv.id = tip.product_varian_id")
									->join("tb_product tp","tp.id = tpv.product_id")
									->where("tip.invoice_id",$QInvoice->id)
									->get("tb_invoice_product tip")
									->result();
					
					$InvoiceProducts = array();
					foreach($QInvoiceProducts as $QInvoiceProduct){
						$InvoiceProduct = array(
									"id"=>$QInvoiceProduct->id,
									"quantity"=>$QInvoiceProduct->quantity,
									"product_id"=>$QInvoiceProduct->product_id,
									"product_name"=>$QInvoiceProduct->product_name,
									"product_varian_id"=>$QInvoiceProduct->product_varian_id,
									"product_varian_name"=>$QInvoiceProduct->product_varian_name,
								);
						
						array_push($InvoiceProducts,$InvoiceProduct);
					}
					
					$Invoice = array(
							"id"=>$QInvoice->id,
							"number"=>$QInvoice->invoice_no,
							"member_name"=>$QInvoice->member_name,
							"member_email"=>$QInvoice->member_email,
							"member_confirm"=>$QInvoice->member_confirm,
							"price_total"=>$QInvoice->price_total,
							"price_shipment"=>$QInvoice->price_shipment,
							"notes"=>$QInvoice->notes,
							"shipment_no"=>$QInvoice->shipment_no,
							"shipment_service"=>$QInvoice->shipment_service,
							"recipient_name"=>$QInvoice->recipient_name,
							"recipient_phone"=>$QInvoice->recipient_phone,
							"location_to_province"=>$QInvoice->location_to_province,
							"location_to_city"=>$QInvoice->location_to_city,
							"location_to_kecamatan"=>$QInvoice->location_to_kecamatan,
							"location_to_postal"=>$QInvoice->location_to_postal,
							"status"=>$QInvoice->status,
							"shop"=>$Shop,
							"invoice_products"=>$InvoiceProducts,
						);
					
					array_push($Invoices,$Invoice);
				}
				
				$this->response->send(array(
						"result"=>0,
						"total"=>sizeOf($Invoices),
						"size"=>sizeOf($QInvoices),
						"notas"=>$Invoices,
					), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doCartProductDelete(){
		try{
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
			
			if($this->response->post("cart_product") == "" || $this->response->postDecode("cart_product") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data cart produk yang dipilih","messageCode"=>3), true);
				return;
			}
			
			$QCartProduct = $this->db->where("id", $this->response->postDecode("cart_product"))->get("tb_cart_product")->row();
			if(empty($QCartProduct)){
				$this->response->send(array("result"=>0,"message"=>"Data produk tidak ada dalam keranjang belanja anda","messageCode"=>2), true);
				return;
			}
			/*
			*	------------------------------------------------------------------------------
			*	Query menghapus data cart product
			*	------------------------------------------------------------------------------
			*/
			
			$Delete = $this->db->where("id", $QCartProduct->id)->delete("tb_cart_product");
			
			if($Delete){
				$CartProducts = $this->db->where("cart_id",$QCartProduct->cart_id)->get("tb_cart_product")->result();
				if(sizeOf($CartProducts) <= 0){
					$Delete = $this->db->where("id",$QCartProduct->cart_id)->delete("tb_cart");
				}
				
				$this->response->send(array("result"=>1,"message"=>"Data produk belanja telah dihapus","messageCode"=>4), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Data produk belanja tidak dapat dihapus","messageCode"=>5), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getShopCouriers(){
		try{
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
				$this->response->send(array("result"=>0,"message"=>"Toko yang anda cari tidak ditemukan","messageCode"=>2), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Query data courier toko
			*	------------------------------------------------------------------------------
			*/
			
			$QShopCouriers = $this->db
							->select("mc.*")
							->join("ms_courier mc","mc.id = ttc.courier_id")
							->where("ttc.toko_id",$QShop->id)
							->get("tb_toko_courier ttc")
							->result();
			
			if(sizeOf($QShopCouriers) > 0){
				$Couriers = array();
				foreach($QShopCouriers as $QShopCourier){
					$Courier = array(
								"id"=>$QShopCourier->id,
								"name"=>$QShopCourier->name,
							);
					array_push($Couriers,$Courier);
				}
				
				$this->response->send(array("result"=>1,"total"=>sizeOf($QShopCouriers),"size"=>sizeOf($QShopCouriers),"couriers"=>$Couriers), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data courier yang di temukan","messageCode"=>5), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doCartAdd(){
		try {
		
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
				$this->response->send(array("result"=>0,"message"=>"Belum ada product yang di kirim","messageCode"=>1), true);
				return;
			}
			
			$QProduct = $this->db
						->select("tp.*, tt.id as shop_id")
						->join("tb_toko_category_product ttcp","ttcp.id = tp.toko_category_product_id")
						->join("tb_toko tt","tt.id = ttcp.toko_id")
						->where("tp.id",$this->response->postDecode("product"))
						->get("tb_product tp")
						->row();
						
			if(empty($QProduct)){
				$this->response->send(array("result"=>0,"message"=>"Product tidak ditemukan","messageCode"=>2), true);
				return;
			}
			
			if($this->response->post("varians") == "" || $this->response->postDecode("varians") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data varians yang dikirim","messageCode"=>1), true);
				return;
			}

			/*
			*	------------------------------------------------------------------------------
			*	Menyimpan data cart
			*	------------------------------------------------------------------------------
			*/
			$QCart = $this->db
						->where("member_id",$QUser->id)
						->where("toko_id",$QProduct->shop_id)
						->get("tb_cart")
						->row();
			
			if(empty($QCart)){
				$date = date("Y-m-d H:i:s");
			
				$Data = array(
					"member_id"=>$QUser->id,
					"toko_id"=>$QProduct->shop_id,
					"price_total"=>$this->response->postDecode("price_total"),
					"create_date"=>$date,
					"create_user"=>$QUser->email,
					"update_date"=>$date,
					"update_user"=>$QUser->email,
				);
				
				$Save = $this->db->insert("tb_cart",$Data);
				if($Save){
					/*
					*	------------------------------------------------------------------------------
					*	Mengambil data cart yang telah disimpan
					*	------------------------------------------------------------------------------
					*/
					$QCart = $this->db
							->where("member_id",$QUser->id)
							->where("toko_id",$QProduct->shop_id)
							->where("price_total",$this->response->postDecode("price_total"))
							->where("create_date",$date)
							->where("create_user",$QUser->email)
							->where("update_date",$date)
							->where("update_user",$QUser->email)
							->get("tb_cart")
							->row();
				}
			}else{
				$date = date("Y-m-d H:i:s");
			
				$Data = array(
					"price_total"=>$this->response->postDecode("price_total"),
					"update_date"=>$date,
					"update_user"=>$QUser->email,
				);
				
				$Save = $this->db->where("id",$QCart->id)->update("tb_cart",$Data);
			}
			
			if($Save){
				if(!empty($QCart)){
					/*
					*	------------------------------------------------------------------------------
					*	Simpan data cart product
					*	------------------------------------------------------------------------------
					*/
					$QCartProduct = $this->db
								->where("cart_id",$QCart->id)
								->where("product_id",$QProduct->id)
								->get("tb_cart_product")
								->row();
								
					if(empty($QCartProduct)){
						$Data = array(
								"cart_id"=>$QCart->id,
								"product_id"=>$QProduct->id,
								"price_product"=>$this->response->postDecode("price_total"),
								"create_date"=>$date,
								"create_user"=>$QUser->email,
								"update_date"=>$date,
								"update_user"=>$QUser->email,
							);
							
						$Save = $this->db->insert("tb_cart_product",$Data);
						if($Save){
							$QCartProduct = $this->db
												->where("cart_id",$QCart->id)
												->where("product_id",$QProduct->id)
												->get("tb_cart_product")
												->row();
						}
					}
					
				
					/*
					*	------------------------------------------------------------------------------
					*	Simpan data cart varian
					*	------------------------------------------------------------------------------
					*/
					for($i=1;$i<=$this->response->postDecode("varians");$i++){
						$QVarian = $this->db->where("id",$this->response->postDecode("varian".$i))->get("tb_product_varian")->row();
						
						if(!empty($QVarian) && $this->response->post("varian".$i."_qty") != "" && $this->response->postDecode("varian".$i."_qty") != ""){
							$Data = array(
									"cart_product_id"=>$QCartProduct->id,
									"product_varian_id"=>$QVarian->id,
									"quantity"=>$this->response->postDecode("varian".$i."_qty"),
									"create_date"=>$date,
									"create_user"=>$QUser->email,
									"update_date"=>$date,
									"update_user"=>$QUser->email,
								);
							
							$Save = $this->db->insert("tb_cart_varian",$Data);
						}
					}
				}
			
				/*
				*	------------------------------------------------------------------------------
				*	Mengambil data Cart Products
				*	------------------------------------------------------------------------------
				*/
				$CartProducts = array();
				$QCartProducts = $this->db
									->where("tcp.cart_id",$QCart->id)
									->get("tb_cart_product tcp")
									->result();
				
				foreach($QCartProducts as $QCartProduct){
					/*
					*	------------------------------------------------------------------------------
					*	Mengambil data cart varian berdasarkan cart product
					*	------------------------------------------------------------------------------
					*/
					$CartVarians = array();
					$QCartVarians = $this->db
										->where("cart_product_id",$QCartProduct->id)
										->get("tb_cart_varian")
										->result();
										
					foreach($QCartVarians as $QCartVarian){
						/*
						*	------------------------------------------------------------------------------
						*	Mengambil data cart varian berdasarkan cart product
						*	------------------------------------------------------------------------------
						*/
						$QProductVarian = $this->db
											->where("id",$QCartVarian->product_varian_id)
											->get("tb_product_varian")
											->row();
						
						$ProductVarian = array(
										"id"=>$QProductVarian->id,
										"name"=>$QProductVarian->name,
										"stock_qty"=>$QProductVarian->stock_qty,
										"product"=>$this->getProductById($QProductVarian->product_id),
									);
						
						$CartVarian = array(
									"id"=>$QCartVarian->id,
									"quantity"=>$QCartVarian->quantity,
									"product_varian"=>$ProductVarian,
								);
								
						array_push($CartVarians,$CartVarian);
					}
					
					/*
					*	------------------------------------------------------------------------------
					*	Membuat data Cart Product
					*	------------------------------------------------------------------------------
					*/
					$CartProduct = array(
									"id"=>$QCartProduct->id,
									"price_product"=>$QCartProduct->price_product,
									"product"=>$this->getProductById($QCartProduct->product_id,$QUser->id),
									"cart_varians"=>$CartVarians,
								);
					
					array_push($CartProducts,$CartProduct);
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	Membuat data Cart untuk response
				*	------------------------------------------------------------------------------
				*/
				$Cart = array(
						"id"=>$QCart->id,
						"price_total"=>$QCart->price_total,
						"shop"=>$this->getShopById($QCart->toko_id),
						"cart_products"=>$CartProducts,
					);
				
				$this->response->send(array("result"=>1,"cart"=>$Cart), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Data tidak dapat disimpan","messageCode"=>2), true);
			}
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doCartSave(){
		try{
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
			
			if($this->response->post("cart") == "" || $this->response->postDecode("cart") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data belanja yang dipilih","messageCode"=>3), true);
				return;
			}
			
			$QCart = $this->db
				->where("id",$this->response->postDecode("cart"))
				->where("member_id",$this->response->postDecode("user"))
				->get("tb_cart")
				->row();
				
			if(empty($QCart)){
				$this->response->send(array("result"=>0,"message"=>"Keranjang belanja yang anda cari tidak ditemukan","messageCode"=>2), true);
				return;
			}
			
			if($this->response->post("courier") == "" || $this->response->postDecode("courier") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data kurir yang dipilih","messageCode"=>3), true);
				return;
			}
			
			$QCourier = $this->db->where("id",$this->response->postDecode("courier"))->get("ms_courier")->row();
			if(empty($QCourier)){
				$this->response->send(array("result"=>0,"message"=>"Data kurir tidak ditemukan","messageCode"=>2), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Ambil data alamat tujuan pengiriman
			*	------------------------------------------------------------------------------
			*/
			
			if($this->response->postDecode("user_location_id") != ""){
				$QUserLocation = $this->db
					->select("tml.*, ml.kecamatan as location_kecamatan, ml.city as location_city, ml.province as location_province, ml.postal_code as location_postal")
					->join("ms_location ml","tml.location_id = ml.id")
					->where("tml.id",$this->response->postDecode("user_location_id"))
					->get("tb_member_location tml")
					->row();
					
			}else{
				$QLocation = $this->db
						->where("kelurahan",$this->response->postDecode("location_kelurahan"))
						->where("city",$this->response->postDecode("location_city"))
						->where("province",$this->response->postDecode("location_province"))
						->where("postal_code",$this->response->postDecode("location_postal"))
						->get("ms_location")
						->row();
						
				if(empty($QLocation)){
					$QLocation = $this->db
						->where("kelurahan",$this->response->postDecode("location_kelurahan"))
						->where("city",$this->response->postDecode("location_city"))
						->where("province",$this->response->postDecode("location_province"))
						->get("ms_location")
						->row();
						
					$Data = array(
						"member_id"=>$QUser->id,
						"location_id"=>$QLocation->id,
						"name"=>$this->response->postDecode("user_location_name"),
						"address"=>$this->response->postDecode("user_location_address"),
						"phone"=>$this->response->postDecode("user_location_phone"),
						"postal"=>$QLocation->postal_code,
						"create_date"=>date("Y-m-d H:i:s"),
						"create_user"=>$QUser->email, 
						"update_date"=>date("Y-m-d H:i:s"),
						"update_user"=>$QUser->email,
					);
					
					$Save = $this->db->insert("tb_member_location",$Data);
					
					$QUserLocation = $this->db
						->select("tml.*, ml.kecamatan as location_kecamatan, ml.city as location_city, ml.province as location_province, ml.postal_code as location_postal")
						->join("ms_location ml","tml.location_id = ml.id")
						->where("tml.member_id",$QUser->id)
						->where("tml.location_id",$QLocation->id)
						->where("tml.name",$this->response->postDecode("user_location_name"))
						->where("tml.address",$this->response->postDecode("user_location_address"))
						->where("tml.phone",$this->response->postDecode("user_location_phone"))
						->where("tml.postal",$QLocation->postal_code)
						->get("tb_member_location tml")
						->row();
				}else{
					$Data = array(
						"member_id"=>$QUser->id,
						"location_id"=>$QLocation->id,
						"name"=>$this->response->postDecode("user_location_name"),
						"address"=>$this->response->postDecode("user_location_address"),
						"phone"=>$this->response->postDecode("user_location_phone"),
						"postal"=>$this->response->postDecode("location_postal"),
						"create_date"=>date("Y-m-d H:i:s"),
						"create_user"=>$QUser->email, 
						"update_date"=>date("Y-m-d H:i:s"),
						"update_user"=>$QUser->email,
					);
				
					$Save = $this->db->insert("tb_member_location",$Data);
					
					$QUserLocation = $this->db
						->select("tml.*, ml.kecamatan as location_kecamatan, ml.city as location_city, ml.province as location_province, ml.postal_code as location_postal")
						->join("ms_location ml","tml.location_id = ml.id")
						->where("tml.member_id",$QUser->id)
						->where("tml.location_id",$QLocation->id)
						->where("tml.name",$this->response->postDecode("user_location_name"))
						->where("tml.address",$this->response->postDecode("user_location_address"))
						->where("tml.phone",$this->response->postDecode("user_location_phone"))
						->where("tml.postal",$this->response->postDecode("location_postal"))
						->get("tb_member_location tml")
						->row();
				}
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Hitung Harga Total, Harga Pengiriman, Harga Unik dari tabel Cart Product
			*	------------------------------------------------------------------------------
			*/
			
			$invoice_no = "123456789";
			$price_total = 0;
			$price_shipment = 0;
			$price_unique = 0;
			
			$QCartProducts = $this->db
					->select("tcp.*, tpv.id as varian_id, tpv.name as varian_name, tp.id as product_id, tp.name as product_name, tp.description as product_description")
					->join("tb_product_varian tpv","tcp.product_varian_id = tpv.id")
					->join("tb_product tp","tpv.product_id = tp.id")
					->where("tcp.cart_id",$QCart->id)
					->get("tb_cart_product tcp")
					->result();
			
			foreach($QCartProducts as $QCartProduct){
				$price_total = $price_total + ($QCartProduct->quantity + $QCartProduct->price_product);
			}
			
			
			
			/*
			*	------------------------------------------------------------------------------
			*	Simpan data cart ke invoice
			*	------------------------------------------------------------------------------
			*/
			$Data = array(
					"toko_id"=>$QCart->toko_id,
					"member_id"=>$QCart->member_id,
					"invoice_no"=>$invoice_no,
					"notes"=>$this->response->postDecode("note"),
					"member_name"=>$QUser->name,
					"member_email"=>$QUser->email,
					"member_confirm"=>0,
					"status"=>0,
					"price_total"=>$price_total,
					"price_shipment"=>$price_shipment,
					"price_unique"=>$price_unique,
					"shipment_no"=>$QCourier->id,
					"shipment_service"=>$QCourier->name,
					"recipient_name"=>$QUserLocation->name,
					"recipient_phone"=>$QUserLocation->phone,
					"location_to_province"=>$QUserLocation->location_province,
					"location_to_city"=>$QUserLocation->location_city,
					"location_to_kecamatan"=>$QUserLocation->location_kecamatan,
					"location_to_postal"=>$QUserLocation->location_postal,
					"create_date"=>date("Y-m-d H:i:s"),
					"create_user"=>$QUser->email,
					"update_date"=>date("Y-m-d H:i:s"),
					"update_user"=>$QUser->email,
				);
				
			$Save = $this->db->insert("tb_invoice",$Data);
			
			if($Save){
				/*
				*	------------------------------------------------------------------------------
				*	Hapus data Cart dan ambil data Toko
				*	------------------------------------------------------------------------------
				*/
				
				//$this->db->where("id",$QCart->id)->delete("tb_cart");
				
				$Shop = $this->getShopById($QCart->toko_id);
				
				/*
				*	------------------------------------------------------------------------------
				*	Query ambil data Invoice Terbaru
				*	------------------------------------------------------------------------------
				*/
				$QInvoice = $this->db
						->where("toko_id",$QCart->toko_id)
						->where("member_id",$QCart->member_id)
						->where("invoice_no",$invoice_no)
						->where("notes",$this->response->postDecode("note"))
						->where("member_name",$QUser->name)
						->where("member_email",$QUser->email)
						->where("member_confirm",0)
						->where("status",0)
						->where("price_total",$price_total)
						->where("price_shipment",$price_shipment)
						->where("price_unique",$price_unique)
						->where("shipment_no",$QCourier->id)
						->where("shipment_service",$QCourier->name)
						->where("recipient_name",$QUserLocation->name)
						->where("recipient_phone",$QUserLocation->phone)
						->where("location_to_province",$QUserLocation->location_province)
						->where("location_to_city",$QUserLocation->location_city)
						->where("location_to_kecamatan",$QUserLocation->location_kecamatan)
						->where("location_to_postal",$QUserLocation->location_postal)
						->get("tb_invoice")
						->row();
				
				/*
				*	------------------------------------------------------------------------------
				*	Simpan data cart produk menjadi invoice product
				*	------------------------------------------------------------------------------
				*/
				foreach($QCartProducts as $QCartProduct){
					$Data = array(
							"invoice_id"=>$QInvoice->id,
							"product_varian_id"=>$QCartProduct->product_varian_id,
							"product_name"=>$QCartProduct->product_name,
							"product_description"=>$QCartProduct->product_description,
							"varian_name"=>$QCartProduct->varian_name,
							"price"=>$QCartProduct->price_product,
							"quantity"=>$QCartProduct->quantity,
							"create_date"=>date("Y-m-d H:i:s"),
							"create_user"=>$QUser->email,
							"update_date"=>date("Y-m-d H:i:s"),
							"update_user"=>$QUser->email,
						);
					
					$this->db->insert("tb_invoice_product",$Data);
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	Ambil data Nota Product
				*	------------------------------------------------------------------------------
				*/
				
				$QNotaProducts = $this->db
							->where("tip.invoice_id",$QInvoice->id)
							->get("tb_invoice_product tip")
							->result();
				
				$NotaProducts = array();
				foreach($QNotaProducts as $QNotaProduct){
					$NotaProduct = array(
							"id"=>$QNotaProduct->id,
							"name"=>$QNotaProduct->product_name,
							"description"=>$QNotaProduct->product_description,
							"varian"=>$QNotaProduct->varian_name,
							"price"=>$QNotaProduct->price,
							"quantity"=>$QNotaProduct->quantity,
						);
					
					array_push($NotaProducts,$NotaProduct);
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	Buat object Nota
				*	------------------------------------------------------------------------------
				*/
				$Nota = array(
						"id"=>$QInvoice->id,
						"invoice_no"=>$QInvoice->invoice_no,
						"notes"=>$QInvoice->notes,
						"member_name"=>$QInvoice->member_name,
						"member_email"=>$QInvoice->member_email,
						"member_confirm"=>$QInvoice->member_confirm,
						"status"=>$QInvoice->status,
						"price_total"=>$QInvoice->price_total,
						"price_shipment"=>$QInvoice->price_shipment,
						"price_unique"=>$QInvoice->price_unique,
						"shipment_no"=>$QInvoice->shipment_no,
						"shipment_service"=>$QInvoice->shipment_service,
						"recipient_name"=>$QInvoice->recipient_name,
						"recipient_phone"=>$QInvoice->recipient_phone,
						"location_to_province"=>$QInvoice->location_to_province,
						"location_to_city"=>$QInvoice->location_to_city,
						"location_to_kecamatan"=>$QInvoice->location_to_kecamatan,
						"location_to_postal"=>$QInvoice->location_to_postal,
						"shop"=>$Shop,
						"invoice_products"=>$NotaProducts,
					);
				
				$this->response->send(array("result"=>0,"message"=>"Invoice telah disimpan","messageCode"=>5,"invoice"=>$Nota), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Data cart tidak dapat disimpan ke dalam invoice","messageCode"=>5), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getMessages(){
		try{
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
			*	Query ambil data messages
			*	------------------------------------------------------------------------------
			*/
			
			$QMessages = $this->db;
			$QMessages = $QMessages->select("tmm.*,tm.message");
			$QMessages = $QMessages->join("tb_message tm","tmm.message_id = tm.id");
			$QMessages = $QMessages->where("tmm.member_id",$QUser->id);
			$QMessages = $QMessages->order_by("tmm.id","DESC");
			$QMessages = $QMessages->group_by("tmm.toko_id");
			
			
			if($this->response->post("page") != "" && $this->response->postDecode("page") != ""){
				$QMessages = $QMessages->limit(10,$this->response->postDecode("page"));
			}else{
				$QMessages = $QMessages->limit(10,0);
			}
			
			$QMessages = $QMessages->get("tb_member_message tmm")->result();
			
			/*
			*	------------------------------------------------------------------------------
			*	Membentuk object Messages
			*	------------------------------------------------------------------------------
			*/
			$Messages = array();
			foreach($QMessages as $QMessage){
				$Shop = $this->getShopById($QMessage->toko_id);
			
				$Message = array(
						"id"=>$QMessage->id,
						"shop_name"=>$QMessage->toko_name,
						"message"=>$QMessage->message,
						"flag_from"=>$QMessage->flag_from,
						"flag_read"=>$QMessage->flag_read,
						"shop"=>$Shop,
					);
				
				array_push($Messages,$Message);
			}
			
			if(sizeOf($QMessages) > 0){
				$this->response->send(array("result"=>1,"total"=>sizeOf($Messages),"size"=>sizeOf($Messages),"messages"=>$Messages), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak ada pesan untuk anda","messageCode"=>3), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doMessageDelete(){
		try{
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
				$this->response->send(array("result"=>0,"message"=>"Tidak ada toko yang dipilih","messageCode"=>3), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Query delete messages
			*	------------------------------------------------------------------------------
			*/
			
			$Delete = $this->db
					->where("member_id",$QUser->id)
					->where("toko_id",$this->response->postDecode("shop"))
					->delete("tb_member_message");
					
			if($Delete){
				$this->response->send(array("result"=>1,"message"=>"Pesan telah dihapus","messageCode"=>4), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Pesan tidak dapat dihapus.","messageCode"=>5), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doMessageSave(){
		try{
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
				$this->response->send(array("result"=>0,"message"=>"Tidak ada toko yang dipilih","messageCode"=>3), true);
				return;
			}
			
			$QShop = $this->db->where("id",$this->response->postDecode("shop"))->get("tb_toko")->row();
			if(empty($QShop)){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data toko yang ditemukan","messageCode"=>4), true);
				return;
			}
			
			if($this->response->post("message") == "" || $this->response->postDecode("message") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada pesan yang anda kirimkan","messageCode"=>5), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Menyimpan data message parent
			*	------------------------------------------------------------------------------
			*/
			
			$Data = array(
					"message"=>$this->response->postDecode("message"),
					"create_date"=>date("Y-m-d H:i:s"),
					"create_user"=>$QUser->email,
					"update_date"=>date("Y-m-d H:i:s"),
					"update_user"=>$QUser->email,
				);
			
			$Save = $this->db->insert("tb_message",$Data);
			if($Save){
				$QMessage = $this->db
							->where("message",$this->response->postDecode("message"))
							->get("tb_message")
							->row();
				
				if(!empty($QMessage)){
					$Data1 = array(
							"member_id"=>$QUser->id,
							"message_id"=>$QMessage->id,
							"toko_id"=>$QShop->id,
							"toko_name"=>$QShop->name,
							"flag_from"=>1,
							"flag_read"=>1,
							"create_date"=>date("Y-m-d H:i:s"),
							"create_user"=>$QUser->email,
							"update_date"=>date("Y-m-d H:i:s"),
							"update_user"=>$QUser->email,
						);
						
					$Data2 = array(
							"member_id"=>$QUser->id,
							"message_id"=>$QMessage->id,
							"toko_id"=>$QShop->id,
							"member_name"=>$QUser->name,
							"flag_from"=>0,
							"flag_read"=>0,
							"create_date"=>date("Y-m-d H:i:s"),
							"create_user"=>$QUser->email,
							"update_date"=>date("Y-m-d H:i:s"),
							"update_user"=>$QUser->email,
						);
						
					$this->db->insert("tb_member_message",$Data1);
					$this->db->insert("tb_toko_message",$Data2);
					
					$QUserMessage = $this->db
								->where("member_id",$QUser->id)
								->where("message_id",$QMessage->id)
								->where("toko_id",$QShop->id)
								->where("toko_name",$QShop->name)
								->where("flag_from",1)
								->where("flag_read",1)
								->get("tb_member_message")
								->row();
					
					$Shop = $this->getShopById($QUserMessage->toko_id);
					
					$Messages = array(
								"id"=>$QUserMessage->id,
								"shop_name"=>$QUserMessage->toko_name,
								"message"=>$QMessage->message,
								"flag_from"=>$QUserMessage->flag_from,
								"flag_read"=>$QUserMessage->flag_read,
								"shop"=>$Shop,
							);
					
					$this->response->send(array("result"=>1,"message"=>"Pesan telah dikirim","messageCode"=>6,"messages"=>$Messages), true);
				}else{
					$this->response->send(array("result"=>0,"message"=>"Pesan tidak valid","messageCode"=>7), true);
				}
			}else{
				$this->response->send(array("result"=>0,"message"=>"Pesan tidak dapat dikirim","messageCode"=>8), true);
			}
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getCityByProvince(){
		try{
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
			
			if($this->response->post("province") == "" || $this->response->postDecode("province") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada propinsi yang dipilih","messageCode"=>3), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Mengambil data kota berdasarkan nama propinsi
			*	------------------------------------------------------------------------------
			*/
			$Cities = array();
			$QCities = $this->db
							->where("province",$this->response->postDecode("province"))
							->group_by("city")
							->get("ms_location")
							->result();
			foreach($QCities as $QCity){
				$City = array(
						"id"=>$QCity->id,
						"name"=>$QCity->city,
					);
				
				array_push($Cities,$City);
			}
			
			if(sizeOf($Cities) > 0){
				$Kecamatans = array();
				$QKecamatans = $this->db
						->where("city",$QCity->city)
						->where("province",$this->response->postDecode("province"))
						->group_by("kecamatan")
						->get("ms_location")
						->result();
								
				foreach($QKecamatans as $QKecamatan){
					$Kecamatan = array(
							"id"=>$QKecamatan->id,
							"name"=>$QKecamatan->kecamatan,
						);
					
					array_push($Kecamatans,$Kecamatan);
				}
				
				$this->response->send(array("result"=>1,"cities"=>$Cities,"kecamatans"=>$Kecamatans,"messageCode"=>4), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Kota tidak ditemukan","messageCode"=>5), true);
			}
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getKecamatanByCityProvince(){
		try{
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
			
			if($this->response->post("province") == "" || $this->response->postDecode("province") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada propinsi yang dipilih","messageCode"=>3), true);
				return;
			}
			
			if($this->response->post("city") == "" || $this->response->postDecode("city") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada kota yang dipilih","messageCode"=>4), true);
				return;
			}
			
			
			$Kecamatans = array();
			$QKecamatans = $this->db
						->where("city",$this->response->postDecode("city"))
						->where("province",$this->response->postDecode("province"))
						->group_by("kecamatan")
						->get("ms_location")
						->result();
								
			foreach($QKecamatans as $QKecamatan){
				$Kecamatan = array(
						"id"=>$QKecamatan->id,
						"name"=>$QKecamatan->kecamatan,
					);
				
				array_push($Kecamatans,$Kecamatan);
			}
			
			if(sizeOf($Kecamatans) > 0){
				$this->response->send(array("result"=>1,"kecamatans"=>$Kecamatans,"messageCode"=>5), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Kota tidak ditemukan","messageCode"=>6), true);
			}
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
}

