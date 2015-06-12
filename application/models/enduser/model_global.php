<? class Model_global extends CI_Model{
    function privilege($id){
        $hak = $this->cek_privilege($id);
        $privilege ='';
        foreach($hak as $row){
            
            if($row->setting_acces == 1){
                $privilege .= 'setting,';
            }
            if($row->product_add == 1){
                $privilege .= 'padd,';
            }
            if($row->product_edit == 1){
                $privilege .= 'pedit,';
            }
            if($row->product_delete == 1){
                $privilege .= 'pdelete,';
            }
            if($row->feed_add == 1){
                $privilege .= 'fadd,';
            }
            if($row->company_edit == 1){
                $privilege .= 'cedit,';
            }
        }
        $_SESSION['privilege'] = $privilege;
    }
    
    function cek_privilege($id){
        return $this->db->where('user_id',$id)->get('tb_user_setting')->result();
    }
    
    function cek_user($id){
        $cek = $this->db->where('id',$id)->get('tb_user');
        if($cek->num_rows == 0){
            redirect('login/logout');
        }
    }
	
	function cek_user1($id){
        $cek = $this->db->where('id',$id)->get('tb_user');
        if($cek->num_rows == 0){
            unset($_SESSION['vertibox']);
			unset($_SESSION['privilege']);
			unset($_SESSION['verified']);
			unset($_SESSION['following']);		
			unset($_SESSION['supply']);
            unset($_SESSION['buy']);
            unset($_SESSION['info']);
            unset($_SESSION['category_follow']);
            unset($_SESSION['category_feed']);
            unset($_SESSION['country_feed']);
            unset($_SESSION['country_follow']);
			unset($_SESSION['sign_email']);
        }
    }

    function get_contact(){
        return $this->db->where('user_parent_id',$_SESSION['vertibox']['id'])->join('tb_user','tb_user.id=c.user_child_id')->get('tb_user_contact c');
    }

    public function get_hastag($id){
        return $this->db->where('id',$id)->get('tb_company');
    }

    public function get_type_row($id){
        return $this->db->where('id',$id)->get('tb_post_type');
    }

    // get follow
    function get_follow_country($user_id,$country_id){
        return $this->db->where('user_id',$user_id)->where('country_id',$country_id)->get('tb_feedbox_country');
    }

    function get_follow_category($user_id,$category_id){
        return $this->db->where('user_id',$user_id)->where('category_id',$category_id)->get('tb_follow_category ');
    }

    //get category level on header
    public function get_category_level($value='')
    {
        return $this->db->where('level',$value)->get('tb_category');
    }

    public function get_category_parent($value='')
    {
        return $this->db->where('parent_id',$value)->limit(6,0)->get('tb_category');
    }
}
