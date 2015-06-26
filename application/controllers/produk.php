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
			$this->rules();

			if ($this->form_validation->run() == TRUE) {
				$tipe 			= $this->template->clearInput($this->input->post('tipe'));
				$nama 			= $this->template->clearInput($this->input->post('nama'));
				$sku 			= $this->template->clearInput($this->input->post('sku'));
				$kategori 		= $this->template->clearInput($this->input->post('kategori'));
				$berat 			= $this->template->clearInput($this->input->post('berat'));
				$satuan 		= $this->template->clearInput($this->input->post('satuan'));
				$min_order 		= $this->template->clearInput($this->input->post('min_order'));
				$deskripsi 		= $this->template->clearInput($this->input->post('deskripsi'));
				$stok 			= $this->template->clearInput($this->input->post('stok'));
				$stok_utama 	= $this->template->clearInput($this->input->post('stok_utama'));
				$harga_pembelian= $this->template->clearInput($this->input->post('harga_pembelian'));

				$total_picture 	= $this->template->clearInput($this->input->post('total_picture'));
				$total_varian 	= $this->template->clearInput($this->input->post('total_varian'));
				$gunakan_varian = $this->template->clearInput($this->input->post('gunakan_varian'));
				$action 		= $this->template->clearInput($this->input->post('action'));
				$harga_level_1 	= $this->template->clearInput($this->input->post('harga_level_1'));
				$harga_level_2 	= $this->template->clearInput($this->input->post('harga_level_2'));
				$harga_level_3 	= $this->template->clearInput($this->input->post('harga_level_3'));
				$harga_level_4 	= $this->template->clearInput($this->input->post('harga_level_4'));
				$harga_level_5 	= $this->template->clearInput($this->input->post('harga_level_5'));

				$data = array(
					'stock_type_detail'			=> $tipe,
					'toko_category_product_id'	=> $kategori,
					'active'					=> $action,
					'name'						=> $nama,
					'sku_no'					=> $sku,
					'weight'					=> $berat,
					'unit'						=> $satuan,
					'min_order'					=> $min_order,
					'description'				=> $deskripsi,
					'stock_type'				=> $stok,
					'price_base'				=> $harga_pembelian,
					'price_1'					=> $harga_level_1,
					'price_2'					=> $harga_level_2,
					'price_3'					=> $harga_level_3,
					'price_4'					=> $harga_level_4,
					'price_5'					=> $harga_level_5,
					'create_user'				=> $_SESSION['bonobo']['email'],
					'update_user'				=> $_SESSION['bonobo']['email']
					);

				$insert = $this->db->insert('tb_product',$data);
				
				if ($insert) {
					$id = $this->db->where('name',$nama)->where('sku_no',$sku)->where('create_user',$_SESSION['bonobo']['email'])->get('tb_product')->row()->id;

					$pic=1;
					$url    = 'assets/pic/product/';
					for($i=1;$i<=$total_picture;$i++){
						if($pic <= 3){
							if(isset($_FILES['pic_'.$i]['name'])){
								$picture = $this->template->upload_picture($url,'pic_'.$i);
								if($picture != 'error'){
									$this->db->set('file',$picture)
										->set('product_id',$id)
										->set('create_user',$_SESSION['bonobo']['email'])
										->set('update_user',$_SESSION['bonobo']['email'])
										->insert('tb_product_image');
								}
								$pic++;								
							}
						}
					}

					if ($gunakan_varian != 'on') {
						$this->db->set('product_id',$id)
								->set('name','null')
								->set('stock_qty',$stok_utama)
								->set('create_user',$_SESSION['bonobo']['email'])
								->set('update_user',$_SESSION['bonobo']['email'])
								->insert('tb_product_varian');
					}else{
						$var=1;
						for($i=1;$i<=$total_varian;$i++){
							if($var <= 3){
								if(isset($_POST['nama_varian_'.$i])){
									$nama_varian = $this->template->clearInput($this->input->post('nama_varian_'.$i));
									$stok_varian = $this->template->clearInput($this->input->post('stok_varian_'.$i));

									$this->db->set('product_id',$id)
										->set('name',$nama_varian)
										->set('stock_qty',$stok_varian)
										->set('create_user',$_SESSION['bonobo']['email'])
										->set('update_user',$_SESSION['bonobo']['email'])
										->insert('tb_product_varian');
									echo $nama_varian.'<br>';
									$var++;
								}
							}
						}
					}
				}
				//redirect('produk');
			}
		}


		$data['kategori']		= $this->model_produk->get_kategori($_SESSION['bonobo']['id']);
		$data['level_harga']	= $this->model_produk->get_toko($_SESSION['bonobo']['id'])->row();

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

	private function rules(){
		$this->form_validation->set_rules('tipe', '', 'required');
		$this->form_validation->set_rules('nama', '', 'required|max_length[50]');
		$this->form_validation->set_rules('sku', '', 'max_length[20]');
		$this->form_validation->set_rules('kategori', '', 'max_length[100]');
		$this->form_validation->set_rules('berat', '', 'max_length[100]');
		$this->form_validation->set_rules('satuan', '', 'max_length[5]');
		$this->form_validation->set_rules('min_order', '', 'numeric|max_length[100]');
		$this->form_validation->set_rules('deskripsi', '', 'max_length[250]');
		$this->form_validation->set_rules('stok', '', 'numeric|max_length[100]');
		$this->form_validation->set_rules('harga_pembelian', '', 'numeric|max_length[100]');
	}

	
}

