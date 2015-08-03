<?php

if($Shop->flag_information == 0){
	$Button = "<a href='".base_url("toko/step7")."' class='btn waves-effect waves-light red'><i class='mdi-navigation-chevron-left left'></i> Kembali</a><a href='".base_url("toko/complete_step")."' class='btn waves-effect waves-light'>Simpan<i class='mdi-navigation-chevron-right right'></i></a>";
}else{
	$Button = "<button class='btn waves-effect waves-light'>Simpan<i class='mdi-navigation-chevron-right right'></i></button>";
}

echo"
	<div class='col s12 m12 l12'>
		<form class='formain'>
			<div class='formhead'>
				<h2 class='titmain'><b>BANK</b></h2>
				<p>Masukkan data Bank Anda.</p>
			</div>
			<div class='row formbody'>
				<div class='input-field col s12 m12'>
					<button id='btnAddNew' data-target='popupFormAdd' class='btn waves-effect waves-light modal-trigger' type='button'>
						<i class='mdi-content-add-circle-outline left'></i> Tambah baru
					</button>
					<label id='notifStep6'></label>
				</div>
";

foreach($ShopBanks as $ShopBank){
	$BankImage = base_url("assets/image/img_default_photo.jpg");
	
	if(!empty($ShopBank->bank_image) && file_exists("./assets/pic/bank/".$ShopBank->bank_image)){
		$BankImage = base_url("assets/pic/user/resize/".$ShopBank->bank_image);
	}
		
	echo"
				<div class='col s12 m8 l4'>
					<div class='card-panel grey lighten-5 z-depth-1 boderrander'>
						<div class='row '>
							<div class='col s12 m6 l4'>
								<img src='".$BankImage."' alt='' class='circle responsive-img'>
							</div>
							<div class='col s12 m6 l8'>
								<blockquote>
									<h5>".$ShopBank->bank_name."</h5>
									<h6> a.n ".$ShopBank->acc_name."</h6>
									<h6>".$ShopBank->acc_no."</h6>
								</blockquote>
								<div class='input-field col s12 m12'>
									<button onclick=ctrlShopStep8.formEdit(".$ShopBank->id."); data-target='popupFormAdd' class='btn-flat waves-effect waves-light modal-trigger' type='button'>
										<i class='mdi-editor-border-color'></i>
									</button>
									<button onclick=ctrlShopStep8.doDelete(".$ShopBank->id."); class='btn-flat waves-effect waves-light' type='button' name='action'>
										<i class='mdi-action-delete'></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				
	";
}

echo"

				<div class='input-field col s12 m12'><p><br></p></div>
				<div class='input-field col s12 m12'>
					".$Button."
				</div>	
			</div>
		</form>
	</div>
	
	
	<!-- Modal Structure -->
	<div id='popupFormAdd' class='modal modal-fixed-footer'>
		<div class='modal-header red'>
			
		</div>
		<div class='modal-content'>								      
			<div class='col s12 m12 l12'>
				<form id='formStep6Add'>
					<input type='hidden' name='txtId' value=''>
					<div class='row formbody'>
						<div class='col m12'>
							<div class='input-field col s12 m12'>							
								Nama Bank								
							</div>
							<div id='divCmbBank' class='input-field col s12 m12'>																
								<select name='cmbBank' class='select-standar'>
									<option value='' disabled selected>Pilih Bank</option>
";
	
	foreach($Banks as $Bank){
		echo"	
			<option value='".$Bank->id."'>".$Bank->name."</option>
		";
	}
	
echo"
								</select>																
							</div>
							<div class='input-field col s12 m12'>
								<span for='txtName'>Nama Pemilik Rekening</span>
								<input id='txtName' name='txtName' type='text' class='validate'>
							</div>
							<div class='input-field col s12 m12'>
								<span for='txtNo'>Nomor Rekening</span>
								<input id='txtNo' name='txtNo' type='text' class='validate numbersOnly' maxlength='20'>
							</div>															
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class='modal-footer'>
			<a href='javascript:void(0);' id='btnSave' class='modal-action modal-close waves-effect waves-green btn-flat '>Simpan</a>
			<a href='javascript:void(0);' class='modal-action modal-close waves-effect waves-red btn-flat '>Batal</a>
		</div>
	</div>
";

echo"
	<script>
		var ctrlShopStep8 = new CtrlShopStep8();
		ctrlShopStep8.init();
	</script>
";

?>