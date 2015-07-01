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
					<a href='#'>Edit</a>
					<a href='javascript:void(0);' onclick=ctrlShopStep5.doRateDelete(".$Rate->id.")>Hapus</a>
				</div>
			</td>
		</tr>
	";
}
?>