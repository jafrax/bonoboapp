<?php

/*
* MODEL MEMBER LOCATION
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Heri Siswanto, Create function : get_by_member
*/

class Model_member_location extends CI_Model {
	
	public function get_by_member($member){
		return $this->db->select("tml.*, ml.postal_code as location_postal, ml.kecamatan as location_kecamatan, ml.city as location_city, ml.province as location_province")
						->join("ms_location ml","ml.id = tml.location_id")
						->where("tml.member_id",$member)
						->get("tb_member_location tml");
	}
	
}

?>