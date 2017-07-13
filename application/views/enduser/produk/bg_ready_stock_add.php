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
		<a  class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
		<a  class=' modal-action modal-close waves-effect waves-red btn-flat'>YA</a>
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
		<a  class=' modal-action modal-close waves-effect waves-red btn-flat'>YA</a>
		<a  class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
	</div>
</div>

<div id='add_kategori' class='modal confirmation'>	
	<div class='modal-header teal'>
		<i class='mdi-content-add-box left'></i> Tambah kategori
	</div>	
	<form class='modal-content' id='form_add_kategori'>
		<span for='nama_kategori'>Nama kategori <span class='text-red'>*</span></span>
		<input id='id-toko' name='nama' type='hidden' value='".$_SESSION['bonobo']['id']."' >
		<input id='nama_kategori' name='nama_kategori' type='text' class='validate'>
		<label class='error error-chosen' for='nama_kategori'></label>	
	<div class='modal-footer'>		
		<button type='button' onclick=javascript:tambah_kategori() id='tambah-kategori' class='btn waves-effect lighten-2 btn-flat white-text add-kateg waves-light teal'>TAMBAH</button>
		<a href='javascript:void(0)' class='btn modal-action modal-close waves-effect red btn-flat white-text waves-light'>TUTUP</a>
	</div>
	</form>
</div>
				<div class='col s12 m12 l3'>
					<ul class='menucontent'>
						<li><a class='active' href='".base_url()."produk/index/1'>READY STOCK</a></li>
						<li><a href='".base_url()."produk/pre_order/1'>PRE ORDER</a></li>
						<li><a href='".base_url()."produk/atur_kategori'>ATUR KATEGORI</a></li>	
					</ul>
				</div>
				<div class='col s12 m12 l9'>
					<form class='formain'id='form-ready' method='post' action='' enctype='multipart/form-data'>
						<div class='formhead'>
							<h2 class='titmain'><b>BUAT BARANG BARU READY STOCK</b></h2>
						</div>
						<div class='row formbody'>
							<div class='col s12'>
								<br>
								<div class='input-field col s12'>
									<input name='tipe' type='hidden' value='1' class='validate'>
									<input id='nama_barang' name='nama' type='text' placeholder='Ex : Baju Bonobo' class='validate' maxlength='50' length='50' required>
									<label for='nama_barang'>Nama Barang <span class='text-red'>*</span></label>
								</div>
								<div class='input-field col s12'>
									<input id='nomor_sku' type='text' name='sku' placeholder='Ex : AD001' maxlength='20' class='validate' length='20'>
									<label for='nomor_sku'>Kode Barang</label>
								</div>
								<div class='col s12 m6' id='tempat-kategori'>
									<label>Kategori Barang <span class='text-red'>*</span></label>
									<label class='error error-chosen' for='select-kategori'></label>
									<select name='kategori' id='select-kategori' class='selectize' required>
										<option value='' disabled selected>Pilih Kategori Barang</option>";
										foreach ($kategori->result() as $row_ktgri) {
											echo "<option value='".$row_ktgri->id."'>".$row_ktgri->name."</option>";
										}
										echo"
									</select>
								</div>
								<div class='input-field col s12 m6'>
									<a href='#add_kategori' onclick=javascript:reset_cat() class='btn-flat right modal-trigger'><b class='blue-text'><i class='mdi-content-add-box left'></i>BUAT KATEGORI BARU</b></a>
								</div>
								
								<div class='input-field col s12 '>
									<span>Image Produk</span>
									<div class='picture-area'>
										<div class='col s6 m3 l2' id='div_pic_1'>
											<div class='card' >
												<a class='delimg' id='rem_pic_1' style='display:none' onclick=javascript:remove_picture('pic_1')><i class='mdi-navigation-close right'></i></a>
												<div class='card-image img-product waves-effect waves-block waves-light'>
													<img id='img_pic_1' onclick=javascript:click_picture('pic_1') class='responsive-img img-product' src='".base_url()."html/images/comp/product_large.png'>
													<input type='file' class='pic_product' name='pic_1' id='pic_1' style='opacity: 0.0;width:1px; height:1px' OnChange=javascript:picture_upload(this.id,image_resize_1)>
													<input id='image_resize_1' type='hidden' name='image_resize_1' />
												</div>
																						
											</div><label for='pic_1' class='error error-image' generated='true'></label>										
										</div>
										<div class='col s6 m3 l2' id='div_pic_2'>
											<div class='card' >
												<a class='delimg' id='rem_pic_2' style='display:none' onclick=javascript:remove_picture('pic_2')><i class='mdi-navigation-close right'></i></a>
												<div class='card-image img-product waves-effect waves-block waves-light'>
													<img id='img_pic_2' onclick=javascript:click_picture('pic_2') class='responsive-img img-product' src='".base_url()."html/images/comp/product_large.png'>
													<input type='file' class='pic_product' name='pic_2' id='pic_2' style='opacity: 0.0;width:1px; height:1px' OnChange=javascript:picture_upload(this.id,image_resize_2)>
													<input id='image_resize_2' type='hidden' name='image_resize_2' />
												</div>
																						
											</div><label for='pic_2' class='error error-image' generated='true'></label>										
										</div>
										<div class='col s6 m3 l2' id='div_pic_3'>
											<div class='card' >
												<a class='delimg' id='rem_pic_3' style='display:none' onclick=javascript:remove_picture('pic_3')><i class='mdi-navigation-close right'></i></a>
												<div class='card-image img-product waves-effect waves-block waves-light'>
													<img id='img_pic_3' onclick=javascript:click_picture('pic_3') class='responsive-img img-product' src='".base_url()."html/images/comp/product_large.png'>
													<input type='file' class='pic_product' name='pic_3' id='pic_3' style='opacity: 0.0;width:1px; height:1px' OnChange=javascript:picture_upload(this.id,image_resize_3)>
													<input id='image_resize_3' type='hidden' name='image_resize_3' />
												</div>
																						
											</div><label for='pic_3' class='error error-image' generated='true'></label>										
										</div>
										<div class='col s6 m3 l2' id='div_pic_4'>
											<div class='card' >
												<a class='delimg' id='rem_pic_4' style='display:none' onclick=javascript:remove_picture('pic_4')><i class='mdi-navigation-close right'></i></a>
												<div class='card-image img-product waves-effect waves-block waves-light'>
													<img id='img_pic_4' onclick=javascript:click_picture('pic_4') class='responsive-img img-product' src='".base_url()."html/images/comp/product_large.png'>
													<input type='file' class='pic_product' name='pic_4' id='pic_4' style='opacity: 0.0;width:1px; height:1px' OnChange=javascript:picture_upload(this.id,image_resize_4)>
													<input id='image_resize_4' type='hidden' name='image_resize_4' />
												</div>
																					
											</div><label for='pic_4' class='error error-image' generated='true'></label>											
										</div>
										<div class='col s6 m3 l2' id='div_pic_5'>
											<div class='card' >
												<a class='delimg' id='rem_pic_5' style='display:none' onclick=javascript:remove_picture('pic_5')><i class='mdi-navigation-close right'></i></a>
												<div class='card-image img-product waves-effect waves-block waves-light'>
													<img id='img_pic_5' onclick=javascript:click_picture('pic_5') class='responsive-img img-product' src='".base_url()."html/images/comp/product_large.png'>
													<input type='file' class='pic_product' name='pic_5' id='pic_5' style='opacity: 0.0;width:1px; height:1px' OnChange=javascript:picture_upload(this.id,image_resize_5)>
													<input id='image_resize_5' type='hidden' name='image_resize_5' />
												</div>
																						
											</div><label for='pic_5' class='error error-image' generated='true'></label>										
										</div>
									</div>
									<!--<a id='add-poto' class='btn-flat left' onclick=javascript:add_picture()><b class='blue-text'><i class='mdi-content-add-box left'></i>TAMBAH GAMBAR</b></a>-->
								</div>
								<input type='hidden' name='total_picture' id='total_picture' value='5'/>
								<div class='input-field col s12 m8'>
									<span class='grey-text'><b>Ukuran Maks</b> : 1 MB.</span><br>
									<span class='grey-text'><b>Format</b> : .jpg, .png.</span>
								</div>

								<div class='input-field col s12'>
									<input id='perkiraan_berat' placeholder='0,00' type='text' name='berat' class='validate berat' maxlength='9'>
									<label for='perkiraan_berat'>Perkiraan Berat <span>( Kilogram)</span></label>
								</div>
								<div class='input-field col s12'>
									<input id='satuan' type='text' name='satuan' placeholder='Misal: Pcs' class='validate' length='5'>
									<label for='satuan'>Satuan <span></span></label>
								</div>
								<div class='input-field col s12'>
									<input id='min_order' value='1' type='text' name='min_order' class='validate numbersOnly'>
									<label for='min_order'>Min Order</label>
								</div>
								<div class='input-field col s12'>
									<textarea id='deskripsi' placeholder='Ex : Baju bonobo adalah baju berkualitas.' name='deskripsi' class='materialize-textarea' length='250'></textarea>
									<label for='deskripsi'>Deskripsi</label>
								</div>
								
							</div>
							<div class='row formbody'>
								<div class='linehead'>STOK BARANG</div>
								<div class=' col s12 m6'>
								<label>Tipe Stok <span class='text-red'>*</span></label>
								<label class='error error-chosen' for='stok'></label>
									<select name='stok' id='stok' required OnChange=javascript:change_stok() class='select-standar lectfilter'>										
										<option value='1'>Stok selalu tersedia</option>
										<option value='0' selected>Gunakan stok</option>
									</select>									
								</div>
								<div class='input-field col s12 m12'>
									<input type='checkbox' id='gunakan_varian' name='gunakan_varian' onclick=javascript:setVarian() />
									<label for='gunakan_varian'>Gunakan varian</label>
								</div>
								<input type='hidden' name='total_varian' value='1' id='tot_varian' />
								<ul class='col s12 m12 cek-stok' id='tempat-varian' style='display:none'>
									<li class='varsto nolmar' id='li_varian_1'>
										<div class='input-field col s12 m5'>
											<span for='varian'>Varian <span class='text-red'>*</span></span>
											<input id='varian' name='nama_varian_1' type='text' maxlength='15' placeholder='Ex : Merah' class='validate' >
										</div>
										<div class='input-field col s11 m5 tersedia' style='display:none'>
											<label >Stok : <span class='text-green'>selalu tersedia</span></label>
										</div>
										<div class='input-field col s11 m5 pakai-stok'>
											<span for='varian'>Stok <span class='text-red'>*</span></span>
											<input id='varian' name='stok_varian_1' type='text' maxlength='15' placeholder='Jumlah stok' class='validate numbersOnly' required>										
										</div>
										<div class='input-field col s1 m1' >
											<a onclick=javascript:deleteVarian('li_varian_1'); class='btn-floating waves-effect waves-red white right'><i class='mdi-navigation-close blue-grey-text'></i></a>
										</div>
									</li>
								</ul>
								<ul class='col s12 m12 cek-stok nolmar nolpad' style='display:none'>								
									<li class='input-field col s12 m12 nolmar nolpad'>
										<a class='btn-flat left' id='add-varian' onclick=javascript:addVarian()><b class='blue-text'><i class='mdi-content-add-box left'></i>TAMBAH VARIAN</b></a>
									</li>
								</ul>
								<ul class='col s12 m12 uncek-stok' >
									<li class='varsto'>
										<div class='input-field col s12 m6 tersedia' style='display:none'>
											<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label> <span class='text-red'>*</span>
										</div>
										<div class='input-field col s12 m6 pakai-stok' >
											<input id='varian' name='stok_utama' type='text' placeholder='Jumlah stok' maxlength='15' class='validate numbersOnly' required>
											<label for='varian'>Stok <span></span></label>
										</div>
									</li>
								</ul>
							</div>
							<div class='row formbody'>
								<div class='linehead'>HARGA BARANG</div>
								<div class='input-field col s12 m6'>
									<input id='harga_pembelian' name='harga_pembelian' maxlength='11' placeholder='0' type='text' class='validate ribuan'>
									<label for='harga_pembelian'>Harga Beli</label>
								</div>
								<div class='input-field col s12 m12 varsto'>
									<span for='harga_jual' style='font-weight:bold;'>Harga Jual </span>
								</div>";
								$a1 = 'block';
								if ($level_harga->level_2_active == 1) {$a2 = 'block';}else{$a2 = 'none';}
								if ($level_harga->level_3_active == 1) {$a3 = 'block';}else{$a3 = 'none';}
								if ($level_harga->level_4_active == 1) {$a4 = 'block';}else{$a4 = 'none';}
								if ($level_harga->level_5_active == 1) {$a5 = 'block';}else{$a5 = 'none';}
								echo"
								<ul class='col s12 m12'>
									<li class='varsto' style='display:$a1'>
										<div class='input-field col s12 m6 nolpad nolmar'>
											<input id='harga_level_1' maxlength='11' name='harga_level_1' type='text' placeholder='0' class='validate ribuan' required>
											<label for='harga_level_1'>Harga "; if ($level_harga->level_1_name != '') {echo $level_harga->level_1_name;}else{echo "level 1";} echo" <span class='text-red'>*</span></label>
										</div>
									</li>
									<li class='varsto' style='display:$a2'>
										<div class='input-field col s12 m6 nolpad nolmar'>
											<input id='harga_level_2' maxlength='11' name='harga_level_2' type='text' placeholder='0' class='validate ribuan' >
											<label for='harga_level_2'>Harga "; if ($level_harga->level_2_name != '') {echo $level_harga->level_2_name;}else{echo "level 2";} echo"</label>
										</div>
									</li>
									<li class='varsto' style='display:$a3'>
										<div class='input-field col s12 m6 nolpad nolmar'>
											<input id='harga_level_3' maxlength='11' name='harga_level_3' type='text' placeholder='0' class='validate ribuan' >
											<label for='harga_level_3'>Harga "; if ($level_harga->level_3_name != '') {echo $level_harga->level_3_name;}else{echo "level 3";} echo"</label>
										</div>
									</li>
									<li class='varsto' style='display:$a4'>
										<div class='input-field col s12 m6 nolpad nolmar'>
											<input id='harga_level_4' maxlength='11' name='harga_level_4' type='text' placeholder='0' class='validate ribuan' >
											<label for='harga_level_4'>Harga "; if ($level_harga->level_4_name != '') {echo $level_harga->level_4_name;}else{echo "level 4";} echo"</label>
										</div>
									</li>
									<li class='varsto' style='display:$a5'>
										<div class='input-field col s12 m6 nolpad nolmar'>
											<input id='harga_level_5' maxlength='11' name='harga_level_5' type='text' placeholder='0' class='validate ribuan' >
											<label for='harga_level_5'>Harga "; if ($level_harga->level_5_name != '') {echo $level_harga->level_5_name;}else{echo "level 5";} echo"</label>
										</div>
									</li>
								</ul>
								<div class='input-field col s12 m12 varsto'>
									<button class='btn waves-effect waves-light right col s12 m3' type='submit' value='1' name='action'>Simpan</button>																		
									<button class='btn waves-effect waves-light deep-orange right col s12 m3' value='0' type='submit' name='action'>Simpan Draft</button>
									<button class='btn waves-effect waves-light red right col s12 m3' type='button' name='action' onclick='location.href=\"".base_url()."produk/\"'>Batal</button>
								</div>
							</div>
						</div>
					</form>
				</div>
<script type='text/javascript' src='".base_url("")."assets/jController/enduser/CtrlProduk.js'></script>

";

?>