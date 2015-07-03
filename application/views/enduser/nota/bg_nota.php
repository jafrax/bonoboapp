<?php
echo"
				<div class='col s12 m12 l12'>
					<div class='formain'>
						<div class='formhead'>
							<h2 class='titmain'><b>NOTA PEMBELIAN</b></h2>
						</div>
						<div class='row formbody'>
							<div class='col s12 listline'>
								<div class='input-field col s12 m12 l8 nolpad'>
									<!-- <a class='waves-effect orange-text left '><i class='mdi-action-star-rate col s6 m1 small'></i></a> -->
									<a class='waves-effect orange-text left '><i class='mdi-content-flag col s6 m1 small'></i></a>
									
									<div class='input-field col s12 m3 left'>
										<select class='select-standar' id='sort' onchange=javascript:change_sort()>										
											<option value='1'>Paling Baru</option>
											<option value='2'>Paling Lama</option>										
										</select>									
									</div>
									<div class='input-field col s12 m3 left'>
										<select class='select-standar' id='tipe_bayar' onchange=javascript:change_bayar()>										
											<option value='1'>Belum Lunas</option>
											<option value='2'>Lunas</option>
											<option value='3'>Semua</option>
										</select>									
									</div>
									<div class='input-field col s12 m3 left'>
										<select class='select-standar' id='tipe_stok' onchange=javascript:change_stock()>
											<option value='1'>Pre Order</option>
											<option value='2'>Ready Stok</option>
										</select>									
									</div>
									
								</div>
								<div class='input-field col s12 m12 l4 nolpad'>
									<i class='mdi-action-search prefix'></i>
									<input id='nama' type='text' class='validate' onkeypress=javascript:search_nota() id='keyword_nota'>
									<label for='nama'>Cari</label>
								</div>
							</div>
							<div class='col s12 listline'>								
      							<p class='checkallboxnota left'>
									<input type='checkbox' class='filled-in' onclick=javascript:cek_all_nota() id='pilih-semua'  />
      								<label for='pilih-semua'></label>									
								</p>
								<div class='input-field col s6 m3'>
									<select class='select-standar' id='option-go'>
										<option value=''>Pilih Tindakan</option>
										<option value='0'>Batal</option>
										<option value='1'>Hapus</option>										
									</select>									
								</div>
								<div class='input-field col s12 m4'>
									<button class='waves-effect waves-light btn deep-orange darken-1 left' onclick=javascript:go()>GO</button>
								</div>								
							</div>
						</div>

						<div class='row formbody'>";
						$i = 0;
						foreach ($nota->result() as $row) {
							$i++;
							echo"
							
							<!-- nota -->
							<div class=' s12 m12' id='nota-".$row->id."'>
      							<div class='notacard card-panel grey lighten-5 z-depth-1'>
						          	<div class='row '>		
						          		<div class='checkitem col s12 m1'>
							            	<input type='checkbox' class='filled-in cek_nota' id='cek-nota-".$i."'  />
      										<label for='cek-nota-".$i."'></label>
      										<input type='hidden' id='cek-$i' value='".$row->id."' />
							            </div>
							            <div class='col s12 m2'>";
										$image = $this->model_nota->get_image($row->member_id);

							            if ($image->num_rows() > 0) {
							            	echo "<img src='".base_url()."assets/pic/user/resize/".$image->row()->image."' alt='' class='circle responsive-img col'> ";
							            }else{
							            	echo "<img src='html/images/comp/male.png' alt='' class='circle responsive-img col'> ";
							            }
							              echo"
							            </div>
							            <div class='col s11 m4'>
							              	<h5 class='blue-text'><a href='#' >".$row->invoice_no."</a></h5>
							              	<h6 class='blue-text'>".$row->member_name."</h6>
							              	<span class='labelbudge pink lighten-2'>PRE ORDER</span>
							              	<h5>Rp. ".number_format($row->price_total, 2 , ',' , '.')."</h5>
							            </div>
							            
							            <div class='col s12 m5'>
							            	<div class='col s12 m12'>";
							            		$old_date = $row->create_date;
												$old_date_timestamp = strtotime($old_date);
												$date = date('d F Y, H.i', $old_date_timestamp);
							            		echo"
								              	<p class='blue-grey-text lighten-3 right'>$date (30 Menit yang lalu)</p>
								              	<br>
								            </div>
								            <div class='col s12 m12'>";
								            if ($row->status == 0 ) {
								            	echo "<h5 class='red-text right' id='lunas-".$row->id."'>Belum Lunas</h5>";
								            }elseif ($row->status == 1) {								            	
								            	echo "<h5 class='green-text right' id='lunas-".$row->id."'>Lunas</h5>";
								            }elseif ($row->status == 2) {
								            	echo "<h5 class='grey-text right' id='lunas-".$row->id."'>Batal</h5>";
								            }
												
												echo"
											</div>
											<div class='col s12 m7' id='lokasi-btn-".$row->id."'>";
											if ($row->status != 2) {
											echo"						            		
												<button id='btn-bayar-".$row->id."' data-target='bayar-".$row->id."' class='btn modal-trigger waves-effect orange darken-1 white-text waves-light right' type='button' name='action'>Bayar</button>
												<button id='btn-batal-".$row->id."' data-target='batal_nota_".$row->id."' class='btn modal-trigger waves-effect red white-text waves-light right' type='button' name='action' >Batal</button>
								            </div>
								            <div id='batal_nota_".$row->id."' class='modal confirmation'>
												<div class='modal-header red'>
													<i class='mdi-navigation-close left'></i> Hapus produk
												</div>
												<form class='modal-content'>
													<p>Apakah Anda yakin ingin membatalkan pesanan?</p>
												</form>
												<div class='modal-footer'>
													<a class=' modal-action modal-close waves-effect waves-light btn-flat'>TIDAK</a>
													<button type='button' onclick=javascript:batal_nota(".$row->id.") class='btn-flat modal-action modal-close waves-effect '>YA</button>
												</div>
											</div>
								            <div id='bayar-".$row->id."' class='modal  modal-fixed-footer'>
												
												<div class='modal-header red'>
													<i class='mdi-action-label-outline left'></i> Pilih metode transaksi
												</div>
												<form class='modal-content' id='form-komfirmasi-".$row->id."'>
													<p>
														<label for='metode'>Pilih metode transaksi</label>
														<select id='metode-".$row->id."' class='select-standar' onchange=javascript:change_metode(".$row->id.")>
															";
															if ($toko->pm_store_payment == 1) {
																echo "<option value='1'>Bayar ditempat</option>";
																$show_rek = 'none';
															}
															if ($toko->pm_transfer == 1) {
																echo "<option value='2'>Transfer via bank</option>";
																$show_rek = 'block';
															}
														echo"
														</select>
														
													</p>
													<p class='modal-content'><br>
														<p>No. Transaksi : <span class='blue-text'>".$row->invoice_no."</span></p>
														<p>Tanggal Konfirmasi : <span class='blue-text'>$date</span></p>
														<p>Jumlah yang di bayar : <span class='blue-text'>Rp. ".number_format($row->price_total, 2 , ',' , '.')."</span></p><br>
														<p id='rekening-".$row->id."' style='display:$show_rek;'>

															<label for='metode'>Pilih Rekening Tujuan</label>
															<select id='rek-".$row->id."' class='select-standar'>
																<option value='' disabled selected>Pilih Rekening Tujuan</option>";
																foreach ($rekening->result() as $row_rk) {
																	echo "<option value='".$row_rk->id."'>".$row_rk->name."</option>";
																}
																echo"
															</select>
															
														</p>
													</p>
												</form>
												<div class='modal-footer'>
													<a class='modal-action modal-close waves-effect waves-red btn-flat' onclick=javascript:konfirmasi(".$row->id.")>Konfirmasi</a>
													<a class='modal-action modal-close waves-effect waves-red btn-flat'>Batal</a>		
												</div>";
											}else{
												echo "<br>";
											}
											echo"
											</div>

											<p class='tool col s12 m5'>
												<a href='#delete_nota_".$row->id."' class='modal-trigger red-text right '><i class='mdi-action-delete col s1 small'></i></a>
												<a class=' red-text right '><i class='mdi-content-mail col s1 small'></i></a>
												<a class=' red-text right '><i class='mdi-action-print col s1 small'></i></a>
												<div id='delete_nota_".$row->id."' class='modal confirmation'>
													<div class='modal-header red'>
														<i class='mdi-navigation-close left'></i> Hapus produk
													</div>
													<form class='modal-content'>
														<p>Apakah anda yakin ingin menghapus nota dari <b>'".$row->member_name."'</b> ?</p>
													</form>
													<div class='modal-footer'>
														<a href='#!' class=' modal-action modal-close waves-effect waves-light btn-flat'>TIDAK</a>
														<button type='button' onclick=javascript:delete_nota(".$row->id.") class='btn-flat modal-action modal-close waves-effect '>YA</button>
													</div>
												</div>
											</p>											
							            </div>
						          	</div>
						          	<div class='row '>
							            
							            <ul class='collapsible ' data-collapsible='accordion'>";
							            if ($row->member_confirm == 1) {
							            echo"
								            <li class=''>
								                <div class='collapsible-header truncate'><p class='red-text'><i class='mdi-content-flag'></i> Pembeli telah melakukan konfirmasi. <span class='blue-text'>Klik disini</span> untuk detail</p></div>
								                <div class='collapsible-body' style='display: none;'>
								                	<div class='col s12 m6'>									       		
								                		<p><b>Bank Asal :</b><br>
								                			Bank Plecit Indonesia<br>
								                			303058123123<br>
								                			a.n Dinar Wahyu Wibowo</p>
								                	</div>
								                	<div class='col s12 m6'>
								                		<p><b>Bank Tujuan :</b><br>
								                			Bank Roma Indonesia<br>
								                			303058123123<br>
								                			a.n Dinar Wahyu Wibowo</p>
								                	</div>
								                </div>
								            </li>";
								        }
								            echo"
								            <li class=''>
								                <div class='collapsible-header'><i class='mdi-action-receipt'></i>Notes
								                <a class='right col s2 m1 center' onclick=javascript:edit_notes(".$row->id.") >Edit</a>
								                </div>								                
								                <div class='collapsible-body' style='display: none;'>
								                <p>
								                	<textarea disabled class='materialize-textarea notes-".$row->id."' name='notes-".$row->id."'>".$row->notes."</textarea>
								                	<a class='tombol-notes-".$row->id." right col s2 m1 center' onclick=javascript:simpan_notes(".$row->id.") style='display: none;'>Simpan</a>
										            <a class='tombol-notes-".$row->id." right col s2 m1 center red-text' onclick=javascript:batal_notes(".$row->id.") style='display: none;'>Batal</a>
								                </p></div>
								            </li>
								            <li class=''>
								                <div class='collapsible-header'><i class='mdi-action-description'></i>Shipment Detail
								                	<a class='right col s2 m1 center modal-trigger' href='#pengiriman'>Edit</a>
								                </div>
								                <div class='collapsible-body' style='display: none;'>
								                	<p>
									                	<b>Pengiriman : </b> JNE<br>
									                	<b>Resi : </b> 12345679987654321
									                </p>
								                </div>
								                <div id='pengiriman' class='modal modal-fixed-footer'>
													<div class='modal-content'>
														<form class='col s12 m6'>
															<div class='input-field col s12 m6'>
																<label>Jenis Pengiriman</label>
																<select class='chosen-select'>
																	<option value='' disabled selected>Pilih Jenis Pengiriman</option>
																	<option value='1'>Option 1</option>
																	<option value='2'>Option 2</option>
																	<option value='3'>Option 3</option>
																</select>
															</div>
															<div class='input-field col s12 m8'>
																<input id='nama' type='text' class='validate'>
																<label for='nama'>Nomor Resi</label>
															</div>
															<div class='input-field col s12 m8'>
																<input id='tokoid' type='text' class='validate'>
																<label for='tokoid'>Nama Penerima</label>
															</div>
															<div class='input-field col s12 m8'>
																<input id='tokoid' type='text' class='validate'>
																<label for='tokoid'>Kode Pos</label>
															</div>
															<div class='input-field col s12 m6'>
																<label>Pilih Provinsi</label>
																<select class='chosen-select'>
																	<option value='' disabled selected>Pilih Provinsi</option>
																	<option value='1'>Option 1</option>
																	<option value='2'>Option 2</option>
																	<option value='3'>Option 3</option>
																</select>
															</div>
															<div class='input-field col s12 m6'>
																<label>Pilih Kota</label>
																<select class='chosen-select'>
																	<option value='' disabled selected>Pilih Kota</option>
																	<option value='1'>Option 1</option>
																	<option value='2'>Option 2</option>
																	<option value='3'>Option 3</option>
																</select>
															</div>
															<div class='input-field col s12 m6'>
																<label>Pilih Kecamatan</label>
																<select class='chosen-select'>
																	<option value='' disabled selected>Pilih Kecamatan</option>
																	<option value='1'>Option 1</option>
																	<option value='2'>Option 2</option>
																	<option value='3'>Option 3</option>
																</select>
															</div>
															<div class='input-field col s12 m8'>
																<textarea id='alamat' class='materialize-textarea' ></textarea>
																<label for='alamat'>Alamat Penerima</label>
															</div>
															<br><br><br><br>
														</form>
													</div>
													<div class='modal-footer'>
														<a href='#!' class=' modal-action modal-close waves-effect waves-red btn-flat'>Konfirmasi</a>
														<a href='#!' class=' modal-action modal-close waves-effect waves-red btn-flat'>Batal</a>		
													</div>
												</div>
								            </li>
							            </ul>

						          	</div>
						        </div>
							</div>";
						}
						echo"
						<input type='hidden' id='total-nota' value='$i' />
						</div>
					</div>
				</div>
				<script type='text/javascript' src='".base_url("")."assets/jController/enduser/CtrlNota.js'></script>
";
?>