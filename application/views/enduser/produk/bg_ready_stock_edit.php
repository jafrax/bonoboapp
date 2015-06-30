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
					<form class='formain'id='form-ready' method='post' action='' enctype='multipart/form-data'>
						<div class='formhead'>
							<h2 class='titmain'><b>EDIT BARANG READY STOCK</b></h2>
						</div>
						<div class='row formbody'>
							<div class='col s12'>
								<div class='col s12 m6'>
									<label>Tipe barang <span class='text-red'>*</span></label>
									<label class='error error-chosen' for='tipe'></label>
									<select name='tipe'>
										<option value='' disabled selected>Choose your option</option>
										<option value='1' "; if ($produk->stock_type == 0) echo "selected"; echo">Ready Stock</option>
										<option value='0' "; if ($produk->stock_type == 1) echo "selected"; echo">Pre Order</option>										
									</select>									
								</div>
								<div class='input-field col s12'>
									<input id='nama_barang' name='nama' type='text' class='validate' length='50' value='".$produk->name."' required>
									<label for='nama_barang'>Nama barang <span class='text-red'>*</span></label>									
								</div>
								<div class='input-field col s12'>
									<input id='nomor_sku' type='text' name='sku' class='validate' length='20' value='".$produk->sku_no."'>
									<label for='nomor_sku'>Nomor SKU</label>
								</div>
								<div class='col s12 m6' id='tempat-kategori'>
									<label>Kategori barang <span class='text-red'>*</span></label>
									<label class='error error-chosen' for='select-kategori'></label>
									<select name='kategori' id='select-kategori' required>
										<option value='' disabled selected>Choose your option</option>";
										foreach ($kategori->result() as $row_ktgri) {
											$select = '';
											if ($row_ktgri->id == $produk->kategori) {$select = 'selected';}
											echo "<option value='".$row_ktgri->id."' $select>".$row_ktgri->name."</option>";
										}
										echo"
									</select>
								</div>
								<div class='input-field col s12 m6'>
									<a href='#add_kategori' class='btn-flat right modal-trigger'><b class='blue-text'><i class='mdi-content-add-box left'></i>BUAT KATEGORI BARU</b></a>
								</div>
								<div class='input-field col s12 picture-area'>";
                                    $pic    = $this->model_produk->get_one_image($produk->id);
                                    $i      = 1;
                                    if(count($pic->result())>0){
                                        foreach($pic->result() as $item){
                                           echo "
	                                           	<div class='col s6 m4 l3' id='div_pic_".$item->id."'>
													<div class='card' >
														<a class='delimg' onclick=javascript:remove_picture('pic_".$item->id."')><i class='mdi-content-backspace'></i></a>
														<div class='card-image img-product waves-effect waves-block waves-light'>
															<img id='img_pic_".$item->id."' onclick=javascript:click_picture('pic_".$item->id."') class='responsive-img img-product' src='".base_url()."assets/pic/product/resize/".$item->file."'>
															<input type='file' class='pic_product' name='pic_".$item->id."' id='pic_".$item->id."' style='opacity: 0.0;width:1px; height:1px' OnChange=javascript:picture_upload(this.id)>
														</div>
														<label for='pic_".$item->id."' class='error error-image' generated='true'></label>										
													</div>										
												</div>
                                            ";
                                            $i++;
                                        }
                                    }else{
                                        echo "
                                            <div class='col s6 m4 l3' id='div_pic_1'>
												<div class='card' >
													<a class='delimg' onclick=javascript:remove_picture('pic_1')><i class='mdi-content-backspace'></i></a>
													<div class='card-image img-product waves-effect waves-block waves-light'>
														<img id='img_pic_1' onclick=javascript:click_picture('pic_1') class='responsive-img img-product' src='".base_url()."html/images/comp/product_large.png'>
														<input type='file' class='pic_product' name='pic_1' id='pic_1' style='opacity: 0.0;width:1px; height:1px' OnChange=javascript:picture_upload(this.id)>
													</div>
													<label for='pic_1' class='error error-image' generated='true'></label>										
												</div>										
											</div>
                                        ";
                                    }
                                    echo "
									
								</div>
								<input type='hidden' name='total_picture' id='total_picture' value='1'/>
								<div class='input-field col s12 m12'>
									<a class='btn-flat right' onclick=javascript:add_picture()><b class='blue-text'><i class='mdi-content-add-box left'></i>TAMBAH GAMBAR</b></a>
								</div>
								<div class='input-field col s12'>
									<input id='perkiraan_berat' placeholder='0.00' type='text' name='berat' class='validate' value='".$produk->berat."'>
									<label for='perkiraan_berat'>Perkiraan berat <span>( Kilogram)</span></label>
								</div>
								<div class='input-field col s12'>
									<input id='satuan' type='text' name='satuan' placeholder='Misal: Lusin, Pcs' class='validate' length='5' value='".$produk->satuan."'>
									<label for='satuan'>Satuan <span></span></label>
								</div>
								<div class='input-field col s12'>
									<input id='min_order' placeholder='1' type='text' name='min_order' class='validate numbersOnly' value='".$produk->min_order."'>
									<label for='min_order'>Min order</label>
								</div>
								<div class='input-field col s12'>
									<textarea id='deskripsi' name='deskripsi' class='materialize-textarea' length='250' >".$produk->description."</textarea>
									<label for='deskripsi'>Deskripsi</label>
								</div>
								
							</div>
							<div class='row formbody'>
								<div class='linehead'>Stok Barang</div>
								<div class=' col s12 m6'>
								<label>Tipe stok <span class='text-red'>*</span></label>
								<label class='error error-chosen' for='stok'></label>
									<select name='stok' id='stok' required OnChange=javascript:change_stok()>										
										<option value='1' "; if ($produk->tipe_stok == 1) echo "selected"; echo">Stok selalu tersedia</option>
										<option value='0' "; if ($produk->tipe_stok == 0) echo "selected"; echo">Gunakan stok</option>
									</select>									
								</div>";
								if ($produk->tipe_stok == 1) {
									$tersedia = 'block';
									$guna_stok= 'none';
								};

								if ($produk->tipe_stok == 0) {
									$tersedia = 'none';
									$guna_stok= 'block';
								};
								$varian = $this->model_produk->get_varian_produk($produk->id);
								if ($produk->tipe_stok == 1) {};
								echo"
								<div class='input-field col s12 m12'>
									<input type='checkbox' id='gunakan_varian' name='gunakan_varian' onclick=javascript:setVarian() />
									<label for='gunakan_varian'>Gunakan varian</label>
								</div>
								<input type='hidden' name='total_varian' value='1' id='tot_varian' />
								<ul class='col s12 m12 cek-stok' id='tempat-varian' style='display:none'>
									<li class='varsto' id='li_varian_1'>
										<div class='input-field col s12 m5'>
											<input id='varian' name='nama_varian_1' type='text' placeholder='Misal: Lusin, Pcs' class='validate'>
											<label for='varian'>Varian <span></span></label>
										</div>
										<div class='input-field col s11 m5 tersedia'>
											<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label>
										</div>
										<div class='input-field col s11 m5 pakai-stok'  style='display:none'>
											<input id='varian' name='stok_varian_1' type='text' placeholder='Jumlah stok' class='validate numbersOnly'>
											<label for='varian'>Stok <span></span></label>											
										</div>
										<div class='input-field col s1 m1' >
											<a onclick=javascript:deleteVarian('li_varian_1'); class='btn-floating btn-xs waves-effect waves-red white right'><i class='mdi-navigation-close blue-grey-text'></i></a>
										</div>
									</li>
								</ul>
								<ul class='col s12 m12 cek-stok' style='display:none'>								
									<li class='input-field col s12 m12'>
										<a class='btn-flat left' onclick=javascript:addVarian()><b class='blue-text'><i class='mdi-content-add-box left'></i>TAMBAH VARIAN</b></a>
									</li>
								</ul>
								<ul class='col s12 m12 uncek-stok' >
									<li class='varsto'>
										<div class='input-field col s12 m6 tersedia'>
											<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label>
										</div>
										<div class='input-field col s12 m6 pakai-stok' style='display:none'>
											<input id='varian' name='stok_utama' type='text' placeholder='Jumlah stok' class='validate numbersOnly'>
											<label for='varian'>Stok <span></span></label>
										</div>
									</li>
								</ul>
							</div>
							<div class='row formbody'>
								<div class='linehead'>Harga Barang</div>
								<div class='input-field col s12 m6'>
									<input id='harga_pembelian' name='harga_pembelian' type='text' class='validate numbersOnly' value='".$produk->harga_pembelian."'>
									<label for='harga_pembelian'>Harga pembelian</label>
								</div>
								<div class='input-field col s12 m12 varsto'>
									<label for='harga_jual'>Harga jual <span class='text-red'>*</span></label>
								</div>

								<ul class='col s12 m12'>
									<li class='varsto'>
										<p><br></p>
										<div class='input-field col s12 m6'>
											<input id='varian' name='harga_level_1' type='text' placeholder='0' class='validate numbersOnly' required value='".$produk->harga_1."'>
											<label for='varian'>Harga "; if ($level_harga->level_1_name != '') {echo $level_harga->level_1_name;}else{echo "level 1";} echo" <span class='text-red'>*</span></label>
										</div>
									</li>
									<li class='varsto'>
										<div class='input-field col s12 m6'>
											<input id='varian' name='harga_level_2' type='text' placeholder='0' class='validate numbersOnly' value='".$produk->harga_2."'>
											<label for='varian'>Harga "; if ($level_harga->level_2_name != '') {echo $level_harga->level_2_name;}else{echo "level 2";} echo"</label>
										</div>
									</li>
									<li class='varsto'>
										<div class='input-field col s12 m6'>
											<input id='varian' name='harga_level_3' type='text' placeholder='0' class='validate numbersOnly' value='".$produk->harga_3."'>
											<label for='varian'>Harga "; if ($level_harga->level_3_name != '') {echo $level_harga->level_3_name;}else{echo "level 3";} echo"</label>
										</div>
									</li>
									<li class='varsto'>
										<div class='input-field col s12 m6'>
											<input id='varian' name='harga_level_4' type='text' placeholder='0' class='validate numbersOnly' value='".$produk->harga_4."'>
											<label for='varian'>Harga "; if ($level_harga->level_4_name != '') {echo $level_harga->level_4_name;}else{echo "level 4";} echo"</label>
										</div>
									</li>
									<li class='varsto'>
										<div class='input-field col s12 m6'>
											<input id='varian' name='harga_level_5' type='text' placeholder='0' class='validate numbersOnly' value='".$produk->harga_5."'>
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