<?php 
$uri = $this->uri->segment(1);
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
	<link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons' >
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
	<script type='text/javascript' src='".base_url("assets/jController/enduser/CtrlShop.js")."'></script>
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
			<li "; if ($uri == 'toko') echo"class='active'"; echo"><a "; if ($uri == 'toko') echo"class='active'"; echo" href='".base_url()."'>Toko</a></li>
			<li "; if ($uri == 'anggota') echo"class='active'"; echo"><a "; if ($uri == 'anggota') echo"class='active'"; echo" href='".base_url("anggota")."'>Anggota</a></li>
			<li "; if ($uri == 'produk') echo"class='active'"; echo"><a "; if ($uri == 'produk') echo"class='active'"; echo" href='".base_url("produk")."'>Produk</a></li>
			<li "; if ($uri == '') echo"class='active'"; echo"><a "; if ($uri == '') echo"class='active'"; echo" href='#'>Nota</a></li>
			<li "; if ($uri == 'message') echo"class='active'"; echo"><a "; if ($uri == 'message') echo"class='active'"; echo" href='".base_url("message")."'>Pesan</a></li>
			<li "; if ($uri == '') echo"class='active'"; echo"><a "; if ($uri == '') echo"class='active'"; echo" href='#'>Pemesanan Pre Order</a></li>
			<li "; if ($uri == '') echo"class='active'"; echo"><a "; if ($uri == '') echo"class='active'"; echo" href='".base_url("index/logout")."'>Logout</a></li>
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
					<div class='usermain right'>
						<img class='responsive-img userdum' src='".base_url()."html/images/comp/male.png' />
						<a class='dropdown-button right' data-beloworigin='true' href='#' data-activates='duser' >
							<text>James Rodriguez</text>
						</a>
						<ul id='duser' class='dropdown-content right'>
							<li><a href='".base_url("index/logout")."'>Logout</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<nav class='nav grey darken-2'>
			<div class='containermain'>
				<ul class='navmenu'>
					<li class='menuutama"; if ($uri == 'toko') echo" active"; echo"'>
						<a "; if ($uri == 'toko') echo"class='active'"; echo" href='".base_url()."'>Toko</a>
						<ul class='subnemuutama grey darken-1'>
							<li><a href='".base_url("toko/")."'>Informasi Toko</a></li>
							<li><a href='".base_url("toko/step2")."'>Atur Privasi</a></li>
							<li><a href='".base_url("toko/step3")."'>Atur Pengurangan Stok</a></li>
							<li><a href='".base_url("toko/step4")."'>Metode Transaksi</a></li>
							<li><a href='".base_url("toko/step5")."'>Pengiriman</a></li>
							<li><a href='".base_url("toko/step6")."'>Bank</a></li>
							<li><a href='".base_url("toko/step7")."'>Atur Level Harga</a></li>
						</ul>
					</li>
					<li "; if ($uri == 'anggota') echo"class='active'"; echo"><a "; if ($uri == 'anggota') echo"class='active'"; echo" href='".base_url("anggota")."'>Anggota</a></li>
					<li "; if ($uri == 'produk') echo"class='active'"; echo"><a "; if ($uri == 'produk') echo"class='active'"; echo" href='".base_url("produk")."'>Produk</a></li>
					<li "; if ($uri == '') echo"class='active'"; echo"><a "; if ($uri == '') echo"class='active'"; echo" href='#'>Nota</a></li>
					<li "; if ($uri == 'message') echo"class='active'"; echo"><a "; if ($uri == 'message') echo"class='active'"; echo" href='".base_url("message")."'>Pesan</a></li>
					<li "; if ($uri == '') echo"class='active'"; echo"><a "; if ($uri == '') echo"class='active'"; echo" href='#'>Pemesanan Pre Order</a></li>
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