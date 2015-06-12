<?php
class Model_setting extends CI_Model {

	public function get(){
		$setting = null;
		
		$QSetting = $this->db->get("tb_setting")->row();
		if(empty($QSetting)){
			$Save = array(
					"gold_flag"=>"+",
					"gold_value"=>"10",
					"verified_flag"=>"+",
					"verified_value"=>"20",
					"like_flag"=>"+",
					"like_value"=>"1",
					"dislike_flag"=>"-",
					"dislike_value"=>"1",
					"create_user"=>$_SESSION["login_user"]->username,
					"update_user"=>$_SESSION["login_user"]->username,
				);
			$this->save($Save);
			$setting = $this->get();
		}else{
			$setting = $QSetting;
		}
		return $setting;
	}
	
	function save($setting){
		if(empty($setting["id"])){
			return $this->db->insert("tb_setting",$setting);
		}else{
			return $this->db->where("id",$setting["id"])->update("tb_setting",$setting);
		}
	}

}

?>