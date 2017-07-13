<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Admin CONTROLLER daftar_toko
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 22 July 2015 by Adi Setyo, Create controller : Coding index, delete, search, suspend
*/
class Daftar_toko extends CI_Controller {
    var $data = array('scjav'=>'assets/jController/admin/CtrlDtoko.js');
	var $limit = 10;
	var $offset = 0;
    function __construct(){
        parent::__construct();
        $this->load->model("admin/model_toko");
		if(empty($_SESSION['bonobo_admin']) || empty($_SESSION['bonobo_admin']->id)){
			redirect('admin/index/signin');
            return;
		}
    }
    
    public function index(){
        $page=$this->uri->segment(4);
        $uri=4;
        $limit=$this->limit;
        if(!$page):
        $offset = $this->offset;
            else:
            $offset = $page;
        endif;
        $pg=$this->model_toko->get_all_toko();
        $url='admin/daftar_toko/index';
        $this->data['pagination'] = $this->template->paging2($pg,$uri,$url,$limit);        
        $this->data['allToko']=$this->model_toko->get_all_toko($limit,$offset);

        if ($this->input->post('ajax')) {
            $this->load->view('admin/daftar_toko/bg_daftartoko_ajax', $this->data);
        } else {
            $this->template->bonobo_admin('daftar_toko/bg_daftartoko', $this->data);
        } 
    }
    
    
    
    function UploadExcel(){
    	$table = 'statement';
    	$filename ='expense.xls';
    
    	$pathToFile = './uploads/' . $filename;
    
    	//           print_r($pathToFile);die;
    	$valuesSql="";
    	$this->load->library('Excel_Reader');
    	$data = new Excel_Reader($pathToFile);
    	$sql = "INSERT INTO $table (";
    	for($index = 1;$index <= $data->sheets[0]['numCols']; $index++){
    		$sql.= strtolower($data->sheets[0]['cells'][1][$index]) . ", ";
    	}
    
    	$sql = rtrim($sql, ", ")." ) VALUES ( ";
    	for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
    		$valuesSQL = '';
    		for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
    			$valuesSql .= "\"" . $data->sheets[0]['cells'][$i][$j] . "\", ";
    		}
    		echo $sql . rtrim($valuesSql, ", ")." ) <br>";
    	}                                           // add this line
    
    
    }
    
    
	
	public function delete(){
		if($_POST != null){
			$delete = $this->input->post('delete');
			$delete	= explode(",",$delete);
			$del	= array('');
			
			for($i=0;$i<count($delete);$i++) {
				$del[] = $delete[$i];
            }
            
			$this->db->where_in('id',$delete)->delete('tb_toko');
		}
	}
	
	public function search(){
		if(isset($_POST['search'])  ){
			$search = $this->db->escape_str($this->input->post('search'));
			
			if(empty($search)){$search ='all-search';}
			$_SESSION['search']	= $search;
		}	
		if(isset($_SESSION['search'])){			
			$page	= $this->uri->segment(4);
			$uri	= 4;
			$limit	= $this->limit;
			if(!$page){
				$offset = $this->offset;
			}else{
				$offset = $page;
			}
			
			$this->data["search"]	= $_SESSION['search'];
			$pg		            	= $this->model_toko->search($_SESSION['search']);
			$url	           		= 'admin/daftar_toko/search';
			$this->data['pagination']	= $this->template->paging2($pg,$uri,$url,$limit);
			$this->data['allToko']		= $this->model_toko->search($_SESSION['search'],$limit,$offset);
			$this->load->view('admin/daftar_toko/bg_daftartoko_ajax', $this->data);
		}
	}
	public function datechange(){
        $getid = $this->input->post("getid");
        if($getid){
            $cek   = $this->model_toko->edit($getid);
            $msg    = "error";
            if(count($cek)>0){
                $msg    = "success";
            }
            $msg    = array("msg"=>$msg);
            $data   = array_merge($msg,$cek);
            echo json_encode($data);
        }else{
            $this->form_validation->set_rules('datepickermah', '', 'required');
            $this->form_validation->set_rules('idedit', '', 'required');
            $msg    = "error";
            $notif  = "";
            if ($this->form_validation->run() == TRUE){
                
                $datepickermah    	= $this->db->escape_str($this->input->post('datepickermah'));
                $idedit    			= $this->db->escape_str($this->input->post('idedit'));
				$date_time=date('Y-m-d',strtotime($datepickermah));
                $param  = array(
                    'expired_on'          => $date_time,
					'update_user'   	=> $_SESSION['bonobo_admin']->email
                );
                
                $update = $this->db->where("id",$idedit)->update('tb_toko',$param);
                if($update){
                    $msg    = "success";
                    $notif  = "Berhasil";
					$date=$date_time;
                }
            }
            echo json_encode(array("msg"=>$msg,"notif"=>$notif,"tanggal"=>$date));
        }
    }
	public function suspend(){
		$id 	= $this->input->post('id');
		$msg    = "error";
        $notif  = "";
		if($id){
			$cek	= $this->model_toko->edit($id);
			if(count($cek) > 0){
				$this->db->set('status',3)->where('id',$id)->update('tb_toko');
				$msg    = "success";
			}
		}
		echo json_encode(array("msg"=>$msg,"notif"=>$notif));
    }
	public function unsuspend(){
        $id 	= $this->input->post('id');
		$msg    = "error";
        $notif  = "";
		if($id){
			$cek	= $this->model_toko->edit($id);
			if(count($cek) > 0){
				$this->db->set('status',2)->where('id',$id)->update('tb_toko');
				$msg    = "success";
			}
		}
		echo json_encode(array("msg"=>$msg,"notif"=>$notif));
    }
	
}
