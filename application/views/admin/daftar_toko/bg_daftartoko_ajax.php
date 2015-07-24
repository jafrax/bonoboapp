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
			foreach ($allToko->result() as $row) {
			$i++;
			$nama=ucwords($row->name);
			echo "
			<tr class='toko-".$row->id."'>
				<td>$i</td>
				<td>".$nama."</td>
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
				echo"<td><a href='#' data-toggle='modal' data-target='.confirm_".$row->id."'> ".$date_time." </a> </td>
					<div class='modal fade confirm_".$row->id."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
					  <div class='modal-dialog modal-sm'>
						<div class='modal-content'>
							<div class='box box-solid box-danger'>
								<div class='box-header'>
									<h3 class='box-title'>Confirmation</h3>
									<div class='box-tools pull-right'>
										<button class='btn btn-danger btn-sm' data-widget='collapse'><i class='fa fa-minus'></i></button>
										<button class='btn btn-danger btn-sm' class='close' data-dismiss='modal' aria-label='Close'><i class='fa fa-times'></i></button>
									</div>
								</div>
								<div class='box-body' style='display: block;'>
									Box class: <code>.box.box-solid.box-primary</code>
									<p>
									</p>
								</div><!-- /.box-body -->
								<div class='box-footer'>
									<button type='submit' class='btn btn-danger'>Ok</button>
									<button type='submit' class='btn btn-danger'>Cancel</button>
								</div>
							</div>
						</div>
					  </div>
					</div>
				<td><a href='#' class='btn btn-warning btn-sm' data-target='.delete_".$row->id."' data-toggle='modal'>Hapus</a></td>
				<div class='modal fade delete_".$row->id."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
					  <div class='modal-dialog modal-sm'>
						<div class='modal-content'>
							<div class='box box-solid box-danger'>
								<div class='box-header'>
									<h3 class='box-title'>Confirmation</h3>
									<div class='box-tools pull-right'>
										<button class='btn btn-danger btn-sm' data-widget='collapse'><i class='fa fa-minus'></i></button>
										<button class='btn btn-danger btn-sm' class='close' data-dismiss='modal' aria-label='Close'><i class='fa fa-times'></i></button>
									</div>
								</div>
								<div class='box-body' style='display: block;'>
									<span> Apakah anda yakin ingin menghapus '".$nama."' ? </span>
									<br/>
								</div><!-- /.box-body -->
								<div class='box-footer'>
									<button type='button' class='btn btn-danger' data-dismiss='modal' onclick='javascript:delete_dt(".$row->id.")'>Ya</button>
									<button type='button' class='btn btn-danger' data-dismiss='modal'>Tidak</button>
								</div>
							</div>
						</div>
					  </div>
					</div>
			</tr>";
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
	