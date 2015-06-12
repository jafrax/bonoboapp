<?php
class Model_company extends CI_Model {

	function get_list_all($keyword=""){
        return $this->db
			->select("tcompany.*, tcity.name as city_name, tprovince.name as province_name, tcountry.name as country_name")
			->join("countries tcountry","tcompany.country_id = tcountry.code","left")
			->join("regions tprovince","tcompany.province_id = tprovince.id","left")
			->join("cities tcity","tcompany.country_id = tcity.country AND tcompany.province_id = tcity.region","left")
			->where("tcompany.name LIKE ", "%".$keyword."%")
			->get('tb_company tcompany');
    }
	
	function get_list_all_by_limit($keyword="", $limit=1000000,$offset=0){
        return $this->db
			->select("tcompany.*, tcity.name as city_name, tprovince.name as province_name, tcountry.name as country_name")
			->join("countries tcountry","tcompany.country_id = tcountry.code","left")
			->join("regions tprovince","tcompany.province_id = tprovince.id","left")
			->join("cities tcity","tcompany.country_id = tcity.country AND tcompany.province_id = tcity.region","left")
			->where("tcompany.name LIKE ", "%".$keyword."%")
			->limit($limit,$offset)
			->get('tb_company tcompany')
			->result();
    }
	
	function get_by_id($id){
        return $this->db
			->select("tcompany.*, tcity.name as city_name, tprovince.name as province_name, tcountry.name as country_name")
			->join("tb_country tcountry","tcompany.country_id = tcountry.id","left")
			->join("tb_province tprovince","tcompany.province_id = tprovince.id","left")
			->join("tb_city tcity","tcompany.city_id = tcity.id","left")
			->where("tcompany.id", $id)
			->get('tb_company tcompany')
			->row();
    }
	
	function get_list_slide_by_company($id){
		return $this->db
				->select("tcs.*,tc.*,tcs.id as slide_id")
				->join("tb_company tc","tcs.company_id = tc.id")
				->where("tcs.company_id",$id)
				->get("tb_company_slide tcs")
				->result();
	}
	
	function get_slide_by_id($id){
		return $this->db
				->select("tcs.*,tc.*")
				->join("tb_company tc","tcs.company_id = tc.id")
				->where("tcs.id",$id)
				->get("tb_company_slide tcs")
				->row();
	}
	
	function doDelete($id){
		$delete =  $this->db->where("id",$id)->delete("tb_company");
		if($delete){
			$del = $this->db->where("company_id",$id)->delete("tb_user");
			return 'sukses';
		}
	}
	
	function doDeleteSlide($id){
		return $this->db->where("id",$id)->delete("tb_company_slide");
	}
	
	function doSave($company){
		$companySaved = null;
		if(!empty($company["id"])){
			$this->db->where("id",$company["id"])->update("tb_company",$company);
			$companySaved = $this->db->where("id",$company["id"])->get("tb_company")->row();
		}else{
			$this->db->insert("tb_company",$company);
			$companySaved = $this->db->get("tb_company",$company)->row();
		}
		return $companySaved;
	}
	
	function doSaveSlide($companySlide){
		if(!empty($companySlide["id"])){
			$this->db->where("id",$companySlide["id"])->update("tb_company_slide",$companySlide);
		}else{
			$this->db->insert("tb_company_slide",$companySlide);
		}
	}
	
	
}

?>