<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER NOTA WEBSITE
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Dinar Wahyu Wibowo, Create controller, All function
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
		unset($_SESSION['sort']);
		unset($_SESSION['tipe_bayar']);
		unset($_SESSION['tipe_stok']);
		unset($_SESSION['flagger']);
		unset($_SESSION['search']);
		unset($_SESSION['keyword']);
		
		$data['nota']		= $this->model_nota->get_nota();
		$data['rekening']	= $this->model_nota->get_rekening();
		$data['toko']		= $this->model_nota->get_toko()->row();		

		$this->template->bonobo('nota/bg_nota',$data);
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

	public function konfirmasi(){
		$id 		= $this->input->post('id');
		$metode 	= $this->input->post('metode');
		$rekening 	= $this->input->post('rekening');

		$cek_id	= $this->model_nota->get_nota_by_id($id);

		if ($cek_id->num_rows == 0) {
			echo "0";
			return;
		}

		$cek_stok = $this->model_nota->get_toko()->row();
		if ($cek_stok->stock_adjust == 1) {
			//echo "string";
			$produk = $this->model_nota->get_nota_product_by_id($id);
				foreach ($produk->result() as $row) {
					$stok_req = $row->quantity;
					$stok = $this->db->where('id',$row->product_varian_id)->get('tb_product_varian')->row()->stock_qty;
					if ($stok < $stok_req ) {
						echo "0";
						return;
					}					
				}
				foreach ($produk->result() as $row) {
					$stok = $row->quantity;
					$this->db->where('id',$row->product_varian_id)->set('stock_qty','stock_qty - $stok')->update('tb_product_varian');
				}
			
		}

		$update = $this->db->set('status',1)->where('id',$id)->update('tb_invoice');
		if ($update) {
			echo "1";
		}
	}

	public function set_location(){
		$postal = $this->input->post('postal');

		$location = $this->model_nota->get_location($postal);

		if ($location->num_rows() > 0 ) {			
			$province = $this->model_nota->get_province();
			echo "<label>Pilih Provinsi</label>
					<select class='chosen-select' name='province' id='province' onchange=javascript:set_city()>";
			foreach ($province->result() as $row_p) {
				$select = '';
				if ($row_p->province == $location->row()->province) {$select = 'selected';}
				echo "<option $select value='".$row_p->province."'>".$row_p->province."</option>";
			}
			echo "</select>";
		}else{
			echo "0";
		}
	}

	public function set_city(){
		$postal = $this->input->post('postal');

		$location = $this->model_nota->get_location($postal);

		if ($location->num_rows() > 0 ) {			
			$city = $this->model_nota->get_city($location->row()->province);
			echo "<label>Pilih Kota</label>
					<select class='chosen-select' name='city' id='city' onchange=javascript:set_kecamatan()>";
			foreach ($city->result() as $row_p) {
				$select = '';
				if ($row_p->city == $location->row()->city) {$select = 'selected';}
				echo "<option $select value='".$row_p->city."'>".$row_p->city."</option>";
			}
			echo "</select>";
		}
	}

	public function set_city_prov(){
		$province = $this->input->post('province');

		$city = $this->model_nota->get_city($province);
		echo "<label>Pilih Kota</label>
				<select class='chosen-select' name='city' id='city' onchange=javascript:set_kecamatan()>";
		foreach ($city->result() as $row_p) {
			echo "<option value='".$row_p->city."'>".$row_p->city."</option>";
		}
		echo "</select>";		
	}

	public function set_kecamatan(){
		$postal = $this->input->post('postal');

		$location = $this->model_nota->get_location($postal);

		if ($location->num_rows() > 0 ) {			
			$kecamatan = $this->model_nota->get_kecamatan($location->row()->city);
			echo "<label>Pilih Kecamatan</label>
					<select class='chosen-select' name='kecamatan' id='kecamatan'>";
			foreach ($kecamatan->result() as $row_p) {
				$select = '';
				if ($row_p->kecamatan == $location->row()->kecamatan) {$select = 'selected';}
				echo "<option $select value='".$row_p->kecamatan."'>".$row_p->kecamatan."</option>";
			}
			echo "</select>";
		}
	}

	public function set_kecamatan_city(){
		$city = $this->input->post('city');
		
		$kecamatan = $this->model_nota->get_kecamatan($city);
		echo "<label>Pilih Kecamatan</label>
				<select class='chosen-select' name='kecamatan' id='kecamatan'>";
		foreach ($kecamatan->result() as $row_p) {
			echo "<option value='".$row_p->kecamatan."'>".$row_p->kecamatan."</option>";
		}
		echo "</select>";
	}

	public function pengiriman(){
		$id 		= $this->template->clearInput($this->input->post('id_nota'));
		$kurir 		= $this->template->clearInput($this->input->post('kurir'));
		$biaya 		= $this->template->clearInput($this->input->post('biaya'));
		$resi 		= $this->template->clearInput($this->input->post('nomor-resi'));
		$nama 		= $this->template->clearInput($this->input->post('namane'));
		$phone 		= $this->template->clearInput($this->input->post('phone'));
		$postal		= $this->template->clearInput($this->input->post('postal-code'));
		$province	= $this->template->clearInput($this->input->post('province'));
		$city 		= $this->template->clearInput($this->input->post('city'));
		$kecamatan	= $this->template->clearInput($this->input->post('kecamatan'));
		$alamat		= $this->template->clearInput($this->input->post('alamat'));

		/*$data	= array(
			'shipment_no'		=> $resi,
			'shipment_service'	=> $kurir,
			'price_shipment'	=> $biaya,
			'recipient_name'	=> $nama,
			'recipient_phone'	=> $phone,
			'location_to_province'	=> $province,
			'location_to_city'	=> $city,
			'location_to_kecamatan'	=> $kecamatan,
			'location_to_postal'	=> $postal,			
			'location_to_address'	=> $alamat
			);*/

		$data	= array(
			'shipment_no'		=> $resi,
			'shipment_service'	=> $kurir,
			);

		$update = $this->db->where('id',$id)->update('tb_invoice',$data);
		if ($update) {			
			echo "
    		<b>Pengiriman : </b> ".$kurir."<br>
        	<b>Resi : </b> ".$resi."<br>       
        	";
		}else{
			echo "0";
		}
	}

	public function detail(){
		$invoice 			= $this->uri->segment(3);
		$data['nota']		= $this->model_nota->get_nota_invoice($invoice)->row();
		$data['rekening']	= $this->model_nota->get_rekening();
		$data['toko']		= $this->model_nota->get_toko()->row();
		$data['produk']		= $this->model_nota->get_nota_product($invoice);

		$this->template->bonobo('nota/bg_nota_detail',$data);
	}

	public function cetak(){
		$invoice 			= $this->uri->segment(3);
		$data['nota']		= $this->model_nota->get_nota_invoice($invoice)->row();
		$data['rekening']	= $this->model_nota->get_rekening();
		$data['toko']		= $this->model_nota->get_toko()->row();
		$data['produk']		= $this->model_nota->get_nota_product($invoice);

		$this->load->view('enduser/nota/bg_print',$data);
	}

	public function ajax_load(){
		$data['nota']		= $this->model_nota->get_nota();
		$data['rekening']	= $this->model_nota->get_rekening();
		$data['toko']		= $this->model_nota->get_toko()->row();

		$this->load->view('enduser/nota/bg_nota_ajax',$data);
	}

	public function sort(){
		$code = $this->input->post('code');

		if ($code == 1) {
			$_SESSION['sort'] = 'ASC';
		}elseif ($code == 2) {
			$_SESSION['sort'] = 'DESC';
		}

		$this->ajax_load();
	}

	public function tipe_bayar(){
		$code = $this->input->post('code');

		if ($code == 1) {
			$_SESSION['tipe_bayar'] = 0;
		}elseif ($code == 2) {
			$_SESSION['tipe_bayar'] = 1;
		}elseif ($code == 3) {
			unset($_SESSION['tipe_bayar']);
		}

		$this->ajax_load();
	}

	public function tipe_stok(){
		$code = $this->input->post('code');

		if ($code == 0) {
			$_SESSION['tipe_stok'] = 0;
		}elseif ($code == 1) {
			$_SESSION['tipe_stok'] = 1;
		}elseif ($code == 1) {
			unset($_SESSION['tipe_stok']);
		}

		$this->ajax_load();
	}

	public function set_flag(){
		$_SESSION['flagger'] = true;
		$this->ajax_load();
	}

	public function unset_flag(){
		unset($_SESSION['flagger']);
		$this->ajax_load();
	}

	public function search(){
		$keyword = $this->input->post('keyword');
		$search = $this->input->post('search');
		if ($keyword != '') {
			$_SESSION['search'] = $search;
			$_SESSION['keyword'] = $keyword;
		}else{
			unset($_SESSION['search']);
			unset($_SESSION['keyword']);
		}
		
		$this->ajax_load();
	}
}

