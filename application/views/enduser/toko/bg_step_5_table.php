<?

foreach($Rates as $Rate){
	echo"
		<tr>
			<td>
				<div class='input-field table'>
					".$Rate->location_to_province."
				</div>
			</td>
			<td>
				<div class='input-field table'>
					".$Rate->location_to_city."
				</div>
			</td>
			<td>
				<div class='input-field table'>
					".$Rate->location_to_kecamatan."
				</div>
			</td>
			<td>
				<div class='input-field table'>Rp. ".number_format($Rate->price, 2 , ',' , '.')." 
					
				</div>
			</td>
			<td>
				<div class='input-field table'>
					<a href='#divFormRate' onclick=ctrlShopStep7.initPopupRateAdd(".$Rate->id."); class='modal-trigger col waves-effect waves-light'>Edit</a>
					<a href='javascript:void(0);' onclick=ctrlShopStep7.doRateDelete(".$Rate->id."); class='modal-trigger col waves-effect waves-light'>Hapus</a>
				</div>
			</td>
		</tr>
	";
}

echo"<script>
$(document).ready(function() {
		/*NUMBER FORMAT*/
	$('input.price').priceFormat({	    
	    limit: 12,
    	centsLimit: 0,
		centsSeparator: '',
    	thousandsSeparator: '.',
    	prefix: 'Rp. ',
	});
	/*NUMBER FORMAT*/
});
</script>";
?>