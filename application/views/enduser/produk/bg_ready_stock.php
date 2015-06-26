<?php
echo"
<div id='delete_produk' class='modal confirmation'>
	<div class='modal-header red'>
		<i class='mdi-navigation-close left'></i> Hapus produk
	</div>
	<form class='modal-content'>
		<p>Apakah anda yakin ingin menghapus <b>'nama produk'</b> ?</p>
	</form>
	<div class='modal-footer'>
		<a href='#!' class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
		<a href='#!' class=' modal-action modal-close waves-effect waves-red btn-flat'>YA</a>
	</div>
</div>

			<div class='col s12 m12 l3'>
					<ul class='menucontent'>
						<li><a class='active' href='produk_ready_stock.html'>READY STOK</a></li>
						<li><a href='produk_pre_order.html'>PRE ORDER</a></li>
						<li><a href='.html'>ATUR KATEGORI</a></li>
						<li><a href='.html'>KATEGORI</a></li>
					</ul>
				</div>
				<div class='col s12 m12 l9'>
					<div class='formain'>
						<div class='formhead'>
						<div class='input-field col right'>
								<button class='waves-effect waves-light btn deep-orange darken-1 right' onclick='location.href=\"".base_url()."produk/add/1\"'><i class='mdi-content-add-circle-outline left'></i>TAMBAH PRODUK</button>
							</div>
							<h2 class='titmain'><b>READY STOK</b> <span>( 25 Produk )</span></h2>
							<p>Halaman ini menampilkan barang-barang ready stok yang ada di toko anda !</p>

						</div>
						<ul class='row formbody'>
							<li class='col s12 listanggodaf'>
								<div class='input-field col s12 m6 l6 nolpad'>
									<div class='input-field col s12 m8 l6'>
										<select class=''>
											<option value='' disabled selected>Pilih filter</option>
											<option value='1'>Published</option>
											<option value='0'>Draft</option>											
										</select>
									</div>
									
								</div>								
								<div class='input-field col s12 m6 l3 nolpad right'>
									<i class='mdi-action-search prefix'></i>
									<input id='nama' type='text' class='validate'>
									<label for='nama'>Cari produk</label>
								</div>
							</li>
							<li class='col s12 listanggodaf'>
								<div class='col s12 m12 l9 nolpad'>
									<p class='col s1 m1 l1'>
										<input type='checkbox' class='filled-in' id='filled-in-box' />
										<label for='filled-in-box'></label>
									</p>
									<div class='input-field col s8 m4 l5'>
										<select class='lectfilter'>
											<option value='' disabled selected>Pilih tindakan</option>
											<option value='1'>Hapus</option>
											<option value='2'>Pindah ke Draft</option>
											<option value='3'>Pindah ke Publish</option>
											<option value='4'>Pindah ke Ready Stock</option>
										</select>
									</div>
									<div class='input-field col s12 m4 l3'>
										<button class='waves-effect waves-light btn deep-orange darken-1 left'>GO</button>
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
								<li class='col s12 m12 listanggodaf'>
									<p class='col s1 m1 l1'>
										<input type='checkbox' class='filled-in cek_produk' name='cek_produk_".$row->id."' id='cek-$i' />
										<label for='cek-$i'></label>
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
										<p class='titleproduct'><a href=''><b >".$row->name."</b></a></p>
										</p>";
										if ($row->stock_type == 0) {
											$stok =  $this->model_produk->get_varian_produk($row->id);
											foreach ($stok->result() as $row_stok) {
												echo"
												<p class='input-field col s12 m12 l6 nolpad'>
													<input id='stok' type='text' value='".$row_stok->stock_qty."' placeholder='Stok' class='validate'>";
													if ($row_stok->name != 'null') {
														echo "<label for='stok'>".$row_stok->name."</label>";
													}
													
													if ($row_stok->stock_qty == 0) {
														echo"<span class='label red right'>Stok habis</span>";
													}
												echo"	
												</p>";
											}											
										}else{
											echo "
											<div class='input-field col s12 m6'>
												<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label>
											</div>
											";
										}
										echo"
										<div class='col s12 m12 l12 '>";
										if ($row->active == 0) {
											echo "<button class='waves-effect waves-light btn-flat grey lighten-2 disabled'>DRAFT</button>";
										}											
											echo"
											<a href='#delete_produk' class='modal-trigger btn-floating btn-xs waves-effect waves-light red right'><i class='mdi-navigation-close'></i></a>
										</div>
									</div>
								</li>";
							}
							echo"
							</div>
							<div id='dua'>
								<div class='card col s12 m4 l3 nolpad'>
									<p class='checkiniabs'>
										<input type='checkbox' class='filled-in' id='filled-in-card-item-1' checked='checked' />
										<label for='filled-in-card-item-1'></label>
									</p>
									<div class='card-image waves-effect waves-block waves-light'>
										<img class='activator' src='images/comp/product_large.png'>
									</div>
									<div class='card-content'>
										<span class='card-title activator grey-text text-darken-4'>Candy Men <i class='mdi-navigation-more-vert right'></i></span>
										<p><a href='#'>This is a link</a></p>
									</div>
									<div class='card-reveal'>
										<span class='card-title grey-text text-darken-4'>Card Title <i class='mdi-navigation-close right'></i></span>
										<p>Here is some more information about this product that is only revealed once clicked on.</p>
									</div>
								</div>
								<div class='card col s12 m4 l3 nolpad'>
									<p class='checkiniabs'>
										<input type='checkbox' class='filled-in' id='filled-in-card-item-1' checked='checked' />
										<label for='filled-in-card-item-1'></label>
									</p>
									<div class='card-image waves-effect waves-block waves-light'>
										<img class='activator' src='images/comp/product_large.png'>
									</div>
									<div class='card-content'>
										<span class='card-title activator grey-text text-darken-4'>Candy Men <i class='mdi-navigation-more-vert right'></i></span>
										<p><a href='#'>This is a link</a></p>
									</div>
									<div class='card-reveal'>
										<span class='card-title grey-text text-darken-4'>Card Title <i class='mdi-navigation-close right'></i></span>
										<p>Here is some more information about this product that is only revealed once clicked on.</p>
									</div>
								</div>
								<div class='card col s12 m4 l3 nolpad'>
									<p class='checkiniabs'>
										<input type='checkbox' class='filled-in' id='filled-in-card-item-1' checked='checked' />
										<label for='filled-in-card-item-1'></label>
									</p>
									<div class='card-image waves-effect waves-block waves-light'>
										<img class='activator' src='images/comp/product_large.png'>
									</div>
									<div class='card-content'>
										<span class='card-title activator grey-text text-darken-4'>Candy Men <i class='mdi-navigation-more-vert right'></i></span>
										<p><a href='#'>This is a link</a></p>
									</div>
									<div class='card-reveal'>
										<span class='card-title grey-text text-darken-4'>Card Title <i class='mdi-navigation-close right'></i></span>
										<p>Here is some more information about this product that is only revealed once clicked on.</p>
									</div>
								</div>
							</div>

						</ul>
					</div>
				</div>
";
?>		