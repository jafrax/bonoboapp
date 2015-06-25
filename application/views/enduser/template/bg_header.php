<?php 
echo"
<!DOCTYPE html>
<html>
<head>
	<title>Bonobo</title>
	
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'/>

	<link rel='icon' type='image/gif' sizes='16x7' href='".base_url("html/images/comp/icon.ico")."'>

	<link type='text/css' rel='stylesheet' href='".base_url("html/css/materialize.min.css")."'  media='screen,projection'/>
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/font-awesome.min.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/materialize-tags.min.css")."'/>
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/jpushmenu.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/chosen.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/style.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/tablet.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/mobile.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/comp.css")."' />

	<script>var base_url = '".base_url()."';</script>
	<script type='text/javascript' src='".base_url("html/js/jquery-2.1.4.min.js")."'></script>
	<script type='text/javascript' src='".base_url("html/js/materialize.min.js")."'></script>
	<script type='text/javascript' src='".base_url("html/js/materialize-tags.min.js")."'></script>
	<script type='text/javascript' src='".base_url("html/js/jpushmenu.js")."'></script>
	<script type='text/javascript' src='".base_url("html/js/chosen.jquery.js")."'></script>
	<script type='text/javascript' src='".base_url("assets/jLib/jQuery/jquery.validate.js")."'></script>	
	<script type='text/javascript' src='".base_url("assets/jLib/jQuery/additional-methods.js")."'></script>
	<script type='text/javascript' src='".base_url("assets/jController/CtrlSystem.js")."'></script>
	<script type='text/javascript' src='".base_url("assets/jController/enduser/CtrlAnggota.js")."'></script>
	<script type='text/javascript' src='".base_url("assets/jController/enduser/CtrlMessage.js")."'></script>
</head>

<body class='cbp-spmenu-push cbp-spmenu-push-toleft'>
	<nav class='cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left cbp-spmenu-open'>
		<ul class='col s12 navmob mobleft'>
			<li class='usermob'>
				<div class='usermain left'>
					<img class='responsive-img userdum' src='".base_url()."html/images/comp/male.png' />
					<text>James Rodriguez</text>
				</div>
			</li>
			<li><a href='".base_url()."'>Toko</a></li>
			<li><a href='".base_url("anggota")."'>Anggota</a></li>
			<li><a href='#'>Produk</a></li>
			<li><a href='#'>Nota</a></li>
			<li><a href='".base_url("message")."'>Pesan</a></li>
			<li><a href='#'>Pre Order</a></li>
			<li><a href='".base_url("index/logout")."'>Logout</a></li>
		</ul>
	</nav>

	<header>
		<div class='headmain'>
			<div class='row padhead'>
				<ul class='col s1 navmob toggle-menu menu-left push-body jPushMenuBtn'>
					<li><a href='#'><i class='fa fa-align-justify'></i></a></li>
				</ul>
				<div class='col s6 m4 l2'>
					<a href='".base_url("/")."'>
						<img class='responsive-img logo' src='".base_url()."html/images/comp/logo_shadow.png' />
					</a>
				</div>
				<div class='col s6 m8 l10'>
					<a href='".base_url("index/logout")."'>
						<div class='usermain right'>
							<img class='responsive-img userdum' src='".base_url()."html/images/comp/male.png' />
							<text>James Rodriguez</text>
						</div>
					</a>
				</div>
			</div>
		</div>
		<nav class='nav grey darken-2'>
			<div class='containermain'>
				<ul class='navmenu'>
					<li><a href='".base_url()."'>Toko</a></li>
					<li><a href='".base_url("anggota")."'>Anggota</a></li>
					<li><a href='#'>Produk</a></li>
					<li><a href='#'>Nota</a></li>
					<li><a href='".base_url("message")."'>Pesan</a></li>
					<li><a href='#'>Pre Order</a></li>
				</ul>
			</div>
		</nav>
	</header>
	<content>
		<div class='contentmain'>
			<div class='containermain'>
				<div class='row contentsebenarya'>
";
?>