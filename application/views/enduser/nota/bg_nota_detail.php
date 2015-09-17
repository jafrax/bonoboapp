<?php
echo "
				<div class='col s12 m12 l12'>
					<div class='formain'>
						<div class='row '>
							<h6><a href='".base_url()."nota' class='btn-flat waves-red s12 blue-text'>
							    <i class='mdi-navigation-arrow-back '></i> Kembali
							</a></h6>

							<div class='col s12 m6'>							
								<div class='input-field col s12 m8 '>";
									if ($nota->status != 2) {
										echo "<button id='btn-batal-".$nota->id."' data-target='batal_nota_".$nota->id."' class=' modal-trigger btn-flat waves-effect red darken-1 white-text waves-light' type='button' name='action'>Batal</button>";
										if ($nota->status != 1) {
											echo"
										<button id='btn-bayar-".$nota->id."' data-target='bayar-".$nota->id."' class='btn modal-trigger waves-effect orange darken-1 white-text waves-light ' type='button' name='action'>Bayar</button>";
										}
									echo"
									<h6 class='hide-on-med-and-up'><br></h6>	
									<div id='batal_nota_".$nota->id."' class='modal confirmation'>
										<div class='modal-header red'>
											<i class='mdi-navigation-close left'></i> Hapus produk
										</div>
										<form class='modal-content'>
											<p>Apakah Anda yakin ingin membatalkan pesanan?</p>
											<p><input type='checkbox' class='filled-in' id='batal-cek-".$nota->id."'  />
      												<label for='batal-cek-".$nota->id."'>Kembalikan stok?</label></p>
										</form>
										<div class='modal-footer'>
											<a class=' modal-action modal-close waves-effect waves-light btn-flat'>TIDAK</a>
											<button type='button' onclick=javascript:batal_nota(".$nota->id.") class='btn-flat modal-action modal-close waves-effect '>YA</button>
										</div>
									</div>
									<div id='bayar-".$nota->id."' class='modal  modal-fixed-footer'>
										<div class='modal-header red'>
											<i class='mdi-action-label-outline left'></i> Pilih metode transaksi
										</div>
										<form class='modal-content' id='form-komfirmasi-".$nota->id."'>
											
												<label for='metode'>Pilih metode transaksi</label>
												<select id='metode-".$nota->id."' class='select-standar' onchange=javascript:change_metode(".$nota->id.")>
													";
													if ($toko->pm_store_payment == 1) {
														echo "<option value='1'>Bayar ditempat</option>";
														$show_rek = 'none';
													}
													if ($toko->pm_transfer == 1) {
														echo "<option value='2' "; if ($nota->member_confirm == 1) {echo 'selected';$show_rek = 'block';} echo ">Transfer via bank</option>";
														
													}
													
													$date 		= date('d M Y');
													
												echo"
												</select>
												
												<p>No. Transaksi : <span class='blue-text'>".$nota->invoice_no."</span></p>
												<p>Tanggal Konfirmasi : <span class='blue-text'>$date</span></p>
												<p>Jumlah yang di bayar : <span class='blue-text'>Rp. ".number_format($nota->price_total, 2 , ',' , '.')."</span></p><br>
												<p id='rekening-".$nota->id."' style='display:$show_rek;'>

													<label for='metode'>Pilih Rekening Tujuan</label>
													<select id='rek-".$nota->id."' class='select-standar'>
														<option value='' disabled >Pilih Rekening Tujuan</option>";
														if ($nota->member_confirm == 1) {
															$rekening_tujuan = $this->model_nota->get_rek_tujuan($nota->id);
															$selected = $rekening_tujuan->row()->toko_bank_id;
														}
														foreach ($rekening->result() as $row_rk) {
															$select = '';
															if ($row_rk->id == $selected) {$select = 'selected';}
															echo "<option $select value='".$row_rk->id."'>".$row_rk->name."</option>";
														}
														echo"
													</select>
											</p>
										</form>
										<div class='modal-footer'>
											<a class='modal-action modal-close waves-effect waves-red btn-flat' onclick=javascript:konfirmasi(".$nota->id.")>Konfirmasi</a>
											<a class='modal-action modal-close waves-effect waves-red btn-flat'>Batal</a>		
										</div>
									</div>";
									}else{
										echo "<br>";
									}
									echo "
									
								</div>
							</div>
							<div class='toolb col s12 m6'>
								<a href='#delete_nota_".$nota->id."' class='modal-trigger red-text right' href='#'><i class='mdi-action-delete small'></i></a>
								<!--<a href='".base_url()."message/kirim/".base64_encode($nota->member_email)."/".base64_encode($nota->member_name)."' class=' red-text right '><i class='mdi-content-mail small'></i></a>-->
								<a href='".base_url()."nota/cetak/".$nota->invoice_no."' onclick='window.open(\"".base_url()."nota/cetak/".$nota->invoice_no."\", \"newwindow\", \"width=800, height=600\"); return false;' class=' red-text right '><i class='mdi-action-print col s1 small'></i></a>
							</div>
							<div id='delete_nota_".$nota->id."' class='modal confirmation'>
								<div class='modal-header red'>
									<i class='mdi-navigation-close left'></i> Hapus produk
								</div>
								<form class='modal-content'>
									<p>Apakah anda yakin ingin menghapus nota dari <b>'".$nota->member_name."'</b> ?</p>
								</form>
								<div class='modal-footer'>
									<a href='javascript:void(0)' class=' modal-action modal-close waves-effect waves-light btn-flat'>TIDAK</a>
									<button type='button' onclick=javascript:delete_nota2(".$nota->id.") class='btn-flat modal-action modal-close waves-effect '>YA</button>
								</div>
							</div>
						</div>

						<div class='row '>
							<div class='linehead'></div>
							<div class='col s12 m6 left'>
								<h4 class='light'>No. Transaksi : ".$nota->invoice_no."</h4>";
			            		$old_date = $nota->create_date;
								$old_date_timestamp = strtotime($old_date);
								$date = date('d M Y', $old_date_timestamp);

								$ago 		= $this->template->xTimeAgoDesc($old_date,date('Y-m-d H:i:s'));
			            		echo"
								<h6>Tanggal : $date ( $ago )</h6>
								<h5><br></h5>
							</div>
							<div class='col s12 m6 right'>
								<h5 class='right-align light'><span class='blue-text'>".$nota->member_name."</span></h5>
								";
					            if ($nota->status == 0 ) {
					            	echo "<h6 class='red-text right' id='lunas-".$nota->id."'>Belum Lunas</h6>";
					            }elseif ($nota->status == 1) {								            	
					            	echo "<h6 class='green-text right' id='lunas-".$nota->id."'>Lunas</h6>";
					            }elseif ($nota->status == 2) {
					            	echo "<h6 class='grey-text right' id='lunas-".$nota->id."'>Batal</h6>";
					            }									
								echo"
							</div>
							<!-- nota -->
							<div class='col s12 m12'>";
								foreach ($produk->result() as $row_p) {
									$image = $this->model_nota->get_nota_product_image($row_p->id)->row();
									$images = base_url()."html/images/comp/product.png";
									if (count($image) > 0 ) {
										if (file_exists(base_url()."/assets/pic/product/".$image->product_image)) {
											$images = base_url()."assets/pic/product/resize/".$image->product_image;
										}										
									}
									echo "<div class='nota-product col s12 m6'>
											<img src='".$images."' class='responsive-img col s4 m4 left'>
											<div class='col s8 m8'>
												<p class='blue-text'>".$row_p->product_name."</p>
												<p><span class='blue-text'>@</span> Rp. ".number_format($row_p->price_unit, 0 , ',' , '.')."</p>
												<p><dl class='dl-horizontal col s12 ' >
	
							                	
												";

												$varian = $this->model_nota->get_varian_product($row_p->id);
												if ($varian->num_rows() > 0) {
													foreach ($varian->result() as $row_v) {
														if ($row_v->varian_name == 'null') {
															echo "	<dt style='text-align:left'><b>Jumlah : </b></dt>
							                						<dd>".$row_v->quantity."</dd>";
														}else{
															echo "	<dt style='text-align:left'><b>".$row_v->varian_name."</b><span class='grey-text'> x ".$row_v->quantity."</span></dt>
							                						<dd>= Rp. ".number_format($row_v->price_varian, 0 , ',' , '.')."</dd>";															
														}
													}
												}
											echo "
												</dl></p>	
												<h5> Rp. ".number_format($row_p->price_product, 0 , ',' , '.')."</h5>
											</div>
										</div>";
								}
  							echo "
							</div>

							<div class='col s12 m6'>
								<h5><br></h5>
								<h5><br></h5>
								<div class='col s6 m6 left-align'>
									<p>Total nota :</p>
									<p>Biaya kirim :</p>";
									if ($nota->invoice_seq_payment > 0) {
										echo "<p>Kode unik :</p>";
									}
									echo"									
																		
								</div>
								<div class='col s6 m6 right-align'>
									<p>Rp ".number_format($nota->price_item, 0 , ',' , '.')."</p>
									<p>Rp ".number_format($nota->price_shipment, 0 , ',' , '.')."</p>";
									if ($nota->invoice_seq_payment > 0) {
										echo  number_format($nota->invoice_seq_payment, 0 , ',' , '.')."</p>";
									}
									echo"
								</div>
								<div class='line'></div>
								<div class='col s6 m6 left-align'>
									<b>Total Transaksi :</b>								
								</div>
								<div class='col s6 m6 right-align'>
									<b>Rp ".number_format($nota->price_total, 0 , ',' , '.')."</b>								
								</div>

							</div>
							<div class='col s12 m6'>
								<h5><br></h5>
								<div class='line '></div>
								<h5><br></h5>
								<div class='col s6 m6 left-align'>
									<b>Detail Pengiriman :</b>
									<p>Pengiriman via :</p>
									<p>No. Resi :</p>
									<p>Nama Penerima :</p>
									<p>Telepon :</p>
									<p>Alamat :</p>
									<p>Kecamatan :</p>
									<p>Kota :</p>
									<p>Provinsi :</p>
								</div>
								<div class='col s6 m6 right-align'>
									<a href='#pengiriman' class='modal-trigger' >edit</a>
									<p>".$nota->shipment_service."</p>
									<p>".($nota->shipment_no == '' ? "<br>" : $nota->shipment_no)."</p>
									<p>".$nota->recipient_name."</p>
									<p>".$nota->recipient_phone."</p>
									<p>".$nota->recipient_address."</p>
									<p>".$nota->location_to_kecamatan."</p>
									<p>".$nota->location_to_city."</p>
									<p>".$nota->location_to_province."</p>
								</div>			
							</div>
							<div class='col s12 m6'>
								<h5><br></h5>
								<div class='line'></div>
								<h5><br></h5>
								<div class='col s12 m12'>
									<a class='right col s2 m2 right-align' onclick=javascript:edit_notes(".$nota->id.") >Edit</a>
									<textarea id='note' disabled class='materialize-textarea notes-".$nota->id."' >".$nota->notes."</textarea>
									<label for='note'>Note</label>							
								</div>
								<div class='col s12 m12'>
									<a onclick=javascript:simpan_notes(".$nota->id.") class='tombol-notes-".$nota->id." col right' style='display: none;'>Simpan</a>
									<a onclick=javascript:batal_notes(".$nota->id.") class='tombol-notes-".$nota->id." col right red-text' style='display: none;'>Batal</a>	
								</div>
							</div>
							<div class='col s12 m6'>
								<br>							
							</div>";
							if ($nota->member_confirm == 1) {
							$rekening = $this->model_nota->get_rek_tujuan($nota->id)->row();
							echo "
								<div class='col s12 m6'>
									<h5 class='hide-on-med-and-up'><br></h5>
									<div class='line hide-on-med-and-up'></div>
									<h5 class='hide-on-med-and-up'><br></h5>
									<h6>Detail Pembayaran</h6>
									<div class='col s6 m6 left-align'>
										<b>Bank Asal :</b>
										<p>".$rekening->from_bank."</p>
										<p>".$rekening->from_acc_no."</p>
										<p>".$rekening->from_acc_name."</p>
									</div>
									<div class='col s6 m6 right-align'>
										<b>Bank Tujuan</b>
										<p>".$rekening->to_bank."</p>
										<p>".$rekening->to_acc_no."</p>
										<p>".$rekening->to_acc_name."</p>
									</div>
								</div>";
							}
						echo"
						</div>

						<div class='row '>
							<div id='pengiriman' class='modal modal-fixed-footer'>
								<div class='modal-content'>
									<form id='form-pengiriman'>
										<input type='hidden' value='".$nota->id."' name='id_nota' />
										<div class='input-field col s12 m6'>
											<label>Jenis Pengiriman</label>
											<select class='selectize' name='kurir'>
												<option value='' disabled selected>Pilih Jenis Pengiriman</option>
												<option value='Ambil di toko'>Ambil di toko</option>";
												$toko_kurir = $this->model_nota->get_toko_kurir($nota->toko_id);
												foreach ($toko_kurir->result() as $kurir_t) {
													$select = '';
													if ($kurir_t->name == $nota->shipment_service) {$select = 'selected';}
													echo "<option $select value='".$kurir_t->name."'>".$kurir_t->name."</option>";
												}
												$kustom_kurir = $this->model_nota->get_kustom_kurir($nota->toko_id);
												foreach ($kustom_kurir->result() as $kurir_k) {
													$select = '';
													if ($kurir_k->name == $nota->shipment_service) {$select = 'selected';}
													echo "<option $select value='".$kurir_k->name."'>".$kurir_k->name."</option>";
												}	
												echo"								
											</select>
										</div>
										<div class='input-field col s12 m8'>
											<input disabled id='biaya' name='biaya' type='text' class='validate' value='".$nota->price_shipment."'>
											<label for='biaya'>Biaya Pengiriman</label>
										</div>
										<div class='input-field col s12 m8'>
											<input id='nomor-resi' name='nomor-resi' type='text' class='validate' value='".$nota->shipment_no."'>
											<label for='nomor-resi'>Nomor Resi</label>
										</div>	
										<div class='input-field col s12 m8'>
											<input disabled id='namane' name='namane' type='text' class='validate' value='".$nota->recipient_name."'>
											<label for='namane'>Nama Penerima</label>
										</div>						
										<div class='input-field col s12 m8'>
											<input disabled id='phone' name='phone' type='text' class='validate' value='".$nota->recipient_phone."'>
											<label for='phone'>Nomor Penerima</label>
										</div>
										<div class='input-field col s12 m8'>
											<input disabled id='postal-code' name='postal-code' type='text' onkeyup=javascript:set_location() class='validate' value='".$nota->location_to_postal."'>
											<label for='postal-code'>Kode Pos</label>
										</div>
										<div class='input-field col s12 m8'>
											<textarea disabled id='alamat' name='alamat' class='materialize-textarea' >".$nota->recipient_address."</textarea>
											<label for='alamat'>Alamat Penerima</label>
										</div>
										<div class='input-field col s12 m6' id='panggon-province'>
											<span>Pilih Provinsi</span>
											<select disabled class='chosen-select' name='province' id='province' onchange=javascript:set_city()>
												<option value='' disabled selected>Pilih Provinsi</option>";
												$provinsi = $this->model_nota->get_province();
												foreach ($provinsi->result() as $row_p) {
													$select = '';
													if ($row_p->province == $nota->location_to_province) {$select = 'selected';}
													echo "<option $select value='".$row_p->province."'>".$row_p->province."</option>";
												}	
												echo"
											</select>
										</div>
										<div class='input-field col s12 m6' id='panggon-city'>
											<span>Pilih Kota</span>
											<select disabled class='chosen-select' name='city' id='city' onchange=javascript:set_kecamatan()>
												<option value='' disabled selected>Pilih Kota</option>";
												if ($nota->location_to_city != '') {
													$kota = $this->model_nota->get_city($nota->location_to_province);
													foreach ($kota->result() as $row_k) {
														$select = '';
														if ($row_k->city == $nota->location_to_city) {$select = 'selected';}
														echo "<option $select value='".$row_k->city."'>".$row_k->city."</option>";
													}	
												}else{
													$kota = $this->model_nota->get_city($nota->location_to_province);
													foreach ($kota->result() as $row_k) {
														echo "<option value='".$row_k->city."'>".$row_k->city."</option>";
													}	
												}
												
												echo"
											</select>
										</div>
										<div class='input-field col s12 m6' id='panggon-kecamatan'>
											<span>Pilih Kecamatan</span>
											<select disabled class='chosen-select' name='kecamatan' id='kecamatan'>
												<option value='' disabled selected>Pilih Kecamatan</option>";
												if ($nota->location_to_kecamatan != '') {
													$kecamatan = $this->model_nota->get_kecamatan($nota->location_to_city);
													foreach ($kecamatan->result() as $row_c) {
														$select = '';
														if ($row_c->kecamatan == $nota->location_to_kecamatan) {$select = 'selected';}
														echo "<option $select value='".$row_c->kecamatan."'>".$row_c->kecamatan."</option>";
													}	
												}else{
													$kecamatan = $this->model_nota->get_kecamatan($nota->location_to_city);
													foreach ($kecamatan->result() as $row_c) {
														echo "<option value='".$row_c->kecamatan."'>".$row_c->kecamatan."</option>";
													}	
												}																	
												echo"
											</select>
										</div>						
									</form>
								</div>
								<div class='modal-footer'>
									<a onclick=javascript:confirm_courier(1) class='modal-action modal-close waves-effect waves-red btn-flat'>Konfirmasi</a>
									<a class='modal-action modal-close waves-effect waves-red btn-flat'>Batal</a>		
								</div>
							</div>
						</div>
					</div>
				</div>
<script type='text/javascript' src='".base_url("")."assets/jController/enduser/CtrlNota.js'></script>
";
?>