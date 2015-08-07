<?php echo"
	<div class='formain'>
	<div class='formhead'>
		<h2 class='titmain'><b>Ubah Password</b></h2>
	</div>
	<form class='row formbody' id='form-change-password'>
		<div class='input-field col s12 m8'>
			<input disabled id='email' type='email' name='email' class='validate' value='".$_SESSION['bonobo']['email']."'>
			<label for='email'>Email</label>
		</div>
		<div class='input-field col s12 m8'>
			<input id='oldpass' type='password' name='oldpass' class='validate'>
			<label for='email'>Password</label>
		</div>
		<div class='input-field col s12 m8'>
			<input id='newpass' type='password' name='newpass' class='validate' >
			<label for='pesan'>Pasword Baru</label>
		</div>		
		<div class='input-field col s12 m8'>
			<input id='renewpass' type='password' name='renewpass' class='validate' >
			<label for='pesan'>Ulangi Pasword Baru</label>
		</div>
		<div class='input-field col s12 m8'>
			<button class='waves-effect waves-light btn deep-orange darken-1 right' type='button' onclick=javascript:c_password('form-change-password','toko/change_password')>Simpan</button>
		</div>
	</form>
</div>"; ?>