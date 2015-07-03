<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER PRODUK WEBSITE
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Dinar Wahyu Wibowo, Create controller
*/

class Nota extends CI_Controller {

	function __construct(){
        parent::__construct();
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			redirect('index/signin/');
			return;
		}

		$this->load->model("enduser/model_nota");		
    }
	
	public function index(){
		$data['nota']	= $this->model_nota->get_nota();		

		$this->template->bonobo('nota/bg_nota',$data);
	}

	private function cek_id($id){

	}

	public function change_note(){
		$id 	= $this->input->post('id');
		$note 	= $this->input->post('note');

		$cek_id	= $this->model_nota->get_nota_by_id($id);

		if ($cek_id->num_rows == 0) {
			echo "0";
			return;
		}

		$update = $this->db->set('notes',$note)->where('id',$id)->update('tb_invoice');
		if ($update) {
			echo "1";
		}
	}

	public function nota_batal(){
		$id 	= $this->input->post('id');

		$cek_id	= $this->model_nota->get_nota_by_id($id);

		if ($cek_id->num_rows == 0) {
			echo "0";
			return;
		}

		$update = $this->db->set('status',2)->where('id',$id)->update('tb_invoice');
		if ($update) {
			echo "1";
		}
	}

	public function nota_delete(){
		$id 	= $this->input->post('id');

		$cek_id	= $this->model_nota->get_nota_by_id($id);

		if ($cek_id->num_rows == 0) {
			echo "0";
			return;
		}

		$delete = $this->db->where('id',$id)->delete('tb_invoice');
		if ($delete) {
			echo "1";
		}
	}
}

