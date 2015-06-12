<?php class Model_profile extends CI_model{
    function get_user($id){
        return $this->db->select('a.*, b.name as company, b.verified')
            ->join('tb_company b','b.id = a.company_id','left')
            ->where('a.id',$id)
            ->get('tb_user a');
    }
    
    function get_contact($id){
        return $this->db->where('user_id',$id)->get('tb_user_attribut');
    }
    
    function get_country(){
        return $this->db->order_by('name','asc')->get('tb_country');
    }
    
    function get_company($id){
        return $this->db
            ->select('a.*,b.name as country, c.name as province, d.name as city')
            ->join('tb_country b','a.country_id = b.id','left')
            ->join('tb_province c','a.province_id = c.id','left')
            ->join('tb_city d','a.city_id = d.id','left')
            ->where('a.id',$id)
            ->get('tb_company a');
    }
    
    function get_slideshow($id){
        return $this->db->where('company_id',$id)->get('tb_company_slide');
    }
    
    function get_category($id){
		return $this->db->select('a.id as cat, b.parent_names, b.name, b.id')->join('tb_category b','b.id = a.category_id')->where('a.company_id',$id)->get('tb_company_category a')->result();
	}
}
