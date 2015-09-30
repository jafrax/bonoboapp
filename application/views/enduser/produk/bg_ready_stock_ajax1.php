<?php
$uri4 = $this->uri->segment(4);
$uri3 = $this->uri->segment(3);
$uri2 = $this->uri->segment(2);
if ($produk->num_rows() == 0) {
	if (isset($_SESSION['keyword'])) {
		echo "Produk \"".$_SESSION['keyword']."\" tidak ditemukan";
	}else{
		echo "Produk ready stock kosong";
	}
}
							$i=0;
							if ($uri4 != '') {
								$i= $uri4;
							}							
							foreach ($produk->result() as $row) {
								$i++;
								$image = $this->model_produk->get_one_image($row->id)->row();
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
										<p class='titleproduct'><a href='".base_url()."produk/edit/".base64_encode($row->id)."'><b >".$row->name."</b></a></p>
										</p>";
										if ($row->stock_type_detail == 0) {
											$stok =  $this->model_produk->get_varian_produk($row->id);
											foreach ($stok->result() as $row_stok) {
												echo"
													
													<p class='input-field col s12 m12 l7 nolpad'>";
														if($row->sku_no != 'null'){
														echo "<label for='stok'>".$row->sku_no."</label>";
													}
													if ($row->unit !='') {
														echo "<i class='prefix prefix-gan'>".$row->unit."</i>";
													}
													if ($row_stok->name != 'null') {
														echo "<label for='stok' class='active'>".$row_stok->name."</label>";
													}

													echo"<input onkeyup=javascript:change_stock(".$row_stok->id.") type='text' maxlength='9' name='stok-".$row_stok->id."' value='".$row_stok->stock_qty."' placeholder='Stok' class='validate numbersOnly stok-".$row_stok->id."'>";									
													
													
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
															<div class='input-col s12 m12'>
																
																<label for='varian'><b class='label-stock'>".$row_stok->name."</b> Stok : <span class='text-green'>selalu tersedia</span></label>
															</div>";
														}else if($row_stok->name == 'null'){
															echo "
															<div class='input-col s12 m12'>																
																<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label>
															</div>";
														}

													echo"
													</p>";
												}
										}
										echo"

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