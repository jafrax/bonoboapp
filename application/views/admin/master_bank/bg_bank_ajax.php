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
				<th>Logo</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>";
		$i=0;
		if ($this->uri->segment(4)!= ''){
			$i = $this->uri->segment(4);
		}
		}
			if ($allMbank->num_rows > 0){
			foreach ($allMbank->result() as $row ){
					$i++;
					$image = base_url().'html/admin/img/credit/dummy_logo.png';
					if(!empty($row->image) && file_exists("./assets/pic/bank/".$row->image)){
						$image = base_url("assets/pic/bank/resize/".$row->image);
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
						<td><img class='logobank' src='$image' /></td>
						<td>
							<button class='btn btn-primary btn-sm' onClick=javascript:bank_modal('".$row->id."') >Edit</button>
						</td>
					</tr>";
					}
				}else{
					echo "
							<tr>
								<span> Zero </span>
							</tr>";
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