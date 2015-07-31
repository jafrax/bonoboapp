<?php

echo"
	<form id='formStep5Rate' class='modal-content'>
		<input type='hidden' name='txtRateId' value='".(empty($Rate) ? "" : $Rate->id != null ? $Rate->id : "")."'>
		<div class='row formbody'>
			<div class='col m12'>
				<div class='input-field col s12 m4'>							
					Provinsi								
				</div>
				<div id='divProvince' class='input-field col s12 m8'>
					<p>
						<select name='cmbProvince' onChange=ctrlShopStep7.loadComboboxCity(); class='chzn-select'>
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
					</p>
				</div>
				<div class='input-field col s12 m4'>							
					Kota								
				</div>
				<div id='divCity' class='input-field col s12 m8'>
					<p>
						<select name='cmbCity' onChange=ctrlShopStep7.loadComboboxKecamatan(); class='chzn-select'>
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
					</p>
				</div>
				<div class='input-field col s12 m4'>							
					Kecamatan								
				</div>
				<div id='divKecamatan' class='input-field col s12 m8'>
					<p>
						<select name='cmbKecamatan' class='chzn-select'>
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
					</p>
				</div>
				<div class='input-field col s12 m4'>							
					Ongkos Kirim								
				</div>
				<div class='input-field col s12 m8'>
					<p>
						<input name='txtRatePrice' type='text' class='validate price' maxlength='18 value='".(empty($Rate) ? "" : $Rate->id != null ? $Rate->price : "")."'>										
					</p>
				</div>
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
	    limit: 18,
    	centsLimit: 2,
		centsSeparator: ',',
    	thousandsSeparator: '.',
    	prefix: 'Rp. ',
	});
	/*NUMBER FORMAT*/
});
</script>";
?>