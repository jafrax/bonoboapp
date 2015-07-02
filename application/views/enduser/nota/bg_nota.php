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
										<select  class='select-standar'>										
											<option value='1'>Paling Baru</option>
											<option value='2'>Paling Lama</option>										
										</select>									
									</div>
									<div class='input-field col s12 m3 left'>
										<select class='select-standar'>										
											<option value='1'>Belum Lunas</option>
											<option value='2'>Lunas</option>
											<option value='3'>Semua</option>
										</select>									
									</div>
									<div class='input-field col s12 m3 left'>
										<select class='select-standar'>										
											<option value='1'>Pre Order</option>
											<option value='2'>Ready Stok</option>
										</select>									
									</div>
									
								</div>
								<div class='input-field col s12 m12 l4 nolpad'>
									<i class='mdi-action-search prefix'></i>
									<input id='nama' type='text' class='validate'>
									<label for='nama'>Cari</label>
								</div>
							</div>
							<div class='col s12 listline'>								
      							<p class='checkallboxnota left'>
									<input type='checkbox' class='filled-in' id='pilih-semua'  />
      								<label for='pilih-semua'></label>									
								</p>
								<div class='input-field col s6 m3'>
									<select class='select-standar'>										
										<option value=''>Pilih Tindakan</option>
										<option value='1'>Batal</option>
										<option value='1'>Hapus</option>
										<option value='1'>Selesai</option>
									</select>									
								</div>
								<div class='input-field col s12 m4'>
									<button class='waves-effect waves-light btn deep-orange darken-1 left'>GO</button>
								</div>								
							</div>
						</div>

						<div class='row formbody'>
							<!-- nota -->
							<div class=' s12 m12'>								
      							<div class='notacard card-panel grey lighten-5 z-depth-1'>
						          	<div class='row '>		
						          		<div class='checkitem col s12 m1'>
							            	<input type='checkbox' class='filled-in' id='product'  />
      										<label for='product'></label>
      										<!-- <i class='mdi-action-star-rate orange-text small left vote'></i> -->
							            </div>
							            <div class='col s12 m2'>
							              	<img src='images/comp/male.png' alt='' class='circle responsive-img col'> 
							            </div>
							            <div class='col s11 m4'>
							              	<h5 class='blue-text'>Nama Pembeli</h5>
							              	<h6 class='blue-text'>#123-123 </h6>
							              	<span class='labelbudge pink lighten-2'>PRE ORDER</span>
							              	<h5>Rp. 123.123,00</h5>							              	
							            </div>
							            
							            <div class='col s12 m5'>
							            	<div class='col s12 m12'>
								              	<p class='blue-grey-text lighten-3 right'>28 Mei 2015, 12.30 (30 Menit yang lalu)</p>
								              	<br>
								            </div>
								            <div class='col s12 m12'>
												<h5 class='red-text right'>Belum Lunas</h5>
											</div>
											<div class='col s12 m7'>						            		
												<button data-target='bayar' class='btn modal-trigger waves-effect orange darken-1 white-text waves-light right' type='button' name='action'>Bayar</button>
												<button class='btn waves-effect red white-text waves-light right' type='button' name='action'>Batal</button>
								            </div>
											<p class='tool col s12 m5'>
												<a class=' red-text right ' href='#'><i class='mdi-action-delete col s1 small'></i></a>
												<a class=' red-text right ' href='#'><i class='mdi-content-mail col s1 small'></i></a>
												<a class=' red-text right ' href='#'><i class='mdi-action-print col s1 small'></i></a>
											</p>											
							            </div>
						          	</div>
						          	<div class='row '>
							            
							            <ul class='collapsible ' data-collapsible='accordion'>
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
								            </li>
								            <li class=''>
								                <div class='collapsible-header'><i class='mdi-action-receipt'></i>Notes
								                <a class='right col s2 m1 center' href=''>Edit</a>
								                </div>
								                <div class='collapsible-body' style='display: none;'><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p></div>
								            </li>
								            <li class=''>
								                <div class='collapsible-header'><i class='mdi-action-description'></i>Shipment Detail
								                	<a class='right col s2 m1 center' href=''>Edit</a>
								                </div>
								                <div class='collapsible-body' style='display: none;'>
								                	<p>
									                	<b>Pengiriman : </b> JNE<br>
									                	<b>Resi : </b> 12345679987654321
									                </p>
								                </div>
								            </li>
							            </ul>

						          	</div>
						        </div>
							</div>	

							<!-- nota -->
							<div class=' s12 m12'>								
      							<div class='notacard card-panel grey lighten-5 z-depth-1'>
						          	<div class='row '>						          		
							            				          	
							            <div class='checkitem col s12 m1'>
							            	<input type='checkbox' class='filled-in' id='product'  />
      										<label for='product'></label>
      										<!-- <i class='mdi-action-star-rate orange-text small left vote'></i> -->
							            </div>

							            <div class='col s12 m2'>
							              	<img src='images/comp/male.png' alt='' class='circle responsive-img col'> 
							            </div>
							            <div class='col s11 m4'>
							              	<h5 class='blue-text'>Nama Pembeli</h5>
							              	<h6 class='blue-text'>#123-123</h6>
							              	<span class='labelbudge green lighten-2'>READY STOK</span>
							              	<h5>Rp. 123.123,00</h5>							              	
							            </div>
							            <div class='col s12 m5'>
							            	<div class='col s12 m12'>
								              	<p class='blue-grey-text lighten-3 right'>28 Mei 2015, 12.30 (30 Menit yang lalu)</p><br>
								            </div>
								            <div class='col s12 m12'>
												<h5 class='green-text right'>Lunas</h5>
											</div>
											<div class='col s12 m7'>						            		
												<button class='btn waves-effect red white-text waves-light right' type='button' name='action'>Batal</button>
								            </div>
											<p class='tool col s12 m5'>
												<a class=' red-text right ' href='#'><i class='mdi-action-delete col s1 small'></i></a>
												<a class=' red-text right ' href='#'><i class='mdi-content-mail col s1 small'></i></a>
												<a class=' red-text right ' href='#'><i class='mdi-action-print col s1 small'></i></a>
											</p>											
							            </div>
						          	</div>
						          	<div class='row '>						          		
							           
							            <ul class='collapsible ' data-collapsible='accordion'>
								            <li class=''>
								                <div class='collapsible-header'><p class='red-text'><i class='mdi-content-flag'></i> Pembeli telah melakukan konfirmasi. <span class='blue-text'>Klik disini</span> untuk detail</p></div>
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
								            </li>
								            <li class=''>
								                <div class='collapsible-header truncate'><i class='mdi-action-receipt'></i>Notes
								                	<a class='right col s2 m1 center' href=''>Simpan</a>
								                	<a class='right col s2 m1 center red-text' href=''>Batal</a>
								                </div>
								                <div class='collapsible-body' style='display: none;'>

								                </div>
								            </li>
								            <li class=''>
								                <div class='collapsible-header'><i class='mdi-action-description'></i>Shipment Detail
								                	<a class='right col s2 m1 center' href=''>Edit</a>
								                </div>
								                <div class='collapsible-body' style='display: none;'>
								                	<p>
									                	<b>Pengiriman : </b> JNE<br>
									                	<b>Resi : </b> 12345679987654321
									                </p>
									                <p>
									                	<button data-target='pengiriman' class='btn-flat modal-trigger waves-effect blue-text waves-blue' type='button' name='action'>Edit Detail</button>
									                </p>											                
								                </div>
								            </li>
							            </ul>
						          	</div>
						        </div>
							</div>						
						</div>
					</div>
				</div>
";
?>