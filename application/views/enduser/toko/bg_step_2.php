<?php

echo"
	<div class='col s12 m12 l12'>
		<form class='formain'>
			<div class='formhead'>
				<h2 class='titmain'><b>ATUR PRIVASI</b></h2>
				<p>Anda dapat mengatur siapa saja yang dapat masuk ke jaringan toko Anda</p>
			</div>
			<div class='row formbody'>
				<div class='input-field col s12 m8'>
					<input id='privasi' name='group1' type='radio' class='with-gap'>
					<label for='privasi'>Toko Privat</label>
				</div>	
				<div class='input-field col s12 m8'>
					<p>Toko privat berarti, Anda harus melakukan konfirmasi untuk setiap pembeli yang ingin masuk ke jaringan Anda.</p>
				</div>

				<div class='input-field col s12 m8'>
					<input id='publik' name='group1' type='radio' class='with-gap' checked>
					<label for='publik'>Toko Publik</label>
				</div>
				<div class='input-field col s12 m8'>
					<p>Toko publik berarti siapapun bisa masuk kedalam jaringan toko Anda, tanpa perlu konfirmasi dari Anda.</p>
				</div>
				
				<div class='input-field col s12 m8'>
				</div>
				<div class='input-field col s12 m8'>
					<button class='btn waves-effect waves-light red' type='button' onclick='location.href='toko_informasi.html'' name='action'>
						<i class='mdi-navigation-chevron-left left'></i> Kembali
					</button>
					<button class='btn waves-effect waves-light' type='button' onclick='location.href='atur_pengurangan_stok.html'' name='action'>Selanjutnya
						<i class='mdi-navigation-chevron-right right'></i>
					</button>
				</div>					
			</div>
		</form>
	</div>
";

?>