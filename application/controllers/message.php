<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER MESSAGE WEBSITE
* This controler for screen messages
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 25 Juni 2015 by Heri Siswanto, Create function : index, showNewMessage, showMessageDetail, doDelete, doDeletes, doMessageReads, doMessageSend, doMessageNewSend, doMessageAdd
*/

set_time_limit (99999999999);

class Message extends CI_Controller {

	function __construct(){
        parent::__construct();
		
		$this->load->model("enduser/model_toko");
		$this->load->model("enduser/model_toko_member");
		$this->load->model("enduser/model_toko_message");
		$this->load->model("enduser/model_member");
		
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			redirect('index/');
			return;
		}
    }
	
	
	private function doMessageAdd($ShopId,$MemberId,$Message){
		$Shop = $this->model_toko->get_by_id($ShopId)->row();
		if(empty($Shop)){
			return false;
		}
		
		$Member = $this->model_member->get_by_id($MemberId)->row();
		if(empty($Member)){
			return false;
		}
		
		$date = date("Y-m-d H:i:s");
		
		$Data = array(
				"message"=>$Message,
				"create_date"=>$date,
				"create_user"=>$Shop->email,
				"update_date"=>$date,
				"update_user"=>$Shop->email,
			);
			
		$Save = $this->db->insert("tb_message",$Data);
		if($Save){
			$QMessage = $this->db
				->where("message",$Message)
				->where("create_date",$date)
				->where("create_user",$Shop->email)
				->where("update_date",$date)
				->where("update_user",$Shop->email)
				->get("tb_message")
				->row();
							
			if(!empty($QMessage)){
				$Data1 = array(
						"toko_id"=>$Shop->id,
						"member_id"=>$Member->id,
						"message_id"=>$QMessage->id,
						"member_name"=>$Member->name,
						"flag_from"=>1,
						"flag_read"=>1,
						"create_date"=>$date,
						"create_user"=>$Shop->email,
						"update_date"=>$date,
						"update_user"=>$Shop->email,
					);
				
				$Data2 = array(
						"toko_id"=>$Shop->id,
						"member_id"=>$Member->id,
						"message_id"=>$QMessage->id,
						"toko_name"=>$Shop->name,
						"flag_from"=>0,
						"flag_read"=>0,
						"create_date"=>$date,
						"create_user"=>$Shop->email,
						"update_date"=>$date,
						"update_user"=>$Shop->email,
					);
					
				$Save1 = $this->db->insert("tb_toko_message",$Data1);
				$Save2 = $this->db->insert("tb_member_message",$Data2);
				
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function index(){
		$data["keyword"] = "";
		
		if($this->response->post("keyword") != ""){
			$data["keyword"] = $this->response->post("keyword");
		}
		
		$data["Messages"] = $this->model_toko_message->get_by_shop_grouping($_SESSION["bonobo"]["id"], $data["keyword"]);
		
		$this->template->bonobo("message/bg_message",$data);
	}
	
	public function showNewMessage(){
		$this->load->view("enduser/message/bg_message_new");
	}
	
	public function showMessageDetail(){
		if($this->response->post("id") == ""){
			echo "Tidak ada pesan yang dipilih";
			return;
		}
		
		$data["Member"] = $this->model_member->get_by_id($this->response->post("id"))->row();
		$data["Messages"] = $this->model_toko_message->get_by_shop_member($_SESSION["bonobo"]["id"],$this->response->post("id"))->result();
		
		$this->load->view("enduser/message/bg_message_detail",$data);
	}
	
	public function doDelete(){
		if($this->response->post("id") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang dipilih","messageCode"=>1));
			return;
		}
		
		$Delete = $this->db
					->where("member_id",$this->response->post("id"))
					->where("toko_id",$_SESSION["bonobo"]["id"])
					->delete("tb_toko_message");
		
		if($Delete){
			$this->response->send(array("result"=>1,"message"=>"Pesan telah dihapus","messageCode"=>2));
		}else{
			$this->response->send(array("result"=>0,"message"=>"Pesan tidak dapat dihapus","messageCode"=>3));
		}
	}
	
	public function doDeletes(){
		$Delete = $this->db
					->where("toko_id",$_SESSION["bonobo"]["id"])
					->delete("tb_toko_message");
		
		if($Delete){
			$this->response->send(array("result"=>1,"message"=>"Semua pesan telah dihapus","messageCode"=>1));
		}else{
			$this->response->send(array("result"=>0,"message"=>"Pesan tidak dapat dihapus","messageCode"=>2));
		}
	}
	
	public function doMessageReads(){
		$Update = $this->db
					->set("flag_read",1)
					->where("toko_id",$_SESSION["bonobo"]["id"])
					->update("tb_toko_message");
		
		if($Update){
			$this->response->send(array("result"=>1,"message"=>"Semua pesan telah terbaca","messageCode"=>1));
		}else{
			$this->response->send(array("result"=>0,"message"=>"Pesan tidak dapat diubah","messageCode"=>2));
		}
	}
	
	public function doMessageSend(){
		if($this->response->post("id") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang dipilih","messageCode"=>1));
			return;
		}
		
		if($this->response->post("message") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada pesan yang dikirim","messageCode"=>3));
			return;
		}
		
		$Save = $this->doMessageAdd($_SESSION["bonobo"]["id"],$this->response->post("id"),$this->response->post("message"));
		
		if($Save){
			$this->response->send(array("result"=>1,"message"=>"Pesan telah dikirim","messageCode"=>4));
		}else{
			$this->response->send(array("result"=>0,"message"=>"Pesan tidak dapat dikirim","messageCode"=>6));
		}
	}
	
	public function doMessageNewSend(){
		if($this->response->post("checkbox") == "1"){
			if($this->response->post("message") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada pesan yang dikirim","messageCode"=>3));
				return;
			}
			
			$Members = $this->model_toko_member->get_member_by_shop($_SESSION["bonobo"]["id"])->result();
			foreach($Members as $Member){
				$this->doMessageAdd($_SESSION["bonobo"]["id"], $Member->id, $this->response->post("message"));
			}
			
			$this->response->send(array("result"=>1,"message"=>"Pesan telah dikirim","messageCode"=>3));
		}else{
			if($this->response->post("emails") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada email tujuan","messageCode"=>1));
				return;
			}
			
			if($this->response->post("message") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada pesan yang dikirim","messageCode"=>3));
				return;
			}
			
			$pEmails = explode(",",$this->response->post("emails"));
			$Emails = "";
			for($i = 0 ; $i < count($pEmails); $i++){
				$Emails = $Emails."'".$pEmails[$i]."',";
			}
			$Emails = $Emails."#";
			$Emails = str_replace(",#","",$Emails);
						
			$Members = $this->model_toko_member->get_member_by_emails($_SESSION["bonobo"]["id"],$Emails)->result();
			foreach($Members as $Member){
				$this->doMessageAdd($_SESSION["bonobo"]["id"], $Member->id, $this->response->post("message"));
			}
			
			$this->response->send(array("result"=>1,"message"=>"Pesan telah dikirim","messageCode"=>3));
		}
	}
	
	
}

