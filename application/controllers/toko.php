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
		$this->load->model("enduser/model_nota");
		$this->template->cek_license();
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			redirect('index/');
			return;
		}

    }
	
	public function index(){
		$step=$_SESSION['bonobo']['step'];
			if($step != 0){
				$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('step',1)->update('tb_toko');
			}
		$data["Categories"] = $this->model_category->get()->result();
		$data["Provinces"] = $this->model_location->get_provinces()->result();
		$data["Cities"] = $this->model_location->get_cities()->result();
		$data["Kecamatans"] = $this->model_location->get_kecamatans()->result();
		$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
		$data["Shopp"] = $this->model_toko->get_alamat($_SESSION['bonobo']['id']);
		$data["Attributes"] = $this->model_toko_attribute->get_by_shop($_SESSION["bonobo"]["id"])->result();
		
		$this->template->bonobo_step("enduser/toko/bg_step_1",$data);
	}

	public function dostep1deletekontak(){
		if($this->response->post("id") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang dipilih","messageCode"=>1));
			return;
		}
		
		$Delete = $this->db->where("id",$this->response->post("id"))->delete("tb_toko_attribute");
		if($Delete){
			$this->response->send(array("result"=>1,"message"=>"Data telah dihapus","messageCode"=>1));
		}else{
			$this->response->send(array("result"=>0,"message"=>"Tidak dapat dihapus","messageCode"=>1));
		}
	}

	public function rules_pin(){
		$username = $_REQUEST['txtTagname'];
		$valid = "true";		
	    $cek=$this->db->where('tag_name',$username)->get('tb_toko');

	    if($cek->num_rows()>0){
			$valid = "false";
	    }else{

 			$cek2=$this->db->where('tag_name',$username)->where('id',$_SESSION['bonobo']['id'])-> get('tb_toko');
 			
 			if($cek2->num_rows()>0){

			$valid = "false";

				}else{

			$valid = "true";
	    } }
	    echo $valid;
	}
	
	public function comboboxprov(){
		$Provinces = $this->model_location->get_provinces_by_zipcode($this->response->post("zip_code"))->result();
		
		echo"<select name='cmbProvince' class='selectize'><option value='' disabled selected>Pilih Provinsi</option>";

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
		$step=$_SESSION['bonobo']['step'];
			if($step != 0){
			$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('step',2)->update('tb_toko');
			}
		if(!$_POST){
			$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
		
			$this->template->bonobo_step("enduser/toko/bg_step_2",$data);
		}else{
			$Data = array(
					"privacy"=>$this->response->post("rdgPrivation"),
				);
			$step=$_SESSION['bonobo']['step'];
			if($step != 0){
				$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('step',3)->update('tb_toko');
			}
			$Save = $this->db->where("id",$_SESSION["bonobo"]["id"])->update("tb_toko",$Data);
			
			redirect("toko/step3");
		}
	}
	
	public function step3(){
		$step=$_SESSION['bonobo']['step'];
			if($step != 0){
				$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('step',3)->update('tb_toko');
			}
		if(!$_POST){
			$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
			
			$this->template->bonobo_step("enduser/toko/bg_step_3",$data);
		}else{
			$Data = array(
					"stock_adjust"=>$this->response->post("rdgStock"),
				);
			$step=$_SESSION['bonobo']['step'];
			if($step != 0){
				$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('step',4)->update('tb_toko');
			}
			$Save = $this->db->where("id",$_SESSION["bonobo"]["id"])->update("tb_toko",$Data);
			
			redirect("toko/step4");
		}
	}
	
	public function step4save(){
		if($this->response->post("chkPaymentCash") == "" && $this->response->post("chkPaymentTransfer")  == ""){
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
					"txtLevel2"=>$pm_store_payment,
					"pm_transfer"=>$pm_transfer,
				);
			$step=$_SESSION['bonobo']['step'];
			if($step != 0){
				$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('step',5)->update('tb_toko');
			}
			$Save = $this->db->where("id",$_SESSION["bonobo"]["id"])->update("tb_toko",$Data);
			$this->response->send(array("result"=>1,"message"=>"Data berhasil disimpan","messageCode"=>1));
		}
	}
	
	public function step4(){

		$step=$_SESSION['bonobo']['step'];
			if($step != 0){
				$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('step',4)->update('tb_toko');
			}

			$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
			
			$this->template->bonobo_step("enduser/toko/bg_step_4",$data);

	}
	
	public function step7(){
		$step=$_SESSION['bonobo']['step'];
			if($step != 0){
				$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('step',7)->update('tb_toko');
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
			$step=$_SESSION['bonobo']['step'];
			if($step != 0){
				$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('step',8)->update('tb_toko');
			}	
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
		$step=$_SESSION['bonobo']['step'];
			if($step != 0){
				$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('step',8)->update('tb_toko');
			}
		$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
		$data["Banks"] = $this->model_bank->get()->result();
		$data["ShopBanks"] = $this->model_toko_bank->get_by_shop($_SESSION["bonobo"]["id"])->result();
		
		$this->template->bonobo_step("enduser/toko/bg_step_6",$data);
	}
	
	public function step5(){
		$step=$_SESSION['bonobo']['step'];
			if($step != 0){
				$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('step',5)->update('tb_toko');
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
		
		/*$username = $_REQUEST['txtTagname'];
		$valid = "true";		
	    $cek=$this->db->where('tag_name',$username)->get('tb_toko');

	    if($cek->num_rows()>0){
			$valid = "false";
	    }else{

 			$cek2=$this->db->where('tag_name',$username)->where('id',$_SESSION['bonobo']['id'])-> get('tb_toko');
 			
 			if($cek2->num_rows()>0){

			$valid = "false";

				}else{

			$valid = "true";
	    } }
	    echo $valid;
		
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
		
					
			
			$UploadPath    = 'assets/pic/shop/';
			$Upload = $this->template->upload_picture($UploadPath,"txtShopLogoFile");
			if(!empty($_FILES['txtShopLogoFile']) && isset($_FILES['txtShopLogoFile']['name']) && !empty($_FILES['txtShopLogoFile']['name'])){
			$UploadPath    = 'assets/pic/shop/';
			$Upload = $this->template->upload_picture($UploadPath,"txtShopLogoFile");
			
			if($Upload == 'error'){
				$Unggah = "";

				$this->response->send(array("result"=>0,"message"=>"Ukuran gambar maksimum 1 Mb ! ","messageCode"=>1));

				return;
				redirect("toko/");
			}else{
				$Unggah=$Upload;
				$_SESSION['bonobo']['image'] = $Unggah;
			}
			
			
			$Data = array(
				"name"=>$this->response->post("txtName"),
				"tag_name"=>$this->response->post("txtTagname"),
				"keyword"=>$this->response->post("txtKeyword"),
				"description"=>$this->response->post("txtDescription"),
				"phone"=>$this->response->post("txtPhone"),
				"address"=>$this->response->post("txtAddress"),
				"postal"=>$postal,
				"image"=>$Unggah,
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
				"postal"=>$postal,
				"category_id"=>$Category,
				"location_id"=>$Location,
			);
		}
		$step=$_SESSION['bonobo']['step'];
		if($step != 0){
			$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('step',2)->update('tb_toko');
		}	
			$Save = $this->db->where("id",$_SESSION["bonobo"]["id"])->update("tb_toko",$Data);
			if($Save){

				$_SESSION['bonobo']['name'] = $this->response->post("txtName");
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
		
		$price = str_replace(".", "", str_replace('Rp. ', '', $this->response->post("txtRatePrice"))) ;
		//echo $price;
		if($this->response->post("txtRateId") == ""){
			$Data = array(
					"courier_custom_id"=>$this->response->post("customCourier"),
					"location_to_province"=>$this->response->post("cmbProvince"),
					"location_to_city"=>$this->response->post("cmbCity"),
					"location_to_kecamatan"=>$this->response->post("cmbKecamatan"),
					"price"=> $price,
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
					"price"=>$price,
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
			$this->response->send(array("result"=>1,"id"=>$ShopBank->id,"acc_name"=>$ShopBank->acc_name,"acc_no"=>$ShopBank->acc_no,"bank_name"=>$ShopBank->bank_name,"messageCode"=>1));
		}else{
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang ditemukan","messageCode"=>1));
		}
	}

	public function doStep8Save(){

		
		if($this->response->post("txtName") == ""){
			$this->response->send(array("result"=>0,"message"=>"Nama pemilik rekening masih kosong","messageCode"=>2));
			return;
		}
		
		if($this->response->post("txtNo") == ""){
			$this->response->send(array("result"=>0,"message"=>"Nomor rekening masih kosong","messageCode"=>3));
			return;
		}
		$step=$_SESSION['bonobo']['step'];

		$bank = $this->response->post("cmbBank");
		if ($bank == 'lainnya') {
			$bank = $this->response->post("txtBank");
		}
		
		if($this->response->post("txtId") == ""){
			$Data = array(
					"toko_id"=>$_SESSION["bonobo"]["id"],
					"bank_name"=>$bank,
					"acc_name"=>$this->response->post("txtName"),
					"acc_no"=>$this->response->post("txtNo"),
					"create_date"=>date("Y-m-d H:i:s"),
					"create_user"=>$_SESSION['bonobo']['email'],
					"update_date"=>date("Y-m-d H:i:s"),
					"update_user"=>$_SESSION['bonobo']['email'],
				);
				
				$respon=$this->model_toko->get_rekeningsama2($this->response->post("txtNo"));
				//ori = $respon=$this->model_toko->get_rekeningsama22($this->response->post("txtNo"));
				if($respon > 0){
					$this->response->send(array("result"=>0,"message"=>"Tidak dapat menyimpan data bank, Nomor Rekening telah digunakan di Toko Anda","messageCode"=>5));
				}else{
					$Save = $this->db->insert("tb_toko_bank",$Data);
					if($Save){
						$this->response->send(array("result"=>1,"message"=>"Bank telah disimpan","messageCode"=>4));
					}else{
						$this->response->send(array("result"=>0,"message"=>"Tidak dapat menyimpan data bank","messageCode"=>5));
					}
				}
		}else{
			$Data = array(
					"toko_id"=>$_SESSION["bonobo"]["id"],
					"bank_name"=>$bank,
					"acc_name"=>$this->response->post("txtName"),
					"acc_no"=>$this->response->post("txtNo"),
					"update_user"=>$_SESSION['bonobo']['email'],
				);
			
				$respon=$this->model_toko->get_rekeningsama22($this->response->post("txtNo"));
				if($respon > 0){
					$this->response->send(array("result"=>0,"message"=>"Tidak dapat menyimpan data bank","messageCode"=>5));
				}else{
					$Save = $this->db->where("id",$this->response->post("txtId"))->update("tb_toko_bank",$Data);
					if($Save){
						$this->response->send(array("result"=>1,"message"=>"Bank telah disimpan","messageCode"=>6));
					}else{
						$this->response->send(array("result"=>0,"message"=>"Tidak dapat menyimpan data bank","messageCode"=>7));
					}
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
				
				for ($i=1;$i <= 5;$i++){
					if ($this->response->post("chkLevel".$i) == 1){
						for ($a=1;$a <= 5;$a++){						
							if ($i != $a && $this->response->post("chkLevel".$a) == 1){
								if ($this->response->post("txtLevel".$i) == $this->response->post("txtLevel".$a)){
									$this->response->send(array("result"=>0,"message"=>"Gagal menyimpan. Form tidak boleh kosong " ,"messageCode"=>0));
									//echo json_encode("Data ".$this->response->post("txtLevel".$i)." tidak boleh sama");
									return;
								}
							}
						}
					}
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
				$step=$_SESSION['bonobo']['step'];
				if($step != 0){
					$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('step',6)->update('tb_toko'); 
				}
                      
                $Save = $this->db->where("id",$_SESSION["bonobo"]["id"])->update("tb_toko",$Data);
                if($Save){                     
                        $this->response->send(array("result"=>1,"message"=>"Data telah disimpan","messageCode"=>0));                 
                }else{
                        $this->response->send(array("result"=>0,"message"=>"Data tidak dapat disimpan","messageCode"=>0));
                }
        }
	
	public function comboboxCity(){
		$Cities = $this->model_toko->get_kota($this->input->post("province"))->result();
		echo"<select name='cmbCity' id='cmbCity' onchange=javascript:set_kecamatan() class='selectize cmbCity'><option value='' disabled selected>Pilih Kota</option>";

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
		//$Kecamatans = $this->model_location->get_kecamatans_by_city_province($this->response->post("city"),$this->response->post("province"),$this->response->post("zip_code"))->result();
		$Kecamatans = $this->model_toko->get_kecamatan($this->input->post("kota"))->result();
		echo"<select name='cmbKecamatan' id='tkecamatan' onchange=javacript:set_location() class='selectize cmbKecamatan'><option value='' disabled selected>Pilih Kecamatan</option>";

		foreach($Kecamatans as $Kecamatan){
			echo"<option value='".$Kecamatan->kecamatan."' >".$Kecamatan->kecamatan."</option>";
		}
			
		echo"
			</select>
			<label id='notifKecamatan' class='error' style='display:none;'></label>
			<script>initComboBox();</script>
		";
	}
	
	public function step7ComboboxCity(){
		$Cities = $this->model_location->get_cities_by_provincee($this->response->post("province"))->result();
		
		echo"<p><select name='cmbCity' id='cmbCity' onChange=ctrlShopStep7.loadComboboxKecamatan(); class='selectize'><option value='' disabled selected>Pilih Kota</option>";

		foreach($Cities as $City){
			echo"<option value='".$City->city."'>".$City->city."</option>";
		}
			
		echo"</select></p><script>initComboBox();</script>";
	}
	
	public function step7ComboboxKecamatan(){
		$Kecamatans = $this->model_location->get_kecamatans_by_city_provincee($this->response->post("city"),$this->response->post("province"))->result();
		
		echo"<p><select name='cmbKecamatan' id='cmbKecamatan' class='selectize'><option value='' disabled selected>Pilih Kecamatan</option>";

		foreach($Kecamatans as $Kecamatan){
			echo"<option value='".$Kecamatan->kecamatan."'>".$Kecamatan->kecamatan."</option>";
		}
			
		echo"</select></p><script>initComboBox();</script>";
	}
	
	public function step8ComboboxBank(){
		$Banks = $this->model_bank->get()->result();
		$ShopBank = $this->model_toko_bank->get_by_id($this->response->post("id"))->row();
		
		echo"<select id='cmbBank' name='cmbBank' class='select-standar' onchange=javascript:pilihngebank() ><option value='' disabled selected>Pilih Bank</option>";
		
		foreach($Banks as $Bank){
			if(!empty($ShopBank)){
				if($Bank->id != $ShopBank->bank_id){
					echo"<option value='".$Bank->name."'>".$Bank->name."</option>";
				}
				else{
					
					echo "<option value='".$ShopBank->bank_id."' selected>".$ShopBank->bank_name."</option>";
				}

			}else{
				echo"<option value='".$Bank->name."'>".$Bank->name."</option>";
			}
		}

				echo "<option value='lainnya' >Bank Lainnya</option>";
			
		echo"</select><script>$('.select-standar').chosen();</script>";

		/*echo "<select name='cmbBank' class='browser-default' onchange=javascript:pilihngebank()>
				<option value='Bank BCA' >Bank BCA</option>
				<option value='Bank Mandiri' >Bank Mandiri</option>
				<option value='Bank BNI' >Bank BNI</option>
				<option value='Bank BCA' >Bank BCA</option>
				<option value='Bank BRI' >Bank BRI</option>
				<option value='Bank BTN' >Bank BTN</option>
				<option value='lainnya' >Bank Lainnya</option>
			</select>";*/
	}
	
	public function step8ComboboxBankadd(){
		$Banks = $this->model_bank->get()->result();
		
		echo"<select id='cmbBank' name='cmbBank' class='select-standar' onchange=javascript:pilihngebank() ><option value='' disabled selected>Pilih Bank</option>";
		
		foreach($Banks as $Bank){
				echo"<option value='".$Bank->name."'>".$Bank->name."</option>";
		}
				echo "<option value='lainnya' >Bank Lainnya</option>";
			
		echo"</select><script>$('.select-standar').chosen();</script>";
		/*echo "<select name='cmbBank' class='browser-default' onchange=javascript:pilihngebank()>
				<option value='Bank BCA' >Bank BCA</option>
				<option value='Bank Mandiri' >Bank Mandiri</option>
				<option value='Bank BNI' >Bank BNI</option>
				<option value='Bank BRI' >Bank BRI</option>
				<option value='Bank BTN' >Bank BTN</option>
				<option value='lainnya' >Bank Lainnya</option>
			</select>";*/
	}

	function step6(){
		$data["Shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();

		if ($_POST) {
			$konfirmasi = $this->input->post('konfirmasi');
			$step=$_SESSION['bonobo']['step'];
			if($step != 0){
				$this->db->where('id',$_SESSION['bonobo']['id'])->set('step',7)->update('tb_toko');
			}
			$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('invoice_confirm',$konfirmasi)->update('tb_toko');
			if ($update) {
				redirect('toko/step7');
				
			}
		}

		$this->template->bonobo_step("enduser/toko/bg_konfirmasi",$data);
	}
	
	function complete_step(){
		$this->db->where('id',$_SESSION['bonobo']['id'])->set('flag_information',1)->update('tb_toko');
		$step=$_SESSION['bonobo']['step'];
		if($step != 0){
			$update = $this->db->where('id',$_SESSION['bonobo']['id'])->set('step',0)->update('tb_toko');
		}
		redirect('toko');
	}
	// diabuat oleh adi 04-08-2015
	public function kodepos(){
		$data['postal'] = $this->input->post("txtPostal");
		$data['kecamatan'] = $this->input->post("cmbKecamatan");
		$data['city'] = $this->input->post("cmbCity");
		$data['province'] = $this->input->post("cmbProvince");
		if (($data['province']=='null') and ($data['kecamatan']=='null') and ($data['city']=='null')){
			$kodpe=array('postal_code'=>'Alamat Pos tidak ditemukan');
		}else{
			$kodepos=$this->model_toko->getcode_pos($data)->result();
			foreach($kodepos as $row){
				$kodpe[]=$row->postal_code;
			}
		}
			 echo json_encode($kodpe);
	}
	// diabuat oleh adi 04-08-2015
	function nomer_rekening(){
		$data['bank_name'] 	= $_REQUEST['txtBank'];
		$data['rekeningmu'] 	= $_REQUEST['txtNo'];
		$respon=$this->model_toko->get_rekeningsama($data);
		if($respon > 0){
			$valid = "false";
		}else{
			$valid = "true";
		}
		echo $valid;
	}
	// diabuat oleh adi 04-08-2015
	function ceklevel1(){
		$data 	= $_REQUEST['txtLevel1'];
		$cek	= $this->db->where('level_1_name',$data)->where('id',$_SESSION['bonobo']['id'])->get('tb_toko');
	    if(count($cek->result()) > 0){
			$valid="true";
	    }else{
			$cek	= $this->db->where('level_2_name',$data)->or_where('level_3_name',$data)->or_where('level_4_name',$data)->or_where('level_5_name',$data)->where('id',$_SESSION['bonobo']['id'])->get('tb_toko');
			if(count($cek->result()) > 0){
			$valid = "false";
			}else{
				$valid="true";
			}
	    }
	    echo $valid;
	}
	// diabuat oleh adi 04-08-2015
	function ceklevel2(){
		$data 	= $_REQUEST['txtLevel22'];
		$cek	= $this->db->where('level_2_name',$data)->where('id',$_SESSION['bonobo']['id'])->get('tb_toko');
	    if(count($cek->result())>0){
			$valid="true";
	    }else{
			$cek	= $this->db->where('level_1_name',$data)->or_where('level_3_name',$data)->or_where('level_4_name',$data)->or_where('level_5_name',$data)->where('id',$_SESSION['bonobo']['id'])->get('tb_toko');
			if(count($cek->result())>0){
			$valid = "false";
			}else{
				$valid="true";
			}
	    }
	    echo $valid;
	}
	// diabuat oleh adi 04-08-2015
	function ceklevel3(){
		$data 	= $_REQUEST['txtLevel33'];
		 $cek	= $this->db->where('level_3_name',$data)->where('id',$_SESSION['bonobo']['id'])->get('tb_toko');
	    if(count($cek->result())>0){
			$valid="true";
	    }else{
			$cek	= $this->db->where('level_2_name',$data)->or_where('level_1_name',$data)->or_where('level_4_name',$data)->or_where('level_5_name',$data)->where('id',$_SESSION['bonobo']['id'])->get('tb_toko');
			if(count($cek->result())>0){
			$valid = "false";
			}else{
				$valid="true";
			}
	    }
	    echo $valid;
	}
	// diabuat oleh adi 04-08-2015
	function ceklevel4(){
		$data 	= $_REQUEST['txtLevel44'];
		 $cek	= $this->db->where('level_4_name',$data)->where('id',$_SESSION['bonobo']['id'])->get('tb_toko');
	    if(count($cek->result())>0){
			$valid="true";
	    }else{
			$cek	= $this->db->where('level_2_name',$data)->or_where('level_3_name',$data)->or_where('level_1_name',$data)->or_where('level_5_name',$data)->where('id',$_SESSION['bonobo']['id'])->get('tb_toko');
			if(count($cek->result())>0){
			$valid = "false";
			}else{
				$valid="true";
			}
	    }
	    echo $valid;
	}
	// diabuat oleh adi 04-08-2015
	function ceklevel5(){
		$data 	= $_REQUEST['txtLevel55'];
	    $cek	= $this->db->where('level_5_name',$data)->where('id',$_SESSION['bonobo']['id'])->get('tb_toko');
	    if(count($cek->result())>0){
			$valid="true";
	    }else{
			$cek	= $this->db->where('level_2_name',$data)->or_where('level_3_name',$data)->or_where('level_4_name',$data)->or_where('level_1_name',$data)->where('id',$_SESSION['bonobo']['id'])->get('tb_toko');
			if(count($cek->result())>0){
			$valid = "false";
			}else{
				$valid="true";
			}
	    }
	    echo $valid;
	}
	// diabuat oleh adi 04-08-2015
	public function change_password(){
		if(!$_POST){
			$this->template->bonobo('cp/bg_cp');
		}else{
			$this->form_validation->set_rules('oldpass', '', 'required|min_length[5]|max_length[50]');
			$this->form_validation->set_rules('newpass', '', 'trim|required|min_length[5]|max_length[50]');
			$this->form_validation->set_rules('renewpass', '', 'trim|required|matches[newpass]');
			$msg    = "error";
			$notif  = "";
			if ($this->form_validation->run() == TRUE){
				$id   		= $_SESSION['bonobo']['id'];
				$password   = $this->db->escape_str($this->input->post('oldpass'));
				$cek	= $this->db->where('password',md5($password))->where("id",$id)->get('tb_toko');
				if(count($cek->result())>0){
					$param  = array(
					'password'      => md5($this->input->post('newpass')),
					'update_user'   => $_SESSION['bonobo']['email']
					);
				
				$insert = $this->db->where("id",$id)->update('tb_toko',$param);
					if($insert){
						$msg    = "success";
						$notif  = "Berhasil";
					}
				}else{
					$msg    = "zero";
					$notif  = "Password yang anda masukkan salah";
				}
			}else{
            
				}
			echo json_encode(array("msg"=>$msg,"notif"=>$notif));
			
		}
			
	}
		// diabuat oleh adi 04-08-2015
	function rules_password(){
		$pass 	= $_REQUEST['oldpass'];
		$id   	=$_SESSION['bonobo']['id'];
	    $cek	= $this->db->where('password',md5($pass))->where("id",$id)->get('tb_toko');
	    if(count($cek->result())>0){
			$valid = "true";
	    }else{
			$valid = "false";
	    }
	    echo $valid;
	}

	
}

