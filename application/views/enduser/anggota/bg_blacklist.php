<?php	
	
echo"
	<div class='col s12 m12 l3'>
		<ul class='menucontent'>
			<li><a href='".base_url("anggota")."'>ANGGOTA BARU</a> <span class='new badge'>".$countNewMember."</span></li>
			<li><a href='".base_url("anggota/invite")."'>KIRIM UNDANGAN</a></li>
			<li><a href='".base_url("anggota/members")."'>DAFTAR ANGGOTA</a></li>
			<li><a href='".base_url("anggota/blacklist")."' class='active'>BLACKLIST</a></li>
		</ul>
	</div>
	
	
	<div class='col s12 m12 l9'>
		<div class='formain'>
			<div class='formhead'>
				<h2 class='titmain'><b>DAFTAR BLACKLIST</b></h2>
				<p>Pembeli yang berada dalam blacklist tidak bisa masuk kembali dalam toko anda.</p>
			</div>
			<div id='notifBlacklist' align='center' style='display:none;'></div>
			<ul class='row formbody'>
				<form method='POST' action='".base_url("anggota/blacklist/")."'>
				<li class='col s12 listanggodaf'>
					<div class='input-field col s12 m8 right'>
						<i class='mdi-action-search prefix'></i>
						<input id='keyword' name='keyword' type='text' class='validate' value='".$keyword."'>
						<label for='keyword'>Cari anggota</label>
					</div>
				</li>
				</form>
";

if(sizeOf($Members) <= 0){
	echo"Data tidak ditemukan";
}else{
	foreach($Members as $Member){
		$MemberImage = base_url("assets/image/img_default_photo.jpg");
		
		if(!empty($Member->image) && file_exists("./assets/pic/user/".$Member->image)){
			$MemberImage = base_url("assets/pic/user/resize/".$Member->image);
		}
		
		echo"
			<li class='col s12 m6 l4 listanggodaf'>
				<div class='col s12 m5 l4'>
					<img src='".$MemberImage."' class='responsive-img userimg'>
				</div>
				<div class='col s12 m7 l8'>
					<p><a href='#popupBlacklist' onclick=ctrlAnggotaBlacklist.popupDetail2(".$Member->id."); class='modal-trigger'><b class='userangoota'>".$Member->name."</b></a></p>
					<a href='#popupDelete' onclick=ctrlAnggotaBlacklist.popupDelete(".$Member->id.",'".urlencode($Member->name)."'); class='modal-trigger btn-floating btn-xs waves-effect waves-light red right'><i class='mdi-navigation-close'></i></a>
				</div>
			</li>
		";
	}
}
echo"
				
			</ul>
		</div>
	</div>
	
	<div id='popupBlacklist' class='modal modal-fixed-footer'></div>
	
	<div id='popupDelete' class='modal confirmation'>
		<div class='modal-header red'>
			<i class='mdi-navigation-close left'></i> Keluarkan dari blacklist
		</div>
		<form class='modal-content'>
			<input id='blacklistDeleteID' type='hidden'>
			<p>Pembeli yang dikeluarkan dari blacklist, dikemudian hari bisa masuk lagi ke toko anda. Lanjutkan ?</p>
		</form>
		<div class='modal-footer'>
			<a href='javascript:void(0);' id='aBlacklistDeleteYes' class=' modal-action modal-close waves-effect waves-teal lighten-2 btn-flat'>YA</a>
			<a href='javascript:void(0);' id='aBlacklistDeleteNo' class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
		</div>
	</div>
	
	<script>
		var ctrlAnggotaBlacklist = new CtrlAnggotaBlacklist();
		ctrlAnggotaBlacklist.init();
	</script>
";

?>