<?php
$uri4 = $this->uri->segment(4);
$uri3 = $this->uri->segment(3);
$uri2 = $this->uri->segment(2);
if ($produk->num_rows() == 0) {
	if (isset($_SESSION['keyword'])) {
		echo "Produk \"".$_SESSION['keyword']."\" tidak ditemukan";
	}else{
		echo "Produk pre order kosong";
	}
}
							$i=0;
							if ($uri4 != '') {
								$i= $uri4;
							}
							foreach ($produk->result() as $row) {
								$i++;
								$image = $this->model_produk->get_one_image($row->id)->row();
								
								$old_date 			= $row->end_date;
								$old_date_timestamp = strtotime($old_date);
								$date 				= date('Y/m/d', $old_date_timestamp);

								if (date('Y-m-d') > $row->end_date) {
									$kadal = "block";
								}else{
									$kadal = "none";
								}
								echo"
								<li class='col s12 m12 listanggodaf produk-".$row->id."'>
									<p class='col s1 m1 l1'>
										<input type='checkbox' class='filled-in cek_produk' onclick=javascript:ngeklik('cek-2-$i','cek-1-$i') name='cek_produk_".$row->id."' id='cek-1-$i' />
										<label for='cek-1-$i'></label>
										<input type='hidden' id='cek-$i' value='".$row->id."'>
									</p>
									<div class='col s12 m3 l2'>";
										if ($image) {
											echo "<img src='".base_url()."assets/pic/product/resize/".$image->file."' class='responsive-img userimg'>";											
										}else{
											echo "<img src='".base_url()."html/images/comp/product.png' class='responsive-img userimg'>";
										}

									echo"	
									</div>

									<div class='col s12 m8 l9'>
										<p class='titleproduct'><a href='".base_url()."produk/edit_pre_order/".base64_encode($row->id)."'><b >".$row->name."</b></a></p>
										</p>";
											//if ($row->stock_type_detail == 1) {
											$stok =  $this->model_produk->get_varian_produk($row->id);
												foreach ($stok->result() as $row_stok) {
													echo"
													<p class='col s12 m12 l12 '>	";													
														if ($row_stok->name != 'null') {
															echo "
															<div class=' col s12 m12'>
																<label for='varian'><b class='label-stock'>".$row_stok->name."</b></label>
															</div>";
														}else if($row_stok->name == 'null'){
															echo "
															<div class=' col s12 m12'>																
															<!--	<label for='varian'><span class='text-green'>selalu tersedia</span></label> -->
															</div>";
														}

													echo"
													</p>";
												}
										//}
										echo"


										<p class='input-field col s12 m12 l6 nolpad'>
											<input id='tanggal-".$row->id."' name='tanggal-".$row->id."' onchange=javascript:change_date(".$row->id.") type='text' data-value='".$date."'  placeholder='Tanggal Berakhir' class='validate datepicker '>
											<span class='label red right kadal-".$row->id."' style='display:$kadal'>Kadaluarsa</span>
										</p>



										<div class='col s12 m12 l12 '>";

										if ($row->active == 0) {
											echo "<button class='waves-effect waves-light btn-flat grey lighten-2 disabled draft-".$row->id."'>DRAFT</button>";
										}else{
											echo "<button class='waves-effect waves-light btn-flat grey lighten-2 disabled draft-".$row->id."' style='display:none;'>DRAFT</button>";
										}
											echo"
											<a href='#delete_produk_".$row->id."' class='modal-trigger btn-floating btn-xs waves-effect waves-light red right'><i class='mdi-navigation-close'></i></a>
											<div id='delete_produk_".$row->id."' class='modal confirmation'>
												<div class='modal-header red'>
													<i class='mdi-navigation-close left'></i> Hapus produk
												</div>
												<form class='modal-content'>
													<p>Apakah anda yakin ingin menghapus <b>'".$row->name."'</b> ?</p>
												</form>
												<div class='modal-footer'>													
													<button type='button' onclick=javascript:delete_produk(".$row->id.",\"$uri2\") class='btn-flat modal-action modal-close waves-effect '>YA</button>
													<a href='javascript:void(0)' class=' modal-action modal-close waves-effect waves-light btn-flat'>TIDAK</a>
												</div>
											</div>
										</div>
									</div>
								</li>";
							}



?>		