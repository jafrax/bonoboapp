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
			<td><span id='tp-".$row->id."'>".$row->location_to_province."</span> /
				<span id='tc-".$row->id."'> ".$row->location_to_city." </span> /
				<span id='tk-".$row->id."'> ".$row->location_to_kecamatan." </span>
			</td>
			<td><span id='pr-".$row->id."'>".$row->price."</span></td>
			<td>
				<button data-toggle='modal' data-target='.bs-edit-modal-sm-".$row->id."' class='btn btn-primary btn-sm' onClick=javascript:dkurir_modal('".$row->id."') >Edit</button>
			</td>
		</tr>
		<div class='modal fade bs-edit-modal-sm-".$row->id."' id='bs-edit-modal-sm-".$row->id."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
		  <div class='modal-dialog modal-sm'>
			<div class='modal-content'>
				<div class='box box-primary'>
			<div id='edit_dk".$row->id."'>
			</div>
			</div><!-- /.box -->
					</div>
				  </div>								
		</div>
		";
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