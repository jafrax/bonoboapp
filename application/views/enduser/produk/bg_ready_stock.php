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
							<h2 class='titmain'><b>READY STOK</b> <span>( 25 Produk )</span></h2>
							<p>Halaman ini menampilkan barang-barang ready stok yang ada di toko anda !</p>
						</div>
						<ul class='row formbody'>
							<li class='col s12 listanggodaf'>
								<div class='input-field col s12 m12 l6 nolpad'>
									<div class='input-field col s12 m8 l6'>
										<select class='lectfilter'>
											<option value='' disabled selected>Published</option>
											<option value='1'>Option 1</option>
											<option value='2'>Option 2</option>
											<option value='3'>Option 3</option>
										</select>
									</div>
									<div class='input-field col s12 m4 l6'>
										<button class='waves-effect waves-light btn deep-orange darken-1 left' onclick='location.href=\"".base_url()."produk/add/1\"'>TAMBAH</button>
									</div>
								</div>
								<div class='input-field col s12 m12 l6 nolpad'>
									<i class='mdi-action-search prefix'></i>
									<input id='nama' type='text' class='validate'>
									<label for='nama'>Cari produk</label>
								</div>
							</li>
							<li class='col s12 listanggodaf'>
								<div class='col s12 m12 l9 nolpad'>
									<p class='col s4 m4 l4'>
										<input type='checkbox' class='filled-in' id='filled-in-box' checked='checked' />
										<label for='filled-in-box'>Pilih semua</label>
									</p>
									<div class='input-field col s8 m4 l5'>
										<select class='lectfilter'>
											<option value='' disabled selected>Pilih tindakan</option>
											<option value='1'>Option 1</option>
											<option value='2'>Option 2</option>
											<option value='3'>Option 3</option>
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

							<div id='satu'>
								<li class='col s12 m12 listanggodaf'>
									<p class='col s1 m1 l1'>
										<input type='checkbox' class='filled-in' id='filled-in-box-item-1' checked='checked' />
										<label for='filled-in-box-item-1'></label>
									</p>
									<div class='col s12 m3 l2'>
										<img src='images/comp/product.png' class='responsive-img userimg'>
									</div>
									<div class='col s12 m8 l9'>
										<p class='titleproduct'><a href=''><b >Candy Men</b></a></p>
										</p>
										<p class='input-field col s12 m12 l6 nolpad'>
											<input id='stok' type='text' value='0' placeholder='Stok' class='validate'>
											<span class='label red right'>Stok habis</span>
										</p>
										<div class='col s12 m12 l12 '>
											<button class='waves-effect waves-light btn-flat grey lighten-2 disabled'>DRAFT</button>
											<a href='#delete_produk' class='modal-trigger btn-floating btn-xs waves-effect waves-light red right'><i class='mdi-navigation-close'></i></a>
										</div>
									</div>
								</li>
								<li class='col s12 m12 listanggodaf'>
									<p class='col s1 m1 l1'>
										<input type='checkbox' class='filled-in' id='filled-in-box-item-2' checked='checked' />
										<label for='filled-in-box-item-2'></label>
									</p>
									<div class='col s12 m3 l2'>
										<img src='images/comp/product.png' class='responsive-img userimg'>
									</div>
									<div class='col s12 m8 l9'>
										<p class='titleproduct'><a href=''><b >Candy Men</b></a></p>
										</p>
										<p class='input-field col s12 m12 l6 nolpad'>
											<input id='stok' type='text' value='20' placeholder='Stok'  class='validate'>
										</p>
										<div class='col s12 m12 l12 '>
											<button class='waves-effect waves-light btn-flat grey lighten-2 disabled'>DRAFT</button>
											<a href='#delete_produk' class='modal-trigger btn-floating btn-xs waves-effect waves-light red right'><i class='mdi-navigation-close'></i></a>
										</div>
									</div>
								</li>
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