<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER DASHBOARD WEBSITE
* This controler for screen dashboard
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 23 Juni 2015 by Heri Siswanto, Create function : index
* 2. Create 26 Juni 2015 by Heri Siswanto, Create function : step2, step3, step4
*/

set_time_limit (99999999999);

class Toko extends CI_Controller {

	function __construct(){
        parent::__construct();
		
		$this->load->model("enduser/model_courier");
		$this->load->model("enduser/model_courier_custom");
		$this->load->model("enduser/model_courier_custom_rate");
		$this->load->model("enduser/model_category");
		$this->load->model("enduser/model_location");
		$this->load->model("enduser/model_toko");
		$this->load->model("enduser/model_toko_attribute");
		$this->load->model("enduser/model_toko_courier");
		
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			redirect('index/');
			return;
		}
    }
	
	public function index(){
		$data["Categories"] = $this->model_category->get()->result();
		$data["Provinces"] = $this->model_location->get_provinces()->result();
		$data["Cities"] = $this->model_location->get_cities()->result();
		$data["Kecamatans"] = $this->model_location->get_kecamatans()->result();
		$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
		$data["Attributes"] = $this->model_toko_attribute->get_by_shop($_SESSION["bonobo"]["id"])->result();
		
		$this->template->bonobo_step("enduser/toko/bg_step_1",$data);
	}
	
	public function step2(){
		if(!$_POST){
			$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
		
			$this->template->bonobo_step("enduser/toko/bg_step_2",$data);
		}else{
			$Data = array(
					"privacy"=>$this->response->post("rdgPrivation"),
				);
			
			$Save = $this->db->where("id",$_SESSION["bonobo"]["id"])->update("tb_toko",$Data);
			
			redirect("toko/step3");
		}
	}
	
	public function step3(){
		if(!$_POST){
			$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
			
			$this->template->bonobo_step("enduser/toko/bg_step_3",$data);
		}else{
			$Data = array(
					"stock_adjust"=>$this->response->post("rdgStock"),
				);
			
			$Save = $this->db->where("id",$_SESSION["bonobo"]["id"])->update("tb_toko",$Data);
			
			redirect("toko/step4");
		}
	}
	
	public function step4(){
		if(!$_POST){
			$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
			
			$this->template->bonobo_step("enduser/toko/bg_step_4",$data);
		}else{
			$pm_store_payment = 0;
			$pm_transfer = 0;
			
			if($this->response->post("chkPaymentCash") != ""){
				$pm_store_payment = 1;
			}
			
			if($this->response->post("chkPaymentTransfer") != ""){
				$pm_transfer = 1;
			}
			
			$Data = array(
					"pm_store_payment"=>$pm_store_payment,
					"pm_transfer"=>$pm_transfer,
				);
			
			$Save = $this->db->where("id",$_SESSION["bonobo"]["id"])->update("tb_toko",$Data);
			
			redirect("toko/step5");
		}
	}
	
	public function step5(){
		if(!$_POST){
			$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
			$data["Couriers"] = $this->model_courier->get()->result();
			$data["CustomeCouriers"] = $this->model_courier_custom->get_by_shop($_SESSION['bonobo']['id'])->result();
			$data["Provinces"] = $this->model_location->get_provinces()->result();
			$data["Cities"] = $this->model_location->get_cities()->result();
			$data["Kecamatans"] = $this->model_location->get_kecamatans()->result();
			
			$this->template->bonobo_step("enduser/toko/bg_step_5",$data);
		}else{
			$dm_pick_up_store = 0;
			$dm_expedition = 0;
			$dm_store_delivery = 0;
			
			
			if($this->response->post("chkPickUpStore") != ""){
				$dm_pick_up_store = 1;
			}
			
			if($this->response->post("chkExpedition") != ""){
				$dm_expedition = 1;
			}
			
			if($this->response->post("chkStoreDelivery") != ""){
				$dm_store_delivery = 1;
			}
			
			$Data = array(
					"dm_pick_up_store"=>$dm_pick_up_store,
					"dm_expedition"=>$dm_expedition,
					"dm_store_delivery"=>$dm_store_delivery,
				);
			
			$Save = $this->db->where("id",$_SESSION["bonobo"]["id"])->update("tb_toko",$Data);
			
			if($Save){
				/*
				*	Save Shop Courier
				*/
				$Couriers = $this->model_courier->get()->result();
				
				foreach($Couriers as $Courier){
					if($this->response->post("chkCourier".$Courier->id) != ""){
						$QCourier = $this->model_toko_courier->get_by_shop_courier($_SESSION["bonobo"]["id"],$Courier->id)->row();
						
						if(empty($QCourier)){
							$Data = array(
									"toko_id"=>$_SESSION["bonobo"]["id"],
									"courier_id"=>$Courier->id,
									"create_date"=>date("Y-m-d H:i:s"),
									"create_user"=>$_SESSION['bonobo']['email'],
									"update_date"=>date("Y-m-d H:i:s"),
									"update_user"=>$_SESSION['bonobo']['email'],
								);
								
							$Insert = $this->db->insert("tb_toko_courier",$Data);
						}
					}else{
						$Delete = $this->db
							->where("toko_id",$_SESSION["bonobo"]["id"])
							->where("courier_id",$Courier->id)
							->delete("tb_toko_courier");
					}
				}
			}
			
			redirect("toko/step6");
		}
	}
	
	public function step6(){
		$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
		
		$this->template->bonobo_step("enduser/toko/bg_step_6",$data);
	}
	
	public function step7(){
		$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
		
		$this->template->bonobo_step("enduser/toko/bg_step_7",$data);
	}
	
	public function step5Detail(){
		if($this->response->post("id") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang dipilih","messageCode"=>1));
			return;
		}
		
		$Courier = $this->model_courier_custom->get_by_id($this->response->post("id"))->row();
		if(!empty($Courier)){
			$this->response->send(array("result"=>1,"id"=>$Courier->id,"name"=>$Courier->name,"messageCode"=>1));
		}else{
			$this->response->send(array("result"=>0,"message"=>"Data tidak ditemukan","messageCode"=>1));
		}
	}
	
	public function step5Form(){
		$data["Provinces"] = $this->model_location->get_provinces()->result();
		$data["Cities"] = $this->model_location->get_cities()->result();
		$data["Kecamatans"] = $this->model_location->get_kecamatans()->result();
			
		$this->load->view("enduser/toko/bg_step_5_form",$data);
	}
	
	public function step5Table(){
		if($this->response->post("courier") == ""){
			echo "Tidak ada data";
			return;
		}
		
		$data["Rates"] = $this->model_courier_custom_rate->get_by_courier($this->response->post("courier"))->result();
		$this->load->view("enduser/toko/bg_step_5_table",$data);
	}
	
	public function doStep1Save(){
		if($this->response->post("txtName") == ""){
			$this->response->send(array("result"=>0,"message"=>"Field nama masih kosong","messageCode"=>1));
			return;
		}
		
		if($this->response->post("txtTagname") == ""){
			$this->response->send(array("result"=>0,"message"=>"Field toko ID masih kosong","messageCode"=>1));
			return;
		}
		
		if($this->response->post("cmbCategory") == ""){
			$this->response->send(array("result"=>0,"message"=>"Field kategory masih kosong","messageCode"=>1));
			return;
		}
		
		if($this->response->post("cmbProvince") == ""){
			$this->response->send(array("result"=>0,"message"=>"Field propinsi masih kosong","messageCode"=>1));
			return;
		}
		
		if($this->response->post("cmbCity") == ""){
			$this->response->send(array("result"=>0,"message"=>"Field kota masih kosong","messageCode"=>1));
			return;
		}
		
		if($this->response->post("cmbKecamatan") == ""){
			$this->response->send(array("result"=>0,"message"=>"Field kecamatan masih kosong","messageCode"=>1));
			return;
		}
		
		$QCategory = $this->model_category->get_by_id($this->response->post("cmbCategory"))->row();
		if(!empty($QCategory)){
			$Category = $QCategory->id;
		}else{
			$Category = null;
		}
		
		$postal = $this->response->post("txtPostal");
		$kecamatan = $this->response->post("cmbKecamatan");
		$city = $this->response->post("cmbCity");
		$province = $this->response->post("cmbProvince");
		
		$QLocation = $this->model_location->get_by_filter($postal,$kecamatan,$city,$province)->row();
		if(!empty($QLocation)){
			$Location = $QLocation->id;
		}else{
			$QLocation = $this->model_location->get_by_filter(null,$kecamatan,$city,$province)->row();
			if(!empty($QLocation)){
				$Location = $QLocation->id;
			}else{
				$Location = null;
			}
		}
		
		if(!empty($_FILES['txtShopLogoFile']) && isset($_FILES['txtShopLogoFile']['name']) && !empty($_FILES['txtShopLogoFile']['name'])){
			$UploadPath    = 'assets/pic/shop/';
			$Upload = $this->template->upload_picture($UploadPath,"txtShopLogoFile");
			
			if($Upload == 'error'){
				$Upload = "";
			}
			
			$Data = array(
				"name"=>$this->response->post("txtName"),
				"tag_name"=>$this->response->post("txtTagname"),
				"keyword"=>$this->response->post("txtKeyword"),
				"description"=>$this->response->post("txtDescription"),
				"phone"=>$this->response->post("txtPhone"),
				"address"=>$this->response->post("txtAddress"),
				"postal"=>$this->response->post("txtPostal"),
				"image"=>$Upload,
				"category_id"=>$Category,
				"location_id"=>$Location,
			);
		}else{
			$Data = array(
				"name"=>$this->response->post("txtName"),
				"tag_name"=>$this->response->post("txtTagname"),
				"keyword"=>$this->response->post("txtKeyword"),
				"description"=>$this->response->post("txtDescription"),
				"phone"=>$this->response->post("txtPhone"),
				"address"=>$this->response->post("txtAddress"),
				"postal"=>$this->response->post("txtPostal"),
				"category_id"=>$Category,
				"location_id"=>$Location,
			);
		}
			
		$Save = $this->db->where("id",$_SESSION["bonobo"]["id"])->update("tb_toko",$Data);
		if($Save){
			if($this->response->post("intAttributeCount") > 0){
				for($i=1;$i<=$this->response->post("intAttributeCount");$i++){
					if($this->response->post("txtAttributeName".$i) != "" && $this->response->post("txtAttributeValue".$i) != ""){
						if($this->response->post("txtAttributeId".$i) == ""){						
							$Data = array(
								"toko_id"=>$_SESSION["bonobo"]["id"],
								"name"=>$this->response->post("txtAttributeName".$i),
								"value"=>$this->response->post("txtAttributeValue".$i),
								"create_date"=>date("Y-m-d H:i:s"),
								"create_user"=>$_SESSION['bonobo']['email'],
								"update_date"=>date("Y-m-d H:i:s"),
								"update_user"=>$_SESSION['bonobo']['email'],
							);
							
							$Save = $this->db->insert("tb_toko_attribute",$Data);
						}else{
							$Data = array(
								"toko_id"=>$_SESSION["bonobo"]["id"],
								"name"=>$this->response->post("txtAttributeName".$i),
								"value"=>$this->response->post("txtAttributeValue".$i),
								"update_user"=>$_SESSION['bonobo']['email'],
							);
							
							$Save = $this->db->where("id",$this->response->post("txtAttributeId".$i))->update("tb_toko_attribute",$Data);
						}
					}
				}
			}
		
			$this->response->send(array("result"=>1,"message"=>"Informasi toko telah disimpan : ","messageCode"=>1));
		}else{
			$this->response->send(array("result"=>0,"message"=>"Informasi tidak dapat disimpan","messageCode"=>1));
		}
	}
	
	public function doStep5CourierSave(){
		if($this->response->post("name") == ""){
			$this->response->send(array("result"=>0,"message"=>"Nama masih kosong","messageCode"=>1));
			return;
		}
		
		if($this->response->post("id") == ""){
			$date = date("Y-m-d H:i:s");
			$Data = array(
					"toko_id"=>$_SESSION["bonobo"]["id"],
					"name"=>$this->response->post("name"),
					"status"=>1,
					"create_date"=>$date,
					"create_user"=>$_SESSION['bonobo']['email'],
					"update_date"=>$date,
					"update_user"=>$_SESSION['bonobo']['email'],
				);
				
			$Save = $this->db->insert("tb_courier_custom",$Data);
			if($Save){
				$Courier = $this->db
						->where("toko_id",$_SESSION["bonobo"]["id"])
						->where("name",$this->response->post("name"))
						->where("status",1)
						->where("create_date",$date)
						->where("create_user",$_SESSION['bonobo']['email'])
						->where("update_date",$date)
						->where("update_user",$_SESSION['bonobo']['email'])
						->get("tb_courier_custom")
						->row();
				
				if(!empty($Courier)){
					$this->response->send(array("result"=>1,"message"=>"Data telah disimpan","messageCode"=>1,"id"=>$Courier->id));
				}else{
					$this->response->send(array("result"=>0,"message"=>"Data telah disimpan","messageCode"=>1));
				}
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak dapat disimpan","messageCode"=>1));
			}
		}else{
			$Data = array(
					"name"=>$this->response->post("name"),
				);
				
			$Save = $this->db->where("id",$this->response->post("id"))->update("tb_courier_custom",$Data);
			if($Save){
				$this->response->send(array("result"=>1,"message"=>"Data telah disimpan","messageCode"=>1));
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak dapat disimpan","messageCode"=>1));
			}
		}
	}
	
	public function doStep5CourierDelete(){
		if($this->response->post("id") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang dipilih","messageCode"=>1));
			return;
		}
		
		$Delete = $this->db->where("id",$this->response->post("id"))->delete("tb_courier_custom");
		if($Delete){
			$this->response->send(array("result"=>1,"message"=>"Data telah dihapus","messageCode"=>1));
		}else{
			$this->response->send(array("result"=>0,"message"=>"Tidak dapat dihapus","messageCode"=>1));
		}
	}
	
	public function doStep5RateSave(){
		if($this->response->post("customCourier") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data courier yang dipilih","messageCode"=>1));
			return;
		}
		
		if($this->response->post("cmbProvince") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada propinsi yang dipilih","messageCode"=>2));
			return;
		}
		
		if($this->response->post("cmbCity") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada kota yang dipilih","messageCode"=>3));
			return;
		}
		
		if($this->response->post("cmbKecamatan") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada kecamatan yang dipilih","messageCode"=>4));
			return;
		}
				
		if($this->response->post("txtRateId") == ""){
			$Data = array(
					"courier_custom_id"=>$this->response->post("customCourier"),
					"location_to_province"=>$this->response->post("cmbProvince"),
					"location_to_city"=>$this->response->post("cmbCity"),
					"location_to_kecamatan"=>$this->response->post("cmbKecamatan"),
					"price"=>$this->response->post("txtRatePrice"),
					"create_date"=>date("Y-m-d H:i:s"),
					"create_user"=>$_SESSION['bonobo']['email'],
					"update_date"=>date("Y-m-d H:i:s"),
					"update_user"=>$_SESSION['bonobo']['email'],
				);
			
			$Save = $this->db->insert("tb_courier_custom_rate",$Data);
			if($Save){
				$this->response->send(array("result"=>1,"message"=>"Rate telah disimpan","messageCode"=>4));
			}else{
				$this->response->send(array("result"=>0,"message"=>"Rate tidak dapat disimpan","messageCode"=>5));
			}
		}else{
			$Data = array(
					"courier_custom_id"=>$this->response->post("customCourier"),
					"location_to_province"=>$this->response->post("cmbProvince"),
					"location_to_city"=>$this->response->post("cmbCity"),
					"location_to_kecamatan"=>$this->response->post("cmbKecamatan"),
					"price"=>$this->response->post("txtRatePrice"),
					"update_user"=>$_SESSION['bonobo']['email'],
				);
			
			$Save = $this->db->where("id",$this->response->post("txtRateId"))->update("tb_courier_custom_rate",$Data);
			if($Save){
				$this->response->send(array("result"=>1,"message"=>"Rate telah disimpan","messageCode"=>6));
			}else{
				$this->response->send(array("result"=>0,"message"=>"Rate tidak dapat disimpan","messageCode"=>7));
			}
		}
	}
	
	public function doStep5RateDelete(){
		if($this->response->post("rate") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data rate yang dipilih","messageCode"=>1));
			return;
		}
		
		$Delete = $this->db->where("id",$this->response->post("rate"))->delete("tb_courier_custom_rate");
		if($Delete){
			$this->response->send(array("result"=>1,"message"=>"Data telah dihapus","messageCode"=>2));
		}else{
			$this->response->send(array("result"=>0,"message"=>"Data tidak dapat dihapus","messageCode"=>3));
		}
	}
	
	public function comboboxCity(){
		$Cities = $this->model_location->get_cities_by_province($this->response->post("province"))->result();
		
		echo"<select name='cmbCity' onChange=ctrlShopStep1.loadComboboxKecamatan(); class='chzn-select'><option value='' disabled selected>Pilih Kota</option>";

		foreach($Cities as $City){
			echo"<option value='".$City->city."'>".$City->city."</option>";
		}
			
		echo"
			</select>
			<label id='notifCity' class='error' style='display:none;'></label>
			<script>initComboBox();</script>
		";
	}
	
	public function comboboxKecamatan(){
		$Kecamatans = $this->model_location->get_kecamatans_by_city_province($this->response->post("city"),$this->response->post("province"))->result();
		
		echo"<select name='cmbKecamatan' class='chzn-select'><option value='' disabled selected>Pilih Kecamatan</option>";

		foreach($Kecamatans as $Kecamatan){
			echo"<option value='".$Kecamatan->kecamatan."'>".$Kecamatan->kecamatan."</option>";
		}
			
		echo"
			</select>
			<label id='notifKecamatan' class='error' style='display:none;'></label>
			<script>initComboBox();</script>
		";
	}
	
	public function step5ComboboxCity(){
		$Cities = $this->model_location->get_cities_by_province($this->response->post("province"))->result();
		
		echo"<p><select name='cmbCity' onChange=ctrlShopStep5.loadComboboxKecamatan(); class='chzn-select'><option value='' disabled selected>Pilih Kota</option>";

		foreach($Cities as $City){
			echo"<option value='".$City->city."'>".$City->city."</option>";
		}
			
		echo"</select></p><script>initComboBox();</script>";
	}
	
	public function step5ComboboxKecamatan(){
		$Kecamatans = $this->model_location->get_kecamatans_by_city_province($this->response->post("city"),$this->response->post("province"))->result();
		
		echo"<p><select name='cmbKecamatan' class='chzn-select'><option value='' disabled selected>Pilih Kecamatan</option>";

		foreach($Kecamatans as $Kecamatan){
			echo"<option value='".$Kecamatan->kecamatan."'>".$Kecamatan->kecamatan."</option>";
		}
			
		echo"</select></p><script>initComboBox();</script>";
	}
}

