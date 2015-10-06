<?php
						$i = 5;
						foreach ($nota->result() as $row) {
							$i++;
							echo"
									
							<!-- buat notif dari opsi GO -->
						<div id='produk_go' class='modal confirmation'>
							<div class='modal-header red'>
								<i class='mdi-navigation-close left'></i> <span id='head-go'>Hapus</span> Nota
							</div>
							<form class='modal-content'>
								<p><span id='tipe-go'></span> nota Anda ?</p>
							</form>
							<div class='modal-footer'>
								<button type='button' onclick=javascript:go() class='btn-flat modal-action modal-close waves-effect '>YA</button>
								<a href='' class=' modal-action modal-close waves-effect waves-light btn-flat'>TIDAK</a>
							</div>
						</div>		
								
		
												<!-- hapus -->
												<div id='delete_nota' class='modal confirmation'>
													<div class='modal-header red'>
														<i class='mdi-navigation-close left'></i> <span id='head-del'> produk
													</div>
													<form class='modal-content'><p>Apakah anda yakin ingin menghapus nota ?</p>
													</form>
													<div class='modal-footer'>														
														<button type='button' onclick=javascript:delete_nota() class='btn-flat modal-action modal-close waves-effect '>YA</button>
														<a href='javascript:void(0)' class=' modal-action modal-close waves-effect waves-light btn-flat'>TIDAK</a>
													</div>
												</div>		
		
		
		
								       <div id='batalnota' class='modal confirmation'>
												<div class='modal-header red'>
													<i class='mdi-navigation-close left' ></i> Batal produk
												</div>
												<form class='modal-content'>
													<p>Apakah Anda yakin ingin membatalkan pesanan?</p>
													<!-- <p id=idbatal></p> -->
													
													<input type=checkbox class=filled-in id=batal-cek- /><label  for=batal-cek- />Kembalikan stok?</label>
												</form>
												<div class='modal-footer'>
													<!-- <p id=proses > -->
													<p> <button type=button onclick=javascript:batal_nota() class='btn-flat modal-action modal-close waves-effect' >YA</button></p>
													<a class=' modal-action modal-close waves-effect waves-light btn-flat'>TIDAK</a>
												</div>
											</div>
										
							<!-- nota -->
									
							<div class=' s12 m12' id='nota-".$row->id."'>
      							<div class='notacard card-panel grey lighten-5 z-depth-1'>
						          	<div class='row '>		
						          		<div class='checkitem col s0 m0'>
							            	<input type='checkbox' class='filled-in cek_nota' id='cek-nota-".$i."'  />
      										<label for='cek-nota-".$i."'> </label>
      										<input type='hidden' id='cek-$i' value='".$row->id."' />
							            </div>
							            <div class='col s6 m7'>	
      									<div class='col s4 m4'>
      									<h6 class='blue-text'><span class='grey-text '>INVOICE NO</span> <a href='".base_url()."nota/detail/".$row->invoice_no."' >".$row->invoice_no."</a></h6> 
      									<h5>Rp. ".number_format($row->price_total, 0 , ',' , '.')."</h5> 
							            <h6 class='blue-text'>".$row->member_name."</h6> 	
      									</div>
      									";
									

									$old_date 	= $row->create_date;
									$old_date_timestamp = strtotime($old_date);
									$date 		= date('d M Y');
									$ago 		= $this->template->xTimeAgoDesc($old_date,date('Y-m-d H:i:s'));
									$tanggal = date('d M Y', strtotime('-0 days', strtotime( $old_date )));
									
										if ($row->stock_type == 1) {
											echo "<div class='col s6 m3'><span class='labelbudge green lighten-2 center'>READY STOK </span> </div>";
										}else{
											echo "<div class='col s6 m3'><span class='labelbudge pink lighten-2 center'>PRE ORDER </span> </div>";
										}
							
								            if ($row->status == 0 ) {
								            	echo "<div class='col s6 m4' id='lokasi-btn-35' align='right'><h5 class='red-text right' id='lunas-".$row->id."'>Belum Lunas</h5></div>";
								            }elseif ($row->status == 1) {								            	
								            	echo "<div class='col s6 m4' id='lokasi-btn-35' align='right'><h5 class='green-text right' id='lunas-".$row->id."'>Lunas</h5></div>";
								            }elseif ($row->status == 2) {
								            	echo "<div class='col s6 m4' id='lokasi-btn-35' align='right'><h5 class='grey-text right' id='lunas-".$row->id."'>Batal</h5></div>";
								            }	echo"
											
								     	  			
							               
							             </div >
							             
							            <div class='col s4 m4 right' > 
							              	<div class='col s8 m9 right '>  $tanggal ($ago) <br> </div> ";
							              
							              	echo "
							              			<div class='col s4 m6 ' id='lokasi-btn-".$row->id."'>";
											if ($row->status != 2) {
												if ($row->status != 1) {
													echo" <br>
												<button href='javascript:void(0);' onclick=bayarnota(".$row->id.",'".$row->invoice_no."','".$row->price_total."');   class='btn modal-trigger waves-effect orange darken-1 white-text waves-light right' type='button' name='action'>Bayar</button>";
												}
												//echo "<button href='javascript:void(0);' onclick=batalnota(".$row->id."); class='btn modal-trigger waves-effect red white-text waves-light right' type='button' name='action' >Batal</button>";
											echo"												
								            </div>
							              	
													
								            <div id='bayarnota' class='modal  modal-fixed-footer'>
												<div class='modal-header red'>
													<i class='mdi-action-label-outline left'></i> Pilih metode transaksi
												</div>
												
								            		<form class='modal-content' id='form-komfirmasi-".$row->id."'>
													
														<label for='metode'>Pilih metode transaksi</label>
														"; 
														
															echo
															";
															<select id='metode' class='select-standar' onchange=javascript:change_metode()>
															";
															if ($toko->pm_store_payment == 1) {
																echo "<option value='1'>Bayar ditempat</option>";
																$show_rek = 'none';
															}
															if ($toko->pm_transfer == 1) {
																echo "<option value='2' "; if ($row->member_confirm == 1) {echo 'selected';$show_rek = 'block';} echo ">Transfer via bank</option>";
																	
															}
																
															echo "
															</select>
						
														<p>No. Transaksi : <span id='nota' class='blue-text'></span></p>
														<p>Tanggal Konfirmasi : <span class='blue-text'>$date</span></p>
														<p>Jumlah yang di bayar : <span id='bayar' class='blue-text'>Rp. ".number_format($row->price_total, 2 , ',' , '.')."</span></p><br>
														<p id='rekening' style='display:$show_rek;'>
															<label for='metode'>Pilih Rekening Tujuan   </label>
															<select id='rek' class='select-standar'>
																<option value='' disabled >Pilih Rekening Tujuan</option>";
																if ($row->member_confirm == 1) {
																	$rekening_tujuan = $this->model_nota->get_rek_tujuan($row->id);
																	if ($rekening_tujuan->num_rows() > 0) {
																		$selected = $rekening_tujuan->row()->toko_bank_id;
																	}else{
																		$selected = '';
																	}
																}
																foreach ($rekening->result() as $row_rk) {
																	$select = '';
																	if ($row_rk->id == $selected) {$select = 'selected';}
																	echo "<option $select value='".$row_rk->id."'>".$row_rk->name." ( ".$row_rk->no." ) </option>";
																}
																echo"
															</select>
													</p>
												</form>
												<div class='modal-footer'>
													<a class='modal-action modal-close waves-effect waves-red btn-flat' onclick=javascript:konfirmasi()>Konfirmasi</a>
													<a class='modal-action modal-close waves-effect waves-red btn-flat'>Batal</a>		
												</div>";
											}else{
												echo "<br>";
											}
											echo"
											</div>
											<p class='tool col s6 m6 right'>
												<!-- hapus nota -->
													<br>
												<a class='modal-trigger red-text right' onclick=batalnota(".$row->id."); ><i class='mdi-navigation-close col s1  small'></i></a>
												<a class='modal-trigger red-text right' onclick=delitem(".$row->id."); ><i class='mdi-action-delete col s1 small'></i></a>
												<a href='".base_url()."nota/cetak/".$row->invoice_no."' onclick='window.open(\"".base_url()."nota/cetak/".$row->invoice_no."\", \"newwindow\", \"width=800, height=600\"); return false;' class=' red-text right '><i class='mdi-action-print col s1 small'></i></a>
											</p>											
							            </div>
						          	</div>
							
									
									
						          	<div class='row '>
							            <ul class='collapsible ' data-collapsible='accordion'>";
							            if ($row->member_confirm == 1) {
							            	$rekening_tujuan = $this->model_nota->get_rek_tujuan($row->id);
							            	if ($rekening_tujuan->num_rows() > 0) {
							            		$rekening1 = $rekening_tujuan->row();
								            	echo"
									            <li class=''>
									                <div class='collapsible-header truncate'><p class='red-text'><i class='mdi-content-flag'></i> Nota sudah dikonfirmasi. <span class='blue-text'>Klik disini</span> untuk detail</p></div>
									                <div class='collapsible-body' style='display: none;'>
									                	<div class='col s12 m6'>									       		
									                		<p><b>Bank Asal :</b><br>
									                			".$rekening1->from_bank."<br>
									                			".$rekening1->from_acc_no."<br>
									                			".$rekening1->from_acc_name."</p>
									                	</div>
									                	<div class='col s12 m6'>
									                		<p><b>Bank Tujuan :</b><br>
									                			".$rekening1->to_bank."<br>
									                			".$rekening1->to_acc_no."<br>
									                			".$rekening1->to_acc_name."</p>
									                	</div>
									                </div>
									            </li>";
							            	}else{
							            		echo"
									            <li class=''>
									                <div class='collapsible-header truncate'><p class='red-text'><i class='mdi-content-flag'></i> Pembeli telah melakukan konfirmasi. <span class='blue-text'>Klik disini</span> untuk detail</p></div>
									                <div class='collapsible-body' style='display: none;'>
									                	<div class='col s12 m6'>									       		
									                		<p><b>Bank Asal :</b><br>
									                	</div>
									                	<div class='col s12 m6'>
									                		<p><b>Bank Tujuan :</b><br>
									                	</div>
									                </div>
									            </li>";
							            	}
								        }
								            echo"
								            <li class=''>
								                <div class='collapsible-header'><i class='mdi-action-receipt'></i>Notes
								                
								                </div>								                
								                <div class='collapsible-body' style='display: none;'>
								                <p>
								                <a class='right col s2 m1 center' onclick=javascript:edit_notes(".$row->id.") >Edit</a>
								                	<textarea disabled class='materialize-textarea notes-".$row->id."' name='notes-".$row->id."'>".$row->notes."</textarea>
								                	<a class='tombol-notes-".$row->id." right col s2 m1 center' onclick=javascript:simpan_notes(".$row->id.") style='display: none;'>Simpan</a>
										            <a class='tombol-notes-".$row->id." right col s2 m1 center red-text' onclick=javascript:batal_notes(".$row->id.") style='display: none;'>Batal</a>
								                </p></div>
								            </li>
								            <li class=''>
								                <div class='collapsible-header'><i class='mdi-action-description'></i>Shipment Detail
								                	<a class='right col s2 m1 center modal-trigger' href='#pengiriman'>Edit</a>
								                </div>
								                <div class='collapsible-body' style='display: none;' id='isi-kurir'>
								           
							                		<dl class='dl-horizontal col s12 m10 l5' id='panggon-nota'>
								                		<dt><b>Pengiriman : </b></dt>
								                		<dd>".$row->shipment_service."</dd>
									                	<dt><b>Resi : </b></dt>
									                	<dd>".$row->shipment_no."</dd>
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
								                	</dl>
									              
								                </div>
								                <div id='pengiriman' class='modal modal-fixed-footer'>
													<div class='modal-content'>
														<form id='form-pengiriman'>
															<input type='hidden' value='".$row->id."' name='id_nota' />
															<div class='input-field col s12 m6'>
																<span>Jenis Pengiriman</span>
																<select class='chosen-select' name='kurir'>
																	<option value='' disabled selected>Pilih Jenis Pengiriman</option>
																	<option value='Ambil di toko'>Ambil di toko</option>";
																	$toko_kurir = $this->model_nota->get_toko_kurir($row->toko_id);
																	foreach ($toko_kurir->result() as $kurir_t) {
																		$select = '';
																		if ($kurir_t->name == $row->shipment_service) {$select = 'selected';}
																		echo "<option $select value='".$kurir_t->name."'>".$kurir_t->name."</option>";
																	}
																	$kustom_kurir = $this->model_nota->get_kustom_kurir($row->toko_id);
																	foreach ($kustom_kurir->result() as $kurir_k) {
																		$select = '';
																		if ($kurir_k->name == $row->shipment_service) {$select = 'selected';}
																		echo "<option $select value='".$kurir_k->name."'>".$kurir_k->name."</option>";
																	}	
																	echo"								
																</select>
															</div>
															<div class='input-field col s12 m8'>
																<input disabled id='biaya' name='biaya' type='text' class='validate' value='".$row->price_shipment."'>
																<label for='biaya'>Biaya Pengiriman</label>
															</div>
															<div class='input-field col s12 m8'>
																<input id='nomor-resi' name='nomor-resi' type='text' class='validate' value='".$row->shipment_no."'>
																<label for='nomor-resi'>Nomor Resi</label>
															</div>	
															<div class='input-field col s12 m8'>
																<input disabled id='namane' name='namane' type='text' class='validate' value='".$row->recipient_name."'>
																<label for='namane'>Nama Penerima</label>
															</div>															
															<div class='input-field col s12 m8'>
																<input disabled id='phone' name='phone' type='text' class='validate' value='".$row->recipient_phone."'>
																<label for='phone'>Nomor Penerima</label>
															</div>
															<div class='input-field col s12 m8'>
																<input disabled id='postal-code' name='postal-code' type='text' onkeyup=javascript:set_location() class='validate' value='".$row->location_to_postal."'>
																<label for='postal-code'>Kode Pos</label>
															</div>
															<div class='input-field col s12 m8'>
																<textarea disabled id='alamat' name='alamat' class='materialize-textarea' >".$row->recipient_address."</textarea>
																<label for='alamat'>Alamat Penerima</label>
															</div>
															<div class='input-field col s12 m6' id='panggon-province'>
																<span>Pilih Provinsi</span>
																<select disabled class='chosen-select' name='province' id='province' onchange=javascript:set_city()>
																	<option value='' disabled selected>Pilih Provinsi</option>";
																	$provinsi = $this->model_nota->get_province();
																	foreach ($provinsi->result() as $row_p) {
																		$select = '';
																		if ($row_p->province == $row->location_to_province) {$select = 'selected';}
																		echo "<option $select value='".$row_p->province."'>".$row_p->province."</option>";
																	}	
																	echo"
																</select>
															</div>
															<div class='input-field col s12 m6' id='panggon-city'>
																<span>Pilih Kota</span>
																<select disabled class='chosen-select' name='city' id='city' onchange=javascript:set_kecamatan()>
																	<option value='' disabled selected>Pilih Kota</option>";
																	if ($row->location_to_city != '') {
																		$kota = $this->model_nota->get_city($row->location_to_province);
																		foreach ($kota->result() as $row_k) {
																			$select = '';
																			if ($row_k->city == $row->location_to_city) {$select = 'selected';}
																			echo "<option $select value='".$row_k->city."'>".$row_k->city."</option>";
																		}	
																	}else{
																		$kota = $this->model_nota->get_city($row->location_to_province);
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
																	if ($row->location_to_kecamatan != '') {
																		$kecamatan = $this->model_nota->get_kecamatan($row->location_to_city);
																		foreach ($kecamatan->result() as $row_c) {
																			$select = '';
																			if ($row_c->kecamatan == $row->location_to_kecamatan) {$select = 'selected';}
																			echo "<option $select value='".$row_c->kecamatan."'>".$row_c->kecamatan."</option>";
																		}	
																	}else{
																		$kecamatan = $this->model_nota->get_kecamatan($row->location_to_city);
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
														<a onclick=javascript:confirm_courier(0) class='modal-action modal-close waves-effect waves-red btn-flat'>Konfirmasi</a>
														<a class='modal-action modal-close waves-effect waves-red btn-flat'>Batal</a>		
													</div>
												</div>
								            </li>
							            </ul>

						          	</div>
						        </div>
							</div>";
						}
						
?>