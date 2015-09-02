<?php

/*
* MODEL TOKO
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 23 Juni 2015 by Heri Siswanto, Create function : get_by_login, get_by_email
* 2. Update 24 Juni 2015 by Heri Siswanto, Create function : get_by_id
* 3. Create 03 Juli 2015 by Adi Setyo, Create function : get_by_verf,update_level_toko4,update_level_toko3,update_level_toko2,update_level_toko
* 														 cek_member_use4,cek_member_use3,cek_member_use2,cek_member_use1,cek_status_level_toko
*/

class Model_toko extends CI_Model {
	
	public function get_by_login($email,$password){
		return $this->db->select('tt.*')
						->where("tt.email",$email)
						->where("tt.password",$password)
						->get("tb_toko tt");
	}
		
	public function get_by_email($email){
		return $this->db->select('tt.*')
						->where("tt.email",$email)
						->get("tb_toko tt");
	}
	public function cek_user_active($data){
		return $this->db->select('tt.*')
						->where("tt.email",$data['email_user'])
						->where("tt.status !=",2)
						->get("tb_toko tt");
	}
	
	
	public function get_by_id($id){
		return $this->db->select('tt.*, mc.name as category_name, ml.kecamatan as location_kecamatan, ml.city as location_city, ml.province as location_province')
						->join("ms_location ml","tt.location_id = ml.id","LEFT")
						->join("ms_category mc","tt.category_id = mc.id","LEFT")
						->where("tt.id",$id)
						->get("tb_toko tt");
			}
			
			
	public function get_by_verf($email,$uri_veri){
		return	$this->db->select('tt.*')
						 ->where('tt.email',$email)
						 ->where('tt.verified_code',$uri_veri)
						 ->get('tb_toko tt');
	}
	public function update_status($email,$uri_veri){
		return	$this->db->select('tt.*')
						 ->where('tt.email',$email)
						 ->where('tt.verified_code',$uri_veri)
						 ->get('tb_toko tt');
	}
	// diabuat oleh adi 04-08-2015
	public function cek_status_level_toko($data){
         $this->db->where('tt.id',$data['id_toko']);
         $return = $this->db->get('tb_toko tt');
         return $return;       
    }
	// diabuat oleh adi 04-08-2015
    public function cek_member_use1($id){
         $this->db->where('tt.toko_id',$id['id_toko']);
         $this->db->where('tt.price_level',1);
         $return = $this->db->get('tb_toko_member tt');
         return $return;
    }
	// diabuat oleh adi 04-08-2015
    public function cek_member_use2($id){
                $this->db->where('tt.toko_id',$id['id_toko']);
                $this->db->where('tt.price_level',2);
                $return = $this->db->get('tb_toko_member tt');
                return $return;
    }
	// diabuat oleh adi 04-08-2015
    public function cek_member_use3($id){
                $this->db->where('tt.toko_id',$id['id_toko']);
                $this->db->where('tt.price_level',3);
                $return = $this->db->get('tb_toko_member tt');
                return $return;
    }
	// diabuat oleh adi 04-08-2015
    public function cek_member_use4($id){
                $this->db->where('tt.toko_id',$id['id_toko']);
                $this->db->where('tt.price_level',4);
                $return = $this->db->get('tb_toko_member tt');
                return $return;
    }
	// diabuat oleh adi 04-08-2015
    public function cek_member_use5($id){
               $this->db->where('tt.toko_id',$id['id_toko']);
                $this->db->where('tt.price_level',5);
                $return = $this->db->get('tb_toko_member tt');
                return $return;
    }
	// diabuat oleh adi 04-08-2015
    public function update_level_toko2($data,$data_update){
                $this->db->set('level_2_active',$data_update);
                $this->db->where('tt.id',$data['id_toko']);
                $this->db->update('tb_toko tt');
                $return=$this->db->affected_rows();
                return $return;
     }
	 // diabuat oleh adi 04-08-2015
     public function update_level_toko3($data,$data_update){
                $this->db->set('level_3_active',$data_update);
                $this->db->where('tt.id',$data['id_toko']);
                $this->db->update('tb_toko tt');
                $return=$this->db->affected_rows();
                return $return;
     }
	 // diabuat oleh adi 04-08-2015
     public function update_level_toko4($data,$data_update){
                $this->db->set('level_4_active',$data_update);
                $this->db->where('tt.id',$data['id_toko']);
                $this->db->update('tb_toko tt');
                $return=$this->db->affected_rows();
                return $return;
      }
	  // diabuat oleh adi 04-08-2015
      public function update_level_toko5($data,$data_update){
                $this->db->set('level_5_active',$data_update);
                $this->db->where('tt.id',$data['id_toko']);
                $this->db->update('tb_toko tt');
                $return=$this->db->affected_rows();
                return $return;
      }
	  // diabuat oleh adi 04-08-2015
	  public function get_all_address($data){
		$this->db->where('tt.postal_code',$data);
		$return=$this->db->get('ms_location tt');
		return $return;
	  }
	  // diabuat oleh adi 04-08-2015
	  public function get_siti($id){
		$this->db->where('id',$id);
		return $this->db->get('ms_location');
	  }
	  // diabuat oleh adi 04-08-2015
	  public function get_kota($id){
		$this->db->where('province',$id);
		$this->db->group_by('city');
		return $this->db->get('ms_location');
	}
	// diabuat oleh adi 04-08-2015
	function get_kecamatan($id){
		$this->db->where('city',$id);
		$this->db->group_by('kecamatan');
		return $this->db->get('ms_location');
	}
	// diabuat oleh adi 04-08-2015
	public function get_alamat($id){
		$this->db->select('tb_toko.location_id,ms_location.city,ms_location.kecamatan,ms_location.province');
		$this->db->from('tb_toko');
		$this->db->join('ms_location', 'tb_toko.location_id = ms_location.id','inner');
		$this->db->where('tb_toko.id',$id);
		return $this->db->get();
	}

	// diabuat oleh adi 04-08-2015	
	public function get_allkota(){
		$this->db->group_by('city');
		return $this->db->get('ms_location');
	}
	// diabuat oleh adi 04-08-2015
	public function get_allkecamatan(){
		$this->db->group_by('kecamatan');
		return $this->db->get('ms_location');
	}
	// diabuat oleh adi 04-08-2015
	public function get_id_location($pos){
		$this->db->where('postal_code',$pos);
		return $this->db->get('ms_location');
	}
	// diabuat oleh adi 04-08-2015
	public function getcode_pos($data){
		$this->db->select('postal_code');
        $this->db->like("province", $data['province'] );
        $this->db->like("city", $data['city'] );
        $this->db->like("kecamatan", $data['kecamatan'] );
        $this->db->like("postal_code", $data['postal'] );
		 $this->db->order_by('id', 'DESC');
        return $this->db->get('ms_location');
	}
	// diabuat oleh adi 04-08-2015
	public function get_rekeningsama($data){
		$this->db->where('acc_no',$data['rekeningmu']);
		$this->db->where('bank_name',$data['bank_name']);
		//$this->db->where('toko_id',$_SESSION['bonobo']['id']);
		return $this->db->get('tb_toko_bank')->num_rows();
	}
	// diabuat oleh adi 04-08-2015
	public function get_rekeningsama2($data){
		$this->db->where('acc_no',$data['rekeningmu']);
		//$this->db->where('toko_id',$_SESSION['bonobo']['id']);
		return $this->db->get('tb_toko_bank')->num_rows();
	}
	// diabuat oleh adi 11-08-2015
	public function get_rekeningsama22($rekeningmu){
		$this->db->where('acc_no',$rekeningmu);
		//$this->db->where('toko_id',$_SESSION['bonobo']['id']);
		return $this->db->get('tb_toko_bank')->num_rows();
	}
	
	public function reset_akun($data){
		$this->db->like('token',$data['token'],'none');
		$this->db->like('email',$data['email'],'none');
		return $this->db->get('tb_toko');
	}
	
	
		

}

?>