<?php
echo "
<div class='col s12 m12 l12'>
					<div class='formain'>
						<div class='row formbody'>
							<div class='col s12 m12'>
								<ul class='row formbody'>";
								foreach ($produk->result() as $row) {
									$count = $this->model_preorder->get_belum_selesai($row->id)->num_rows();
									echo "
									<li class='col s12 m6 listanggodaf'>
										<div class='col s3 m5 l4'>";
										if ($row->image) {
											echo "<img src='".base_url()."assets/pic/product/resize/".$row->image."' class='responsive-img userimg'>";
										}else{
											echo "<img src='html/images/comp/male.png' class='responsive-img userimg'>";
										}
											echo "
										</div>
										<div class='col s9 m7 l8'>
											<p class=' blue-grey-text lighten-3 right'>19.09</p>
											<p><a href=''><b class='userangoota'>".$row->name."</b></a></p>				
											<span class='red-text'>$count Belum Selesai</span>										
											<p>
											<a onclick=javascript:all_done() class='btn-flat waves-effect waves-light teal white-text right'>Selesai Semua</a> 
											<a href='".base_url()."preorder/detail/".base64_encode($row->id)."' class='btn-flat waves-effect waves-light deep-orange white-text right'>Lihat Pesanan</a></p>
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