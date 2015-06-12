<?php
class Model_feedbox extends CI_Model {
	
	public function getfeedAll($pt,$id,$limit=1000000,$offset=0){
		$this->db->select('tb_company.id company_id,tb_user.fullname fullname,tb_company.gold_date gold_date,tb_company.verified_date verified_date, tb_company.verified verified, tb_company.hastag hastag,tb_feed.visitor visitor,tb_feed.user_id user_id,tb_post_type.name name_type,tb_post_type.id type,tb_feed.title title,tb_feed.company_name company,tb_feed.content content,tb_feed.id id,tb_feed_image.image image,tb_feed.create_date date')
						->where('tb_feed.user_id',$id)
						->where('tb_feed.status',1)
						->where('tb_post_type.id =', $pt)
						->limit($limit,$offset)
						->join('tb_feed_image','tb_feed_image.feed_id=tb_feed.id','left')
						->join('tb_post_type','tb_post_type.id=tb_feed.post_type_id')
						->join('tb_company','tb_company.id=tb_feed.company_id','left')
						->join('tb_user','tb_user.id=tb_feed.user_id')
						->group_by("tb_feed.id")
						->order_by("tb_feed.create_date", "desc");
		if (isset($_SESSION['buying_keyword'])) {
			$this->db->like('tb_feed.title',$_SESSION['buying_keyword']);
		}
		if (isset($_SESSION['info_keyword'])) {
			$this->db->like('tb_feed.title',$_SESSION['info_keyword']);
		}
		return	$this->db->get('tb_feed');
	}

	public function getfeedCompany($pt,$id,$limit=1000000,$offset=0){
		$this->db->select('tb_company.id company_id,tb_user.fullname fullname,tb_company.gold_date gold_date,tb_company.verified_date verified_date, tb_company.verified verified,tb_company.hastag hastag,tb_feed.visitor visitor,tb_feed.user_id user_id,tb_post_type.name name_type,tb_post_type.id type,tb_feed.title title,tb_feed.company_name company,tb_feed.content content,tb_feed.id id,tb_feed_image.image image,tb_feed.create_date date')
						->where('tb_feed.company_id',$id)
						->where('tb_feed.status',1)
						->where('tb_post_type.id =', $pt)
						->limit($limit,$offset)
						->join('tb_feed_image','tb_feed_image.feed_id=tb_feed.id','left')
						->join('tb_post_type','tb_post_type.id=tb_feed.post_type_id')
						->join('tb_company','tb_company.id=tb_feed.company_id')
						->join('tb_user','tb_user.id=tb_feed.user_id')
						->group_by("tb_feed.id")
						->order_by("tb_feed.create_date", "desc");
		if (isset($_SESSION['buying_keyword'])) {
			$this->db->like('tb_feed.title',$_SESSION['buying_keyword']);
		}
		return	$this->db->get('tb_feed');
	}

	public function get_type(){
		return $this->db->get('tb_post_type')->result();
	}
	public function get_country(){
		return $this->db->get('tb_country')->result();
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
		return $this->db->where('feed_id',$id)->get('tb_feed_image')->result();
	}
	public function get_image_product($id){
		return $this->db->select('image')->where('product_id',$id)->get('tb_product_image')->result();
	}
	function get_category_new($id){
		return $this->db->select('a.id as cat, b.name, b.id')->join('tb_category b','b.id = a.category_id')->where('a.feed_id',$id)->get('tb_feed_category a')->result();
	}
	public function get_category($id){
		return $this->db->select('tb_feed_category.id id,tb_category.name,tb_category.id')->where('feed_id',$id)->join('tb_category','tb_category.id=category_id')->get('tb_feed_category');
	}
	public function get_id_image($limit,$offset,$id){
		return $this->db->where('feed_id',$id)->limit($offset,$limit)->get('tb_feed_image');
	}
	public function get_verified($id){
		return $this->db->where('id',$id)->get('tb_company');
	}
	public function get_company($company){
		return $this->db->select('n.icon icon,c.*')->join('tb_country n','n.id = c.country_id','left')->where("c.id",$company)->get("tb_company c");
	}
	public function get_product($id){
		$query = $this->db->query("select a.*, c.name as country, e.name as city, d.name as company, d.register_year, d.street, d.product_main, (select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image
								from tb_product a
								join tb_company d on d.id = a.company_id
								left join tb_country c on c.id = a.country_id
								left join tb_city e on e.id = a.city_id								
								where a.id= '$id'");
		return $query;
	}

	public function get_icon($id){
		return $this->db->select('icon')->where('id',$id)->get('tb_country')->row();
	}
}

?>