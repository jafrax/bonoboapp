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

	var $limit = 10;
	var $offset = 0;
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
		$this->template->cek_license();
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
				
				
				return $QMessage;
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
		$data["Members"] = $this->model_toko_member->get_member_by_shop($_SESSION["bonobo"]["id"])->result();
		$this->load->view("enduser/message/bg_message_new",$data);
	}
	
	public function showMessageDetail(){
		if($this->response->post("id") == ""){
			echo "Tidak ada pesan yang dipilih";
			return;
		}
		
		$this->db->where("toko_id",$_SESSION["bonobo"]["id"])->where("member_id",$this->response->post("id"))->set("flag_read",1)->update('tb_toko_message');

		$data["Member"] = $this->model_member->get_by_id($this->response->post("id"))->row();
		$data["Messages"] = $this->model_toko_message->get_by_shop_member($_SESSION["bonobo"]["id"],$this->response->post("id"),$this->limit,$this->offset)->result();
		
		$this->load->view("enduser/message/bg_message_detail",$data);
	}

	public function ajax_message()
	{	
		$uri3   = $this->uri->segment(3);
		$member = $this->response->post('member');
		$data["Member"] = $this->model_member->get_by_id($member)->row();
		$data["Messages"] = $this->model_toko_message->get_by_shop_member($_SESSION["bonobo"]["id"],$member,$this->limit,$uri3)->result();
		
		$this->load->view("enduser/message/bg_message_detail_ajax",$data);
	}

	public function showContactDetail(){
		if($this->response->post("id") == ""){
			echo "Tidak ada pesan yang dipilih";
			return;
		}
		$data["keyword"] = "";
		
		if($this->response->post("keyword") != ""){
			$data["keyword"] = $this->response->post("keyword");
		}
		$uri3   = $this->uri->segment(3);
		
		if (empty($uri3)) {
			$offset = $this->offset; 
		}else{
			$offset = $uri3; 
		}
			
		$data["Messages"] = $this->model_toko_message->get_by_shop_grouping($_SESSION["bonobo"]["id"], $data["keyword"], 5 ,$offset);
		
		$this->load->view("enduser/message/bg_message_contact",$data);
	}
	
	public function getUpdateMessageDetail(){
		if($this->response->post("member") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada kontak yang aktif","messageCode"=>1));
			return;
		}
		
		$QMessages = $this->db
				->select("tm.*,ttm.id as toko_message_id")
				->join("tb_message tm","tm.id = ttm.message_id")
				->where("ttm.member_id",$this->response->post("member"))
				->where("ttm.flag_read",0)
				->get("tb_toko_message ttm")
				->result();
		
		if(sizeOf($QMessages) > 0){
			foreach($QMessages as $QMessage){
				$Data = array(
						"flag_read"=>1,
					);
					
				$Save = $this->db->where("id",$QMessage->toko_message_id)->update("tb_toko_message",$Data);
			}
			$this->response->send(array("result"=>1,"messages"=>$QMessages));
		}else{
			$this->response->send(array("result"=>0,"message"=>"Tidak ada pesan baru","messageCode"=>2));
		}
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
		
		$QMessage = $this->doMessageAdd($_SESSION["bonobo"]["id"],$this->response->post("id"),$this->response->post("message"));
		
		if($QMessage != false){
			$Message = array(
					"message"=>$QMessage->message,
					"create_date"=>$this->hs_datetime->getTime4String($QMessage->create_date),
				);
			$this->response->send(array("result"=>1,"message"=>$Message,"messageCode"=>4));
		}else{
			$this->response->send(array("result"=>0,"message"=>"Pesan tidak dapat dikirim","messageCode"=>6));
		}
	}
	
	public function doMessageNewSend(){
		if($this->response->post("checkbox") == "1"){
			if($this->response->post("message") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada pesan yang dikirim","messageCode"=>1));
				return;
			}
			
			$Members = $this->model_toko_member->get_member_by_shop($_SESSION["bonobo"]["id"])->result();
			foreach($Members as $Member){
				$this->doMessageAdd($_SESSION["bonobo"]["id"], $Member->id, $this->response->post("message"));
			}
			
			$this->response->send(array("result"=>1,"message"=>"Pesan telah dikirim","messageCode"=>2));
		}else{
			if($this->response->post("member") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada anggota yang dipilih","messageCode"=>1));
				return;
			}
			
			if($this->response->post("message") == ""){
				$this->response->send(array("result"=>0,"message"=>"Tidak ada pesan yang dikirim","messageCode"=>2));
				return;
			}
			
			
			/*
			* Multiple Email
			*
			
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
			*/
			
			$Save = $this->doMessageAdd($_SESSION["bonobo"]["id"], $this->response->post("member"), $this->response->post("message"));
			if($Save){
				$this->response->send(array("result"=>1,"message"=>"Pesan telah dikirim","messageCode"=>3));
			}else{
				$this->response->send(array("result"=>0,"message"=>"Pesan tidak dapat dikirim","messageCode"=>4));
			}
		}
	}

	public function kirim($tujuan){
		if ($_POST) {
			$email 		= $this->input->post('email');
			$message 	= $this->template->clearInput($this->input->post('message'));

			$Member = $this->model_member->get_by_email($email)->row();
			if(empty($Member)){
				redirect('message');
				return false;
			}

			$date = date("Y-m-d H:i:s");
		
			$Data = array(
					"message"=>$message,
					"create_date"=>$date,
					"create_user"=>$_SESSION['bonobo']['email'],
					"update_user"=>$_SESSION['bonobo']['email'],
				);
				
			$Save = $this->db->insert("tb_message",$Data);
			if($Save){
				$QMessage = $this->db
					->where("message",$message)					
					->where("create_user",$_SESSION['bonobo']['email'])					
					->where("update_user",$_SESSION['bonobo']['email'])
					->get("tb_message")
					->row();
								
				if(!empty($QMessage)){
					$Data1 = array(
							"toko_id"=>$_SESSION['bonobo']['id'],
							"member_id"=>$Member->id,
							"message_id"=>$QMessage->id,
							"member_name"=>$Member->name,
							"flag_from"=>1,
							"flag_read"=>1,
							"create_date"=>$date,
							"create_user"=>$_SESSION['bonobo']['email'],
							"update_date"=>$date,
							"update_user"=>$_SESSION['bonobo']['email'],
						);
					
					$Data2 = array(
							"toko_id"=>$_SESSION['bonobo']['id'],
							"member_id"=>$Member->id,
							"message_id"=>$QMessage->id,
							"toko_name"=>$_SESSION['bonobo']['name'],
							"flag_from"=>0,
							"flag_read"=>0,
							"create_date"=>$date,
							"create_user"=>$_SESSION['bonobo']['email'],
							"update_date"=>$date,
							"update_user"=>$_SESSION['bonobo']['email'],
						);
						
					$Save1 = $this->db->insert("tb_toko_message",$Data1);
					$Save2 = $this->db->insert("tb_member_message",$Data2);
					
					redirect('message');
				}else{
					return false;
				}
			}
		}

		$data["Messages"] = $this->model_toko_message->get_by_shop_grouping($_SESSION["bonobo"]["id"], "");
		$this->template->bonobo("message/bg_message_2",$data);
	}
	
	
}

