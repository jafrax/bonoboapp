<?php
$uri = base64_decode($this->uri->segment(3));
$uri2 = base64_decode($this->uri->segment(4));
echo "
<div class='col s12 m12 l12'>
					<div class='formain'>
						<div class='formhead'>
							<div class='input-field col s6 m4'>
						        <i class='mdi-action-search prefix'></i>
						        <input disabled id='icon_prefix' type='text' class='validate'>
						        <label for='icon_prefix'></label>
					        </div>					        
						</div>

						<div class='row formbody'>
							<div class='col s12 m4'>
								<ul class='row formbody'>
									<li class='col s12 listanggodaf'>
										<div class='input-field col s12 m12'>
											<button  class='btn waves-effect disabled waves-light col s12 m12' type='cancel' name='action'>
											    Tandai semua 'Sudah dibaca'
											</button>
										</div>
										<div class='input-field col s12 m12'>
											<button  class='btn waves-effect disabled waves-light deep-orange darken-1 col s12 m12' type='submit' name='action'>
												Hapus semua
											</button>
										</div>
									</li>
									
									";

									foreach($Messages->result() as $Message){
										$MessageStatus = "";
										$MemberImage = base_url("assets/image/img_default_photo.jpg");
										
										if(!empty($Message->qmember_image) && file_exists("./assets/pic/user/".$Message->qmember_image)){
											$MemberImage = base_url("assets/pic/user/resize/".$Message->qmember_image);
										}
										
										$MessageNew = $this->model_toko_message->get_by_shop_member_new($_SESSION["bonobo"]["id"],$Message->member_id)->result();
										if(sizeOf($MessageNew) > 0){
											$MessageStatus = "<p class='red-text'>Pesan baru</p>";
										}
										
										$MessageLast = $this->model_toko_message->get_by_shop_member_last($_SESSION["bonobo"]["id"],$Message->member_id)->row();
										
										echo"
											<li class='col s12 m12 listanggodaf waves-effect' onclick=ctrlMessage.showMessageDetail(".$Message->member_id.")>
												<div class='col s3 m5 l4'>
													<img src='".$MemberImage."' class='responsive-img userimg'>
												</div>
												<div class='col s9 m7 l8'>
													<p class=' blue-grey-text lighten-3 right'>".$this->hs_datetime->getTime4String($MessageLast->create_date)."</p>
													<p><a  href=''><b class='userangoota'>".$Message->qmember_name."</b></a></p>															
													<p>".$this->template->limitChar($MessageLast->message,50)."</p>
													".$MessageStatus."
													
												</div>
											</li>
										";
									}

								echo"							
								</ul>
							</div>
							<div class='col s12 m8'>		        
								<h6>Kepada : </h6>
								<div class='content-pesan'>
									<h4>".$uri2."</h4>
								</div>

								<div class='content-balasan'>
									<form class='col s12' method='post' action='' id='pesannyanota'>
									    <div class='row'>
									        <div class='input-field col s12'>
									          	<textarea id='message' class='materialize-textarea' name='message'></textarea>
									          	<label for='message'>Isi Pesan</label>
									          	<input type='hidden' name='email' value='$uri'>
									        </div>
									        <div class='input-field col s12'>
									          	<button class='btn-flat waves-effect waves-light deep-orange white-text right' type='submit' name='action'>
												    <i class='mdi-content-send right'></i> Kirim
												</button>
									        </div>
									    </div>
								    </form>
								</div>							
						    </div>
						    <div class='input-field col s12 m8'>

						    </div>
						</div>
					</div>
				</div>
				";
				?>