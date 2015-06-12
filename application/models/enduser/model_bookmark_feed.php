<?php 

class Model_bookmark_feed extends CI_model{
   
    function get_all_by_user($user_id){
		return $this->db
				->select("company.hastag as hastag,bookmark.id as bookmark_id, user.id as user_id, user.fullname as user_name, feed.id as feed_id, feed.title as feed_name, feed.content as feed_content, feed.status as feed_status, feed.status as feed_type, feed.company_name as feed_company, feed.company_id as feed_company_id, feed.user_id as feed_user_id, company.verified as company_verified, company.verified_date as company_verified_date, company.gold_date as company_gold_date, feed.user_id as feed_user_id, feed.create_date as feed_date, (select tfi.image from tb_feed_image tfi where tfi.feed_id = feed.id limit 1 offset 0) as feed_image, type.name as type_name, (select count(id) from tb_feed_like tfl where tfl.feed_id = feed.id and status = 1) as feed_likes, (select count(id) from tb_feed_like tful where tful.feed_id = feed.id and status = 0) as feed_unlikes")
				->join("tb_user user","bookmark.user_id = user.id")
				->join("tb_feed feed","bookmark.feed_id = feed.id")
				->join("tb_post_type type","feed.post_type_id = type.id")
				->join('tb_company company','feed.company_id = company.id','left')
				->where('type.id !=', '2')
				->where("bookmark.user_id",$user_id)
				->get("tb_bookmark_feed bookmark");
   }
   
   function get_limit_by_user($user_id,$type,$limit,$offset){
		return $this->db
				->select("company.hastag as hastag,bookmark.id as bookmark_id, user.id as user_id, user.fullname as user_name, feed.id as feed_id, feed.title as feed_name, feed.content as feed_content, feed.status as feed_status, feed.company_name as feed_company, feed.company_id as feed_company_id, feed.user_id as feed_user_id, company.verified as company_verified, company.verified_date as company_verified_date, company.gold_date as company_gold_date, feed.user_id as feed_user_id, feed.create_date as feed_date, (select tfi.image from tb_feed_image tfi where tfi.feed_id = feed.id limit 1 offset 0) as feed_image, type.name as type_name,type.id as type_id, (select count(id) from tb_feed_like tfl where tfl.feed_id = feed.id and status = 1) as feed_likes, (select count(id) from tb_feed_like tful where tful.feed_id = feed.id and status = 0) as feed_unlikes")
				->join("tb_user user","bookmark.user_id = user.id")
				->join("tb_feed feed","bookmark.feed_id = feed.id")
				->join("tb_post_type type","feed.post_type_id = type.id")
				->join('tb_company company','feed.company_id = company.id','left')
				->where('type.id', $type)
				->where("bookmark.user_id",$user_id)
				->limit($limit,$offset)
				->get("tb_bookmark_feed bookmark");
   }
   
   function delete($id){
		return $this->db->where("id",$id)->delete("tb_bookmark_feed");
   }
   
}
