<?php
class Model_company extends CI_Model {
	//=========== New Model =============//
	public function get_company_name($company){
		return $this->db->select('tb_company.*, a.name country,b.name province,c.name city')
			->join('countries a','a.code = tb_company.country_id','left')
			->join('regions b','b.code = tb_company.province_id and tb_company.country_id = b.country','left')
			->join('cities c','c.ID = tb_company.city_id','left')
			->where("tb_company.hastag",$company)
			->get("tb_company")
			->result();
	}
	
	public function get_company_by_id($company){
		return $this->db->select('tb_company.*, a.name country,b.name province,c.name city')
			->join('countries a','a.code = tb_company.country_id','left')
			->join('regions b','b.code = tb_company.province_id and tb_company.country_id = b.country','left')
			->join('cities c','c.ID = tb_company.city_id','left')
			->where("tb_company.id",$company)
			->get("tb_company")
			->result();
	}
	
	public function get_company_name_2($company){
		return $this->db->select('tb_company.*, a.name country,b.name province,c.name city')
			->join('countries a','a.code = tb_company.country_id','left')
			->join('regions b','b.code = tb_company.province_id and tb_company.country_id = b.country','left')
			->join('cities c','c.ID = tb_company.city_id','left')
			->where("tb_company.id",$company)
			->get("tb_company")
			->row();
	}
	
	public function get_phone($id){
		$phone = $this->db->where('company_id',$id)->get('tb_company_phone')->result();
		return $phone;
	}
	
	function get_user_company($id){
        return $this->db
			->select('a.*, b.name')
			->join('tb_company b','b.id = a.company_id')
			->where('company_id',$id)
			->where('user_group_id',2)
			->get('tb_user a')
			->result();
    }
	
	function cek_user_company($company,$user,$email){
		return $this->db
			->select('a.*, b.name')
			->join('tb_company b','b.id = a.company_id')
			->where('company_id',$company)
			->where('a.id',$user)
			->where('a.email',$email)
			->where('user_group_id',2)
			->get('tb_user a')
			->result();
	}
	
	function get_user($id){
        return $this->db->select('a.*, b.name as company, b.verified')
            ->join('tb_company b','b.id = a.company_id','left')
            ->where('a.id',$id)
            ->get('tb_user a')
			->result();
    }
	
	function get_user_email($email){
        return $this->db->select('a.*, b.name as company, b.verified')
            ->join('tb_company b','b.id = a.company_id','left')
            ->where('a.email',$email)
            ->get('tb_user a')
			->result();
    }
	
	function get_user_contact($id){
        return $this->db->where('user_id',$id)->get('tb_user_attribut')->result();
    }
	
	function get_user_contact_2($id){
        return $this->db
			->select("company.id company_id,company.hastag hastag,child.fullname name,child.position position,child.phone phone,child.email email,contact.id id,parent.id as parent_id, SUBSTR(parent.fullname, 1, 25) as parent_name, parent.image as parent_image, child.id as child_id, SUBSTR(child.fullname, 1, 25) as child_name, child.image as child_image, SUBSTR(company.name, 1, 25) as company_name",false)
			->join("tb_user parent","contact.user_parent_id = parent.id")
			->join("tb_user child","contact.user_child_id = child.id")
			->join("tb_company company","child.company_id = company.id","left")
			->where("contact.user_parent_id",$id)
			->order_by("child_name", "asc")
			->get("tb_user_contact contact")
			->result();
    }
	
	/*
	function get_country(){
		return $this->db->order_by('name','asc')->get('tb_country')->result();
	}
	*/
	
	// ============== country =============//
	function get_country(){
		//$this->db->cache_on();
		return $this->db
			->where('code !=','')
			->order_by('name','asc')
			->get('countries')
			->result();
	}
	
	function get_regions($id){
		return $this->db
			->where('country',$id)
			->where('name !=','')
			->order_by('name','asc')
			->get('regions')
			->result();
	}
	
	function get_cities($country,$region=null){
		if($region != null){
			$this->db->where('region',$region);
		}
		return $this->db
			->where('country',$country)
			->where('name !=','')
			->order_by('name','asc')
			->get('cities')
			->result();
	}

	function get_cities2($region){

		return $this->db->where('region',$region)
						->where('name !=','')
						->order_by('name','asc')
						->get('cities')
						->result();
	}
	
	// ====================================//
	
	// ============== product =============//
	function get_product($id){
		$query = $this->db->query("select a.*, (select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image from tb_product a where company_id = '$id' ");
		return $query->result();
	}
	
	function get_product_sort($id,$sort){
		if($sort == "asc"){
			$sort = "order by name asc";
		}
		else{
			$sort = "order by id desc";
		}
		$query = $this->db->query("select a.*, (select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image from tb_product a where company_id = '$id' $sort ");
		return $query->result();
	}
	
	function get_product_detail($id,$company){
		$query = $this->db->query("select a.*, c.name as country, e.name as city, d.hastag, d.name as company, d.register_year, d.street, d.product_main, (select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image
								from tb_product a
								join tb_company d on d.id = a.company_id
								left join countries c on c.code = a.country_id
								left join cities e on e.ID = a.city_id
								
								where a.id= '$id' and a.company_id = '$company' ");
		return $query->result();
	}
	
	public function get_product_recomended($id,$category,$limit=10,$offset=0){
		//$this->db->cache_on();
		return $this->db->select('p.*,a.image image')
			->join('tb_product_image a','a.product_id=p.id','left')
			->group_by('p.id')
			->where("company_id",$id)
			->where("p.id !=",$category)
			->limit($limit,$offset)
			->order_by("id","random")
			->get("tb_product p")
			->result();
	}
	
	function get_product_catalog($id,$catalog){
		$query = $this->db->query("select a.*, (select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image from tb_product a where company_id = '$id' and catalog_id = '$catalog' ");
		return $query->result();
	}
	
	/*function get_product_uncatalogue($id,$catalog_id){
		$query = $this->db->query("select a.*, (select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image from tb_product a where company_id = '$id' and catalog_id not in ( '" . implode($catalog_id, "', '") . "' ) ");
		return $query->result();
	}*/
	function get_product_uncatalogue($id,$catalog_id){
		$query = $this->db->query("select a.*, (select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image from tb_product a where company_id = '$id' and catalog_id is null ");
		return $query->result();
	}
	
	function get_catalog($id){
	   return $this->db->where('company_id',$id)->order_by('name','asc')->get('tb_catalog')->result();
	}
	
	function get_catalog_product($id,$catalog_id){
	   return $this->db
			->select('a.*')
			->join('tb_product b','a.id = b.catalog_id')
			->where('b.company_id',$id)
			->where_in('b.catalog_id',$catalog_id)
			->group_by('b.catalog_id')
			->order_by('a.name','asc')
			->get('tb_catalog a')
			->result();
	}
	
	function get_catalog_product_filter($filter,$id){
	   return $this->db
			->select('a.*')
			->join('tb_product b','a.id = b.catalog_id')
			->where('b.company_id',$id)
			->where('b.catalog_id',$filter)
			->group_by('b.catalog_id')
			->order_by('a.name','asc')
			->get('tb_catalog a')
			->result();
	}
	
	function get_filter_catalog_product($filter,$id,$catalog_id){
		//$where = " company_id = '$id' and catalog_id = '$catalog' ";
		if($filter != 'all-search'){
			$this->db->like('b.name',$filter);
		}
		
		return $this->db
			->select('a.*')
			->join('tb_product b','a.id = b.catalog_id')
			->where('b.company_id',$id)
			->where_in('b.catalog_id',$catalog_id)
			->group_by('b.catalog_id')
			->order_by('a.name','asc')
			->get('tb_catalog a')
			->result();
	}
	
	function get_filter_product_uncatalogue($filter,$id,$catalog_id){
		$where = " ";
		if($filter != 'all-search'){
			$where = " and name like '%$filter%' ";
		}
		$query = $this->db->query("select a.*, (select image from tb_product_image b where a.id = b.product_id order by b.id asc limit 1) as image from tb_product a where company_id = '$id' and catalog_id is null $where ");
		return $query->result();
	}
	
	function get_account($id,$company){
		return $this->db->where('id !=',$id)->where('company_id',$company)->order_by('fullname','asc')->get('tb_user')->result();
	}
	
	function get_product_category($id){
		return $this->db->select('a.id as cat, b.name, b.id')->join('tb_category b','b.id = a.category_id')->where('a.product_id',$id)->get('tb_product_category a')->result();
	}
	
	function get_product_pic($id){
		return $this->db->where('product_id',$id)->get('tb_product_image')->result();
	}
	
	function get_product_attribute($id){
		return $this->db->where('product_id',$id)->get('tb_product_attribut')->result();
	}
	
	function get_product_desc($id){
		return $this->db->where('product_id',$id)->get('tb_product_description')->result();
	}
	
	function get_feed($id){
		return $this->db->where('product_id',$id)->get('tb_feed')->result();
	}
	
	function get_feed_pic($id){
		return $this->db->where('feed_id',$id)->get('tb_feed_image')->result();
	}
	
	function get_category_feed($id){
		return $this->db->where('feed_id',$id)->get('tb_feed_category')->result();
	}
	
	//=========================================
	
	// ============== category =============//
	function get_category($level=1){
		return $this->db->where('level',$level)->get('tb_category')->result();
	}
	
	function get_category_prnt($id){
		return $this->db->where('parent_id',$id)->get('tb_category')->result();
	}
	
	function get_category_company($id){
		return $this->db
			->select('a.id as cat, b.parent_names, b.name, b.id, b.code')
			->join('tb_category b','b.id = a.category_id')
			->where('a.company_id',$id)
			->get('tb_company_category a')
			->result();
	}
	
	
	//=========================================
	
	// ============== follower =============//
	public function get_follower($id,$limit=10000000,$offset=0){
		return $this->db
			->select('c.name as company, c.hastag, b.fullname as name, b.id, b.image, b.email')
			->join('tb_user b','b.id=a.user_id')
			->join('tb_company c','c.id = b.company_id','left')
			->where("a.company_id",$id)
			->limit($limit,$offset)
			->get("tb_follow_company a")
			->result();
	}
	
	public function get_follower_filter($filter,$id,$limit=10000000,$offset=0){
		$where	= "";
		if($filter != 'all-search'){
			$where = " and (b.fullname like '%$filter%' or c.name like '%$filter%' )";
		}
		return $this->db
			->select('c.name as company, c.hastag, b.fullname as name, b.id, b.image, b.email')
			->where("(a.company_id like '$id' $where )", null)
			->join('tb_user b','b.id=a.user_id')
			->join('tb_company c','c.id = b.company_id')
			->limit($limit,$offset)
			->get("tb_follow_company a")
			->result();
	}
	
	/*
	public function get_following($id,$company){
		return $this->db->where('user_id',$id)->where('company_id',$company)->get("tb_follow_company");
	}
	*/
	
	public function get_following($id,$limit=10000000,$offset=0){
		return $this->db
			->select('c.name as company, c.image_logo as image, c.id as company_id, c.hastag, a.id, a.user_id')
			->join('tb_company c','c.id = a.company_id')
			->where("a.user_id",$id)
			->limit($limit,$offset)
			->get("tb_follow_company a")
			->result();
	}
	
	public function get_following_filter($filter,$id,$limit=10000000,$offset=0){
		$where	= "";
		if($filter != 'all-search'){
			$this->db->like("c.name",$filter);
		}
		return $this->db
			->select('c.name as company, c.image_logo as image, c.id as company_id, c.hastag, a.id, a.user_id')
			->join('tb_company c','c.id = a.company_id')
			->where("a.user_id",$id)
			->limit($limit,$offset)
			->get("tb_follow_company a")
			->result();
	}
	
	function cek_follow($id,$user,$company){
		return $this->db
			//->where('id',$id)
			->where('user_id',$user)
			->where('company_id',$company)
			->get('tb_follow_company')
			->result();
	}
	
	function cek_follow_2($user,$company,$date){
		return $this->db
			->where('user_id',$user)
			->where('company_id',$company)
			->where('create_date',$date)
			->order_by('id','desc')
			->limit(1)
			->get('tb_follow_company')
			->result();
	}

	function cek_favorite($id,$user){
		return $this->db
			->where('user_id',$user)
			->where('product_id',$id)
			->get('tb_bookmark_product')
			->result();
	}
	
	//=========================================
	
	//======messages/inbox=====================
	function get_contact($id){
		return $this->db
			->select("b.id, b.fullname, c.name as company")
			->join("tb_user b","a.user_child_id = b.id")
			->join("tb_company c","b.company_id = c.id","left")
			->where("a.user_parent_id",$id)
			->get("tb_user_contact a")
			->result();
	}
	
	function get_user_message($id){
		$from 	= $this->from($id);
		$to		= $this->to($id);
		$data	= array_merge($from,$to);
		
		if(count($data) > 0){
			//sort data based id
			foreach ($data as $key => $row) {
				$volume[$key]  = $row['id_msg'];
			}
			array_multisort($volume, SORT_ASC, $data);
			
			//remove duplicate data based user_id
			$newArr = array();
			foreach ($data as $val) {
				$newArr[$val['user_id']] = $val;    
			}
			$data 	= array_values($newArr);
			
			//sort data based id
			foreach ($data as $key => $row) {
				$volume2[$key]  = $row['id_msg'];
			}
			array_multisort($volume2, SORT_DESC, $data);
			//*/
		}
		
		return $data;
	}
	
	
	
	private function from($id){
		$from = $this->db
			->select('a.id as id_msg,a.user_from_id as user_id, a.update_date as time, a.status, a.message, b.fullname, b.image, c.name as company, c.hastag')
			->join('tb_user b','a.user_from_id = b.id')
			->join('tb_company c','c.id = b.company_id','left')
			->where('a.user_to_id',$id)
			->where('a.user_id',$id)
			->order_by('a.id','desc')
			->get('tb_message a')
			->result_array();
		return $from;
	}
	
	private function to($id){
		$to = $this->db
			->select('a.id as id_msg,a.user_to_id as user_id, a.update_date as time, a.status, a.message, b.fullname, b.image, c.name as company, c.hastag')
			->join('tb_user b','a.user_to_id = b.id')
			->join('tb_company c','c.id = b.company_id','left')
			->where('a.user_from_id',$id)
			->where('a.user_id',$id)
			->order_by('a.id','desc')
			->get('tb_message a')
			->result_array();
		return $to;
	}
	
	function get_user_message_filter($id,$filter){
		$from 	= $this->from_filter($id,$filter);
		$to		= $this->to_filter($id,$filter);
		$data	= array_merge($from,$to);
		
		if(count($data) > 0){
			//sort data based id
			foreach ($data as $key => $row) {
				$volume[$key]  = $row['id_msg'];
			}
			array_multisort($volume, SORT_ASC, $data);
			
			//remove duplicate data based user_id
			$newArr = array();
			foreach ($data as $val) {
				$newArr[$val['user_id']] = $val;    
			}
			$data 	= array_values($newArr);
			
			//sort data based id
			foreach ($data as $key => $row) {
				$volume2[$key]  = $row['id_msg'];
			}
			array_multisort($volume2, SORT_DESC, $data);
			//*/
		}
		
		return $data;
	}
	
	private function from_filter($id,$filter){
		if($filter != "jupuken-kabeh"){
			$this->db->like('b.fullname',$filter);
		}
		$from = $this->db
			->select('a.id as id_msg,a.user_from_id as user_id, a.update_date as time, a.status, a.message, b.fullname, b.image, c.name as company, c.hastag')
			->join('tb_user b','a.user_from_id = b.id')
			->join('tb_company c','c.id = b.company_id','left')
			->where('a.user_to_id',$id)
			->where('a.user_id',$id)
			
			->order_by('a.id','desc')
			->get('tb_message a')
			->result_array();
		return $from;
	}
	
	private function to_filter($id,$filter){
		if($filter != "jupuken-kabeh"){
			$this->db->like('b.fullname',$filter);
		}
		$to = $this->db
			->select('a.id as id_msg,a.user_to_id as user_id, a.update_date as time, a.status, a.message, b.fullname, b.image, c.name as company, c.hastag')
			->join('tb_user b','a.user_to_id = b.id')
			->join('tb_company c','c.id = b.company_id','left')
			->where('a.user_from_id',$id)
			->where('a.user_id',$id)
			//->like('b.fullname',$filter)
			->order_by('a.id','desc')
			->get('tb_message a')
			->result_array();
		return $to;
	}
	
	function get_count_message($user,$friend){
		return $this->db
			->select('id')
			->where('user_id', $user)
			->where('user_from_id', $friend)
			->where("user_to_id",$user)
			->where("status",0)
			->get('tb_message a')
			->result();
	}
	
	function change_status_message($user,$friend){
		return $this->db
			->set('status',1)
			->where('user_id', $user)
			->where('user_from_id', $friend)
			->where("user_to_id",$user)
			->where("status",0)
			->update('tb_message a');
	}
	
	function get_check_contact($user,$friend){
		return $this->db
			->where("a.user_parent_id",$user)
			->where("a.user_child_id",$friend)
			->get("tb_user_contact a")
			->result();
	}
	
	function get_message($user,$friend,$limit=5,$offset=0){
		return $this->db
			->select('a.id as id_msg,a.user_from_id as user_id, a.update_date as time, a.status, a.message, b.fullname, b.image, c.fullname as fullname2, c.image as image2, d.name as company')
			->join('tb_user b','a.user_to_id = b.id','left')
			->join('tb_user c','a.user_from_id = c .id','left')
			->join("tb_company d","c.company_id = d.id",'left')
			->where('a.user_id', $user)
			->where("(a.user_to_id = '$friend' OR a.user_from_id = '$friend')")
			->order_by('a.id','desc')
			->limit($limit,$offset)
			->get('tb_message a')
			->result_array();
	}
	
	
	
	function cek_user_message($id,$user,$email){
		return $this->db
			->select('c.name as company, c.hastag, b.fullname as name, b.id, b.image, b.email')
			->join('tb_user b','b.id=a.user_id')
			->join('tb_company c','c.id = b.company_id',"left")
			->where("a.company_id",$id)
			->where("b.id",$user)
			->where("b.email",$email)
			->get("tb_follow_company a")
			->result();
	}
	
	function cek_user_message_2($id,$user,$email){
		return $this->db
			->select('c.name as company, c.hastag, b.fullname as name, b.id, b.image, b.email')
			->join('tb_company c','c.id = b.company_id','left')
			->where("b.id",$user)
			->where("b.email",$email)
			->get("tb_user b")
			->result();
	}
	//=========================================
	
	
	public function get_company($company){
		return $this->db->select('tb_company.*, a.name province,b.name country,c.name city')
						->join('tb_province a','a.id=province_id','left')
						->join('tb_country b','b.id=tb_company.country_id','left')
						->join('tb_city c','c.id=tb_company.city_id','left')
						->where("tb_company.id",$company)
						->get("tb_company");
	}
	public function get_company_id($id){
		return $this->db->where('id',$id)->get('tb_user');
	}
	public function get_name($id){
		return $this->db->where('id',$id)->get('tb_company');
	}
	public function get_catalogue($company){
		return $this->db->where("company_id",$company)->get("tb_catalog");
	}
	/*public function get_product($id,$keyword=''){
		return $this->db->select('p.*,a.image image')
						->where("company_id",$id)
						->join('tb_product_image a','a.product_id=p.id','left')
						->group_by('p.id')
						->like('p.name',$keyword)
						->get("tb_product p");
	}*/
	public function get_product_by_ctlg($id,$keyword=''){
		return $this->db->select('p.*,a.image image')
						->where("catalog_id",$id)
						->join('tb_product_image a','a.product_id=p.id','left')
						->group_by('p.id')
						->like('p.name',$keyword)
						->get("tb_product p");
	}
	public function get_product_by_ctlg1($id,$keyword=''){
		return $this->db->select('p.*,a.image image')
						->where("catalog_id",NULL)
						->where("p.company_id",$id)
						->join('tb_product_image a','a.product_id=p.id','left')
						->group_by('p.id')
						->like('p.name',$keyword)
						->get("tb_product p");
	}
	/*public function get_product_by_limit_rand($id,$limit=10,$offset=0){
		return $this->db->select('p.*,a.image image')
			->where("company_id",$id)
			->join('tb_product_image a','a.product_id=p.id','left')
			->group_by('p.id')
			->limit($limit,$offset)
			->order_by("id","random")
			->get("tb_product p");
	}
	
	/*public function get_follower($id){
		return $this->db->where("tb_follow_company.company_id",$id)->join('tb_user','tb_user.id=user_id')->get("tb_follow_company");
	}*/
	
	
	/*public function get_contact($id,$id2){
		return $this->db->where('company_id',$id)->where('user_id',$id2)->get('tb_follow_company');	
	}*/
	public function get_follow($id,$id2){
		return $this->db->where('company_id',$id)->where('user_id',$id2)->get('tb_follow_company');	
	}
	/*public function get_user_contact($id){
		return $this->db->where('company_id',$id)->get('tb_user');
	}*/
	public function get_id($email){
		return $this->db->where('email',$email)->get('tb_user');
	}
	public function get_slidder($id){
		return $this->db->where('company_id',$id)->get('tb_company_slide');
	}
	public function get_hastag($name){
		return $this->db->where('hastag',$name)->get('tb_company');
	}


	public function get_category_new($id){
		return $this->db->select('a.id as cat, b.name, b.id')->join('tb_category b','b.id = a.category_id')->where('a.feed_id',$id)->get('tb_feed_category a')->result();
	}


	function get_blocked_user($id,$limit=10000000,$offset=0){
		$this->db->select('a.image image,a.id user_id,a.fullname fullname,c.name company_name,c.hastag hastag')->join('tb_user a','a.id=user_child_id')->join('tb_company c','c.id=a.company_id','left')->where('user_parent_id',$id)->limit($limit,$offset);
		if (isset($_SESSION['setting_keyword'])) {
			$this->db->like('a.fullname',$_SESSION['setting_keyword']);
			
		}
		return $this->db->get('tb_feedbox_blocked');
	}

	
	
	
	
	
	/* ------------------------------------------------------
	*  CREATE FILTER SEARCH
	*  Vertibox Version 2
	*  ------------------------------------------------------
	*/
	function get_by_search($keyword="", $category=null, $offset=0, $limit=5){
		$QCompany = $this->db;
		
		if($keyword != "" && $keyword != "all"){
			$QCompany = $QCompany->select("company.*, country.name as company_country, city.name as company_city, (SELECT phone FROM tb_company_phone WHERE company_id = company.id LIMIT 0,1) as company_phone, (MATCH (company.name,company.keyword) AGAINST ('".$keyword."' IN BOOLEAN MODE )) as rank", false);
		}else{
			$QCompany = $QCompany->select("company.*, country.name as company_country, city.name as company_city, (SELECT phone FROM tb_company_phone WHERE company_id = company.id LIMIT 0,1) as company_phone", false);
		}
		
		$QCompany = $QCompany->join("countries country","company.country_id = country.code","LEFT");
		$QCompany = $QCompany->join("cities city","company.city_id = city.ID","LEFT");
		
		if($keyword != "" && $keyword != "all"){
			$whereOrName = "";
			if(strlen($keyword) <= 3){
				$whereOrName = "OR (company.name LIKE '%".$keyword."%') OR (company.keyword LIKE '%".$keyword."%')";
			}
			
			$QCompany = $QCompany->where("((MATCH (company.name,company.keyword) AGAINST ('".$keyword."' IN BOOLEAN MODE)) ".$whereOrName." )");
			
			if(!empty($category) && !empty($category->code)){
				$QCompany = $QCompany->where("company.id IN (SELECT cc.company_id as id FROM tb_company_category cc JOIN tb_category category ON cc.category_id = category.id WHERE category.code LIKE ","'%".$category->code."%')", false);
			}
			
			$QCompany = $QCompany->order_by("rank DESC, company.id DESC, company.verified","DESC");
		}else{
			if(!empty($category) && !empty($category->code)){
				$QCompany = $QCompany->where("company.id IN (SELECT cc.company_id as id FROM tb_company_category cc JOIN tb_category category ON cc.category_id = category.id WHERE category.code LIKE ","'%".$category->code."%')", false);
			}
			
			$QCompany = $QCompany->order_by("company.id DESC, company.verified","DESC");
		}
		
		$QCompany = $QCompany->group_by("company.id");
		$QCompany = $QCompany->limit($limit,$offset);
		$Companies = $QCompany->get("tb_company company");
		
		return  $Companies;
	}
	
}

?>