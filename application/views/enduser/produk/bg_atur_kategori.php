<?php

echo"
<div id='tambah_kategori' class='modal confirmation'>
	<div class='modal-header deep-orange'>
		<i class='mdi-action-spellcheck left'></i> Tambah Kategori
	</div>
	<form class='modal-content' id='form_add_kategori'>
		<span for='nama_kategori'>Nama kategori <span class='text-red'>*</span></span>
		<input id='id-toko' name='nama' type='hidden' value='".$_SESSION['bonobo']['id']."' >
		<input id='nama_kategori' maxlength='20' name='nama_kategori' type='text' class='validate'>
		<label class='error error-chosen' for='nama_kategori'></label>
	</form>
	<div class='modal-footer'>
		<a onclick=javascript:tambah_kategori_atur() class='waves-effect waves-light btn teal darken-1' >YA</a>
		<span class='col'> </span>
		<a class='modal-action modal-close waves-effect waves-light btn red darken-1' onclick=javascript:reset_cat()>TIDAK</a>
	</div>
</div>
<div class='col s12 m12 l3'>
					<ul class='menucontent'>
						<li><a href='".base_url()."produk/index/1'>READY STOCK</a></li>
						<li><a href='".base_url()."produk/pre_order/1'>PRE ORDER</a></li>
						<li><a class='active' href='".base_url()."produk/atur_kategori'>ATUR KATEGORI</a></li>						
					</ul>
				</div>
				<div class='col s12 m12 l9'>
					<div class='formain'>
						<div class='formhead'>														
							<h2 class='titmain'><b>ATUR KATEGORI</b></h2>
							<p>Halaman ini untuk membuat dan menghapus kategori produk di toko anda !</p>
							<div class='input-field col s12 m4 right'>
								<button href='#tambah_kategori' onclick=javascript:reset_cat() class='modal-trigger waves-effect waves-light btn blue darken-1 right s12'><i class='mdi-content-add-circle-outline left'></i>TAMBAH KATEGORI</button>
							</div>
						</div>
						<ul class='row formbody'>
							<li class='col s12 listanggodaf'>								
								<div class='input-field col s12 m5 right'>
									<i class='mdi-action-search prefix'></i>
									<input id='keyword-kategori' onkeypress=javascript:cari_kategori(event) type='text' class='validate'>
									<label for='keyword-kategori'>Cari kategori</label>
								</div>
							</li>
							<div id='tempat-kategori' class='hanya-atur'>
							";
							if ($kategori->num_rows() == 0) {
								if (isset($_SESSION['search_kategori'])) {
									echo "Kategori \"".$_SESSION['search_kategori']."\" tidak ditemukan";
									unset($_SESSION['search_kategori']);
								}else{
									echo "Kategori kosong";
								}
							}
							foreach ($kategori->result() as $row) {
								$count = $this->model_produk->count_product_by_category($row->id);
								echo"									
								<li class='col s12 listanggonew' id='kategori-".$row->id."'>
									<div class='col s12 m12 l6'><p><b>".$row->name."</b> <b class='green-text'> $count Produk</b></p>
									</div>
									<div class='col s12 m12 l6'>
										<a href='#delete_kategori_".$row->id."' class='modal-trigger btn-flat right'><b class='text-red'><i class='mdi-av-not-interested left'></i>Hapus</b></a>
										<a href='#edit_kategori_".$row->id."' onclick=javascript:set_rules(".$row->id.") class='modal-trigger btn-flat right'><b class='blue-text'><i class='mdi-editor-border-color left'></i>Edit</b></a>
										<div id='delete_kategori_".$row->id."' class='modal confirmation'>
											<div class='modal-header red'>
												<i class='mdi-navigation-close left'></i> Hapus Kategori
											</div>
											<form class='modal-content'>
												<p>Apakah anda yakin ingin menghapus <b>'".$row->name."'</b> ?</p>
											</form>
											<div class='modal-footer'>
												<a onclick=javascript:delete_kategori('".$row->id."') class=' modal-action modal-close btn-flat teal-text'>YA</a>
												<a  class=' modal-action modal-close btn-flat red-text'>TIDAK</a>
											</div>
										</div>

										<div id='edit_kategori_".$row->id."' class='modal confirmation'>
											<div class='modal-header deep-orange'>
												<i class='mdi-action-spellcheck left'></i> Edit Kategori
											</div>
											<form class='modal-content' id='form_edit_kategori_".$row->id."'>
												<p>
													<div class='input-field col s12'>														
														<input id='nama_".$row->id."' name='nama_kategori' maxlength='20' type='text' value='".$row->name."' class='validate' required>
														<label for='nama_".$row->id."'>Kategori</label>	
														<label  class='error' for='nama_".$row->id."'></label>													
													</div>
											    </p>
											</form>
											<div class='modal-footer'>
												<a href='javascript:void(0)' onclick=javascript:edit_kategori('".$row->id."') class=' modal-action btn-flat teal-text'>YA</a>
												<a href='javascript:void(0)' onClick='window.location.reload()' class=' modal-action modal-close btn-flat red-text'>TIDAK</a>
											</div>
										</div>
									</div>
								</li>";
							}
						echo"
						</div>						
						<center>
							<h3><br></h3>
							<img id='preloader' src='".base_url()."html/images/comp/loading.GIF' style='display:none' /><br>
							<label id='habis' class='green-text' style='display:none'>Semua kategori telah ditampilkan</label>							
						</center>
						</ul>
					</div>
				</div>
				<script type='text/javascript' src='".base_url("")."assets/jController/enduser/CtrlProduk.js'></script>";

?>				
