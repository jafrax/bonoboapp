<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER INDEX WEBSITE
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Dinar Wahyu Wibowo, Create controller
*/

class Produk extends CI_Controller {

	function __construct(){
        parent::__construct();
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			redirect('index/signin/');
			return;
		}

		$this->load->model("enduser/model_produk");		
    }
	
	public function index(){		
		$this->template->bonobo('produk/bg_ready_stock');
	}

	public function add(){
		if ($_POST) {
			
		}
		$data['kategori']	= $this->model_produk->get_kategori($_SESSION['bonobo']['id']);

		$this->template->bonobo('produk/bg_ready_stock_add',$data);
	}

	public function edit(){
		
	}

	public function delete(){
		
	}


// =========================================================================

	public function add_kategori() {
		$id 	= $this->input->post('id');
		$nama 	= $this->input->post('nama');

		$data	= array(
			'toko_id'		=> $id,
			'name'			=> $nama,
			'create_user'	=> $_SESSION['bonobo']['email'],
			'update_user'	=> $_SESSION['bonobo']['email']
			);

		$insert	= $this->db->insert('tb_toko_category_product',$data);

		if ($insert) {
			$kategori = $this->model_produk->get_kategori($_SESSION['bonobo']['id']);

			echo "<select name='kategori' id='select-kategori'>
					<option value='' disabled selected>Choose your option</option>";
			
			foreach ($kategori->result() as $row_ktgri) {
				echo "<option value='".$row_ktgri->id."'>".$row_ktgri->name."</option>";
			}

			echo "</select>
			<label>Kategori barang</label>";
		}
	}

	
}

