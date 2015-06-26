<?php

echo"
	<div class='col s12 m12 l12'>
		<form class='formain'>
			<div class='formhead'>
				<h2 class='titmain'><b>METODE TRANSAKSI</b></h2>
				<p>Metode transaksi yang sesuai dengan kebutuhan dan kenyamanan Anda.</p>
			</div>
			<div class='row formbody'>
				<div class='input-field col s12 m8'>
					<input type='checkbox' class='filled-in' id='bayar-di-tempat' checked='checked' />
					<label for='bayar-di-tempat'>Bayar di tempat</label>
				</div>
				<div class='input-field col s12 m8'>
					<p>Pembeli akan datang langsung ke toko Anda untuk melunasi pembayaran.
					</p>
				</div>
				<div class='input-field col s12 m8'>
					<input type='checkbox' class='filled-in' id='via-bank' checked='checked' />
					<label for='via-bank'>Transfer via Bank</label>
				</div>	
				<div class='input-field col s12 m8'>
					<p>Transfer via Bank yang di dukung oleh Anda.
					</p>
				</div>
				<div class='input-field col s12 m8'>
				</div>
				<div class='input-field col s12 m8'>
					<button class='btn waves-effect waves-light red' type='button' onclick='location.href='atur_pengurangan_stok.html'' name='action'>
						<i class='mdi-navigation-chevron-left left'></i> Kembali
					</button>
					<button class='btn waves-effect waves-light' type='button' onclick='location.href='pengiriman.html'' name='action'>Selanjutnya
						<i class='mdi-navigation-chevron-right right'></i>
					</button>
				</div>					
			</div>
		</form>
	</div>
";

?>