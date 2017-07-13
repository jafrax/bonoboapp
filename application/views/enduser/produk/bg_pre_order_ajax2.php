<?php
$uri4 = $this->uri->segment(4);
$uri3 = $this->uri->segment(3);
if ($produk->num_rows() == 0) {
	if (isset($_SESSION['keyword'])) {
		echo "Produk \"".$_SESSION['keyword']."\" tidak ditemukan";
	}else{
		echo "Produk pre order kosong";
	}
}
							$a=0;
							if ($uri4 != '') {
								$a= $uri4;
							}
							foreach ($produk->result() as $row) {
								$enddate=date('d M Y', strtotime($row->end_date));
								if (date('Y-m-d') > $row->end_date) {
									$kadal = "block";
								}else{
									$kadal = "none";
								}
								$a++;
								$image = $this->model_produk->get_one_image($row->id)->row();
								$sunting = "Sunting Produk »";
								$clean = str_replace(chr(194)," ",$sunting);
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
										<div class='card-title activator grey-text text-darken-4  small-text'><b>".$row->name."</b> <i class='mdi-navigation-more-vert right'></i></div>
										<p><a class='small-text' href='".base_url()."produk/edit_pre_order/".base64_encode($row->id)."'>".$clean."</a></p>
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
							
?>		