<?php

if($Shop->flag_information == 0){
	$Button = "<a href='".base_url("toko/step2")."' class='btn waves-effect waves-light red'><i class='mdi-navigation-chevron-left left'></i> Kembali</a><button class='btn waves-effect waves-light'>Selanjutnya<i class='mdi-navigation-chevron-right right'></i></button>";
}else{
	$Button = "<button class='btn waves-effect waves-light'>Simpan<i class='mdi-navigation-chevron-right right'></i></button>";
}

echo"
	<div class='col s12 m12 l12'>
		<form class='formain' method='POST' action='".base_url("toko/step3/")."'>
			<div class='formhead'>
				<h2 class='titmain'><b>ATUR PENGURANGAN STOK</b></h2>
				<p>Anda dapat mengatur kapan stok Anda akan dihitung berkurang. Pilihlah sesuai kemudahan Anda.</p>
			</div>
			<div class='row formbody'>
				<div class='input-field col s12 m8'>
					<input id='rdgStock1' name='rdgStock' type='radio' class='with-gap' value='0' ".($Shop->stock_adjust == 0 ? "checked" : "").">
					<label for='rdgStock1'>Saat pembeli menyelesaikan transaksi dari keranjang belanja</label>
				</div>
				<div class='input-field col s12 m8'>
					<p>Stok akan berkurang ketika Pembeli sudah menyelesaikan transaksi di keranjang belanja.<br>
						Catatan:<br>
						- Stok berkurang sekalipun pembeli belum melakukan pembayaran.<br>
						- Stok akan berkurang secara otomatis jika Anda membatalkan atau menghapus Nota<br>
					</p>
				</div>
				<div class='input-field col s12 m8'>
					<input id='rdgStock2' name='rdgStock' type='radio' class='with-gap' value='1' ".($Shop->stock_adjust == 1 ? "checked" : "").">
					<label for='rdgStock2'>Saat toko menyatakan status pesanan 'Lunas' </label>
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
					".$Button."
				</div>					
			</div>
		</form>
	</div>
";

?>