<?php

if($Shop->flag_information == 0){
	$Button = "<a href='".base_url("toko/step3")."' class='btn waves-effect waves-light red'><i class='mdi-navigation-chevron-left left'></i> Kembali</a><button class='btn waves-effect waves-light'>Selanjutnya<i class='mdi-navigation-chevron-right right'></i></button>";
}else{
	$Button = "<button class='btn waves-effect waves-light'>Simpan<i class='mdi-navigation-chevron-right right'></i></button>";
}

echo"
	<div class='col s12 m12 l12'>
		<form class='formain' method='POST' action='".base_url("toko/step4/")."'>
			<input type='hidden' name='submit' value='submited'/>
			<div class='formhead'>
				<h2 class='titmain'><b>METODE TRANSAKSI</b></h2>
				<p>Metode transaksi yang sesuai dengan kebutuhan dan kenyamanan Anda.</p>
			</div>
			<div class='row formbody'>
				<div class='input-field col s12 m8'>
					<input type='checkbox' name='chkPaymentCash' class='filled-in' id='bayar-di-tempat' ".($Shop->pm_store_payment == 1 ? "checked" : "")." />
					<label for='bayar-di-tempat'>Bayar di tempat</label>
				</div>
				<div class='input-field col s12 m8'>
					<p>Pembeli akan datang langsung ke toko Anda untuk melunasi pembayaran.
					</p>
				</div>
				<div class='input-field col s12 m8'>
					<input type='checkbox' name='chkPaymentTransfer' class='filled-in' id='via-bank' ".($Shop->pm_transfer == 1 ? "checked" : "")." />
					<label for='via-bank'>Transfer via Bank</label>
				</div>	
				<div class='input-field col s12 m8'>
					<p>Transfer via Bank yang di dukung oleh Anda.
					</p>
				</div>
				<div class='input-field col s12 m8'>
				</div>
				<div class='input-field col s12 m8'>
					".$Button."
				</div>					
			</div>
		</form>
	</div>
";

?>