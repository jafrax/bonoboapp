<?php
echo "
<table class='table table-bordered table-striped'>
	<thead>
		<tr>
			<th style='width: 10px'>
				<label>
					<input id='checkall' type='checkbox'>
				</label>
			</th>
			<th>No</th>
			<th>Lokasi Awal</th>
			<th>Lokasi Tujuan</th>
			<th>Harga Per Kg</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>";
	$i=0;
	if ($allDKurir->num_rows > 0){
		foreach($allDKurir->result() as $row ){
		$i++;
		echo "
		<tr class='toko-".$row->id."'>
			<td>
				<label>
					<input class='checkboxDelete' type='checkbox' value='".$row->id."' >
				</label>
			</td>
			<td>$i</td>
			<td><span id='fp-".$row->id."'>".$row->location_from_province."</span> /
				<span id='fc-".$row->id."'> ".$row->location_from_city." </span> /
				<span id='fk-".$row->id."'> ".$row->location_from_kecamatan." </span>
			
			</td>
			<td><span id='fp-".$row->id."'>".$row->location_to_province."</span> /
				<span id='fc-".$row->id."'> ".$row->location_to_city." </span> /
				<span id='fk-".$row->id."'> ".$row->location_to_kecamatan." </span>
			</td>
			<td>".$row->price."</td>
			<td>
				<button data-toggle='modal' data-target='.bs-edit-modal-sm' class='btn btn-primary btn-sm'>Edit</button>
				<button data-toggle='modal' data-target='.confirm' class='btn btn-warning btn-sm'>Hapus</button>
			</td>
		</tr>";
		}
	  } else {
			if(isset($search)){
					echo "<tr><td colspan='8'><center>Tidak ditemukan pencarian dengan keyword <b>$search</b></center></td></tr>";
				}else{
					echo "<tr><td colspan='8'><center>zero</center></td></tr>";
				}
	  }
		
	echo "
	</tbody>
	<tfoot>
		<tr>
			<th style='width: 10px'>
				<label>
					<input id='checkall' type='checkbox'>
				</label>
			</th>
			<th>No</th>
			<th>Lokasi Awal</th>
			<th>Lokasi Tujuan</th>
			<th>Harga Per Kg</th>
			<th>Action</th>
	</tfoot>
</table>
<div class='box-footer clearfix'>
$pagination
</div>
"; ?>