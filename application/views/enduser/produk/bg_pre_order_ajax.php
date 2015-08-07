<?php
$uri3 = $this->uri->segment(3);

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
										</p>
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
										<p><a href='".base_url()."produk/edit_pre_order/".base64_encode($row->id)."'>Sunting Produk</a></p>
									</div>
									<div class='card-reveal nolpad'>
										<span class='card-title grey-text text-darken-4'><i class='mdi-navigation-close right'></i></span>
										<p>
											<div class='col s12'><b>".$row->name."</b></div>
											<div class='col s12'><b>SKU</b></div>
											<div class='col s12'>".$row->sku_no."</div>
											<div class='col s12'><b>Kategori</b></div>
											<div class='col s12'>".$row->kategori."</div>
											<div class='col s12'><b>Tanggal Berakhir</b></div>
											<div class='input-field col s12'>
												<span class='date-".$row->id."'>".$row->end_date."</span>
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
							
?>		