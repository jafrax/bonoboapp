<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER ANGGOTA WEBSITE
* This controler for screen anggota
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Heri Siswanto, Create function : index, joinin, invite, members, members_detail, doJoininDelete, doJoininDeletes, doJoininAccept, doJoininReject
* 2. Update 25 Juni 2015 by Heri Siswanto, Create function : blacklist, doMemberDelete, doBlacklistDelete.
*/

set_time_limit (99999999999);

class Anggota extends CI_Controller {
	
	var $limit = 20;
	var $offset = 0;
	
	function __construct(){
    	parent::__construct();
		
		$this->load->model("enduser/model_toko");
		$this->load->model("enduser/model_toko_member");
		$this->load->model("enduser/model_toko_blacklist");
		$this->load->model("enduser/model_joinin");
		$this->load->model("enduser/model_member");
		$this->load->model("enduser/model_member_attribute");
		$this->load->model("enduser/model_member_location");
		
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			redirect('index/');
			return;
		}
		$this->template->cek_license();
    }
	
	private function countNewMember(){
		$count = sizeOf($this->model_member->get_join_news($_SESSION['bonobo']['id'])->result());
		return $count;
	}
	//07-08-2015 create this function
	private function jumlahbacklist(){
		$count = sizeOf($this->model_member->get_bl_member_by_shop($_SESSION['bonobo']['id'])->result());
		return $count;
	}
	
	public function index(){
		$this->joinin();
	}
	
	public function joinin(){
		$data["shop"] = $this->model_member->get_toko_by_id($_SESSION['bonobo']['id'])->row();
		$data["countNewMember"] = $this->countNewMember();
		
		$uri = 3;
		$url='anggota/joinin/';
		$limit=$this->limit;
		$page = $this->uri->segment(3);
		$objects = $this->model_member->get_join_by_shop($_SESSION['bonobo']['id']);
		
		if(!$page){
			$offset = $this->offset;
		}else{
			$offset = $page;
		}
		
		$data['pagination'] = $this->template->paging1($objects,$uri,$url,$limit);
		$data["joinins"] = $this->model_member->get_join_limit_by_shop($_SESSION['bonobo']['id'],$this->limit,$offset)->result();
		
		$this->template->bonobo("anggota/bg_joinin",$data);
	}
	
	public function invite(){
		$data["shop"] = $this->model_member->get_toko_by_id($_SESSION['bonobo']['id'])->row();
		$data["countNewMember"] = $this->countNewMember();
		$data["notif"] = "";
		$data["email"] = $this->response->post("email");
		$data["message"] = $this->response->post("message");
		
		if($_POST && !empty($data["shop"])){
			$valid = true;
			
			
			
			if($data["email"] == ""){
				$data["notif"] = "<label class='text-red'>Email harus diisi !</label>";
				$valid = false;
			}
			
			if($valid){
				$Data = array(
						"toko_id"=>$_SESSION['bonobo']['id'],
						"email"=>$data["email"],
						"message"=>$data["message"],
						"create_date"=>date("Y-m-d H:i:s"),
						"create_user"=>$_SESSION['bonobo']['email'],
						"update_date"=>date("Y-m-d H:i:s"),
						"update_user"=>$_SESSION['bonobo']['email'],
					);
				if($data["email"]!=$_SESSION['bonobo']['email']){
					$Save = $this->db->insert("tb_invite",$Data);
					if($Save){
						$message ="Hi ".$data["email"].",<br><br>
							Anda mendapat undangan untuk bergabung dengan Toko ".$data["shop"]->name.".<br><br>
							<b>Pesan :</b><br>
							<i>\"".$data["message"]."\"</i><br><br>
							<a href='".base_url()."' style='background:#eaeaea;padding:7px;'>BERGABUNG</a><br><br>
							Thanks, Bonobo.com
						";
						
						$this->template->send_email($data["email"],'no-reply@bonobo.com', $message);
					
						$data["notif"] = "Undangan anda telah dikirim ke email : ".$data["email"]."";
						//$data["email"] = "";
						//$data["message"] = "";
						echo json_encode(array("msg"=>'success',"notif"=>$data["notif"] ));
						return false;
					}else{
						$data["notif"] = "Undangan anda tidak dapat dikirim !";
						echo json_encode(array("msg"=>'error',"notif"=>$data["notif"] ));
						return false;
					}
				}else{
						$data["notif"] = "Undangan anda tidak dapat dikirim !";
						echo json_encode(array("msg"=>'error',"notif"=>$data["notif"] ));
						return false;
				}
				
			}
		}
		
		$this->template->bonobo("anggota/bg_invite",$data);
	}
	
	public function members(){
		$data["keyword"] = "";
		$data["shop"] = $this->model_member->get_toko_by_id($_SESSION['bonobo']['id'])->row();
		$data["countNewMember"] = $this->countNewMember();
		
		if($this->response->post("keyword") != ""){
			$data["keyword"] = $this->response->post("keyword");
		}
		
		$data["Members"] = $this->model_member->get_tm_member_by_shop($data["shop"]->id, $data["keyword"])->result();
		
		$this->template->bonobo("anggota/bg_members",$data);
	}
	
	public function blacklist(){
		$data["keyword"] = "";
		$data["shop"] = $this->model_member->get_toko_by_id($_SESSION['bonobo']['id'])->row();
		$data["countNewMember"] = $this->countNewMember();
		
		if($this->response->post("keyword") != ""){
			$data["keyword"] = $this->response->post("keyword");
		}
		
		$data["Members"] = $this->model_member->get_bl_member_by_shop($data["shop"]->id, $data["keyword"])->result();
		$data["jumlahbacklist"] = $this->jumlahbacklist();
		$this->template->bonobo("anggota/bg_blacklist",$data);
	}
	
	public function members_detail(){
		$data["Member"] = $this->model_member->get_by_id($this->response->post("id"))->row();
		
		$this->load->view("enduser/anggota/bg_members_detail",$data);
	}
	// diabuat oleh adi 04-08-2015
	public function members_detail_b(){
		$data["Member"] = $this->model_member->get_by_id($this->response->post("id"))->row();
		
		$this->load->view("enduser/anggota/bg_members_detailb",$data);
	}
	// diabuat oleh adi 07-08-2015
	public function members_detail_ab(){
		$data["Member"] = $this->model_member->get_by_id($this->response->post("id"))->row();
		
		$this->load->view("enduser/anggota/bg_members_detailab",$data);
	}
	
	
	public function doJoininDelete(){
		if($this->response->post("id") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang dipilih","messageCode"=>1));
			return;
		}
		
		$QJoinin = $this->model_member->get_join_by_id($this->response->post("id"))->row();
		if(!empty($QJoinin)){
			$Delete = $this->db->where("id",$QJoinin->id)->delete("tb_join_in");
			if($Delete){
				$this->response->send(array("result"=>1,"message"=>"Data telah dihapus","messageCode"=>2));
			}else{
				$this->response->send(array("result"=>0,"message"=>"Data tidak dapat dihapus","messageCode"=>3));
			}
		}else{
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang ditemukan","messageCode"=>4));
		}
	}
	
	public function doJoininDeletes(){
		if($this->response->post("shop_id") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data toko yang dipilih","messageCode"=>1));
			return;
		}
		
		$QJoinins = $this->model_member->get_join_by_shop($this->response->post("shop_id"))->result();
		if(sizeOf($QJoinins) > 0){
			$Delete = $this->db->where("toko_id",$this->response->post("shop_id"))->delete("tb_join_in");
			if($Delete){
				$this->response->send(array("result"=>1,"message"=>"Data telah dihapus","messageCode"=>2));
			}else{
				$this->response->send(array("result"=>0,"message"=>"Data tidak dapat dihapus","messageCode"=>3));
			}
		}else{
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang ditemukan","messageCode"=>4));
		}
	}
	
	public function doJoininAccept(){
		if($this->response->post("id") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang dipilih","messageCode"=>1));
			return;
		}
		
		if($this->response->post("level") == ""){
			$this->response->send(array("result"=>0,"message"=>"Anda belum memilih level harga","messageCode"=>1));
			return;
		}
		
		$QJoinin = $this->model_member->get_join_by_id($this->response->post("id"))->row();
		if(!empty($QJoinin)){
			$Data = array("status"=>1);
			$Save = $this->db->where("id",$QJoinin->id)->update("tb_join_in",$Data);
			if($Save){
				$Data = array(
						"toko_id"=>$QJoinin->toko_id,
						"member_id"=>$QJoinin->member_id,
						"price_level"=>$this->response->post("level"),
						"create_date"=>date("Y-m-d H:i:s"),
						"create_user"=>$_SESSION['bonobo']['email'],
						"update_date"=>date("Y-m-d H:i:s"),
						"update_user"=>$_SESSION['bonobo']['email'],
					);
					
				$this->db->insert("tb_toko_member",$Data);
			
				$this->response->send(array("result"=>1,"message"=>"Permintaan telah diterima menjadi Anggota toko Anda","messageCode"=>2));
			}else{
				$this->response->send(array("result"=>0,"message"=>"Permintaan tidak dapat diproses","messageCode"=>3));
			}
		}else{
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data permintaan yang ditemukan","messageCode"=>4));
		}
	}
	
	public function doJoininReject(){
		if($this->response->post("id") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang dipilih","messageCode"=>1));
			return;
		}
		
		$QJoinin = $this->model_member->get_join_by_id($this->response->post("id"))->row();
		if(!empty($QJoinin)){
			$Data = array("status"=>2);
			$Save = $this->db->where("id",$QJoinin->id)->update("tb_join_in",$Data);
			if($Save){
				$this->response->send(array("result"=>1,"message"=>"Permintaan telah ditolak menjadi Anggota toko Anda","messageCode"=>2));
			}else{
				$this->response->send(array("result"=>0,"message"=>"Permintaan tidak dapat diproses","messageCode"=>3));
			}
		}else{
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data permintaan yang ditemukan","messageCode"=>4));
		}
	}
	
	public function doMemberDelete(){
		if($this->response->post("id") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang dipilih","messageCode"=>1));
			return;
		}
		
		$QMember = $this->model_member->get_by_id($this->response->post("id"))->row();
		if(!empty($QMember)){
			if($this->response->post("blacklist") == 1){
				$Data = array(
						"toko_id"=>$_SESSION['bonobo']['id'],
						"member_id"=>$QMember->id,
						"create_date"=>date("Y-m-d H:i:s"),
						"create_user"=>$_SESSION['bonobo']['email'],
						"update_date"=>date("Y-m-d H:i:s"),
						"update_user"=>$_SESSION['bonobo']['email'],
					);
					
				$Save = $this->db->insert("tb_toko_blacklist",$Data);
			}
			
			$Delete = $this->db->where("toko_id",$_SESSION['bonobo']['id'])->where("member_id",$QMember->id)->delete("tb_toko_member");
			if($Delete){
				$this->response->send(array("result"=>1,"message"=>"Member telah dihapus dari daftar keanggotaan","messageCode"=>4));
			}else{
				$this->response->send(array("result"=>0,"message"=>"Member tidak dapat di hapus","messageCode"=>4));
			}
		}else{
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang ditemukan","messageCode"=>4));
		}
	}
	
	public function doBlacklistDelete(){
		if($this->response->post("id") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang dipilih","messageCode"=>1));
			return;
		}
		
		$QMember = $this->model_member->get_by_id($this->response->post("id"))->row();
		if(!empty($QMember)){
			$Delete = $this->db->where("toko_id",$_SESSION['bonobo']['id'])->where("member_id",$QMember->id)->delete("tb_toko_blacklist");
			if($Delete){
				$this->response->send(array("result"=>1,"message"=>"Member telah dihapus dari daftar blacklist","messageCode"=>4));
			}else{
				$this->response->send(array("result"=>0,"message"=>"Member tidak dapat di hapus","messageCode"=>4));
			}
		}else{
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang ditemukan","messageCode"=>4));
		}
	}
}

