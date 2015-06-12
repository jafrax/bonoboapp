<?php 

class Model_feed_like extends CI_model{
   
   function get_by_user_feed($user_id,$feed_id){
		return $this->db
				->where("user_id",$user_id)
				->where("feed_id",$feed_id)
				->get("tb_feed_like");
   }
   
   function get_like_by_user_feed($user_id,$feed_id){
		return $this->db
				->where("user_id",$user_id)
				->where("feed_id",$feed_id)
				->where("status",1)
				->get("tb_feed_like");
   }
   
   function get_unlike_by_user_feed($user_id,$feed_id){
		return $this->db
				->where("user_id",$user_id)
				->where("feed_id",$feed_id)
				->where("status",0)
				->get("tb_feed_like");
   }
   
    function get_like_by_feed($feed_id){
		return $this->db
				->where("feed_id",$feed_id)
				->where("status",1)
				->get("tb_feed_like");
   }
   
   function get_unlike_by_feed($feed_id){
		return $this->db
				->where("feed_id",$feed_id)
				->where("status",0)
				->get("tb_feed_like");
   }
   
   function do_like($user_id,$feed_id){
		$Like = $this->get_by_user_feed($user_id,$feed_id)->row();
		
		if(empty($Like)){
			$data = array(
						"user_id"=>$user_id,
						"feed_id"=>$feed_id,
						"status"=>1,
						"create_user"=>$_SESSION["vertibox"]["username"],
						"create_date"=>date("Y-m-d"),
						"update_user"=>$_SESSION["vertibox"]["username"]
					);
					
			$Save = $this->db->insert("tb_feed_like",$data);
			if($Save){
				$this->model_feed->inc_point($feed_id);
				return true;
			}else{
				return false;
			}
		}else{
			if($Like->status == 0){
				$data = array(
							"status"=>1,
							"update_user"=>$_SESSION["vertibox"]["username"]
						);
						
				$Save = $this->db->where("id",$Like->id)->update("tb_feed_like",$data);
				if($Save){
					$this->model_feed->inc_point($feed_id);				
					$this->model_feed->inc_point($feed_id);
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
   }
   
   function do_unlike($user_id,$feed_id){
		$Like = $this->get_by_user_feed($user_id,$feed_id)->row();
		
		if(empty($Like)){
			$data = array(
						"user_id"=>$user_id,
						"feed_id"=>$feed_id,
						"status"=>0,
						"create_user"=>$_SESSION["vertibox"]["username"],
						"create_date"=>date("Y-m-d"),
						"update_user"=>$_SESSION["vertibox"]["username"]
					);
			
			$Save = $this->db->insert("tb_feed_like",$data);
			if($Save){
				$this->model_feed->dec_point($feed_id);
				return true;
			}else{
				return false;
			}
		}else{
			if($Like->status == 1){
				$data = array(
						"status"=>0,
						"update_user"=>$_SESSION["vertibox"]["username"]
					);
			
				$Save = $this->db->where("id",$Like->id)->update("tb_feed_like",$data);
				if($Save){
					$this->model_feed->dec_point($feed_id);
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
   }
   
   
   
}
