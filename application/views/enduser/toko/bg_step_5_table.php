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
				<div class='input-field table'>
					".$Rate->price."
				</div>
			</td>
			<td>
				<div class='input-field table'>
					<a href='#divFormRate' onclick=ctrlShopStep7.initPopupRateAdd(".$Rate->id."); class='modal-trigger'>Edit</a>
					<a href='javascript:void(0);' onclick=ctrlShopStep7.doRateDelete(".$Rate->id.");>Hapus</a>
				</div>
			</td>
		</tr>
	";
}

echo"<script>$('.modal-trigger').leanModal();</script>";
?>