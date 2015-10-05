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
	<div class='contentmain'>
		<div class='containermain'>
			<div class='row contentsebenarya'>
				<div class='col s12 m12 l12'>
					<a href='".base_url()."license'>&larr; Kembali</a>
					<form class='formain'>
						<div class='formhead'>
							<h2 class='titmain'><b>FAQ</b></h2>
						</div>

						<div class='row formbody'>
							<p>
								<h2 class='light title-faq '>Apa itu kode Aktivasi?</h2>
									<p class='light'>Kode aktivasi merupakan kode yang diberikan oleh Admin Bonobo kepada setiap Pengguna (Toko) yang mendaftarkan akun di Bonoboapp.com.<br> Setiap kode ini bersifat unik dan hanya bisa digunakan 1 kali.</p><br>

									<h2 class='light title-faq '>Kegunaan kode aktivasi?</h2>
									<p class='light'>Kode aktivasi digunakan untuk melakukan validasi atas akun Anda.<br> Tanpa kode aktivasi, Anda tidak dapat menggunakan fitur-fitur yang ada di Bonoboapp.com. </p><br>

									<h2 class='light title-faq '>Kapan saya harus memasukkan kode Aktivasi?</h2>
									<p class='light'>- Saat Anda pertama kali mendaftarkan Akun Anda di Bonoboapp.com.<br> Di sini anda perlu memasukkan kode aktivasi untuk mem-validasi Akun Anda.</p>
									 
									<p class='light'>- Saat akun Anda expired. Setiap akun di Bonoboapp.com memiliki masa berlaku tertentu. Anda bisa melihat sisa hari aktif akun Anda di menu profile.<br> Jika akun anda sudah expired, maka Anda perlu memasukkan kode aktivasi kembali untuk memperpanjang akun Anda.</p><br>

									<h2 class='light title-faq '>Bagaimana saya mendapatkan kode Aktivasi?</h2>
									<p class='light'>Dengan melakukan langkah mudah berikut:<br>
									- Klik hyperlink 'Minta Disini' yang terdapat di halaman Aktivasi. (Halaman sebelum ini)<br>
									- Isi data dengan lengkap.<br>
									- Admin kami akan menghubungi Anda untuk menginformasikan langkah selanjutnya.<br>
									- Setelah Anda menyelesaikan langkah tersebut, kode aktivasi akan dikirimkan kepada Anda melalui email.</p><br>

									<p class='light'>Saya masih memiliki pertanyaan lanjutan
									Silakan kirimkan pertanyaan Anda ke <a href='mailto:cs@bonoboapp.com'>CS@bonoboapp.com.</a><br> Kami akan segera menjawab pertanyaan Anda.</p>
							</p>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</content>
<footer class='page-footer grey darken-3'>

	<div class='footer-copyright grey darken-4'>
		<div class='container'> 2015 Bonobo
			<a class='grey-text text-lighten-4 right' href='javascript:void(0)'>Tentang Kami</a>
			<a class='grey-text text-lighten-4 right' href='".base_url('index/pp')."'>Kebijakan privasi</a>
			<a class='grey-text text-lighten-4 right' href='".base_url('index/tos')."'>Syarat dan ketentuan</a>
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
<script type='text/javascript' src='".base_url("")."assets/jController/enduser/CtrlLicense.js'></script>
</body>
</html>
";
?>