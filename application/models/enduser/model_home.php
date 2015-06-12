<?php
class Model_home extends CI_Model {
	
	public function getfeedAll($limit=1000000,$offset=0){
		$this->db->select('tb_feed.country_id country_id,tb_company.verified verified,tb_company.gold_date gold_date,tb_company.verified_date verified_date,tb_company.hastag hastag,tb_feed.status status,tb_feed_category.category_id category_id,tb_company.verified,tb_feed.user_id user_id,tb_post_type.id type,tb_post_type.name name_type,tb_feed.title title,tb_feed.company_name company,tb_feed.company_id company_id,tb_feed.content content,tb_feed.id id,tb_feed_image.image image,tb_feed.create_date date')
						->limit($limit,$offset)
						->join('tb_feed_image','tb_feed_image.feed_id=tb_feed.id','left')
						->join('tb_post_type','tb_post_type.id=tb_feed.post_type_id')
						->join('tb_company','tb_company.id=tb_feed.company_id','left')
						->join('tb_feed_category','tb_feed.id=tb_feed_category.feed_id')
						
						->group_by("tb_feed.id")
						->order_by("tb_feed.point", "desc")
						->order_by("tb_feed.id", "desc");

		if ($_SESSION['supply']  == true){$this->db->or_where('tb_post_type.id','2');}
		if ($_SESSION['buy'] 	 == true){$this->db->or_where('tb_post_type.id','1');}
		if ($_SESSION['info'] 	 == true){$this->db->or_where('tb_post_type.id','3');}
		if ($_SESSION['verified']== true && $_SESSION['gold']==false){$this->db->where('tb_company.verified','2');}	
		if ($_SESSION['gold']	 == true && $_SESSION['verified']==false){$this->db->where('tb_company.verified','1');}
		$verified = array('1','2');
		if ($_SESSION['gold']	 == true && $_SESSION['verified']==true){$this->db->where_in('tb_company.verified',$verified);}
		

		if (isset($_SESSION['vertibox']['id'])){
			$this->db->join("tb_follow_category","tb_feed_category.category_id=tb_follow_category.category_id","inner");
			$this->db->where("tb_follow_category.user_id",$_SESSION['vertibox']['id']);
			$this->db->join("tb_feedbox_country","tb_feedbox_country.country_id=tb_feed.country_id");
			$this->db->where("tb_feedbox_country.user_id",$_SESSION['vertibox']['id']);			
		}
		if (isset($_SESSION['country_feed'])){$this->db->where('tb_feed.country_id',$_SESSION['country_feed']);}

		if (isset($_SESSION['vertibox']['id']) && $_SESSION['following']==true){
			$this->db->join('tb_follow_company','tb_follow_company.company_id=tb_feed.company_id');
			$this->db->where('tb_follow_company.user_id',$_SESSION['vertibox']['id']);
		}
		return $this->db->get('tb_feed');
	}

	public function getfeedAll_nofollow($limit=1000000,$offset=0){
		$this->db->select('tb_feed.country_id country_id,tb_company.verified verified,tb_company.gold_date gold_date,tb_company.verified_date verified_date,tb_company.hastag hastag,tb_feed.status status,tb_feed_category.category_id category_id,tb_company.verified,tb_feed.user_id user_id,tb_post_type.id type,tb_post_type.name name_type,tb_feed.title title,tb_company.name company,tb_feed.company_id company_id,tb_feed.content content,tb_feed.id id,tb_feed_image.image image,tb_feed.create_date date')
						->limit($limit,$offset)
						->join('tb_feed_image','tb_feed_image.feed_id=tb_feed.id','left')
						->join('tb_post_type','tb_post_type.id=tb_feed.post_type_id')
						->join('tb_company','tb_company.id=tb_feed.company_id','left')
						->join('tb_feed_category','tb_feed.id=tb_feed_category.feed_id')
						->join('tb_category','tb_category.id=tb_feed_category.category_id')
						->group_by("tb_feed.id")
						
						->order_by("tb_feed.point", "desc")
						->order_by("tb_feed.id", "desc");

		if ($_SESSION['supply']==true){$this->db->or_where('tb_post_type.id','2');}
		if ($_SESSION['buy']==true){$this->db->or_where('tb_post_type.id','1');}
		if ($_SESSION['info']==true){$this->db->or_where('tb_post_type.id','3');}
		if ($_SESSION['verified']==true && $_SESSION['gold']==false){$this->db->where('tb_company.verified','2');}	
		if ($_SESSION['gold']==true && $_SESSION['verified']==false){$this->db->where('tb_company.verified','1');}
		
		$verified = array('1','2');
		if ($_SESSION['gold']==true && $_SESSION['verified']==true){$this->db->where_in('tb_company.verified',$verified);}

		if (isset($_SESSION['country_feed'])){$this->db->where('tb_feed.country_id',$_SESSION['country_feed']);}
		if (isset($_SESSION['country_follow'])){$this->db->where_in('tb_feed.country_id',$_SESSION['country_follow']);}
		if (isset($_SESSION['category_feed'])){$this->db->like('tb_category.code',$_SESSION['category_feed']);}
		if (isset($_SESSION['category_follow'])){$this->db->where_in('tb_feed_category.category_id',$_SESSION['category_follow']);}
		if (isset($_SESSION['blocked'])){$this->db->where_not_in('tb_feed.user_id', $_SESSION['blocked']);}


		if (isset($_SESSION['vertibox']['id']) && $_SESSION['following']==true){
			$this->db->join('tb_follow_company','tb_follow_company.company_id=tb_feed.company_id');
			$this->db->where('tb_follow_company.user_id',$_SESSION['vertibox']['id']);
		}
		return $this->db->get('tb_feed');
	}

	public function get_follow_country(){
		return $this->db->where('user_id',$_SESSION['vertibox']['id'])->get('tb_feedbox_country');
	}

	public function get_follow_country_name(){
		return $this->db->select('b.country_id')
						->where('b.user_id',$_SESSION['vertibox']['id'])
						->get('tb_feedbox_country b');
	}

	public function get_filter($filter,$limit=1000000,$offset=0){
        return $this->db->select('province_id,tb_city.id,tb_city.name,tb_city.code,tb_province.name as province_name')
        				->like('tb_city.name',$filter)
        				->join('tb_province','tb_province.id=province_id')
        				->limit($limit,$offset)
        				->get('tb_city');
    }

	public function get_type(){
		return $this->db->get('tb_post_type')->result();
	}
	public function get_type_row($id){
		return $this->db->where('id',$id)->get('tb_post_type');
	}
	public function get_country(){
		return $this->db->get('countries')->result();
	}
	public function get_city_all(){
		return $this->db->get('tb_city')->result();
	}
	public function get_city($id){
		return $this->db->select('tb_city.name as name,tb_city.id')->join('tb_province','tb_province.id=tb_city.province_id')->join('tb_country','tb_country.id=tb_province.country_id')->where('tb_province.country_id',$id)->get('tb_city')->result();
	}
	public function get_cat($level){
		return $this->db->where('level',$level)->get('tb_category')->result();
	}
	public function get_cat_parent($id){
		return $this->db->where('parent_id',$id)->get('tb_category')->result();
	}
	public function get_category_feed($id){
		return $this->db->where('feed_id',$id)->get('tb_feed_category')->result();
	}
	public function get_category_product($id){
		return $this->db->where('product_id',$id)->get('tb_product_category')->result();
	}
	public function get_category_code($id){
		return $this->db->where('id',$id)->get('tb_category')->row();
	}
	public function get_lv2($id){
		return $this->db->like('code',''.$id.'.','before')->get('tb_category')->row();
	}
	public function get_category_follow($cat,$id){
		return $this->db->where('category_id',$cat)->where('user_id',$id)->get('tb_follow_category')->num_rows();
	}
	public function get_like($par,$id){
		return $this->db->where('feed_id',$id)->where('status',$par)->get('tb_feed_like')->num_rows();
	}
	public function get_one($id){
		return $this->db->where('id',$id)->get('tb_feed');
	}
	public function get_feed($id){
		return $this->db->where('id',$id)->get('tb_feed');
	}
	public function get_image($id){
		return $this->db->select('image')->where('feed_id',$id)->get('tb_feed_image')->row();
	}
	public function get_image_all($id){
		return $this->db->select('image')->where('feed_id',$id)->get('tb_feed_image')->result();
	}
	public function get_follow_company($id_user,$id_company){
		return $this->db->where('user_id',$id_user)->where('company_id',$id_company)->get('tb_follow_company')->num_rows();
	}
	public function get_bookmark_feed($id_user,$id_feed){
		return $this->db->where('user_id',$id_user)->where('feed_id',$id_feed)->get('tb_bookmark_feed')->num_rows();
	}
	public function get_bookmark_product($id_user,$id_feed){
		$feed = $this->get_feed($id_feed)->row();
		return $this->db->where('user_id',$id_user)->where('product_id',$feed->product_id)->get('tb_bookmark_product')->num_rows();
	}
	public function get_bookmark_product2($id_user,$id){
		return $this->db->where('user_id',$id_user)->where('product_id',$id)->get('tb_bookmark_product')->num_rows();
	}
	function insert_bookmark($user_id,$feed_id){
		$data = array(
					"user_id"=>$user_id,
					"feed_id"=>$feed_id,
					"create_user"=>$_SESSION["vertibox"]["username"],
					"create_date"=>date("Y-m-d"),
					"update_user"=>$_SESSION["vertibox"]["username"]
				);
				
		return $this->db->insert("tb_bookmark_feed",$data);
	}

	function insert_bookmark_product($user_id,$product_id){
		$data = array(
					"user_id"=>$user_id,
					"product_id"=>$product_id,
					"create_user"=>$_SESSION["vertibox"]["username"],
					"create_date"=>date("Y-m-d"),
					"update_user"=>$_SESSION["vertibox"]["username"]
				);
				
		return $this->db->insert("tb_bookmark_product",$data);
	}

	public function get_have_like($id_user,$status,$id_feed){
		return $this->db->where('user_id',$id_user)->where('feed_id',$id_feed)->where('status',$status)->get('tb_feed_like')->num_rows();
	}
	public function get_blocked2($id_parent){
		return $this->db->where('user_parent_id',$id_parent)->get('tb_feedbox_blocked');
	}
	public function get_blocked($id_parent,$id_child){
		return $this->db->where('user_parent_id',$id_parent)->where('user_child_id',$id_child)->get('tb_feedbox_blocked')->num_rows();
	}
	public function get_user($id){
		return $this->db->where('id',$id)->get('tb_user');
	}
	public function get_readmore($id){
		return $this->db->select('tb_feed.status status,tb_company.verified verified,tb_company.gold_date gold_date,tb_company.verified_date verified_date,tb_post_type.id type,tb_post_type.name name_type,tb_company.hastag hastag,tb_feed.user_id user_id,tb_feed.title title,tb_feed.company_name company,tb_feed.company_id company_id,tb_feed.content content,tb_feed.id id,tb_feed.create_date date,tb_feed.visitor visitor')
						->join('tb_post_type','tb_post_type.id=tb_feed.post_type_id')
						->join('tb_company','tb_company.user_id=tb_feed.user_id','left')
						->where('tb_feed.id',$id)
						->get('tb_feed');
	}
	public function get_country_topten(){
		return $this->db->where("interest",1)->order_by('countries.name','asc')->get('countries');
	}
	public function get_country_feed($id){
		return $this->db->where('user_id',$id)->join('countries','countries.code=country_id')->order_by('countries.name','asc')->get('tb_feedbox_country');
	}
	public function get_country_follow($id,$country){
		return $this->db->where('user_id',$id)->where('country_id',$country)->join('countries','countries.code=country_id')->get('tb_feedbox_country');
	}
	public function get_follow_category($id){
		return $this->db->where('user_id',$id)->get('tb_follow_category');
	}
	public function get_follow_category2($id){
		return $this->db->where('user_id',$id)->where('level',2)->join('tb_category a','a.id=b.category_id')->order_by('name','asc')->get('tb_follow_category b');
	}
	public function get_follow_category2_name($id){
		return $this->db->select('b.category_id')->where('user_id',$id)->where('level',2)->join('tb_category a','a.id=b.category_id')->get('tb_follow_category b');
	}
	public function get_id($email){
		return $this->db->where('email',$email)->get('tb_user');
	}
	public function get_already($id1,$id2){
		return $this->db->where('user_parent_id',$id1)->where('user_child_id',$id2)->get('tb_user_contact');
	}
	public function get_hastag($id){
		return $this->db->where('id',$id)->get('tb_company');
	}
	public function get_flag($id){
		return $this->db->where('code',$id)->get('countries');
	}
	public function get_product($product_id){
		return $this->db->where('id',$product_id)->get('tb_product');
	}
}

?>