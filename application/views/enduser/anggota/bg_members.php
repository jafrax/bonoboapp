<?php	
	
echo"
	<div class='col s12 m12 l3'>
		<ul class='menucontent'>
			<li><a href='".base_url("anggota")."'>ANGGOTA BARU</a> <span class='new badge'>".$countNewMember."</span></li>
			<li><a href='".base_url("anggota/invite")."'>KIRIM UNDANGAN</a></li>
			<li><a href='".base_url("anggota/members")."' class='active'>DAFTAR ANGGOTA</a></li>
			<li><a href='".base_url("anggota/blacklist")."'>BLACKLIST</a></li>
		</ul>
	</div>
	
	
	<div class='col s12 m12 l9'>
		<div class='formain'>
			<div class='formhead'>
				<h2 class='titmain'><b>DAFTAR ANGGOTA</b> <span>( 25 Anggota )</span></h2>
				<p>Halaman ini menampilkan pembeli yang telah menjadi anggota !</p>
			</div>
			<ul class='row formbody'>
				<li class='col s12 listanggodaf'>
					<div class='input-field col s12 m8'>
						<i class='mdi-action-search prefix'></i>
						<input id='nama' type='text' class='validate'>
						<label for='nama'>Cari anggota</label>
					</div>
				</li>
				<li class='col s12 m6 l4 listanggodaf'>
					<div class='col s12 m5 l4'>
						<img src='images/comp/male.png' class='responsive-img userimg'>
					</div>
					<div class='col s12 m7 l8'>
						<p><a href='#detail_anggota' class='modal-trigger' href=''><b class='userangoota'>Yegar sahaduta</b></a></p>
						</p><a href='#setting_harga' class='modal-trigger' ><b>Level : Grosir</b></a></p>
						<a href='#delete_anggota' class='modal-trigger btn-floating btn-xs waves-effect waves-light red right'><i class='mdi-navigation-close'></i></a>
					</div>
				</li>
				<li class='col s12 m6 l4 listanggodaf'>
					<div class='col s12 m5 l4'>
						<img src='images/comp/female.png' class='responsive-img userimg'>
					</div>
					<div class='col s12 m7 l8'>
						<p><a href=''><b class='userangoota'>Dian sastro w</b></a></p>
						</p><a href='#setting_harga' class='modal-trigger' ><b>Level : Grosir</b></a></p>
						<a href='#delete_anggota' class='modal-trigger btn-floating btn-xs waves-effect waves-light red right'><i class='mdi-navigation-close'></i></a>
					</div>
				</li>
				<li class='col s12 m6 l4 listanggodaf'>
					<div class='col s12 m5 l4'>
						<img src='images/comp/male.png' class='responsive-img userimg'>
					</div>
					<div class='col s12 m7 l8'>
						<p><a href=''><b class='userangoota'>Yegar sahaduta</b></a></p>
						</p><a href='#setting_harga' class='modal-trigger' ><b>Level : Grosir</b></a></p>
						<a href='#delete_anggota' class='modal-trigger btn-floating btn-xs waves-effect waves-light red right'><i class='mdi-navigation-close'></i></a>
					</div>
				</li>
				<li class='col s12 m6 l4 listanggodaf'>
					<div class='col s12 m5 l4'>
						<img src='images/comp/female.png' class='responsive-img userimg'>
					</div>
					<div class='col s12 m7 l8'>
						<p><a href=''><b class='userangoota'>Dian sastro w</b></a></p>
						</p><a href='#setting_harga' class='modal-trigger' ><b>Level : Grosir</b></a></p>
						<a href='#delete_anggota' class='modal-trigger btn-floating btn-xs waves-effect waves-light red right'><i class='mdi-navigation-close'></i></a>
					</div>
				</li>
				<li class='col s12 m6 l4 listanggodaf'>
					<div class='col s12 m5 l4'>
						<img src='images/comp/female.png' class='responsive-img userimg'>
					</div>
					<div class='col s12 m7 l8'>
						<p><a href=''><b class='userangoota'>Dian sastro w</b></a></p>
						</p><a href='#setting_harga' class='modal-trigger' ><b>Level : Grosir</b></a></p>
						<a href='#delete_anggota' class='modal-trigger btn-floating btn-xs waves-effect waves-light red right'><i class='mdi-navigation-close'></i></a>
					</div>
				</li>
				<li class='col s12 m6 l4 listanggodaf'>
					<div class='col s12 m5 l4'>
						<img src='images/comp/female.png' class='responsive-img userimg'>
					</div>
					<div class='col s12 m7 l8'>
						<p><a href=''><b class='userangoota'>Dian sastro w</b></a></p>
						</p><a href='#setting_harga' class='modal-trigger' ><b>Level : Grosir</b></a></p>
						<a href='#delete_anggota' class='modal-trigger btn-floating btn-xs waves-effect waves-light red right'><i class='mdi-navigation-close'></i></a>
					</div>
				</li>
				<li class='col s12 m6 l4 listanggodaf'>
					<div class='col s12 m5 l4'>
						<img src='images/comp/male.png' class='responsive-img userimg'>
					</div>
					<div class='col s12 m7 l8'>
						<p><a href=''><b class='userangoota'>Yegar sahaduta</b></a></p>
						</p><a href='#setting_harga' class='modal-trigger' ><b>Level : Grosir</b></a></p>
						<a href='#delete_anggota' class='modal-trigger btn-floating btn-xs waves-effect waves-light red right'><i class='mdi-navigation-close'></i></a>
					</div>
				</li>
				
			</ul>
		</div>
	</div>
	
	
	<div id='delete_anggota' class='modal confirmation'>
		<div class='modal-header red'>
			<i class='mdi-navigation-close left'></i> Hapus anggota
		</div>
		<form class='modal-content'>
			<p>Apakah anda yakin ingin menghapus <b>'nama anggota'</b> ?</p>
			<p>
				<input type='checkbox' class='filled-in' id='blacklist' />
				<label for='blacklist'>Masukan kedalam blacklist</label>
			</p>
		</form>
		<div class='modal-footer'>
			<a href='#!' class=' modal-action modal-close waves-effect waves-teal lighten-2 btn-flat'>YA</a>
			<a href='#!' class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
		</div>
	</div>

	<div id='detail_anggota' class='modal modal-fixed-footer'>
		<div class='row modal-content'>
			<div class='col s12 m3 l3'>
				<img src='images/comp/female.png' class='responsive-img userimg'>
			</div>
			<div class='col s12 m9 l9 formdetilpup'>
				<p><b>Email :</b>dian@gmail.com</p>
				<p><b>Nama :</b>Dian sastro w</p>
				<p><b>Hand Phone :</b>08383838345</p>
				<p><b>Whats Up :</b>08383838345</p>
				<p><b>Line :</b>dians</p>
			</div>
			<div class='col s12 m12 l12 formdetilpup'>
				<h6><b>Alamat</b></h6>
				<p><b>Propinsi :</b>Jawa Tengah</p>
				<p><b>Kota :</b>Surakarta</p>
				<p><b>Kecamatan :</b>Kalimu Gedi</p>
				<p><b>Alamat :</b>Jl. Kaliurang No. 303</p>
				<p><b>Kodepos :</b>33322</p>
			</div>
		</div>
		<div class='modal-footer'>
			<a href='#!' class=' modal-action modal-close waves-effect waves-red btn-flat'>KELUAR</a>
		</div>
	</div>

	<div id='setting_harga' class='modal confirmation'>
		<div class='modal-header deep-orange'>
			<i class='mdi-action-spellcheck left'></i> Setting harga
		</div>
		<form class='modal-content'>
			<p>
				<div class='input-field col s12'>
					<select>
						<option value='' disabled selected>Choose your option</option>
						<option value='1'>Option 1</option>
						<option value='2'>Option 2</option>
						<option value='3'>Option 3</option>
					</select>
				</div>
			</p>
		</form>
		<div class='modal-footer'>
			<a href='#!' class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
			<a href='#!' class=' modal-action modal-close waves-effect waves-red btn-flat'>YA</a>
		</div>
	</div>
";

?>