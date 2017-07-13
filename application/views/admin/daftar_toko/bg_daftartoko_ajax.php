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
			<th>PIN Toko</th>
			<th>Email</th>
			<th>Account Status</th>
			<th>Berlaku s/d</th>
		</tr>
	</thead>
	<tbody>";
		 $i=0;
	if ($this->uri->segment(4)!= ''){
		$i = $this->uri->segment(4);
	}
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
				<td>".$row->tag_name."</td>
				<td>".$row->email."</td>
				<td>";
					if($row->status == 2){
						echo "<button class='btn btn-info btn-sm btn-toko-".$row->id."' data-toggle='modal' data-target='.box-toko_suspend".$row->id."' >Suspend</button>";
						echo "
							<div class='modal fade box-toko_suspend".$row->id."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
								<div class='modal-dialog modal-sm'>
									<div class='modal-content'>
										<div class='box box-solid box-danger'>
											<div class='box-header'>
												<h3 class='box-title'>Confirmation</h3>
												<div class='box-tools pull-right'>
													<button class='btn btn-danger btn-sm' class='close' data-dismiss='modal' aria-label='Close'><i class='fa fa-times'></i></button>
												</div>
											</div>
											<div class='box-body body-delete' style='display: block;'>
												<p>
													Suspend Toko ".$nama."
												</p>
											</div><!-- /.box-body -->
											<div class='box-footer'>
												<button type='button' class='btn btn-danger delete-ok' data-dismiss='modal' onclick=javascript:toko_suspend('".$row->id."')>Ok</button>
												<button type='button' class='btn btn-danger delete-cancel' data-dismiss='modal'>Cancel</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							";
					
					}else if($row->status == 3) {
						echo "<button class='btn btn-danger btn-sm btn-toko-".$row->id."'  data-toggle='modal' data-target='.box-toko_unsuspend".$row->id."' >Unsuspend</button>";
						echo "<div class='modal fade box-toko_unsuspend".$row->id."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
								<div class='modal-dialog modal-sm'>
									<div class='modal-content'>
										<div class='box box-solid box-danger'>
											<div class='box-header'>
												<h3 class='box-title'>Confirmation</h3>
												<div class='box-tools pull-right'>
													<button class='btn btn-danger btn-sm' class='close' data-dismiss='modal' aria-label='Close'><i class='fa fa-times'></i></button>
												</div>
											</div>
											<div class='box-body body-delete' style='display: block;'>
												<p>
													Aktifkan Toko ".$nama."
												</p>
											</div><!-- /.box-body -->
											<div class='box-footer'>
												<button type='button' class='btn btn-danger delete-ok' data-dismiss='modal' onclick=javascript:toko_unsuspend('".$row->id."')>Ok</button>
												<button type='button' class='btn btn-danger delete-cancel' data-dismiss='modal'>Cancel</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							";
					}
					echo "
				</td>";
				$date_time=date('d M Y',strtotime($row->expired_on));
				echo"<td><a href='#' id='tanggalmu".$row->id."' onClick=javascript:tanggal_modal('".$row->id."')> ".$date_time." </a> </td>
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
			<th>PIN Toko</th>
			<th>Email</th>
			<th>Account Status</th>
			<th>Berlaku s/d</th>
	</tfoot>
</table>
<div id='page' class='box-footer clearfix'>
$pagination
</div>";
?>
	