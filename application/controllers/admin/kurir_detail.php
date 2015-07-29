<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Admin CONTROLLER Kurir_detail
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 28 July 2015 by Adi Setyo, Create controller : Coding index, delete, search, edit, add
*/
class Kurir_detail extends CI_Controller {
    var $data = array('scjav'=>'assets/jController/admin/CtrlDkurir.js');
	var $limit = 10;
	var $offset = 0;
    function __construct(){
        parent::__construct();
        $this->load->model("admin/model_dkurir");
		if(empty($_SESSION['bonobo_admin']) || empty($_SESSION['bonobo_admin']->id)){
			redirect('admin/index/signin');
            return;
		}
    }
    
    public function index(){
		$_SESSION['link_kurir_detail']=$this->uri->segment(4);
		$_SESSION['kurir_detail']=base64_decode($_SESSION['link_kurir_detail']);
        $page=$this->uri->segment(6);
        $uri=6;
        $limit=$this->limit;
        if(!$page):
        $offset = $this->offset;
            else:
            $offset = $page;
        endif;
        $pg=$this->model_dkurir->get_all_dkurir($_SESSION['kurir_detail']);
        $url='admin/kurir_detail/index/'.$_SESSION['link_kurir_detail'].'/index/';
        $this->data['pagination'] = $this->template->paging2($pg,$uri,$url,$limit);        
        $this->data['allDKurir']=$this->model_dkurir->get_all_dkurir($_SESSION['kurir_detail'],$limit,$offset);
		$this->data['get_province'] = $this->model_dkurir->get_province();
		$this->data['get_kota'] = $this->model_dkurir->get_allkota();
		$this->data['get_kecamatan'] = $this->model_dkurir->get_allkecamatan();
		if ($this->input->post('ajax')) {
            $this->load->view('admin/master_kurir_detail/master_kurir_detail_ajax', $this->data);
        } else {
            $this->template->bonobo_admin('master_kurir_detail/master_kurir_detail', $this->data);
        } 
    }
		
	public function delete(){
		if($_POST != null){
			$delete = $this->input->post('delete');
			$delete	= explode(",",$delete);
			$del	= array('');
			
			for($i=0;$i<count($delete);$i++) {
				$del[] = $delete[$i];
            }
            
			$this->db->where_in('id',$delete)->delete('tb_courier_rate');
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
			$pg		            	= $this->model_dkurir->search($_SESSION['search'],$_SESSION['kurir_detail']);
			$url					= 'admin/kurir_detail/search/';
			$this->data['pagination']	= $this->template->paging2($pg,$uri,$url,$limit);
			$this->data['allDKurir']		= $this->model_dkurir->search($_SESSION['search'],$_SESSION['kurir_detail'],$limit,$offset);
			$this->load->view('admin/master_kurir_detail/master_kurir_detail_ajax', $this->data);
		}
	}
	
	public function edit(){
        $getid = $this->input->post("getid");
        if($getid){
            $cek   = $this->model_dkurir->edit($getid);
            $msg    = "error";
            if(count($cek)>0){
                $msg    = "success";
            }
            $msg    = array("msg"=>$msg);
            $data   = array_merge($msg,$cek);
            echo json_encode($data);
        }else{
            $this->form_validation->set_rules('namaedit', '', 'required');
            $this->form_validation->set_rules('idedit', '', 'required');
            $msg    = "error";
            $notif  = "";
            if ($this->form_validation->run() == TRUE){
                
                $name    	= $this->db->escape_str($this->input->post('namaedit'));
                $idedit     = $this->db->escape_str($this->input->post('idedit'));
                $param  = array(
                    'name'          => $name,
					'update_user'   => $_SESSION['bonobo_admin']->email
                );
                
                $insert = $this->db->where("id",$idedit)->update('tb_courier_rate',$param);
                if($insert){
                    $msg    = "success";
                    $notif  = "Berhasil";
                }
            }
            echo json_encode(array("msg"=>$msg,"notif"=>$notif));
        }
    }
	
	public function add (){
		$this->form_validation->set_rules('fprovince', '', 'required');
		$this->form_validation->set_rules('fkota', '', 'required');
		$this->form_validation->set_rules('fkecamatan', '', 'required');
		$this->form_validation->set_rules('tprovince', '', 'required');
		$this->form_validation->set_rules('tkota', '', 'required');
		$this->form_validation->set_rules('tkecamatan', '', 'required');
		$this->form_validation->set_rules('hargapkg', '', 'required');
		$msg    = "error";
		$notif  = "";
		if ($this->form_validation->run() == TRUE){
            $fprovince    	= $this->db->escape_str($this->input->post('fprovince'));
            $fkota    	= $this->db->escape_str($this->input->post('fkota'));
            $fkecamatan    	= $this->db->escape_str($this->input->post('fkecamatan'));
            $tprovince    	= $this->db->escape_str($this->input->post('tprovince'));
            $tkota    	= $this->db->escape_str($this->input->post('tkota'));
            $tkecamatan    	= $this->db->escape_str($this->input->post('tkecamatan'));
            $hargapkg    	= $this->db->escape_str($this->input->post('hargapkg'));
			 $data_add  = array(
								'courier_id' 	=>$_SESSION['kurir_detail'],
								'location_from_province' => $fprovince ,
								'location_from_city'=>$fkota,
								'location_from_kecamatan'=>$fkecamatan,
								'location_to_province'=>$tprovince,
								'location_to_city'=>$tkota,
								'location_to_kecamatan'=>$tkecamatan,
								'price'=>$hargapkg,
								'create_date'	=> date("Y-m-d H:i:s"),
								'create_user'   => $_SESSION['bonobo_admin']->email
            );
			$insert = $this->db->insert('tb_courier_rate',$data_add);
            if($insert){
                $msg    = "success";
                $notif  = "Berhasil";
            }
		}else{
		
		}
		echo json_encode(array("msg"=>$msg,"notif"=>$notif));
	}
	
	public function set_city(){
		$province = $this->input->post('province');

		$city = $this->model_dkurir->get_kota($province);
		echo "<select  class='chosen-select' name='fkota' id='fkota' onchange=javascript:set_kecamatan()>
			<option value='' disabled selected>Pilih Kota</option>";
			foreach ($city->result() as $row_p) {
				echo "<option value='".$row_p->city."'>".$row_p->city."</option>";
			}			
		echo"</select>";
	}
	
	public function set_kecamatan(){
		$kota = $this->input->post('kota');

		$kota = $this->model_dkurir->get_kecamatan($kota);
		echo "<select  class='chosen-select' name='fkecamatan' id='fkecamatan'>
				<option value='' disabled selected>Pilih Kecamatan</option>";
			foreach ($kota->result() as $row_p) {
				echo "<option value='".$row_p->kecamatan."'>".$row_p->kecamatan."</option>";
			}			
		echo"</select>";
	}
	
	public function set_tcity(){
		$province = $this->input->post('province');

		$city = $this->model_dkurir->get_kota($province);
		echo "<select  class='chosen-select' name='tkota' id='tkota' onchange=javascript:set_tkecamatan()>
			<option value='' disabled selected>Pilih Kota</option>";
			foreach ($city->result() as $row_p) {
				echo "<option value='".$row_p->city."'>".$row_p->city."</option>";
			}			
		echo"</select>";
	}
	
	public function set_tkecamatan(){
		$kota = $this->input->post('kota');

		$kota = $this->model_dkurir->get_kecamatan($kota);
		echo "<select  class='chosen-select' name='tkecamatan' id='tkecamatan'>
				<option value='' disabled selected>Pilih Kecamatan</option>";
			foreach ($kota->result() as $row_p) {
				echo "<option value='".$row_p->kecamatan."'>".$row_p->kecamatan."</option>";
			}			
		echo"</select>";
	}
	public function set_edit(){
		$ffprovince = $this->input->post('ffprovince');
		$ffkota = $this->input->post('ffkota');
		$ffkecamatan = $this->input->post('ffkecamatan');
		$ftprovince = $this->input->post('ftprovince');
		$ftkota = $this->input->post('ftkota');
		$ftkecamatan = $this->input->post('ftkecamatan');
		$price = $this->input->post('price');

		$prove = $this->model_dkurir->get_province();
		echo "
		<div class='form-group' id='ffprovince'>
		<label for=''>Lokasi Awal</label>
		<select  class='chosen-select' name='fprovince' id='fprovince' onchange='javascript:sset_city(".$ffprovince.")' >
			<option value='' selected>Pilih Provinsi</option>";
			
			foreach ($prove->result() as $row_p) {
				$select = '';
				if ($row_p->province == $ffprovince) {$select = 'selected';}
				echo "<option $select value='".$row_p->province."'>".$row_p->province."</option>";
			}			
		echo"</select></div>";
		//
		$city = $this->model_dkurir->get_kota($ffprovince);
		echo "<div class='form-group' id='ffkota'>
		<select  class='chosen-select' name='fkota' id='fkota' onchange=javascript:sset_kecamatan('$ffkota')>
			<option value='' selected>Pilih Kota</option>";	
			foreach ($city->result() as $row_p) {
				$select = '';
				if ($row_p->city == $ffkota) {$select = 'selected';}
				echo "<option $select value='".$row_p->city."'>".$row_p->city."</option>";
			}
		echo"</select></div>";
		//
		$kota = $this->model_dkurir->get_kecamatan($ffkota);
		echo "<div class='form-group' id='ffkecamatan'>
		<select  class='chosen-select' name='fkecamatan' id='fkecamatan'>
				<option value='' selected>Pilih Kecamatan</option>";
				foreach ($kota->result() as $row_p) {
				$select = '';
					if ($row_p->kecamatan == $ffkecamatan) {$select = 'selected';}
					echo "<option $select value='".$row_p->kecamatan."'>".$row_p->kecamatan."</option>";
				}	
		echo"</select></div>";
		//
		$provet = $this->model_dkurir->get_province();
		echo"<div class='form-group'>
						<label for=''>Lokasi Tujuan</label>
		<select  class='chosen-select' name='tprovince' id='tprovince' onchange=javascript:sset_tcity('$ftprovince')>
		<option value='' selected>Pilih Provinsi</option>";
		foreach ($provet->result() as $row_pp) {
				$select = '';
				if ($row_pp->province == $ftprovince) {$select = 'selected';}
				echo "<option $select value='".$row_pp->province."'>".$row_pp->province."</option>";
		}	
		echo"
		</select></div>";
		//
		$city = $this->model_dkurir->get_kota($ftprovince);
		echo "<div class='form-group' id='ftkota'>
		<select  class='chosen-select' name='tkota' id='tkota' nchange=javascript:sset_tkecamatan('$ftkota')>
			<option value='' selected>Pilih Kota</option>";	
			foreach ($city->result() as $row_p) {
				$select = '';
				if ($row_p->city == $ftkota) {$select = 'selected';}
				echo "<option $select value='".$row_p->city."'>".$row_p->city."</option>";
			}
		echo"</select></div>";
		//
		$kota = $this->model_dkurir->get_kecamatan($ftkota);
		echo "<div class='form-group' id='ftkecamatan'>
		<select  class='chosen-select' name='tkecamatan' id='tkecamatan'>
				<option value='' selected>Pilih Kecamatan</option>";
				foreach ($kota->result() as $row_p) {
				$select = '';
					if ($row_p->kecamatan == $ftkecamatan) {$select = 'selected';}
					echo "<option $select value='".$row_p->kecamatan."'>".$row_p->kecamatan."</option>";
				}	
		echo"</select></div>
		<div class='form-group'>
						<label for=''>Harga per Kg</label>
						<input type='text' class='form-control' id='hargapkg' name='hargapkg' value='$price' >
					</div>
		";
	}
	
}
