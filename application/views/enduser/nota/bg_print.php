<?php
echo "
<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'/>
<title>Bonobo</title>
</head>
<body class='cbp-spmenu-push cbp-spmenu-push-toleft'>
";
?>

<table border=1 cellspacing=10>
<tr>
 <td  align="center" colspan="8" ><h2 class='titmain'><b> CETAK NOTA </b></h2> </td>		
</tr>
<tr>
 <td  align="center" colspan="8" ><h3 class='titmain'><b> No Nota : <?php echo ".$nota->invoice_no."; ?> </b></h3> </td>		
</tr>
<tr>
 <td  align="center" colspan="8" ><h4 class='titmain'><b> Tanggal Pembelian : <?php  $old_date 			= $nota->create_date;
										$old_date_timestamp = strtotime($old_date);
										$date 				= date('d M Y', $old_date_timestamp);echo $date; ?> </b></h4> </td>		
</tr>

<tr>
<td colspan="8"  ></td>
</tr>
<tr>
<td colspan="8"  ></td>
</tr>
<tr>
<td colspan="8"  ></td>
</tr>

<tr>
<td align="center" colspan="2"><h4 class='titmain'><b> <?php  echo "$toko->name" ;?>  </b></h4></td>
<td align="center" colspan="2"></td>
<td align="center" colspan="2"></td>
<td align="center" colspan="2"><h4 class='titmain'><b> <?php echo "Nama Pemesan : " ?>  </b></h4></td>
</tr>
<tr>
<td align="center" colspan="2"><h4 class='titmain'><b> <?php  echo "$toko->address" ;?>  </b></h4></td>
<td align="center" colspan="2"></td>
<td align="center" colspan="2"></td>
<td align="center" colspan="2"><h4 class='titmain'><b> <?php echo  "$nota->member_name"; ?>  </b></h4></td>
</tr>
<tr>
<td align="center" colspan="2"><h4 class='titmain'><b> <?php  echo "$toko->phone" ;?>  </b></h4></td>
<td align="center" colspan="2"></td>
<td align="center" colspan="2"></td>
<td align="center" colspan="2" ><h4  class='titmain'><b> <?php  if ($nota->status == 0 ) {
								            	$status="Belum Lunas";
								            }elseif ($nota->status == 1) {								            	
								            	$status="Lunas";
								            }elseif ($nota->status == 2) {
								            	$status="Batal";
								            }	echo $status; ?>  </b></h4></td>
</tr>



<tr>
<td></td>
<td align="left" colspan="6">  
<?php echo " 
<div class='row '>";
											foreach ($produk->result() as $row_p) {
												$image = $this->model_nota->get_nota_product_image($row_p->id)->row();
												$images = base_url()."html/images/comp/product.png";
												if (count($image) > 0 ) {
													if (file_exists(base_url()."/assets/pic/product/".$image->product_image)) {
														$images = base_url()."assets/pic/product/resize/".$image->product_image;
													}										
												}
												echo "<div class='nota-product col s12 m6'>
														<img src='".$images."' class='responsive-img col s4 m4 left'>
														<div class='col s8 m8'>
															<p class='blue-text'>".$row_p->product_name."</p>
															<p >Rp. ".$row_p->price_product."</p>";

															$varian = $this->model_nota->get_varian_product($row_p->id);
															if ($varian->num_rows() > 0) {
																foreach ($varian->result() as $row_v) {
																	if ($row_v->varian_name == 'null') {
																		echo "<p >Jumlah : ".$row_v->quantity."</p>";
																	}else{
																		echo "<p >Varian : ".$row_v->varian_name." , Jumlah : ".$row_v->quantity."</p>";
																	}
																}
															}
														echo "
														</div>
													</div>";
											}
			  							echo "
						          	</div>
		"?>
</td>
<td></td>
</tr>


<tr>
<td colspan="2"><h4 class='titmain' ><b>Total Nota : </b></h4></td>
<td align="right"><?php  echo number_format($nota->price_item) ;?></td>
<td colspan="5"></td>

</tr>

<tr>
<td colspan="2" ><h4 class='titmain'><b>Biaya Kirim :  </b></h4></td>
<td align="right" ><?php  echo number_format($nota->price_shipment);?></td>
<td colspan="5"></td>	
</tr>
<?php 
if ($toko->invoice_confirm == 0) {
?>													
<tr>
<td colspan="2"><h4 class='titmain'><b> Kode Unik :   </b></h4></td>
<td align="right"><?php echo "$nota->invoice_seq_payment";?></td>
<td colspan="5"></td>	
</tr>
<?php 
} ?>
<tr>
<td colspan="3"><hr align="left"> </td>
</tr>
<tr>
<td colspan="2"><h4 class='titmain'><b> Total Transaksi :  </b></h4></td>
<td align="right" ><?php echo number_format($nota->price_total); ?></td>
<td colspan="5"></td>	
</tr>
<tr>
<td colspan="8"  ></td>
</tr>
	
	<tr>
	<td >NOTES </td>
	<td colspan="7"> </td>
	</tr>
	<tr>
	<td colspan="8"> <?php echo $nota->notes; ?> </td>
	</tr>

</table>
<?php
echo "
</body>
</html>";
?>