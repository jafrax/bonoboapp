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
					<a href='#'>Hapus</a>
				</div>
			</td>
		</tr>
	";
}
?>