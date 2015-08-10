<?php echo "
<table class='table table-bordered table-striped'>
	<thead>
		<tr>
			<th style='width: 10px'>
				<input type='checkbox' id='checkall' >
			</th>
			<th>No</th>
			<th>Nama Admin</th>
			<th>Email Admin</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>";
	$i=0;
		if($Account->num_rows() >0){
			foreach($Account->result() as $row){
				$i++;
				echo "
					<tr>
						<td>";
							if($_SESSION["bonobo_admin"]->id == $row->id || $row->id == 1){
								 
							}else{
								echo "<input type='checkbox' class='checkboxDelete' value='".$row->id."'>";   
							}
							echo "
						</td>
						<td>$i</td>
						<td id='nama-".$row->id."' >".$row->name."</td>
						<td>".$row->email."</td>
						<td>";
							if($_SESSION["bonobo_admin"]->id == $row->id){
								echo "<button class='btn btn-default btn-sm' >Reset password</button>";
							}else{
								echo "<button class='btn btn-info btn-sm' onclick=javascript:account_reset_modal('".$row->id."','".base64_encode($row->name)."') >Reset password</button>";
							}
							echo "
							
							<button class='btn btn-info btn-sm' onclick=javascript:account_modal('".$row->id."') >Edit</button>
						</td>
					</tr>
				";
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
				<input type='checkbox' id='checkall' >
			</th>
			<th>No</th>
			<th>Nama Admin</th>
			<th>Email Admin</th>
			<th>Action</th>
		</tr>
	</tfoot>
</table>
<div class='box-footer clearfix'>
	<div class='pagination pagination-sm no-margin pull-right'>
		$pagination
	</div>
</div>
";?>