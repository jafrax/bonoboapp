<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* MODEL Account
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 28 Juni 2015 by Adi Setyo, Create function : read, edit, search
*/
class Model_account extends CI_Model {
    function read($limit=1000000,$offset=0){
        $this->db->order_by("name","asc");
		$this->db->limit($limit,$offset);
		return $this->db->get('tb_admin');
    }
    
    function edit($id){
        $this->db->where("id",$id);
		return $this->db->get('tb_admin')->result();
    }
    
    public function search($search,$limit=1000000,$offset=0){
        if($search != "all-search"){
            $this->db->like("name",$search);
			$this->db->or_like("email",$search);
        }
		$this->db->limit($limit,$offset);
        $this->db->order_by("name","asc");
		return $this->db->get('tb_admin');
    }

   public function get_by_email($email){
        return $this->db->select('tt.*')
                        ->where("tt.email",$email)
                        ->get("tb_admin tt");
    }
    
    public function reset_akun($data){
        $this->db->like('token',$data['token']);
        $this->db->like('email',$data['email']);
        return $this->db->get('tb_admin');
    }

}
