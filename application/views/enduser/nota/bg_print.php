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

<table width="372" border=1 cellspacing="0" >
<tr>
 <td  align="center" colspan="10" ><h2 class='titmain'><b> CETAK NOTA </b></h2> </td>		
</tr>
<tr>
 <td  align="center" colspan="10" ><h3 class='titmain'><b> No Nota : <?php echo $nota->invoice_no; ?> </b></h3> </td>		
</tr>
<tr>
 <td  align="center" colspan="10" ><h4 class='titmain'><b> Tanggal Pembelian : <?php  $old_date = $nota->create_date; $old_date_timestamp = strtotime($old_date);
										$date 				= date('d M Y', $old_date_timestamp);echo $date; ?> </b></h4> </td>		
</tr>

<tr>
<td colspan="10"  ></td>
</tr>
<tr>
<td colspan="10"  ></td>
</tr>

<tr>
<td align="center" colspan="3"><h4 class='titmain'><b> <?php  echo "$toko->name" ;?>  </b></h4></td>
<td align="center" colspan="2"></td>
<td align="center" colspan="5"><h4 class='titmain'><b> <?php echo "Nama Pemesan : " ?>  </b></h4></td>
</tr>
<tr>
<td align="center" colspan="3"><h4 class='titmain'><b> <?php  echo "$toko->address" ;?>  </b></h4></td>
<td align="center" colspan="2"></td>
<td align="center" colspan="5"><h4 class='titmain'><b> <?php echo  "$nota->member_name"; ?>  </b></h4></td>
</tr>
<tr>
<td align="center" colspan="3"><h4 class='titmain'><b> <?php  echo "$toko->phone" ;?>  </b></h4></td>
<td align="center" colspan="2"></td>
<td align="center" colspan="5" ><h4  class='titmain'><b> <?php  if ($nota->status == 0 ) {
								            	$status="Belum Lunas";
								            }elseif ($nota->status == 1) {								            	
								            	$status="Lunas";
								            }elseif ($nota->status == 2) {
								            	$status="Batal";
								            }	echo $status; ?>  </b></h4></td>
</tr>


<tr>
<td colspan="10"  ></td>
</tr>
<tr>
<td colspan="10"  ></td>
</tr>


<?php 
foreach ($produk->result() as $row_p) {
$image = $this->model_nota->get_nota_product_image($row_p->id)->row();
//$images = base_url()."html/images/comp/product.png";
if (count($image) > 0 ) {
if (file_exists(base_url()."assets/pic/product/".$image->product_image)) {
		$images = base_url()."assets/pic/product/resize/".$image->product_image;
	}else{
		$images = base_url()."html/images/comp/product.png";
	}
} 
?>



<tr>
  <td colspan="2"><img src="<?php echo $images; ?>" width="50" height="50" ></td>
  <td colspan="7"><h4 class='titmain'><b> <?php echo $row_p->product_name; ?></b></h4>  </td>
  <td width="71" rowspan="5">
    <?php 
$varian = $this->model_nota->get_varian_product($row_p->id);
$total=0;
if ($varian->num_rows() > 0) {
foreach ($varian->result() as $row_v) {
	$total=$total + $row_v->quantity;
	if ($row_v->varian_name <> 'null') {
	?>
  <table  border="0">
    <tr>
      <td><?  echo $row_v->varian_name; echo " = "; echo $row_v->quantity; ?></td>
      </tr>
  </table>
  <?   }
	}
}
?>
    
    
  </td>
  </tr>

<tr>
  <td colspan="2">&nbsp;</td>
<td colspan="7"><?php echo "Harga Satuan @".$row_p->price_product; ?></td>
</tr>

<tr>
  <td colspan="2">&nbsp;</td>
<td colspan="7"><?php echo "Total = ".$total; ?></td>
</tr>

<tr>
  <td colspan="2">&nbsp;</td>
<td colspan="7"><?php $hargatotal= $total * $row_p->price_product; echo "Harga Total = Rp".$hargatotal;   ?></td>
</tr>

<tr>
  <td colspan="2">&nbsp;</td>
<td colspan="2"></td>
<td width="10">&nbsp;</td>
<td colspan="4"></td>
</tr>

<tr>
<td colspan="10" align="center"><hr align="center"> </td>
</tr>


<?php } ?>
<tr>
<td colspan="10"  ></td>
</tr>

<tr>
<td colspan="2"><h4 class='titmain' ><b>Total Nota : </b></h4></td>
<td width="49" align="right"><?php  echo number_format($nota->price_item) ;?></td>
<td colspan="7"></td>

</tr>

<tr>
<td colspan="2" ><h4 class='titmain'><b>Biaya Kirim :  </b></h4></td>
<td align="right" ><?php  echo number_format($nota->price_shipment);?></td>
<td colspan="7"></td>	
</tr>
<?php 
if ($toko->invoice_confirm == 0) {
?>													
<tr>
<td colspan="2"><h4 class='titmain'><b> Kode Unik :   </b></h4></td>
<td align="right"><?php echo "$nota->invoice_seq_payment";?></td>
<td colspan="7"></td>	
</tr>
<?php 
} ?>
<tr>
<td colspan="3"><hr align="left"> </td>
</tr>
<tr>
<td colspan="2"><h4 class='titmain'><b> Total Transaksi :  </b></h4></td>
<td align="right" ><?php echo number_format($nota->price_total); ?></td>
<td colspan="7"></td>	
</tr>
<tr>
<td colspan="10"  ></td>
</tr>
	
	<tr>
	<td width="113" >NOTES </td>
	<td colspan="9"> </td>
	</tr>
	<tr>
	<td colspan="10" > <?php echo $nota->notes; ?> </td>
	</tr>

</table>
<?php
echo "
</body>
</html>";
?>