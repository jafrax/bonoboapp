<?php

echo"
	<form id='formStep5Rate' class='modal-content'>
		<input type='hidden' name='txtRateId' value='".(empty($Rate) ? "" : $Rate->id != null ? $Rate->id : "")."'>
				<div class='col m12'>
				<div class='input-field col s12 m4'>							
					Provinsi								
				</div>
				<div id='divProvince' class='input-field col s12 m8'>
					<p>
						<select name='cmbProvince' id='cmbProvince' onChange=ctrlShopStep7.loadComboboxCity(); class='selectize'>
";

	if(!empty($Rate)){
		echo"<option value='".$Rate->location_to_province."' selected>".$Rate->location_to_province."</option>";
	}else{
		echo"<option value='' disabled selected>Pilih Provinsi</option>";
	}

	foreach($Provinces as $Province){
		echo"<option value='".$Province->province."'>".$Province->province."</option>";
	}
	
echo"
						</select>
						<label class='error error-chosen' for='cmbProvince'></label>
					</p>
				</div>
				<div class='input-field col s12 m4'>							
					Kota  <img width='16px' id='loader-kota' style='display:none' src='".base_url()."html/images/comp/loading.GIF' />
				</div>
				<div id='divCity' class='input-field col s12 m8'>
					<p>
						<select name='cmbCity' id='cmbCity' onChange=ctrlShopStep7.loadComboboxKecamatan(); class='selectize'>
";

	if(!empty($Rate)){
		echo"<option value='".$Rate->location_to_city."' selected>".$Rate->location_to_city."</option>";
	}else{
		echo"<option value='' disabled selected>Pilih Kota</option>";
	}
	
	foreach($Cities as $City){
		echo"<option value='".$City->city."'>".$City->city."</option>";
	}
	
echo"
						</select>
						<label class='error error-chosen' for='cmbCity'></label>
					</p>
				</div>
				<div class='input-field col s12 m4'>							
					Kecamatan  <img width='16px' id='loader-kec' style='display:none' src='".base_url()."html/images/comp/loading.GIF' />
				</div>
				<div id='divKecamatan' class='input-field col s4 m8'>
					<p>
						<select name='cmbKecamatan' id='cmbKecamatan' class='selectize'>
";

	if(!empty($Rate)){
		echo"<option value='".$Rate->location_to_kecamatan."' selected>".$Rate->location_to_kecamatan."</option>";
	}else{
		echo"<option value='' disabled selected>Pilih Kecamatan</option>";
	}
	
	foreach($Kecamatans as $Kecamatan){
		echo"<option value='".$Kecamatan->kecamatan."'>".$Kecamatan->kecamatan."</option>";
	}
	
echo"
						</select>
						<label class='error error-chosen' for='cmbKecamatan'></label>
					</p>
				</div>
				<div class='input-field col s12 m4'>							
					Ongkos Kirim per Kg
				</div>
				<div class='input-field col s12 m8'>
					<p>
						<input name='txtRatePrice' type='text' class='validate price' maxlength='18' value='".(empty($Rate) ? "" : $Rate->id != null ? $Rate->price : "")."'>										
					</p>
				</div>
			</div>
	</form>
	
	<style>
		.chosen-results{ max-height:100px!important; }
	</style>
	
";
echo"<script>
$(document).ready(function() {
		/*NUMBER FORMAT*/
	$('input.price').priceFormat({	    
	    limit: 12,
    	centsLimit: 0,
		centsSeparator: '',
    	thousandsSeparator: '.',
    	prefix: 'Rp. ',
	});
	/*NUMBER FORMAT*/
});
</script>";
?>