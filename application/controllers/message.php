<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER MESSAGE WEBSITE
* This controler for screen messages
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 25 Juni 2015 by Heri Siswanto, Create function : index
*/

set_time_limit (99999999999);

class Message extends CI_Controller {

	function __construct(){
        parent::__construct();
		
		$this->load->model("enduser/model_toko_message");
		$this->load->model("enduser/model_member");
		
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			redirect('index/');
			return;
		}
    }
	
	public function index(){
		$data["keyword"] = "";
		
		if($this->response->post("keyword") != ""){
			$data["keyword"] = $this->response->post("keyword");
		}
		
		$data["Messages"] = $this->model_toko_message->get_by_shop_grouping($_SESSION["bonobo"]["id"], $data["keyword"])->result();
		
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
		
		$QMember = $this->model_member->get_by_id($this->response->post("id"))->row();
		if(empty($QMember)){
			$this->response->send(array("result"=>0,"message"=>"Member tidak terdaftar","messageCode"=>2));
			return;
		}
		
		if($this->response->post("message") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada pesan yang dikirim","messageCode"=>3));
			return;
		}
		
		$message = $this->response->post("message");
		$email = $_SESSION['bonobo']['email'];
		$date = date("Y-m-d H:i:s");
		
		$Data = array(
				"message"=>$message,
				"create_date"=>$date,
				"create_user"=>$email,
				"update_date"=>$date,
				"update_user"=>$email,
			);
			
		$Save = $this->db->insert("tb_message",$Data);
		if($Save){
			$QMessage = $this->db
							->where("message",$message)
							->where("create_date",$date)
							->where("create_user",$email)
							->where("update_date",$date)
							->where("update_user",$email)
							->get("tb_message")
							->row();
			if(!empty($QMessage)){
				$Data1 = array(
						"toko_id"=>$_SESSION['bonobo']['id'],
						"member_id"=>$QMember->id,
						"message_id"=>$QMessage->id,
						"member_name"=>$QMember->name,
						"flag_from"=>1,
						"flag_read"=>1,
						"create_date"=>$date,
						"create_user"=>$email,
						"update_date"=>$date,
						"update_user"=>$email,
					);
				
				$Data2 = array(
						"toko_id"=>$_SESSION['bonobo']['id'],
						"member_id"=>$QMember->id,
						"message_id"=>$QMessage->id,
						"toko_name"=>$_SESSION['bonobo']['name'],
						"flag_from"=>0,
						"flag_read"=>0,
						"create_date"=>$date,
						"create_user"=>$email,
						"update_date"=>$date,
						"update_user"=>$email,
					);
					
				$Save1 = $this->db->insert("tb_toko_message",$Data1);
				$Save2 = $this->db->insert("tb_member_message",$Data2);
				
				$this->response->send(array("result"=>1,"message"=>"Pesan telah dikirim","messageCode"=>4));
			}else{
				$this->response->send(array("result"=>0,"message"=>"Pesan tidak dapat dikirim","messageCode"=>5));
			}
		}else{
			$this->response->send(array("result"=>0,"message"=>"Pesan tidak dapat dikirim","messageCode"=>6));
		}
	}
}

