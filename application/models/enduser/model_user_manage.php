<?php class Model_user_manage extends CI_model{
    
    private function get_id($company){
        $data = $this->db->where('id',$company)->get('tb_company')->row();
        $id=0;
        if(count($data)>0){
            $id = $data->user_id;
        }
        return $id;
    }
    
    function get_user($id,$company,$limit=100000,$offset=0){
        return $this->db->where('id !=',$id)->where('id !=',$this->get_id($company))->where('company_id',$company)->where('user_group_id',2)->limit($limit,$offset)->get('tb_user');
    }
    
    function edit($id){
        return $this->db->where('id',$id)->get('tb_user');
    }
    
    function setting($id){
        return $this->db->where('user_id',$id)->get('tb_user_setting')->result();
    }
    
    function filter($filter,$id,$company,$limit=100000,$offset=0){
        $where	= "";
		if($filter != 'all-search'){
			$where = " and (fullname like '%$filter%' )";
		}
        return $this->db
            
            ->where('id !=',$this->get_id($company))
            ->where('company_id',$company)
            ->where('user_group_id',2)
            ->where("(company_id != '$id' $where )", null)
            ->limit($limit,$offset)
            ->get('tb_user');
    }
}
