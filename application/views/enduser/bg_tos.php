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
						<div class='formhead center'>
							<h2 id='top' class='titmain'><b>Syarat & Ketentuan</b></h2>
						</div>

						<div class='row formbody container_custom'>
							<p>								
									<h2 class='light title-faq '>Selamat datang di www.bonoboapp.com.</h2><br>
									<p>Syarat & ketentuan yang ditetapkan di bawah ini mengatur pemakaian jasa yang ditawarkan oleh PT. Bonobo terkait penggunaan situs www.bonoboapp.com. Pengguna disarankan membaca dengan seksama karena dapat berdampak kepada hak dan kewajiban Pengguna di bawah hukum.</p>
									<p>Dengan mendaftar dan/atau menggunakan situs www.bonoboapp.com, maka pengguna dianggap telah membaca, mengerti, memahami dan menyutujui semua isi dalam Syarat & ketentuan. Syarat & ketentuan ini merupakan bentuk kesepakatan yang dituangkan dalam sebuah perjanjian yang sah antara Pengguna dengan PT. VisiONE System. Jika pengguna tidak menyetujui salah satu, sebagian, atau seluruh isi Syarat & ketentuan, maka pengguna tidak diperkenankan menggunakan layanan di www.bonoboapp.com.</p>
									<p class='light'>
									<ul>										
										<li><a href='#definisi'>A. Definisi</a></li>
										<li><a href='#akun'>B. Akun, Saldo Bonobo, Password dan Keamanan</a></li>
										<li><a href='#pembelian'>C. Transaksi Pembelian</a></li>
										<li><a href='#harga'>D. Harga</a></li>										
										<li><a href='#konten'>E. Konten</a></li>									
										<li><a href='#gantirugi'>F. Ganti Rugi</a></li>
										<li><a href='#hukum'>G. Pilihan Hukum</a></li>
										<li><a href='#update'>H. Pembaharuan</a></li>
									</ul>
									</p>
									<ol style='margin-left:15px	'>

									________________________________________
									<h3 id='definisi' class='light title-faq '>A. DEFINISI</h3>
									<p class='light'>
								<li>PT. VisiONE System adalah suatu perseroan terbatas yang menjalankan kegiatan usaha jasa web portal www.bonoboapp.com, yakni situs privat perdagangan yang dijual oleh penjual terdaftar. Selanjutnya disebut Bonobo.</li>
								<li>Situs Bonobo adalah www.bonoboapp.com.</li>
								<li>Syarat & ketentuan adalah perjanjian antara Pengguna dan Bonobo yang berisikan seperangkat peraturan yang mengatur hak, kewajiban, tanggung jawab pengguna dan Bonobo, serta tata cara penggunaan sistem layanan Bonobo.</li>
								<li>Pengguna adalah pihak yang menggunakan layanan Bonobo, termasuk namun tidak terbatas pada pembeli, penjual ataupun pihak lain yang sekedar berkunjung ke Situs Bonobo.</li>
								<li>Pembeli adalah Pengguna terdaftar yang melakukan permintaan atas Barang yang dijual oleh Penjual di Situs Bonobo.</li>
								<li>Penjual adalah Pengguna terdaftar yang melakukan tindakan buka toko dan/atau melakukan penawaran atas suatu Barang kepada para Pengguna Situs Bonobo.</li>
								<li>Barang adalah benda yang berwujud / memiliki fisik Barang yang dapat diantar / memenuhi kriteria pengiriman oleh perusahaan jasa pengiriman Barang.</li>
									</p>________________________________________
									<h3 id='akun' class='light title-faq '>B. AKUN, PASSWORD DAN KEAMANAN</h3>
									<p class='light'>
								<li>Pengguna dengan ini menyatakan bahwa pengguna adalah orang yang cakap dan mampu untuk mengikatkan dirinya dalam sebuah perjanjian yang sah menurut hukum.</li>
								<li>Pengguna yang telah mendaftar berhak bertindak sebagai:<br>
									- Pembeli<br>
									- Penjual<br>
									</li>
									<li>Pengguna yang akan bertindak sebagai Penjual diwajibkan untuk membeli kode lisensi yang dikeluarkan oleh Bonobo untuk dapat menggunakan layanan buka toko. Setelah aktivasi kode lisensi, Pengguna berhak melakukan pengaturan terhadap item-item yang akan diperdagangkan di etalase pribadi Pengguna.</li>
									<li>Bonobo tanpa pemberitahuan terlebih dahulu kepada Pengguna, memiliki kewenangan untuk melakukan tindakan yang perlu atas setiap dugaan pelanggaran atau pelanggaran Syarat & ketentuan dan/atau hukum yang berlaku, yakni tindakan berupa, penghapusan Barang, moderasi toko, penutupan toko, suspensi akun, dan/atau penghapusan akun pengguna.</li>
									<li>Bonobo memiliki kewenangan untuk menutup toko atau akun Pengguna baik sementara maupun permanen apabila didapati adanya tindakan kecurangan dalam bertransaksi untuk kepentingan pribadi Pengguna.</li>
									<li>Pengguna dilarang untuk menciptakan dan/atau menggunakan alat dan fitur otomatis yang bertujuan untuk memanipulasi data pada system Bonobo, termasuk namun tidak terbatas pada (i) manipulasi data Toko (ii) melakukan perambanan (crawling) (iii) transaksi jual beli otomatis.</li>
									<li>Pengguna bertanggung jawab secara pribadi untuk menjaga kerahasiaan akun dan password untuk semua aktivitas yang terjadi dalam akun Pengguna.</li>
									<li>Bonobo tidak akan meminta password akun Pengguna untuk alasan apapun, oleh karena itu Bonobo menghimbau Pengguna agar tidak memberikan password akun Anda kepada pihak manapun, baik kepada pihak ketiga maupun kepada pihak yang mengatasnamakan Bonobo.</li>
									<li>Pengguna setuju untuk memastikan bahwa Pengguna keluar dari akun di akhir setiap sesi dan memberitahu Bonobo jika ada penggunaan tanpa izin atas sandi atau akun Pengguna.</li>
									<li>Pengguna dengan ini menyatakan bahwa Bonobo tidak bertanggung jawab atas kerugian atau kerusakan yang timbul dari penyalahgunaan akun Pengguna.</li>
									 <a href='#top'>kembali ke atas</a>
									</p>________________________________________
									<h3 id='pembelian' class='light title-faq '>C. TRANSAKSI PEMBELIAN</h3>
									<p class='light'>
									<li>Transaksi hanya dapat dilakukan oleh Pembeli yang sudah bergabung didalam Penjual.</li>
									<li>Metode pembayaran diatur oleh Penjual dan dilakukan dalam konteks pribadi antara Pembeli dan Penjual. Bonobo tidak terlibat dan bertanggung jawab dalam hal apapun didalam transaksi yang terjadi.</li>
									<li>Pembeli memahami dan menyetujui bahwa ketersediaan stok Barang merupakan tanggung jawab Penjual yang menawarkan Barang tersebut. Terkait ketersediaan stok Barang dapat berubah sewaktu-waktu, sehingga dalam keadaan stok Barang kosong, maka penjual akan menolak order, dan pembayaran atas barang yang bersangkutan dikembalikan kepada Pembeli.</li>
									<li>Pembeli memahami dan menyetujui bahwa setiap klaim yang dilayangkan setelah adanya konfirmasi / konfirmasi otomatis penerimaan Barang adalah bukan menjadi tanggung jawab Bonobo. Kerugian yang timbul setelah adanya konfirmasi/konfirmasi otomatis penerimaan Barang menjadi tanggung jawab Pembeli secara pribadi.</li>
									<li>Pembeli memahami dan menyetujui bahwa setiap masalah pengiriman Barang yang disebabkan keterlambatan pembayaran adalah merupakan tanggung jawab dari Pembeli.</li>

									</p>________________________________________									
									<h3 id='harga' class='light title-faq '>D. HARGA</h3>
									<p class='light'>
									<li>Harga Barang yang terdapat dalam situs Bonobo adalah harga yang ditetapkan oleh Penjual. </li>
									<li>Pembeli memahami dan menyetujui bahwa kesalahan keterangan harga dan informasi lainnya yang disebabkan tidak terbaharuinya halaman situs Bonobo dikarenakan browser/ISP yang dipakai Pembeli adalah tanggung jawab Pembeli.</li>
									<li>Penjual memahami dan menyetujui bahwa kesalahan ketik yang menyebabkan keterangan harga atau informasi lain menjadi tidak benar/sesuai adalah tanggung jawab Penjual. Perlu diingat dalam hal ini, apabila terjadi kesalahan pengetikan keterangan harga Barang yang tidak disengaja, Penjual berhak menolak pesanan Barang yang dilakukan oleh pembeli.</li>
									<li>Pengguna memahami dan menyetujui bahwa setiap masalah dan/atau perselisihan yang terjadi akibat ketidaksepahaman antara Penjual dan Pembeli tentang harga bukanlah merupakan tanggung jawab Bonobo.</li>
									<li>Situs Bonobo untuk saat ini hanya melayani transaksi jual beli Barang dalam mata uang Rupiah.</li>
									 <a href='#top'>kembali ke atas</a>

									</p>________________________________________									
									<h3 id='konten' class='light title-faq '>E. KONTEN</h3>
									<p class='light'>
									<li>Dalam menggunakan layanan Situs Bonobo, Pengguna dilarang untuk menggunakan konten yang mengandung unsur SARA, diskriminasi, merendahkan/menyudutkan orang lain, bahasa vulgar/seksual, dan bersifat ancaman.</li>
									<li>Pengguna dilarang mempergunakan foto/gambar Barang yang memiliki watermark yang menandakan hak kepemilikan orang lain.</li>
									<li>Penguna dengan ini memahami dan menyetujui bahwa penyalahgunaan foto/gambar yang di unggah oleh Pengguna adalah tanggung jawab Pengguna secara pribadi.</li>
									<li>Ketika Pengguna menggungah ke Situs Bonobo dengan konten atau posting konten, Pengguna memberikan Bonobo hak non-eksklusif, di seluruh dunia, secara terus-menerus, tidak dapat dibatalkan, bebas royalti, disublisensikan ( melalui beberapa tingkatan ) hak untuk melaksanakan setiap dan semua hak cipta, publisitas , merek dagang , hak basis data dan hak kekayaan intelektual yang Pengguna miliki dalam konten, di media manapun yang dikenal sekarang atau di masa depan. Selanjutnya , untuk sepenuhnya diizinkan oleh hukum yang berlaku , Anda mengesampingkan hak moral dan berjanji untuk tidak menuntut hak-hak tersebut terhadap Bonobo.</li>
									<li>Pengguna menjamin bahwa tidak melanggar hak kekayaan intelektual dalam mengunggah konten Pengguna kedalam situs Bonobo. Setiap Pengguna dengan ini bertanggung jawab secara pribadi atas pelanggaran hak kekayaan intelektual dalam mengunggah konten di Situs Bonobo.</li>
									<li>Bonobo tidak bertanggung jawab atas konten atau produk yang dijual oleh Penjual. Permasalahan hukum yang akan timbul akibat penyalahgunaan Bonobo merupakan tanggung jawab Penjual secara utuh.</li>
									 <a href='#top'>kembali ke atas</a></p>
									 
									________________________________________
									<h3 id='gantirugi' class='light title-faq '>F. GANTI RUGI</h3>
									<p class='light'>
									<li>Pengguna akan melepaskan Bonobo dari tuntutan ganti rugi dan menjaga Bonobo (termasuk Induk Perusahaan, direktur, dan karyawan) dari setiap klaim atau tuntutan, termasuk biaya hukum yang wajar, yang dilakukan oleh pihak ketiga yang timbul dalam hal Anda melanggar Perjanjian ini, penggunaan Layanan Bonobo yang tidak semestinya dan/ atau pelanggaran Anda terhadap hukum atau hak-hak pihak ketiga.</li>
									 <a href='#top'>kembali ke atas</a></br>
									 
									________________________________________
									<h3 id='hukum' class='light title-faq '>G. PILIHAN HUKUM</h3>
									<p class='light'>									
									<li>Perjanjian ini akan diatur oleh dan ditafsirkan sesuai dengan hukum Republik Indonesia, tanpa memperhatikan pertentangan aturan hukum. Anda setuju bahwa tindakan hukum apapun atau sengketa yang mungkin timbul dari, berhubungan dengan, atau berada dalam cara apapun berhubungan dengan situs dan/atau Perjanjian ini akan diselesaikan secara eksklusif dalam yurisdiksi pengadilan Republik Indonesia.</li>
									 <a href='#top'>kembali ke atas</a></br>
									________________________________________
									<h3 id='update' class='light title-faq '>H. PEMBAHARUAN</h3>
									<p class='light'>									
									<li>Syarat & ketentuan mungkin di ubah dan/atau diperbaharui dari waktu ke waktu tanpa pemberitahuan sebelumnya. Bonobo menyarankan agar anda membaca secara seksama dan memeriksa halaman Syarat & ketentuan ini dari waktu ke waktu untuk mengetahui perubahan apapun. Dengan tetap mengakses dan menggunakan layanan Bonobo, maka pengguna dianggap menyetujui perubahan-perubahan dalam Syarat & ketentuan.</li>
									<a href='#top'>kembali ke atas</a></br></br></br>
									</ol>
							</p>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</content>
<footer class='page-footer grey darken-3 nolmar nolpad'>	
	<div class='footer-copyright grey darken-4'>
		<div class='containermain'>
			<a class='grey-text text-lighten-3' href='javascript:void(0)'>Tentang Kami</a>
			<a class='grey-text text-lighten-3' href='".base_url('index/pp')."'>Kebijakan privasi</a>
			<a class='grey-text text-lighten-3' href='".base_url('index/tos')."'>Syarat dan ketentuan</a>
			<a href='http://www.bonoboapp.com' align='center'>© 2015 Bonobo, Inc. All rights reserved.</a>
		</div>		
	</div>
</footer>


<script type='text/javascript' src='".base_url()."html/js/jquery-2.1.4.min.js'></script>
<script type='text/javascript' src='".base_url()."html/js/materialize.min.js'></script>
<script type='text/javascript' src='".base_url()."html/js/jpushmenu.js'></script>
<script type='text/javascript' src='".base_url()."html/js/chosen.jquery.js'></script>
<script type='text/javascript' src='".base_url("html/js/selectize.js")."'></script>
<script type='text/javascript' src='".base_url("assets/jLib/jQuery/jquery.price_format.2.0.min.js")."'></script>
<script type='text/javascript' src='".base_url("assets/jLib/jQuery/jquery.validate.js")."'></script>
<script type='text/javascript' src='".base_url("assets/jLib/jQuery/additional-methods.js")."'></script>
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