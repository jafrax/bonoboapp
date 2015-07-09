<?php
echo "
<div class='col s12 m12 l12'>
					<div class='formain'>
						<div class='row formbody'>
							<div class='col s12 m12'>
								<ul class='row formbody'>";
								foreach ($produk->result() as $row) {
									echo "
									<li class='col s12 m6 listanggodaf'>
										<div class='prordercrop col s12 m5 l4 nolpad'>";
										if ($row->image) {
											echo "<img src='".base_url()."assets/pic/product/resize/".$row->image."' class='responsive-img '>";
										}else{
											echo "<img src='html/images/comp/male_large.png' class='responsive-img userimg'>";
										}
											echo "
										</div>
										<div class='col s12 m7 l8'>
											<p class=' blue-grey-text lighten-3 right'>19.09</p>
											<p><a href=''><b class='userangoota'>".$row->name."</b></a></p>				
											<span class='red-text'>20 Belum Selesai</span>										
											<p>
											<a href='#' class='btn-flat waves-effect waves-light teal white-text right'>Selesai Semua</a> 
											<a href='pesanan_pre_order_detail.html' class='btn-flat waves-effect waves-light deep-orange white-text right'>Lihat Pesanan</a></p>
										</div>
									</li>";
								}
									echo"
								</ul>
							</div>							
						</div>
					</div>
				</div>

";

?>