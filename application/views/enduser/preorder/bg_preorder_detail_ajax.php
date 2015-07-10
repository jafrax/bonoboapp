<?php

						if ($nota->num_rows() > 0) {
							$i=0;
							foreach ($nota->result() as $row) {
								$i++;
								echo "
								<div class='col s12 m12'>								
	      							<div class='notacard card-panel grey lighten-5 z-depth-1'>
							          	<div class='row '>
							          		<div class='col s12 m1'>
												<input type='checkbox' class='filled-in cek_nota' id='cek-nota-".$i."' />
			      								<label for='cek-nota-".$i."'></label>	
			      								<input type='hidden' id='cek-$i' value='".$row->id."' />								
											</div>
								            <div class='col s6 m2'>";
												$image = $this->model_preorder->get_image($row->member_id);

									            if ($image->row()->image != '') {
									            	echo "<img src='".base_url()."assets/pic/user/resize/".$image->row()->image."' alt='' class='circle responsive-img col'> ";
									            }else{
									            	echo "<img src='".base_url()."html/images/comp/male.png' alt='' class='circle responsive-img col'> ";
									            }
									              echo"								              	
								            </div>
								            <div class='col s12 m4'>
								              	<h5 class='blue-text'>".$row->invoice_no."</h5>
								              	<h6 class='blue-text'>".$row->member_name."</h6>";
								              	if ($row->status == 0 ) {
									            	echo "<span class='labelbudge pink lighten-2'>BELUM LUNAS</span>";
									            }elseif ($row->status == 1) {
									            	echo "<span class='labelbudge green lighten-2'>LUNAS</span>";
									            }elseif ($row->status == 2) {
									            	echo "<span class='labelbudge grey lighten-2'>BATAL</span>";
									            }
								              	
								              	echo "
								              	<h5>Rp. ".number_format($row->price_total, 2 , ',' , '.')."</h5>
								            </div>								           
								            <div class='col s12 m5'>";
							            		$old_date = $row->create_date;
												$old_date_timestamp = strtotime($old_date);
												$date = date('d F Y, H.i', $old_date_timestamp);
												$ago 		= $this->template->xTimeAgoDesc($old_date,date('Y-m-d H:i:s'));
							            		echo"
								              	<p class='col blue-grey-text lighten-3 right'>$date ( $ago )</p><br>";
								              	if ($row->status_pre_order == 0) {
								              		echo "
													<h5 class='col red-text right' id='selesai-".$row->id."'>Belum Selesai</h5><br><br><br>
													<button class='btn-flat waves-effect red white-text waves-light right' id='tombol-".$row->id."' type='button' name='action'>Selesai</button>
													";
												}else{
													echo "
													<h5 class='col green-text right'>Selesai</h5>													
													";
												}
												echo "
								            </div>
							          	</div>
							        </div>
								</div>
								";
							}
							echo "<input type='hidden' value='$i' id='total-nota' />";
						}else{
							echo "
								<div class='col s12 m12'>								
	      							<div class='notacard card-panel grey lighten-5 z-depth-1'>
							          	<div class='row '>
							          		<p> Data pemesanan tidak ada </p>
							          	</div>
							        </div>
								</div>
								";
						}							
				?>