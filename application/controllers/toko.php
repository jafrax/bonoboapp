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
		
		$this->load->model("enduser/model_bank");
		$this->load->model("enduser/model_courier");
		$this->load->model("enduser/model_courier_custom");
		$this->load->model("enduser/model_courier_custom_rate");
		$this->load->model("enduser/model_category");
		$this->load->model("enduser/model_location");
		$this->load->model("enduser/model_toko");
		$this->load->model("enduser/model_toko_attribute");
		$this->load->model("enduser/model_toko_courier");
		$this->load->model("enduser/model_toko_bank");
		
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			redirect('index/');
			return;
		}
		
    }
	
	public function index(){
		$result=$this->model_toko->get_byflag_information($_SESSION['bonobo']['id'])->num_rows();
		$_SESSION['bonobo']['flag_information']=0;
		if($result>0){
			$_SESSION['bonobo']['flag_information']=1;
		}
		$data["Categories"] = $this->model_category->get()->result();
		$data["Provinces"] = $this->model_location->get_provinces()->result();
		$data["Cities"] = $this->model_location->get_cities()->result();
		$data["Kecamatans"] = $this->model_location->get_kecamatans()->result();
		$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
		$data["Attributes"] = $this->model_toko_attribute->get_by_shop($_SESSION["bonobo"]["id"])->result();
		
		$this->template->bonobo_step("enduser/toko/bg_step_1",$data);
	}
	
	public function comboboxprov(){
		$Provinces = $this->model_location->get_provinces_by_zipcode($this->response->post("zip_code"))->result();
		
		echo"<select name='cmbProvince' class='chzn-select'><option value='' disabled selected>Pilih Provinsi</option>";

		foreach($Provinces as $Province){
			echo"<option value='".$Province->province."' selected>".$Province->province."</option>";
		}
			
		echo"
			</select>
			<label id='notifProvince' class='error' style='display:none;'></label>
			<script>initComboBox();</script>
		";		
	}
	
	public function step2(){
		$result=$this->model_toko->get_byflag_information($_SESSION['bonobo']['id'])->num_rows();
		$_SESSION['bonobo']['flag_information']=0;
		if($result>0){
			$_SESSION['bonobo']['flag_information']=1;
		}
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
		$result=$this->model_toko->get_byflag_information($_SESSION['bonobo']['id'])->num_rows();
		$_SESSION['bonobo']['flag_information']=0;
		if($result>0){
			$_SESSION['bonobo']['flag_information']=1;
		}
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
	
	public function step4save(){
		if(empty($this->response->post("chkPaymentCash")) && empty($this->response->post("chkPaymentTransfer"))){
			$this->response->send(array("result"=>0,"message"=>"Harap memilih salah satu metode pembayaran","messageCode"=>1));
			return false;
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
			$this->response->send(array("result"=>1,"message"=>"Data berhasil disimpan","messageCode"=>1));
		}
	}
	
	public function step4(){
		$result=$this->model_toko->get_byflag_information($_SESSION['bonobo']['id'])->num_rows();
		$_SESSION['bonobo']['flag_information']=0;
		if($result>0){
			$_SESSION['bonobo']['flag_information']=1;
		}
			$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
			
			$this->template->bonobo_step("enduser/toko/bg_step_4",$data);

	}
	
	public function step7(){
		$result=$this->model_toko->get_byflag_information($_SESSION['bonobo']['id'])->num_rows();
		$_SESSION['bonobo']['flag_information']=0;
		if($result>0){
			$_SESSION['bonobo']['flag_information']=1;
		}
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
			
			redirect("toko/step8");
		}
	}
	
	public function step8(){
		$result=$this->model_toko->get_byflag_information($_SESSION['bonobo']['id'])->num_rows();
		$_SESSION['bonobo']['flag_information']=0;
		if($result>0){
			$_SESSION['bonobo']['flag_information']=1;
		}
		$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
		$data["Banks"] = $this->model_bank->get()->result();
		$data["ShopBanks"] = $this->model_toko_bank->get_by_shop($_SESSION["bonobo"]["id"])->result();
		
		$this->template->bonobo_step("enduser/toko/bg_step_6",$data);
	}
	
	public function step5(){
		$result=$this->model_toko->get_byflag_information($_SESSION['bonobo']['id'])->num_rows();
		$_SESSION['bonobo']['flag_information']=0;
		if($result>0){
			$_SESSION['bonobo']['flag_information']=1;
		}
                $data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
                $data['status1']=0;
                $data['status2']=0;
                $data['status3']=0;
                $data['status4']=0;
                $data['status5']=0;
                $data['id_toko']=$_SESSION['bonobo']['id'];
                        $result=$this->model_toko->cek_member_use1($data)->num_rows();
                        if($result>0){
                                $data['status1']=1;
                        }
                        $result=$this->model_toko->cek_member_use2($data)->num_rows();
                        if($result>0){
                                $data['status2']=1;
                        }
                        $result=$this->model_toko->cek_member_use3($data)->num_rows();
                        if($result>0){
                                $data['status3']=1;
                        }
                        $result=$this->model_toko->cek_member_use4($data)->num_rows();
                        if($result>0){
                                $data['status4']=1;
                        }
                        $result=$this->model_toko->cek_member_use5($data)->num_rows();
                        if($result>0){
                                $data['status5']=1;
                        }
                $this->template->bonobo_step("enduser/toko/bg_step_7",$data);
        }
	
	public function step7Detail(){
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
	
	public function step7Form(){
		$data["Provinces"] = $this->model_location->get_provinces()->result();
		$data["Cities"] = $this->model_location->get_cities()->result();
		$data["Kecamatans"] = $this->model_location->get_kecamatans()->result();
		$data["Rate"] = $this->model_courier_custom_rate->get_by_id($this->response->post("id"))->row();
		
		$this->load->view("enduser/toko/bg_step_5_form",$data);
	}
	
	public function step7Table(){
		if($this->response->post("courier") == ""){
			echo "Tidak ada data";
			return;
		}
		
		$data["Rates"] = $this->model_courier_custom_rate->get_by_courier($this->response->post("courier"))->result();
		$this->load->view("enduser/toko/bg_step_5_table",$data);
	}
	
	public function doStep1Save(){
		/*if($this->response->post("txtName") == ""){
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
		}*/
		
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
		$UploadPath    = 'assets/pic/shop/';
			$Upload = $this->template->upload_picture($UploadPath,"txtShopLogoFile");
		if(!empty($_FILES['txtShopLogoFile']) && isset($_FILES['txtShopLogoFile']['name']) && !empty($_FILES['txtShopLogoFile']['name'])){
			$UploadPath    = 'assets/pic/shop/';
			$Upload = $this->template->upload_picture($UploadPath,"txtShopLogoFile");
			
			if($Upload == 'error'){
				$Upload = "";
			}else{
				$_SESSION['bonobo']['image'] = $Upload;
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
	
	public function doStep7CourierSave(){
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
	
	public function doStep7CourierDelete(){
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
	
	public function doStep7RateSave(){
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
	
	public function doStep7RateDelete(){
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
	
	public function step8GetData(){
		if($this->response->post("id") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang dipilih","messageCode"=>1));
			return;
		}
		
		$ShopBank = $this->model_toko_bank->get_by_id($this->response->post("id"))->row();
		if(!empty($ShopBank)){
			$this->response->send(array("result"=>1,"id"=>$ShopBank->id,"acc_name"=>$ShopBank->acc_name,"acc_no"=>$ShopBank->acc_no,"bank_id"=>$ShopBank->bank_id,"bank_name"=>$ShopBank->bank_name,"messageCode"=>1));
		}else{
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang ditemukan","messageCode"=>1));
		}
	}

	public function doStep8Save(){
		if($this->response->post("cmbBank") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada bank yang dipilih","messageCode"=>1));
			return;
		}
		
		if($this->response->post("txtName") == ""){
			$this->response->send(array("result"=>0,"message"=>"Nama pemilik rekening masih kosong","messageCode"=>2));
			return;
		}
		
		if($this->response->post("txtNo") == ""){
			$this->response->send(array("result"=>0,"message"=>"Nomor rekening masih kosong","messageCode"=>3));
			return;
		}
		
		if($this->response->post("txtId") == ""){
			$Data = array(
					"toko_id"=>$_SESSION["bonobo"]["id"],
					"bank_id"=>$this->response->post("cmbBank"),
					"acc_name"=>$this->response->post("txtName"),
					"acc_no"=>$this->response->post("txtNo"),
					"create_date"=>date("Y-m-d H:i:s"),
					"create_user"=>$_SESSION['bonobo']['email'],
					"update_date"=>date("Y-m-d H:i:s"),
					"update_user"=>$_SESSION['bonobo']['email'],
				);
			$Save = $this->db->insert("tb_toko_bank",$Data);
			if($Save){
				$this->response->send(array("result"=>1,"message"=>"Bank telah disimpan","messageCode"=>4));
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak dapat menyimpan data bank","messageCode"=>5));
			}
		}else{
			$Data = array(
					"toko_id"=>$_SESSION["bonobo"]["id"],
					"bank_id"=>$this->response->post("cmbBank"),
					"acc_name"=>$this->response->post("txtName"),
					"acc_no"=>$this->response->post("txtNo"),
					"update_user"=>$_SESSION['bonobo']['email'],
				);
			$Save = $this->db->where("id",$this->response->post("txtId"))->update("tb_toko_bank",$Data);
			if($Save){
				$this->response->send(array("result"=>1,"message"=>"Bank telah disimpan","messageCode"=>6));
			}else{
				$this->response->send(array("result"=>0,"message"=>"Tidak dapat menyimpan data bank","messageCode"=>7));
			}
		}
	}
	
	public function doStep8Delete(){
		if($this->response->post("id") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data bank yang dipilih","messageCode"=>1));
			return;
		}
		
		$Delete = $this->db->where("id",$this->response->post("id"))->delete("tb_toko_bank");
		if($Delete){
			$this->response->send(array("result"=>1,"message"=>"Data telah dihapus","messageCode"=>2));
		}else{
			$this->response->send(array("result"=>0,"message"=>"Data tidak dapat dihapus","messageCode"=>3));
		}
		
	}
	
       public function autocek_level2(){
                $data['id_toko']=$_SESSION["bonobo"]["id"];
                $cek_levelonmember=$this->model_toko->cek_member_use2($data);
                if($cek_levelonmember->num_rows()>0){
                        $this->response->send(array("result"=>1,"message"=>"use data"));
                }else{
                        $this->response->send(array("result"=>0,"message"=>"not use"));
                }
        }
        public function update_level2(){
                $data['number'] =$this->response->post("level");
                $data['id_toko']=$_SESSION["bonobo"]["id"];
                $cek_level=$this->model_toko->cek_status_level_toko($data);
                $row=$cek_level->row();
                $data_update=1;
                if($row->level_2_active > 0){
                        $data_update=0;
                }
                $cek_level=$this->model_toko->update_level_toko2($data,$data_update);
                if($cek_level>0){
                        $this->response->send(array("result"=>1,"message"=>"Change sukses"));
                }else{
                        $this->response->send(array("result"=>0,"message"=>"Change failed"));
                }      
        }

        public function autocek_level3(){
                $data['id_toko']=$_SESSION["bonobo"]["id"];
                $cek_levelonmember=$this->model_toko->cek_member_use3($data);
                if($cek_levelonmember->num_rows()>0){
                        $this->response->send(array("result"=>1,"message"=>"use data"));
                }else{
                        $this->response->send(array("result"=>0,"message"=>"not use"));
                }
        }
        public function update_level3(){
                $data['number'] =$this->response->post("level");
                $data['id_toko']=$_SESSION["bonobo"]["id"];
                $cek_level=$this->model_toko->cek_status_level_toko($data);
                $row=$cek_level->row();
                $data_update=1;
                if($row->level_3_active > 0){
                        $data_update=0;
                }
                $cek_level=$this->model_toko->update_level_toko3($data,$data_update);
                if($cek_level>0){
                        $this->response->send(array("result"=>1,"message"=>"Change sukses"));
                }else{
                        $this->response->send(array("result"=>0,"message"=>"Change failed"));
                }      
        }

        public function autocek_level4(){
                $data['id_toko']=$_SESSION["bonobo"]["id"];
                $cek_levelonmember=$this->model_toko->cek_member_use4($data);
                if($cek_levelonmember->num_rows()>0){
                        $this->response->send(array("result"=>1,"message"=>"use data"));
                }else{
                        $this->response->send(array("result"=>0,"message"=>"not use"));
                }
        }
        public function update_level4(){
                $data['number'] =$this->response->post("level");
                $data['id_toko']=$_SESSION["bonobo"]["id"];
                $cek_level=$this->model_toko->cek_status_level_toko($data);
                $row=$cek_level->row();
                $data_update=1;
                if($row->level_4_active > 0){
                        $data_update=0;
                }
                $cek_level=$this->model_toko->update_level_toko4($data,$data_update);
                if($cek_level>0){
                        $this->response->send(array("result"=>1,"message"=>"Change sukses"));
                }else{
                        $this->response->send(array("result"=>0,"message"=>"Change failed"));
                }      
        }

        public function autocek_level5(){
                $data['id_toko']=$_SESSION["bonobo"]["id"];
                $cek_levelonmember=$this->model_toko->cek_member_use5($data);
                if($cek_levelonmember->num_rows()>0){
                        $this->response->send(array("result"=>1,"message"=>"use data"));
                }else{
                        $this->response->send(array("result"=>0,"message"=>"not use"));
                }
        }
        public function update_level5(){
                $data['number'] =$this->response->post("level");
                $data['id_toko']=$_SESSION["bonobo"]["id"];
                $cek_level=$this->model_toko->cek_status_level_toko($data);
                $row=$cek_level->row();
                $data_update=1;
                if($row->level_5_active > 0){
                        $data_update=0;
                }
                $cek_level=$this->model_toko->update_level_toko5($data,$data_update);
                if($cek_level>0){
                        $this->response->send(array("result"=>1,"message"=>"Change sukses"));
                }else{
                        $this->response->send(array("result"=>0,"message"=>"Change failed"));
                }      
        }

        public function doStep5Save(){
                $chkLevel1 = 0;
                $chkLevel2 = 0;
                $chkLevel3 = 0;
                $chkLevel4 = 0;
                $chkLevel5 = 0;
               
                if($this->response->post("chkLevel1") != ""){
                        $chkLevel1 = 1;
                }
                if($this->response->post("chkLevel2") != ""){
                        $chkLevel2 = 1;
                }
                if($this->response->post("chkLevel3") != ""){
                        $chkLevel3 = 1;
                }
                if($this->response->post("chkLevel4") != ""){
                        $chkLevel4 = 1;
                }
                if($this->response->post("chkLevel5") != ""){
                        $chkLevel5 = 1;
                }
       
                $Data = array(
                                "level_1_name"=>$this->response->post("txtLevel1"),
                                "level_2_name"=>$this->response->post("txtLevel2"),
                                "level_3_name"=>$this->response->post("txtLevel3"),
                                "level_4_name"=>$this->response->post("txtLevel4"),
                                "level_5_name"=>$this->response->post("txtLevel5"),
                                "level_1_active"=>$chkLevel1,
                                "level_2_active"=>$chkLevel2,
                                "level_3_active"=>$chkLevel3,
                                "level_4_active"=>$chkLevel4,
                                "level_5_active"=>$chkLevel5,
                                "create_date"=>date("Y-m-d H:i:s"),
                                "create_user"=>$_SESSION['bonobo']['email'],
                                "update_date"=>date("Y-m-d H:i:s"),
                                "update_user"=>$_SESSION['bonobo']['email'],
                        );
                       
                $Save = $this->db->where("id",$_SESSION["bonobo"]["id"])->update("tb_toko",$Data);
                if($Save){                     
                        $this->response->send(array("result"=>1,"message"=>"Dsdata telah disimpan","messageCode"=>0));                 
                }else{
                        $this->response->send(array("result"=>0,"message"=>"Data tidak dapat disimpan","messageCode"=>0));
                }
        }
	
	public function comboboxCity(){
		$Cities = $this->model_location->get_cities_by_province($this->response->post("province"),$this->response->post("zip_code"))->result();
		
		echo"<select name='cmbCity' onChange=ctrlShopStep1.loadComboboxKecamatan(); class='chzn-select'><option value='' disabled selected>Pilih Kota</option>";

		foreach($Cities as $City){
			echo"<option value='".$City->city."' selected>".$City->city."</option>";
		}
			
		echo"
			</select>
			<label id='notifCity' class='error' style='display:none;'></label>
			<script>initComboBox();</script>
		";
	}
	
	public function comboboxKecamatan(){
		$Kecamatans = $this->model_location->get_kecamatans_by_city_province($this->response->post("city"),$this->response->post("province"),$this->response->post("zip_code"))->result();
		
		echo"<select name='cmbKecamatan' class='chzn-select'><option value='' disabled selected>Pilih Kecamatan</option>";

		foreach($Kecamatans as $Kecamatan){
			echo"<option value='".$Kecamatan->kecamatan."' selected>".$Kecamatan->kecamatan."</option>";
		}
			
		echo"
			</select>
			<label id='notifKecamatan' class='error' style='display:none;'></label>
			<script>initComboBox();</script>
		";
	}
	
	public function step7ComboboxCity(){
		$Cities = $this->model_location->get_cities_by_province($this->response->post("province"))->result();
		
		echo"<p><select name='cmbCity' onChange=ctrlShopStep7.loadComboboxKecamatan(); class='chzn-select'><option value='' disabled selected>Pilih Kota</option>";

		foreach($Cities as $City){
			echo"<option value='".$City->city."'>".$City->city."</option>";
		}
			
		echo"</select></p><script>initComboBox();</script>";
	}
	
	public function step7ComboboxKecamatan(){
		$Kecamatans = $this->model_location->get_kecamatans_by_city_province($this->response->post("city"),$this->response->post("province"))->result();
		
		echo"<p><select name='cmbKecamatan' class='chzn-select'><option value='' disabled selected>Pilih Kecamatan</option>";

		foreach($Kecamatans as $Kecamatan){
			echo"<option value='".$Kecamatan->kecamatan."'>".$Kecamatan->kecamatan."</option>";
		}
			
		echo"</select></p><script>initComboBox();</script>";
	}
	
	public function step8ComboboxBank(){
		$Banks = $this->model_bank->get()->result();
		$ShopBank = $this->model_toko_bank->get_by_id($this->response->post("id"))->row();
		
		echo"<select id='cmbBank' name='cmbBank' class='select-standar'><option value='' disabled selected>Pilih Bank</option>";
		
		foreach($Banks as $Bank){
			if(!empty($ShopBank)){
				if($Bank->id != $ShopBank->bank_id){
					echo"<option value='".$Bank->id."'>".$Bank->name."</option>";
				}else{
					echo "<option value='".$ShopBank->bank_id."' selected>".$ShopBank->bank_name."</option>";
				}
			}else{
				echo"<option value='".$Bank->id."'>".$Bank->name."</option>";
			}
		}
			
		echo"</select><script>$('.select-standar').material_select();</script>";
	}

	function step6(){
		$result=$this->model_toko->get_byflag_information($_SESSION['bonobo']['id'])->num_rows();
		$_SESSION['bonobo']['flag_information']=0;
		if($result>0){
			$_SESSION['bonobo']['flag_information']=1;
		}
		$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();

		if ($_POST) {
			$konfirmasi = $this->input->post('konfirmasi');

			$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('invoice_confirm',$konfirmasi)->update('tb_toko');
			if ($update) {
				redirect('toko/step7');
			}
		}

		$this->template->bonobo_step("enduser/toko/bg_konfirmasi",$data);
	}
	
	function complete_step(){
		$this->db->where('id',$_SESSION['bonobo']['id'])->set('flag_information',1)->update('tb_toko');
		$result=$this->model_toko->get_byflag_information($_SESSION['bonobo']['id'])->num_rows();
		$_SESSION['bonobo']['flag_information']=0;
		if($result>0){
			$_SESSION['bonobo']['flag_information']=1;
		}
		redirect('toko');
	}
}

