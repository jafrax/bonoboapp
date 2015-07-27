<?php
echo "
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
		if ($allPembeli->num_rows > 0) {
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
		}else{
			echo "<tr>
					<td colspan='4'>Zero</td>                                       
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
<div class='box-footer clearfix'>
	$pagination
</div>
";
?>