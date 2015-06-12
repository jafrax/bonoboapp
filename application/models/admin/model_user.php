<?php
class Model_user extends CI_Model {

	function get_user_all($limit=1000000,$offset=0){
        return $this->db->where('user.user_group_id',2)->limit($limit,$offset)->get('tb_user user');
    }
	function get_user_by_id($id,$limit=1000000,$offset=0){
        return $this->db->where('user.user_group_id',2)->where('user.id',$id)->limit($limit,$offset)->get('tb_user user');
    }
    function get_all_user_company($limit=1000000,$offset=0){
        return $this->db->select('u.status,u.email,u.username,u.facebook as fb,u.fullname,u.phone,u.id,c.name  company_name')        				
        				->join('tb_company  c','c.id=u.company_id', 'left')
						->where('u.user_group_id',2)
        				->limit($limit,$offset)
        				->get('tb_user  u');
    }
    function get_filter($filter,$limit=1000000,$offset=0){
        return $this->db->select('u.status,u.email,u.username,u.password,u.fullname,u.phone,u.id,u.facebook as fb,c.name  company_name') 
        				->limit($limit,$offset)     
        				->like('u.email',$filter)  				
        				->join('tb_company  c','c.id=u.company_id', 'left')
						->where('u.user_group_id',2)
        				->get('tb_user  u');
    }
    public function get_one($id){
		return $this->db->select('u.status,u.email,u.username,u.password,u.fullname,u.phone,u.id,c.name  company_name')        				
        				->join('tb_company  c','c.id=u.company_id', 'left')
        				->where('u.id',$id)->get('tb_user u');
	}
    function get_attribut($id){
        return $this->db->where('user_id',$id)->get('tb_user_attribut');
    }
    function get_image($id){
        return $this->db->select('image')->where('id',$id)->get('tb_user')->row();
    }
	
}

?>