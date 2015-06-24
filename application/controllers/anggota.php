<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER ANGGOTA WEBSITE
* This controler for screen anggota
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Heri Siswanto, Create controller
*/

set_time_limit (99999999999);

class Anggota extends CI_Controller {
	
	var $limit = 1;
	var $offset = 0;
	
	function __construct(){
        parent::__construct();
		
		$this->load->model("enduser/model_toko");
		$this->load->model("enduser/model_toko_member");
		$this->load->model("enduser/model_joinin");
		
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			redirect('index/');
			return;
		}
		
    }
	
	private function countNewMember(){
		$count = sizeOf($this->model_joinin->get_news($_SESSION['bonobo']['id'])->result());
		return $count;
	}
	
	public function index(){
		$this->joinin();
	}
	
	public function joinin(){
		$data["shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
		$data["countNewMember"] = $this->countNewMember();
		
		$uri = 3;
		$url='anggota/joinin/';
		$limit=$this->limit;
		$page = $this->uri->segment(3);
		$objects = $this->model_joinin->get_by_shop($_SESSION['bonobo']['id']);
		
		if(!$page){
			$offset = $this->offset;
		}else{
			$offset = $page;
		}
		
		$data['pagination'] = $this->template->paging1($objects,$uri,$url,$limit);
		$data["joinins"] = $this->model_joinin->get_limit_by_shop($_SESSION['bonobo']['id'],$this->limit,$offset)->result();
		
		$this->template->bonobo("anggota/bg_joinin",$data);
	}
	
	public function invite(){
		$data["shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
		$data["countNewMember"] = $this->countNewMember();
		$data["notif"] = "";
		$data["email"] = $this->response->post("email");
		$data["message"] = $this->response->post("message");
		
		if($_POST && !empty($data["shop"])){
			$valid = true;
			
			if($data["message"] == ""){
				$data["notif"] = "<label class='text-red'>Message harus diisi !</label>";
				$valid = false;
			}
			
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
				
				$Save = $this->db->insert("tb_invite",$Data);
				if($Save){
					$message ="Hi ".$data["email"].",<br><br>
						Anda mendapat undangan untuk bergabung dengan Toko ".$data["shop"]->name.".<br><br>
						<b>Pesan :</b><br>
						<i>\"".$data["message"]."\"</i><br><br>
						<a href='".base_url()."' style='background:#eaeaea;padding:7px;'>BERGABUNG</a><br><br>
						Thanks, Bonobo.com
					";
					
					$this->template->send_email($data["email"],'Undangan dari Toko '.$data["shop"]->name, $message);
				
					$data["notif"] = "<label class='text-green'>Undangan anda telah dikirim ke email : ".$data["email"]."</label>";
					$data["email"] = "";
					$data["message"] = "";
				}else{
					$data["notif"] = "<label class='text-red'>Undangan anda tidak dapat dikirim !</label>";
				}
			}
		}
		
		$this->template->bonobo("anggota/bg_invite",$data);
	}
	
	public function members(){
		$data["shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
		$data["countNewMember"] = $this->countNewMember();
		
		$data["members"] = $this->model_toko_member->get_members_by_shop($data["shop"]->id)->result();
		
		$this->template->bonobo("anggota/bg_members",$data);
	}
	
	public function blacklist(){
		$data["shop"] = $this->model_toko->get_by_id($_SESSION['bonobo']['id'])->row();
		$data["countNewMember"] = $this->countNewMember();
		
		$this->template->bonobo("anggota/bg_blacklist",$data);
	}
	
	public function doJoininDelete(){
		if($this->response->post("id") == ""){
			$this->response->send(array("result"=>0,"message"=>"Tidak ada data yang dipilih","messageCode"=>1));
			return;
		}
		
		$QJoinin = $this->model_joinin->get_by_id($this->response->post("id"))->row();
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
		
		$QJoinins = $this->model_joinin->get_by_shop($this->response->post("shop_id"))->result();
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
		
		$QJoinin = $this->model_joinin->get_by_id($this->response->post("id"))->row();
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
		
		$QJoinin = $this->model_joinin->get_by_id($this->response->post("id"))->row();
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
}

