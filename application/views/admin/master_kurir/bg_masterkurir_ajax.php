<?php
echo"
<table class='table table-bordered table-striped'>
	<thead>
		<tr>
			<th style='width: 10px'>
				<label>
					<input id='checkall' type='checkbox'>
				</label>
			</th>
			<th>No</th>
			<th>Nama kurir</th>
			<!--<th>Logo</th>-->
			<th>Action</th>
		</tr>
	</thead>
	<tbody>";
	$i=0;
	if ($this->uri->segment(4)!= ''){
			$i = $this->uri->segment(4);
		}
	if ($allMKurir->num_rows > 0){
	foreach ($allMKurir->result() as $row ){
	$id_link=base64_encode($row->id);
			$i++;
			$image = base_url().'html/admin/img/credit/dummy_logo.png';
			if(!empty($row->image) && file_exists("./assets/pic/kurir/".$row->image)){
				$image = base_url("assets/pic/kurir/resize/".$row->image);
			}
			echo "
			<tr class='toko-".$row->id."'>
				<td>
					<label>
						<input class='checkboxDelete' type='checkbox' value='".$row->id."' >
					</label>
				</td>
				<td>$i</td>
				<td id='nama-".$row->id."'>".$row->name."</td>
				<!--<td><img class='logokurir' src='$image' /></td>-->
				<td>
					<button class='btn btn-primary btn-sm' onClick=javascript:kurir_modal('".$row->id."') >Edit</button>
					 <a href='".base_url('admin/kurir_detail/index/'.$id_link.'')."' class='btn btn-info btn-sm'>Detail</a>
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
			<th>Nama kurir</th>
			<!--<th>Logo</th>-->
			<th>Action</th>
	</tfoot>
</table>
<div class='box-footer clearfix'>
$pagination
</div>
"; ?>