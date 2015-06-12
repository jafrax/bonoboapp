<?php 

class Model_feed extends CI_model{
   
   function get_by_id($id){
		return $this->db->where("id",$id)->get("tb_feed")->row();
   }
   
   function inc_point($id){
		if(empty($this->model_setting)){
			$this->load->model("enduser/model_setting");
		}
   
		$Setting = $this->model_setting->get()->row();
		$Feed = $this->get_by_id($id);
		
		if(!empty($Setting) && !empty($Feed)){
			if($Setting->like_flag == "+"){
				$data = array(
						"point"=>$Feed->point+$Setting->like_value,
					);
			}else{
				$data = array(
						"point"=>$Feed->point - $Setting->like_value,
					);
			}	
			return $this->db->where("id",$id)->update("tb_feed",$data);
		}else{
			return false;
		}
   }
   
   function dec_point($id){
		if(empty($this->model_setting)){
			$this->load->model("enduser/model_setting");
		}
   
		$Setting = $this->model_setting->get()->row();
		$Feed = $this->get_by_id($id);
		
		if(!empty($Setting) && !empty($Feed)){
			if($Setting->dislike_flag == "+"){
				$data = array(
						"point"=>$Feed->point+$Setting->dislike_value,
					);
			}else{
				$data = array(
						"point"=>$Feed->point - $Setting->dislike_value,
					);
			}	
			return $this->db->where("id",$id)->update("tb_feed",$data);
		}else{
			return false;
		}
   }

   function get_feed_by_type($id,$type)
   {
   	return $this->db->where('company_id',$id)->where('post_type_id',$type)->get('tb_feed');
   }
}
