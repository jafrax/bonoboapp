<?php
echo "
				<div class='col s12 m12 l12'>
					<div class='formain'>
						<div class='formhead'>
					        <a href='pesanan_pre_order.html' class='btn-flat waves-red'>
							    <i class='mdi-navigation-arrow-back left'></i> Kembali
							</a>
						</div>

						<div class='row formbody'>
							<div class='col s12 m6'>
								<h4>Nama Produk</h4>
							</div>
							<div class='col s12 m6'>
								<div class='input-field col s5 right'>
									<select class='select-standar'>										
										<option value='1'>Paling Baru</option>
										<option value='2'>Paling Lama</option>										
									</select>									
								</div>
								<div class='input-field col s5 right'>
									<select class='select-standar'>										
										<option value='1'>Belum Selesai</option>
										<option value='2'>Selesai</option>
										<option value='3'>Semua</option>
										<option value='3'>Semua</option>
									</select>									
								</div>
								<!--<h4><i class='mdi-action-star-rate grey-text col right'></i></h4>-->
							</div>
						</div>

						<div class='row formbody'>
							<div class='linehead'></div>

							<!-- nota -->
							<div class='col s12 m6 right'>
								<div class='input-field col s8 m8 nolpad '>
									<i class='mdi-action-search prefix'></i>
							        <input id='icon_prefix' type='text' class='validate'>
							        <label for='icon_prefix'>Cari</label>
								</div>
								<div class='input-field col s4 m4 nolpad '>
									<select class='select-standar'>										
										<option value='1'>Nama Pembeli</option>
										<option value='2'>No Nota</option>
										<option value='2'>Jumlah Tagihan</option>
									</select>									
								</div>
							</div>

							<div class='col s12 m6'>								
      							<div class='input-field col'>
									<input type='checkbox' class='filled-in' onclick=javascript:cek_all_nota() id='pilih-semua'  />
      								<label for='pilih-semua'></label>									
								</div>
								
								<div class='input-field col'>
									<button class='btn-flat waves-effect red white-text waves-light left'>Selesai</button>
								</div>								
							</div>

						</div>

						<div class='row formbody'>
							<!-- nota -->";
						if ($nota->num_rows() > 0) {
							$i=0;
							foreach ($nota->result() as $row) {
								$i++;
								echo "
								<div class='col s12 m12'>								
	      							<div class='notacard card-panel grey lighten-5 z-depth-1'>
							          	<div class='row '>
							          		<div class='col s12 m1'>
												<input type='checkbox' class='filled-in cek_nota' id='cek-nota-".$i."' />
			      								<label for='cek-nota-".$i."'></label>									
											</div>
								            <div class='col s6 m2'>";
												$image = $this->model_preorder->get_image($row->member_id);

									            if ($image->row()->image != '') {
									            	echo "<img src='".base_url()."assets/pic/user/resize/".$image->row()->image."' alt='' class='circle responsive-img col'> ";
									            }else{
									            	echo "<img src='".base_url()."html/images/comp/male.png' alt='' class='circle responsive-img col'> ";
									            }
									              echo"								              	
								            </div>
								            <div class='col s12 m4'>
								              	<h5 class='blue-text'>".$row->invoice_no."</h5>
								              	<h6 class='blue-text'>".$row->member_name."</h6>";
								              	if ($row->status == 0 ) {
									            	echo "<span class='labelbudge pink lighten-2'>BELUM LUNAS</span>";
									            }elseif ($row->status == 1) {
									            	echo "<span class='labelbudge green lighten-2'>LUNAS</span>";
									            }elseif ($row->status == 2) {
									            	echo "<span class='labelbudge grey lighten-2'>BATAL</span>";
									            }
								              	
								              	echo "
								              	<h5>Rp. ".number_format($row->price_total, 2 , ',' , '.')."</h5>
								            </div>								           
								            <div class='col s12 m5'>";
							            		$old_date = $row->create_date;
												$old_date_timestamp = strtotime($old_date);
												$date = date('d F Y, H.i', $old_date_timestamp);
							            		echo"
								              	<p class='col blue-grey-text lighten-3 right'>$date (30 Menit yang lalu)</p><br>";
								              	if ($row->status_pre_order == 0) {
								              		echo "
													<h5 class='col red-text right'>Belum Selesai</h5><br><br><br>
													<button class='btn-flat waves-effect red white-text waves-light right' type='button' name='action'>Selesai</button>
													";
												}else{
													echo "
													<h5 class='col green-text right'>Selesai</h5>													
													";
												}
												echo "
								            </div>
							          	</div>
							        </div>
								</div>
								";
							}
							echo "<input type='hidden' value='$i' id='total-nota' />";
						}else{
							echo "
								<div class='col s12 m12'>								
	      							<div class='notacard card-panel grey lighten-5 z-depth-1'>
							          	<div class='row '>
							          		<p> Data pemesanan tidak ada </p>
							          	</div>
							        </div>
								</div>
								";
						}
							echo "
						</div>
					</div>
				</div>
				<script type='text/javascript' src='".base_url("")."assets/jController/enduser/CtrlPreorder.js'></script>
				";
				?>