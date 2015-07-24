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
		";

		echo "
			<tr>
				<th>No</th>
				<th>Nama Toko</th>
				<th>Email</th>
				<th>Email Status</th>
				<th>Account Status</th>
				<th>Berlaku s/d</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>";
			$i=0;
			if ($allToko->num_rows() == 0) {
				echo "<tr>
					<td>$i</td>
					<td>Data activation kosong</td>
					<td></td>
					<td></td>                                        
					<td></td>                                        
					<td></td>                                        
				</tr>";
			}else{
				foreach ($allToko->result() as $row) {
				$i++;
			echo "
				<tr>
					<td>$i</td>
					<td>".$row->name."</td>
					<td>".$row->email."</td>
					<td>";
					if($row->status == 2){
							echo "<span class='label label-success'>Verified</span>";
					}else{
							echo "<span class='label label-danger'>! Verified</span>";
					}
					echo"
					</td>
					<td><a href='#' data-toggle='modal' data-target='.bs-example-modal-sm'><span class='label label-success'>Active</span></button></td>";
					$date_time=date('d F Y',strtotime($row->expired_on));
					echo"<td><a herf='#' data-toggle='modal' data-target='.confirm'> ".$date_time." </a> </td>
					<td>
						<button class='btn btn-warning btn-sm'>Hapus</button>
					</td>
				</tr>";
				}
			}
			echo "										
			</tbody>
		<tfoot>
			<tr>
				<th>No</th>
				<th>Nama Toko</th>
				<th>Email</th>
				<th>Email Status</th>
				<th>Account Status</th>
				<th>Berlaku s/d</th>
				<th>Action</th>
		</tfoot>
	</table>
</div><!-- /.box-body -->
<div class='box-footer clearfix'>
	$pagination
</div>";
	?>
	