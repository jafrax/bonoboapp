<?php

echo"
	<div class='col s12 m12 l12'>
		<form class='formain'>
			<div class='formhead'>
				<h2 class='titmain'><b>ATUR PENGURANGAN STOK</b></h2>
				<p>Anda dapat mengatur kapan stok Anda akan dihitung berkurang. Pilihlah sesuai kemudahan Anda.</p>
			</div>
			<div class='row formbody'>
				<div class='input-field col s12 m8'>
					<input id='publik' name='group1' type='radio' class='with-gap' checked>
					<label for='publik'>Saat pembeli menyelesaikan transaksi dari keranjang belanja</label>
				</div>
				<div class='input-field col s12 m8'>
					<p>Stok akan berkurang ketika Pembeli sudah menyelesaikan transaksi di keranjang belanja.<br>
						Catatan:<br>
						- Stok berkurang sekalipun pembeli belum melakukan pembayaran.<br>
						- Stok akan berkurang secara otomatis jika Anda membatalkan atau menghapus Nota<br>
					</p>
				</div>
				<div class='input-field col s12 m8'>
					<input id='privasi' name='group1' type='radio' class='with-gap'>
					<label for='privasi'>Saat toko menyatakan status pesanan 'Lunas' </label>
				</div>	
				<div class='input-field col s12 m8'>
					<p>Stok akan berkurang ketika Toko melakukan konfirmasi pembayaran.<br>
						Catatan:<br>
						- Stok berkurang setelah pembeli melakukan pembayaran.<br>
						- Anda mungkin perlu melakukan refund jika ada dua atau lebih pembeli yang yang telah membayar pesanannya tetapi stok tidak mencukupi.<br>
					</p>
				</div>
				<div class='input-field col s12 m8'>
				</div>
				<div class='input-field col s12 m8'>
					<button class='btn waves-effect waves-light red' type='button' onclick='location.href='atur_privasi.html'' name='action'>
						<i class='mdi-navigation-chevron-left left'></i> Kembali
					</button>
					<button class='btn waves-effect waves-light' type='button' onclick='location.href='metode_transaksi.html'' name='action'>Selanjutnya
						<i class='mdi-navigation-chevron-right right'></i>
					</button>
				</div>					
			</div>
		</form>
	</div>
";

?>