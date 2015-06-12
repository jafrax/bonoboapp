<?php 

class Model_product extends CI_model{
   
	function get_by_id_in($ids){
		return $this->db
				->select("product.id as product_id, product.name as product_name, (select pi.image from tb_product_image pi where pi.product_id = product.id limit 1 offset 0) as product_image, product.min_order_qty as product_order_qty, product.min_order_unit as product_order_unit, product.price_currency as product_price_currency, product.price_min as product_price_min, product.price_max as product_price_max, product.price_unit as product_price_unit, product.payment_lc as product_payment_lc, product.payment_da as product_payment_da, product.payment_tt as product_payment_tt, product.payment_wu as product_payment_wu, product.payment_other as product_payment_other, company.id as company_id, company.name as company_name, company.product_main as company_main, company.supplier as company_supplier, company.buyer as company_buyer, country.name as country_name, company.hastag")
				->join("tb_company company","product.company_id = company.id")
				->join("tb_country country","company.country_id = country.id", "left")
				->where("product.id IN (".$ids.")")
				->get("tb_product product");
	}
	
	function get_account($id,$company){
		return $this->db->where('id !=',$id)->where('company_id',$company)->order_by('fullname','asc')->get('tb_user')->result();
	}
	
	// ============== product =============//
	function get_product($id){
		$query = $this->db->query("select a.*, (select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image from tb_product a where company_id = '$id' ");
		return $query->result();
	}
	
	function get_product_catalog($id,$filter){
		$query = $this->db
			->query("select a.*, c.name as catalog,
					(select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image
					from tb_product a
					join tb_catalog c on c.id = a.catalog_id
					where a.company_id = '$id'
					and catalog_id ='$filter'");
		return $query->result();
	}
	
	function get_product_catalog_2($id,$catalog){
		$query = $this->db->query("select a.*, (select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image from tb_product a where company_id = '$id' and catalog_id = '$catalog' ");
		return $query->result();
	}
	
	function get_product_catalog_3($id){
		$query = $this->db->query("select a.*, (select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image from tb_product a where company_id = '$id' and catalog_id IS NULL ");
		return $query->result();
	}

	function get_product1($id){
		$query = $this->db->query("select a.*, (select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image from tb_product a where company_id = '$id' ");
		return $query;
	}
	
	function get_product_catalog1($id,$filter){
		$query = $this->db->query("select a.*, (select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image from tb_product a where company_id = '$id' and catalog_id ='$filter'");
		return $query;
	}
	
	function get_product_filter($id,$id_catalog,$filter){
		if($id_catalog != 'all-search'){
			if($filter != 'all-search'){
				$where = " company_id = '$id' and catalog_id ='$id_catalog' and name like '%$filter%' ";
			}else{
				$where = " company_id = '$id' and catalog_id ='$id_catalog' ";
			}
		}else{
			if($filter != 'all-search'){
				$where = " company_id = '$id' and name like '%$filter%' ";
			}else{
				$where = " company_id = '$id' ";
			}
		}
		
		$query = $this->db->query("select a.*, (select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image from tb_product a where $where ");
		//echo $this->db->last_query();
		return $query->result();
	}
	
	function get_product_one($id,$company){
		$query = $this->db->query("select a.*, c.name as country, e.name as city, d.name as company, d.register_year, d.street, d.product_main, (select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image
								from tb_product a
								join tb_company d on d.id = a.company_id
								left join tb_country c on c.id = a.country_id
								left join tb_city e on e.id = a.city_id
								
								where a.id= '$id' and a.company_id = '$company' ");
		return $query->result();
	}
	
	function get_product_attribute($id){
		return $this->db->where('product_id',$id)->get('tb_product_attribut')->result();
	}
	
	function get_product_desc($id){
		return $this->db->where('product_id',$id)->get('tb_product_description')->result();
	}
	
	function get_product_pic($id){
		return $this->db->where('product_id',$id)->get('tb_product_image')->result();
	}
	
	function get_feed_pic($id){
		return $this->db->where('feed_id',$id)->get('tb_feed_image')->result();
	}
	
	function get_catalog($id){
	   return $this->db->where('company_id',$id)->order_by('name','asc')->get('tb_catalog')->result();
	}
	
	function get_catalog_product($id){
	   return $this->db
			->select('a.*')
			->join('tb_product b','a.id = b.catalog_id')
			->where('b.company_id',$id)
			->group_by('b.catalog_id')
			->order_by('a.name','asc')
			->get('tb_catalog a')
			->result();
	}
	
	// ============== category =============//
	function get_cat($level){
		return $this->db->where('level',$level)->get('tb_category');
	}
	
	function get_cat_parent($id){
		return $this->db->where('parent_id',$id)->get('tb_category')->result();
	}
	
	function get_category($id){
		return $this->db->select('a.id as cat, b.name, b.id')->join('tb_category b','b.id = a.category_id')->where('a.product_id',$id)->get('tb_product_category a')->result();
	}
	
	function get_category_feed($id){
		return $this->db->where('feed_id',$id)->get('tb_feed_category')->result();
	}
	
	function get_cat_product($id){
		return $this->db->where('product_id',$id)->get('tb_product_category')->result();
	}
	
	function get_cat_id($id){
		return $this->db->where('id',$id)->get('tb_category')->result();
	}
	
	function get_cat_level_parent($lvl,$prnt=null){
		if($prnt != null){
			$this->db->where('parent_id',$prnt);
		}
		return $this->db->where('level',$lvl)->get('tb_category')->result();
	}
	
	function get_cat_company($id){
		return $this->db->select('a.*, b.name, b.id as id_cat')->join('tb_category b','b.id = a.category_id')->where('a.company_id',$id)->get('tb_company_category a')->result();
	}
  
	function get_by_search_all($keyword="", $category=null){
		$QProduct = $this->db;
		
		if($keyword != "" && $keyword != "all"){
			$QProduct = $QProduct->select("company.gold_date gold_date,product.user_id as user_id,product.id as product_id, product.name as product_name, (select pi.image from tb_product_image pi where pi.product_id = product.id limit 0,1) as product_image, product.price_currency as product_price_currency, product.price_min as product_price_min, product.price_max as product_price_max, product.price_unit as product_price_unit, product.min_order_qty as product_order_qty, product.min_order_unit as product_order_unit, product.message_type as product_message_type, product.message_user_id as product_message_user_id, company.id as company_id, company.name as company_name, company.verified as company_verified, company.hastag, country.name as company_country, city.name as company_city, (MATCH (product.name,product.keyword) AGAINST ('".$keyword."' IN BOOLEAN MODE )) as rank", false);
		}else{
			$QProduct = $QProduct->select("company.gold_date gold_date,product.user_id as user_id,product.id as product_id, product.name as product_name, (select pi.image from tb_product_image pi where pi.product_id = product.id limit 0,1) as product_image, product.price_currency as product_price_currency, product.price_min as product_price_min, product.price_max as product_price_max, product.price_unit as product_price_unit, product.min_order_qty as product_order_qty, product.min_order_unit as product_order_unit, product.message_type as product_message_type, product.message_user_id as product_message_user_id, company.id as company_id, company.name as company_name, company.verified as company_verified, company.hastag, country.name as company_country, city.name as company_city", false);
		}
		
		$QProduct = $QProduct->join("tb_company company","product.company_id = company.id");
		$QProduct = $QProduct->join("tb_company company","product.company_id = company.id");
		$QProduct = $QProduct->join("countries country","product.country_id = country.code","LEFT");
		$QProduct = $QProduct->join("cities city","product.city_id = city.ID","LEFT");
		
		if($keyword != "" && $keyword != "all"){
			$QProduct = $QProduct->where("(MATCH (product.name,product.keyword) AGAINST ('".$keyword."' IN BOOLEAN MODE))");
			
			if(!empty($category)){
				$QProduct = $QProduct->where("product.id IN (SELECT pc.product_id as id FROM tb_product_category pc JOIN tb_category category ON pc.category_id = category.id WHERE category.code LIKE ","'%".$category->code."%')",false);
			}
		}else{
			if(!empty($category)){
				$QProduct = $QProduct->where("product.id IN (SELECT pc.product_id as id FROM tb_product_category pc JOIN tb_category category ON pc.category_id = category.id WHERE category.code LIKE ","'%".$category->code."%')",false);
			}
		}
		$Products = $QProduct->get("tb_product product");
		
		return  $Products;
	}
	
	/* ------------------------------------------------------
	*  REVISI FILTER SEARCH
	*  Vertibox Version 1
	*  1). Keyword juga memfilter field keyword pada product
	*  2). Penambahan order by product.id and company.verified
	*  ------------------------------------------------------
	function get_by_search($keyword="", $category=null, $offset=0, $limit=5){
		$QProduct = $this->db;
		
		if($keyword != "" && $keyword != "all"){
			$QProduct = $QProduct->select("company.gold_date gold_date,product.user_id as user_id,product.id as product_id, product.name as product_name, (select pi.image from tb_product_image pi where pi.product_id = product.id limit 0,1) as product_image, product.price_currency as product_price_currency, product.price_min as product_price_min, product.price_max as product_price_max, product.price_unit as product_price_unit, product.min_order_qty as product_order_qty, product.min_order_unit as product_order_unit, product.message_type as product_message_type, product.message_user_id as product_message_user_id, company.id as company_id, company.name as company_name, company.verified as company_verified, company.hastag, country.name as company_country, city.name as company_city, (MATCH (product.name,product.keyword) AGAINST ('".$keyword."' IN BOOLEAN MODE )) as rank", false);
		}else{
			$QProduct = $QProduct->select("company.gold_date gold_date,product.user_id as user_id,product.id as product_id, product.name as product_name, (select pi.image from tb_product_image pi where pi.product_id = product.id limit 0,1) as product_image, product.price_currency as product_price_currency, product.price_min as product_price_min, product.price_max as product_price_max, product.price_unit as product_price_unit, product.min_order_qty as product_order_qty, product.min_order_unit as product_order_unit, product.message_type as product_message_type, product.message_user_id as product_message_user_id, company.id as company_id, company.name as company_name, company.verified as company_verified, company.hastag, country.name as company_country, city.name as company_city", false);
		}
		
		$QProduct = $QProduct->join("tb_company company","product.company_id = company.id");
		$QProduct = $QProduct->join("countries country","product.country_id = country.code","LEFT");
		$QProduct = $QProduct->join("cities city","product.city_id = city.ID","LEFT");
		
		if($keyword != "" && $keyword != "all"){
			$QProduct = $QProduct->where("((MATCH (product.name,product.keyword) AGAINST ('".$keyword."' IN BOOLEAN MODE)) OR (product.name LIKE '%".$keyword."%' OR product.keyword LIKE '%".$keyword."%'))");
			
			if(!empty($category)){
				$QProduct = $QProduct->where("product.id IN (SELECT pc.product_id as id FROM tb_product_category pc JOIN tb_category category ON pc.category_id = category.id WHERE category.code LIKE ","'%".$category->code."%')", false);
			}
			
			$QProduct = $QProduct->order_by("rank DESC, company.verified DESC, product.id","DESC");
		}else{
			if(!empty($category)){
				$QProduct = $QProduct->where("product.id IN (SELECT pc.product_id as id FROM tb_product_category pc JOIN tb_category category ON pc.category_id = category.id WHERE category.code LIKE ","'%".$category->code."%')",false);
			}
			
			$QProduct = $QProduct->order_by("company.verified DESC, product.id","DESC");
		}
		
		$QProduct = $QProduct->group_by("product.id");
		$QProduct = $QProduct->limit($limit,$offset);
		$Products = $QProduct->get("tb_product product");
		
		return  $Products;
	}
	*/
	
	function get_by_search($keyword="", $category=null, $offset=0, $limit=5){
		$QProduct = $this->db;
		
		if($keyword != "" && $keyword != "all"){
			$QProduct = $QProduct->select("company.gold_date gold_date,product.user_id as user_id,product.id as product_id, product.name as product_name, (select pi.image from tb_product_image pi where pi.product_id = product.id limit 0,1) as product_image, product.price_currency as product_price_currency, product.price_min as product_price_min, product.price_max as product_price_max, product.price_unit as product_price_unit, product.min_order_qty as product_order_qty, product.min_order_unit as product_order_unit, product.message_type as product_message_type, product.message_user_id as product_message_user_id, company.id as company_id, company.name as company_name, company.verified as company_verified, company.hastag, country.name as company_country, city.name as company_city, (MATCH (product.name) AGAINST ('".$keyword."' IN BOOLEAN MODE )) as rank", false);
		}else{
			$QProduct = $QProduct->select("company.gold_date gold_date,product.user_id as user_id,product.id as product_id, product.name as product_name, (select pi.image from tb_product_image pi where pi.product_id = product.id limit 0,1) as product_image, product.price_currency as product_price_currency, product.price_min as product_price_min, product.price_max as product_price_max, product.price_unit as product_price_unit, product.min_order_qty as product_order_qty, product.min_order_unit as product_order_unit, product.message_type as product_message_type, product.message_user_id as product_message_user_id, company.id as company_id, company.name as company_name, company.verified as company_verified, company.hastag, country.name as company_country, city.name as company_city", false);
		}
		
		$QProduct = $QProduct->join("tb_company company","product.company_id = company.id");
		$QProduct = $QProduct->join("countries country","product.country_id = country.code","LEFT");
		$QProduct = $QProduct->join("cities city","product.city_id = city.ID","LEFT");
		
		if($keyword != "" && $keyword != "all"){
			$whereOrName = "";
			if(strlen($keyword) <= 3){
				$whereOrName = "OR (product.name LIKE '%".$keyword."%')";
			}
			
			$QProduct = $QProduct->where("((MATCH (product.name) AGAINST ('".$keyword."' IN BOOLEAN MODE)) ".$whereOrName." )");
			
			if(!empty($category)){
				$QProduct = $QProduct->where("product.id IN (SELECT pc.product_id as id FROM tb_product_category pc JOIN tb_category category ON pc.category_id = category.id WHERE category.code LIKE ","'%".$category->code."%')", false);
			}
			
			$QProduct = $QProduct->order_by("rank DESC, product.id DESC, company.verified","DESC");
		}else{
			if(!empty($category)){
				$QProduct = $QProduct->where("product.id IN (SELECT pc.product_id as id FROM tb_product_category pc JOIN tb_category category ON pc.category_id = category.id WHERE category.code LIKE ","'%".$category->code."%')", false);
			}
			
			$QProduct = $QProduct->order_by("product.id DESC, company.verified","DESC");
		}
		
		$QProduct = $QProduct->group_by("product.id");
		$QProduct = $QProduct->limit($limit,$offset);
		$Products = $QProduct->get("tb_product product");
		
		return  $Products;
	}
	
    function get_by_query($query){
		$hasil = $this->db->query($query);
		return $hasil;
   }

   	public function get_bookmark_product($id_user,$id_product){
		return $this->db->where('user_id',$id_user)->where('product_id',$id_product)->get('tb_bookmark_product')->num_rows();
	}

	function insert_bookmark($user_id,$feed_id){
		$data = array(
					"user_id"=>$user_id,
					"product_id"=>$feed_id,
					"create_user"=>$_SESSION["vertibox"]["username"],
					"create_date"=>date("Y-m-d"),
					"update_user"=>$_SESSION["vertibox"]["username"]
				);
				
		return $this->db->insert("tb_bookmark_product",$data);
	}

	public function get_one($id){
		return $this->db->where('id',$id)->get('tb_product');
	}

	public function get_company($id){
		return $this->db->where('id',$id)->get('tb_company')->row();
	}

	public function get_country($id){
		return $this->db->where('code',$id)->get('countries')->row();
	}

	public function get_product_by_company($id,$keyword){
		return $this->db->where('company_id',$id)->like('name',$keyword)->get('tb_product');
	}
	
	function get_feed($id){
		return $this->db->where('product_id',$id)->get('tb_feed')->result();
	}

	public function get_image($id){
		return $this->db->where('product_id',$id)->get('tb_product_image');
	}
}
