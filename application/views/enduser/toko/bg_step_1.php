<?php

$ShopImage = base_url("assets/image/img_default_photo.jpg");
		
if(!empty($Shop->image) && file_exists("./assets/pic/shop/".$Shop->image)){
	$ShopImage = base_url("assets/pic/shop/resize/".$Shop->image);
}

if($Shop->flag_information == 0){
	$Button = "<button id='btnNext' class='btn waves-effect waves-light' type='button'>Selanjutnya<i class='mdi-navigation-chevron-right right'></i></button>";
}else{
	$Button = "<button id='btnSave' class='btn waves-effect waves-light' type='button'>Simpan<i class='mdi-navigation-chevron-right right'></i></button>";
}

echo"
	<div class='col s12 m12 l12'>
		<form id='formStep1' class='formain'>
			<div class='formhead'>
				<h2 class='titmain'><b>INFORMASI TOKO</b></h2>
			</div>
			<div class='row formbody'>
				<div class='linehead'>Informasi Umum</div>
				<div class='input-field col s12 m8'>
					<input id='txtName' name='txtName' type='text' class='validate' value='".$Shop->name."'>
					<label for='txtName'>Nama toko *</label>
					<label id='notifName' class='error' style='display:none;'></label>
				</div>
				<div class='input-field col s12 m8'>
					<input id='txtTagname' name='txtTagname' type='text' class='validate'  value='".$Shop->tag_name."'>
					<label for='txtTagname'>Toko Id *</label>
					<label id='notifTagname' class='error' style='display:none;'></label>
				</div>
				<div class='col s12 m6'>
					<label>Pilih kategori *</label>
					<div class='input-field'>
						<select name='cmbCategory'>
";

	if(!empty($Shop->category_name)){
		echo"<option value='".$Shop->category_id."' disabled selected>".$Shop->category_name."</option>";
	}else{
		echo"<option value='' disabled selected>Pilih Kategori</option>";
	}

	foreach($Categories as $Category){
		echo"<option value='".$Category->id."'>".$Category->name."</option>";
	}

echo"
						</select>
						<label id='notifCategory' class='error' style='display:none;'></label>
					</div>
				</div>
				<div class='input-field col s12 m8'>
					<input id='txtKeyword' name='txtKeyword' type='text' class='validate' value='".$Shop->keyword."'>
					<label for='txtKeyword'>Kata kunci pencarian</label>
				</div>
				<div class='input-field col s12 m8'>
					<textarea id='txtDescription' name='txtDescription' class='materialize-textarea' >".$Shop->description."</textarea>
					<label for='txtDescription'>Deskripsi toko</label>
				</div>
				<div class='input-field col s12 m8'>
					Logo Toko
					
					<div class='card div-circle-logo col s6 m4 l3'>
						<a class='delimg'><i class='mdi-content-backspace'></i></a>
						<div class='card-image waves-effect waves-block waves-light'>
							<img id='imgShopLogo' src='".$ShopImage."' class='circle-logo' style='cursor:pointer;'>
							<input id='txtShopLogoFile' type='file' style='display:none;'>
						</div>
					</div>
					
					
				</div>
			</div>
			<div class='row formbody'>
				<div class='linehead'>Alamat dan Kontak</div>
				<div class='input-field col s12 m8'>
					<input id='txtPhone' name='txtPhone' type='text' class='validate' value='".$Shop->phone."'>
					<label for='txtPhone'>Telephone</label>
				</div>
				<div class='input-field col s12 m8'>								
					Kontak Lainnya
					<div class='row valign-wrapper'>
						<div class='col s12 m3'>
							Nama kontak
						</div>
						<div class='col s12 m5'>
							<input id='kontak' type='text' class='validate'>
						</div>
						<div class='col s12 m3'>
							Pin/ID/Nomor
						</div>
						<div class='col s12 m5'>
							<input id='id' type='text' class='validate'>
						</div>
					</div>
					<div class='row valign-wrapper'>
						<div class='col s2 m2'>
							
						</div>
						<div class='col s10 m6'>
							<a href='#'>Tambah kontak</a>
						</div>
					</div>
				</div>
				<div class='input-field col s12 m8'>
					<input id='txtPostal' name='txtPostal' type='text' class='validate'  value='".$Shop->postal."'>
					<label for='txtPostal'>Kodepos</label>
				</div>
				<div class=' col s12 m8'>
					<label>Provinsi</label>
					<div id='divProvince' class='input-field'>
						<select name='cmbProvince' onChange=ctrlShopStep1.loadComboboxCity(); class=''>
";

	if(!empty($Shop->location_province)){
		echo"<option value='".$Shop->location_province."' disabled selected>".$Shop->location_province."</option>";
	}else{
		echo"<option value='' disabled selected>Pilih Provinsi</option>";
	}

	foreach($Provinces as $Province){
		echo"<option value='".$Province->province."'>".$Province->province."</option>";
	}
	
echo"
						</select>
						<label id='notifProvince' class='error' style='display:none;'></label>
					</div>
				</div>
				<div class=' col s12 m8'>
					<label>Kota</label>
					<div id='divCity' class='input-field'>
						<select name='cmbCity' onChange=ctrlShopStep1.loadComboboxKecamatan();>
";

	if(!empty($Shop->location_city)){
		echo"<option value='".$Shop->location_city."' disabled selected>".$Shop->location_city."</option>";
	}else{
		echo"<option value='' disabled selected>Pilih Kota</option>";
	}
	
	foreach($Cities as $City){
		echo"<option value='".$City->city."'>".$City->city."</option>";
	}
	
echo"
						</select>
						<label id='notifCity' class='error' style='display:none;'></label>
					</div>
				</div>
				<div class=' col s12 m8'>
					<label>Kecamatan</label>
					<div id='divKecamatan' class='input-field'>
						<select name='cmbKecamatan'>
";

	if(!empty($Shop->location_kecamatan)){
		echo"<option value='".$Shop->location_kecamatan."' disabled selected>".$Shop->location_kecamatan."</option>";
	}else{
		echo"<option value='' disabled selected>Pilih Kecamatan</option>";
	}
	
	foreach($Kecamatans as $Kecamatan){
		echo"<option value='".$Kecamatan->kecamatan."'>".$Kecamatan->kecamatan."</option>";
	}
	
echo"
						</select>
						<label id='notifKecamatan' class='error' style='display:none;'></label>
					</div>
				</div>
				<div class='input-field col s12 m8'>
					<textarea id='txtAddress' name='txtAddress' class='materialize-textarea' >".$Shop->address."</textarea>
					<label for='txtAddress'>Alamat toko</label>
				</div>
				<div class='input-field col s12 m8'>
					".$Button."
					<div id='notifStep1' style='display:none;'></div>
				</div>
			</div>
		</form>
	</div>
	
	<script>
		var ctrlShopStep1 = new CtrlShopStep1();
		ctrlShopStep1.init();
	</script>
";

?>