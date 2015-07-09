<?php	
	
echo"
	<div class='col s12 m12 l3'>
		<ul class='menucontent'>
			<li><a href='".base_url("anggota")."' class='active'>ANGGOTA BARU</a> <span class='new badge'>".$countNewMember."</span></li>
			<li><a href='".base_url("anggota/invite")."'>KIRIM UNDANGAN</a></li>
			<li><a href='".base_url("anggota/members")."'>DAFTAR ANGGOTA</a></li>
			<li><a href='".base_url("anggota/blacklist")."'>BLACKLIST</a></li>
		</ul>
	</div>
	
	
	<div class='col s12 m12 l9'>
		<div class='formain'>
			<div class='formhead'>
				<h2 class='titmain'><b>ANGGOTA BARU</b></h2>
				<p>Pantau kedatangan anggota baru di toko anda !</p>
				<a href='javascript:void(0);' onclick=ctrlAnggotaJoinin.doDeletes('".$shop->id."') class='modal-trigger right'><b>Hapus semua</b></a><br>
			</div>
			<label id='notifJoinin'></label>
			<ul class='row formbody'>
";
if(sizeOf($joinins) <= 0){
	echo"Data tidak ditemukan";
}else{
	foreach($joinins as $joinin){
		$Status = "Ingin bergabung di toko anda";
		$Buttons = "<a href='#setting_harga' onclick=ctrlAnggotaJoinin.accept(".$joinin->id.") class='modal-trigger'><button class='waves-effect waves-light btn right'>Terima</button></a><button  onclick=ctrlAnggotaJoinin.doReject(".$joinin->id.") class='waves-effect waves-light btn red lighten-1 right'>Tolak</button>";
		
		if($joinin->status == 1){
			$Status = "<b class='text-green'>diterima</b> menjadi Anggota toko Anda";
			$Buttons = "<a class='waves-effect btn-flat right' onclick=ctrlAnggotaJoinin.doDelete(".$joinin->id.")><b class='text-red'><i class='mdi-av-not-interested left'></i>Hapus</b></a>";
		}elseif($joinin->status == 2){
			$Status = "<b class='text-red'>ditolak</b> menjadi Anggota toko Anda";
			$Buttons = "<a class='waves-effect btn-flat right' onclick=ctrlAnggotaJoinin.doDelete(".$joinin->id.")><b class='text-red'><i class='mdi-av-not-interested left'></i>Hapus</b></a>";
		}elseif($joinin->status == 3){
			$Status = "<b class='text-green'>menerima</b> undangan Anda untuk menjadi Anggota";
			$Buttons = "<a class='waves-effect btn-flat right' onclick=ctrlAnggotaJoinin.doDelete(".$joinin->id.")><b class='text-red'><i class='mdi-av-not-interested left'></i>Hapus</b></a>";
		}elseif($joinin->status == 4){
			$Status = "<b class='text-red'>menolak</b> undangan Anda untuk menjadi Anggota";
			$Buttons = "<a class='waves-effect btn-flat right' onclick=ctrlAnggotaJoinin.doDelete(".$joinin->id.")><b class='text-red'><i class='mdi-av-not-interested left'></i>Hapus</b></a>";
		}
		
		echo"
					<li class='col s12 listanggonew'>
						<div class='col s12 m8'><p><a href=''><b>".$joinin->member_name."</b></a> ".$Status."</p>
							<time>".$this->hs_datetime->getDate4String($joinin->create_date)." WIB</time>
						</div>
						<div class='col s12 m4' id='divButton".$joinin->id."'>
							".$Buttons."
						</div>
					</li>
		";
	}
}
echo"
				".$pagination."
			</ul>
		</div>
	</div>
	
	<div id='setting_harga' class='modal confirmation'>
		<div class='modal-header deep-orange'>
			<i class='mdi-action-spellcheck left'></i> Setting harga
		</div>
		<form id='formJoininLevel' class='modal-content'>
			<label id='notifJoininLevel'></label>
			<input name='id' type='hidden' value=''>
			<p>
				<div class='input-field col s12'>
					<select name='level' class='chosen-select'>
						<option value='' disabled selected>Choose your option</option>
						";
						if($shop->level_1_active == 1){
							echo "<option value='1'>".$shop->level_1_name."</option>";
						}
						if($shop->level_2_active == 1){
							echo "<option value='2'>".$shop->level_2_name."</option>";	
						}
						if($shop->level_3_active == 1){
							echo "<option value='3'>".$shop->level_3_name."</option>";
						}
						if($shop->level_4_active == 1){
							echo "<option value='4'>".$shop->level_4_name."</option>";
						}
						if($shop->level_5_active == 1){
							echo "<option value='5'>".$shop->level_5_name."</option>";
						}
					echo "</select>
				</div>
			</p>
		</form>
		<div class='modal-footer'>
			<a href='javascript:void(0);' id='aJoinLevelNo' class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
			<a href='javascript:void(0);' id='aJoinLevelYes' class=' modal-action modal-close waves-effect waves-red btn-flat'>YA</a>
		</div>
	</div>
	
	
	
	<script>
		var ctrlAnggotaJoinin = new CtrlAnggotaJoinin();
		ctrlAnggotaJoinin.init();
	</script>
";

?>