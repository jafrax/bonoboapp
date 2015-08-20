<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER PRODUK WEBSITE
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Dinar Wahyu Wibowo, Create controller,  All function
*/

class Produk extends CI_Controller {

	function __construct(){
        parent::__construct();
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			
			redirect('index/signin/');
			return;
		}
		$this->template->cek_license();
		$this->load->model("enduser/model_produk");		
    }

    var $limit_pro 	= 10;
	var $offset_pro = 0;
	
	public function index(){
		$uri =  $this->uri->segment(3);

		$page 	= $this->uri->segment(4);        
        $limit_pro 	= $this->limit_pro;
        if(!$page){
        	$offset_pro = $this->offset_pro;
        }else{
            $offset_pro = $page;
        }

		if ($uri == '') {
			redirect('produk/index/1');	
		}

		$data['produk'] 	= $this->model_produk->get_produk_by_id($_SESSION['bonobo']['id'],1,$uri,$limit_pro,$offset_pro);
		$data['total'] 		= $this->model_produk->get_produk_by_id($_SESSION['bonobo']['id'],1,$uri)->num_rows();
		$data['kategori']	= $this->model_produk->get_kategori($_SESSION['bonobo']['id']);

		if ($this->input->post('ajax')) {
			if ($data['produk']->num_rows() > 0){
                $satu = $this->load->view('enduser/produk/bg_ready_stock_ajax1', $data,TRUE);
                $dua = $this->load->view('enduser/produk/bg_ready_stock_ajax2', $data,TRUE);
                echo json_encode(array('msg' => 'success','satu' => base64_encode($satu),'dua' => base64_encode($dua)));
            }else{
            	echo json_encode(array('msg' => 'habis'));
            }
        } else {
            $this->template->bonobo('produk/bg_ready_stock',$data);
        }
		
	}

	public function add(){
		if ($_POST) {
			$this->rules();

			if ($this->form_validation->run() == TRUE) {
				$tipe 			= $this->template->clearInput($this->input->post('tipe'));
				$nama 			= $this->template->clearInput($this->input->post('nama'));
				$sku 			= $this->template->clearInput($this->input->post('sku'));
				$kategori 		= $this->template->clearInput($this->input->post('kategori'));
				$berat 			= round($this->input->post('berat'),2);
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
					'stock_type_detail'			=> $stok,
					'toko_category_product_id'	=> $kategori,
					'active'					=> $action,
					'name'						=> $nama,
					'sku_no'					=> $sku,
					'weight'					=> $berat,
					'unit'						=> $satuan,
					'min_order'					=> $min_order,
					'description'				=> $deskripsi,
					'stock_type'				=> $tipe,
					'price_base'				=> $harga_pembelian,
					'price_1'					=> str_replace('.','',$harga_level_1),
					'price_2'					=> str_replace('.','',$harga_level_2),
					'price_3'					=> str_replace('.','',$harga_level_3),
					'price_4'					=> str_replace('.','',$harga_level_4),
					'price_5'					=> str_replace('.','',$harga_level_5),
					'create_user'				=> $_SESSION['bonobo']['email'],
					'create_date'				=> date('Y-m-d H:i:s'),
					'update_user'				=> $_SESSION['bonobo']['email']
					);

				$insert = $this->db->insert('tb_product',$data);
				
				if ($insert) {
					$id = $this->db->where('name',$nama)->where('create_user',$_SESSION['bonobo']['email'])->where('toko_category_product_id',$kategori)->where('price_1',str_replace('.','',$harga_level_1))->order_by('create_date','DESC')->get('tb_product')->row()->id;

					$pic=1;
					$url    = 'assets/pic/product/';
					for($i=1;$i<=5;$i++){
						if($pic <= 5){
							if(isset($_FILES['pic_'.$i]['name'])){
								$picture = $this->template->upload_picture($url,'pic_'.$i);
								if($picture != 'error'){
									$this->db->set('file',$picture)
										->set('product_id',$id)
										->set('create_user',$_SESSION['bonobo']['email'])
										->set('create_date',date('Y-m-d H:i:s'))
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
								->set('create_date',date('Y-m-d H:i:s'))
								->set('update_user',$_SESSION['bonobo']['email'])
								->insert('tb_product_varian');
					}else{
						$var=1;
						for($i=1;$i<=$total_varian;$i++){
							if(isset($_POST['nama_varian_'.$i])){
								if ($_POST['nama_varian_'.$i] != '') {
									$nama_varian = $this->template->clearInput($this->input->post('nama_varian_'.$i));
									$stok_varian = $this->template->clearInput($this->input->post('stok_varian_'.$i));

									$this->db->set('product_id',$id)
										->set('name',$nama_varian)
										->set('stock_qty',$stok_varian)
										->set('create_user',$_SESSION['bonobo']['email'])
										->set('create_date',date('Y-m-d H:i:s'))
										->set('update_user',$_SESSION['bonobo']['email'])
										->insert('tb_product_varian');
									//echo $nama_varian.'<br>';
									$var++;
								}
							}							
						}
					}
				}
				redirect('produk');
			}
		}


		$data['kategori']		= $this->model_produk->get_kategori($_SESSION['bonobo']['id']);
		$data['level_harga']	= $this->model_produk->get_toko($_SESSION['bonobo']['id'])->row();

		$this->template->bonobo('produk/bg_ready_stock_add',$data);
	}

	public function edit(){
		$uri = base64_decode($this->uri->segment(3));

		$produk = $this->model_produk->get_one_produk($uri);
		if ($produk->num_rows == 0) {
			redirect('error');
		}

		if ($_POST) {
			$this->rules();

			if ($this->form_validation->run() == TRUE) {
				$tipe 			= $this->template->clearInput($this->input->post('tipe'));
				$nama 			= $this->template->clearInput($this->input->post('nama'));
				$sku 			= $this->template->clearInput($this->input->post('sku'));
				$kategori 		= $this->template->clearInput($this->input->post('kategori'));
				$berat 			= round($this->input->post('berat'),2);
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
					'stock_type_detail'			=> $stok,
					'toko_category_product_id'	=> $kategori,
					'active'					=> $action,
					'name'						=> $nama,
					'sku_no'					=> $sku,
					'weight'					=> $berat,
					'unit'						=> $satuan,
					'min_order'					=> $min_order,
					'description'				=> $deskripsi,					
					'price_base'				=> $harga_pembelian,
					'price_1'					=> str_replace('.','',$harga_level_1),
					'price_2'					=> str_replace('.','',$harga_level_2),
					'price_3'					=> str_replace('.','',$harga_level_3),
					'price_4'					=> str_replace('.','',$harga_level_4),
					'price_5'					=> str_replace('.','',$harga_level_5),
					'update_user'				=> $_SESSION['bonobo']['email']
					);

				$update = $this->db->where('id',$uri)->update('tb_product',$data);
				
				if ($update) {
					$id = $uri;

					$url    = 'assets/pic/product/';
					$pic 	= $this->model_produk->get_one_image($id);
					foreach($pic->result() as $item){
						if(isset($_FILES['pic_edit_'.$item->id]['name'])){
							$picture = $this->template->upload_picture($url,'pic_edit_'.$item->id,$item->file);
							if($picture != 'error'){
								$this->db->set('file',$picture)
									->set('update_user',$_SESSION['bonobo']['email'])
									->where('id',$item->id)->update('tb_product_image');
							}
						}else{
							$delete = $this->db->where('id',$item->id)->delete('tb_product_image');
							if($delete){
								@unlink($url.$item->file);
								@unlink($url."resize/".$item->file);
							}
						}
					}

					$pic 	= 1;
					
					for($i=1;$i<=$total_picture;$i++){
						if($pic <= 5){
							if(isset($_FILES['pic_'.$i]['name'])){
								$picture = $this->template->upload_picture($url,'pic_'.$i);
								if($picture != 'error'){
									$this->db->set('file',$picture)
										->set('product_id',$id)
										->set('create_user',$_SESSION['bonobo']['email'])
										->set('create_date',date('Y-m-d H:i:s'))
										->set('update_user',$_SESSION['bonobo']['email'])
										->insert('tb_product_image');
								}
								$pic++;								
							}
						}
					}

					if ($gunakan_varian != 'on') {
						$no_varian = $this->model_produk->get_varian_produk_null($id);

						if ($no_varian->num_rows() > 0) {							
							$this->db->where('product_id',$id)->where('name !=','null')->delete('tb_product_varian');
							$this->db->set('stock_qty',$stok_utama)->where('product_id',$id)->where('name','null')->update('tb_product_varian');
						}else{
							$this->db->where('product_id',$id)->delete('tb_product_varian');
							$this->db->set('product_id',$id)
								->set('name','null')
								->set('stock_qty',$stok_utama)
								->set('create_user',$_SESSION['bonobo']['email'])
								->set('create_date',date('Y-m-d H:i:s'))
								->set('update_user',$_SESSION['bonobo']['email'])
								->insert('tb_product_varian');
						}						
					}else{
						$this->db->where('product_id',$id)->where('name','null')->delete('tb_product_varian');
						$desc = $this->model_produk->get_varian_produk($id);
						foreach($desc->result() as $item){
							if(isset($_POST['nama_edit_varian_'.$item->id]) || isset($_POST['stok_edit_varian_'.$item->id])){
								$title 	= ($this->input->post('nama_edit_varian_'.$item->id));
								$content= ($this->input->post('stok_edit_varian_'.$item->id));
								if($item->name != $title || $item->stock_qty != $content ){
									$this->db->set('name',$title)->set('stock_qty',$content)->set('update_user',$_SESSION['bonobo']['email'])->where('id',$item->id)->update('tb_product_varian');
								}
							}else{
								$this->db->where('id',$item->id)->delete('tb_product_varian');
							}
						}
						
						$var=1;
						for($i=1;$i<=$total_varian;$i++){
							if(isset($_POST['nama_varian_'.$i])){
								if ($_POST['nama_varian_'.$i] != '') {
									$nama_varian = $this->template->clearInput($this->input->post('nama_varian_'.$i));
									$stok_varian = $this->template->clearInput($this->input->post('stok_varian_'.$i));

									$this->db->set('product_id',$id)
										->set('name',$nama_varian)
										->set('stock_qty',$stok_varian)
										->set('create_user',$_SESSION['bonobo']['email'])
										->set('create_date',date('Y-m-d H:i:s'))
										->set('update_user',$_SESSION['bonobo']['email'])
										->insert('tb_product_varian');
									//echo $nama_varian.'<br>';
									$var++;
								}
							}							
						}
					}
				}
				redirect('produk');
			}
		}


		$data['produk']			= $produk->row();
		$data['kategori']		= $this->model_produk->get_kategori($_SESSION['bonobo']['id']);
		$data['level_harga']	= $this->model_produk->get_toko($_SESSION['bonobo']['id'])->row();
		$this->template->bonobo('produk/bg_ready_stock_edit',$data);
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
			'create_date'	=> date('Y-m-d H:i:s'),
			'update_user'	=> $_SESSION['bonobo']['email']
			);

		$insert	= $this->db->insert('tb_toko_category_product',$data);

		if ($insert) {
			$kategori = $this->model_produk->get_kategori($_SESSION['bonobo']['id']);

			echo "<label>Kategori Barang <span class='text-red'>*</span></label>
					<label class='error error-chosen' for='select-kategori'></label>
					<select name='kategori' id='select-kategori' class='select-standar' required>
					<option value='' disabled selected>Pilih Kategori Barang</option>";
			
			foreach ($kategori->result() as $row_ktgri) {
				echo "<option value='".$row_ktgri->id."'>".$row_ktgri->name."</option>";
			}

			echo "</select>
			";
		}
	}

	public function rules_kategori(){
		$username = $_REQUEST['nama_kategori'];
	    $cek=$this->db->where('name',$username)->where('toko_id',$_SESSION['bonobo']['id'])->get('tb_toko_category_product');
	    if($cek->num_rows()>0){
			$valid = "false";
	    }else{
			$valid = "true";
	    }
	    echo $valid;
	}

	private function rules(){		
		$this->form_validation->set_rules('nama', '', 'required|max_length[50]');
		$this->form_validation->set_rules('sku', '', 'max_length[20]');
		$this->form_validation->set_rules('kategori', '', 'max_length[100]');
		$this->form_validation->set_rules('berat', '', 'max_length[100]');
		$this->form_validation->set_rules('satuan', '', 'max_length[5]');
		$this->form_validation->set_rules('min_order', '', 'max_length[100]');
		$this->form_validation->set_rules('deskripsi', '', 'max_length[250]');
		$this->form_validation->set_rules('stok', '', 'max_length[100]');
		$this->form_validation->set_rules('harga_pembelian', '', 'max_length[100]');
	}


	public function change_stock(){
		$id = $this->input->post('id');
		$stok = $this->input->post('stok');

		$this->db->where('id',$id)->set('stock_qty',$stok)->update('tb_product_varian');
		echo $stok;
	}


// Option GO =========================================================================

	public function delete_product(){
		$id 	= $this->input->post('id');
		$uri 	= $this->input->post('uri');
		$url   	= 'assets/pic/product/';
		$image 	= $this->model_produk->get_one_image($id);
		foreach ($image->result() as $row) {
			$picture = $row->file;
			@unlink($url.$picture);
        	@unlink($url."resize/$picture");
		}

		$delete = $this->db->where('id',$id)->delete('tb_product');
		if ($delete) {
			if ($uri == 'index') {
				$total = $this->model_produk->get_produk_by_id($_SESSION['bonobo']['id'],1,1)->num_rows();
			}else{
				$total = $this->model_produk->get_produk_by_id($_SESSION['bonobo']['id'],0,1)->num_rows();
			}			
			echo "$total";	
		}else{
			echo "0";
		}
	}

	public function draft_product(){
		$id 	= $this->input->post('id');

		$this->db->where('id',$id)->set('active',0)->update('tb_product');
		echo "2";
	}

	public function publish_product(){
		$id 	= $this->input->post('id');

		$this->db->where('id',$id)->set('active',1)->update('tb_product');
		echo "3";	
	}

	public function ready_product(){
		$id 	= $this->input->post('id');

		$this->db->where('id',$id)->set('stock_type',1)->update('tb_product');
		echo "4";
	}

	public function pre_order_product(){
		$id 	= $this->input->post('id');
		$date = $this->db->where('id',$id)->get('tb_product')->row()->end_date;

		if ($date == '0000-00-00') {
			$this->db->where('id',$id)->set('stock_type',0)->set('end_date',date('Y-m-d'))->update('tb_product');
		}else{
			$this->db->where('id',$id)->set('stock_type',0)->set('end_date',date('Y-m-d'))->update('tb_product');
		}		
		echo "5";
	}

	public function set_search(){
		$_SESSION['keyword'] = $this->input->post('keyword');
	}






/* =========================================================================================================================
/* =========================================================================================================================
* PRE ORDER
*
* Create 30 Juni 2015 by Dinar Wahyu Wibowo
*/
	var $limit_pre 	= 10;
	var $offset_pre = 0;
	public function pre_order(){
		$uri =  $this->uri->segment(3);

		$page 	= $this->uri->segment(4);        
        $limit_pre 	= $this->limit_pre;
        if(!$page){
        	$offset_pre = $this->offset_pre;
        }else{
            $offset_pre = $page;
        }

		if ($uri == '') {
			redirect('produk/pre_order/1');	
		}

		$data['produk'] 	= $this->model_produk->get_produk_by_id($_SESSION['bonobo']['id'],0,$uri,$limit_pre,$offset_pre);
		$data['total'] 		= $this->model_produk->get_produk_by_id($_SESSION['bonobo']['id'],0,$uri)->num_rows();
		$data['kategori']	= $this->model_produk->get_kategori($_SESSION['bonobo']['id']);

		if ($this->input->post('ajax')) {
			if ($data['produk']->num_rows() > 0){
                $satu = $this->load->view('enduser/produk/bg_pre_order_ajax1', $data,TRUE);
                $dua = $this->load->view('enduser/produk/bg_pre_order_ajax2', $data,TRUE);
                echo json_encode(array('msg' => 'success','satu' => base64_encode($satu),'dua' => base64_encode($dua)));
            }else{
            	echo json_encode(array('msg' => 'habis'));
            }
        } else {
            $this->template->bonobo('produk/bg_pre_order',$data);
        }
		
	}

	public function add_pre_order(){
		if ($_POST) {
			$this->rules_pre_order();

			if ($this->form_validation->run() == TRUE) {
				$tipe 			= $this->template->clearInput($this->input->post('tipe'));
				$nama 			= $this->template->clearInput($this->input->post('nama'));
				$sku 			= $this->template->clearInput($this->input->post('sku'));
				$tgl_pre_order	= $this->template->clearInput($this->input->post('tgl_pre_order_submit'));
				$kategori 		= $this->template->clearInput($this->input->post('kategori'));
				$berat 			= $this->template->clearInput(round($this->input->post('berat'),2));
				$satuan 		= $this->template->clearInput($this->input->post('satuan'));
				$min_order 		= $this->template->clearInput($this->input->post('min_order'));
				$deskripsi 		= $this->template->clearInput($this->input->post('deskripsi'));				
				$harga_pembelian= $this->template->clearInput($this->input->post('harga_pembelian'));

				$total_picture 	= $this->template->clearInput($this->input->post('total_picture'));				
				$action 		= $this->template->clearInput($this->input->post('action'));
				$harga_level_1 	= $this->template->clearInput($this->input->post('harga_level_1'));
				$harga_level_2 	= $this->template->clearInput($this->input->post('harga_level_2'));
				$harga_level_3 	= $this->template->clearInput($this->input->post('harga_level_3'));
				$harga_level_4 	= $this->template->clearInput($this->input->post('harga_level_4'));
				$harga_level_5 	= $this->template->clearInput($this->input->post('harga_level_5'));
				
				if ($tgl_pre_order == '') {
					$tgl_pre_order = date('Y-m-d');
				}

				$data = array(
					'stock_type'				=> 0,
					'toko_category_product_id'	=> $kategori,
					'active'					=> $action,
					'name'						=> $nama,
					'sku_no'					=> $sku,
					'end_date'					=> $tgl_pre_order,
					'weight'					=> $berat,
					'unit'						=> $satuan,
					'min_order'					=> $min_order,
					'description'				=> $deskripsi,					
					'price_base'				=> $harga_pembelian,
					'price_1'					=> str_replace('.','',$harga_level_1),
					'price_2'					=> str_replace('.','',$harga_level_2),
					'price_3'					=> str_replace('.','',$harga_level_3),
					'price_4'					=> str_replace('.','',$harga_level_4),
					'price_5'					=> str_replace('.','',$harga_level_5),
					'create_user'				=> $_SESSION['bonobo']['email'],
					'create_date'				=> date('Y-m-d H:i:s'),
					'update_user'				=> $_SESSION['bonobo']['email']
					);

				$insert = $this->db->insert('tb_product',$data);
				
				if ($insert) {
					$id = $this->db->where('name',$nama)->where('sku_no',$sku)->where('create_user',$_SESSION['bonobo']['email'])->where('toko_category_product_id',$kategori)->where('price_1',$harga_level_1)->order_by('create_date','DESC')->get('tb_product')->row()->id;

					$pic=1;
					$url    = 'assets/pic/product/';
					for($i=1;$i<=$total_picture;$i++){
						if($pic <= 5){
							if(isset($_FILES['pic_'.$i]['name'])){
								$picture = $this->template->upload_picture($url,'pic_'.$i);
								if($picture != 'error'){
									$this->db->set('file',$picture)
										->set('product_id',$id)
										->set('create_user',$_SESSION['bonobo']['email'])
										->set('create_date',date('Y-m-d H:i:s'))
										->set('update_user',$_SESSION['bonobo']['email'])
										->insert('tb_product_image');
								}
								$pic++;								
							}
						}
					}

					$this->db->set('product_id',$id)
								->set('name','null')
								->set('stock_qty',0)
								->set('create_user',$_SESSION['bonobo']['email'])
								->set('create_date',date('Y-m-d H:i:s'))
								->set('update_user',$_SESSION['bonobo']['email'])
								->insert('tb_product_varian');
					
				}
				redirect('produk/pre_order');
			}
		}


		$data['kategori']		= $this->model_produk->get_kategori($_SESSION['bonobo']['id']);
		$data['level_harga']	= $this->model_produk->get_toko($_SESSION['bonobo']['id'])->row();

		$this->template->bonobo('produk/bg_pre_order_add',$data);
	}

	public function edit_pre_order(){
		$uri = base64_decode($this->uri->segment(3));

		$produk = $this->model_produk->get_one_produk($uri);
		if ($produk->num_rows == 0) {
			redirect('error');
		}

		if ($_POST) {
			$this->rules_pre_order();

			if ($this->form_validation->run() == TRUE) {
				$tipe 			= $this->template->clearInput($this->input->post('tipe'));
				$nama 			= $this->template->clearInput($this->input->post('nama'));
				$sku 			= $this->template->clearInput($this->input->post('sku'));
				$tgl_pre_order	= $this->template->clearInput($this->input->post('tgl_pre_order_submit'));
				$kategori 		= $this->template->clearInput($this->input->post('kategori'));
				$berat 			= $this->template->clearInput(round($this->input->post('berat'),2));
				$satuan 		= $this->template->clearInput($this->input->post('satuan'));
				$min_order 		= $this->template->clearInput($this->input->post('min_order'));
				$deskripsi 		= $this->template->clearInput($this->input->post('deskripsi'));				
				$harga_pembelian= $this->template->clearInput($this->input->post('harga_pembelian'));

				$total_picture 	= $this->template->clearInput($this->input->post('total_picture'));				
				$action 		= $this->template->clearInput($this->input->post('action'));
				$harga_level_1 	= $this->template->clearInput($this->input->post('harga_level_1'));
				$harga_level_2 	= $this->template->clearInput($this->input->post('harga_level_2'));
				$harga_level_3 	= $this->template->clearInput($this->input->post('harga_level_3'));
				$harga_level_4 	= $this->template->clearInput($this->input->post('harga_level_4'));
				$harga_level_5 	= $this->template->clearInput($this->input->post('harga_level_5'));

				$data = array(					
					'toko_category_product_id'	=> $kategori,
					'active'					=> $action,
					'name'						=> $nama,
					'sku_no'					=> $sku,
					'end_date'					=> $tgl_pre_order,
					'weight'					=> $berat,
					'unit'						=> $satuan,
					'min_order'					=> $min_order,
					'description'				=> $deskripsi,					
					'price_base'				=> $harga_pembelian,
					'price_1'					=> str_replace('.','',$harga_level_1),
					'price_2'					=> str_replace('.','',$harga_level_2),
					'price_3'					=> str_replace('.','',$harga_level_3),
					'price_4'					=> str_replace('.','',$harga_level_4),
					'price_5'					=> str_replace('.','',$harga_level_5),					
					'update_user'				=> $_SESSION['bonobo']['email']
					);

				$update = $this->db->where('id',$uri)->update('tb_product',$data);
				
				if ($update) {
					$id = $uri;

					$url    = 'assets/pic/product/';
					$pic 	= $this->model_produk->get_one_image($id);
					foreach($pic->result() as $item){
						if(isset($_FILES['pic_edit_'.$item->id]['name'])){
							$picture = $this->template->upload_picture($url,'pic_edit_'.$item->id,$item->file);
							if($picture != 'error'){
								$this->db->set('file',$picture)
									->set('update_user',$_SESSION['bonobo']['email'])
									->where('id',$item->id)->update('tb_product_image');
							}
						}else{
							$delete = $this->db->where('id',$item->id)->delete('tb_product_image');
							if($delete){
								@unlink($url.$item->file);
								@unlink($url."resize/".$item->file);
							}
						}
					}

					$pic 	= 1;
					
					for($i=1;$i<=$total_picture;$i++){
						if($pic <= 5){
							if(isset($_FILES['pic_'.$i]['name'])){
								$picture = $this->template->upload_picture($url,'pic_'.$i);
								if($picture != 'error'){
									$this->db->set('file',$picture)
										->set('product_id',$id)
										->set('create_user',$_SESSION['bonobo']['email'])
										->set('create_date',date('Y-m-d H:i:s'))
										->set('update_user',$_SESSION['bonobo']['email'])
										->insert('tb_product_image');
								}
								$pic++;								
							}
						}
					}
				}
				redirect('produk/pre_order');
			}
		}


		$data['produk']			= $produk->row();
		$data['kategori']		= $this->model_produk->get_kategori($_SESSION['bonobo']['id']);
		$data['level_harga']	= $this->model_produk->get_toko($_SESSION['bonobo']['id'])->row();
		$this->template->bonobo('produk/bg_pre_order_edit',$data);
	}


// =========================================================================


	private function rules_pre_order(){
		
		$this->form_validation->set_rules('nama', '', 'required|max_length[50]');
		$this->form_validation->set_rules('sku', '', 'max_length[20]');
		$this->form_validation->set_rules('kategori', '', 'max_length[100]');
		$this->form_validation->set_rules('berat', '', 'max_length[100]');
		$this->form_validation->set_rules('satuan', '', 'max_length[5]');
		$this->form_validation->set_rules('min_order', '', 'max_length[100]');
		$this->form_validation->set_rules('deskripsi', '', 'max_length[250]');		
		$this->form_validation->set_rules('harga_pembelian', '', 'max_length[100]');
	}

	public function change_date(){
		$id 	= $this->input->post('id');
		$date 	= $this->input->post('date');

		$old_date 			= $date;
		$old_date_timestamp = strtotime($old_date);
		$new_date 			= date('Y-m-d', $old_date_timestamp);

		if (date('Y-m-d') > $new_date) {
			$edit = $this->db->where('id',$id)->set('end_date',$new_date)->update('tb_product');
			echo "kadaluarsa";
		}else{
			$edit = $this->db->where('id',$id)->set('end_date',$new_date)->update('tb_product');
			echo "sukses";
		}		
	}











/* =========================================================================================================================
/* =========================================================================================================================
* Atur Kategori
*
* Create 1 Juli 2015 by Dinar Wahyu Wibowo
*/
	var $limit 	= 10;
	var $offset = 0;
	function atur_kategori(){
		$data['kategori']	= $this->model_produk->get_kategori($_SESSION['bonobo']['id']);
		unset($_SESSION['search_kategori']);

		$page 	= $this->uri->segment(3);        
        $limit 	= $this->limit;
        if(!$page){
        	$offset = $this->offset;
        }else{
            $offset = $page;
        }

        $data['kategori'] 		= $this->model_produk->get_kategori($_SESSION['bonobo']['id'],$limit,$offset);
        
		if ($this->input->post('ajax')) {
			if ($data['kategori']->num_rows() > 0){
                $this->load->view('enduser/produk/bg_atur_kategori_ajax', $data);
            }
        } else {
            $this->template->bonobo('produk/bg_atur_kategori', $data);
        }
	}

	public function add_kategori2() {
		$id 	= $this->input->post('id');
		$nama 	= $this->template->clearInput($this->input->post('nama'));

		$data	= array(
			'toko_id'		=> $id,
			'name'			=> $nama,
			'create_user'	=> $_SESSION['bonobo']['email'],
			'create_date'	=> date('Y-m-d H:i:s'),
			'update_user'	=> $_SESSION['bonobo']['email']
			);

		$insert	= $this->db->insert('tb_toko_category_product',$data);

		if ($insert) {
			$this->print_kategori();
		}
	}

	private function print_kategori(){
		$kategori = $this->model_produk->get_kategori($_SESSION['bonobo']['id'],10,0);
		if ($kategori->num_rows() == 0) {
			if (isset($_SESSION['search_kategori'])) {
				echo "Kategori \"".$_SESSION['search_kategori']."\" tidak ditemukan";
				//unset($_SESSION['search_kategori']);
			}else{
				echo "Kategori kosong";
			}
		}
			foreach ($kategori->result() as $row) {
				$count = $this->model_produk->count_product_by_category($row->id);
				echo"									
				<li class='col s12 listanggonew' id='kategori-".$row->id."'>
					<div class='col s12 m7'><p><b>".$row->name."</b> <i> $count Produk</i></p>
					</div>
					<div class='col s12 m5'>
						<a href='#delete_kategori_".$row->id."' class='modal-trigger btn-flat right'><b class='text-red'><i class='mdi-av-not-interested left'></i>Hapus</b></a>
						<a href='#edit_kategori_".$row->id."' onclick=javascript:set_rules(".$row->id.") class='modal-trigger btn-flat right'><b class='blue-text'><i class='mdi-editor-border-color left'></i>Edit</b></a>
						<div id='delete_kategori_".$row->id."' class='modal confirmation'>
							<div class='modal-header red'>
								<i class='mdi-navigation-close left'></i> Hapus produk
							</div>
							<form class='modal-content'>
								<p>Apakah anda yakin ingin menghapus <b>'".$row->name."'</b> ?</p>
							</form>
							<div class='modal-footer'>
								<a onclick=javascript:delete_kategori('".$row->id."') class=' modal-action modal-close waves-effect waves-red btn-flat'>YA</a>
								<a  class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
							</div>
						</div>

						<div id='edit_kategori_".$row->id."' class='modal confirmation'>
							<div class='modal-header deep-orange'>
								<i class='mdi-action-spellcheck left'></i> Edit kategori
							</div>
							<form class='modal-content' id='form_edit_kategori_".$row->id."'>
								<p>
									<div class='input-field col s12'>														
										<input id='nama_".$row->id."' name='nama_kategori' type='text' value='".$row->name."' class='validate'>
										<label for='nama_".$row->id."'>Kategori</label>
									</div>
							    </p>
							</form>
							<div class='modal-footer'>
								<a onclick=javascript:edit_kategori('".$row->id."') class=' modal-action waves-effect waves-red btn-flat'>YA</a>
								<a  class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
							</div>
						</div>
					</div>
				</li>";
			}
	}


	public function delete_kategori(){
		$id = $this->input->post('id');
		$produk = $this->model_produk->count_product_by_category($id);
		if ($produk > 0) {
			echo "Kategori masih memiliki produk";
			return;
		}
		$delete = $this->db->where('id',$id)->delete('tb_toko_category_product');
		if ($delete) {
			echo "1";
		}else{
			echo "0";
		}
	}

	public function edit_kategori(){
		$id = $this->input->post('id');
		$nama = $this->input->post('nama');
		$edit = $this->db->where('id',$id)->set('name',$nama)->update('tb_toko_category_product');
		if ($edit) {
			$this->print_kategori();
		}
	}

	public function set_search_kategori(){
		$keyword = $this->input->post('keyword');
		$_SESSION['search_kategori'] = $keyword;

		$this->print_kategori();
	}	


	public function set_filter_kategori(){
		$kategori = $this->input->post('kategori');
		$_SESSION['filter_kategori'] = $kategori;		
	}	
}

