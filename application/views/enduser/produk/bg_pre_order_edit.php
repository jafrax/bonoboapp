<?php
$uri3 = $this->uri->segment(3);
$weight= $produk->berat;

$weights = explode(".",$weight);
if(!isset($weights[1])){
	$weight = $weight * 100;
}

echo "
<div id='delete_produk' class='modal confirmation'>
	<div class='modal-header red'>
		<i class='mdi-navigation-close left'></i> Hapus produk
	</div>
	<form class='modal-content'>
		<p>Apakah anda yakin ingin menghapus <b>'nama produk'</b> ?</p>
	</form>
	<div class='modal-footer'>
		<a class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
		<a class=' modal-action modal-close waves-effect waves-red btn-flat'>YA</a>
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
		<a class=' modal-action modal-close waves-effect waves-red btn-flat'>YA</a>
		<a class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
	</div>
</div>

<div id='add_kategori' class='modal confirmation'>	
	<div class='modal-header teal'>
		<i class='mdi-content-add-box left'></i> Tambah kategori
	</div>	
	<form class='modal-content' id='form_add_kategori'>
		<span for='nama_kategori'>Nama kategori <span class='text-red'>*</span></label>
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
						<li><a href='".base_url()."produk/index/1'>READY STOCK</a></li>
						<li><a class='active' href='".base_url()."produk/pre_order/1'>PRE ORDER</a></li>
						<li><a href='".base_url()."produk/atur_kategori'>ATUR KATEGORI</a></li>	
					</ul>
				</div>
				<div class='col s12 m12 l9'>
					<form class='formain'id='form-pre' method='post' action='' enctype='multipart/form-data'>
						<div class='formhead'>
							<h2 class='titmain'><b>EDIT BARANG PRE ORDER</b></h2>
						</div>
						<div class='row formbody'>
							<br>
							<div class='col s12'>
								<div class='input-field col s12'>
									<input id='nama_barang' name='nama' type='text' placeholder='Ex : Baju Bonobo' maxlength='50' class='validate' length='50' value='".$produk->name."' required>
									<label for='nama_barang'>Nama Barang <span class='text-red'>*</span></label>									
								</div>
								<div class='input-field col s12'>
									<input id='nomor_sku' type='text' name='sku' placeholder='Ex : AD001' maxlength='20' class='validate' length='20' value='".$produk->sku_no."'>
									<label for='nomor_sku'>Kode Barang</label>
								</div>";
								$old_date 			= $produk->end_date;
								$old_date_timestamp = strtotime($old_date);
								$date 				= date('Y/m/d', $old_date_timestamp);
								echo"
								<div class='input-field col s12'>
									<input  id='tgl_pre_order' data-value='$date' name='tgl_pre_order'  type='text' placeholder='Tanggal selesai PRE ORDER' class='datepicker validate'>
									<label for='tgl_pre_order'>Tanggal selesai PRE ORDER <span class='text-red'>*</span></label>
									<label class='error' for='tgl_pre_order'></label>
								</div>
								<div class='col s12 m6' id='tempat-kategori'>
									<label>Kategori Barang <span class='text-red'>*</span></label>
									<label class='error error-chosen' for='select-kategori'></label>
									<select class='selectize' name='kategori' id='select-kategori' required>
										<option value='' disabled selected>Pilih Kategori Barang</option>";
										foreach ($kategori->result() as $row_ktgri) {
											$select = '';
											if ($row_ktgri->id == $produk->kategori) {$select = 'selected';}
											echo "<option value='".$row_ktgri->id."' $select>".$row_ktgri->name."</option>";
										}
										echo"
									</select>
								</div>
								<div class='input-field col s12 m6'>
									<a href='#add_kategori' onclick=javascript:reset_cat() class='btn-flat right modal-trigger'><b class='blue-text'><i class='mdi-content-add-box left'></i>BUAT KATEGORI BARU</b></a>
								</div>

								<div class='input-field col s12'>
									<span>Image Produk</span>
									<div class=' picture-area'>";
	                                    $pic    = $this->model_produk->get_one_image($produk->id);
	                                    $i      = 1;
	                                    if(count($pic->result())>0){
	                                        foreach($pic->result() as $item){
	                                           echo "
		                                           	<div class='col s6 m3 l2' id='div_pic_edit_".$item->id."'>
														<div class='card' >
															<a class='delimg' id='rem_pic_edit_".$item->id."' onclick=javascript:remove_picture('pic_edit_".$item->id."')><i class='mdi-navigation-close right'></i></a>
															<div class='card-image img-product waves-effect waves-block waves-light'>
																<img id='img_pic_edit_".$item->id."' onclick=javascript:click_picture_edit('pic_edit_".$item->id."') class='responsive-img img-product' src='".base_url()."assets/pic/product/resize/".$item->file."'>
																<input type='file' class='pic_edit_product' name='pic_edit_".$item->id."' id='pic_edit_".$item->id."' style='opacity: 0.0;width:1px; height:1px' OnChange=javascript:picture_upload(this.id,image_resize_".$item->id.")>
																<input id='image_resize_".$item->id."' type='hidden' name='image_resize_".$item->id."' />
															</div>
															<label for='pic_edit_".$item->id."' class='error error-image' generated='true'></label>										
														</div>										
													</div>
	                                            ";
	                                            $i++;
	                                        }
	                                    }
	                                    $nol = 6-$i;
	                                    for ($i=1; $i <= $nol ; $i++){
	                                        echo "
	                                            <div class='col s6 m3 l2' id='div_pic_".$i."'>
													<div class='card' >
														<a class='delimg' id='rem_pic_".$i."' style='display:none' onclick=javascript:remove_picture('pic_".$i."')><i class='mdi-navigation-close right'></i></a>
														<div class='card-image img-product waves-effect waves-block waves-light'>
															<img id='img_pic_".$i."' onclick=javascript:click_picture('pic_".$i."') class='responsive-img img-product' src='".base_url()."html/images/comp/product_large.png'>
															<input type='file' class='pic_product' name='pic_".$i."' id='pic_".$i."' style='opacity: 0.0;width:1px; height:1px' OnChange=javascript:picture_upload(this.id,image_resize_".$i.")>
															<input id='image_resize_".$i."' type='hidden' name='image_resize_".$i."' />
														</div>
														<label for='pic_".$i."' class='error error-image' generated='true'></label>										
													</div>										
												</div>
	                                        ";
	                                    }
	                                    echo "
	                                </div>
									<!--<a class='btn-flat left' onclick=javascript:add_picture()><b class='blue-text'><i class='mdi-content-add-box left'></i>TAMBAH GAMBAR</b></a>-->
								</div>
								<input type='hidden' name='total_picture' id='total_picture' value='$nol'/>
								<div class='input-field col s12 m8'>
									<span class='grey-text'><b>Ukuran Maks</b> : 1 MB.</span><br>
									<span class='grey-text'><b>Format</b> : .jpg, .png.</span>
								</div>

								<div class='input-field col s12'>
									<input id='perkiraan_berat' placeholder='0,00' type='text' name='berat' class='validate berat' value='".$weight."'>
									<label for='perkiraan_berat'>Perkiraan Berat <span>( Kilogram)</span></label>
								</div>
								<div class='input-field col s12'>
									<input id='satuan' type='text' name='satuan' placeholder='Misal: Pcs' class='validate' length='5' value='".$produk->satuan."'>
									<label for='satuan'>Satuan <span></span></label>
								</div>
								<div class='input-field col s12'>
									<input id='min_order' placeholder='1' type='text' name='min_order' class='validate numbersOnly' value='".$produk->min_order."'>
									<label for='min_order'>Min Order</label>
								</div>
								<div class='input-field col s12'>
									<textarea id='deskripsi' placeholder='Ex : Baju bonobo adalah baju berkualitas.' name='deskripsi' class='materialize-textarea' length='250' >".$produk->description."</textarea>
									<label for='deskripsi'>Deskripsi</label>
								</div>
								
							</div>
											
											
							
							<div class='row formbody'>
								<div class='linehead'>VARIAN BARANG</div>
								<div class=' col s12 m6' name='stokPr' id='stokPr' required OnChange=javascript:change_stokPr()>
								</div>";
								if ($produk->tipe_stok == 1) {
									$tersedia = 'block';
									$guna_stok= 'none';
								};

								if ($produk->tipe_stok == 0) {
									$tersedia = 'none';
									$guna_stok= 'block';
								};

								$varian_null = $this->model_produk->get_varian_produk_null($produk->id);
								if ($varian_null->num_rows() > 0) {
									$checked 	= '';
									$cek_stok 	= 'none';
									$uncek_stok	= 'block';
									$stok_utama = $varian_null->row()->stock_qty;
								}else{
									$checked 	= 'checked';
									$cek_stok 	= 'block';
									$uncek_stok	= 'none';
									$stok_utama = '';
								}
								
								$varian = $this->model_produk->get_varian_produk($produk->id);
								echo"
										
								
								<div class='input-field col s12 m12'>
									<input type='checkbox' id='gunakan_varian' name='gunakan_varian' onclick=javascript:setVarianPr() $checked/>
									<label for='gunakan_varian'>Gunakan varian</label>
								</div>
								
								
								<input type='hidden' name='total_varian' value='1' id='tot_varian' />
								<ul class='col s12 m12 cek-stok' id='tempat-varian' >";
									if ($varian_null->num_rows() == 0) {
										foreach ($varian->result() as $row_var) {
											echo"<li class='varsto nolmar' id='li_edit_varian_".$row_var->id."'>
													<div class='input-field col s12 m5 '>
														<span for='varian'>Varian <span class='text-red'>*</span></span>  
														<input id='varian' name='nama_edit_varian_".$row_var->id."' maxlength='30' value='".$row_var->name."' type='text' placeholder='Ex : Merah' class='validate' required>
													</div>
													<div class='input-field col s1 m1'>
														<a onclick=javascript:deleteVarian('li_edit_varian_".$row_var->id."'); class='btn-floating btn-xs waves-effect waves-red white right'><i class='mdi-navigation-close blue-grey-text'></i></a>
													</div> 
												</li>";
										}
									
									}
									
									// $addVar = 'block';
									// if ($varian_null->num_rows() > 5) {
									// 	$addVar = 'none';
									// }
									$jumlah = $this->model_produk->get_varian_produk($produk->id);
									$jum = $jumlah->num_rows();
									$addVar = 'block';
									if ( $jum < 1) {
										$addVar = 'none';
									}
									 if($jum >= 5){
										$addVar = 'none';
									}
									
									echo"
								</ul>
								
								<ul class='col s12 m12 cek-stok' style='display:$cek_stok'>								
									<li class='input-field col s12 m12 nolmar'>
										<a class='btn-flat left' id='add-varianPr' style='display:$addVar' onclick=javascript:addVarianPr()><b class='blue-text'><i class='mdi-content-add-box left'></i>TAMBAH VARIAN</b></a>
									</li>
								</ul>
								
							</div>				
											
											
											
							<div class='row formbody'>
								<div class='linehead'>HARGA BARANG</div>
								<div class='input-field col s12 m6'>
									<input id='harga_pembelian' maxlength='11' name='harga_pembelian' type='text' placeholder='0' class='validate ribuan' value='".$produk->harga_pembelian."'>
									<label for='harga_pembelianmbelian'>Harga Beli</label>
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
											<input id='harga_level_1' maxlength='11' name='harga_level_1' type='text' placeholder='0' class='validate ribuan' required value='".$produk->harga_1."'>
											<label for='harga_level_1'>Harga "; if ($level_harga->level_1_name != '') {echo $level_harga->level_1_name;}else{echo "level 1";} echo" <span class='text-red'>*</span></label>
										</div>
									</li>
									<li class='varsto' style='display:$a2'>
										<div class='input-field col s12 m6 nolpad nolmar'>
											<input id='harga_level_2' maxlength='11' name='harga_level_2' type='text' placeholder='0' class='validate ribuan' value='".$produk->harga_2."'>
											<label for='harga_level_2'>Harga "; if ($level_harga->level_2_name != '') {echo $level_harga->level_2_name;}else{echo "level 2";} echo"</label>
										</div>
									</li>
									<li class='varsto' style='display:$a3'>
										<div class='input-field col s12 m6 nolpad nolmar'>
											<input id='harga_level_3' maxlength='11' name='harga_level_3' type='text' placeholder='0' class='validate ribuan' value='".$produk->harga_3."'>
											<label for='harga_level_3'>Harga "; if ($level_harga->level_3_name != '') {echo $level_harga->level_3_name;}else{echo "level 3";} echo"</label>
										</div>
									</li>
									<li class='varsto' style='display:$a4'>
										<div class='input-field col s12 m6 nolpad nolmar'>
											<input id='harga_level_4' maxlength='11' name='harga_level_4' type='text' placeholder='0' class='validate ribuan' value='".$produk->harga_4."'>
											<label for='harga_level_4'>Harga "; if ($level_harga->level_4_name != '') {echo $level_harga->level_4_name;}else{echo "level 4";} echo"</label>
										</div>
									</li>
									<li class='varsto' style='display:$a5'>
										<div class='input-field col s12 m6 nolpad nolmar'>
											<input id='harga_level_5' maxlength='11' name='harga_level_5' type='text' placeholder='0' class='validate ribuan' value='".$produk->harga_5."'>
											<label for='harga_level_5'>Harga "; if ($level_harga->level_5_name != '') {echo $level_harga->level_5_name;}else{echo "level 5";} echo"</label>
										</div>
									</li>
								</ul>
								<div class='input-field col s12 m12 varsto'>
									<button class='btn waves-effect waves-light right col s12 m3' type='submit' value='1' name='action'>Simpan</button>																		
									<button class='btn waves-effect waves-light deep-orange right col s12 m3' value='0' type='submit' name='action'>Simpan Draft</button>
									<button class='btn waves-effect waves-light red right col s12 m3' type='button' name='action' onclick='location.href=\"".base_url()."produk/pre_order\"'>Batal</button>
								</div>
							</div>
						</div>
					</form>
				</div>
<script type='text/javascript' src='".base_url("")."assets/jController/enduser/CtrlProduk.js'></script>

";

?>
