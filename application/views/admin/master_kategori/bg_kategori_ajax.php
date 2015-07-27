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
				<th>Nama Kategori</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>";
		$i=0;
		if ($allMKategori->num_rows > 0){
		foreach ($allMKategori->result() as $row ){
				$i++;
				echo "
				<tr class='toko-".$row->id."'>
					<td>
						<label>
							<input class='checkboxDelete' type='checkbox' value='".$row->id."' >
						</label>
					</td>
					<td>$i</td>
					<td>".$row->name."</td>
					<td>
						<button data-toggle='modal' data-target='.bs-edit-modal-sm' class='btn btn-primary btn-sm'>Edit</button>
					</td>
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
				<th>Nama Kategori</th>
				<th>Action</th>
		</tfoot>
	</table>
<div class='box-footer clearfix'>
	$pagination
</div>
";
?>