<?php 
echo"
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
	if ($this->uri->segment(4)!= ''){
			$i = $this->uri->segment(4);
		}
	if($allMLokasi->num_rows > 0){
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
	}else{
		if(isset($search)){
                echo "<tr><td colspan='6'><center>Tidak ditemukan pencarian dengan keyword <b>$search</b></center></td></tr>";
            }else{
                echo "<tr><td colspan='6'><center>zero</center></td></tr>";
            }
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
<div class='box-footer clearfix'>
	$pagination
</div>
";
?>