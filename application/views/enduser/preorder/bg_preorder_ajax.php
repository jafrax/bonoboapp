<?php

									foreach ($produk->result() as $row) { //echo "ajak".$row->id;
									$count = $this->model_preorder->get_belum_selesai($row->id)->num_rows();
									$count2 = $this->model_preorder->get_sudah_selesai($row->id)->num_rows();
									
										$jmlPreOrder=0;
										$jmlLunas=0;
										
										$count_pre_order = $this->model_preorder->get_lusin_pre_order($row->id);
										foreach ($count_pre_order->result() as $pre_order) {
										$jmlPreOrder= $jmlPreOrder + $pre_order->jumlah;
										}
										
										$count_lunas = $this->model_preorder->get_lusin_lunas($row->id);
										foreach ($count_pre_order->result() as $lunas) {
										$jmlLunas=$jmlLunas + $lunas->jumlah;
										}
									
									
										$ago 		= $this->template->xTimeAgoDesc($row->create_date,date('Y-m-d H:i:s'));
										echo "
										<li class='col s12 m6 l6 nolpad nolmar' id='li-".$row->id."'>  
											<div class='listpesanpreorder'>
												<div class='prordercrop col s12 m5 l4 nolpad'>";
												if ($row->image) {
													echo "<img src='".base_url()."assets/pic/product/resize/".$row->image."' class='responsive-img '>";
												}else{
													echo "<img src='assets/image/img_default_logo.jpg' class='responsive-img userimg'>";
												}
													echo "
												</div>
												<div class='col s12 m7 l6'>
													<p class=' blue-grey-text lighten-3 right small-text'>$ago</p>
													<p><a href='".base_url()."preorder/detail/".base64_encode($row->id)."/".base64_encode($row->name)."' ><b class='userangoota'>".$row->name."</b></a></p>				
													<br>
													<span class='red-text' id='counter-".$row->id."'>$jmlPreOrder Lusin Pre Order</span>	
													<br>
													<span class='blue-text' id='counter-".$row->id."'>$jmlLunas Lusin Lunas</span>
												</div>
												<div class='col s12'>
												
												<div class='col s4 right'			
												 <span class='Blue-text' id='counter-".$row->id."'>$count NOTA OPEN</span>	
												 </div>
												 <div class='col s4 right'>
												 <span class='red-text' id='counter-".$row->id."'>$count2 NOTA CLOSE</span> 
												</div>		
													<p class='colink'>";
													if ($count > 0) {
														echo "<!-- <a onclick=javascript:all_done(".$row->id.") id='btn-selesai-".$row->id."' class='right'>Selesai Semua »</a> --> ";
													}												
													echo"
													<!-- 	<a href='".base_url()."preorder/detail/".base64_encode($row->id)."/".base64_encode($row->name)."' class='right'>Lihat Pesanan »</a></p> -->
												</div>
											</div>
										</li>";
									}
								

?>