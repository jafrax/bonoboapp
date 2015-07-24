<?php
echo "
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
				<th>Nama Pembeli</th>
				<th>Email</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>";
		$i=0;
		foreach($allPembeli->result() as $row){
		$i++;
		$nama=ucwords($row->name);
			echo "
			<tr>
				<td>$i</td>
				<td>".$nama."</td>
				<td>".$row->email."</td>
				<td>
					<button data-toggle='modal' data-target='.confirm' class='btn btn-warning btn-sm' >Hapus</button>
				</td>
			</tr>";
		}
		echo"
		</tbody>
		<tfoot>
			<tr>
				<th>No</th>
				<th>Nama Pembeli</th>
				<th>Email</th>
				<th>Action</th>
		</tfoot>
	</table>
</div><!-- /.box-body -->
<div class='box-footer clearfix'>
	$pagination
</div>
";
?>