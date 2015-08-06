<?php

echo "
<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'/>
<title>Bonobo</title>

	<link rel='icon' type='image/gif' sizes='16x7' href='".base_url("html/images/comp/icon.ico")."'>
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/materialize.min.css")."'  media='screen,projection'/>
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/font-awesome.min.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/style.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/tablet.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/mobile.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/comp.css")."' />

	<script>var base_url = '".base_url()."';</script>
	<script type='text/javascript' src='".base_url("")."html/js/jquery-2.1.4.min.js'></script>
	<script type='text/javascript' src='".base_url("")."html/js/materialize.min.js'></script>
	<script type='text/javascript' src='".base_url("assets/jLib/jQuery/jquery.validate.js")."'></script>
	<script type='text/javascript' src='".base_url("assets/jController/CtrlSystem.js")."'></script>
	<script type='text/javascript' src='".base_url("assets/jController/enduser/CtrlIndex.js")."'></script>


	
	<style>html{ width:100%; height:100%; }</style>

</head>

<body class='bgpic' style='background-image: url(".base_url("html/images/data/iphone.jpg").");'>
	<section class='absolute bgop'>
	<header class='head'>
		<div class='row'>
			<div class='col s6 m4 l2'><img class='responsive-img' src='".base_url("html/images/comp/logo_shadow.png")."' /></div>
			<div class='col s6 m8 l10'>
				<p class='signup'><text>Baru datang ke bonobo ?</text><a href='".base_url("index/signup")."' class='waves-effect waves-light btn deep-orange darken-1' >Daftar</a></p>
			</div>
		</div>
	</header>
	<content>
		<div class='containermain'>
			<div class='row col-signin'>
				<form id='form-reset-password' class='signin z-depth-2'>
					<div class='row'>
					";
					$text='';
					if(!empty($pesan)){
						$text= "<span id='repas'>".$pesan."</span>";
					}
					echo $text;
					echo "
						<div id='lblNotif' class='notif-error'></div>
						<div class='input-field col s12'>
							<input id='newpass' name='newpass' type='password' class='validate' tabindex='2' maxlength='50'>
							<label for='newpass'>Password Baru</label>
							<label id='notifEmail' class='error' style='display:none;'><i class='fa fa-warning'></i> Harus diisi !</label>
						</div>
						<div class='input-field col s12'>
							<input id='renewpass' name='renewpass' type='password' class='validate' tabindex='2' maxlength='50'>
							<label for='renewpass'>Ulangi Password Baru</label>
							<label id='notifPassword' class='error' style='display:none;'><i class='fa fa-warning'></i> Harus diisi !</label>
						</div>
						<div class='input-field col s12'>
							<button class='waves-effect waves-light btn deep-orange darken-1 right' type='button' onclick=javascript:r_password('form-reset-password','index/new_password')>Simpan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</content>
	<footer>
		<div class='row footer'>
			<div class='col s12' align='right'>
				<a href='' >Syarat dan ketentuan</a>
				<a href='' >Kebijakan privasi</a>
				<a href='' >Tentang kami</a>
			</div>
		</div>
	</footer>
	</section>


</body>
</html>

<script>
	var ctrlSignin = new CtrlSignin();
	ctrlSignin.init();
</script>
";
?>