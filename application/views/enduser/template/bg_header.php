<?php 
$uri = $this->uri->segment(1);
	

$nav = "";
if (date('Y-m-d') > $_SESSION['bonobo']['expired_on']) {
	$nav = "none";
}

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
	<link type='text/css' rel='stylesheet' href='//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/font-awesome.min.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/materialize-tags.min.css")."'/>
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/jpushmenu.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/chosen.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/selectize.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/style.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/tablet.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/mobile.css")."' />
	<link type='text/css' rel='stylesheet' href='".base_url("html/css/comp.css")."' />

	<script>var base_url = '".base_url()."';</script>
	<script type='text/javascript' src='".base_url("html/js/jquery-2.1.4.min.js")."'></script>
	<script type='text/javascript' src='//code.jquery.com/jquery-1.10.2.js'></script>
	<script type='text/javascript' src='//code.jquery.com/ui/1.11.4/jquery-ui.js'></script>
	<script type='text/javascript' src='".base_url("html/js/materialize.min.js")."'></script>
	<script type='text/javascript' src='".base_url("html/js/materialize-tags.min.js")."'></script>
	<script type='text/javascript' src='".base_url("html/js/jpushmenu.js")."'></script>
	<script type='text/javascript' src='".base_url("html/js/chosen.jquery.js")."'></script>
	<script type='text/javascript' src='".base_url("html/js/selectize.js")."'></script>
	<script type='text/javascript' src='".base_url("assets/jLib/jQuery/jquery.validate.js")."'></script>
	<script type='text/javascript' src='".base_url("assets/jLib/jQuery/additional-methods.js")."'></script>
	<script type='text/javascript' src='".base_url("assets/jLib/jQuery/jquery.price_format.2.0.min.js")."'></script>
	<script type='text/javascript' src='".base_url("assets/jController/CtrlSystem.js")."'></script>
	<script type='text/javascript' src='".base_url("assets/jController/enduser/CtrlShop.js")."'></script>
	<script type='text/javascript' src='".base_url("assets/jController/enduser/CtrlAnggota.js")."'></script>
	<script type='text/javascript' src='".base_url("assets/jController/enduser/CtrlMessage.js")."'></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
";

?>


<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5668e8d50c2fc456799e304f/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->


<?php
echo"
</head>

<body class='cbp-spmenu-push cbp-spmenu-push-toleft'>
	<nav class='cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left cbp-spmenu-open'>
		<ul class='col s12 navmob mobleft'>
			<li class='usermob'>
				<div class='usermain left'>";
					if (isset($_SESSION['bonobo']['image'])) {
						echo "<img class='responsive-img userdum' src='".base_url()."assets/pic/shop/resize/".$_SESSION['bonobo']['image']."' />";
					}else{
						echo "<img class='responsive-img userdum' src='".base_url()."html/images/comp/male.png' /> ";
					}
					echo "
					<text>".$_SESSION['bonobo']['name']."</text>
				</div>
			</li>
			<li style='display:$nav' "; if ($uri == 'toko') echo"class='active'"; echo"><a "; if ($uri == 'toko') echo"class='active'"; echo" href='".base_url()."'>Toko</a></li>
			<li style='display:$nav' "; if ($uri == 'anggota') echo"class='active'"; echo"><a "; if ($uri == 'anggota') echo"class='active'"; echo" href='".base_url("anggota")."'>Anggota</a></li>
			<li style='display:$nav' "; if ($uri == 'produk') echo"class='active'"; echo"><a "; if ($uri == 'produk') echo"class='active'"; echo" href='".base_url("produk")."'>Produk</a></li>
			<li style='display:$nav' "; if ($uri == 'nota') echo"class='active'"; echo"><a "; if ($uri == 'nota') echo"class='active'"; echo" href='".base_url("nota")."'>Nota<span style='' class='notifinnota badge red'>0</span></a></li>
			<li "; if ($uri == 'message') echo"class='active'"; echo"><a "; if ($uri == 'message') echo"class='active'"; echo" href='".base_url("message")."'>Message <span style='display:none' class='notifindong badge red'>0</span></a></li>
			<li style='display:$nav' "; if ($uri == 'preorder') echo"class='active'"; echo"><a "; if ($uri == 'preorder') echo"class='active'"; echo" href='".base_url("preorder")."'>Pemesanan Pre Order</a></li>
			<li "; if ($uri == '') echo"class='active'"; echo"><a "; if ($uri == '') echo"class='active'"; echo" href='".base_url("toko/change_password")."'>Change password</a></li>
			<li><a href='".base_url("license")."'>Perpanjang Masa Aktif</a></li>
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
				<div class='col s5 m8 l10'>
					<div class='usermain right'>";
						if (isset($_SESSION['bonobo']['image']) && $_SESSION['bonobo']['image']!="") {
							echo "<img class='responsive-img userdum' src='".base_url()."assets/pic/shop/resize/".$_SESSION['bonobo']['image']."' />";
						}else{
							echo "<img class='responsive-img userdum' src='".base_url()."html/images/comp/male.png' /> ";
						}
						echo "
						<a class='dropdown-button right' data-beloworigin='true' href='#' data-activates='duser' >
							<text>".$_SESSION['bonobo']['name']."</text>
							<i class='mdi-navigation-arrow-drop-down right'></i>
						</a>
						<ul id='duser' class='dropdown-content right' data-gutter='20' data-beloworigin='true' data-constrainwidth='false'>
							<li><a href='".base_url("toko/change_password")."'>Change Password</a></li>
							<li><a href='".base_url("license")."'>Perpanjang Masa Aktif</a></li>
							<li><a href='".base_url("index/logout")."'>Logout</a></li>
						</ul>						
					</div><!--
					<div class='notification right' style='display:$nav'>
						<a class='message' href='".base_url("message")."'><i class='material-icons '>message</i></a>
						
					</div>-->
				</div>
			</div>
		</div>
		<nav class='nav grey darken-2' style='display:$nav'>
			<div class='containermain'>
				<ul class='navmenu' >
					<li  class='menuutama"; if ($uri == 'toko') echo" active"; echo"'>
						<a "; if ($uri == 'toko') echo"class='active'"; echo" href='".base_url("toko/")."'>Toko</a>
						<ul class='subnemuutama'>
							";
						echo "<li><a href='".base_url("toko/")."'>1. INFORMASI TOKO</a></li>
								<li><a href='".base_url("toko/step2")."'>2. PRIVASI</a></li>
								<li><a href='".base_url("toko/step3")."'>3. STOK</a></li>
								<li><a href='".base_url("toko/step4")."'>4. METODE TRANSAKSI</a></li>
								<li><a href='".base_url("toko/step5")."'>5. LEVEL HARGA</a></li>
								<li><a href='".base_url("toko/step6")."'>6. METODE KONFIRMASI</a></li>
								<li><a href='".base_url("toko/step7")."'>7. PENGIRIMAN</a></li>
								<li><a href='".base_url("toko/step8")."'>8. BANK</a></li>";
							
							echo "							
						</ul>
					</li>
					<li "; if ($uri == 'anggota') echo"class='active'"; echo"><a "; if ($uri == 'anggota') echo"class='active'"; echo" href='".base_url("anggota")."'>Anggota</a></li>
					<li "; if ($uri == 'produk') echo"class='active'"; echo"><a "; if ($uri == 'produk') echo"class='active'"; echo" href='".base_url("produk")."'>Produk</a></li>
					<li "; if ($uri == 'nota') echo"class='active'"; echo"><a "; if ($uri == 'nota') echo"class='active'"; echo" href='".base_url("nota")."'>Nota <span style='display:none' class='notifinnota badge red'>0</span></a></li>					
					<li "; if ($uri == 'preorder') echo"class='active'"; echo"><a "; if ($uri == 'preorder') echo"class='active'"; echo" href='".base_url("preorder")."'>Pemesanan Pre Order</a></li>
					<li "; if ($uri == 'message') echo"class='active'"; echo"><a "; if ($uri == 'message') echo"class='active'"; echo" href='".base_url("message")."'>Message <span style='display:none' class='notifindong badge red'>0</span></a></li>
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