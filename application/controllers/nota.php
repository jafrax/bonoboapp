<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* CONTROLLER NOTA WEBSITE
* This controler for screen index
*
* Log Activity : ~ Create your log if you change this controller ~
* 1. Create 24 Juni 2015 by Dinar Wahyu Wibowo, Create controller, All function
*/

class Nota extends CI_Controller {
	var $limit = 5;
	var $offset = 0;
	function __construct(){
        parent::__construct();
		if(empty($_SESSION['bonobo']) || empty($_SESSION['bonobo']['id'])){
			
			redirect('index/signin/');
			return;
		}
		$this->template->cek_license();
		$this->load->model("enduser/model_nota");	
		
		
    }
    
    
	
	public function index(){		
		
		$_SESSION['filter_nota']['date_to'] 	= date('Y-m-d');
		$_SESSION['filter_nota']['date_from'] 	= date('Y-m-d', strtotime('-1 month', strtotime( date('Y-m-d') )));
		
		//$data['nota']		= $this->model_nota->get_nota();
		$data['rekening']	= $this->model_nota->get_rekening();
		$data['toko']		= $this->model_nota->get_toko()->row();	

		$page 	= $this->uri->segment(3);        
        $limit 	= $this->limit;
        if(!$page){
        	unset($_SESSION['filter_nota']);
        	
        	$offset = $this->offset;
        }else{
            $offset = $page;
        }
        
        $data['nota'] = $this->model_nota->get_nota($limit,$offset);
        
		if ($this->input->post('ajax')) {
			if ($data['nota']->num_rows() > 0){
                $this->load->view('enduser/nota/bg_nota_ajax', $data);
            }
        } else {
            $this->template->bonobo('nota/bg_nota', $data);
        }		
	}


	public function index2(){		
		
		
		//$data['nota']		= $this->model_nota->get_nota();
		$data['rekening']	= $this->model_nota->get_rekening();
		$data['toko']		= $this->model_nota->get_toko()->row();	

		$page 	= $this->uri->segment(3);        
        $limit 	= $this->limit;
        if(!$page){
        	unset($_SESSION['filter_nota']);
        	
        	$offset = $this->offset;
        }else{
            $offset = $page;
        }
        
        $data['nota'] = $this->model_nota->get_nota($limit,$offset);
        
		if ($this->input->post('ajax')) {
			if ($data['nota']->num_rows() > 0){
                $this->load->view('enduser/nota/bg_nota_ajax', $data);
            }
        } else {
            $this->template->bonobo('nota/bg_nota', $data);
        }		
	}
	
	

	public function change_date_from(){
		$date 	= $this->input->post('date');

		if($date == ''){
			$date 	= date('Y-m-d', strtotime('-1 month', strtotime( date('Y-m-d') )));
		}else{
		$old_date 			= $date;
		$old_date_timestamp = strtotime($old_date);
		$new_date 			= date('Y-m-d', $old_date_timestamp);
	
		if (date('Y-m-d') > $new_date) {
			echo "Lebih dari hari ini ";
			
		}elseif ($_SESSION['filter_nota']['date_from'] > $_SESSION['filter_nota']['date_to'])	{
			echo "Lebih dari to date ";
		}else{
			unset($_SESSION['filter_nota']['date_from']);
			$_SESSION['filter_nota']['date_from'] = $new_date;
			echo "sukses";
			
		}
		
		$this->ajax_load();
	}}
	

	public function change_date_to(){
		$date 	= $this->input->post('date');
		if($date == ''){
			$date	= date('Y-m-d');
		}else{
		$old_date 			= $date;
		$old_date_timestamp = strtotime($old_date);
		$new_date 			= date('Y-m-d', $old_date_timestamp);
	
		if (date('Y-m-d') > $new_date) {
			echo "kadaluarsa";
		}else{
			unset($_SESSION['filter_nota']['date_to']);
			$_SESSION['filter_nota']['date_to'] = $new_date;
			echo "sukses";
		}
		
		$this->ajax_load();
	}}

	public function filter_dates(){
		$date_from =$this->input->post('tgl_awal');
		$date_to = $this->input->post('tgl_akhir');

		//if($date_from && $date_to !=''){
		$_SESSION['filter_nota']['date_from']  = $date_from;
		$_SESSION['filter_nota']['date_to'] = $date_to;
		//echo $date_from." ".$_SESSION['date_from'];
	/*}else{
		unset($_SESSION['date_from']);
		unset($_SESSION['date_to']);
	}*/
		$this->ajax_load();

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
		$cek 	= $this->input->post('cek');

		$cek_id	= $this->model_nota->get_nota_by_id($id);

		if ($cek_id->num_rows == 0) {
			echo "0";
			return;
		}
		//$cek= $this->model_nota->get_toko()->row();
		if ($cek != null) {
			
			$produk = $this->model_nota->get_nota_product_by_id($id);				
				foreach ($produk->result() as $row) {
					$stok 	= $row->quantity;
					$oldstok= $this->db->where('id',$row->product_varian_id)->get('tb_product_varian')->row()->stock_qty;

					$this->db->where('id',$row->product_varian_id)->set('stock_qty',$oldstok+$stok)->update('tb_product_varian');
				}
			
		}

		$update = $this->db->set('status',2)->where('id',$id)->update('tb_invoice');
		if ($update) {
			echo "1";
			
		}
	}

	public function nota_batal2(){
		$id 	= $this->input->post('id');
		$cek 	= $this->input->post('cek');

		$cek_id	= $this->model_nota->get_nota_by_id($id);

		if ($cek_id->num_rows == 0) {
			echo "0";
			return;
		}
		if ($cek != null) {
			$produk = $this->model_nota->get_nota_product_by_id($id);				
				foreach ($produk->result() as $row) {
					$stok 	= $row->quantity;
					$oldstok= $this->db->where('id',$row->product_varian_id)->get('tb_product_varian')->row()->stock_qty;

					$this->db->where('id',$row->product_varian_id)->set('stock_qty',$oldstok+$stok)->update('tb_product_varian');
				}
			
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
		$to_bank	=0 ;
		$to_acc_no 	=0;
		$to_acc_name ='';
		$price_total = 0;
		

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
					$stok 	= $row->quantity;
					$oldstok= $this->db->where('id',$row->product_varian_id)->get('tb_product_varian')->row()->stock_qty;

					$this->db->where('id',$row->product_varian_id)->set('stock_qty',$oldstok-$stok)->update('tb_product_varian');
				}
			
		}
	
	
	if($metode == 2 ){
	//ambil data bank
	$row_tb_bank = 	$this->model_nota->get_toko_bank($rekening);
	foreach ($row_tb_bank->result() as $row_bank) {
		$to_bank	= $row_bank->bank_name;
		$to_acc_no 	= $row_bank->acc_no;
		$to_acc_name =$row_bank->acc_name;
		
	}
	
	//ambil total transaksi invoice
	$row_invoice = 	$this->model_nota->get_nota_by_id($id);
	foreach ($row_invoice->result() as $row_inv) {
		$price_total	= $row_inv->price_total;
	}
	
	//cek tranfer jika sudah ada	
	$cek_bank_transfer = $this->model_nota->get_tranfer($id);
	if($cek_bank_transfer->num_rows == 0){
		
		$data = array(	'invoice_id'		=> $id,
						'price'				=> $price_total,
						'from_bank'			=> '',
						'from_acc_no'		=> '',
						'from_acc_name'		=> '',
						'to_bank'			=> $to_bank,
						'to_acc_no'			=> $to_acc_no,
						'to_acc_name'		=> $to_acc_name,
						'create_date'		=> date('Y-m-d H:i:s'),
						'create_user'		=> $_SESSION['bonobo']['email'],
						'update_date'		=> date('Y-m-d H:i:s'),
						'update_user'		=> $_SESSION['bonobo']['email']
		);
		
		$insert = $this->db->insert('tb_invoice_transfer_confirm',$data);
		$this->db->where('id',$id)->set('member_confirm',1)->update('tb_invoice');
		
	}else{
		$this->db->where('invoice_id',$id)->set('to_bank',$to_bank)->set('to_acc_no',$to_acc_no)->set('to_acc_name',$to_acc_name)->set('price',$price_total)->update('tb_invoice_transfer_confirm');
		$this->db->where('id',$id)->set('member_confirm',1)->update('tb_invoice');
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

			$row = $this->db->where('id',$id)->get('tb_invoice')->row();
			echo "
			<dt><b>Pengiriman : </b></dt>
    		<dd>".$kurir."</dd>
        	<dt><b>Resi : </b></dt>
        	<dd>".$resi."</dd>
        	<dt><b>Biaya Pengiriman : </b></dt>
        	<dd>".$row->price_shipment."</dd>
        	<dt><b>Nama Penerima : </b></dt>
        	<dd>".$row->recipient_name."</dd>
        	<dt><b>No. Telp. Penerima : </b></dt>
        	<dd>".$row->recipient_phone."</dd>
        	<dt><b>Provinsi Penerima : </b></dt>
        	<dd>".$row->location_to_province."</dd>
        	<dt><b>Kabupaten/Kota Penerima : </b></dt>
        	<dd>".$row->location_to_city."</dd>
        	<dt><b>Kecamatan Penerima : </b></dt>
        	<dd>".$row->location_to_kecamatan."</dd>
        	<dt><b>Kode Pos Penerima : </b></dt>
        	<dd>".$row->location_to_postal."</dd>
        	<dt><b>Alamat Penerima : </b></dt>
        	<dd>".$row->recipient_address."</dd>      
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

		$content = $this->load->view('enduser/nota/bg_print',$data,true);
		$this->template->print2pdf('Invoce Bonobo',$content);
	}

	public function ajax_load(){
		$data['nota']		= $this->model_nota->get_nota($this->limit,$this->offset);
		$data['rekening']	= $this->model_nota->get_rekening();
		$data['toko']		= $this->model_nota->get_toko()->row();

		$this->load->view('enduser/nota/bg_nota_ajax',$data);
	}

	public function sort(){
		$code = $this->input->post('code');

		if ($code == 1) {
			$_SESSION['filter_nota']['sort'] = 'ASC';
		}elseif ($code == 2) {
			$_SESSION['filter_nota']['sort'] = 'DESC';
		}

		$this->ajax_load();
	}


	
	public function tipe_bayar(){
		$code = $this->input->post('code');

		if ($code == 1) {
			$_SESSION['filter_nota']['tipe_bayar'] = 0;
		}elseif ($code == 2) {
			$_SESSION['filter_nota']['tipe_bayar'] = 1;
		}elseif ($code == 3) {
			unset($_SESSION['filter_nota']['tipe_bayar']);
		}

		$this->ajax_load();
	}

	public function tipe_stok(){
		$code = $this->input->post('code');

		if ($code == 0) {
			$_SESSION['filter_nota']['tipe_stok'] = 0;
		}elseif ($code == 1) {
			$_SESSION['filter_nota']['tipe_stok'] = 1;
		}elseif ($code == 1) {
			unset($_SESSION['filter_nota']['tipe_stok']);
		}

		$this->ajax_load();
	}

	public function set_flag(){
		$_SESSION['filter_nota']['flagger'] = 1;
		$this->ajax_load();
	}

	public function unset_flag(){
		unset($_SESSION['filter_nota']['flagger']);
		$this->ajax_load();
	}

	public function search(){
		$keyword = $this->input->post('keyword');
		$search = $this->input->post('search');
		if ($keyword != '') {
			$_SESSION['filter_nota']['search'] = $search;
			$_SESSION['filter_nota']['keyword'] = $keyword;
		}else{
			unset($_SESSION['filter_nota']['search']);
			unset($_SESSION['filter_nota']['keyword']);
		}
		
		$this->ajax_load();
	}
}

