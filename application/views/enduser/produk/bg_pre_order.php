<?php
$uri3 = $this->uri->segment(3);

echo"
			<div class='col s12 m12 l3'>
					<ul class='menucontent'>
						<li><a href='".base_url()."produk/'>READY STOK</a></li>
						<li><a class='active' href='".base_url()."produk/pre_order'>PRE ORDER</a></li>
						<li><a href='".base_url()."produk/atur_kateogri'>ATUR KATEGORI</a></li>
						<li><a href='".base_url()."produk/kategori'>KATEGORI</a></li>
					</ul>
				</div>
				<div class='col s12 m12 l9'>
					<div class='formain'>
						<div class='formhead'>
						<div class='input-field col right'>
								<button class='waves-effect waves-light btn deep-orange darken-1 right' onclick='location.href=\"".base_url()."produk/add/1\"'><i class='mdi-content-add-circle-outline left'></i>TAMBAH PRODUK</button>
							</div>
							<h2 class='titmain'><b>READY STOK</b> <span>( ".$produk->num_rows()." Produk )</span></h2>
							<p>Halaman ini menampilkan barang-barang ready stok yang ada di toko anda !</p>

						</div>
						<ul class='row formbody'>
							<li class='col s12 listanggodaf'>
								<div class='input-field col s12 m6 l6 nolpad'>
									<div class=' col s12 m8 l6'>
										<select class='select-standar lectfilter' onchange=javascript:change_active() id='active_type'>
											<option value='' disabled >Pilih filter</option>
											<option value='1' "; if ($uri3 == '' || $uri3 == '1'){ echo "selected";} echo">Published</option>
											<option value='0' "; if ($uri3 != '' && $uri3 == '0'){ echo "selected";} echo">Draft</option>											
										</select>

									</div>
									<div class=' col s12 m8 l6'>
									<select class='select-standar lectfilter'>
											<option value='' disabled >Pilih filter</option>
											<option >Fashion</option>
											<option >Otomotif</option>
											<option >Electronic</option>
										</select>
									</div>
								</div>								
								<div class='input-field col s12 m6 l4 nolpad right'>
									<i class='mdi-action-search prefix'></i>
									<input id='keyword' type='text' class='validate' value='"; if (isset($_SESSION['keyword'])) {echo $_SESSION['keyword'];unset($_SESSION['keyword']);} echo"'>
									<label for='keyword'>Cari produk</label >
								</div>
							</li>
							<li class='col s12 listanggodaf'>
								<div class='col s12 m12 l9 nolpad'>
									<p class='col s1 m1 l1'>
										<input type='checkbox' class='filled-in' onclick=javascript:cek_all() id='cek_all' />
										<label for='cek_all'></label>
									</p>
									<div class='input-field col s8 m4 l5'>
										<select class='select-standar lectfilter' id='option-go'>
											<option value='' disabled selected>Pilih tindakan</option>
											<option value='1'>Hapus</option>
											<option value='2'>Pindah ke Draft</option>
											<option value='3'>Pindah ke Publish</option>
											<option value='5'>Pindah ke Pre Order</option>
										</select>
									</div>
									<div class='input-field col s12 m4 l3'>
										<button class='waves-effect waves-light btn deep-orange darken-1 left' onclick=javascript:go()>GO</button>
									</div>
								</div>
								<ul class='tabs navthum col s12 m12 l3 nolpad right'>
									<li class='tab'><a class='active' href='#satu' ><i class='mdi-action-view-stream'></i></a></li>
									<li class='tab'><a href='#dua'><i class='mdi-action-view-module'></i></a></li>
								</ul>
							</li>

							<div id='satu'>";
							$i=0;
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
										if ($row->stock_type == 0) {
											$stok =  $this->model_produk->get_varian_produk($row->id);
											foreach ($stok->result() as $row_stok) {
												echo"
												<p class='input-field col s12 m12 l7 nolpad'>
													<input onkeyup=javascript:change_stock(".$row_stok->id.") type='text' name='stok-".$row_stok->id."' value='".$row_stok->stock_qty."' placeholder='Stok' class='validate numbersOnly stok-".$row_stok->id."'>";
													if ($row_stok->name != 'null') {
														echo "<label for='stok'>".$row_stok->name."</label>";
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
																
																<label for='varian'><b class='label-stock'>".$row_stok->name."</b> Stok : <span class='text-green'>selalu tersedia</span></label>
															</div>";
														}else{
															echo "
															<div class='input-field col s12 m12'>																
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
											echo "<button class='waves-effect waves-light btn-flat grey lighten-2 disabled' id='draft-".$row->id."'>DRAFT</button>";
										}else{
											echo "<button class='waves-effect waves-light btn-flat grey lighten-2 disabled' id='draft-".$row->id."' style='display:none;'>DRAFT</button>";
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
													<a href='#!' class=' modal-action modal-close waves-effect waves-light btn-flat'>TIDAK</a>
													<button type='button' onclick=javascript:delete_produk(".$row->id.") class='btn-flat modal-action modal-close waves-effect '>YA</button>
												</div>
											</div>
										</div>
									</div>
								</li>";
							}
							echo"
							<input type='hidden' id='total_produk' value='$i'>
							</div>
							<div id='dua'>";
							$a=0;
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
									<div class='card-reveal'>
										<span class='card-title grey-text text-darken-4'>".$row->name." <i class='mdi-navigation-close right'></i></span>
										<p>
											<div class='col s6'><b>Nomor SKU</b></div>
											<div class='col s6'>".$row->sku_no."</div>
											<div class='col s6'><b>Kategori</b></div>
											<div class='col s6'>".$row->kategori."</div>
											<div class='col s12'><b>Stok</b></div>
											<div class='col s12'>";
											if ($row->stock_type == 0) {
												$stok =  $this->model_produk->get_varian_produk($row->id);
												foreach ($stok->result() as $row_stok) {
													echo"
													<p class='input-field col s12 m12 l12 nolpad'>
														<input onkeyup=javascript:change_stock(".$row_stok->id.") type='text' name='stok-".$row_stok->id."' value='".$row_stok->stock_qty."' placeholder='Stok' class='validate numbersOnly stok-".$row_stok->id."'>";
														if ($row_stok->name != 'null') {
															echo "<label for='stok'>".$row_stok->name."</label>";
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
																<label for='varian'><b class='label-stock'>".$row_stok->name."</b> Stok : <span class='text-green'>selalu tersedia</span></label>
															</div>";
														}else{
															echo "
															<div class='input-field col s12 m12'>																
																<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label>
															</div>";
														}

													echo"
													</p>";
												}
											}
											echo"
										</div>
										</p>
									</div>
								</div>";
							}
							echo "
							</div>
						</ul>
					</div>
				</div>
				<script type='text/javascript' src='".base_url("")."assets/jController/enduser/CtrlProduk.js'></script>
";
?>		