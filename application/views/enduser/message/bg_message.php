<?php
echo"
	<div class='col s12 m12 l12'>
		<div class='formain'>
			<div class='formhead'>
				
				<div class='input-field col s12 m4'>
					<h2 class='titmain' id='totalan'><b>MESSAGE</b></h2>
				</div>				
				<div class='col s12 m8'>
					<button id='aMessageNew' class='btn deep-orange darken-1 waves-effect waves-light right pesan' type='button' name='action'>
						<i class='mdi-content-add-circle-outline left'></i> New Message
					</button>
				</div>
			</div>
			<div id='notifMessage' align='center' style='display:none;'></div>
			<div class='row formbody'>
				<div class='col s12 m4'>
					<ul class='row '>
						<li class='col s12 listanggodaf'>";
						$jedul = 'none';
						if ($Messages->num_rows() > 0) {
							$jedul = 'block';
						}
							echo "
							<div class='input-field col s12 m12'>
								<button id='btnMessageReads' style='display:$jedul' class='btn waves-effect waves-light col s12 m12' type='cancel' name='action'>
									Tandai semua 'Sudah dibaca'
								</button>
							</div>
							<div class='input-field col s12 m12'>
								<a href='#popupDeletes' style='display:$jedul' class='modal-trigger btn waves-effect waves-light deep-orange darken-1 col s12 m12'>
									Hapus semua
								</a>
							</div>							
						</li>
					</ul>
					<ul class='row '>
						<li class='col s12 listanggodaf'>
						<form method='POST' action='".base_url("message/")."'>							
							<input id='messageSearch' name='keyword' type='text' class='validate' placeholder='Cari pesan' value='".$keyword."'>
							<label for='messageSearch'></label>
						</form>
						</li>
					</ul>
					<ul class='row' id='contact-scroll' style='max-height: 500px; overflow: auto;' onscroll=javascript:scrollContact()>
						<div id='contact-pesan'>

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
										<p>".$this->template->limitChar($MessageLast->message,50)." </p>
										".$MessageStatus."
										<a href='#popupDelete' onclick=ctrlMessage.popupDelete(".$Message->member_id.",'".urlencode($Message->member_name)."'); class='modal-trigger btn-floating btn-xs waves-effect waves-red white right'><i class='mdi-navigation-close blue-grey-text'></i></a>
									</div>
								</li>
							";
						}

						echo"
						</div>
						<div id='loader-contact' style='text-align:center;display:none'><img src='".base_url()."html/images/comp/loading.GIF' width='40px'></div>
						<div id='habis-contact' style='display:none;font-size:12px;text-align:center;margin:20px' class='blue-text'><p >Contact sudah ditampilkan semua</p></div>
					</ul>
				</div>
				<div class='col s12 m8' id='messageContent'>";
						if ($Messages->num_rows() == 0) {
							echo "<center>Anda tidak memiliki pesan</center>";
						}
				echo"
				</div>
			</div>
		</div>
	</div>
	
	<div id='popupDelete' class='modal confirmation'>
		<div class='modal-header red'>
			<i class='mdi-navigation-close left'></i> Hapus Pesan
		</div>
		<form class='modal-content'>
			<input id='messageDeleteID' type='hidden' name='id'>
			<p>Apakah anda yakin ingin menghapus pesan dari <b id='messageDeleteName'></b> ?</p>
		</form>
		<div class='modal-footer'>		
			<a href='javascript:void(0);' id='aMessageDeleteYes' class=' modal-action modal-close waves-effect waves-red btn-flat'>YA</a>
			<a href='javascript:void(0);' id='aMessageDeleteNo' class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
		</div>
	</div>
	
	<div id='popupDeletes' class='modal confirmation'>
		<div class='modal-header red'>
			<i class='mdi-navigation-close left'></i> Hapus Semua Pesan
		</div>
		<form class='modal-content'>
			<p>Apakah anda yakin ingin menghapus semua pesan anda ?</p>
		</form>
		<div class='modal-footer'>		
			<a href='javascript:void(0);' id='aMessageDeletesYes' class=' modal-action modal-close waves-effect waves-red btn-flat'>YA</a>
			<a href='javascript:void(0);' class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
		</div>
	</div>
	
	<script>
		var ctrlMessage = new CtrlMessage();
		ctrlMessage.init();
		
	</script>
";

$Message = $Messages->row();
if(!empty($Message)){
	echo"
		<script>
			ctrlMessage.showMessageDetail(".$Message->member_id.");
		</script>
	";
}
?>