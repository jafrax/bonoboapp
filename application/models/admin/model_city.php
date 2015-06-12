<?php
class Model_city extends CI_Model {

	public function get_list_all(){
		return $this->db->get('cities');
	}
	
	public function get_by_country($country_id){
		return $this->db
				->where("country",$country_id)
				->get('cities');
	}
	
	public function get_by_country_region($country_id,$region_id){
		return $this->db
					->where("country",$country_id)
					->where("region",$region_id)
					->get('cities');
	}
	
	public function getcityAll($limit=1000000,$offset=0){
		return $this->db->select('city.id, city.name, city.region, city.country, province.name as province_name, country.name as country_name')
						->join('countries country','city.country = country.code')
						->join('regions province','city.region = province.code AND city.country = province.country', 'Left', false)
						->limit($limit,$offset)
						->get('cities city');
	}

	public function get_filter($keyword,$country=null,$limit=1000000,$offset=0){
		$QCity = $this->db->select('city.id, city.name, city.region, city.country, province.name as province_name, country.name as country_name')
        				->join('countries country','city.country = country.code')
						->join('regions province','city.region = province.code AND city.country = province.country', 'Left', false)
						->like('city.name', $keyword);
						
		if($country != null){
			$QCity = $QCity->where("country.code",$country);
		}
		
		$City = $QCity->limit($limit,$offset)->get('cities city');
        
        return $City;		
    }

    public function get_one($id){
		return $this->db->where('id',$id)->get('cities');
	}

}

?>