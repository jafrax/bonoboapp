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
					<a href='".base_url()."'>&larr; Kembali</a>
					<form class='formain'>
						<div class='formhead'>
							<h2 id='top' class='titmain'><b>Kebijakan Privasi</b></h2>
						</div>

						<div class='row formbody'>
							<p>
								<p>Adanya Kebijakan Privasi ini adalah komitmen nyata dari Bonobo untuk menghargai dan melindungi setiap informasi pribadi Pengguna situs www.Bonobo.com (situs Bonobo).</p>
								<p>Kebijakan ini (beserta syarat-syarat penggunaan dari situs Bonobo sebagaimana tercantum dalam \"Syarat & Ketentuan\" dan dokumen lain yang tercantum di situs Bonobo) menetapkan dasar atas segala data pribadi yang Pengguna berikan kepada Bonobo atau yang Bonobo kumpulkan dari Pengguna, kemudian akan diproses oleh Bonobo mulai pada saat melakukan pendaftaran, mengakses dan menggunakan layanan Bonobo. Harap memperhatikan ketentuan di bawah ini secara seksama untuk memahami pandangan dan kebiasaan Bonobo berkenaan dengan data Bonobo memperlakukan informasi tersebut.</p>
								<p>Dengan mengakses dan menggunakan layanan situs Bonobo, Pengguna dianggap telah membaca, memahami dan memberikan persetujuannya terhadap pengumpulan dan penggunaan data pribadi Pengguna sebagaimana diuraikan di bawah ini.</p>
								<p>Kebijakan Privasi ini mungkin di ubah dan/atau diperbaharui dari waktu ke waktu tanpa pemberitahuan sebelumnya. Bonobo menyarankan agar anda membaca secara seksama dan memeriksa halaman Kebijakan Privasi ini dari waktu ke waktu untuk mengetahui perubahan apapun. Dengan tetap mengakses dan menggunakan layanan Bonobo, maka pengguna dianggap menyetujui perubahan-perubahan dalam Kebijakan Privasi ini.</p>
								<p class='light'>
								<ul>
								<li><a href='#informasi'>Informasi Pengguna</a></li>
								<li><a href='#penggunaan'>Penggunaan Informasi</a></li>
								<li><a href='#pengguna'>Pengungkapan informasi Pengguna</a></li>
								<li><a href='#merek'>Merek Dagang Bonobo</a></li>								
								<li><a href='#kritik'>Kritik dan Saran</a></li>
								</ul>
								</p>
								________________________________________
								<h3 id='informasi' class='light title-faq '>Informasi Pengguna</h3> <br>
								<p>Bonobo mengumpulkan informasi Pengguna dengan tujuan untuk memperoses dan memperlancar proses penggunaan situs Bonobo. Tindakan tersebut telah memperoleh persetujuan Pengguna pada saat pengumpulan informasi.</p>
								<p>Bonobo mengumpulkan informasi pribadi sewaktu Pengguna mendaftar ke Bonobo, sewaktu Pengguna menggunakan layanan Bonobo, sewaktu Pengguna mengunjungi halaman Bonobo atau halaman-halaman para mitra tertentu dari Bonobo, dan sewaktu Anda menghubungi Bonobo. Bonobo dapat menggabung informasi mengenai Pengguna yang kami miliki dengan informasi yang kami dapatkan dari para mitra usaha atau perusahaan-perusahaan lain.</p>
								<p>Sewaktu Anda mendaftar untuk menjadi Pengguna Bonobo, maka Bonobo akan mengumpulkan data pribadi Pengguna, yakni nama lengkap, alamat e-mail, nomor telepon yang dapat dihubungi, password dan informasi lainnya yang diperlukan. Dengan memberikan informasi / data tersebut, Anda memahami, bahwa Bonobo dapat meminta dan mendapatkan setiap informasi / data pribadi Pengguna untuk kesinambungan dan keamanan situs ini.</p>
								<p>Bonobo akan mengumpulkan dan mengolah keterangan lengkap mengenai transaksi atau penawaran atau hubungan financial lainnya yang Pengguna laksanakan melalui situs Bonobo dan mengenai pemenuhan pesanan Pengguna.</p>
								<p>Bonobo akan mengumpulkan dan mengolah data mengenai kunjungan Pengguna ke situs Bonobo, termasuk namun tidak terbatas pada data lalu-lintas, data lokasi, weblog, tautan ataupun data komunikasi lainnya, apakah hal tersebut disyaratkan untuk tujuan penagihan atau lainnya, serta sumberdaya yang Pengguna akses.</p>
								<p>Pada saat Pengguna menghubungi Bonobo, maka Bonobo menyimpan catatan mengenai korespondensi tersebut dan isi dari komunikasi antara Pengguna dan Bonobo.</p>
								<p>Pengguna memahami dan menyetujui bahwa nama Pengguna dan daerah Kota (bukan alamat lengkap) Pengguna merupakan informasi umum yang tertera di halaman profile Bonobo Pengguna.</p>
								<p>Bonobo dengan sendirinya menerima dan mencatat informasi dari komputer dan browser Pengguna, termasuk alamat IP, informasi cookie Bonobo, atribut piranti lunak dan piranti keras, serta halaman yang Pengguna minta.</p>
								<p>Setiap informasi / data Pengguna yang disampaikan kepada Bonobo dan/atau yang dikumpulkan oleh Bonobo dilindungi dengan upaya sebaik mungkin oleh perangkat keamanan teruji, yang digunakan oleh Bonobo secara elektronik. Meskipun demikian, Bonobo tidak menjamin kerahasiaan informasi yang Pengguna sampaikan tersebut, dalam kondisi adanya pihak-pihak lain yang mengambil atau mempergunakan informasi Pengguna dengan melawan hukum serta tanpa izin Bonobo.</p>
								<p>Kerahasiaan kata sandi atau password merupakan tanggung jawab masing-masing Pengguna. Bonobo tidak bertanggung jawab atas kerugian yang dapat ditimbulkan akibat kelalaian pengguna dalam menjaga kerahasiaan passwordnya.</p>
						<a href='#top'>kembali ke atas</a><br>
								________________________________________
								<h3 id='penggunaan' class='light title-faq '>Penggunaan Informasi</h3><br>
								<p>Bonobo dapat menggunakan keseluruhan informasi / data Pengguna sebagai acuan untuk upaya peningkatan produk dan pelayanan.</p>
								<p>Bonobo dapat mempergunakan dan mengolah Informasi / data Pengguna dengan tujuan untuk menyesuaikan situs Bonobo sesuai dengan minat Pengguna.</p>
								<p>Bonobo dapat menggunakan keseluruhan informasi / data Pengguna untuk kebutuhan internal Bonobo tentang riset pasar, promosi tentang produk baru, penawaran khusus, maupun informasi lain, dimana Bonobo dapat menghubungi Pengguna melalui email, surat, telepon, fax.</p>
								<p>Bonobo dapat meminta Pengguna melengkapi survei yang Bonobo gunakan untuk tujuan penelitian atau lainnya, meskipun Pengguna tidak harus menanggapinya.</p>
								<p>Bonobo dapat menghubungi Pengguna melalui email, surat, telepon, fax, termasuk namun tidak terbatas, untuk membantu dan/atau menyelesaikan proses transaksi jual beli antar Pengguna.</p>
								<p>Situs Bonobo memilki kemungkinan terhubung dengan situs-situs lain diluar situs Bonobo, dengan demikian Pengguna menyadari dan memahami bahwa Bonobo tidak turut bertanggung jawab terhadap kerahasiaan informasi Pengguna setelah Pengguna mengakses situs-situs tersebut dengan meninggalkan atau berada diluar situs Bonobo.</p>
						<a href='#top'>kembali ke atas</a><br>
								________________________________________
								<h3 id='pengguna' class='light title-faq '>Pengungkapan Informasi Pengguna</h3><br>
								<p >Bonobo menjamin tidak ada penjualan, pengalihan, distribusi atau meminjamkan informasi / data pribadi Anda kepada pihak ketiga lain, tanpa terdapat izin dari Anda. Kecuali dalam hal-hal sebagai berikut:</p>
<ol style='margin-left:15px	'>
								<p class='light'>
								
								
								<li>Apabila Bonobo secara keseluruhan atau sebagian assetnya diakuisisi atau merger dengan pihak ketiga, maka data pribadi yang dimiliki oleh pihak Bonobo akan menjadi salah satu aset yang dialihkan atau digabung.</li>
								<li>Apabila Bonobo berkewajiban mengungkapkan dan/atau berbagi data pribadi Pengguna dalam upaya mematuhi kewajiban hukum dan/atau dalam upaya memberlakukan atau menerapkan syarat-syarat penggunaan Bonobo sebagaimana tercantum dalam Syarat dan Ketentuan Layanan Bonobo dan/atau perikatan perikatan lainnya antara Bonobo dengan pihak ketiga; atau untuk melindungi hak, properti, atau keselamatan Bonobo, pelanggan Bonobo, atau pihak lain. Di sini termasuk pertukaran informasi dengan perusahaan dan organisasi lain untuk tujuan perlindungan Bonobo beserta Penggunanya termasuk namun tidak terbatas pada penipuan, kerugian financial atau pengurangan resiko lainnya.</li>
								
								</ol>
								</p><br>
						<a href='#top'>kembali ke atas</a><br>
								
								________________________________________
								<h3 id='merek' class='light title-faq '>Merek Dagang Bonobo</h3><br>
								<p>Situs Bonobo berisi materi informasi / data yang sah dan didaftarkan sesuai ketentuan yang berlaku, penyalahgunaan informasi / data yang telah terdaftar secara sah adalah pelanggaran hukum dan dapat dituntut menurut ketentuan perundang-undangan yang berlaku. Materi informasi / data dimaksud tidak terbatas pada trademark, desain, tampilan, antar muka, dan grafis.</p>
								<p>Nama dan logo \"Bonobo\" telah terdaftar secara resmi di Departemen Hukum dan Hak Asasi Manusia, Direktorat Jenderal Hak Cipta dan Hak Kekayaan Intelektual Republik Indonesia. Pihak lain dilarang oleh undang-undang untuk menggunakan atau mengatas-namakan dengan nama dan / atau logo \"Bonobo\" untuk kepentingan pribadi dan kelompok tertentu tanpa kuasa yang diberikan khusus untuk itu, dengan atau tanpa sepengetahuan Bonobo. Pelanggaran terhadap hal ini akan dikenai pasal pelanggaran hak cipta dan hak kekayaan intelektual.</p>
								<p>Tindakan hukum akan dilakukan apabila ditemui tindakan percobaan, baik yang disengaja atau tidak disengaja, untuk mengubah, mengakses halaman situs Bonobo secara paksa yang dibuat bukan untuk konsumsi publik, atau merusak situs Bonobo dan / atau perangkat server yang termuat di dalamnya, tanpa izin khusus yang diberikan oleh pengelola resmi dan sah Bonobo.</p>
						<a href='#top'>kembali ke atas</a><br>
								________________________________________
								<h3 id='kritik' class='light title-faq '>Kritik dan Saran</h3><br>
								<p >Segala jenis kritik, saran, maupun keperluan lain dapat disampaikan ke cs@bonoboapp.com.</p><br>
						<a href='#top'>kembali ke atas</a>
								<p class='light'>Pembaruan Terakhir : 15 September 2015 11:30 GMT+7</p><br>

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
<script type='text/javascript' src='".base_url("html/js/selectize.js")."'></script>
<script type='text/javascript' src='".base_url()."html/js/core.js'></script>
<script type='text/javascript' src='".base_url("")."assets/jController/enduser/CtrlLicense.js'></script>
<script>
// handle links with @href started with '#' only
$(document).on('click', 'li a[href^=\"#\"]', function(e) {
    // target element id
    var id = $(this).attr('href');

    // target element
    var id = $(id);
    if (id.length === 0) {
        return;
    }

    // prevent standard hash navigation (avoid blinking in IE)
    e.preventDefault();

    // top position relative to the document
    var pos = $(id).offset().top;

    // animated top scrolling
    $('body, html').animate({scrollTop: pos,  duration: 5000,  easing: 'easein' });
});
</script>
</body>
</html>
";
?>