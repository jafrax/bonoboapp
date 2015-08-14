<?php
echo "
				<div class='col s12 m12 l12'>
					<div class='formain'>
						<div class='row formbody'>
							<div class='col s12 m12'>
								<ul class='row formbody preorder' id='ajax-div'>";
								if ($produk->num_rows() > 0) {
									foreach ($produk->result() as $row) {
										$count = $this->model_preorder->get_belum_selesai($row->id)->num_rows();
										$ago 		= $this->template->xTimeAgoDesc($row->create_date,date('Y-m-d H:i:s'));
										echo "
										<li class='col s12 m6 listanggodaf' id='li-".$row->id."'>
											<div class='prordercrop col s12 m5 l4 nolpad'>";
											if ($row->image) {
												echo "<img src='".base_url()."assets/pic/product/resize/".$row->image."' class='responsive-img '>";
											}else{
												echo "<img src='html/images/comp/male_large.png' class='responsive-img userimg'>";
											}
												echo "
											</div>
											<div class='col s12 m7 l8'>
												<p class=' blue-grey-text lighten-3 right'>$ago</p>
												<p><a href=''><b class='userangoota'>".$row->name."</b></a></p>				
												<span class='red-text' id='counter-".$row->id."'>$count Belum Selesai</span>										
												<p>";
												if ($count > 0) {
													echo "<a onclick=javascript:all_done(".$row->id.") id='btn-selesai-".$row->id."' class='btn-flat waves-effect waves-light teal white-text right'>Selesai Semua</a> ";
												}												
												echo"
												<a href='".base_url()."preorder/detail/".base64_encode($row->id)."/".base64_encode($row->name)."' class='btn-flat waves-effect waves-light deep-orange white-text right'>Lihat Pesanan</a></p>
											</div>
										</li>";
									}
								}else{
									echo "
										<li class='col s12 m6'>
											<div class='col s12 m5 l4 nolpad'>
												Data pemesanan kosong
											</div>
										</li>";
								}
									echo"
									
								</ul>
								<center>
										<h3><br></h3>
										<img id='preloader' src='".base_url()."html/images/comp/loading.GIF' style='display:none' /><br>
										<label id='habis' class='green-text' style='display:none'>Semua produk telah ditampilkan</label>							
									</center>
							</div>							
						</div>
					</div>
				</div>
<script type='text/javascript' src='".base_url("")."assets/jController/enduser/CtrlPreorder.js'></script>
";

?>