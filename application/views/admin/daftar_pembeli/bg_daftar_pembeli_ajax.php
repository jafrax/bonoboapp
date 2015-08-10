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
				<th>Nama Pembeli</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>";
		$i=0;
		if ($this->uri->segment(4)!= ''){
			$i = $this->uri->segment(4);
		}
		if ($allPembeli->num_rows > 0) {
		foreach($allPembeli->result() as $row){
			$i++;
			$nama=ucwords($row->name);
				echo "
				<tr>
					<td>
						<label>
							<input class='checkboxDelete' type='checkbox' value='".$row->id."' >
						</label>
					</td>
					<td>$i</td>
					<td>".$nama."</td>
					<td>".$row->email."</td>
				</tr>";
			}
		}else{
			if(isset($search)){
                echo "<tr><td colspan='6'><center>Tidak ditemukan pencarian dengan keyword <b>$search</b></center></td></tr>";
            }else{
                echo "<tr><td colspan='6'><center>zero</center></td></tr>";
            }
		}
		echo"
		</tbody>
		<tfoot>
			<tr>
				<th style='width: 10px'>
					<label>
						<input id='checkall' type='checkbox'>
					</label>
				</th>
				<th>No</th>
				<th>Nama Pembeli</th>
				<th>Email</th>
		</tfoot>
	</table>
<div class='box-footer clearfix'>
	$pagination
</div>
";
?>