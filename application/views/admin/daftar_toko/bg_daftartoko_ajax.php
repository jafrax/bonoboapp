<?php
echo"
<table class='table table-bordered table-striped'>
	<thead>	";
	echo "
		<tr>
			<th style='width: 10px'>
				<label>
					<input id='checkall' type='checkbox'>
				</label>
			</th>
			<th>No</th>
			<th>Nama Toko</th>
			<th>Email</th>
			<th>Email Status</th>
			<th>Account Status</th>
			<th>Berlaku s/d</th>
		</tr>
	</thead>
	<tbody>";
		 $i=0;
	if ($allToko->num_rows > 0) {
		foreach ($allToko->result() as $row) {
			$i++;
			$nama=ucwords($row->name);
		echo "
			<tr class='toko-".$row->id."'>
				<td>
					<label>
						<input class='checkboxDelete' type='checkbox' value='".$row->id."' >
					</label>
				</td>
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
				</tr>";
			}
	}else{
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
			<th>Nama Toko</th>
			<th>Email</th>
			<th>Email Status</th>
			<th>Account Status</th>
			<th>Berlaku s/d</th>
	</tfoot>
</table>
<div id='page' class='box-footer clearfix'>
$pagination
</div>";
?>
	