<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
* CONTROLLER API BONOBO
* This Api system for tranfers data using external apps, support for android, ios, windows mobile
*
* Log Activity : ~ Create your log if change this controller ~
. 1. Create 12 Juni 2015 by Heri Siswanto, Create controller
*/

//header('content-type: application/json; charset=utf-8');
//ob_start('ob_gzhandler');
set_time_limit (60000);

class Api extends CI_Controller {
	var $paging_limit = 10;
	var $paging_offset = 0;
	var $quality = 90;
	
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
		$blacklist = 0;
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
			$ShopBlacklist = $this->db->where("toko_id",$id)->where("member_id",$user)->get("tb_toko_blacklist")->row();
			
			if(!empty($ShopMember)){
				$join = 1;
				$price_level = $ShopMember->price_level >= 1 ? $ShopMember->price_level : 1;
			}else{
				$JoinIn = $this->db->where("toko_id",$id)->where("member_id",$user)->where("status",0)->get("tb_join_in")->row();
				if(!empty($JoinIn)){
					$join = 2;
				}
			}
			
			if(!empty($ShopInvite)){
				$invite = 1;
			}
			
			if(!empty($ShopBlacklist)){
				$blacklist = 1;
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
			$ShopBank = array(
				"id"=>$QShopBank->id,
				"acc_name"=>$QShopBank->acc_name,
				"acc_no"=>$QShopBank->acc_no,
				"bank_name"=>$QShopBank->bank_name,
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
						->where(" ((tp.stock_type = 0 AND tp.end_date >= '".date("Y-m-d H:i:s")."') OR tp.stock_type = 1) ",null,false)
						->where("ttcp.toko_id",$QShop->id)
						->where("tp.active",1)
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
			"invoice_confirm"=>$QShop->invoice_confirm,
			"dm_pick_up_store"=>$QShop->dm_pick_up_store,
			"dm_expedition"=>$QShop->dm_expedition,
			"dm_store_delivery"=>$QShop->dm_store_delivery,
			"private"=>$QShop->privacy,
			"level_1_name"=>$QShop->level_1_name,
			"level_2_name"=>$QShop->level_2_name,
			"level_3_name"=>$QShop->level_3_name,
			"level_4_name"=>$QShop->level_4_name,
			"level_5_name"=>$QShop->level_5_name,
			"level_1_active"=>$QShop->level_1_active,
			"level_2_active"=>$QShop->level_2_active,
			"level_3_active"=>$QShop->level_3_active,
			"level_4_active"=>$QShop->level_4_active,
			"level_5_active"=>$QShop->level_5_active,
			"image_tumb"=>$ShopImageTumb,
			"image_high"=>$ShopImageHigh,
			"count_products"=>$CountProducts,
			"count_users"=>$CountMembers,
			"join"=>$join,
			"invite"=>$invite,
			"blacklist"=>$blacklist,
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
			if(@getimagesize(base_url("assets/pic/product/".$QProductImage->file))){
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
				"end_date"=>$QProduct->end_date,
				"favorite"=>$isFavorite,
				"shop_category"=>$ShopCategory,
				"images"=>$ProductImages,
				"varians"=>$ProductVarians,
				"shop"=>$ProductShop,
			);
				
		return $Product;
	}
	
	private function getCartById($cart_id,$user_id){
		$QCart = $this->db->where("id",$cart_id)->get("tb_cart")->row();
		
		if(!empty($QCart)){
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
									"product"=>$this->getProductById($QProductVarian->product_id,$user_id),
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
							"product"=>$this->getProductById($QCartProduct->product_id,$user_id),
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
					"stock_type"=>$QCart->stock_type,
					"shop"=>$this->getShopById($QCart->toko_id,$user_id),
					"cart_products"=>$CartProducts,
				);
			return $Cart;
		}else{
			return null;
		}
	}
	
	
	
	private function getInvoiceById($invoice_id,$user_id){
		$QInvoice = $this->db
					->where("id",$invoice_id)
					->get("tb_invoice")
					->row();
	
		if(!empty($QInvoice)){
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
					$product = $this->getProductById($QInvoiceProduct->product_id,$user_id);
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
								"product"=>$this->getProductById($QVarian->product_id,$user_id),
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
					"shop"=>$this->getShopById($QInvoice->toko_id,$user_id),
					"courier"=>$Courier,
					"courier_custom"=>$CourierCustom,
					"courier_type"=>$QInvoice->courier_type,
					"invoice_products"=>$InvoiceProducts,
				);
			return $Invoice;
		}else{
			return null;
		}
	}
	
	
	
	/*
	*	------------------------------------------------------------------------------
	*	PUBLIC FUNCTION
	*	------------------------------------------------------------------------------
	*/
	
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
				$Bank = array(
						"id"=>$QBank->id,
						"name"=>$QBank->name,
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
					/*
					*	Check undangan dari toko untuk bergabung
					*/
					$QInvites = $this->db->where("email",$QUser->email)->get("tb_invite")->result();
					foreach($QInvites as $QInvite){
						$Data = array("member_id"=>$QUser->id);
						$Save=$this->db->where("id",$QInvite->id)->update("tb_invite",$Data);
					}
					
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
					->select("tmb.id, tmb.bank_name, tmb.acc_name as acc_name, tmb.acc_no as acc_no")
					->where("tmb.member_id",$QUser->id)
					->get("tb_member_bank tmb")
					->result();
			
			$Banks = array();
			foreach($QBanks as $QBank){
				$Bank = array(
						"id"=>$QBank->id,
						"bank_name"=>$QBank->bank_name,
						"acc_name"=>$QBank->acc_name,
						"acc_no"=>$QBank->acc_no,
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
					->order_by("tf.product_id","DESC")
					->group_by("tf.product_id")
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
			*	create object user data to response
			*	------------------------------------------------------------------------------
			*/
			$Object = array(
					"result"=>1,
					"contacts"=>$Attributes, 
					"banks"=>$Banks, 
					"locations"=>$Locations,
					"favorites"=>$Favorites,
					"shop_invites"=>$ShopInvites,
				);
			
			$this->response->send($Object, true);
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getUserCart(){
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
			
			if($this->response->post("cart") == "" || $this->response->postDecode("cart") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada cart yang dipilih","messageCode"=>3), true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	create object user data to response
			*	------------------------------------------------------------------------------
			*/
			
			$QCart = $this->db->where("id",$this->response->postDecode("cart"))->get("tb_cart")->row();
			
			if(!empty($QCart)){
				$Cart = $this->getCartById($QCart->id,$QUser->id);
				$this->response->send(array("result"=>1,"cart"=>$Cart), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak ada cart yang ditemukan","messageCode"=>4), true);
			}
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getUserInvoice(){
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
			
			if($this->response->post("invoice") == "" || $this->response->postDecode("invoice") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada nota yang dipilih","messageCode"=>3), true);
				return;
			}
			
			$QInvoice = $this->db->where("id",$this->response->postDecode("invoice"))->get("tb_invoice")->row();
			
			if(!empty($QInvoice)){
				$Invoice = $this->getInvoiceById($QInvoice->id,$QUser->id);
				$this->response->send(array("result"=>1,"invoice"=>$Invoice), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak ada nota yang ditemukan","messageCode"=>4), true);
			}
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getUserCarts(){
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
			*	Menghapus data cart yang status pre order
			*	------------------------------------------------------------------------------
			*/
			
			$Deletes = $this->db
				->where("member_id",$QUser->id)
				->where("stock_type",0)
				->delete("tb_cart");
		
	
			/*
			*	------------------------------------------------------------------------------
			*	Mengambil query data carts
			*	------------------------------------------------------------------------------
			*/
			$QCarts = $this->db;
			$QCarts = $QCarts->where("tc.member_id",$QUser->id);
			$QCarts = $QCarts->where("tc.stock_type",1);
			
			if($this->response->post("lastId") != "" && (float) $this->response->postDecode("lastId") > 0){
				$QCarts = $QCarts->where("tc.id < ",$this->response->postDecode("lastId"));
			}
			
			$QCarts = $QCarts->limit(5,$this->paging_offset);
			$QCarts = $QCarts->order_by("id","DESC");
			$QCarts = $QCarts->get("tb_cart tc");
			$QCarts = $QCarts->result();
			
			$Carts = array();
			foreach($QCarts as $QCart){
				/*
				*	------------------------------------------------------------------------------
				*	Membuat object Cart
				*	------------------------------------------------------------------------------
				*/
				$Cart = array(
						"id"=>$QCart->id,
						"price_total"=>$QCart->price_total,
						"stock_type"=>$QCart->stock_type,
						"shop"=>$this->getShopById($QCart->toko_id,$QUser->id),
					);
				
				array_push($Carts,$Cart);
			}
			
			if(sizeOf($QCarts) > 0){
				$this->response->send(array("result"=>1,"carts"=>$Carts), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak ada cart","messageCode"=>4), true);
			}
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getUserInvoices(){
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
			*	Membuat object invoice
			*	------------------------------------------------------------------------------
			*/
			$QInvoices = $this->db;
			$QInvoices = $QInvoices->where("member_id",$QUser->id);

			if($this->response->post("status") != "" && $this->response->postDecode("status") != ""){
				$QInvoices = $QInvoices->where("status",$this->response->postDecode("status"));
			}		
			
			if($this->response->post("lastId") != "" && $this->response->postDecode("lastId") != "" && intval($this->response->postDecode("lastId")) > 0){
				$QInvoices = $QInvoices->where("id < ",$this->response->postDecode("lastId"));
			}
			
			$QInvoices = $QInvoices->limit(5,$this->paging_offset);
			$QInvoices = $QInvoices->order_by("id","DESC");
			$QInvoices = $QInvoices->get("tb_invoice");
			$QInvoices = $QInvoices->result();

			$Invoices = array();
			foreach($QInvoices as $QInvoice){
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
						"shop"=>$this->getShopById($QInvoice->toko_id,$QUser->id),
					);
				
				array_push($Invoices,$Invoice);
			}
			
			if(sizeOf($QInvoices) > 0){
				$this->response->send(array("result"=>1,"invoices"=>$Invoices), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak ada nota","messageCode"=>4), true);
			}
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getUserProducts(){
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
			*	get data member product
			*	------------------------------------------------------------------------------
			*/
			$Products = array();
			$QProducts = $this->db
					->select("tp.id")
					->join("tb_toko_category_product ttcp","ttcp.id = tp.toko_category_product_id")
					->where("tp.active",1)
					->where("ttcp.toko_id IN (SELECT ttm.toko_id FROM tb_toko_member ttm WHERE ttm.member_id = ".$QUser->id." group by ttm.toko_id)")
					->limit($this->paging_limit,$this->paging_offset)
					->order_by("tp.id","DESC")
					->group_by("tp.id")
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
			*	create object user data to response
			*	------------------------------------------------------------------------------
			*/
			$Object = array(
					"result"=>1,
					"products"=>$Products,
				);
			
			$this->response->send($Object, true);
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getUserMessages(){
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
			*	Mengambil data member message
			*	------------------------------------------------------------------------------
			*/
			$Messages = array();
			$QMessages = $this->db
							->select("tmm.id,tmm.toko_name,tmm.toko_id,tm.message as message,tm.title,tm.image,tmm.flag_read as isread,tmm.flag_from as isfrom")
							->join("tb_message tm","tm.id = tmm.message_id")
							->where("tmm.member_id",$QUser->id)
							->group_by("tmm.toko_id")
							->get("tb_member_message tmm")
							->result();
			
			foreach($QMessages as $QMessage){
				if($QMessage->image != ""){
					if(@getimagesize(base_url("assets/pic/product/".$QMessage->image))){
						$ImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/product/resize/".$QMessage->image)));
						$ImageHigh = base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/product/".$QMessage->image)));
					}else{
						$ImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
						$ImageHigh = $ImageTumb;
					}
				}else{
					$ImageTumb = "";
					$ImageHigh = "";
				}
				
				$Message = array(
						"id"=>$QMessage->id,
						"shop_name"=>$QMessage->toko_name,
						"message"=>$QMessage->message,
						"title"=>$QMessage->title,
						"image_tumb"=>$ImageTumb,
						"image_high"=>$ImageHigh,
						"isread"=>$QMessage->isread,
						"isfrom"=>$QMessage->isfrom,
						"shop"=>$this->getShopById($QMessage->toko_id,$QUser->id),
					);
				
				array_push($Messages,$Message);
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	create object user data to response
			*	------------------------------------------------------------------------------
			*/
			$Object = array(
					"result"=>1,
					"messages"=>$Messages,
				);
			
			$this->response->send($Object, true);
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function getUserMessagesDetail(){
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
			
			if($this->response->post("shop") == "" || $this->response->postDecode("shop") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada toko yang dipilih","messageCode"=>2), true);
				return;
			}
			
			$QShop = $this->db->where("id",$this->response->postDecode("shop"))->get("tb_toko")->row();
			if(empty($QShop)){
				$this->response->send(array("result"=>0,"message"=>"Toko tidak valid","messageCode"=>3), true);
				return;
			}
			/*
			*	------------------------------------------------------------------------------
			*	Mengambil data member message
			*	------------------------------------------------------------------------------
			*/
			$Messages = array();
			$QMessages = $this->db
							->select("tmm.id,tmm.toko_name,tmm.toko_id,tm.message as message,tm.title,tm.image,tmm.flag_read as isread,tmm.flag_from as isfrom")
							->join("tb_message tm","tm.id = tmm.message_id")
							->where("tmm.member_id",$QUser->id)
							->where("tmm.toko_id",$QShop->id)
							->order_by("tmm.id","DESC")
							->group_by("tmm.toko_id")
							->get("tb_member_message tmm")
							->result();
			
			foreach($QMessages as $QMessage){
				if($QMessage->image != ""){
					if(@getimagesize(base_url("assets/pic/product/".$QMessage->image))){
						$ImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/product/resize/".$QMessage->image)));
						$ImageHigh = base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/product/".$QMessage->image)));
					}else{
						$ImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
						$ImageHigh = $ImageTumb;
					}
				}else{
					$ImageTumb = "";
					$ImageHigh = "";
				}
				
				$Message = array(
							"id"=>$QMessage->id,
							"shop_name"=>$QMessage->toko_name,
							"message"=>$QMessage->message,
							"title"=>$QMessage->title,
							"image_tumb"=>$ImageTumb,
							"image_high"=>$ImageHigh,
							"isread"=>$QMessage->isread,
							"isfrom"=>$QMessage->isfrom,
						);
				array_push($Messages,$Message);
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	create object user data to response
			*	------------------------------------------------------------------------------
			*/
			$Object = array(
					"result"=>1,
					"messages"=>$Messages,
				);
			
			$this->response->send($Object, true);
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	
	public function service(){
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
			*	Mengambil data message
			*	------------------------------------------------------------------------------
			*/
			$Messages = array();
			$QMessages = $this->db
							->select("tmm.id,tmm.toko_name,tmm.toko_id,tm.message as message,tmm.flag_read as isread,tmm.flag_from as isfrom")
							->join("tb_message tm","tm.id = tmm.message_id")
							->where("tmm.member_id",$QUser->id)
							->where("tmm.flag_read",0)
							->where("tmm.flag_api",0)
							->limit(1,0)
							->get("tb_member_message tmm")
							->result();
			
			foreach($QMessages as $QMessage){
				$Message = array(
						"id"=>$QMessage->id,
						"shop_name"=>$QMessage->toko_name,
						"message"=>$QMessage->message,
						"isread"=>$QMessage->isread,
						"isfrom"=>$QMessage->isfrom,
						"shop"=>$this->getShopById($QMessage->toko_id,$QUser->id),
					);
				
				$Data = array("flag_api"=>1);
				$Save = $this->db->where("id",$QMessage->id)->update("tb_member_message",$Data);
				
				array_push($Messages,$Message);
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Mengambil data toko invited
			*	------------------------------------------------------------------------------
			*/
			$Invites = array();
			$QInvites = $this->db
						->where("member_id",$QUser->id)
						->where("flag_api",0)
						->limit(1,$this->paging_offset)
						->get("tb_invite")
						->result();
						
			foreach($QInvites as $QInvite){
				$Invite = array(
						"id"=>$QInvite->id,
						"email"=>$QInvite->email,
						"message"=>$QInvite->message,
						"shop"=>$this->getShopById($QInvite->toko_id,$QUser->id),
					);
					
				$Data = array("flag_api"=>1);
				$Save = $this->db->where("id",$QInvite->id)->update("tb_invite",$Data);
				
				array_push($Invites,$Invite);
			}
			
			$this->response->send(array("result"=>1,"messages"=>$Messages,"invites"=>$QInvites), true);
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
			$QProduct = $QProduct->select("tp.id, tp.stock_type, tp.end_date");
			$QProduct = $QProduct->join("tb_toko_category_product tkcp","tkcp.id = tp.toko_category_product_id");
			$QProduct = $QProduct->where("tp.active",1);
			$QProduct = $QProduct->where(" ((tp.stock_type = 0 AND tp.end_date >= '".date("Y-m-d H:i:s")."') OR tp.stock_type = 1) ",null,false);
			$QProduct = $QProduct->where("tkcp.toko_id in (SELECT ttm.toko_id FROM tb_toko_member ttm WHERE ttm.member_id = ".$QUser->id.")",null,false);
			
			if($this->response->post("keyword") != "" && $this->response->postDecode("keyword") != ""){
				$QProduct = $QProduct->where("tp.name LIKE ","%".$this->response->postDecode("keyword")."%");
			}
			
			if($this->response->post("stock_type") != "" && $this->response->postDecode("stock_type") != ""){
				$QProduct = $QProduct->where("tp.stock_type",$this->response->postDecode("stock_type"));
			}
			
			if($this->response->post("lastId") != "" && $this->response->postDecode("lastId") != "" && $this->response->postDecode("lastId") > "0"){
				$QProduct = $QProduct->where("tp.id < ",$this->response->postDecode("lastId"));
			}
			
			$QProduct = $QProduct->limit($this->paging_limit,$this->paging_offset);
			$QProduct = $QProduct->order_by("tp.id","Desc");
			$QProduct = $QProduct->get("tb_product tp");
			$QProducts = $QProduct->result();
			
			if(sizeOf($QProducts) > 0){
				$message= "";
				$Products = array();
				foreach($QProducts as $QProduct){
						$Product = $this->getProductById($QProduct->id,$QUser->id);
						array_push($Products,$Product);
				}
				$this->response->send(array("result"=>1,"message"=>$message,"products"=>$Products), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak ada produk yang ditemukan","messageCode"=>4), true);
			}
		
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		} 
	}
	
	public function getFavorites(){
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
			$QProduct = $QProduct->select("tp.id, tp.stock_type, tp.end_date");
			$QProduct = $QProduct->join("tb_toko_category_product tkcp","tkcp.id = tp.toko_category_product_id");
			$QProduct = $QProduct->where("tp.active",1);
			$QProduct = $QProduct->where(" ((tp.stock_type = 0 AND tp.end_date >= '".date("Y-m-d H:i:s")."') OR tp.stock_type = 1) ",null,false);
			$QProduct = $QProduct->where("tkcp.toko_id in (SELECT ttm.toko_id FROM tb_toko_member ttm WHERE ttm.member_id = ".$QUser->id.")",null,false);
			$QProduct = $QProduct->where("tp.id in (SELECT tf.product_id FROM tb_favorite tf WHERE tf.member_id = ".$QUser->id.")",null,false);
			
			if($this->response->post("keyword") != "" && $this->response->postDecode("keyword") != ""){
				$QProduct = $QProduct->where("tp.name LIKE ","%".$this->response->postDecode("keyword")."%");
			}
			
			if($this->response->post("stock_type") != "" && $this->response->postDecode("stock_type") != ""){
				$QProduct = $QProduct->where("tp.stock_type",$this->response->postDecode("stock_type"));
			}
			
			if($this->response->post("lastId") != "" && $this->response->postDecode("lastId") != "" && intval($this->response->postDecode("lastId")) > 0){
				$QProduct = $QProduct->where("tp.id < ",intval($this->response->postDecode("lastId")));
			}
			
			$QProduct = $QProduct->limit($this->paging_limit,$this->paging_offset);
			$QProduct = $QProduct->order_by("tp.id","Desc");
			$QProduct = $QProduct->get("tb_product tp");
			$QProducts = $QProduct->result();
			
			if(sizeOf($QProducts) > 0){
				$Products = array();
				foreach($QProducts as $QProduct){
					$Product = $this->getProductById($QProduct->id,$QUser->id);
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
						->select("ttb.id,ttb.acc_name,ttb.acc_no,ttb.bank_name as bank_name")
						->where("ttb.toko_id",$QShop->id)
						->get("tb_toko_bank ttb")
						->result();
						
			$ShopBanks = array();
			foreach($QShopBanks as $QShopBank){
				$ShopBank = array(
						"id"=>$QShopBank->id,
						"acc_name"=>$QShopBank->acc_name,
						"acc_no"=>$QShopBank->acc_no,
						"bank_name"=>$QShopBank->bank_name,
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
			$QProduct = $QProduct->select("tp.id, tp.stock_type, tp.end_date");
			$QProduct = $QProduct->join("tb_toko_category_product tkcp","tkcp.id = tp.toko_category_product_id");
			$QProduct = $QProduct->where("tkcp.toko_id", $QShop->id);
			$QProduct = $QProduct->where("tp.active", 1);
			$QProduct = $QProduct->where(" ((tp.stock_type = 0 AND tp.end_date >= '".date("Y-m-d H:i:s")."') OR tp.stock_type = 1) ",null,false);
			
			if($this->response->post("keyword") != "" && $this->response->postDecode("keyword") != ""){
				$QProduct = $QProduct->where("tp.name LIKE ","%".$this->response->postDecode("keyword")."%");
			}
			
			if($this->response->post("lastId") != "" && $this->response->postDecode("lastId") != "" && intval($this->response->postDecode("lastId")) > 0){
				$QProduct = $QProduct->where("tp.id < ",$this->response->postDecode("lastId"));
			}
			
			$QProduct = $QProduct->limit($this->paging_limit,$this->paging_offset);
			$QProduct = $QProduct->order_by("tp.id","Desc");
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
						"price_level"=>1,
						"create_date"=>date("Y-m-d H:i:s"),
						"create_user"=>$QUser->email,
						"update_date"=>date("Y-m-d H:i:s"),
						"update_user"=>$QUser->email,
					);
						
					$Save = $this->db->insert("tb_toko_member",$FollowData);
					
					if($Save){
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
					
						$this->response->send(array("result"=>1,"message"=>"Anda telah tergabung dengan toko ini","messageCode"=>5), true);
					}else{
						$this->response->send(array("result"=>0,"message"=>"Anda tidak dapat bergabung dengan toko ini","messageCode"=>6), true);
					}
				}else{
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
				}
			}else{
				$QFavorites = $this->db
						->select("tf.id")
						->join("tb_product tp","tp.id = tf.product_id")
						->join("tb_toko_category_product ttcp","ttcp.id = tp.toko_category_product_id")
						->where("ttcp.toko_id",$QShop->id)
						->where("tf.member_id",$QUser->id)
						->get("tb_favorite tf")
						->result();
				
				foreach($QFavorites as $QFavorite){
					$Delete = $this->db->where("id",$QFavorite->id)->delete("tb_favorite");
				}
				
				$Delete = $this->db->where("toko_id",$QShop->id)->where("member_id",$QUser->id)->delete("tb_join_in");
				$Delete = $this->db->where("toko_id",$QShop->id)->where("member_id",$QUser->id)->delete("tb_cart");		
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
				$QProduct = $QProduct->limit($this->paging_limit,$this->response->postDecode("page"));
			}else{
				$QProduct = $QProduct->limit($this->paging_limit,$this->paging_offset);
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
			
			if($this->response->post("bank_name") == "" || $this->response->postDecode("bank_name") == ""){
				$this->response->send(array("result"=>0,"message"=>"Nama bank belum dipilih","messageCode"=>3), true);
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
						"member_id"=>$QUser->id,
						"bank_name"=>$this->response->postDecode("bank_name"),
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
						"member_id"=>$QUser->id,
						"bank_name"=>$this->response->postDecode("bank_name"),
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
								->where("member_id",$QUser->id)
								->where("bank_name",$this->response->postDecode("bank_name"))
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
					$UserBank = array(
							"id"=>$QUserBank->id,
							"bank_name"=>$QUserBank->bank_name,
							"acc_name"=>$QUserBank->acc_name,
							"acc_no"=>$QUserBank->acc_no,
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
	
	public function doUserImageUpload(){
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
			
			$file = "file";
			$url = "assets/pic/user/";
			$width = 325;
			$height = 325;
			
			$ci = & get_instance();
			$ci->load->library('upload');
			$ci->load->library('image_lib');
			
			$config['upload_path'] 		= $url; 
			$config['allowed_types'] 	= "gif|jpg|png|jpeg|bmp";
			$config['max_size'] 		= 1000;
			$config['encrypt_name'] 	= TRUE;
			
			$ci->upload->initialize($config);
			
			if($ci->upload->do_upload($file)){
				$data=$ci->upload->data();
				$ci->image_lib->clear();
				
				$image['image_library'] = "GD2";
				$image['source_image'] 	= $data['full_path'];
				$image['new_image'] 	= $url.'resize/'.$data['file_name'];
				$size 					= getimagesize($_FILES[$file]["tmp_name"]);
				$image['maintain_ratio']= TRUE;
				$image['master_dim'] 	= 'auto';
				$image['width'] 		= $width;
				$image['height'] 		= $height;
				
				$ci->image_lib->initialize($image);
				$ci->image_lib->resize();
				
				if(!empty($data['file_name'])){
					$Data = array(
							"image"=>$data['file_name'],
						);
						
					$Save = $this->db->where("id",$QUser->id)->update("tb_member",$Data);
					
					if($Save){
						$this->response->send(array("result"=>1,"message"=>"Gambar telah diubah","messageCode"=>3), true);
					}else{
						$this->response->send(array("result"=>0,"message"=>"Gambar tidak dapat diupload","messageCode"=>4), true);
					}
				}else{
					$this->response->send(array("result"=>0,"message"=>"Gambar tidak dapat diupload","messageCode"=>5), true);
				}
			}else{
				$this->response->send(array("result"=>0,"message"=>"Gambar tidak dapat diupload","messageCode"=>6), true);
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
			
			if($this->response->post("price") == "" || $this->response->postDecode("price") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada jumlah yang ditransfer","messageCode"=>3), true);
				return;
			}
			
			if($this->response->post("from_bank") == "" || $this->response->postDecode("from_bank") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data bank tujuan pengiriman","messageCode"=>3), true);
				return;
			}
			
			if($this->response->post("from_acc_name") == "" || $this->response->postDecode("from_acc_name") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data nama akun tujuan pengiriman","messageCode"=>3), true);
				return;
			}
			
			if($this->response->post("from_acc_no") == "" || $this->response->postDecode("from_acc_no") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data nomor rekening tujuan pengiriman","messageCode"=>3), true);
				return;
			}
			
			if($this->response->post("to_bank") == "" || $this->response->postDecode("to_bank") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data bank asal pengirim","messageCode"=>3), true);
				return;
			}
			
			if($this->response->post("to_acc_name") == "" || $this->response->postDecode("to_acc_name") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data nama akun asal pengirim","messageCode"=>3), true);
				return;
			}
			
			if($this->response->post("to_acc_no") == "" || $this->response->postDecode("to_acc_no") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada data nomor rekening asal pengirim","messageCode"=>3), true);
				return;
			}
			
			$date = date("Y-m-d H:i:s");
			
			$Data = array(
					"invoice_id"=>$QInvoice->id,
					"price"=>$this->response->postDecode("price"),
					"from_bank"=>$this->response->postDecode("from_bank"),
					"from_acc_name"=>$this->response->postDecode("from_acc_name"),
					"from_acc_no"=>$this->response->postDecode("from_acc_no"),
					"to_bank"=>$this->response->postDecode("to_bank"),
					"to_acc_name"=>$this->response->postDecode("to_acc_name"),
					"to_acc_no"=>$this->response->postDecode("to_acc_no"),
					"create_date"=>$date,
					"create_user"=>$QUser->email,
					"update_date"=>$date,
					"update_user"=>$QUser->email,
				);
				
			$Save = $this->db->insert("tb_invoice_transfer_confirm",$Data);
			
			if($Save){
				$Data = array(
					"member_confirm"=>1,
				);
			
				$Save = $this->db->where("id",$QInvoice->id)->update("tb_invoice",$Data);
			
				$this->response->send(array("result"=>1,"message"=>"Konfirmasi pembayaran telah dikirimkan","messageCode"=>5), true);
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
	
	public function alphabet(){
		if(empty($_SESSION["alphabet"])){
			$_SESSION["alphabet"] = "A";
		}else{
			$_SESSION["alphabet"]++;
		}
		
		echo $_SESSION["alphabet"]; 
	}
	
	private function isCardAddValid(){
		/*
		*	------------------------------------------------------------------------------
		*	Validation POST data
		*	------------------------------------------------------------------------------
		*/
		if(!$this->isValidApi($this->response->postDecode("api_key"))){
			return false;
		}
		
		if($this->response->post("user") == "" || $this->response->postDecode("user") == ""){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>1), true);
			return false;
		}
		
		$QUser = $this->db->where("id",$this->response->postDecode("user"))->get("tb_member")->row();
		if(empty($QUser)){
			$this->response->send(array("result"=>0,"message"=>"Anda belum login, silahkan login dahulu","messageCode"=>2), true);
			return false;
		}
		
		if($this->response->post("product") == "" || $this->response->postDecode("product") == ""){
			$this->response->send(array("result"=>0,"message"=>"Belum ada product yang di kirim","messageCode"=>3), true);
			return false;
		}
		
		$QProduct = $this->db
					->select("tp.*, tt.id as shop_id, tt.name as shop_name")
					->join("tb_toko_category_product ttcp","ttcp.id = tp.toko_category_product_id")
					->join("tb_toko tt","tt.id = ttcp.toko_id")
					->where("tp.id",$this->response->postDecode("product"))
					->get("tb_product tp")
					->row();
					
		if(empty($QProduct)){
			$this->response->send(array("result"=>0,"message"=>"Barang sudah tidak tersedia","messageCode"=>4), true);
			return false;
		}
		
		if($this->response->post("varians") == "" || $this->response->postDecode("varians") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data varians yang dikirim","messageCode"=>5), true);
			return false;
		}
		
		if($this->response->post("stock_type") == "" || $this->response->postDecode("stock_type") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data tipe stok","messageCode"=>6), true);
			return false;
		}
		
		if($this->response->post("price") == "" || $this->response->postDecode("price") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data harga barang","messageCode"=>7), true);
			return false;
		}
		
		if($this->response->post("min_order") == "" || $this->response->postDecode("min_order") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data minimal order","messageCode"=>8), true);
			return false;
		}
		
		if($QProduct->active == 0){
			$this->response->send(array("result"=>0,"message"=>"Barang tidak tersedia","messageCode"=>9), true);
			return false;
		}
		
		if($QProduct->stock_type != $this->response->postDecode("stock_type")){
			$this->response->send(array("result"=>0,"message"=>"Barang tidak tersedia","messageCode"=>10), true);
			return false;
		}
		
		if($QProduct->stock_type == 0){
			$long = $this->hs_datetime->countDate(date("Y-m-d H:i:s"),$QProduct->end_date);
			if($long <= 0){
				$this->response->send(array("result"=>0,"message"=>"Barang tidak tersedia","messageCode"=>11), true);
				return false;
			}
		}
		
		
		/*
		*	------------------------------------------------------------------------------
		*	Check perubahan harga produk
		*   Jika harga produk pada server tidak sesuai dengan di APK pada saat user 
		*   melakukan pembelian maka sampaikan pemberitahuan
		*	------------------------------------------------------------------------------
		*/
		
		$product_price = $QProduct->price_1;
					
		$QShopMember = $this->db
			->where("toko_id",$QProduct->shop_id)
			->where("member_id",$QUser->id)
			->get("tb_toko_member")
			->row();
						
		if(empty($QShopMember)){
			$this->response->send(array("result"=>0,"message"=>"Anda sudah tidak tergabung dengan toko \"".$QProduct->shop_name."\"","messageCode"=>12), true);
			return false;
		}
		
		$QShop = $this->db
				->where("id",$QProduct->shop_id)
				->get("tb_toko")
				->row();
		
		if(empty($QShop)){
			$this->response->send(array("result"=>0,"message"=>"Produk dari toko \"".$QProduct->shop_name."\" sudah tidak valid","messageCode"=>13), true);
			return false;
		}
		
		switch($QShopMember->price_level){
			case "1":
				if($QProduct->price_1 > 0 && $QShop->level_1_active == 1){
					$product_price = $QProduct->price_1;
				}
			break;
			
			case "2":
				if($QProduct->price_2 > 0 && $QShop->level_2_active == 1){
					$product_price = $QProduct->price_2;
				}
			break;
			
			case "3":
				if($QProduct->price_3 > 0 && $QShop->level_3_active == 1){
					$product_price = $QProduct->price_3;
				}
			break;
			
			case "4":
				if($QProduct->price_4 > 0 && $QShop->level_4_active == 1){
					$product_price = $QProduct->price_4;
				}
			break;
			
			case "5":
				if($QProduct->price_5 > 0 && $QShop->level_5_active == 1){
					$product_price = $QProduct->price_5;
				}
			break;
		}
		
		
		if($product_price != (float) $this->response->postDecode("price")){
			$this->response->send(array("result"=>0,"message"=>"Harga sudah berubah","messageCode"=>14), true);
			return false;
		}
		
		if($QProduct->min_order != (float) $this->response->postDecode("min_order")){
			$this->response->send(array("result"=>0,"message"=>"Data produk sudah berubah","messageCode"=>15), true);
			return false;
		}
		
		
		/*
		*	------------------------------------------------------------------------------
		*	Check data varian
		*	------------------------------------------------------------------------------
		*/
		$buy_qty = 0;
		$isVarianValid = true;
		for($i=1;$i<=$this->response->postDecode("varians");$i++){
			if($this->response->post("varian".$i) != "" && $this->response->postDecode("varian".$i) != "" && $this->response->post("varian".$i."_qty") != "" && $this->response->postDecode("varian".$i."_qty") != "" && $this->response->postDecode("varian".$i."_qty") != "0"){
				$QVarian = $this->db->where("id",$this->response->postDecode("varian".$i))->get("tb_product_varian")->row();
				
				if(empty($QVarian)){
					$this->response->send(array("result"=>0,"message"=>"Barang tidak tersedia","messageCode"=>16), true);
					$isVarianValid = false;
					continue;
				}else{
					/*
					*	------------------------------------------------------------------------------
					*	Check data stock vs quantity buy
					*   Lakukan pengecheckan jika stock type produk = 1 (ready stock) 
					*   dan jika stock_type_detail produk = 0 (gunakan stock)
					*	------------------------------------------------------------------------------
					*/
					if($QProduct->stock_type == 1 && $QProduct->stock_type_detail == 0){
						if($QVarian->stock_qty < (float) $this->response->postDecode("varian".$i."_qty")){
							$this->response->send(array("result"=>0,"message"=>"Stok barang tidak tersedia","messageCode"=>17), true);
							$isVarianValid = false;
							continue;
						}
					}
					
					$buy_qty = $buy_qty + (float) $this->response->postDecode("varian".$i."_qty");
				}
			}
		}
		
		if(!$isVarianValid){
			return false;
		}
		
		if($QProduct->min_order > $buy_qty){
			$this->response->send(array("result"=>0,"message"=>"Jumlah pembelian kurang dari minimal order","messageCode"=>18), true);
			return false;
		}
		
		return true;
	}
	
	public function doCartAdd(){
		try {
			if(!$this->isCardAddValid()){
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Mengambil data user dan product dari database
			*	------------------------------------------------------------------------------
			*/
			$QUser = $this->db->where("id",$this->response->postDecode("user"))->get("tb_member")->row();
			
			$QProduct = $this->db
						->select("tp.*, tt.id as shop_id")
						->join("tb_toko_category_product ttcp","ttcp.id = tp.toko_category_product_id")
						->join("tb_toko tt","tt.id = ttcp.toko_id")
						->where("tp.id",$this->response->postDecode("product"))
						->get("tb_product tp")
						->row();
			
			/*
			*	------------------------------------------------------------------------------
			*	Menyimpan data cart
			*	------------------------------------------------------------------------------
			*/
			$QCart = $this->db
						->where("member_id",$QUser->id)
						->where("toko_id",$QProduct->shop_id)
						->where("stock_type",$this->response->postDecode("stock_type"))
						->get("tb_cart")
						->row();
			
			if(empty($QCart)){
				$date = date("Y-m-d H:i:s");
			
				$Data = array(
					"member_id"=>$QUser->id,
					"toko_id"=>$QProduct->shop_id,
					"price_total"=>$this->response->postDecode("price_total"),
					"stock_type"=>$this->response->postDecode("stock_type"),
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
							->where("stock_type",$this->response->postDecode("stock_type"))
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
							$QCartVarian = $this->db
										->where("cart_product_id",$QCartProduct->id)
										->where("product_varian_id",$QVarian->id)
										->get("tb_cart_varian")
										->row();
							
							if(empty($QCartVarian)){
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
							}else{
								$Data = array(
										"quantity"=>$this->response->postDecode("varian".$i."_qty"),
										"update_date"=>$date,
										"update_user"=>$QUser->email,
									);
								
								$Save = $this->db->where("id",$QCartVarian->id)->update("tb_cart_varian",$Data);
							}
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
						"stock_type"=>$QCart->stock_type,
						"shop"=>$this->getShopById($QCart->toko_id,$QUser->id),
						"cart_products"=>$CartProducts,
					);
				
				$this->response->send(array("result"=>1,"cart"=>$Cart), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Data tidak dapat disimpan","messageCode"=>16), true);
			}
		} catch (Exception $e) {
			$this->response->send(array("result"=>0,"message"=>"Server Error : ".$e,"messageCode"=>9999), true);
		}
	}
	
	public function doCartSaveValidation(){
		try{
			$isCartValid = true;
			$MessageProducts = array();
			
			/*
			*	------------------------------------------------------------------------------
			*	Validation POST data
			*	------------------------------------------------------------------------------
			*/
			if(!$this->isValidApi($this->response->postDecode("api_key"))){
				return;
			}
			
			if($this->response->post("user") == "" || $this->response->postDecode("user") == ""){
				$this->response->send(array("message"=>"Anda belum login, silahkan login dahulu [1]","messageCode"=>1),true);
				return;
			}
			
			$QUser = $this->db
				->where("id",$this->response->postDecode("user"))
				->get("tb_member")
				->row();
						
			if(empty($QUser)){
				$this->response->send(array("message"=>"Anda belum login, silahkan login dahulu [2]","messageCode"=>2), true);
				return;
			}
			
			if($this->response->post("cart") == "" || $this->response->postDecode("cart") == ""){
				$this->response->send(array("message"=>"Tidak ada data belanja yang dipilih [3]","messageCode"=>3),true);
				return;
			}
			
			$QCart = $this->db
				->where("id",$this->response->postDecode("cart"))
				->where("member_id",$this->response->postDecode("user"))
				->get("tb_cart")
				->row();
				
			if(empty($QCart)){
				$this->response->send(array("message"=>"Data belanja sudah tidak tersedia [4]","messageCode"=>4),true);
				return;
			}
			
			$QShop = $this->db
					->where("id",$QCart->toko_id)
					->get("tb_toko")
					->row();
					
			if(empty($QShop)){
				$this->response->send(array("message"=>"Toko tidak ditemukan [5]","messageCode"=>5),true);
				return;
			}
			
			$QShopMember = $this->db
					->where("toko_id",$QShop->id)
					->where("member_id",$QUser->id)
					->get("tb_toko_member")
					->row();
					
			if(empty($QShopMember)){
				$this->response->send(array("message"=>"Anda sudah tidak tergabung dengan toko \"".$QShop->name."\"  [6]","messageCode"=>6),true);
				return;
			}
			
			if($this->response->post("cart_products") == "" || $this->response->postDecode("cart_products") == ""){
				$this->response->send(array("message"=>"Tidak ada products dalam daftar belanjaan [7]","messageCode"=>7),true);
				return;
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Check data cart products
			*	------------------------------------------------------------------------------
			*/
			
			for($p=0;$p<= ((float) $this->response->postDecode("cart_products")) - 1;$p++){
				if($this->response->post("cart_product".$p) != "" || $this->response->postDecode("cart_product".$p) != ""){
					$MessageProduct = array();
					$FormCartProduct = $this->response->postDecode("cart_product".$p);
					$QCartProduct = $this->db->where("id",$this->response->postDecode("cart_product".$p))->get("tb_cart_product")->row();
					
					if(empty($QCartProduct)){
						if(empty($MessageProduct)){
							$isCartValid = false;
							$MessageProduct = array("product"=>$FormCartProduct,"message"=>"Data cart barang tidak ditemukan [8]");
							array_push($MessageProducts,$MessageProduct);
						}
					}
					
					$QProduct = $this->db->where("id",$QCartProduct->product_id)->get("tb_product")->row();
					
					if(empty($QProduct)){
						if(empty($MessageProduct)){
							$isCartValid = false;
							$MessageProduct = array("product"=>$FormCartProduct,"message"=>"Tidak ada product dalam daftar belanjaan [9]");
							array_push($MessageProducts,$MessageProduct);
						}
					}
					
					if($QProduct->active == 0){
						if(empty($MessageProduct)){
							$isCartValid = false;
							$MessageProduct = array("product"=>$FormCartProduct,"message"=>"Barang tidak tersedia [10]");
							array_push($MessageProducts,$MessageProduct);
						}
					}
					
					if($QProduct->stock_type == 0){
						$long = $this->hs_datetime->countDate(date("Y-m-d H:i:s"),$QProduct->end_date);
						if($long <= 0){
							if(empty($MessageProduct)){
								$isCartValid = false;
								$MessageProduct = array("product"=>$FormCartProduct,"message"=>"Barang tidak tersedia [11]");
								array_push($MessageProducts,$MessageProduct);
							}
						}
					}
					
					if($QProduct->stock_type != $this->response->postDecode("cart_product".$p."_stock_type")){
						if(empty($MessageProduct)){
							$isCartValid = false;
							$MessageProduct = array("product"=>$FormCartProduct,"message"=>"Data barang telah berubah [12]");
							array_push($MessageProducts,$MessageProduct);
						}
					}
						
					if($this->response->post("cart_product".$p."_stock_type") == "" || $this->response->postDecode("cart_product".$p."_stock_type") == ""){
						if(empty($MessageProduct)){
							$isCartValid = false;
							$MessageProduct = array("product"=>$FormCartProduct,"message"=>"Tidak ada data stock type yang dikirim [13]");
							array_push($MessageProducts,$MessageProduct);
						}
					}
					
					if($this->response->post("cart_product".$p."_min_order") == "" || $this->response->postDecode("cart_product".$p."_min_order") == ""){
						if(empty($MessageProduct)){
							$isCartValid = false;
							$MessageProduct = array("product"=>$FormCartProduct,"message"=>"Tidak ada data minimal order yang dikirim [14]");
							array_push($MessageProducts,$MessageProduct);
						}
					}
					
					if($this->response->post("cart_product".$p."_price") == "" || $this->response->postDecode("cart_product".$p."_price") == ""){
						if(empty($MessageProduct)){
							$isCartValid = false;
							$MessageProduct = array("product"=>$FormCartProduct,"message"=>"Tidak ada data harga yang dikirim [15]");
							array_push($MessageProducts,$MessageProduct);
						}
					}
					
					if($QProduct->min_order != (float)$this->response->postDecode("cart_product".$p."_min_order")){
						if(empty($MessageProduct)){
							$isCartValid = false;
							$MessageProduct = array("product"=>$FormCartProduct,"message"=>"Data barang telah diubah [16]");
							array_push($MessageProducts,$MessageProduct);
						}
					}
					
					/*
					*	------------------------------------------------------------------------------
					*	Check perubahan harga barang
					*	------------------------------------------------------------------------------
					*/
					$product_price = $QProduct->price_1;
					
					switch($QShopMember->price_level){
						case "1":
							if($QProduct->price_1 > 0 && $QShop->level_1_active == 1){
								$product_price = $QProduct->price_1;
							}
						break;
						
						case "2":
							if($QProduct->price_2 > 0 && $QShop->level_2_active == 1){
								$product_price = $QProduct->price_2;
							}
						break;
						
						case "3":
							if($QProduct->price_3 > 0 && $QShop->level_3_active == 1){
								$product_price = $QProduct->price_3;
							}
						break;
						
						case "4":
							if($QProduct->price_4 > 0 && $QShop->level_4_active == 1){
								$product_price = $QProduct->price_4;
							}
						break;
						
						case "5":
							if($QProduct->price_5 > 0 && $QShop->level_5_active == 1){
								$product_price = $QProduct->price_5;
							}
						break;
					}
					
					if($QProduct->min_order != (float) $this->response->postDecode("cart_product".$p."_min_order")){
						if(empty($MessageProduct)){
							$isCartValid = false;
							$MessageProduct = array("product"=>$FormCartProduct,"message"=>"Data barang telah diubah [17]");
							array_push($MessageProducts,$MessageProduct);
						}
					}
					
					/*
					*	------------------------------------------------------------------------------
					*	Check data cart varians
					*	------------------------------------------------------------------------------
					*/
					
					if($this->response->post("cart_product".$p."_varians") == "" || $this->response->postDecode("cart_product".$p."_varians") == ""){
						if(empty($MessageProduct)){
							$isCartValid = false;
							$MessageProduct = array("product"=>$FormCartProduct,"message"=>"Tidak ada data varian yang dikirim [18]");
							array_push($MessageProducts,$MessageProduct);
						}
					}
					$message = "";
					$buy_qty = 0;
					for($v=0;$v<= ((float) $this->response->postDecode("cart_product".$p."_varians")) - 1;$v++){
						if($this->response->post("cart_product".$p."_varian".$v) != "" && $this->response->postDecode("cart_product".$p."_varian".$v) != ""){
							$QCartVarian = $this->db
									->where("id",$this->response->postDecode("cart_product".$p."_varian".$v))
									->get("tb_cart_varian")
									->row();
							
							if(empty($QCartVarian)){
								if(empty($MessageProduct)){
									$isCartValid = false;
									$MessageProduct = array("product"=>$FormCartProduct,"message"=>"Varian sudah tidak tersedia [19]");
									array_push($MessageProducts,$MessageProduct);
								}
							}
							
							$QVarian = $this->db
								->where("id",$QCartVarian->product_varian_id)
								->get("tb_product_varian")
								->row();
								
							if(empty($QVarian)){
								if(empty($MessageProduct)){
									$isCartValid = false;
									$MessageProduct = array("product"=>$FormCartProduct,"message"=>"Varian sudah tidak tersedia [20]");
									array_push($MessageProducts,$MessageProduct);
								}
							}
								
							if($this->response->post("cart_product".$p."_varian".$v."_quantity") != "" && $this->response->postDecode("cart_product".$p."_varian".$v."_quantity") != ""){
								if($this->response->postDecode("cart_product".$p."_varian".$v."_quantity") != "0"){
									if($QProduct->stock_type == 1 && $QProduct->stock_type_detail == 0){
										if($QVarian->stock_qty < intval($this->response->postDecode("cart_product".$p."_varian".$v."_quantity"))){
											if(empty($MessageProduct)){
												$isCartValid = false;
												$MessageProduct = array("product"=>$FormCartProduct,"message"=>"Stok tidak mencukupi [21]");
												array_push($MessageProducts,$MessageProduct);
											}
										}
									}
									
									$buy_qty = $buy_qty + intval($this->response->postDecode("cart_product".$p."_varian".$v."_quantity"));
								}
							}
						}
					}
					
					if($QProduct->min_order > $buy_qty){
						if(empty($MessageProduct)){
							$isCartValid = false;
							$MessageProduct = array("product"=>$FormCartProduct,"message"=>"Jumlah pembelian \"".$QProduct->name."\" kurang dari minimal order [22]");
							array_push($MessageProducts,$MessageProduct);
						}
					}
				}
			}
			
			if($isCartValid){
				$this->response->send(array("result"=>1,"message"=>"Cart sudah valid","messageCode"=>23), true);
			}else{
				$this->response->send(array("result"=>0,"message"=>"Cart tidak valid","message_products"=>$MessageProducts,"messageCode"=>24), true);
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
				$this->response->send(array("result"=>0,"message"=>"Daftar belanja anda tidak valid","messageCode"=>4), true);
				return;
			}
			
			$QShop = $this->db
					->where("id",$QCart->toko_id)
					->get("tb_toko")
					->row();
					
			if(empty($QShop)){
				$this->response->send(array("result"=>0,"message"=>"Toko tidak valid","messageCode"=>5), true);
				return;
			}
			
			if($this->response->post("courier_type") == "" || $this->response->postDecode("courier_type") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tipe pengiriman belum dipilih","messageCode"=>6), true);
				return;
			}
			
			if($this->response->postDecode("courier_type") != "0"){
				if($this->response->post("courier") == "" || $this->response->postDecode("courier") == ""){
					$this->response->send(array("result"=>0,"message"=>"Tidak ada kurir yang dipilih","messageCode"=>7), true);
					return;
				}
				
				if($this->response->post("location_name") == "" || $this->response->postDecode("location_name") == ""){
					$this->response->send(array("result"=>0,"message"=>"Tidak ada data nama penerima","messageCode"=>8), true);
					return;
				}
				
				if($this->response->post("location_address") == "" || $this->response->postDecode("location_address") == ""){
					$this->response->send(array("result"=>0,"message"=>"Tidak ada data alamat penerima","messageCode"=>9), true);
					return;
				}
				
				if($this->response->post("province") == "" || $this->response->postDecode("province") == ""){
					$this->response->send(array("result"=>0,"message"=>"Tidak ada data propinsi alamat penerima","messageCode"=>10), true);
					return;
				}
				
				if($this->response->post("city") == "" || $this->response->postDecode("city") == ""){
					$this->response->send(array("result"=>0,"message"=>"Tidak ada data kota alamat penerima","messageCode"=>11), true);
					return;
				}
				
				if($this->response->post("kecamatan") == "" || $this->response->postDecode("kecamatan") == ""){
					$this->response->send(array("result"=>0,"message"=>"Tidak ada data kecamatan alamat penerima","messageCode"=>12), true);
					return;
				}
			}
			
		
			if($this->response->postDecode("courier_type") == "1"){
				$QCourier = $this->db
						->where("name",$this->response->postDecode("courier"))
						->get("ms_courier")
						->row();
						
				if(empty($QCourier)){
					$this->response->send(array("result"=>0,"message"=>"Kurir tidak ditemukan","messageCode"=>13), true);
					return;
				}
			}elseif($this->response->postDecode("courier_type") == "2"){
				$QCourier = $this->db
						->where("name",$this->response->postDecode("courier"))
						->where("toko_id",$QCart->toko_id)
						->get("tb_courier_custom")
						->row();
				
				if(empty($QCourier)){
					$this->response->send(array("result"=>0,"message"=>"Kurir tidak ditemukan","messageCode"=>14), true);
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
					$this->response->send(array("result"=>0,"message"=>"Lokasi penerima tidak valid","messageCode"=>15), true);
					return;
				}
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Syncronisasi data varian dari apps ke server
			*	------------------------------------------------------------------------------
			*/
			
			$isValidQuantity = true;
			$isValidMessage = "Stok tidak mencukupi untuk pembelian ini";
			if($this->response->post("cart_varians") != "" && $this->response->postDecode("cart_varians") != "" && $this->response->postDecode("cart_varians") > 0){
				for ($i = 0; $i <$this->response->postDecode("cart_varians"); $i++) {
					if($this->response->post("cart_varian_".$i) != "" && $this->response->postDecode("cart_varian_".$i) != "" && $this->response->post("cart_varian_quantity_".$i) != "" && $this->response->postDecode("cart_varian_quantity_".$i) != ""){
						$Quantity = floatval($this->response->postDecode("cart_varian_quantity_".$i));
						
						if(!empty($Quantity) && $Quantity > 0){
							$CartVarian = $this->db->where("id",$this->response->postDecode("cart_varian_".$i))->get("tb_cart_varian")->row();
							
							if(!empty($CartVarian)){
								$ProductVarian = $this->db->where("id",$CartVarian->product_varian_id)->get("tb_product_varian")->row();
								if(!empty($ProductVarian)){
									$Product = $this->db->where("id",$ProductVarian->product_id)->get("tb_product")->row();
									if(!empty($Product)){
										if($Product->stock_type == 1 && $Product->stock_type_detail == 0){
											if($ProductVarian->stock_qty < $Quantity){
												$isValidQuantity = false;
												return;
											}
										}
									}else{
										$isValidQuantity = false;
										$isValidMessage = "Data produk tidak valid.";
									}
								}else{
									$isValidQuantity = false;
									$isValidMessage = "Data produk varian tidak valid.";
								}
							}else{
								$isValidQuantity = false;
								$isValidMessage = "Data cart varian tidak valid lagi.";
							}
							
							$Data = array(
										"quantity"=>$Quantity,
									);
							
							$Save = $this->db->where("id",$this->response->postDecode("cart_varian_".$i))->update("tb_cart_varian",$Data);
						}else{
							/*
							*	Delete cart varian karena quantity tidak diisi (null/0)
							*/
							$Delete = $this->db->where("id",$this->response->postDecode("cart_varian_".$i))->delete("tb_cart_varian");
						}
					}
				}
			}
			
			if(!$isValidQuantity){
				$this->response->send(array("result"=>0,"message"=>"Stok tidak mencukupi untuk pembelian ini.","messageCode"=>16), true);
				return;
			}
			
			
			
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
								if($QProduct->price_1 > 0 && $QShop->level_1_active == 1){
									$product_price = $QProduct->price_1;
								}
							break;
							
							case "2":
								if($QProduct->price_2 > 0 && $QShop->level_2_active == 1){
									$product_price = $QProduct->price_2;
								}
							break;
							
							case "3":
								if($QProduct->price_3 > 0 && $QShop->level_3_active == 1){
									$product_price = $QProduct->price_3;
								}
							break;
							
							case "4":
								if($QProduct->price_4 > 0 && $QShop->level_4_active == 1){
									$product_price = $QProduct->price_4;
								}
							break;
							
							case "5":
								if($QProduct->price_5 > 0 && $QShop->level_5_active == 1){
									$product_price = $QProduct->price_5;
								}
							break;
						}
					}
				}
				
				/*
				*	------------------------------------------------------------------------------
				*	Menghitung total harga pembelian per product
				*	------------------------------------------------------------------------------
				*/
				
				$QCartVarians = $this->db
					->select("tcv.*")
					->join("tb_product_varian tpv","tcv.product_varian_id = tpv.id")
					->where("tcv.cart_product_id",$QCartProduct->id)
					->get("tb_cart_varian tcv")
					->result();
						
				foreach($QCartVarians as $QCartVarian){
					$price_product = $price_product + ($QCartVarian->quantity * $product_price);
					
					/*
					*	------------------------------------------------------------------------------
					*	Menghitung berat pembelian per product
					*	------------------------------------------------------------------------------
					*/
					if(!empty($QProduct) && !empty($QProduct->weight) && !empty($QCartVarian->quantity)){
						$weightVarian = $QProduct->weight * $QCartVarian->quantity;
						$shipment_weight = $shipment_weight + $weightVarian;
					}
				}
				
				$Data = array(
						"price_product"=>$price_product,
					);
					
				$Save = $this->db->where("id",$QCartProduct->id)->update("tb_cart_product",$Data);
				
				/*
				*	------------------------------------------------------------------------------
				*	Menghitung total harga pembelian item
				*	------------------------------------------------------------------------------
				*/
				$price_item = $price_item + $price_product;
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
						"stock_type"=>$QCart->stock_type,
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
						"stock_type"=>$QCart->stock_type,
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
						"stock_type"=>$QCart->stock_type,
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
						->where("stock_type",$QCart->stock_type)
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
						->where("stock_type",$QCart->stock_type)
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
						->where("stock_type",$QCart->stock_type)
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
					$QCartProducts = $this->db
						->select("tcp.*, tp.id as product_id, tp.name as product_name, tp.description as product_description, tp.price_base")
						->join("tb_product tp","tcp.product_id = tp.id")
						->where("tcp.cart_id",$QCart->id)
						->get("tb_cart_product tcp")
						->result();
						
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
									$ProductVarian = $this->db->where("id",$QCartVarian->product_varian_id)->get("tb_product_varian")->row();
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
											
											/*
											*	------------------------------------------------------------------------------
											*	Ubah stock quantity produk varian jika setingan shop stock_adjust == 1
											*	------------------------------------------------------------------------------
											*/
											
											if($QShop->stock_adjust == 0 && !empty($ProductVarian)){
												$NewStockQty = $ProductVarian->stock_qty - $QInvoiceVarian->quantity;
												
												$Data = array(
														"stock_qty"=>$NewStockQty,
													);
													
												$Save = $this->db->where("id",$ProductVarian->id)->update("tb_product_varian",$Data);
											}
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
					*	Membuat object Invoice
					*	------------------------------------------------------------------------------
					*/
					$Invoice = $this->getInvoiceById($QInvoice->id,$QUser->id);
					
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
				$QMessages = $QMessages->limit($this->paging_limit,$this->response->postDecode("page"));
			}else{
				$QMessages = $QMessages->limit($this->paging_limit,$this->paging_offset);
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
			
			$title = "";
			$image = "";
			
			if($this->response->post("product") != "" || $this->response->postDecode("product") != ""){
				$QProduct = $this->db
							->where("id",$this->response->postDecode("product"))
							->get("tb_product")
							->row();
				
				if(!empty($QProduct)){
					$QProductImage = $this->db
									->where("product_id",$QProduct->id)
									->get("tb_product_image")
									->row();
									
					if(!empty($QProductImage)){
						$image = $QProductImage->file;
						$title = $QProduct->name;
					}
				}
			}
			
			/*
			*	------------------------------------------------------------------------------
			*	Menyimpan data message parent
			*	------------------------------------------------------------------------------
			*/
			
			$Data = array(
					"message"=>$this->response->postDecode("message"),
					"title"=>$title,
					"image"=>$image,
					"create_date"=>date("Y-m-d H:i:s"),
					"create_user"=>$QUser->email,
					"update_date"=>date("Y-m-d H:i:s"),
					"update_user"=>$QUser->email,
				);
			
			$Save = $this->db->insert("tb_message",$Data);
			if($Save){
				$QMessage = $this->db
							->where("message",$this->response->postDecode("message"))
							->where("title",$title)
							->where("image",$image)
							->where("create_user",$QUser->email)
							->where("update_user",$QUser->email)
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
					
					if($QMessage->image != ""){
						if(@getimagesize(base_url("assets/pic/product/".$QMessage->image))){
							$ImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/pic/product/resize/".$QMessage->image)));
							$ImageHigh = base_url("image.php?q=100&fe=".base64_encode(base_url("assets/pic/product/".$QMessage->image)));
						}else{
							$ImageTumb = base_url("image.php?q=".$this->quality."&fe=".base64_encode(base_url("assets/image/img_default_photo.jpg")));
							$ImageHigh = $ImageTumb;
						}
					}else{
						$ImageTumb = "";
						$ImageHigh = "";
					}
					
					$Messages = array(
								"id"=>$QUserMessage->id,
								"shop_name"=>$QUserMessage->toko_name,
								"message"=>$QMessage->message,
								"title"=>$QMessage->title,
								"image_tumb"=>$ImageTumb,
								"image_high"=>$ImageHigh,
								"isfrom"=>$QUserMessage->flag_from,
								"isread"=>$QUserMessage->flag_read,
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

