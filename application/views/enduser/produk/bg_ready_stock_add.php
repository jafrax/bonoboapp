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

<div id='add_kategori' class='modal confirmation'>	
	<div class='modal-header red'>
		<i class='mdi-content-add-box left'></i> Tambah kategori
	</div>	
	<form class='modal-content' id='form_add_kategori'>
		<input id='id-toko' name='nama' type='hidden' value='".$_SESSION['bonobo']['id']."' >
		<input id='nama-kategori' name='nama' type='text' class='validate'>
		<label for='nama-kategori'>Nama kategori <span class='text-red'>*</span></label>	
	<div class='modal-footer'>
		<a href='#!' class=' modal-action modal-close waves-effect waves-red btn-flat'>TUTUP</a>
		<button type='button' id='tambah-kategori' class='modal-action modal-close waves-effect waves-red btn-flat'>TAMBAH</a>
	</div>
	</form>
</div>
				<div class='col s12 m12 l3'>
					<ul class='menucontent'>
						<li><a class='active' href='produk_ready_stock.html'>READY STOK</a></li>
						<li><a href='produk_pre_order.html'>PRE ORDER</a></li>
						<li><a href='.html'>ATUR KATEGORI</a></li>
						<li><a href='.html'>PILIH KATEGORI</a></li>
					</ul>
				</div>
				<div class='col s12 m12 l9'>
					<form class='formain' method='post' action='' enctype='multipart/form-data'>
						<div class='formhead'>
							<h2 class='titmain'><b>BUAT BARANG BARU PRE ORDER</b></h2>
						</div>
						<div class='row formbody'>
							<div class='col s12'>
								<div class='input-field col s12 m6'>
									<select name='tipe'>
										<option value='' disabled selected>Choose your option</option>
										<option value='1' "; if ($uri3 == 1) echo "selected"; echo">Ready Stock</option>
										<option value='2' "; if ($uri3 == 2) echo "selected"; echo">Pre Order</option>										
									</select>
									<label>Tipe barang</label>
								</div>
								<div class='input-field col s12'>
									<input id='nama_barang' name='nama' type='text' class='validate'>
									<label for='nama_barang'>Nama barang <span class='text-red'>*</span></label>
								</div>
								<div class='input-field col s12'>
									<input id='nomor_sku' type='text' name='sku' class='validate'>
									<label for='nomor_sku'>Nomor SKU</label>
								</div>
								<div class='input-field col s12 m6' id='tempat-kategori'>
									<select name='kategori' id='select-kategori'>
										<option value='' disabled selected>Choose your option</option>";
										foreach ($kategori->result() as $row_ktgri) {
											echo "<option value='".$row_ktgri->id."'>".$row_ktgri->name."</option>";
										}
										echo"
									</select>
									<label>Kategori barang</label>
								</div>
								<div class='input-field col s12 m6'>
									<a href='#add_kategori' class='waves-effect btn-flat right modal-trigger'><b class='text-blue'><i class='mdi-content-add-box left'></i>BUAT KATEGORI BARU</b></a>
								</div>
								<div class='input-field col s12'>
									<div class='col s6 m4 l3 picture-area'>
										<div class='card' id='div_pic_1'>
											<a class='delimg' onclick=javascript:remove_picture('pic_1')><i class='mdi-content-backspace'></i></a>
											<div class='card-image waves-effect waves-block waves-light'>
												<img id='img_pic_1' onclick=javascript:click_picture('pic_1') class='responsive-img img-product' src='".base_url()."html/images/comp/product_large.png'>
												<input type='file' class='pic_product' name='pic_1' id='pic_1' style='opacity: 0.0;width:1px; height:1px' OnChange=javascript:picture_upload(this.id)>
											</div>
										</div>
									</div>
									<input type='hidden' name='total_picture' id='total_picture' value='1'/>
								</div>
								<div class='input-field col s12 m12'>
									<a class='waves-effect btn-flat right' onclick=javascript:add_picture()><b class='text-blue'><i class='mdi-content-add-box left'></i>TAMBAH GAMBAR</b></a>
								</div>
								<div class='input-field col s12'>
									<input id='perkiraan_berat' type='text' class='validate'>
									<label for='perkiraan_berat'>Perkiraan berat <span>( Kilogram)</span></label>
								</div>
								<div class='input-field col s12'>
									<input id='satuan' type='text' placeholder='Misal: Lusin, Pcs' class='validate'>
									<label for='satuan'>Satuan <span></span></label>
								</div>
								<div class='input-field col s12'>
									<input id='min_order' type='text' class='validate'>
									<label for='min_order'>Min order</label>
								</div>
								<div class='input-field col s12'>
									<textarea id='deskripsi' class='materialize-textarea'></textarea>
									<label for='deskripsi'>Deskripsi</label>
								</div>
								
							</div>
							<div class='row formbody'>
								<div class='linehead'><i class='fa fa-minus-square-o'></i>Stok Barang</div>
								<div class='input-field col s12 m6'>
									<select>
										<option value='' disabled selected>Choose your option</option>
										<option value='1'>Stok selalu tersedia</option>
										<option value='2'>Gunakan stok</option>
									</select>
									<label>Tipe stok</label>
								</div>
								<div class='input-field col s12 m12'>
									<input type='checkbox' id='gunakan_varian' />
									<label for='gunakan_varian'>Gunakan varian</label>
								</div>
								<ul class='col s12 m12'>
									<li class='varsto'>
										<div class='input-field col s12 m6'>
											<input id='varian' type='text' placeholder='Misal: Lusin, Pcs' class='validate'>
											<label for='varian'>Varian <span></span></label>
										</div>
										<div class='input-field col s12 m6'>
											<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label>
										</div>
									</li>
									<li class='varsto'>
										<div class='input-field col s12 m6'>
											<input id='varian' type='text' placeholder='Misal: Lusin, Pcs' class='validate'>
											<label for='varian'>Varian <span></span></label>
										</div>
										<div class='input-field col s12 m6'>
											<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label>
										</div>
									</li>
									<li class='varsto'>
										<div class='input-field col s12 m6'>
											<input id='varian' type='text' placeholder='Misal: Lusin, Pcs' class='validate'>
											<label for='varian'>Varian <span></span></label>
										</div>
										<div class='input-field col s12 m6'>
											<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label>
										</div>
									</li>
									<li class='input-field col s12 m12'>
										<a class='waves-effect btn-flat right'><b class='text-blue'><i class='mdi-content-add-box left'></i>TAMBAH VARIAN</b></a>
									</li>
								</ul>
								<ul class='col s12 m12'>
									<li class='varsto'>
										<div class='input-field col s12 m6'>
											<input id='varian' type='text' placeholder='Misal: Lusin, Pcs' class='validate'>
											<label for='varian'>Varian <span></span></label>
										</div>
										<div class='input-field col s12 m6'>
											<input id='varian' type='text' placeholder='Jumlah stok' class='validate'>
											<label for='varian'>Stok <span></span></label>
										</div>
									</li>
									<li class='input-field col s12 m12'>
										<a class='waves-effect btn-flat right'><b class='text-blue'><i class='mdi-content-add-box left'></i>TAMBAH VARIAN</b></a>
									</li>
								</ul>
							</div>
							<div class='row formbody'>
								<div class='linehead'><i class='fa fa-minus-square-o'></i>Harga Barang</div>
								<div class='input-field col s12 m6'>
									<input id='harga_pembelian' type='text' class='validate'>
									<label for='harga_pembelian'>Harga pembelian</label>
								</div>
								<div class='input-field col s12 m12 varsto'>
									<label for='harga_jual'>Harga jual <span class='text-red'>*</span></label>
								</div>
								<ul class='col s12 m12'>
									<li class='varsto'>
										<div class='input-field col s12 m6'>
											<input id='varian' type='text' placeholder='0' class='validate'>
											<label for='varian'>Harga level 1 <span class='text-red'>*</span></label>
										</div>
									</li>
									<li class='varsto'>
										<div class='input-field col s12 m6'>
											<input id='varian' type='text' placeholder='0' class='validate'>
											<label for='varian'>Harga level 2 <span class='text-red'>*</span></label>
										</div>
									</li>
									<li class='varsto'>
										<div class='input-field col s12 m6'>
											<input id='varian' type='text' placeholder='0' class='validate'>
											<label for='varian'>Harga level 3 <span class='text-red'>*</span></label>
										</div>
									</li>
								</ul>
								<div class='input-field col s12 m12 varsto'>
									<button class='btn waves-effect waves-light red right col s12 m3' type='submit' name='action'>Batal<i class='mdi-content-clear right'></i></button>
									<button class='btn waves-effect waves-light yellow darken-3 right col s12 m3' type='submit' name='action'>Simpan Draft<i class='mdi-content-drafts right'></i></button>
									<button class='btn waves-effect waves-light right col s12 m3' type='submit' name='action'>Simpan<i class='mdi-content-send right'></i></button>
								</div>
							</div>
						</div>
					</form>
				</div>
<script type='text/javascript' src='".base_url("")."assets/jController/enduser/CtrlProduk.js'></script>

";

?>