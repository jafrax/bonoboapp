<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
* CONTROLLER API BONOBO
* This Api system for tranfers data using external apps, support for android, ios, windows mobile
*
* Log Activity : ~ Create your log if change this controller ~
. 1. Create 12 Juni 2015 by Heri Siswanto, Create controller
*/

header('content-type: application/json; charset=utf-8');
ob_start('ob_gzhandler');
//set_time_limit (10000);

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
				$UserImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/user/resize/".$QUser->image)));
				$UserImageHigh = base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/user/".$QUser->image)));
			}else{
				$UserImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
				$UserImageHigh = $UserImageTumb;
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
					"image_tumb"=>$UserImageTumb,
					"image_high"=>$UserImageHigh,
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
			->select("tk.*, ml.id as location_id, ml.kecamatan as location_kecamatan, ml.city as location_city, ml.province as location_province, ml.postal_code as location_postal")
			->join("ms_location ml","ml.id = tk.location_id","left")
			->where("tk.id",$id)
			->get("tb_toko tk")
			->row();
			
		if(empty($QShop)){
			return null;
		}
		
		$join = 0;
		$invite = 0;
		$price_level = 1;
		
		/*
		*	---------------------------------------------------------------------------------------------
		*	Membuat data toko
		*	---------------------------------------------------------------------------------------------	
		*/
		if(@getimagesize(base_url("assets/pic/shop/".$QShop->image))){
			$ShopImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/shop/resize/".$QShop->image)));
			$ShopImageHigh = base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/shop/".$QShop->image)));
		}else{
			$ShopImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
			$ShopImageHigh = $ShopImageTumb;
		}
		
		if(!empty($user)){
			$ShopMember = $this->db->where("toko_id",$id)->where("member_id",$user)->get("tb_toko_member")->row();
			$ShopInvite = $this->db->where("toko_id",$id)->where("member_id",$user)->get("tb_invite")->row();
			
			if(!empty($ShopMember)){
				$join = 1;
				$price_level = $ShopMember->price_level >= 1 ? $ShopMember->price_level : 1;
			}
			
			if(!empty($ShopInvite)){
				$invite = 1;
			}
		}
		
		/*
		*	---------------------------------------------------------------------------------------------
		*	Mengambil data shop banks
		*	---------------------------------------------------------------------------------------------	
		*/
		$ShopBanks = array();
		$QShopBanks = $this->db
					->where("toko_id",$QShop->id)
					->get("tb_toko_bank")
					->result();
		
		foreach($QShopBanks as $QShopBank){
			$QBank = $this->db->where("id",$QShopBank->bank_id)->get("ms_bank")->row();
			
			if(!empty($QBank)){
				if(@getimagesize(base_url("assets/pic/bank/".$QBank->image))){
					$BankImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/bank/resize/".$QBank->image)));
					$BankImageHigh = base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/bank/".$QBank->image)));
				}else{
					$BankImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
					$BankImageHigh = $BankImageTumb;
				}
				
				$Bank = array(
					"id"=>$QBank->id,
					"name"=>$QBank->name,
					"image_tumb"=>$BankImageTumb,
					"image_high"=>$BankImageHigh,
				);
			}else{
				$Bank = array();
			}
			
			$ShopBank = array(
				"id"=>$QShopBank->id,
				"acc_name"=>$QShopBank->acc_name,
				"acc_no"=>$QShopBank->acc_no,
				"bank"=>$Bank,
			);
				
			array_push($ShopBanks,$ShopBank);
		}
		
		/*
		*	---------------------------------------------------------------------------------------------
		*	Mengambil data shop couriers
		*	---------------------------------------------------------------------------------------------	
		*/
		
		$ShopCouriers = array();
		$QShopCouriers = $this->db
							->where("toko_id",$QShop->id)
							->get("tb_toko_courier")
							->result();
							
		foreach($QShopCouriers as $QShopCourier){
			$QCourier = $this->db
							->where("id",$QShopCourier->courier_id)
							->get("ms_courier")
							->row();
			$Courier = array();
			if(!empty($QCourier)){
				if(@getimagesize(base_url("assets/pic/kurir/".$QCourier->image))){
					$CourierImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/kurir/resize/".$QCourier->image)));
					$CourierImageHigh = base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/kurir/".$QCourier->image)));
				}else{
					$CourierImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
					$CourierImageHigh = $CourierImageTumb;
				}
				
				$Courier = array(
						"id"=>$QCourier->id,
						"name"=>$QCourier->name,
						"image_tumb"=>$CourierImageTumb,
						"image_high"=>$CourierImageHigh,
					);
			}
			
			$ShopCourier = array(
					"id"=>$QShopCourier->id,
					"courier"=>$Courier,
				);
				
			array_push($ShopCouriers,$ShopCourier);
		}
		
		/*
		*	---------------------------------------------------------------------------------------------
		*	Mengambil data shop courier customs
		*	---------------------------------------------------------------------------------------------	
		*/
		
		$ShopCourierCustoms = array();
		$QShopCourierCustoms = $this->db
							->where("toko_id",$QShop->id)
							->get("tb_courier_custom")
							->result();
							
		foreach($QShopCourierCustoms as $QShopCourierCustom){
			$ShopCourierCustom = array(
					"id"=>$QShopCourierCustom->id,
					"name"=>$QShopCourierCustom->name,
					"status"=>$QShopCourierCustom->status,
				);
				
			array_push($ShopCourierCustoms,$ShopCourierCustom);
		}
		
		/*
		*	---------------------------------------------------------------------------------------------
		*	Mengambil data shop category
		*	---------------------------------------------------------------------------------------------	
		*/
		
		$ShopCategories = array();
		$QShopCategories = $this->db
							->where("toko_id",$QShop->id)
							->get("tb_toko_category_product")
							->result();
							
		foreach($QShopCategories as $QShopCategory){
			$ShopCategory = array(
					"id"=>$QShopCategory->id,
					"name"=>$QShopCategory->name,
				);
				
			array_push($ShopCategories,$ShopCategory);
		}
		
		/*
		*	---------------------------------------------------------------------------------------------
		*	Menghitung data products
		*	---------------------------------------------------------------------------------------------	
		*/
		$QShopProducts = $this->db
						->select("tp.id")
						->join("tb_toko_category_product ttcp","ttcp.id = tp.toko_category_product_id")
						->where("ttcp.toko_id",$QShop->id)
						->get("tb_product tp")
						->result();
						
		$CountProducts = sizeOf($QShopProducts);
		
		/*
		*	---------------------------------------------------------------------------------------------
		*	Menghitung data members
		*	---------------------------------------------------------------------------------------------	
		*/
		$QShopMembers = $this->db
						->select("id")
						->where("toko_id",$QShop->id)
						->get("tb_toko_member")
						->result();
						
		$CountMembers = sizeOf($QShopMembers);
		
		/*
		*	---------------------------------------------------------------------------------------------
		*	Membuat data toko
		*	---------------------------------------------------------------------------------------------	
		*/
		
		$Shop = array(
			"id"=>$QShop->id,
			"name"=>$QShop->name,
			"description"=>$QShop->description,
			"phone"=>$QShop->phone,
			"tag_name"=>$QShop->tag_name,
			"keyword"=>$QShop->keyword,
			"image_tumb"=>$ShopImageTumb,
			"image_high"=>$ShopImageHigh,
			"count_products"=>$CountProducts,
			"count_users"=>$CountMembers,
			"join"=>$join,
			"invite"=>$invite,
			"price_level"=>$price_level,
			"location"=>array(
				"id"=>$QShop->location_id,
				"kecamatan"=>$QShop->location_kecamatan,
				"city"=>$QShop->location_city,
				"province"=>$QShop->location_province,
				"postal"=>$QShop->location_postal,
			),
			"shop_banks"=>$ShopBanks,
			"shop_couriers"=>$ShopCouriers,
			"shop_courier_customs"=>$ShopCourierCustoms,
			"shop_categories"=>$ShopCategories,
		);
		
		return $Shop;
	}
	
	private function getProductById($id, $user=null){
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
			if(@getimagesize(base_url("assets/pic/courier/".$QCourier->image))){
				$ProductImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/product/resize/".$QProductImage->file)));
				$ProductImageHigh = base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/product/".$QProductImage->file)));
			}else{
				$ProductImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
				$ProductImageHigh = $ProductImageTumb;
			}
					
			$ProductImage = array(
						"id"=>$QProductImage->id,
						"image_tumb"=>$ProductImageTumb,
						"image_high"=>$ProductImageHigh,
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
						
		$ProductShop = $this->getShopById($QProduct->toko_id,$user);
		
		/*
		*	------------------------------------------------------------------------------
		*	Query mengambil data produk toko category
		*	------------------------------------------------------------------------------
		*/
						
		$ShopCategory = array(
						"id"=>$QProduct->category_id,
						"name"=>$QProduct->category_name,
					);
		
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
				"shop_category"=>$ShopCategory,
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
									"product"=>$this->getProductById($QProductVarian->product_id,$user),
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
					"shop"=>$this->getShopById($QCart->toko_id,$user),
					"cart_products"=>$CartProducts,
				);
			
			array_push($Carts,$Cart);
		}
		
		return $Carts;
	}
	
	private function getInvoicesByUser($user){
		/*
		*	------------------------------------------------------------------------------
		*	Mengambil data Couriers
		*	------------------------------------------------------------------------------
		*/
		
		$Invoices = array();
		$QInvoices = $this->db
					->where("member_id",$user)
					->get("tb_invoice")
					->result();

		foreach($QInvoices as $QInvoice){
			/*
			*	------------------------------------------------------------------------------
			*	Mengambil data Courier
			*	------------------------------------------------------------------------------
			*/
			
			$Courier = null;
			if(!empty($QInvoice->courier_id)){
				$Courier = array();
				$QCourier = $this->db
							->where("id",$QInvoice->courier_id)
							->get("ms_courier")
							->row();
							
				if(!empty($QCourier)){
					if(@getimagesize(base_url("assets/pic/courier/".$QCourier->image))){
						$CourierImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/courier/resize/".$QCourier->image)));
						$CourierImageHigh = base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/courier/".$QCourier->image)));
					}else{
						$CourierImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
						$CourierImageHigh = $CourierImageTumb;
					}
				
					$Courier = array(
							"id"=>$QCourier->id,
							"name"=>$QCourier->name,
							"image_tumb"=>$CourierImageTumb,
							"image_high"=>$CourierImageHigh,
						);
				}
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Mengambil data Courier Custom
			*	------------------------------------------------------------------------------
			*/
			$CourierCustom = null;
			
			if(!empty($QInvoice->courier_custom_id)){
				$CourierCustom = array();
				
				$QCourierCustom = $this->db
							->where("id",$QInvoice->courier_custom_id)
							->get("tb_courier_custom")
							->row();
							
				if(!empty($QCourierCustom)){
					$CourierCustom = array(
							"id"=>$QCourierCustom->id,
							"name"=>$QCourierCustom->name,
							"status"=>$QCourierCustom->status,
						);
				}
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Mengambil data Invoice Products
			*	------------------------------------------------------------------------------
			*/
			
			$InvoiceProducts = array();
			$QInvoiceProducts = $this->db
							->where("invoice_id",$QInvoice->id)
							->get("tb_invoice_product")
							->result();
			
			foreach($QInvoiceProducts as $QInvoiceProduct){
				/*
				*	------------------------------------------------------------------------------
				*	Mengambil data Product
				*	------------------------------------------------------------------------------
				*/
				$product = array();
				if(!empty($QInvoiceProduct->product_id)){
					$product = $this->getProductById($QInvoiceProduct->product_id,$user);
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	Mengambil data Invoice Varians
				*	------------------------------------------------------------------------------
				*/
				$InvoiceVarians = array();
				$QInvoiceVarians = $this->db
								->where("invoice_product_id",$QInvoiceProduct->id)
								->get("tb_invoice_varian")
								->result();
				
				foreach($QInvoiceVarians as $QInvoiceVarian){
					/*
					*	------------------------------------------------------------------------------
					*	Mengambil data varian
					*	------------------------------------------------------------------------------
					*/
					$Varian = array();
					$QVarian = $this->db
								->where("id",$QInvoiceVarian->product_varian_id)
								->get("tb_product_varian")
								->row();
					
					if(!empty($QVarian)){
						$Varian = array(
								"id"=>$QVarian->id,
								"name"=>$QVarian->name,
								"stock_qty"=>$QVarian->stock_qty,
								"product"=>$this->getProductById($QVarian->product_id,$user),
							);
					}
					
					/*
					*	------------------------------------------------------------------------------
					*	Membuat object Invoice Varian
					*	------------------------------------------------------------------------------
					*/
				
					$InvoiceVarian = array(
								"id"=>$QInvoiceVarian->id,
								"quantity"=>$QInvoiceVarian->quantity,
								"varian_name"=>$QInvoiceVarian->varian_name,
								"varian"=>$Varian,
							);
					
					array_push($InvoiceVarians,$InvoiceVarian);
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	Membuat object Invoice Product
				*	------------------------------------------------------------------------------
				*/
				$InvoiceProduct = array(
							"id"=>$QInvoiceProduct->id,
							"price_product"=>$QInvoiceProduct->price_product,
							"product_name"=>$QInvoiceProduct->product_name,
							"product_image"=>$QInvoiceProduct->product_image,
							"product_description"=>$QInvoiceProduct->product_description,
							"product"=>$product,
							"invoice_varians"=>$InvoiceVarians,
						);
				
				array_push($InvoiceProducts, $InvoiceProduct);
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Membuat object invoice
			*	------------------------------------------------------------------------------
			*/
			$Invoice = array(
					"id"=>$QInvoice->id,
					"invoice_no"=>$QInvoice->invoice_no,
					"invoice_seq_payment"=>$QInvoice->invoice_seq_payment,
					"status"=>$QInvoice->status,
					"status_pre_order"=>$QInvoice->status_pre_order,
					"stock_type"=>$QInvoice->stock_type,
					"member_name"=>$QInvoice->member_name,
					"member_email"=>$QInvoice->member_email,
					"member_confirm"=>$QInvoice->member_confirm,
					"price_total"=>$QInvoice->price_total,
					"price_item"=>$QInvoice->price_item,
					"notes"=>$QInvoice->notes,
					"shipment_no"=>$QInvoice->shipment_no,
					"shipment_service"=>$QInvoice->shipment_service,
					"price_shipment"=>$QInvoice->price_shipment,
					"recipient_name"=>$QInvoice->recipient_name,
					"recipient_phone"=>$QInvoice->recipient_phone,
					"recipient_address"=>$QInvoice->recipient_address,
					"location_to_province"=>$QInvoice->location_to_province,
					"location_to_city"=>$QInvoice->location_to_city,
					"location_to_kecamatan"=>$QInvoice->location_to_kecamatan,
					"location_to_postal"=>$QInvoice->location_to_postal,
					"create_date"=>$QInvoice->create_date,
					"update_date"=>$QInvoice->update_date,
					"shop"=>$this->getShopById($QInvoice->toko_id,$user),
					"courier"=>$Courier,
					"courier_custom"=>$CourierCustom,
					"courier_type"=>$QInvoice->courier_type,
					"invoice_products"=>$InvoiceProducts,
				);
			
			array_push($Invoices,$Invoice);
		}
		
		return $Invoices;
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
			
			/*
			*	------------------------------------------------------------------------------
			*	Get data banks
			*	------------------------------------------------------------------------------
			*/
			$Banks = array();			
			$QBanks = $this->db
							->get("ms_bank")
							->result();
			
			foreach($QBanks as $QBank){
				if(@getimagesize(base_url("assets/pic/bank/".$QBank->image))){
					$BankImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/bank/resize/".$QBank->image)));
					$BankImageHigh = base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/bank/".$QBank->image)));
				}else{
					$BankImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
					$BankImageHigh = $BankImageTumb;
				}
			
				$Bank = array(
						"id"=>$QBank->id,
						"name"=>$QBank->name,
						"image_tumb"=>$BankImageTumb,
						"image_high"=>$BankImageHigh,
					);
				
				array_push($Banks,$Bank);				
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Sending response
			*	------------------------------------------------------------------------------
			*/
			$this->response->send(array("result"=>1,"couriers"=>$Couriers,"provinces"=>$Provinces,"banks"=>$Banks), true);
		
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
					$BankImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/bank/resize/".$QBank->image)));
					$BankImageHigh = base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/bank/".$QBank->image)));
				}else{
					$BankImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
					$BankImageHigh = $BankImageTumb;
				}
			
				$Bank = array(
						"id"=>$QBank->id,
						"acc_name"=>$QBank->acc_name,
						"acc_no"=>$QBank->acc_no,
						"bank_name"=>$QBank->bank_name,
						"image_tumb"=>$BankImageTumb,
						"image_high"=>$BankImageHigh,
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
			$Favorites = array();
			$QFavorites = $this->db
					->select("tf.product_id")
					->join("tb_product tp","tf.product_id = tp.id")
					->where("tp.active",1)
					->where("tf.member_id",$QUser->id)
					->get("tb_favorite tf")
					->result();
			
			foreach($QFavorites as $QFavorite){
				$Favorite = $this->getProductById($QFavorite->product_id,$QUser->id);
				if($Favorite != null){
					array_push($Favorites,$Favorite);
				}
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	get data member product
			*	------------------------------------------------------------------------------
			*/
			$Products = array();
			$QProducts = $this->db
					->select("tp.id")
					->join("tb_toko_category_product ttcp","ttcp.id = tp.toko_category_product_id")
					->where("tp.active",1)
					->where("ttcp.toko_id IN (SELECT ttm.toko_id FROM tb_toko_member ttm WHERE ttm.member_id = ".$QUser->id.")")
					->limit(10,0)
					->get("tb_product tp")
					->result();
			
			foreach($QProducts as $QProduct){
				$Product = $this->getProductById($QProduct->id,$QUser->id);
				if($Product != null){
					array_push($Products,$Product);
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
			
			$ShopMembers = array();
			foreach($QShopMembers as $QShopMember){
				$ShopMember = $this->getShopById($QShopMember->toko_id,$QUser->id);
				if($ShopMember != null){
					array_push($ShopMembers,$ShopMember);
				}
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	get data member shop invites
			*	------------------------------------------------------------------------------
			*/
			
			$QShopInvites = $this->db
					->where("ti.member_id",$QUser->id)
					->get("tb_invite ti")
					->result();
			
			$ShopInvites = array();
			foreach($QShopInvites as $QShopInvite){
				$ShopInvite = $this->getShopById($QShopInvite->toko_id,$QUser->id);
				if($ShopInvite != null){
					array_push($ShopInvites,$ShopInvite);
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
			*	get data member invoice
			*	------------------------------------------------------------------------------
			*/
			
			$Invoices = $this->getInvoicesByUser($QUser->id);
			
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
					"favorites"=>$Favorites,
					"products"=>$Products,
					"shop_members"=>$ShopMembers,
					"shop_invites"=>$ShopInvites,
					"carts"=>$Carts,
					"invoices"=>$Invoices,
				);
			
			$this->response->send($Object, true);
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doRunService(){
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
			*	Mengambil data toko joined
			*	------------------------------------------------------------------------------
			*/
			$Shops = array();
			$QShops = $this->db
						->where("member_id",$QUser->id)
						->get("tb_toko_member")
						->result();
						
			foreach($QShops as $QShop){
				$Shop = $this->getShopById($QShop->toko_id,$QUser->id);
				array_push($Shops,$Shop);
			}
			
			$this->response->send(array("result"=>1,"shops"=>$Shops), true);
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
			$QProduct = $QProduct->select("tp.id");
			$QProduct = $QProduct->join("tb_toko_category_product tkcp","tkcp.id = tp.toko_category_product_id");
			$QProduct = $QProduct->where("tp.active",1);
			$QProduct = $QProduct->where("tkcp.toko_id in (SELECT toko_id FROM tb_toko_member WHERE member_id = ".$QUser->id.")",null,false);
			
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
					$Product = $this->getProductById($QProduct->id,$QUser->id);
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
	
	public function getShopsByPin(){
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
			
			if($this->response->post("pin") == "" || $this->response->postDecode("pin") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tulis PIN toko yang anda cari","messageCode"=>1), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Query data-data toko
			*	------------------------------------------------------------------------------
			*/
			$QShops = $this->db->select("tt.id");
			
			if($this->response->post("pin") != "" && $this->response->postDecode("pin") != ""){
				$QShops = $QShops->where("tt.tag_name",$this->response->postDecode("pin"));
			}
			
			$QShops = $QShops->get("tb_toko tt");
			$QShops = $QShops->result();
			
			if(sizeOf($QShops) > 0){
				$Shops = array();
				foreach($QShops as $QShop){
					$Shop = $this->getShopById($QShop->id, $QUser->id);
					
					if($Shop != null){
						array_push($Shops,$Shop);
					}
				}
				
				$this->response->send(array("result"=>1,"shops"=>$Shops), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak ada toko yang ditemukan","messageCode"=>3), true);
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
			$QShops = $this->db
					->select("ttm.toko_id")
					->where("ttm.member_id",$QUser->id)
					->get("tb_toko_member ttm")
					->result();
			
			if(sizeOf($QShops) > 0){
				$Shops = array();
				foreach($QShops as $QShop){
					$Shop = $this->getShopById($QShop->toko_id, $QUser->id);
					
					array_push($Shops,$Shop);
				}
				
				$this->response->send(array("result"=>1,"shops"=>$Shops), true);
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
			if(@getimagesize(base_url("assets/pic/shop/".$QShop->image))){
				$ShopImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/shop/resize/".$QShop->image)));
				$ShopImageHigh = base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/shop/".$QShop->image)));
			}else{
				$ShopImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
				$ShopImageHigh = $ShopImageTumb;
			}
		
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
				"image_tumb"=>$ShopImageTumb,
				"image_high"=>$ShopImageHigh,
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
			$QProduct = $QProduct->select("tp.id");
			$QProduct = $QProduct->join("tb_toko_category_product tkcp","tkcp.id = tp.toko_category_product_id");
			$QProduct = $QProduct->where("tkcp.toko_id", $QShop->id);
			$QProduct = $QProduct->where("tp.active", 1);
			
			if($this->response->post("keyword") != "" && $this->response->postDecode("keyword") != ""){
				$QProduct = $QProduct->where("tp.name LIKE ","%".$this->response->postDecode("keyword")."%");
			}
			
			$QProduct = $QProduct->get("tb_product tp");
			$QProducts = $QProduct->result();
			
			if(sizeOf($QProducts) > 0){
				$Products = array();
				
				foreach($QProducts as $QProduct){
					$Product = $this->getProductById($QProduct->id, $QUser->id);
					array_push($Products,$Product);
				}
			
				$this->response->send(array("result"=>1,"products"=>$Products), true);
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
					->where("toko_id",$QShop->id)
					->where("member_id",$QUser->id)
					->get("tb_toko_member")
					->row();
						
			if(empty($QFollow)){
				if($QShop->privacy == 1){
					$FollowData = array(
						"toko_id"=>$QShop->id,
						"member_id"=>$QUser->id,
						"create_date"=>date("Y-m-d H:i:s"),
						"create_user"=>$QUser->email,
						"update_date"=>date("Y-m-d H:i:s"),
						"update_user"=>$QUser->email,
					);
						
					$Save = $this->db->insert("tb_toko_member",$FollowData);
					
					if($Save){
					/*
						$QJoin = $this->db
								->where("toko_id",$QShop->id)
								->where("member_id",$QUser->id)
								->get("tb_join_in")
								->row();
						
						if(empty($QJoin)){
					*/
							$JoinData = array(
								"toko_id"=>$QShop->id,
								"member_id"=>$QUser->id,
								"status"=>1,
								"create_date"=>date("Y-m-d H:i:s"),
								"create_user"=>$QUser->email,
								"update_date"=>date("Y-m-d H:i:s"),
								"update_user"=>$QUser->email,
							);
								
							$Save = $this->db->insert("tb_join_in",$JoinData);
						//}
					
						$this->response->send(array("result"=>1,"message"=>"Anda telah tergabung dengan toko ini","messageCode"=>5), true);
					}else{
						$this->response->send(array("result"=>0,"message"=>"Anda tidak dapat bergabung dengan toko ini","messageCode"=>6), true);
					}
				}else{
					$QJoin = $this->db
							->where("toko_id",$QShop->id)
							->where("member_id",$QUser->id)
							->get("tb_join_in")
							->row();
						
					if(empty($QJoin)){
						$Join = array(
							"toko_id"=>$QShop->id,
							"member_id"=>$QUser->id,
							"status"=>0,
							"create_date"=>date("Y-m-d H:i:s"),
							"create_user"=>$QUser->email,
							"update_date"=>date("Y-m-d H:i:s"),
							"update_user"=>$QUser->email,
						);
							
						$Save = $this->db->insert("tb_join_in",$Join);
						
						if($Save){
							$this->response->send(array("result"=>1,"message"=>"Permintaan bergabung anda telah dikirim","messageCode"=>7), true);
						}else{
							$this->response->send(array("result"=>0,"message"=>"Anda tidak dapat bergabung dengan toko ini","messageCode"=>8), true);
						}
					}else{
						$this->response->send(array("result"=>1,"message"=>"Permintaan bergabung telah dikirim","messageCode"=>8), true);
					}
				}
			}else{
				$Delete = $this->db->where("id",$QFollow->id)->delete("tb_toko_member");
				
				if($Delete){
					$this->response->send(array("result"=>1,"message"=>"Anda sudah keluar dari keanggotaan toko ini","messageCode"=>9), true);
				}else{
					$this->response->send(array("result"=>0,"message"=>"Anda tidak dapat keluar dari keanggotaan toko ini","messageCode"=>10), true);
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
					$Product = $this->getProductById($QProduct->id,$QUser->id);
							
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
			
			$Product = $this->getProductById($this->response->postDecode("product"),$QUser->id);
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
			
			if($this->response->post("province") == "" || $this->response->postDecode("province") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data propinsi yang dipilih","messageCode"=>1), true);
				return;
			}
			
			if($this->response->post("city") == "" || $this->response->postDecode("city") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data kota yang dipilih","messageCode"=>1), true);
				return;
			}
			
			if($this->response->post("kecamatan") == "" || $this->response->postDecode("kecamatan") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data kecamatan yang dipilih","messageCode"=>1), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Cari data location berdasarkan province, city & kecamatan
			*	------------------------------------------------------------------------------
			*/
			$QLocation = $this->db
					->where("province",$this->response->postDecode("province"))
					->where("city",$this->response->postDecode("city"))
					->where("kecamatan",$this->response->postDecode("kecamatan"))
					->get("ms_location")
					->row();
			
			if(empty($QLocation)){
				$this->response->send(array("result"=>0,"message"=>"Data lokasi tidak ditemukan","messageCode"=>1), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Simpan data shipment
			*	------------------------------------------------------------------------------
			*/
			$Save = false;
			$Date = date("Y-m-d H:i:s");
			
			if($this->response->post("user_location") == "" || $this->response->postDecode("user_location") == ""){
				$Data = array(
						"location_id"=>$QLocation->id,
						"member_id"=>$QUser->id,
						"name"=>$this->response->postDecode("name"),
						"address"=>$this->response->postDecode("address"),
						"phone"=>$this->response->postDecode("phone"),
						"postal"=>$this->response->postDecode("postal"),
						"create_date"=>$Date,
						"create_user"=>$QUser->email,
						"update_date"=>$Date,
						"update_user"=>$QUser->email,
					);
				
				$Save = $this->db->insert("tb_member_location",$Data);
			}else{
				$Data = array(
						"location_id"=>$QLocation->id,
						"member_id"=>$QUser->id,
						"name"=>$this->response->postDecode("name"),
						"address"=>$this->response->postDecode("address"),
						"phone"=>$this->response->postDecode("phone"),
						"postal"=>$this->response->postDecode("postal"),
						"update_date"=>$Date,
						"update_user"=>$QUser->email,
					);
				$Save = $this->db->where("id",$this->response->postDecode("user_location"))->update("tb_member_location",$Data);
			}
			
			if($Save){
				/*
				*	------------------------------------------------------------------------------
				*	Ambil data user location yang telah disimpan
				*	------------------------------------------------------------------------------
				*/
				if($this->response->post("user_location") == "" || $this->response->postDecode("user_location") == ""){
					$QUserLocation = $this->db
							->where("location_id",$QLocation->id)
							->where("member_id",$QUser->id)
							->where("name",$this->response->postDecode("name"))
							->where("address",$this->response->postDecode("address"))
							->where("phone",$this->response->postDecode("phone"))
							->where("postal",$this->response->postDecode("postal"))
							->where("create_date",$Date)
							->where("create_user",$QUser->email)
							->where("update_date",$Date)
							->where("update_user",$QUser->email)
							->get("tb_member_location")
							->row();
				}else{
					$QUserLocation = $this->db
							->where("id",$this->response->postDecode("user_location"))
							->get("tb_member_location")
							->row();
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	Buat object user location
				*	------------------------------------------------------------------------------
				*/
				$UserLocation = array(
							"id"=>$QUserLocation->id,
							"name"=>$QUserLocation->name,
							"phone"=>$QUserLocation->phone,
							"postal"=>$QUserLocation->postal,
							"address"=>$QUserLocation->address,
							"location_id"=>$QUserLocation->location_id,
							"province"=>$QLocation->province,
							"city"=>$QLocation->city,
							"kecamatan"=>$QLocation->kecamatan,
						);
				
				$this->response->send(array("result"=>1,"user_location"=>$UserLocation,"messageCode"=>4), true);
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
			
			if($this->response->post("user_location") == "" || $this->response->postDecode("user_location") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada lokasi user yang dipilih","messageCode"=>3), true);
				return;
			}
			
			$QUserLocation = $this->db->where("id",$this->response->postDecode("user_location"))->get("tb_member_location")->row();
			if(empty($QUserLocation)){
				$this->response->send(array("result"=>0,"message"=>"Data lokasi user tidak ditemukan","messageCode"=>4), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Delete data shipment
			*	------------------------------------------------------------------------------
			*/
			
			$Delete = $this->db->where("id",$this->response->postDecode("user_location"))->delete("tb_member_location");
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
			
			if($this->response->post("bank") == "" || $this->response->postDecode("bank") == ""){
				$this->response->send(array("result"=>0,"message"=>"Nama bank belum dipilih","messageCode"=>3), true);
				return;
			}
			
			$QBank = $this->db->where("name",$this->response->postDecode("bank"))->get("ms_bank")->row();
			if(empty($QBank)){
				$this->response->send(array("result"=>0,"message"=>"Nama bank yang dipilih tidak ditemukan","messageCode"=>4), true);
				return;
			}
			
			if($this->response->post("acc_name") == "" || $this->response->postDecode("acc_name") == ""){
				$this->response->send(array("result"=>0,"message"=>"Nama nasabah masih kosong","messageCode"=>5), true);
				return;
			}
			
			if($this->response->post("acc_no") == "" || $this->response->postDecode("acc_no") == ""){
				$this->response->send(array("result"=>0,"message"=>"Nomor rekening masih kosong","messageCode"=>6), true);
				return;
			}
			/*
			*	------------------------------------------------------------------------------
			*	Simpan data shipment
			*	------------------------------------------------------------------------------
			*/
			$Save = false;
			$Date = date("Y-m-d H:i:s");
			
			if($this->response->post("user_bank") == "" || $this->response->postDecode("user_bank") == ""){
				$Data = array(
						"bank_id"=>$QBank->id,
						"member_id"=>$QUser->id,
						"acc_name"=>$this->response->postDecode("acc_name"),
						"acc_no"=>$this->response->postDecode("acc_no"),
						"create_date"=>$Date,
						"create_user"=>$QUser->email,
						"update_date"=>$Date,
						"update_user"=>$QUser->email,
					);
				
				$Save = $this->db->insert("tb_member_bank",$Data);
			}else{
				$Data = array(
						"bank_id"=>$QBank->id,
						"member_id"=>$QUser->id,
						"acc_name"=>$this->response->postDecode("acc_name"),
						"acc_no"=>$this->response->postDecode("acc_no"),
						"update_date"=>$Date,
						"update_user"=>$QUser->email,
					);
					
				$Save = $this->db->where("id",$this->response->postDecode("user_bank"))->update("tb_member_bank",$Data);
			}
			
			if($Save){
				if($this->response->post("user_bank") == "" || $this->response->postDecode("user_bank") == ""){
					$QUserBank = $this->db
								->where("bank_id",$QBank->id)
								->where("member_id",$QUser->id)
								->where("acc_name",$this->response->postDecode("acc_name"))
								->where("acc_no",$this->response->postDecode("acc_no"))
								->where("create_date",$Date)
								->where("create_user",$QUser->email)
								->where("update_date",$Date)
								->where("update_user",$QUser->email)
								->get("tb_member_bank")
								->row();
				}else{
					$QUserBank = $this->db
								->where("id",$this->response->postDecode("user_bank"))
								->get("tb_member_bank")
								->row();
				}
				$UserBank = array();
				if(!empty($QUserBank)){
					$QBank = $this->db
							->where("id",$QUserBank->bank_id)
							->get("ms_bank")
							->row();
					
					$Bank = array();
					if(!empty($QBank)){
						if(@getimagesize(base_url("assets/pic/bank/".$QBank->image))){
							$BankImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/bank/resize/".$QBank->image)));
							$BankImageHigh = base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/bank/".$QBank->image)));
						}else{
							$BankImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
							$BankImageHigh = $BankImageTumb;
						}
				
						$Bank = array(
								"id"=>$QBank->id,
								"name"=>$QBank->name,
								"image_tumb"=>$BankImageTumb,
								"image_high"=>$BankImageHigh,
							);
					}
					
					$UserBank = array(
							"id"=>$QUserBank->id,
							"acc_name"=>$QUserBank->acc_name,
							"acc_no"=>$QUserBank->acc_no,
							"bank"=>$Bank,
						);
				}
							
				$this->response->send(array("result"=>1,"user_bank"=>$UserBank), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Data bank tidak dapat disimpan","messageCode"=>7), true);
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
			
			if($this->response->post("user_bank") == "" || $this->response->postDecode("user_bank") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada bank user yang dipilih","messageCode"=>3), true);
				return;
			}
			
			$QUserBank = $this->db->where("id",$this->response->postDecode("user_bank"))->get("tb_member_bank")->row();
			if(empty($QUserBank)){
				$this->response->send(array("result"=>0,"message"=>"Data bank user tidak ditemukan","messageCode"=>4), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Delete data shipment
			*	------------------------------------------------------------------------------
			*/
			
			$Delete = $this->db->where("id",$this->response->postDecode("user_bank"))->delete("tb_member_bank");
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
			*	ubah data password
			*	------------------------------------------------------------------------------
			*/
			$Data = array(
					"password"=>md5($this->response->postDecode("password_new")),
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
	
	public function doInvoiceConfirm(){
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
			
			if($this->response->post("invoice") == "" || $this->response->postDecode("invoice") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data toko yang dipilih","messageCode"=>3), true);
				return;
			}
			
			$QInvoice = $this->db->where("id",$this->response->postDecode("invoice"))->get("tb_invoice")->row();
			if(empty($QInvoice)){
				$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>4), true);
				return;
			}
			
			$Data = array(
					"member_confirm"=>1,
				);
			
			$Save = $this->db->where("id",$QInvoice->id)->update("tb_invoice",$Data);
			if($Save){
				$this->response->send(array("result"=>1,"message"=>"Konfirmasi pembayaran telah di kirimkan","messageCode"=>5), true);
				return;
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak dapat mengirim konfirmasi pembayaran nota anda","messageCode"=>6), true);
				return;
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
										"product"=>$this->getProductById($QProductVarian->product_id,$QUser->id),
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
						"shop"=>$this->getShopById($QCart->toko_id,$QUser->id),
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
	
	public function alphabet(){
		if(empty($_SESSION["alphabet"])){
			$_SESSION["alphabet"] = "A";
		}else{
			$_SESSION["alphabet"]++;
		}
		
		echo $_SESSION["alphabet"]; 
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
			
			$QUser = $this->db
						->where("id",$this->response->postDecode("user"))
						->get("tb_member")
						->row();
						
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
				$this->response->send(array("result"=>0,"message"=>"Daftar belanja anda tidak valid","messageCode"=>2), true);
				return;
			}
			
			if($this->response->post("courier_type") == "" || $this->response->postDecode("courier_type") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tipe pengiriman belum dipilih","messageCode"=>3), true);
				return;
			}
			
			if($this->response->postDecode("courier_type") != "0"){
				if($this->response->post("courier") == "" || $this->response->postDecode("courier") == ""){
					$this->response->send(array("result"=>0,"message"=>"Tidak ada kurir yang dipilih","messageCode"=>3), true);
					return;
				}
				
				if($this->response->post("location_name") == "" || $this->response->postDecode("location_name") == ""){
					$this->response->send(array("result"=>0,"message"=>"Tidak ada data nama penerima","messageCode"=>3), true);
					return;
				}
				
				if($this->response->post("location_address") == "" || $this->response->postDecode("location_address") == ""){
					$this->response->send(array("result"=>0,"message"=>"Tidak ada data alamat penerima","messageCode"=>3), true);
					return;
				}
				
				if($this->response->post("province") == "" || $this->response->postDecode("province") == ""){
					$this->response->send(array("result"=>0,"message"=>"Tidak ada data propinsi alamat penerima","messageCode"=>3), true);
					return;
				}
				
				if($this->response->post("city") == "" || $this->response->postDecode("city") == ""){
					$this->response->send(array("result"=>0,"message"=>"Tidak ada data kota alamat penerima","messageCode"=>3), true);
					return;
				}
				
				if($this->response->post("kecamatan") == "" || $this->response->postDecode("kecamatan") == ""){
					$this->response->send(array("result"=>0,"message"=>"Tidak ada data kecamatan alamat penerima","messageCode"=>3), true);
					return;
				}
			}
			
		
			if($this->response->postDecode("courier_type") == "1"){
				$QCourier = $this->db
						->where("name",$this->response->postDecode("courier"))
						->get("ms_courier")
						->row();
						
				if(empty($QCourier)){
					$this->response->send(array("result"=>0,"message"=>"Kurir tidak ditemukan","messageCode"=>3), true);
					return;
				}
			}elseif($this->response->postDecode("courier_type") == "2"){
				$QCourier = $this->db
						->where("name",$this->response->postDecode("courier"))
						->where("toko_id",$QCart->toko_id)
						->get("tb_courier_custom")
						->row();
				
				if(empty($QCourier)){
					$this->response->send(array("result"=>0,"message"=>"Kurir tidak ditemukan","messageCode"=>3), true);
					return;
				}
			}else{
				$QCourier = null;
			}
			
			
			
			/*
			*	------------------------------------------------------------------------------
			*	Membuat Object Invoice
			*	------------------------------------------------------------------------------
			*/
			
			$Invoice;
			
			/*
			*	------------------------------------------------------------------------------
			*	Ambil data alamat tujuan pengiriman
			*	------------------------------------------------------------------------------
			*/
			
			if($this->response->postDecode("user_location") != ""){
				$QUserLocation = $this->db
					->select("tml.*, ml.kecamatan as location_kecamatan, ml.city as location_city, ml.province as location_province, ml.postal_code as location_postal")
					->join("ms_location ml","tml.location_id = ml.id")
					->where("tml.id",$this->response->postDecode("user_location"))
					->get("tb_member_location tml")
					->row();
			}else if($this->response->postDecode("courier_type") != "0"){
				$QLocation = $this->db
						->where("kecamatan",$this->response->postDecode("kecamatan"))
						->where("city",$this->response->postDecode("city"))
						->where("province",$this->response->postDecode("province"))
						->where("postal_code",$this->response->postDecode("location_postal"))
						->get("ms_location")
						->row();
						
				if(empty($QLocation)){
					$QLocation = $this->db
						->where("kecamatan",$this->response->postDecode("kecamatan"))
						->where("city",$this->response->postDecode("city"))
						->where("province",$this->response->postDecode("province"))
						->get("ms_location")
						->row();
				}
				
				if(!empty($QLocation)){
					$Data = array(
						"member_id"=>$QUser->id,
						"location_id"=>$QLocation->id,
						"name"=>$this->response->postDecode("location_name"),
						"address"=>$this->response->postDecode("location_address"),
						"phone"=>$this->response->postDecode("location_phone"),
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
						->where("tml.name",$this->response->postDecode("location_name"))
						->where("tml.address",$this->response->postDecode("location_address"))
						->where("tml.phone",$this->response->postDecode("location_phone"))
						->where("tml.postal",$this->response->postDecode("location_postal"))
						->get("tb_member_location tml")
						->row();
				}else{
					$this->response->send(array("result"=>0,"message"=>"Lokasi penerima tidak valid","messageCode"=>3), true);
					return;
				}
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Syncronisasi data varian dari apps ke server
			*	------------------------------------------------------------------------------
			*/
			
			if($this->response->post("cart_varians") != "" && $this->response->postDecode("cart_varians") != "" && $this->response->postDecode("cart_varians") > 0){
				for ($i = 0; $i <$this->response->postDecode("cart_varians"); $i++) {
					if($this->response->post("cart_varian_".$i) != "" && $this->response->postDecode("cart_varian_".$i) != "" && $this->response->post("cart_varian_quantity_".$i) != "" && $this->response->postDecode("cart_varian_quantity_".$i) != ""){
						$Data = array(
									"quantity"=>$this->response->postDecode("cart_varian_quantity_".$i),
								);
								
						$Save = $this->db->where("id",$this->response->postDecode("cart_varian_".$i))->update("tb_cart_varian",$Data);
					}
				}
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Get Shop of cart
			*	------------------------------------------------------------------------------
			*/
			
			$QShop = $this->db
					->where("id",$QCart->toko_id)
					->get("tb_toko")
					->row();
			
			/*
			*	------------------------------------------------------------------------------
			*	Hitung Harga Total, Harga Pengiriman, Harga Unik dari tabel Cart Product
			*	------------------------------------------------------------------------------
			*/
			
			$invoice_no = "";
			$price_item = 0;
			$price_shipment = 0;
			$price_unique = 0;
			$price_total = 0;
			$shipment_rate = 0;
			$shipment_weight = 0;
			{
				/*
				*	------------------------------------------------------------------------------
				*	Generate Invoice Number
				*	------------------------------------------------------------------------------
				*/
				
				$seq_no = $QShop->invoice_seq_no;
				$seq_alphabet = $QShop->invoice_seq_alphabet;
						
				$LastInvoice = $this->db
							->where("toko_id",$QShop->id)
							->order_by("id","Desc")
							->get("tb_invoice")
							->row();
							
				if(!empty($LastInvoice)){
					$LastInvoiceDates = explode(" ",$LastInvoice->create_date);
					if( $LastInvoiceDates[0] != date("Y-m-d")){
						$seq_no = 1;
						$seq_alphabet = "A";
					}
				}
					
				$invoice_no = date("ymd").$seq_alphabet.sprintf("%03d", $seq_no);
				
				/*
				*	------------------------------------------------------------------------------
				*	Generate Invoice Price Unique (invoice_seq_payment)
				*	------------------------------------------------------------------------------
				*/
				
				if($QShop->invoice_confirm == 0){
					$price_unique = $QShop->invoice_seq_payment;
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	Generate Invoice Price Shipment (ms_courier)
				*	------------------------------------------------------------------------------
				*/
				if($this->response->postDecode("courier_type") == "1"){
					if(!empty($QShop->location_id)){
						$QShopLocation = $this->db
										->where("id",$QShop->location_id)
										->get("ms_location")
										->row();
										
						if(!empty($QShopLocation)){
							$QCourierRate = $this->db
									->where("courier_id",$QCourier->id)
									->where("location_from_province",$QShopLocation->province)
									->where("location_from_city",$QShopLocation->city)
									->where("location_from_kecamatan",$QShopLocation->kecamatan)
									->where("location_to_province",$this->response->postDecode("province"))
									->where("location_to_city",$this->response->postDecode("city"))
									->where("location_to_kecamatan",$this->response->postDecode("kecamatan"))
									->get("tb_courier_rate")
									->row();
						
							if(!empty($QCourierRate)){
								$shipment_rate = $QCourierRate->price;
							}
						}
					}
				}else if($this->response->postDecode("courier_type") == "2"){
					if(!empty($QShopLocation)){
						$QCourierRate = $this->db
								->where("courier_custom_id",$QCourier->id)
								->where("location_to_province",$this->response->postDecode("province"))
								->where("location_to_city",$this->response->postDecode("city"))
								->where("location_to_kecamatan",$this->response->postDecode("kecamatan"))
								->get("tb_courier_custom_rate")
								->row();
					
						if(!empty($QCourierRate)){
							$shipment_rate = $QCourierRate->price;
						}
					}
				}else{
					$shipment_rate = 0;
				}
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Generate Invoice Price product
			*	------------------------------------------------------------------------------
			*/
			$QCartProducts = $this->db
					->select("tcp.*, tp.id as product_id, tp.name as product_name, tp.description as product_description, tp.price_base")
					->join("tb_product tp","tcp.product_id = tp.id")
					->where("tcp.cart_id",$QCart->id)
					->get("tb_cart_product tcp")
					->result();
			
			
			foreach($QCartProducts as $QCartProduct){
				$product_price = 0;
				$price_product = 0;
				
				/*
				*	------------------------------------------------------------------------------
				*	Mengambil Harga Barang
				*	------------------------------------------------------------------------------
				*/
				
				$QProduct = $this->db
						->where("id",$QCartProduct->product_id)
						->get("tb_product")
						->row();
				
				if(!empty($QProduct)){
					$product_price = $QProduct->price_1;
					
					$QShopMember = $this->db
						->where("toko_id",$QShop->id)
						->where("member_id",$QUser->id)
						->get("tb_toko_member")
						->row();
									
					if(!empty($QShopMember)){
						switch($QShopMember->price_level){
							case "1":
								$product_price = $QProduct->price_1;
							break;
							
							case "2":
								$product_price = $QProduct->price_2;
							break;
							
							case "3":
								$product_price = $QProduct->price_3;
							break;
							
							case "4":
								$product_price = $QProduct->price_4;
							break;
							
							case "5":
								$product_price = $QProduct->price_5;
							break;
						}
					}
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	Mengambil data cart varian
				*	------------------------------------------------------------------------------
				*/
				
				$QCartVarians = $this->db
					->select("tcv.*")
					->join("tb_product_varian tpv","tcv.product_varian_id = tpv.id")
					->where("tcv.cart_product_id",$QCartProduct->id)
					->get("tb_cart_varian tcv")
					->result();
						
				foreach($QCartVarians as $QCartVarian){
					$price_item = $price_item + ($QCartVarian->quantity * $product_price);
					$price_product = $price_product + ($QCartVarian->quantity * $product_price);
					
					if(!empty($QProduct)){
						$weightVarian = $QProduct->weight * $QCartVarian->quantity;
						
						$shipment_weight = $shipment_weight + $weightVarian;
					}
				}
				
				$Data = array(
						"price_product"=>$price_product,
					);
					
				$Save = $this->db->where("id",$QCartProduct->id)->update("tb_cart_product",$Data);
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Simpan data cart ke invoice
			*	------------------------------------------------------------------------------
			*/
			$Date = date("Y-m-d H:i:s");
			$price_shipment = $shipment_rate * $shipment_weight;
			$price_total = $price_item + $price_shipment + $price_unique;
			
			if($this->response->postDecode("courier_type") == "0"){
				$Data = array(
						"toko_id"=>$QCart->toko_id,
						"member_id"=>$QUser->id,
						"member_name"=>$QUser->name,
						"member_email"=>$QUser->email,
						"member_confirm"=>0,
						"courier_id"=>null,
						"courier_custom_id"=>null,
						"courier_type"=>$this->response->postDecode("courier_type"),
						"notes"=>$this->response->postDecode("location_description"),
						"invoice_no"=>$invoice_no,
						"price_total"=>$price_total,
						"price_item"=>$price_item,
						"price_shipment"=>$price_shipment,
						"invoice_seq_payment"=>$price_unique,
						"shipment_no"=>"",
						"shipment_service"=>"",
						"recipient_name"=>"",
						"recipient_phone"=>"",
						"recipient_address"=>"",
						"location_to_province"=>"",
						"location_to_city"=>"",
						"location_to_kecamatan"=>"",
						"location_to_postal"=>"",
						"status"=>0,
						"stock_type"=>1,
						"create_date"=>$Date,
						"create_user"=>$QUser->email,
						"update_date"=>$Date,
						"update_user"=>$QUser->email,
					);
			}else if($this->response->postDecode("courier_type") == "1"){
				$Data = array(
						"toko_id"=>$QCart->toko_id,
						"member_id"=>$QUser->id,
						"member_name"=>$QUser->name,
						"member_email"=>$QUser->email,
						"member_confirm"=>0,
						"courier_id"=>$QCourier->id,
						"courier_custom_id"=>null,
						"courier_type"=>$this->response->postDecode("courier_type"),
						"notes"=>$this->response->postDecode("location_description"),
						"invoice_no"=>$invoice_no,
						"price_total"=>$price_total,
						"price_item"=>$price_item,
						"price_shipment"=>$price_shipment,
						"invoice_seq_payment"=>$price_unique,
						"shipment_no"=>"",
						"shipment_service"=>$QCourier->name,
						"recipient_name"=>$this->response->postDecode("location_name"),
						"recipient_phone"=>$this->response->postDecode("location_phone"),
						"recipient_address"=>$this->response->postDecode("location_address"),
						"location_to_province"=>$this->response->postDecode("province"),
						"location_to_city"=>$this->response->postDecode("city"),
						"location_to_kecamatan"=>$this->response->postDecode("kecamatan"),
						"location_to_postal"=>$this->response->postDecode("location_postal"),
						"status"=>0,
						"stock_type"=>1,
						"create_date"=>$Date,
						"create_user"=>$QUser->email,
						"update_date"=>$Date,
						"update_user"=>$QUser->email,
					);
			}else if($this->response->postDecode("courier_type") == "2"){
				$Data = array(
						"toko_id"=>$QCart->toko_id,
						"member_id"=>$QUser->id,
						"member_name"=>$QUser->name,
						"member_email"=>$QUser->email,
						"member_confirm"=>0,
						"courier_id"=>null,
						"courier_custom_id"=>$QCourier->id,
						"courier_type"=>$this->response->postDecode("courier_type"),
						"notes"=>$this->response->postDecode("location_description"),
						"invoice_no"=>$invoice_no,
						"price_total"=>$price_total,
						"price_item"=>$price_item,
						"price_shipment"=>$price_shipment,
						"invoice_seq_payment"=>$price_unique,
						"shipment_no"=>"",
						"shipment_service"=>$QCourier->name,
						"recipient_name"=>$this->response->postDecode("location_name"),
						"recipient_phone"=>$this->response->postDecode("location_phone"),
						"recipient_address"=>$this->response->postDecode("location_address"),
						"location_to_province"=>$this->response->postDecode("province"),
						"location_to_city"=>$this->response->postDecode("city"),
						"location_to_kecamatan"=>$this->response->postDecode("kecamatan"),
						"location_to_postal"=>$this->response->postDecode("location_postal"),
						"status"=>0,
						"stock_type"=>1,
						"create_date"=>$Date,
						"create_user"=>$QUser->email,
						"update_date"=>$Date,
						"update_user"=>$QUser->email,
					);
			}
			
			$Save = $this->db->insert("tb_invoice",$Data);
			
			if($Save){
				/*
				*	------------------------------------------------------------------------------
				*	Query ambil data Invoice Terbaru
				*	------------------------------------------------------------------------------
				*/
				
				if($this->response->postDecode("courier_type") == "0"){
					$QInvoice = $this->db
						->where("toko_id",$QCart->toko_id)
						->where("member_id",$QUser->id)
						->where("member_name",$QUser->name)
						->where("member_email",$QUser->email)
						->where("member_confirm",0)
						->where("courier_id",null)
						->where("courier_custom_id",null)
						->where("courier_type",$this->response->postDecode("courier_type"))
						->where("invoice_no",$invoice_no)
						->where("notes",$this->response->postDecode("location_description"))
						->where("price_total",$price_total)
						->where("price_item",$price_item)
						->where("price_shipment",$price_shipment)
						->where("invoice_seq_payment",$price_unique)
						->where("shipment_no","")
						->where("shipment_service","")
						->where("recipient_name","")
						->where("recipient_phone","")
						->where("recipient_address","")
						->where("location_to_province","")
						->where("location_to_city","")
						->where("location_to_kecamatan","")
						->where("location_to_postal","")
						->where("status",0)
						->where("stock_type",1)
						->where("create_date",$Date)
						->where("create_user",$QUser->email)
						->where("update_date",$Date)
						->where("update_user",$QUser->email)
						->get("tb_invoice")
						->row();
						
				}else if($this->response->postDecode("courier_type") == "1"){
					$QInvoice = $this->db
						->where("toko_id",$QCart->toko_id)
						->where("member_id",$QUser->id)
						->where("member_name",$QUser->name)
						->where("member_email",$QUser->email)
						->where("member_confirm",0)
						->where("courier_id",$QCourier->id)
						->where("courier_custom_id",null)
						->where("courier_type",$this->response->postDecode("courier_type"))
						->where("invoice_no",$invoice_no)
						->where("notes",$this->response->postDecode("location_description"))
						->where("price_total",$price_total)
						->where("price_item",$price_item)
						->where("price_shipment",$price_shipment)
						->where("invoice_seq_payment",$price_unique)
						->where("shipment_no","")
						->where("shipment_service",$QCourier->name)
						->where("recipient_name",$this->response->postDecode("location_name"))
						->where("recipient_phone",$this->response->postDecode("location_phone"))
						->where("recipient_address",$this->response->postDecode("location_address"))
						->where("location_to_province",$this->response->postDecode("province"))
						->where("location_to_city",$this->response->postDecode("city"))
						->where("location_to_kecamatan",$this->response->postDecode("kecamatan"))
						->where("location_to_postal",$this->response->postDecode("location_postal"))
						->where("status",0)
						->where("stock_type",1)
						->where("create_date",$Date)
						->where("create_user",$QUser->email)
						->where("update_date",$Date)
						->where("update_user",$QUser->email)
						->get("tb_invoice")
						->row();
				}else if($this->response->postDecode("courier_type") == "2"){
					$QInvoice = $this->db
						->where("toko_id",$QCart->toko_id)
						->where("member_id",$QUser->id)
						->where("member_name",$QUser->name)
						->where("member_email",$QUser->email)
						->where("member_confirm",0)
						->where("courier_id",null)
						->where("courier_custom_id",$QCourier->id)
						->where("courier_type",$this->response->postDecode("courier_type"))
						->where("invoice_no",$invoice_no)
						->where("notes",$this->response->postDecode("location_description"))
						->where("price_total",$price_total)
						->where("price_item",$price_item)
						->where("price_shipment",$price_shipment)
						->where("invoice_seq_payment",$price_unique)
						->where("shipment_no","")
						->where("shipment_service",$QCourier->name)
						->where("recipient_name",$this->response->postDecode("location_name"))
						->where("recipient_phone",$this->response->postDecode("location_phone"))
						->where("recipient_address",$this->response->postDecode("location_address"))
						->where("location_to_province",$this->response->postDecode("province"))
						->where("location_to_city",$this->response->postDecode("city"))
						->where("location_to_kecamatan",$this->response->postDecode("kecamatan"))
						->where("location_to_postal",$this->response->postDecode("location_postal"))
						->where("status",0)
						->where("stock_type",1)
						->where("create_date",$Date)
						->where("create_user",$QUser->email)
						->where("update_date",$Date)
						->where("update_user",$QUser->email)
						->get("tb_invoice")
						->row();
				}
					
				if(!empty($QInvoice)){
					$InvoiceProducts = array();
					
					/*
					*	------------------------------------------------------------------------------
					*	Update SEQ alphabet, nomor & payment pada table tb_toko
					*	------------------------------------------------------------------------------
					*/
					
					$seq_alphabet_new = $QShop->invoice_seq_alphabet;
					$seq_no_new = $QShop->invoice_seq_no;
					$seq_payment_new = $QShop->invoice_seq_payment;
					
					$LastInvoice = $this->db
								->where("toko_id",$QShop->id)
								->where("id != ",$QInvoice->id)
								->order_by("id","Desc")
								->get("tb_invoice")
								->row();
								
					if(!empty($LastInvoice)){
						$LastInvoiceDates = explode(" ",$LastInvoice->create_date);
						if( $LastInvoiceDates[0] == date("Y-m-d")){
							if($QShop->invoice_seq_no >= 999){
								$seq_no_new = 1;
								$seq_alphabet_new++;
							}else{
								$seq_no_new++;
							}
						}else{
							$seq_no_new = 2;
							$seq_alphabet_new = "A";
						}
					}
					
					if($QShop->invoice_confirm == 0){
						if($QShop->invoice_seq_payment >= 999){
							$seq_payment_new = 1;
						}else{
							$seq_payment_new++;
						}
					}
					
					$Data = array(
							"invoice_seq_no"=>$seq_no_new,
							"invoice_seq_payment"=>$seq_payment_new,
							"invoice_seq_alphabet"=>$seq_alphabet_new,
						);
					
					$Save = $this->db->where("id",$QShop->id)->update("tb_toko",$Data);
					
					
					/*
					*	------------------------------------------------------------------------------
					*	Simpan data invoice product dari cart product
					*	------------------------------------------------------------------------------
					*/
					foreach($QCartProducts as $QCartProduct){
						$Data = array(
								"invoice_id"=>$QInvoice->id,
								"product_id"=>$QCartProduct->product_id,
								"price_product"=>$QCartProduct->price_product,
								"product_name"=>$QCartProduct->product_name,
								"product_image"=>"",
								"product_description"=>$QCartProduct->product_description,
								"create_date"=>$Date,
								"create_user"=>$QUser->email,
								"update_date"=>$Date,
								"update_user"=>$QUser->email,
							);
							
						$Save = $this->db->insert("tb_invoice_product",$Data);
						if($Save){
							/*
							*	------------------------------------------------------------------------------
							*	Query mengambil data invoice product yang baru saja di save
							*	------------------------------------------------------------------------------
							*/
							
							$QInvoiceProduct = $this->db
								->where("invoice_id",$QInvoice->id)
								->where("product_id",$QCartProduct->product_id)
								->where("price_product",$QCartProduct->price_product)
								->where("product_name",$QCartProduct->product_name)
								->where("product_image","")
								->where("product_description",$QCartProduct->product_description)
								->where("create_date",$Date)
								->where("create_user",$QUser->email)
								->where("update_date",$Date)
								->where("update_user",$QUser->email)
								->get("tb_invoice_product")
								->row();
							
							if(!empty($QInvoiceProduct)){
								$InvoiceVarians = array();
								/*
								*	------------------------------------------------------------------------------
								*	Simpan data invoice varian dari cart varian
								*	------------------------------------------------------------------------------
								*/
								
								$QCartVarians = $this->db
									->select("tcv.*, tpv.name as varian_name")
									->join("tb_product_varian tpv","tcv.product_varian_id = tpv.id")
									->where("tcv.cart_product_id",$QCartProduct->id)
									->get("tb_cart_varian tcv")
									->result();
										
								foreach($QCartVarians as $QCartVarian){
									$Data = array(
											"invoice_product_id"=>$QInvoiceProduct->id,
											"product_varian_id"=>$QCartVarian->product_varian_id,
											"quantity"=>$QCartVarian->quantity,
											"varian_name"=>$QCartVarian->varian_name,
											"create_date"=>$Date,
											"create_user"=>$QUser->email,
											"update_date"=>$Date,
											"update_user"=>$QUser->email,
										);
									
									$Save = $this->db->insert("tb_invoice_varian",$Data);
									if($Save){
										$QInvoiceVarian = $this->db
											->where("invoice_product_id",$QInvoiceProduct->id)
											->where("product_varian_id",$QCartVarian->product_varian_id)
											->where("quantity",$QCartVarian->quantity)
											->where("varian_name",$QCartVarian->varian_name)
											->where("create_date",$Date)
											->where("create_user",$QUser->email)
											->where("update_date",$Date)
											->where("update_user",$QUser->email)
											->get("tb_invoice_varian")
											->row();
											
										if(!empty($QInvoiceVarian)){
											$InvoiceVarian = array(
													"id"=>$QInvoiceVarian->id,
													"quantity"=>$QInvoiceVarian->quantity,
													"varian_name"=>$QInvoiceVarian->varian_name,
													"product_varian"=>array(),
												);
											array_push($InvoiceVarians,$InvoiceVarian);
										}
									}
								}
								
								/*
								*	------------------------------------------------------------------------------
								*	Membuat object Invoice Product
								*	------------------------------------------------------------------------------
								*/
								$InvoiceProduct = array(
									"id"=>$QInvoiceProduct->id,
									"price_product"=>$QInvoiceProduct->price_product,
									"product_name"=>$QInvoiceProduct->product_name,
									"product_image"=>"",
									"product_description"=>$QInvoiceProduct->product_description,
									"product"=>$this->getProductById($QInvoiceProduct->product_id,$QUser->id),
									"invoice_varians"=>$InvoiceVarians,
								);
								
								array_push($InvoiceProducts,$InvoiceProduct);
							}
						}
					}
					
					/*
					*	------------------------------------------------------------------------------
					*	Mengambil data Courier
					*	------------------------------------------------------------------------------
					*/
					
					$Courier = null;
					if(!empty($QInvoice->courier_id)){
						$Courier = array();
						$QCourier = $this->db
									->where("id",$QInvoice->courier_id)
									->get("ms_courier")
									->row();
									
						if(!empty($QCourier)){
							if(@getimagesize(base_url("assets/pic/courier/".$QCourier->image))){
								$CourierImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/courier/resize/".$QCourier->image)));
								$CourierImageHigh = base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/courier/".$QCourier->image)));
							}else{
								$CourierImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
								$CourierImageHigh= $CourierImageTumb;
							}
						
							$Courier = array(
									"id"=>$QCourier->id,
									"name"=>$QCourier->name,
									"image_tumb"=>$CourierImageTumb,
									"image_high"=>$CourierImageHigh,
								);
						}
					}
					
					/*
					*	------------------------------------------------------------------------------
					*	Mengambil data Courier Custom
					*	------------------------------------------------------------------------------
					*/
					$CourierCustom = null;
					
					if(!empty($QInvoice->courier_custom_id)){
						$CourierCustom = array();
						
						$QCourierCustom = $this->db
									->where("id",$QInvoice->courier_custom_id)
									->get("tb_courier_custom")
									->row();
									
						if(!empty($QCourierCustom)){
							$CourierCustom = array(
									"id"=>$QCourierCustom->id,
									"name"=>$QCourierCustom->name,
									"status"=>$QCourierCustom->status,
								);
						}
					}
					
					/*
					*	------------------------------------------------------------------------------
					*	Membuat object Invoice
					*	------------------------------------------------------------------------------
					*/
					$Invoice = array(
							"id"=>$QInvoice->id,
							"invoice_no"=>$QInvoice->invoice_no,
							"notes"=>$QInvoice->notes,
							"member_name"=>$QInvoice->member_name,
							"member_email"=>$QInvoice->member_email,
							"member_confirm"=>$QInvoice->member_confirm,
							"status"=>$QInvoice->status,
							"stock_type"=>$QInvoice->stock_type,
							"price_total"=>$QInvoice->price_total,
							"price_item"=>$QInvoice->price_item,
							"price_shipment"=>$QInvoice->price_shipment,
							"invoice_seq_payment"=>$QInvoice->invoice_seq_payment,
							"shipment_no"=>$QInvoice->shipment_no,
							"shipment_service"=>$QInvoice->shipment_service,
							"recipient_name"=>$QInvoice->recipient_name,
							"recipient_phone"=>$QInvoice->recipient_phone,
							"recipient_address"=>$QInvoice->recipient_address,
							"location_to_province"=>$QInvoice->location_to_province,
							"location_to_city"=>$QInvoice->location_to_city,
							"location_to_kecamatan"=>$QInvoice->location_to_kecamatan,
							"location_to_postal"=>$QInvoice->location_to_postal,
							"shop"=>$this->getShopById($QCart->toko_id,$QUser->id),
							"invoice_products"=>$InvoiceProducts,
							"courier"=>$Courier,
							"courier_custome"=>$CourierCustom,
						);
					
					/*
					*	------------------------------------------------------------------------------
					*	Hapus data Cart dan ambil data Toko
					*	------------------------------------------------------------------------------
					*/
					
					$this->db->where("id",$QCart->id)->delete("tb_cart");
				
					$this->response->send(array("result"=>1,"invoice"=>$Invoice), true);
				}else{
					$this->response->send(array("result"=>0,"message"=>"Tidak dapat menemukan invoice","messageCode"=>5), true);
				}
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak dapat membuat invoice","messageCode"=>5), true);
			}
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getShipmentRate(){
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
			
			if($this->response->post("courier") == "" || $this->response->postDecode("courier") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada kurir yang dipilih","messageCode"=>3), true);
				return;
			}
			
			$QCourier = $this->db->where("name",$this->response->postDecode("courier"))->get("ms_courier")->row();
			if(empty($QCourier)){
				$this->response->send(array("result"=>0,"message"=>"Kurir yang dipilih tidak ditemukan.","messageCode"=>4), true);
				return;
			}
			
			if($this->response->post("shop") == "" || $this->response->postDecode("shop") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada toko yang dipilih","messageCode"=>5), true);
				return;
			}
			
			$QShop = $this->db->where("id",$this->response->postDecode("shop"))->get("tb_toko")->row();
			if(empty($QShop)){
				$this->response->send(array("result"=>0,"message"=>"Toko yang dipilih tidak ditemukan","messageCode"=>6), true);
				return;
			}
			
			if(empty($QShop->location_id)){
				$this->response->send(array("result"=>0,"message"=>"Tidak dapat menemukan biaya pengiriman untuk toko ini","messageCode"=>7), true);
				return;
			}
			
			$ShopLocation = $this->db
						->where("id",$QShop->location_id)
						->get("ms_location")
						->row();
			
			if(empty($ShopLocation)){
				$this->response->send(array("result"=>0,"message"=>"Tidak dapat menemukan biaya pengiriman untuk toko ini","messageCode"=>8), true);
				return;
			}
			
			if($this->response->post("province") == "" || $this->response->postDecode("province") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada product yang dipilih","messageCode"=>9), true);
				return;
			}
			
			if($this->response->post("city") == "" || $this->response->postDecode("city") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada product yang dipilih","messageCode"=>10), true);
				return;
			}
			
			if($this->response->post("kecamatan") == "" || $this->response->postDecode("kecamatan") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada product yang dipilih","messageCode"=>11), true);
				return;
			}
			
			$QRate = $this->db
				->where("courier_id",$QCourier->id)
				->where("location_from_province",$ShopLocation->province)
				->where("location_from_city",$ShopLocation->city)
				->where("location_from_kecamatan",$ShopLocation->kecamatan)
				->where("location_to_province",$this->response->postDecode("province"))
				->where("location_to_city",$this->response->postDecode("city"))
				->where("location_to_kecamatan",$this->response->postDecode("kecamatan"))
				->get("tb_courier_rate")
				->row();
				
			if(!empty($QRate)){
				$this->response->send(array("result"=>1,"price"=>$QRate->price,"messageCode"=>12), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak dapat menemukan biaya pengiriman untuk toko ini","messageCode"=>13), true);
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
				$Shop = $this->getShopById($QMessage->toko_id,$QUser->id);
			
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
					
					$Shop = $this->getShopById($QUserMessage->toko_id,$QUser->id);
					
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
							->where("province",str_replace("+","",$this->response->postDecode("province")))
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
						->where("province",str_replace("+","",$this->response->postDecode("province")))
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
				$this->response->send(array("result"=>0,"message"=>"Kota tidak ditemukan : ".$this->response->postDecode("province"),"messageCode"=>5), true);
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
						->where("city",str_replace("+","",$this->response->postDecode("city")))
						->where("province",str_replace("+","",$this->response->postDecode("province")))
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
				$this->response->send(array("result"=>0,"message"=>"Kecamatan tidak ditemukan","messageCode"=>6), true);
			}
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doShopInviteApprove(){
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
						
			$Delete = $this->db
						->where("member_id",$QUser->id)
						->where("toko_id",$QShop->id)
						->delete("tb_invite");
			
			if($Delete){
				$Data1 = array(
							"toko_id"=>$QShop->id,
							"member_id"=>$QUser->id,
							"status"=>3,
							"create_date"=>date("Y-m-d H:i:s"),
							"create_user"=>$QUser->email,
							"update_date"=>date("Y-m-d H:i:s"),
							"update_user"=>$QUser->email,
						);
				
				$Data2 = array(
							"toko_id"=>$QShop->id,
							"member_id"=>$QUser->id,
							"price_level"=>1,
							"create_date"=>date("Y-m-d H:i:s"),
							"create_user"=>$QUser->email,
							"update_date"=>date("Y-m-d H:i:s"),
							"update_user"=>$QUser->email,
						);
						
				$Save1 = $this->db->insert("tb_join_in",$Data1);
				$Save2 = $this->db->insert("tb_toko_member",$Data2);
				
				$this->response->send(array("result"=>1,"message"=>"Anda telah menerima undangan dari \"".$QShop->name."\"","messageCode"=>4), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Undangan gagal ditolak","messageCode"=>4), true);
			}
			
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	} 
	
	public function doShopInviteReject(){
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
			
			$Delete = $this->db
						->where("member_id",$QUser->id)
						->where("toko_id",$QShop->id)
						->delete("tb_invite");
			
			if($Delete){
				$Data = array(
							"toko_id"=>$QShop->id,
							"member_id"=>$QUser->id,
							"status"=>4,
							"create_date"=>date("Y-m-d H:i:s"),
							"create_user"=>$QUser->email,
							"update_date"=>date("Y-m-d H:i:s"),
							"update_user"=>$QUser->email,
						);
				
				$Save = $this->db->insert("tb_join_in",$Data);
				$this->response->send(array("result"=>1,"message"=>"Anda telah menolak Undangan dari \"".$QShop->name."\"","messageCode"=>4), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Undangan gagal ditolak","messageCode"=>4), true);
			}
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	} 
}

