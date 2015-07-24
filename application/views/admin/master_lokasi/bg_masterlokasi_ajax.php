<?php 
echo"
<div class='box-body table-responsive'>
	<div class='box-tools'>
		<div class='input-group'>
			<input type='text' name='table_search' class='form-control input-sm pull-right' style='width: 150px;' placeholder='Search'/>
			<div class='input-group-btn'>
				<button class='btn btn-sm btn-default'><i class='fa fa-search'></i></button>
			</div>
		</div>
	</div><br>
	<table class='table table-bordered table-striped'>
		<thead>
			<tr>
				<th>No</th>
				<th>Kodepos</th>
				<th>Keluarahan</th>
				<th>Kecamatan</th>
				<th>Kota</th>
				<th>Propinsi</th>
			</tr>
		</thead>
		<tbody>";
		$i=0;
		foreach ($allMLokasi->result() as $row ){
		$i++;
		echo "
			<tr>
				<td>$i</td>
				<td>".$row->postal_code."</td>
				<td>".$row->kelurahan."</td>
				<td>".$row->kecamatan."</td>
				<td>".$row->city."</td>
				<td>".$row->province."</td>
			</tr>
			";
		}
		echo "	
		</tbody>
		<tfoot>
			<tr>
				<th>No</th>
				<th>Kodepos</th>
				<th>Keluarahan</th>
				<th>Kecamatan</th>
				<th>Kota</th>
				<th>Propinsi</th>
		</tfoot>
	</table>
</div><!-- /.box-body -->
<div class='box-footer clearfix'>
	$pagination
</div>
";
?>