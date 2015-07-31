<?php
$fb_params = array('scope' => 'email,user_birthday,user_location,read_stream', 'redirect_uri' => base_url("index/signup_fb"));

$pesan="";
if (!empty($_SESSION['bonobo']['notifikasi'])){						
	$pesan =	$_SESSION['bonobo']['notifikasi'];
	$_SESSION['bonobo']['notifikasi']=null;
}

echo"
<!DOCTYPE html>
<html>
<head>
	<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'/>
	<title>Bonobo</title>

	<link rel='icon' type='image/gif' sizes='16x7' href='".base_url("html/images/comp/icon.ico")."' >
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/materialize.min.css")."'  media='screen,projection'/>
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/font-awesome.min.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/style.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/tablet.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/mobile.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/comp.css")."' />

	<script>var base_url = '".base_url()."';</script>
	<script type='text/javascript' src='".base_url("html/js/jquery-2.1.4.min.js")."'></script>
	<script type='text/javascript' src='".base_url("html/js/materialize.min.js")."'></script>
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
				<p class='signup'><text>Sudah punya akun ?</text><a href='".base_url("index")."' class='waves-effect waves-light btn deep-orange darken-1' >Masuk</a></p>
			</div>
		</div>
	</header>
	<content>
		<div class='containermain'>
			<div class='row col-signup'>
				<h4 class='titlin'>BONOBO IS A SECURE BUSSINESS PLATFORM</h4>
				<p class='note'>Bonobo merupakan tempat berjualan online dimana setiap toko yang tergabung didalamnya bersaing secara sehat dan bersahabat.</p>
				<form id='formSignup' class='signin z-depth-2'>
					<div class='row'>
						<div id='lblNotif' class='notif-error'></div>
						<div class='input-field col s12'>
							<input id='name' name='name' type='text' class='validate' autofocus placeholder='ex : Nama Toko' tabindex='1'>
							<label for='name'>Nama Toko</label>
							<label id='notifName' class='error' style='display:none;'><i class='fa fa-warning'></i> Harus diisi !</label>
						</div>
						<div class='input-field col s12'>
							<input id='email' name='email' type='text' class='validate' tabindex='2'>
							<label for='email'>Email</label>
							<label id='notifEmail' class='error' style='display:none;'><i class='fa fa-warning'></i> Harus diisi !</label>
						</div>
						<div class='input-field col s12'>
							<input id='password' name='password' type='password' class='validate' tabindex='3'>
							<label for='password'>Password</label>
							<label id='notifPassword' class='error' style='display:none;'><i class='fa fa-warning'></i> Harus diisi !</label>
						</div>
						<div class='input-field col s12'>
							<input id='rePassword' name='rePassword' type='password' class='validate' tabindex='4'>
							<label for='rePassword'>Ketik ulang password</label>
							<label id='notifRepassword' class='error' style='display:none;'><i class='fa fa-warning'></i> Sandi tidak sesuai !</label>
						</div>
						<div class='input-field col s12'>
							<button id='btnSave' type='button' class='waves-effect waves-light btn deep-orange darken-1 right' onkeyup=ctrlSignup.onEnter(event); tabindex='5' >DAFTAR</button>
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
	var ctrlSignup = new CtrlSignup();
	ctrlSignup.init();
</script>
";
?>