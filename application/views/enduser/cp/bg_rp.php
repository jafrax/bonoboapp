<?php
echo "
<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'/>
<title>Bonobo</title>

<link rel='icon' href='images/comp/icon.ico' type='image/gif' sizes='16x7'>

<link type='text/css' rel='stylesheet' href='".base_url()."html/css/materialize.min.css'  media='screen,projection'/>
<link type='text/css' rel='stylesheet' href='".base_url()."html/css/font-awesome.min.css' />
<link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
<link type='text/css' rel='stylesheet' href='".base_url()."html/css/jpushmenu.css' />
<link type='text/css' rel='stylesheet' href='".base_url()."html/css/chosen.css' />

<link type='text/css' rel='stylesheet' href='".base_url()."html/css/style.css' />
<link type='text/css' rel='stylesheet' href='".base_url()."html/css/tablet.css' />
<link type='text/css' rel='stylesheet' href='".base_url()."html/css/mobile.css' />
<link type='text/css' rel='stylesheet' href='".base_url()."html/css/comp.css' />
<script>var base_url = '".base_url()."';</script>

</head>
<body class='cbp-spmenu-push cbp-spmenu-push-toleft'>


<header>
	<div class='headmain'>        
		<div class='row padhead'>
			<ul class='col s1 navmob toggle-menu menu-left push-body jPushMenuBtn'>
				<li><a href='#'><i class='fa fa-align-justify'></i></a></li>
			</ul>
			<div class='col s6 m4 l2'><img class='responsive-img logo' src='".base_url()."html/images/comp/logo_shadow.png' /></div>
			<div class='col s6 m8 l10'>

				<div class='usermain right'>";
					if ($_SESSION['bonobo']['image']) {
						echo "<img class='responsive-img userdum' src='".base_url()."assets/pic/shop/resize/".$_SESSION['bonobo']['image']."' />";
					}else{
						echo "<img class='responsive-img userdum' src='".base_url()."html/images/comp/male.png' />";
					}
					echo "
					<a class='dropdown-button right' data-beloworigin='true' href='#' data-activates='duser' >
							<text>".$_SESSION['bonobo']['name']."</text>
						</a>
					<ul id='duser' class='dropdown-content right'>
						<li><a href='".base_url("index/logout")."'>Logout</a></li>
					</ul>
				</div>
				

			</div>
		</div>
	</div>
	
</header>
<content>
	<div class='formain'>
		<div class='formhead'>
			<h2 class='titmain'><b>Ubah Password</b></h2>
		</div>
		<form class='row formbody' id='form-reset-password'>
			<div class='input-field col s12 m8'>
				<input id='email' type='email' name='email' class='validate' value='".$_SESSION['bonobo']['email']."' readonly>
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
				<button class='waves-effect waves-light btn deep-orange darken-1 right' type='button' onclick=javascript:r_password('form-reset-password','toko/change_password/')>Simpan</button>
			</div>
		</form>
	</div>
</content>
<footer class='page-footer grey darken-3'>
	<div class='container'>
		<div class='row'>
			<div class='col l6 s12'>
				<h5 class='white-text'>Footer Content</h5>
				<p class='grey-text text-lighten-4'>You can use rows and columns here to organize your footer content.</p>
			</div>
			<div class='col l4 offset-l2 s12'>
				<h5 class='white-text'>Links</h5>
				<ul>
					<li><a class='grey-text text-lighten-3' href='#!'>Link 1</a></li>
					<li><a class='grey-text text-lighten-3' href='#!'>Link 2</a></li>
					<li><a class='grey-text text-lighten-3' href='#!'>Link 3</a></li>
					<li><a class='grey-text text-lighten-3' href='#!'>Link 4</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class='footer-copyright grey darken-4'>
		<div class='container'> 2015 Bonobo
			<a class='grey-text text-lighten-4 right' href='#!'>Tentang Kami</a>
			<a class='grey-text text-lighten-4 right' href='#!'>Kebijakan privasi</a>
			<a class='grey-text text-lighten-4 right' href='#!'>Syarat dan ketentuan</a>
		</div>
	</div>
</footer>

<script type='text/javascript' src='".base_url()."html/js/jquery-2.1.4.min.js'></script>
<script type='text/javascript' src='".base_url()."html/js/materialize.min.js'></script>
<script type='text/javascript' src='".base_url()."html/js/jpushmenu.js'></script>
<script type='text/javascript' src='".base_url()."html/js/chosen.jquery.js'></script>
<script type='text/javascript' src='".base_url("assets/jLib/jQuery/jquery.price_format.2.0.min.js")."'></script>
<script type='text/javascript' src='".base_url("assets/jLib/jQuery/jquery.validate.js")."'></script>
<script type='text/javascript' src='".base_url("assets/jLib/jQuery/additional-methods.js")."'></script>
<script type='text/javascript' src='".base_url()."html/js/core.js'></script>
<script type='text/javascript' src='".base_url("")."assets/jController/enduser/CtrlRp.js'></script>
</body>
</html>
";
?>