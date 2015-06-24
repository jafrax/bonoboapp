<?php	
	
echo"
	<div class='col s12 m12 l3'>
		<ul class='menucontent'>
			<li><a href='".base_url("anggota")."'>ANGGOTA BARU</a> <span class='new badge'>".$countNewMember."</span></li>
			<li><a href='".base_url("anggota/invite")."' class='active'>KIRIM UNDANGAN</a></li>
			<li><a href='".base_url("anggota/members")."'>DAFTAR ANGGOTA</a></li>
			<li><a href='".base_url("anggota/blacklist")."'>BLACKLIST</a></li>
		</ul>
	</div>
	
	
	<div class='col s12 m12 l9'>
		<div class='formain'>
			<div class='formhead'>
				<h2 class='titmain'><b>KIRIM UNDANGAN</b></h2>
				<p>Ajak teman dan calon pelanggan anda untuk bergabung di toko anda !</p>
			</div>
			<form class='row formbody' method='POST' action='".base_url("anggota/invite")."'>
				<div class='input-field col s12 m8'>
					<input id='email' name='email' type='text' class='validate' value='".$email."'>
					<label for='email'>Email tujuan</label>
				</div>
				<div class='input-field col s12 m8'>
					<textarea id='message' name='message' class='materialize-textarea' >".$message."</textarea>
					<label for='message'>Pesan</label>
				</div>
				<div class='input-field col s12 m8'>
					".$notif."<button class='waves-effect waves-light btn deep-orange darken-1 right'>Kirim</button>
				</div>
			</form>
		</div>
	</div>
";

?>