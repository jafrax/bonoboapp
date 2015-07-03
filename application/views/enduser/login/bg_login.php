<?php

$fb_params = array('scope' => 'email,user_birthday,user_location,read_stream', 'redirect_uri' => base_url("index/signin_fb"));


$pesan="";
if (!empty(	$_SESSION['bonobo']['message_mail_varification'])){						
	$pesan=	$_SESSION['bonobo']['message_mail_varification'];
	$_SESSION['bonobo']['message_mail_varification']=null;

}

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
				<h4 class='titlin'>Masuk ke bonobo</h4>
				<div class='col s12 col-btn-fb' align='center'>
					<a href='".$this->facebook->getLoginUrl($fb_params)."'>
						<button class='waves-effect waves-light btn light-blue darken-4'><i class='fa fa-facebook-official left'></i>Masuk dengan facebook</button>
					</a>
				</div>
				<p class='or'>Atau akun bonobo</p>
				<form id='formSignin' class='signin z-depth-2'>
					<div class='row'>
						<div id='lblNotif' class='notif-error'>".$pesan."</div>
						<div class='input-field col s12'>
							<input id='email' name='email' type='text' class='validate'>
							<label for='email'>Email</label>
							<label id='notifEmail' class='error' style='display:none;'><i class='fa fa-warning'></i> Harus diisi !</label>
						</div>
						<div class='input-field col s12'>
							<input id='password' name='password' type='password' class='validate'>
							<label for='password'>Password</label>
							<label id='notifPassword' class='error' style='display:none;'><i class='fa fa-warning'></i> Harus diisi !</label>
						</div>
						<div class='input-field col s12'>
							<a href='#reset_password' class='modal-trigger left' >Lupa password ?</a>
							<button id='btnSave' type='button' class='waves-effect waves-light btn deep-orange darken-1 right'>Masuk</button>
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

	<div id='reset_password' class='modal confirmation'>
		<div class='modal-header deep-orange darken-1'>
			<i class='mdi-av-not-interested left'></i> Reset password
		</div>
		<form class='modal-content'>
			<div class='input-field col s12'>
				<input id='txtForgotEmail' type='text' class='validate'>
				<label for='txtForgotEmail'>Reset Password</label>
			</div>
			<label id='notifForgotPassword' style='display:none;'></label>
		</form>
		<div class='modal-footer'>
			<a href='javascript:void(0);' id='aForgotSubmit' class=' modal-action waves-effect waves-tiles btn'>RESET PASSWORD</a>
		</div>
	</div>

</body>
</html>

<script>
	var ctrlSignin = new CtrlSignin();
	ctrlSignin.init();
</script>
";
?>