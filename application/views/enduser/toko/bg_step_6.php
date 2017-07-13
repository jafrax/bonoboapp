<?php

if($Shop->flag_information == 0){
	$Button = "<a href='".base_url("toko/step7")."' class='btn waves-effect waves-light red'><i class='mdi-navigation-chevron-left left'></i> Kembali</a>
			<a href='".base_url("produk/index/1")."' class='btn waves-effect waves-light'>Simpan<i class='mdi-navigation-chevron-right right'></i></a>";
}else{
	$Button = "<a href='".base_url("produk/index/1")."' class='btn waves-effect waves-light'>Simpan<i class='mdi-navigation-chevron-right right'></i></a>";
}


echo"
	<div class='col s12 m12 l12'>
		<form class='formain'>
			<div class='formhead'>
				<h2 class='titmain'><b>BANK</b></h2>
				<p>Masukkan data Bank Anda.</p>
			</div>
			<div class='row formbody'>
				<div class='input-field col s12 m12 linehead'>
					<button id='btnAddNew' data-target='popupFormAdd' class='btn waves-effect waves-light modal-trigger right' type='button'>
						<i class='mdi-content-add-circle-outline left'></i> Tambah baru
					</button>
					<label id='notifStep6'></label>
				</div>
";

foreach($ShopBanks as $ShopBank){
		
	echo"					
			<div class='col s12 m12 l12 linehead'>
				<blockquote>
					<h5 class='light'>".$ShopBank->bank_name."</h5>
					<h6 class='' ><b> a.n ".$ShopBank->acc_name."</b></h6>
					<h6 class='blue-text' >".$ShopBank->acc_no."</h6>
				</blockquote>
				<div class='right'>
					<button onclick=ctrlShopStep8.formEdit(".$ShopBank->id."); data-target='popupFormAdd' class='btn-floating waves-effect waves-light modal-trigger blue' type='button'>
						<i class='material-icons left'>launch</i>
					</button>
					<button onclick=ctrlShopStep8.doDelete(".$ShopBank->id."); class='btn-floating waves-effect waves-light red' type='button' name='action'>
						<i class='mdi-navigation-close left'></i>
					</button>
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
		<div class='modal-header deep-orange'>
			
		</div>
		<div class='modal-content'>								      
			<div class='col s12 m12 l12 nolmar nolpad'>
				<form id='formStep6Add'>
					<input type='hidden' name='txtId' value=''>
					<div class='row formbody nolmar nolpad' style='min-height:0;'>
						<div class='col m12 nolmar nolpad' id='iki-edit'>
							<div class='col s12 m12'><span>Nama Bank</span></div>
							<div id='divCmbBank' class='input-field col s12 m12'>
								<select name='cmbBank' class='select-standar' >
									<option value='' disabled selected>Bank BCA</option>
									<option value='' disabled selected>Bank Mandiri</option>
									<option value='' disabled selected>Bank BNI</option>
									<option value='' disabled selected>Bank BRI</option>
									<option value='' disabled selected>Bank BTN</option>
									<option value='' disabled selected>Bank Lainnya</option>
								</select>
							</div>
							<div class='input-field col s12 m12' id='bank-lain' style='display:none'>
								<span for='txtBank'>Nama Bank</span>
								<input id='txtBank' value='Bank ' name='txtBank' type='text' class='validate'>
								<input id='nama_default' type='hidden' name='nama_default' value='0'> 
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
			<button type='button' id='btnSave' class='modal-action waves-effect waves-green btn-flat '>Simpan</button>
			<a href='javascript:void(0);' onclick='window.location.reload()' class='modal-action modal-close waves-effect waves-red btn-flat '>Batal</a>
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