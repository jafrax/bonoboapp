<?php
$uri3 = $this->uri->segment(3);
echo "
<div id='delete_produk' class='modal confirmation'>
	<div class='modal-header red'>
		<i class='mdi-navigation-close left'></i> Hapus produk
	</div>
	<form class='modal-content'>
		<p>Apakah anda yakin ingin menghapus <b>'nama produk'</b> ?</p>
	</form>
	<div class='modal-footer'>
		<a href='#!' class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
		<a href='#!' class=' modal-action modal-close waves-effect waves-red btn-flat'>YA</a>
	</div>
</div>
<div id='delete_varian' class='modal confirmation'>
	<div class='modal-header red'>
		<i class='mdi-navigation-close left'></i> Hapus varian
	</div>
	<form class='modal-content'>
		<p>Apakah anda yakin ingin menghapus varian ini ?</p>
	</form>
	<div class='modal-footer'>		
		<a href='#!' class=' modal-action modal-close waves-effect waves-red btn-flat'>YA</a>
		<a href='#!' class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
	</div>
</div>

<div id='add_kategori' class='modal confirmation'>	
	<div class='modal-header red'>
		<i class='mdi-content-add-box left'></i> Tambah kategori
	</div>	
	<form role='form' class='modal-content' id='form_add_kategori'>
		<input id='id-toko' name='nama' type='hidden' value='".$_SESSION['bonobo']['id']."' >
		<input id='nama_kategori' name='nama_kategori' type='text' class='validate' required>
		<label for='nama_kategori'>Nama kategori <span class='text-red'>*</span></label>	
		<label class='error error-chosen' for='nama_kategori'></label>
	<div class='modal-footer'>
		<a href='#!' class=' modal-action modal-close waves-effect waves-red btn-flat'>TUTUP</a>
		<button type='button' id='tambah-kategori' onclick=javascript:tambah_kategori() class='waves-effect waves-red btn-flat'>TAMBAH</a>
	</div>
	</form>
</div>
				<div class='col s12 m12 l3'>
					<ul class='menucontent'>
						<li><a href='".base_url()."produk/'>READY STOK</a></li>
						<li><a class='active' href='".base_url()."produk/pre_order'>PRE ORDER</a></li>
						<li><a href='".base_url()."produk/atur_kategori'>ATUR KATEGORI</a></li>	
					</ul>
				</div>
				<div class='col s12 m12 l9'>
					<form class='formain' id='form-ready' method='post' action='' enctype='multipart/form-data'>
						<div class='formhead'>
							<h2 class='titmain'><b>BUAT BARANG BARU PRE ORDER</b></h2>
						</div>
						<div class='row formbody'>
							<div class='col s12'>
								<div class='input-field col s12'>
									<input id='nama_barang' name='nama' type='text' placeholder='Ex : Baju Bonobo' class='validate' length='50' required>
									<label for='nama_barang'>Nama Barang <span class='text-red'>*</span></label>
								</div>
								<div class='input-field col s12'>
									<input id='nomor_sku' type='text' name='sku' placeholder='Ex : AD001' class='validate' length='20'>
									<label for='nomor_sku'>SKU</label>
								</div>
								<div class='input-field col s12'>
									<input id='date_fin' name='tgl_pre_order' type='text' placeholder='Tanggal selesai PRE ORDER' class='datepicker validate'>
									<label for='date_fin'>Tanggal selesai PRE ORDER</label>
								</div>
								<div class='col s12 m6' id='tempat-kategori'>
									<label>Kategori Barang <span class='text-red'>*</span></label>
									<label class='error error-chosen' for='select-kategori'></label>
									<select name='kategori' id='select-kategori' class='chosen-select' required>
										<option value='' disabled selected>Pilih Kategori Barang</option>";
										foreach ($kategori->result() as $row_ktgri) {
											echo "<option value='".$row_ktgri->id."'>".$row_ktgri->name."</option>";
										}
										echo"
									</select>
								</div>
								<div class='input-field col s12 m6'>
									<a href='#add_kategori' class='btn-flat right modal-trigger'><b class='blue-text'><i class='mdi-content-add-box left'></i>BUAT KATEGORI BARU</b></a>
								</div>
								<div class='input-field col s12 m8'>
									<i class='grey-text'><b>Ukuran Maks</b> : 1 MB.</i><br>
									<i class='grey-text'><b>Format</b> : .bmp, .jpg, .png.</i>
								</div>
								<div class='input-field col s12'>
									<div class='picture-area'>
										<div class='col s6 m4 l3' id='div_pic_1'>
											<div class='card' >
												<a class='delimg' onclick=javascript:remove_picture('pic_1')><i class='mdi-navigation-close right'></i></a>
												<div class='card-image img-product waves-effect waves-block waves-light'>
													<img id='img_pic_1' onclick=javascript:click_picture('pic_1') class='responsive-img img-product' src='".base_url()."html/images/comp/product_large.png'>
													<input type='file' class='pic_product' name='pic_1' id='pic_1' style='opacity: 0.0;width:1px; height:1px' OnChange=javascript:picture_upload(this.id)>
												</div>
												<label for='pic_1' class='error error-image' generated='true'></label>										
											</div>										
										</div>
									</div>
									<a id='add-poto' class='btn-flat left' onclick=javascript:add_picture()><b class='blue-text'><i class='mdi-content-add-box left'></i>TAMBAH GAMBAR</b></a>
								</div>
								<input type='hidden' name='total_picture' id='total_picture' value='1'/>

								<div class='input-field col s12'>
									<input id='perkiraan_berat' placeholder='0.00' type='text' name='berat' class='validate' maxlength='9'>
									<label for='perkiraan_berat'>Perkiraan Berat <span>( Kilogram)</span></label>
								</div>
								<div class='input-field col s12'>
									<input id='satuan' type='text' name='satuan' placeholder='Misal: Pcs' class='validate' length='5'>
									<label for='satuan'>Satuan <span></span></label>
								</div>
								<div class='input-field col s12'>
									<input id='min_order' placeholder='1' type='text' name='min_order' class='validate numbersOnly'>
									<label for='min_order'>Min Order</label>
								</div>
								<div class='input-field col s12'>
									<textarea id='deskripsi' placeholder='Ex : Baju bonobo adalah baju berkualitas.' name='deskripsi' class='materialize-textarea' length='250'></textarea>
									<label for='deskripsi'>Deskripsi</label>
								</div>
								
							</div>
							
							<div class='row formbody'>
								<div class='linehead'>Harga Barang</div>
								<div class='input-field col s12 m6'>
									<input id='harga_pembelian' name='harga_pembelian' placeholder='0' type='text' class='validate numbersOnly'>
									<label for='harga_pembelian'>Harga Beli</label>
								</div>
								<div class='input-field col s12 m12 varsto'>
									<span for='harga_jual'>Harga Jual <span class='text-red'>*</span></span>
								</div>";
								if ($level_harga->level_1_active == 1) {$a1 = 'block';}else{$a1 = 'none';}
								if ($level_harga->level_2_active == 1) {$a2 = 'block';}else{$a2 = 'none';}
								if ($level_harga->level_3_active == 1) {$a3 = 'block';}else{$a3 = 'none';}
								if ($level_harga->level_4_active == 1) {$a4 = 'block';}else{$a4 = 'none';}
								if ($level_harga->level_5_active == 1) {$a5 = 'block';}else{$a5 = 'none';}
								echo"

								<ul class='col s12 m12'>
									<li class='varsto' style='display:$a1'>
										<p><br></p>
										<div class='input-field col s12 m6'>
											<input id='varian' name='harga_level_1' type='text' placeholder='0' class='validate numbersOnly' required>
											<label for='varian'>Harga "; if ($level_harga->level_1_name != '') {echo $level_harga->level_1_name;}else{echo "level 1";} echo" <span class='text-red'>*</span></label>
										</div>
									</li>
									<li class='varsto' style='display:$a2'>
										<div class='input-field col s12 m6'>
											<input id='varian' name='harga_level_2' type='text' placeholder='Masukkan harga jual barang di level ini' class='validate numbersOnly' >
											<label for='varian'>Harga "; if ($level_harga->level_2_name != '') {echo $level_harga->level_2_name;}else{echo "level 2";} echo"</label>
										</div>
									</li>
									<li class='varsto' style='display:$a3'>
										<div class='input-field col s12 m6'>
											<input id='varian' name='harga_level_3' type='text' placeholder='Masukkan harga jual barang di level ini' class='validate numbersOnly' >
											<label for='varian'>Harga "; if ($level_harga->level_3_name != '') {echo $level_harga->level_3_name;}else{echo "level 3";} echo"</label>
										</div>
									</li>
									<li class='varsto' style='display:$a4'>
										<div class='input-field col s12 m6'>
											<input id='varian' name='harga_level_4' type='text' placeholder='Masukkan harga jual barang di level ini' class='validate numbersOnly' >
											<label for='varian'>Harga "; if ($level_harga->level_4_name != '') {echo $level_harga->level_4_name;}else{echo "level 4";} echo"</label>
										</div>
									</li>
									<li class='varsto' style='display:$a5'>
										<div class='input-field col s12 m6'>
											<input id='varian' name='harga_level_5' type='text' placeholder='Masukkan harga jual barang di level ini' class='validate numbersOnly' >
											<label for='varian'>Harga "; if ($level_harga->level_5_name != '') {echo $level_harga->level_5_name;}else{echo "level 5";} echo"</label>
										</div>
									</li>
								</ul>
								<div class='input-field col s12 m12 varsto'>
									<button class='btn waves-effect waves-light right col s12 m3' type='submit' value='1' name='action'>Simpan<i class='mdi-content-send right'></i></button>																		
									<button class='btn waves-effect waves-light yellow darken-3 right col s12 m3' value='0' type='submit' name='action'>Simpan Draft<i class='mdi-content-drafts right'></i></button>
									<button class='btn waves-effect waves-light red right col s12 m3' type='button' name='action' onclick='location.href=\"".base_url()."produk/\"'>Batal<i class='mdi-content-clear right'></i></button>
								</div>
							</div>
						</div>
					</form>
				</div>
<script type='text/javascript' src='".base_url("")."assets/jController/enduser/CtrlProduk.js'></script>

";

?>