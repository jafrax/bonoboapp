<?php

									foreach ($produk->result() as $row) { //echo "ajak".$row->id;
									$count = $this->model_preorder->get_belum_selesai($row->id)->num_rows();
									//echo "jumlah ajak".$count;
										$ago 		= $this->template->xTimeAgoDesc($row->create_date,date('Y-m-d H:i:s'));
										echo "
										<li class='col s12 m6 l4 listanggodaf' id='li-".$row->id."'>
											<div class='prordercrop col s12 m5 l4 nolpad'>";
											if ($row->image) {
												echo "<img src='".base_url()."assets/pic/product/resize/".$row->image."' class='responsive-img '>";
											}else{
												echo "<img src='assets/image/img_default_logo.jpg' class='responsive-img userimg'>";
											}
												echo "
											</div>
											<div class='col s12 m7 l8'>
												<p class=' blue-grey-text lighten-3 right'>$ago</p>
												<p><b class='userangoota'>".$row->name."</b></p>				
												<span class='red-text' id='counter-".$row->id."'>$count Belum Selesai</span>										
											</div>
											<div class='col s12'>
												<p>";
												if ($count > 0) {
													echo "<a onclick=javascript:all_done(".$row->id.") id='btn-selesai-".$row->id."' class='right'>Selesai Semua »</a> ";
												}												
												echo"
												<a href='".base_url()."preorder/detail/".base64_encode($row->id)."/".base64_encode($row->name)."' class='right'>Lihat Pesanan »</a></p>
											</div>
										</li>";
									}
								

?>