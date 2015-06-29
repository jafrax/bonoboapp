<?php

if($Shop->flag_information == 0){
	$Button = "<a href='".base_url("toko/step4")."' class='btn waves-effect waves-light red'><i class='mdi-navigation-chevron-left left'></i> Kembali</a><button class='btn waves-effect waves-light'>Selanjutnya<i class='mdi-navigation-chevron-right right'></i></button>";
}else{
	$Button = "<button class='btn waves-effect waves-light'>Simpan<i class='mdi-navigation-chevron-right right'></i></button>";
}

echo"
	<div class='col s12 m12 l12'>
		<form class='formain' method='POST' action='".base_url("toko/step5/")."'>
			<input type='hidden' name='submit' value='submited'/>
			<div class='formhead'>
				<h2 class='titmain'><b>PENGIRIMAN</b></h2>
				<p>Pilih jasa pengiriman ayng didukung oleh toko Anda.</p>
			</div>
			<div class='row formbody'>
				<div class='input-field col s12 m8'>
					<input type='checkbox' class='filled-in' id='chkPickUpStore' name='chkPickUpStore' ".($Shop->dm_pick_up_store == 1 ? "checked" : "")."/>
					<label for='chkPickUpStore'>Ambil di toko</label>
				</div>
				<div class='input-field col s12 m8'>
					<p>Pembeli akan datang ke alamat Toko Anda untuk mengambil pesanannya.</p>
				</div>
				<div class='input-field col s12 m8'>
					<input type='checkbox' class='filled-in' id='chkExpedition' name='chkExpedition' ".($Shop->dm_expedition == 1 ? "checked" : "")."/>
					<label for='chkExpedition'>Jasa ekspedisi</label>
				</div>	
				<div class='input-field col s12 m8'>
					<p>Silahkan pilih jasa ekspedisi berikut. Ongkos kirim sesuai kebijakan Perusahaan Ekspedisi yang bersangkutan.
						<div class='input-field col s2 m2'><p></p></div>
						<div class='input-field col s5 m2'>
							<input type='checkbox' id='jne'  />
							<label for='jne'>JNE</label>
						</div>
						<div class='input-field col s5 m8'>
							<input type='checkbox' id='tiki'  />
							<label for='tiki'>TIKI</label>
						</div>
						<div class='input-field col s2 m2'><p></p></div>
						<div class='input-field col s5 m2'>
							<input type='checkbox' id='pos'  />
							<label for='pos'>Pos Indonesia</label>
						</div>
						<div class='input-field col s5 m8'>
							<input type='checkbox' id='cargo'  />
							<label for='cargo'>Cargo</label>
						</div>
					</p>
				</div>
				<div class='input-field col s12 m8'><p></p></div>
				<div class='input-field col s12 m8'>
					<input type='checkbox' class='filled-in' id='chkStoreDelivery' name='chkStoreDelivery' ".($Shop->dm_store_delivery == 1 ? "checked" : "")."/>
					<label for='chkStoreDelivery'>Jasa pengiriman Toko</label>
				</div>	
				<div class='input-field col s12 m8'>
					<p>Anda bisa memasukkan jasa pengiriman lain jika memilikinya.
						<div class='input-field col s8 m6'>
							Kurir Toko <a href=''><i class='mdi-editor-border-color'></i></a>
						</div>
						<div class='input-field col s4 m6'>
							<a class='left red-text' href=''><i class='mdi-action-delete'></i>Hapus</a> 
						</div>
						<div class='input-field col s8 m6'>
							Kurir Toko 2 <a href=''><i class='mdi-editor-border-color'></i></a>
						</div>
						<div class='input-field col s4 m6'>
							<a class='left red-text' href=''><i class='mdi-action-delete'></i>Hapus</a> 
						</div>
					</p>
					<p><a href='#'>Tambah Baru</a></p>
				</div>
				<div class='input-field col s12 m8'><p><br></p></div>
				<div class='input-field col s12 m8'>
					".$Button."
				</div>					
			</div>
		</form>
	</div>
";

?>