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
					<input id='txtName' name='txtName' type='text' placeholder='Ex : PT Bonobo Indonesia' class='validate' value='".$Shop->name."' autofocus>
					<label for='txtName'>Nama toko *</label>
					<label id='notifName' class='error' style='display:none;'></label>
				</div>
				<div class='input-field col s12 m8'>
					<input id='txtTagname' name='txtTagname' type='text' placeholder='Ex : ptbonobo' class='validate'  value='".$Shop->tag_name."'>
					<label for='txtTagname'>Toko Id *</label>
					<label id='notifTagname' class='error' style='display:none;'></label>
				</div>
				<div class='col s12 m8' style='display:none;'>
					<label>Pilih kategori *</label>
					<label id='notifCategory' class='error error-chosen' style='display:none;'></label>
					<div class='input-field' >
						<select name='cmbCategory' class='chosen-select' class='chosen-select'>
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
					<textarea id='txtDescription' name='txtDescription' placeholder='Ex : Bonobo adalah platform Bisnis Online yang aman' class='materialize-textarea' >".$Shop->description."</textarea>
					<label for='txtDescription'>Deskripsi toko</label>
				</div>
				<div class='input-field col s12 m8'>
					<label class='left'>Logo Toko</label><br>
					
					<div class='card div-circle-logo col s6 m4 l3 nolpad'>
						<a id='aShopLogoDelete' class='delimg'><i class='mdi-navigation-close right'></i></a>
						<div class='card-image waves-effect waves-block waves-light'>
							<img id='imgShopLogo' src='".$ShopImage."' class='responsive-img circle-logo' style='cursor:pointer; width:100%;'>
							<input id='txtShopLogoFile' name='txtShopLogoFile' type='file' style='display:none;'>
						</div>
					</div>
				</div>
				<div class='input-field col s12 m8'>
					<i class='grey-text'><b>Ukuran Maks</b> : 1 MB.</i><br>
					<i class='grey-text'><b>Format</b> : .bmp, .jpg, .png.</i>
				</div>
			</div>
			<div class='row formbody'>
				<div class='linehead'>Kontak dan Alamat</div>
				<div class='input-field col s12 m8'>
					<input id='txtPhone' name='txtPhone' placeholder='Ex : 0271-987654' type='text' class='validate' value='".$Shop->phone."'>
					<label for='txtPhone'>Telephone</label>
				</div>
				<div class='input-field col s12 m8'>								
					Kontak Lainnya
					
					<div id='divAttributes'>
";

if(sizeOf($Attributes) <= 0){
	echo"
		<input type='hidden' id='intAttributeCount' name='intAttributeCount' value='1'>
		<div class='row valign-wrapper counter attr-1'>
			<div class='col s12 m3'>
				Nama kontak
			</div>
			<div class='col s12 m5'>
				<input name='txtAttributeId1' type='hidden' value=''>
				<input name='txtAttributeName1' placeholder='BBM/whatsapp/Line' type='text' class='validate'>
			</div>
			<div class='col s12 m3'>
				Pin/ID/Nomor
			</div>
			<div class='col s12 m5'>
				<input name='txtAttributeValue1' placeholder='Ex : AD9876/bonoboLine' type='text' class='validate'>
			</div>
		</div>
	";
}else{
	echo"<input type='hidden' id='intAttributeCount' name='intAttributeCount' value='".sizeOf($Attributes)."'>";
	
	$no = 1;
	foreach($Attributes as $Attribute){
		echo"
			<div class='row valign-wrapper counter attr-".$no."'>
				<div class='col s12 m3'>
					Nama kontak
				</div>
				<div class='col s12 m5'>
					<input name='txtAttributeId".$no."' id='txtAttributeId".$no."' type='hidden' value='".$Attribute->id."'>
					<input name='txtAttributeName".$no."' placeholder='BBM/whatsapp/Line' type='text' class='validate' value='".$Attribute->name."'>
				</div>
				<div class='col s12 m3'>
					Pin/ID/Nomor
				</div>
				<div class='col s12 m5'>
					<input name='txtAttributeValue".$no."' placeholder='Ex : AD9876/bonoboLine' type='text' class='validate' value='".$Attribute->value."'>
				</div>
				<div class='col s12 m5'>
					<a class='btn-floating btn-xs waves-effect waves-light red right' onclick=javascript:deletestep1(".$no.",".$Attribute->id.")>
						<i class='mdi-navigation-close'></i>
					</a>
				</div>
			</div>
		";
		$no++;
	}
}

echo"
					</div>
					<div class='row valign-wrapper counter'>
						<div class='col s2 m2'>
							
						</div>";
						if (sizeOf($Attributes) < 3) {
							echo "
								<div class='col s10 m6'>
									<a href='javascript:void(0);' id='aAttributeAdd'>[+] Tambah kontak</a>
								</div>
							";
						}
						echo "
					</div>
				</div>
				<div class='input-field col s12 m8'>
					<input id='txtPostal' name='txtPostal' type='text' placeholder='Ex : 15122' class='validate'  value='".$Shop->postal."' onChange=ctrlShopStep1.loadComboboxProv();>
					<label for='txtPostal'>Kodepos</label>
				</div>
				<div class=' col s12 m8'>
					<label>Provinsi</label>
					<label id='notifProvince' class='error error-chosen' style='display:none;'></label>
					<div id='divProvince' class='input-field'>
						<select name='cmbProvince' class='chosen-select' onChange=ctrlShopStep1.loadComboboxCity();>
							<option disabled>Pilih propinsi</option>";								

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
						<select name='cmbCity' class='chosen-select' onChange=ctrlShopStep1.loadComboboxKecamatan();>
							<option disabled>Pilih kota</option>";

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
						<select name='cmbKecamatan' class='chosen-select'>
							<option disabled>Pilih kecamatan</option>";

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
					<textarea id='txtAddress' name='txtAddress' placeholder='Ex : Jl. Raya Bonobo no.1' class='materialize-textarea' >".$Shop->address."</textarea>
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