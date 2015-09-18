<?php
echo "

				<div class='col s12 m12 l12'>
					<div id='notif'>
					</div>";		
					$date1 = date("Y-m-d");
					$date2 = $_SESSION['bonobo']['expired_on'];

					$diff = abs(strtotime($date2) - strtotime($date1));

					$years = floor($diff / (365*60*60*24));
					$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
					$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
					
					$old_date 	= $_SESSION['bonobo']['expired_on'];
					$old_date_timestamp = strtotime($old_date);
					$date 		= date('d M Y', $old_date_timestamp);

					//JADUL
					/*echo "$years years, $months months, $days days\n";			
					$date1 = new DateTime($_SESSION['bonobo']['expired_on']);
					$date2 = new DateTime();
					$interval = $date1->diff($date2);
					echo $_SESSION['bonobo']['expired_on'];
					echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; */


					if (date('Y-m-d') < $_SESSION['bonobo']['expired_on']) {
						echo "<div class='card-panel red panel-day-left'>
				      <span class='white-text '>Sisa waktu aktif akun Anda : <b class='white-text' style='text-decoration:underline; font-size:24px'>".$years." Tahun, ".$months." Bulan, ".$days." Hari lagi</b></span><br>
				      <span class='white-text '>Masa aktif sampai tanggal : <b class='white-text' style='text-decoration:underline; font-size:24px'>".$date."</b></span>
				    </div>";
					}
					echo"
					<form class='formain' id='form-license'>
						<div class='formhead'>
							<h2 class='titmain'><b>KODE AKTIVASI</b></h2>
						</div>
						<div class='row formbody'>
							<div class='nolautomar'>
								<div class='linehead center'><h5 class='light'>Silahkan masukan Kode Aktivasi</h5></div>								
								<div class='input-field col s12 nolpad'>
									<h5><br></h5>
								</div>
								<div class='input-field col s12 m6 l3 nolpad'>
									<input id='kode1' name='kode1' type='text' class='center-align validate numbersOnly' maxlength='4' placeholder='XXXX'>
									<label for='kode1' class='error '></label>
								</div>
								<div class='input-field col s12 m6 l3 nolpad'>
									<input id='kode2' name='kode2' type='text' class='center-align validate numbersOnly' maxlength='4' placeholder='XXXX'>
									<label for='kode2' class='error '></label>
								</div>
								<div class='input-field col s12 m6 l3 nolpad'>
									<input id='kode3' name='kode3' type='text' class='center-align validate numbersOnly' maxlength='4' placeholder='XXXX'>
									<label for='kode3' class='error '></label>
								</div>
								<div class='input-field col s12 m6 l3 nolpad'>
									<input id='kode4' name='kode4' type='text' class='center-align validate numbersOnly' maxlength='4' placeholder='XXXX'>
									<label for='kode4' class='error '></label>
								</div>
							</div>
							<div class='nolautomar captcha' style=' overflow:hidden; text-align:center; float:none; padding:15px 0; ' >
								<label id='error-captcha'  style='display:none;color:red'></label>
								".$captcha."								
							</div>
							<div class='nolautomar center'>
								<button class='btn waves-effect waves-light' type='button' name='action' id='ok-btn' onclick=javascript:verifikasi(".$_SESSION['bonobo']['id'].") >Ok</button>";
								if ($months == 0 && $years == 0 && $days >= 0 && date('Y-m-d') <= $_SESSION['bonobo']['expired_on']) {
									echo "<button class='btn waves-effect waves-light red' type='button' onclick='location.href=\"".base_url()."toko\"' name='action'>Skip</button>";
								}

								echo"
							</div>
							<div class='nolautomar'>
								<p class='center upbottom'>Ingin tau lebih banyak tentang halaman ini ? <a href='".base_url()."license/faq/'>Pelajari lebih lanjut</a>
								<br><br>Belum punya Kode Aktivasi ? <a href='".base_url()."license/minta_disini/'>Minta disini</a></p>
							</div>
						</div>
					</form>

				</div>
			
<script type='text/javascript' src='".base_url("")."assets/jController/enduser/CtrlLicense.js'></script>

";
?>