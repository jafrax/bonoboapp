<?php

echo"
	<form id='formStep5Rate' class='modal-content'>
		<input type='hidden' name='txtRateId' value=''>
		<div class='row formbody'>
			<div class='col m12'>
				<div class='input-field col s12 m4'>							
					Provinsi								
				</div>
				<div id='divProvince' class='input-field col s12 m8'>
					<p>
						<select name='cmbProvince' onChange=ctrlShopStep5.loadComboboxCity(); class='chzn-select'>
";

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
						<select name='cmbCity' onChange=ctrlShopStep5.loadComboboxKecamatan(); class='chzn-select'>
";

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
						<input name='txtRatePrice' type='text' class='validate'>										
					</p>
				</div>
			</div>
		</div>
	</form>
	
";

?>