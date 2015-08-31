<?php
$uri4 = $this->uri->segment(4);
$uri3 = $this->uri->segment(3);
if ($produk->num_rows() == 0) {
	if (isset($_SESSION['keyword'])) {
		echo "Produk \"".$_SESSION['keyword']."\" tidak ditemukan";
	}else{
		echo "Produk ready stock kosong";
	}
}
							$a=0;
							if ($uri4 != '') {
								$a= $uri4;
							}
							foreach ($produk->result() as $row) {
								$a++;
								$image = $this->model_produk->get_one_image($row->id)->row();
								echo "
								<div class='card col s12 m4 l3 nolpad produk-".$row->id."' >
									<p class='checkiniabs'>
										<input type='checkbox' class='filled-in cek_produk' onclick=javascript:ngeklik('cek-1-$a','cek-2-$a') id='cek-2-$a'  />
										<label for='cek-2-$a'></label>
									</p>
									<div class='card-image waves-effect waves-block waves-light'>
									";
										if ($image) {
											echo "<img src='".base_url()."assets/pic/product/resize/".$image->file."' class='activator'>";											
										}else{
											echo "<img src='".base_url()."html/images/comp/product.png' class='activator'>";
										}
									echo"										
									</div>
									<div class='card-content'>
										<span class='card-title activator grey-text text-darken-4'>".$row->name." <i class='mdi-navigation-more-vert right'></i></span>
										<p><a href='".base_url()."produk/edit/".base64_encode($row->id)."'>Sunting Produk</a></p>
									</div>
									<div class='card-reveal nolpad'>
										<span class='card-title grey-text text-darken-4'><i class='mdi-navigation-close right'></i></span>
										<p>
											<div class='col s12'><b>".$row->name."</b></div>
											<div class='col s12'><b>SKU</b></div>
											<div class='col s12'>".$row->sku_no."</div>
											<div class='col s12'><b>Kategori</b></div>
											<div class='col s12'>".$row->kategori."</div>
											<div class='col s12'><b>Stok</b></div>
											<div class='col s12'>";
											if ($row->stock_type_detail == 0) {
												$stok =  $this->model_produk->get_varian_produk($row->id);
												foreach ($stok->result() as $row_stok) {
													echo"
													<p class='input-field col s12 m12 l12 nolpad'>
														<input onkeyup=javascript:change_stock2(".$row_stok->id.") type='text' maxlength='9' name='stok-".$row_stok->id."' value='".$row_stok->stock_qty."' placeholder='Stok' class='validate numbersOnly stok-".$row_stok->id." stok-2-".$row_stok->id."'>";
														if ($row_stok->name != 'null') {
															echo "<span for='stok'>".$row_stok->name."</span>";
														}
														
														if ($row_stok->stock_qty == 0) {
															echo"<span class='label red right habis-".$row_stok->id."'>Stok habis</span>";
														}else{
															echo"<span class='label red right habis-".$row_stok->id."' style='display:none'>Stok habis</span>";
														}
													echo"<i class='fa fa-check-circle green-text ok-".$row_stok->id."' style='display:none'> </i>
													</p>";
												}											
											}else{
												$stok =  $this->model_produk->get_varian_produk($row->id);
												foreach ($stok->result() as $row_stok) {
													echo"
													<p class='col s12 m12 l12 '>	";													
														if ($row_stok->name != 'null') {
															echo "
															<div class='input-field col s12 m12'>
																
																<span for='varian'><b class='label-stock'>".$row_stok->name."</b> Stok : <span class='text-green'>selalu tersedia</span></span>
															</div>";
														}else{
															echo "
															<div class='input-field col s12 m12'>																
																<span for='varian'>Stok : <span class='text-green'>selalu tersedia</span></span>
															</div>";
														}

													echo"
													</p>";
												}
											}

											if ($row->active == 0) {
											echo "<button class='waves-effect waves-light btn-flat grey lighten-2 disabled draft-".$row->id."'>DRAFT</button>";
											}else{
												echo "<button class='waves-effect waves-light btn-flat grey lighten-2 disabled draft-".$row->id."' style='display:none;'>DRAFT</button>";
											}
											echo"
										</div>
										</p>
									</div>
								</div>";
							}
?>		