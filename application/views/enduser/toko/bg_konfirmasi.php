<?php
if($Shop->flag_information == 0){
	$Button = "<a href='".base_url("toko/step5")."' class='btn waves-effect waves-light red'><i class='mdi-navigation-chevron-left left'></i> Kembali</a><button type='submit' class='btn waves-effect waves-light'>Selanjutnya<i class='mdi-navigation-chevron-right right'></i></button>";
}else{
	$Button = "<button type='submit' class='btn waves-effect waves-light'>Simpan<i class='mdi-navigation-chevron-right right'></i></button>";
}

echo "
<div class='col s12 m12 l12'>
					<form class='formain' action='' method='post'>
						<div class='formhead'>
							<h2 class='titmain'><b>METODE KONFIRMASI</b></h2>
							<p>Anda dapat mengatur metode konfirmasi pembayaran yang anda inginkan.</p>
						</div>
						<div class='row formbody'>
							<div class='input-field col s12 m8'>
								<input id='publik' name='kofirmasi' value='0' type='radio' class='with-gap' checked>
								<label for='publik'>menggunakan 3 digit terakhir dari nomor nota anda.</label>
							</div>
							<div class='input-field col s12 m8'>
								<p>
									- 3 digit terakhir dari nomor nota akan ditambahkan ke total tagihan pembeli sebagai kode unik.<br>
									- Cara ini memudahkan pembeli karena pembeli tidak perlu melakukan konfirmasi pembayaran melalui Apps.<br>
								</p>
							</div>
							<div class='input-field col s12 m8'>
								<input id='privasi' name='kofirmasi' value='1' type='radio' class='with-gap'>
								<label for='privasi'>Melakukan konfirmasi pembayaran via Bonobo Apps</label>
							</div>	
							<div class='input-field col s12 m8'>
								<p>
									- Pembeli perlu melakukan konfirmasi pembayaran melalui Bonobo Apps (Android).<br>
									- Toko bisa melakukan pengecekan pembayaran berdasarkan rekening pembeli.<br>
									- Tidak ada penambahan kode unik di total tagihan pembeli.<br>
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