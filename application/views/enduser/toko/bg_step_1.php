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
		<form id='formStep1' class='formain' enctype='multipart/form-data'>
			<div class='formhead'>
				<h2 class='titmain'><b>INFORMASI TOKO</b></h2>
			</div>
			<div class='row formbody '>
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
				<div class='col s12 m8'>
					<label>Pilih kategori *</label>
					<label id='notifCategory' class='error error-chosen' style='display:none;'></label>
					<div class='input-field'>
						<select name='cmbCategory'>
";

	if(!empty($Shop->category_name)){
		echo"<option value='".$Shop->category_id."' selected>".$Shop->category_name."</option>";
	}else{
		echo"<option value='' disabled selected>Pilih Kategori</option>";
	}

	foreach($Categories as $Category){
		echo"<option value='".$Category->id."'>".$Category->name."</option>";
	}

echo"
						</select>
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
					<label class='left'>Logo Toko</label><br>
					
					<div class='card div-circle-logo col s6 m4 l3 nolpad'>
						<a id='aShopLogoDelete' class='delimg'><i class='mdi-content-backspace'></i></a>
						<div class='card-image waves-effect waves-block waves-light'>
							<img id='imgShopLogo' src='".$ShopImage."' class='responsive-img' style='cursor:pointer; width:100%;'>
							<input id='txtShopLogoFile' name='txtShopLogoFile' type='file' style='display:none;'>
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
					
					<div id='divAttributes'>
";

if(sizeOf($Attributes) <= 0){
	echo"
		<input type='hidden' id='intAttributeCount' name='intAttributeCount' value='1'>
		<div class='row valign-wrapper'>
			<div class='col s12 m3'>
				Nama kontak
			</div>
			<div class='col s12 m5'>
				<input name='txtAttributeId1' type='hidden' value=''>
				<input name='txtAttributeName1' type='text' class='validate'>
			</div>
			<div class='col s12 m3'>
				Pin/ID/Nomor
			</div>
			<div class='col s12 m5'>
				<input name='txtAttributeValue1' type='text' class='validate'>
			</div>
		</div>
	";
}else{
	echo"<input type='hidden' id='intAttributeCount' name='intAttributeCount' value='".sizeOf($Attributes)."'>";
	
	$no = 1;
	foreach($Attributes as $Attribute){
		echo"
			<div class='row valign-wrapper'>
				<div class='col s12 m3'>
					Nama kontak
				</div>
				<div class='col s12 m5'>
					<input name='txtAttributeId".$no."' type='hidden' value='".$Attribute->id."'>
					<input name='txtAttributeName".$no."' type='text' class='validate' value='".$Attribute->name."'>
				</div>
				<div class='col s12 m3'>
					Pin/ID/Nomor
				</div>
				<div class='col s12 m5'>
					<input name='txtAttributeValue".$no."' type='text' class='validate' value='".$Attribute->value."'>
				</div>
			</div>
		";
		$no++;
	}
}

echo"
					</div>
					<div class='row valign-wrapper'>
						<div class='col s2 m2'>
							
						</div>
						<div class='col s10 m6'>
							<a href='javascript:void(0);' id='aAttributeAdd'>Tambah kontak</a>
						</div>
					</div>
				</div>
				<div class='input-field col s12 m8'>
					<input id='txtPostal' name='txtPostal' type='text' class='validate'  value='".$Shop->postal."'>
					<label for='txtPostal'>Kodepos</label>
				</div>
				<div class=' col s12 m8'>
					<label>Provinsi</label>
					<label id='notifProvince' class='error error-chosen' style='display:none;'></label>
					<div id='divProvince' class='input-field'>
						<select name='cmbProvince' onChange=ctrlShopStep1.loadComboboxCity();>
";

	if(!empty($Shop->location_province)){
		echo"<option value='".$Shop->location_province."' selected>".$Shop->location_province."</option>";
	}else{
		echo"<option value='' disabled selected>Pilih Provinsi</option>";
	}

	foreach($Provinces as $Province){
		echo"<option value='".$Province->province."'>".$Province->province."</option>";
	}
	
echo"
						</select>
					</div>
				</div>
				<div class=' col s12 m8'>
					<label>Kota</label>
					<label id='notifCity' class='error error-chosen' style='display:none;'></label>
					<div id='divCity' class='input-field'>
						<select name='cmbCity' onChange=ctrlShopStep1.loadComboboxKecamatan();>
";

	if(!empty($Shop->location_city)){
		echo"<option value='".$Shop->location_city."' selected>".$Shop->location_city."</option>";
	}else{
		echo"<option value='' disabled selected>Pilih Kota</option>";
	}
	
	foreach($Cities as $City){
		echo"<option value='".$City->city."'>".$City->city."</option>";
	}
	
echo"
						</select>
					</div>
				</div>
				<div class=' col s12 m8'>
					<label>Kecamatan</label>
					<label id='notifKecamatan' class='error error-chosen' style='display:none;'></label>
					<div id='divKecamatan' class='input-field'>
						<select name='cmbKecamatan'>
";

	if(!empty($Shop->location_kecamatan)){
		echo"<option value='".$Shop->location_kecamatan."' selected>".$Shop->location_kecamatan."</option>";
	}else{
		echo"<option value='' disabled selected>Pilih Kecamatan</option>";
	}
	
	foreach($Kecamatans as $Kecamatan){
		echo"<option value='".$Kecamatan->kecamatan."'>".$Kecamatan->kecamatan."</option>";
	}
	
echo"
						</select>
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