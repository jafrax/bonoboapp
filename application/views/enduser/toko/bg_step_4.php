<?php

if($Shop->flag_information == 0){
	$Button = "<a href='".base_url("toko/step3")."' class='btn waves-effect waves-light red'> <i class='mdi-navigation-chevron-left left'></i> Kembali</a>
			 <button id='btnSave' class='btn waves-effect waves-light' type='button'>Lanjut<i class='mdi-navigation-chevron-right right'></i></button>";
}else{
	$Button = "<button id='btnSave' class='btn waves-effect waves-light' type='button'>Simpan <i class='mdi-navigation-chevron-right right'></i></button>";
}

echo"
	<div class='col s12 m12 l12'>
		<form id='formstep4' class='formain' method='POST' >
			<input type='hidden' name='submit' value='submited'/>
			<div class='formhead'>
				<h2 class='titmain'><b>METODE TRANSAKSI</b></h2>
				<p>Metode transaksi yang sesuai dengan kebutuhan dan kenyamanan Anda.</p>
			</div>
			<div class='row formbody'>
				<div class='input-field col s12 m8'>
					<input type='checkbox' name='chkPaymentCash' class='filled-in' id='bayar-di-tempat' ".($Shop->pm_store_payment == 1 ? "checked" : "")." /> 
					<label for='bayar-di-tempat'>Bayar di tempat</label>
					<!-- <input type='checkbox' name='chkPaymentCash2' class='filled-in' value='".$Shop->pm_store_payment."' id='bayar-di-tempat' ".($Shop->pm_store_payment == 1 ? "checked" : "")." /> -->
				</div>
				<div class='input-field col s12 m8'>
					<p>Pembeli akan datang langsung ke toko Anda untuk melunasi pembayaran.
					</p>
				</div>
				<div class='input-field col s12 m8'>
					<input type='checkbox' name='chkPaymentTransfer' class='filled-in' id='via-bank' ".($Shop->pm_transfer == 1 ? "checked" : "")." />
					<label for='via-bank'>Transfer via Bank</label>
					<input type='checkbox' name='chkPaymentTransfer2' class='filled-in' value='".$Shop->pm_store_payment."' id='via-bank' ".($Shop->pm_transfer == 1 ? "checked" : "")." />
				</div>	
				<div class='input-field col s12 m8'>
					<p>Transfer via Bank yang di dukung oleh Anda.
					</p>
				</div>
				<div class='input-field col s12 m8'>
				</div>
				<div class='input-field col s12 m8'>
					".$Button."
				<label id='notifStep4' style='display:none;'></label>	
				</div>
				
			</div>
		</form>
	</div>
";
echo"
	<script>
		var ctrlShopStep4 = new CtrlShopStep4();
		ctrlShopStep4.init();
	</script>
";

?>