<?php 

class Model_product_category extends CI_model{
   
   function get_by_product($product){
		return $this->db
				->select("PCategory.id as PCategory_id, category.id as category_id, category.name as category_name")
				->join("tb_category category","PCategory.category_id = category.id")
				->where("PCategory.product_id",$product)
				->get("tb_product_category PCategory");
   }
   
}
