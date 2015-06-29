<?php

if($Shop->flag_information == 0){
	$Button = "<a href='".base_url("toko/")."' class='btn waves-effect waves-light red'><i class='mdi-navigation-chevron-left left'></i> Kembali</a><button class='btn waves-effect waves-light'>Selanjutnya<i class='mdi-navigation-chevron-right right'></i></button>";
}else{
	$Button = "<button class='btn waves-effect waves-light'>Simpan<i class='mdi-navigation-chevron-right right'></i></button>";
}

echo"
	<div class='col s12 m12 l12'>
		<form class='formain' method='POST' action='".base_url("toko/step2/")."'>
			<div class='formhead'>
				<h2 class='titmain'><b>ATUR PRIVASI</b></h2>
				<p>Anda dapat mengatur siapa saja yang dapat masuk ke jaringan toko Anda</p>
			</div>
			<div class='row formbody'>
				<div class='input-field col s12 m8'>
					<input id='rdgPrivate' name='rdgPrivation' value='1' type='radio' class='with-gap' ".($Shop->privacy == 1 ? "checked" : "").">
					<label for='rdgPrivate'>Toko Privat</label>
				</div>	
				<div class='input-field col s12 m8'>
					<p>Toko privat berarti, Anda harus melakukan konfirmasi untuk setiap pembeli yang ingin masuk ke jaringan Anda.</p>
				</div>

				<div class='input-field col s12 m8'>
					<input id='rdgPublic' name='rdgPrivation' value='0' type='radio' class='with-gap'  ".($Shop->privacy == 0 ? "checked" : "").">
					<label for='rdgPublic'>Toko Publik</label>
				</div>
				<div class='input-field col s12 m8'>
					<p>Toko publik berarti siapapun bisa masuk kedalam jaringan toko Anda, tanpa perlu konfirmasi dari Anda.</p>
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