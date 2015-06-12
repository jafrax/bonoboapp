<?php 

class Model_bookmark_product extends CI_model{
   
   function get_all_by_user($user_id){
	 	return $this->db
				->select("bookmark.id as bookmark_id, user.id as user_id,company.hastag hastag, user.fullname as user_fullname, product.id as product_id, product.name as product_name, product.user_id as product_user_id, (select pi.image from tb_product_image pi where pi.product_id = product.id limit 1 offset 0) as product_image, product.price_currency as product_price_currency, product.price_min as product_price_min, product.price_max as product_price_max, product.price_unit as product_price_unit, product.min_order_qty as product_order_qty, product.min_order_unit as product_order_unit, product.message_type as product_message_type, product.message_user_id as product_message_user_id, company.id as company_id, company.name as company_name, company.verified as company_verified, country.name as company_country, city.name as company_city, (SELECT count(*) FROM tb_follow_company fc where fc.user_id = ".$user_id." and fc.company_id = company.id) as follows")
				->join("tb_user user","bookmark.user_id = user.id")
				->join("tb_product product","bookmark.product_id = product.id")
				->join("tb_company company","product.company_id = company.id")
				->join("countries country","company.country_id = country.code","LEFT")
				->join("cities city","company.city_id = city.ID","LEFT")
				->where("bookmark.user_id",$user_id)
				->get("tb_bookmark_product bookmark");
   }
   
   function get_limit_by_user($user_id,$limit,$offset){
		return $this->db
				->select("company.gold_date gold_date,product.user_id u_id,bookmark.id as bookmark_id,company.hastag hastag, user.id as user_id, user.fullname as user_fullname, product.id as product_id, product.name as product_name, product.user_id as product_user_id, (select pi.image from tb_product_image pi where pi.product_id = product.id limit 1 offset 0) as product_image, product.price_currency as product_price_currency, product.price_min as product_price_min, product.price_max as product_price_max, product.price_unit as product_price_unit, product.min_order_qty as product_order_qty, product.min_order_unit as product_order_unit, product.message_type as product_message_type, product.message_user_id as product_message_user_id, company.id as company_id, company.name as company_name, company.verified as company_verified, country.name as company_country, city.name as company_city, (SELECT count(*) FROM tb_follow_company fc where fc.user_id = '".$user_id." and fc.company_id = company.id') as follows")
				->join("tb_user user","bookmark.user_id = user.id")
				->join("tb_product product","bookmark.product_id = product.id")
				->join("tb_company company","product.company_id = company.id")
				->join("countries country","company.country_id = country.code","LEFT")
				->join("cities city","company.city_id = city.ID","LEFT")
				->where("bookmark.user_id",$user_id)
				->limit($limit,$offset)
				->get("tb_bookmark_product bookmark");
   }
   
   function get_by_user_product($user_id,$product_id){
		return $this->db
				->select("company.hastag hastag,bookmark.id as bookmark_id, user.id as user_id, user.fullname as user_fullname, product.id as product_id, product.name as product_name, product.user_id as product_user_id, (select pi.image from tb_product_image pi where pi.product_id = product.id limit 1 offset 0) as product_image, product.price_currency as product_price_currency, product.price_min as product_price_min, product.price_max as product_price_max, product.price_unit as product_price_unit, product.min_order_qty as product_order_qty, product.min_order_unit as product_order_unit, product.message_type as product_message_type, product.message_user_id as product_message_user_id, company.id as company_id, company.name as company_name, company.verified as company_verified, country.name as company_country, city.name as company_city, (SELECT count(*) FROM tb_follow_company fc where fc.user_id = ".$user_id." and fc.company_id = company.id) as follows")
				->join("tb_user user","bookmark.user_id = user.id")
				->join("tb_product product","bookmark.product_id = product.id")
				->join("tb_company company","product.company_id = company.id")
				->join("countries country","company.country_id = country.code","LEFT")
				->join("cities city","company.city_id = city.ID","LEFT")
				->where("bookmark.user_id",$user_id)
				->where("bookmark.product_id",$product_id)
				->get("tb_bookmark_product bookmark");
   }
   
   function save($object){
		if(empty($object["id"])){
			return $this->db->insert("tb_bookmark_product",$object);
		}else{
			return $this->db->where("id",$object["id"])->update("tb_bookmark_product",$object);
		}
   }
   
   function delete($id){
		return $this->db->where("id",$id)->delete("tb_bookmark_product");
   }
   
}
