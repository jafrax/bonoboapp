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
		
		$this->load->model("enduser/model_category");
		$this->load->model("enduser/model_location");
		$this->load->model("enduser/model_toko");
		$this->load->model("enduser/model_toko_attribute");
		
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
}

