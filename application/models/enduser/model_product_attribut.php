<?php 

class Model_product_attribut extends CI_model{
   
   function get_by_product($product){
		return $this->db
				->where("product_id",$product)
				->get("tb_product_attribut");
   }
   
  
   
}
