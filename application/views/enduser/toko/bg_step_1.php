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
					<input id='txtName' name='txtName' type='text' placeholder=' PT Bonobo Indonesia' class='validate' value='".$Shop->name."' autofocus>
					<label for='txtName'>Nama toko *</label>
					<label id='notifName' class='error' style='display:none;'></label>
				</div>
				<div class='input-field col s12 m8'>
					<input id='txtTagname' name='txtTagname' maxlength='5'  type='text' placeholder=' ptbonobo' class='validate emailLow'  value='".$Shop->tag_name."'>
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
					<textarea id='txtDescription' name='txtDescription' placeholder=' Bonobo adalah platform Bisnis Online yang aman' class='materialize-textarea' >".$Shop->description."</textarea>
					<label for='txtDescription'>Deskripsi toko</label>
				</div>
				<div class='input-field col s12 m8'>
					<label class='left'>Logo Toko</label><br>
					
					<div class='card div-circle-logo col s6 m4 l2 nolpad'>
						<a id='aShopLogoDelete' class='delimg'><i class='mdi-navigation-close right'></i></a>
						<div class='card-image waves-effect waves-block waves-light'>
							<img id='imgShopLogo' src='".$ShopImage."' class='responsive-img circle-logo' style='cursor:pointer; width:100%;height: auto;'>
							<input id='txtShopLogoFile' name='txtShopLogoFile' type='file' style='display:none;height: auto;' data-type='image' class='txtShopLogoFile'>
							<span id='untukgambar' style='color:red;'></span>
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
					<input id='txtPhone' name='txtPhone' placeholder=' 0271987654' type='text' class='validate numbersOnly' maxlength='15' value='".$Shop->phone."'>
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
				<!--Nama kontak--!>
			</div>
			<div class='col s12 m5'>
				<input name='txtAttributeId1' type='hidden' value=''>
				<input name='txtAttributeName1' placeholder='BBM/whatsapp/Line' type='text' class='validate'>
			</div>
			<div class='col s12 m1'>
				<!--Pin/ID/Nomor--!> =
			</div>
			<div class='col s12 m5'>
				<input name='txtAttributeValue1' placeholder=' AD9876/bonoboLine' type='text' class='validate'>
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
					<!--Nama kontak--!>
				</div>
				<div class='col s12 m5'>
					<input name='txtAttributeId".$no."' id='txtAttributeId".$no."' type='hidden' value='".$Attribute->id."'>
					<input name='txtAttributeName".$no."' placeholder='BBM/whatsapp/Line' type='text' class='validate' value='".$Attribute->name."'>
				</div>
				<div class='col s12 m1'>
					<!--Pin/ID/Nomor--!> =
				</div>
				<div class='col s12 m5'>
					<input name='txtAttributeValue".$no."' placeholder=' AD9876/bonoboLine' type='text' class='validate' value='".$Attribute->value."'>
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
						}else{
							echo "
								<div class='col s10 m6' style='display:none'>
									<a href='javascript:void(0);' id='aAttributeAdd'>[+] Tambah kontak</a>
								</div>
							";
						}
						echo "
					</div>
				</div>
				<div class=' col s12 m8'>
					<label>Provinsi</label>
					<label id='notifProvince' class='error error-chosen' style='display:none;'></label>
					<div id='panggon-province' class='input-field'>";
					echo "<select  class='chosen-select cmbProvince' name='cmbProvince' id='province' onchange=javascript:set_city()>
							<option value='' disabled selected>Pilih Provinsi</option>";
							if ($Shopp->num_rows() > 0) {
								foreach($Shopp->result() as $row_x){
										$provinsi = $this->model_nota->get_province();
										foreach ($provinsi->result() as $row_p) {
											echo "<option value='".$row_p->province."' ".($row_p->province == $row_x->province ? "selected='selected'" : "")." >".$row_p->province."</option>";
										}	
									}
							} else {
								$provinsi = $this->model_nota->get_province();
										foreach ($provinsi->result() as $row_p) {
											echo "<option value='".$row_p->province."' ".($row_p->province == $row_x->province ? "selected='selected'" : "")." >".$row_p->province."</option>";
										}
							}		
						echo" 
						</select>";
						echo "
					</div>
				</div>
				<div class=' col s12 m8'>
					<label>Kota</label>
					<label id='notifCity' class='error error-chosen' style='display:none;'></label>
					<div id='panggon-city' class='input-field'>";
					echo "	<select  class='chosen-select cmbCity' name='cmbCity' id='city' onchange=javascript:set_kecamatan()>
												<option value='' disabled selected>Pilih Kota</option>	";
												
							if ($Shopp->num_rows() > 0) {
								foreach($Shopp->result() as $row_x){
												$kota = $this->model_toko->get_kota($row_x->province);
												foreach ($kota->result() as $row_p) {
													echo "<option value='".$row_p->city."' ".($row_p->city == $row_x->city ? "selected='selected'" : "")." >".$row_p->city."</option>";
												}				
								}
							}else{
								$kota = $this->model_toko->get_allkota();
								foreach ($kota->result() as $row_k) {
									echo "<option value='".$row_k->city."'>".$row_k->city."</option>";
								}	
							}
							echo"</select>";
							echo"
					</div>
				</div>
				<div class=' col s12 m8'>
					<label>Kecamatan</label>
					<label id='notifKecamatan' class='error error-chosen' style='display:none;'></label>
					<div id='panggon-kecamatan' class='input-field'>";
						echo "<select  class='chosen-select cmbKecamatan' name='cmbKecamatan' id='kecamatan'  >
							<option value='' disabled selected>Pilih Kecamatan</option>";
							if ($Shopp->num_rows() > 0) {
								foreach($Shopp->result() as $row_x){
									$kecamatan = $this->model_toko->get_kecamatan($row_x->city);
									foreach ($kecamatan->result() as $row_p) {
										echo "<option value='".$row_p->kecamatan."' ".($row_p->kecamatan == $row_x->kecamatan ? "selected='selected'" : "")." >".$row_p->kecamatan."</option>";
									}
								}	
							} else {
								$kecamatan = $this->model_toko->get_allkecamatan();
								foreach ($kecamatan->result() as $row_c) {
									echo "<option value='".$row_c->kecamatan."'>".$row_c->kecamatan."</option>";
								}
							}
							echo"
						</select>";
						echo "
					</div>
				</div>
				<div class='ui-widget input-field col s12 m8'>
					<label for='tags' class=''>Kodepos</label>		
					<input  id='postal-code' name='txtPostal' type='text' class='validate pos' value='".$Shop->postal."' autocoplate='off'>
					
				</div>
				<div class='input-field col s12 m8'>
					<textarea id='txtAddress' name='txtAddress' placeholder=' Jl. Raya Bonobo no.1' class='materialize-textarea' >".$Shop->address."</textarea>
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