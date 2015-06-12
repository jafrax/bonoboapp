<?php 

class Model_feed_category extends CI_model{
   
   function get_by_feed($feed){
		return $this->db
				->select("FCategory.id as FCategory_id, category.id as category_id, category.name as category_name, (select tfc.id from tb_follow_category tfc where tfc.category_id = category.id limit 0 offset 1) as follow")
				->join("tb_category category","FCategory.category_id = category.id")
				->where("FCategory.feed_id",$feed)
				->get("tb_feed_category FCategory");
   }
   
}
