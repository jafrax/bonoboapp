<?php
echo "
				<div class='col s12 m12 l12'>
					<div class='formain'>
						<div class='row formbody'>
							<div class='col s12 m6'>
								<div class='input-field col s12 m8 '>
									<button class='btn-flat waves-effect red darken-1 white-text waves-light' type='button' name='action'>Batal</button>
									<button class='btn-flat waves-effect orange darken-1 white-text waves-light' type='button' name='action'>Bayar</button>
									<h6 class='hide-on-med-and-up'><br></h6>		
								</div>
							</div>
							<div class='col s12 m6'>
								<div class='col s4 m1 center-mobile right'>
									<a class='red-text waves-blue ' href='#'><i class='mdi-action-delete small'></i></a>
								</div>
								<div class='col s4 m1 center-mobile right'>
									<a class='red-text waves-blue ' href='#'><i class='mdi-content-mail small'></i></a>
								</div>
								<div class='col s4 m1 center-mobile right'>
									<a class='red-text waves-blue ' href='#'><i class='mdi-action-print small'></i></a>
								</div>
							</div>
						</div>

						<div class='row formbody'>
							<div class='linehead'></div>
							<div class='col s12 m6 left'>
								<h4>No. Transaksi : ".$nota->invoice_no."</h4>";
			            		$old_date = $nota->create_date;
								$old_date_timestamp = strtotime($old_date);
								$date = date('d F Y', $old_date_timestamp);
			            		echo"
								<h6>Tanggal : $date (1 Hari yang lalu)</h6>
								<h5><br></h5>
							</div>
							<div class='col s12 m6 right'>
								<h4 class='right-align'><span class='blue-text'>".$nota->member_name."</span></h4>
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
									echo "<div class='nota-product col s12 m6'>
											<img src='".base_url()."html/images/comp/product.png' class='responsive-img col s4 m4 left'>
											<div class='col s8 m8'>
												<p class='blue-text'>".$row_p->product_name."</p>
												<p >Rp. ".number_format($row_p->price, 2 , ',' , '.')."</p>
												<p >Jumlah : ".$row_p->quantity."</p>
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
									if ($toko->invoice_confirm == 1) {
										echo "<p>Kode unik :</p>";
									}
									echo"									
																		
								</div>
								<div class='col s6 m6 right-align'>
									<p>Rp ".number_format($nota->price_total, 2 , ',' , '.')."</p>									
									<p>Rp ".number_format($nota->price_shipment, 2 , ',' , '.')."</p>";
									if ($toko->invoice_confirm == 1) {
										echo "<p>".$nota->invoice_seq_payment."</p>";
									}
									echo"
								</div>
								<div class='line'></div>
								<div class='col s6 m6 left-align'>
									<b>Total nota :</b>																	
								</div>
								<div class='col s6 m6 right-align'>
									<b>Rp ".number_format($nota->price_total_transaction, 2 , ',' , '.')."</b>								
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
									<p>".$nota->shipment_no."</p>									
									<p>".$nota->recipient_name."</p>									
									<p>".$nota->recipient_phone."</p>									
									<p>".$nota->location_to_address."</p>									
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
									<textarea id='note' class='materialize-textarea' >".$nota->notes."</textarea>
									<label for='note'>Note</label>							
								</div>
								<div class='col s12 m12'>
									<a class='btn-flat right'>Simpan</a>
									<a class='btn-flat right'>Batal</a>	
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

						<div class='row formbody'>
			
						</div>
					</div>
				</div>

";
?>