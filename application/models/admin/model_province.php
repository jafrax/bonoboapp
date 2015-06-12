<?php
class Model_province extends CI_Model {

	public function get_list_all(){
		return $this->db->select('region.*, country.name as country_name')
						->join('countries country','region.country = country.code')
						->get('regions region');
	}
	
	public function get_by_country($country_id){
		return $this->db->select('region.*, country.name as country_name')
						->join('countries country','region.country = country.code')
						->where("region.country", $country_id)
						->get('regions region');
	}
	
	public function getProvinceAll($limit=1000000,$offset=0){
		return $this->db->select('region.country, region.id, region.name, region.code, country.name as country_name')
						->join('countries country','region.country = country.code','Left')
						->limit($limit,$offset)
						->get('regions region');
	}

	public function get_filter($keyword, $country=null, $limit=1000000, $offset=0){
        $QProvince = $this->db->select('region.country,region.id,region.name,region.code,country.name as country_name')
        				->join('countries country','region.country = country.code','Left')
						->like('region.name',$keyword);
        
		if($country != null){
			$QProvince = $QProvince->where("region.country", $country);
		}
						
		return $QProvince->limit($limit,$offset)->get('regions region');
    }

    public function get_one($id){
		return $this->db->where('id',$id)->get('regions');
	}

}

?>