<?php
$uri3 = $this->uri->segment(3);
$uri2 = $this->uri->segment(2);

echo"
<div id='produk_go' class='modal confirmation'>
	<div class='modal-header red'>
		<i class='mdi-navigation-close left'></i> <span id='head-go'>Hapus</span> produk
	</div>
	<form class='modal-content'>
		<p>Apakah Anda yakin ingin <span id='tipe-go'>menghapus</span> produk Anda ?</p>
	</form>
	<div class='modal-footer'>
		
		<button type='button' onclick=javascript:delete_produk_go() class='btn-flat modal-action modal-close waves-effect '>YA</button>
		<a href='javascript:void(0)' class=' modal-action modal-close waves-effect waves-light btn-flat'>TIDAK</a>
	</div>
</div>

			<div class='col s12 m12 l3'>
					<ul class='menucontent'>
						<li><a href='".base_url()."produk/index/1'>READY STOCK</a></li>
						<li><a class='active' href='".base_url()."produk/pre_order/1'>PRE ORDER</a></li>
						<li><a href='".base_url()."produk/atur_kategori'>ATUR KATEGORI</a></li>	
					</ul>
				</div>
				<div class='col s12 m12 l9'>
					<div class='formain'>
						<div class='formhead'>
						
						<h2 class='titmain' id='totalan'><b>PRE ORDER</b> <span>( ".$total." Produk )</span></h2>
						<p>Halaman ini menampilkan barang-barang pre order yang ada di toko anda !</p>
						<div class='input-field col s12 right'>
							<button class='waves-effect waves-light btn blue darken-1 right' onclick='location.href=\"".base_url()."produk/add_pre_order\"'><i class='mdi-content-add-circle-outline left'></i>TAMBAH PRODUK</button>
						</div>
						</div>
						<ul class='row formbody'>
							<li class='col s12 listanggodaf'>
								<div class='input-field col s12 m6 l4 nolpad nolmar right'>
									<i class='mdi-action-search prefix'></i>
									<input placeholder='Cari' id='keyword' type='text' class='validate' value='"; if (isset($_SESSION['keyword'])) {echo $_SESSION['keyword'];} echo"'>
									<!-- <label for='keyword'>Cari produk</label > -->
								</div>
								<div class='input-field col s12 m6 l6 nolpad nolmar'>
									<div class=' col s12 m8 l6'>
										<select class='selectize bajindul' onchange=javascript:change_active_pre() id='active_type'>
											<option value='' disabled >Pilih filter</option>
											<option value='1' "; if ($uri3 == '' || $uri3 == '1'){ echo "selected";} echo">Published</option>
											<option value='0' "; if ($uri3 != '' && $uri3 == '0'){ echo "selected";} echo">Draft</option>											
										</select>
									</div>
													
									<div class='col s12 m8 l6'>
										<select class='selectize bajindul' onchange=javascript:filter_kategori() id='filter-kategori'>											
											<option value=''>Semua Kategori</option>";
											foreach ($kategori->result() as $row_kt) {
												$select = '';
												if (isset($_SESSION['filter_kategori'])) {
													if ($_SESSION['filter_kategori'] == $row_kt->id) {$select = 'selected';unset($_SESSION['filter_kategori']);}
												}
												echo "<option value='".$row_kt->id."' $select>".$row_kt->name."</option>";
											}
											echo"
										</select>
									</div>
			
								</div>
							</li>
							<li class='col s12 listanggodaf'>
								<div class='col s12 m10 l10 nolpad'>
									<p class='col s1 m1 l1'>
										<input type='checkbox' class='filled-in' onclick=javascript:cek_all() id='cek_all' />
										<label for='cek_all'></label>
									</p>
									<div class='input-field col s7 m7 l5 nolmar'>
										<select class='select-standar lectfilter' id='option-go'>
											<option value='' disabled selected>Pilih tindakan</option>
											<option value='1'>Hapus</option>"; 
											if ($uri3 == '' || $uri3 == '1'){ echo "<option value='2'>Pindah ke Draft</option>";} 
											if ($uri3 != '' && $uri3 == '0'){ echo "<option value='3'>Pindah ke Publish</option>";} 
											echo"
											<option value='4'>Pindah ke Ready Stok</option>
										</select>
									</div>
									<div class='input-field col s4 m4 l3 nolmar'>
										<button class='waves-effect waves-light btn left' onclick=javascript:go()>GO</button>
									</div>
								</div>
								<div class='col s12 m2 l2 nolpad right'>
									<ul class='tabs navthum'>
										<li class='tab'><a class='active' href='#satu' ><i class='mdi-action-view-stream'></i></a></li>
										<li class='tab'><a href='#dua'><i class='mdi-action-view-module'></i></a></li>
									</ul>
								</div>
							</li>

							<div id='satu' class='pre_order'>";
							if ($produk->num_rows() == 0) {
								if (isset($_SESSION['keyword'])) {
									echo "Produk \"".$_SESSION['keyword']."\" tidak ditemukan";
									unset($_SESSION['keyword']);
								}else{
									echo "Produk pre order kosong";
								}
							}
							$i=0;
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
										</p> ";
										
										//if ($row->stock_type_detail == 1)  {
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
									//	}
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
							echo"
							</div>
							<input type='hidden' id='total_produk' value='$i'>
							<input type='hidden' id='uri' value='$uri3'>
							<div id='dua'>";
							$a=0;
							foreach ($produk->result() as $row) {
								$a++;
								$image = $this->model_produk->get_one_image($row->id)->row();
								$enddate=date('d M Y', strtotime($row->end_date));
								if (date('Y-m-d') > $row->end_date) {
									$kadal = "block";
								}else{
									$kadal = "none";
								}
								echo "
								<div class='card col s12 m4 l3 nolpad produk-".$row->id."' >
									<p class='checkiniabs'>
										<input type='checkbox' class='filled-in cek_produk' onclick=javascript:ngeklik('cek-1-$a','cek-2-$a') id='cek-2-$a'  />
										<label for='cek-2-$a'></label>
									</p>
									<div class='card-image waves-effect waves-block waves-light cropimg'>
									";
										if ($image) {
											echo "<img src='".base_url()."assets/pic/product/resize/".$image->file."' class='activator'>";											
										}else{
											echo "<img src='".base_url()."html/images/comp/product_large.png' class='activator'>";
										}
									echo"										
									</div>
									<div class='card-content'>
										<div class='card-title grey-text text-darken-4 small-text'><b>".$row->name."</b> <i class='mdi-navigation-more-vert right'></i></div>
										<p><a class='small-text' href='".base_url()."produk/edit_pre_order/".base64_encode($row->id)."'>Sunting Produk »</a></p>
									</div>
									<div class='card-reveal nolpad'>
										<span class='card-title grey-text text-darken-4'><i class='mdi-navigation-close right'></i></span>
										<p>
											<div class='col s12'><b>".$row->name."</b></div>
											<div class='col s12'><b>Kode Barang</b></div>
											<div class='col s12'>".$row->sku_no."</div>
											<div class='col s12'><b>Kategori</b></div>
											<div class='col s12'>".$row->kategori."</div>
											<div class='col s12'><b>Tanggal Berakhir</b></div>
											<div class='input-field col s12'>
												<span class='date-".$row->id."'>".$enddate."</span>
												<span class='label red right kadal-".$row->id."' style='display:$kadal'>Kadaluarsa</span>
											</div>";
											if ($row->active == 0) {
												echo "<button class='waves-effect waves-light btn-flat grey lighten-2 disabled draft-".$row->id."'>DRAFT</button>";
											}else{
												echo "<button class='waves-effect waves-light btn-flat grey lighten-2 disabled draft-".$row->id."' style='display:none;'>DRAFT</button>";
											}echo"
										</p>
									</div>
								</div>";
							}
							echo "
							</div>
							<div class='col s12' align='center'>
								<h3><br></h3>
								<img id='preloader' src='".base_url()."html/images/comp/loading.GIF' style='display:none' /><br>
								<label id='habis' class='green-text' style='display:none'>Semua produk telah ditampilkan</label>							
							</div>
						</ul>
					</div>
				</div>
				<script type='text/javascript' src='".base_url("")."assets/jController/enduser/CtrlProduk.js'></script>
";
?>		