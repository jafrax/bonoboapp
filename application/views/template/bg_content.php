<?php
echo"
<content>
	<div class='contentmain'>
		<div class='containermain'>
			<div class='row contentsebenarya'>
				<div class='col s12 m12 l12'>
					<ul class='menucontent row'>
						<li class='col s12 m5 l4 langkah active'><a href=''>
							<div class='card-panel '>
								<span class='white-text'>INFORMASI TOKO</span><i class='mdi-hardware-keyboard-arrow-right right'></i>
							</div>
						</a></li>
						<li class='col s12 m5 l4 langkah'><a href=''>
							<div class='card-panel '>
								<span class='white-text'>ATUR INFORMASI</span><i class='mdi-hardware-keyboard-arrow-right right'></i>
							</div>
						</a></li>
						<li class='col s12 m5 l4 langkah'><a href=''>
							<div class='card-panel '>
								<span class='white-text'>ATUR PENGURANGAN STOK</span><i class='mdi-hardware-keyboard-arrow-right right'></i>
							</div>
						</a></li>
						<li class='col s12 m5 l4 langkah'><a href=''>
							<div class='card-panel '>
								<span class='white-text'>METODE TRANSAKSI</span><i class='mdi-hardware-keyboard-arrow-right right'></i>
							</div>
						</a></li>
						<li class='col s12 m5 l4 langkah'><a href=''>
							<div class='card-panel '>
								<span class='white-text'>PENGIRIMAN</span><i class='mdi-hardware-keyboard-arrow-right right'></i>
							</div>
						</a></li>
						<li class='col s12 m5 l4 langkah'><a href=''>
							<div class='card-panel '>
								<span class='white-text'>BANK</span><i class='mdi-hardware-keyboard-arrow-right right'></i>
							</div>
						</a></li>
						<li class='col s12 m5 l4 langkah'><a href=''>
							<div class='card-panel '>
								<span class='white-text'>ATUR LEVEL HARGA</span><i class='mdi-hardware-keyboard-arrow-right right'></i>
							</div>
						</a></li>
					</ul>
				</div>
				<div class='col s12 m12 l12'>
					<form class='formain'>
						<div class='formhead'>
							<h2 class='titmain'><b>INFORMASI TOKO</b></h2>
						</div>
						<div class='row formbody'>
							<div class='linehead'><i class='fa fa-minus-square-o'></i>Informasi Umum</div>
							<div class='input-field col s12 m8'>
								<input id='nama' type='text' class='validate'>
								<label for='nama'>Nama toko</label>
							</div>
							<div class='input-field col s12 m8'>
								<input id='tokoid' type='text' class='validate'>
								<label for='tokoid'>Toko Id</label>
							</div>
							<div class='input-field col s12 m6'>
								<select>
									<option value='' disabled selected>Choose your option</option>
									<option value='1'>Option 1</option>
									<option value='2'>Option 2</option>
									<option value='3'>Option 3</option>
								</select>
								<label>Pilih kategori</label>
							</div>
							<div class='input-field col s12 m8'>
								<input id='katakunci' type='text' class='validate'>
								<label for='katakunci'>Kata kunci pencarian</label>
							</div>
							<div class='input-field col s12 m8'>
								<textarea id='deskripsi' class='materialize-textarea' ></textarea>
								<label for='deskripsi'>Deskripsi toko</label>
							</div>
							<div class='input-field col s12 m8'>
								Logo Toko
								<div class='div-circle-logo'>
									<img src='".base_url()."html/images/comp/male.png' alt='' class='circle-logo'>
								</div>								
							</div>
						</div>
						<div class='row formbody'>
							<div class='linehead'><i class='fa fa-minus-square-o'></i>Alamat dan Kontak</div>
							<div class='input-field col s12 m8'>
								<input id='telephone' type='tel' class='validate'>
								<label for='telephone'>Telephone</label>
							</div>
							<div class='input-field col s12 m8'>								
								Kontak Lainnya
								<div class='row valign-wrapper'>
						            <div class='col s2 m2'>
						             	Nama kontak
						            </div>
						            <div class='col s10 m6'>
						              	<input id='kontak' type='text' class='validate'>
						            </div>
						            <div class='col s2 m2'>
						             	Pin/ID/Nomor
						            </div>
						            <div class='col s10 m6'>
						              	<input id='id' type='text' class='validate'>
						            </div>
						        </div>
						        <div class='row valign-wrapper'>
						            <div class='col s2 m2'>
						             	
						            </div>
						            <div class='col s10 m6'>
						              	<a href='#'>Tambah kontak</a>
						            </div>
						        </div>
							</div>
							<div class='input-field col s12 m8'>
								<select>
									<option value='' disabled selected>Choose your option</option>
									<option value='1'>Option 1</option>
									<option value='2'>Option 2</option>
									<option value='3'>Option 3</option>
								</select>
								<label>Provinsi</label>
							</div>
							<div class='input-field col s12 m8'>
								<select>
									<option value='' disabled selected>Choose your option</option>
									<option value='1'>Option 1</option>
									<option value='2'>Option 2</option>
									<option value='3'>Option 3</option>
								</select>
								<label>Kota</label>
							</div>
							<div class='input-field col s12 m8'>
								<textarea id='alamat' class='materialize-textarea' ></textarea>
								<label for='alamat'>Alamat toko</label>
							</div>
							<div class='input-field col s12 m8'>
								<input id='kodepos' type='text' class='validate'>
								<label for='kodepos'>Kodepos</label>
							</div>
							<div class='input-field col s12 m8'>
								<button class='btn waves-effect waves-light' type='button' name='action' onclick='location.href='atur_privasi.html''>Selanjutnya
								    <i class='mdi-navigation-chevron-right right'></i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</content>
";
?>