<?php
echo "
<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'/>
<title>Bonobo</title>

<link rel='icon' href='".base_url()."html/images/comp/icon.ico' type='image/gif' sizes='16x7'>

<link type='text/css' rel='stylesheet' href='".base_url()."html/css/materialize.min.css'  media='screen,projection'/>
<link type='text/css' rel='stylesheet' href='".base_url()."html/css/font-awesome.min.css' />
<link type='text/css' rel='stylesheet' href='".base_url()."html/css/jpushmenu.css' />
<link type='text/css' rel='stylesheet' href='".base_url()."html/css/chosen.css' />

<link type='text/css' rel='stylesheet' href='".base_url()."html/css/style.css' />
<link type='text/css' rel='stylesheet' href='".base_url()."html/css/tablet.css' />
<link type='text/css' rel='stylesheet' href='".base_url()."html/css/mobile.css' />
<link type='text/css' rel='stylesheet' href='".base_url()."html/css/comp.css' />

</head>
<body class='cbp-spmenu-push cbp-spmenu-push-toleft' onload=window.print();window.close()>

<content>
	<div class='contentmain'>
		<div class='containermain'>
			<div class='row contentsebenarya'>
				<div class='col s12 m12 l12'>
					<div class='formain'>
						<div class='formhead'>
							<h2 class='titmain'><b>CETAK NOTA</b></h2>
						</div>


						<div class='row formbody'>
							<!-- nota -->
							<div class=' s12 m12'>								
      							<div class='notacard card-panel grey lighten-5 z-depth-1'>
						          	<div class='row '>		
						          		<div class='col s6 m6 l3'><img class='responsive-img logo' src='".base_url()."html/images/comp/logo_shadow.png' /></div>
						            	<div class='col s6 m6 l9'>
							              	<p class='blue-grey-text lighten-3 right'>".date('d F Y')."</p>
							              	<br>
							            </div>
						          	</div>
						          	<div class='row center'>
							            <h5><b>Nota Pemesanan</b></h5>
							            <h6>No. Nota: ".$nota->invoice_no."</h6>";
					            		$old_date 			= $nota->create_date;
										$old_date_timestamp = strtotime($old_date);
										$date 				= date('d F Y', $old_date_timestamp);
										
					            		echo"
							            <h6>Tanggal pembelian : $date</h6>
						          	</div>
						          	<div class='row '>
						          		<div class='col s12 m6 l6'>
						          			<h6><b>".$toko->name."</b></h6>
						          			<p>".$toko->address."</p>
						          			<p>".$toko->phone."</p>
						          		</div>
						          		<div class='col s12 m6 l6 right-align'>
						          			<h6><b>Nama pemesan : ".$nota->member_name."</b></h6>";
								            if ($nota->status == 0 ) {
								            	echo "<h5 class='red-text'>Belum Lunas</h5>";
								            }elseif ($nota->status == 1) {								            	
								            	echo "<h5 class='green-text'>Lunas</h5>";
								            }elseif ($nota->status == 2) {
								            	echo "<h5 class='grey-text'>Batal</h5>";
								            }									
											echo"						          			
						          		</div>
						          	</div>
						          	<div class='row '>";
											foreach ($produk->result() as $row_p) {
												$image = $this->model_nota->get_nota_product_image($row_p->id)->row()->image;
												if ($image) {
													$images = base_url()."assets/pic/product/resize/".$image;
												}else{
													$images = base_url()."html/images/comp/product.png";
												}
												echo "<div class='nota-product col s12 m6'>
														<img src='".$images."' class='responsive-img col s4 m4 left'>
														<div class='col s8 m8'>
															<p class='titleproduct'><b >".$row_p->product_name."</b></p>
															<p >Rp. ".number_format($row_p->price, 2 , ',' , '.')."</p>
															<p >Jumlah : ".$row_p->quantity."</p>
														</div>
													</div>";
											}
			  							echo "
						          	</div>
						          	<div class='row '>
										<dl class='dl-horizontal col s12 m10 l5 fontbig'>
											<dt>Total Nota :</dt>
											<dd><p class='green-text'>RP. ".number_format($nota->price_total, 2 , ',' , '.')."</p></dd>
											<dt>Biaya Kirim :</dt>
											<dd><p class='green-text'>RP. ".number_format($nota->price_shipment, 2 , ',' , '.')."</p></dd>
											";
												if ($toko->invoice_confirm == 0) {
													echo "<dt>Kode Unik :</dt>
											<dd><p class='green-text'>".$nota->invoice_seq_payment."</p></dd>";
												}
												echo"
											<hr>
											<dt>Total Transaksi :</dt>
											<dd><p class='green-text'>RP. ".number_format($nota->price_total_transaction, 2 , ',' , '.')."</p></dd>
										</dl>
						          	</div>
						          	<div class='row footernota'>
						          		<h6>Notes :</h6>
						          		<p>".$nota->notes."</p>
						          	</div>
						        </div>
							</div>	

							<!-- nota -->
				
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</content>

<script type='text/javascript' src='".base_url()."html/js/jquery-2.1.4.min.js'></script>
<script type='text/javascript' src='".base_url()."html/js/materialize.min.js'></script>
<script type='text/javascript' src='".base_url()."html/js/jpushmenu.js'></script>
<script type='text/javascript' src='".base_url()."html/js/chosen.jquery.js'></script>

<script type='text/javascript' src='".base_url()."html/js/core.js'></script>
</body>
</html>";
?>