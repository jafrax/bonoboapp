<?php
echo "
<!-- Right side column. Contains the navbar and content of the page -->
<aside class='right-side'>
	<!-- Content Header (Page header) -->
	<section class='content-header'>
		<h1>
			Daftar Pembeli
		</h1>
		<ol class='breadcrumb'>
			<li><a href='#'><i class='fa fa-dashboard'></i> Dashboard</a></li>

			<li class='active'>Daftar Pembeli</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class='content'>

		<div class='box'>
			<div class='box-header'>
				<h3 class='box-title'></h3>                                    
			</div><!-- /.box-header -->
			<div class='box-body table-responsive'>
				<div class='box-tools'>
					<div class='input-group'>
						<button data-toggle='modal' data-target='.delete_modal' onclick=javascript:delete_table('admin/daftar_pembeli/delete') class='btn btn-warning'>Hapus</button>
					</div>
					<div class='input-group'>
						<input type='text' id='search' name='table_search' class='form-control input-sm pull-right' style='width: 150px;' placeholder='Search' onChange=javascript:search('#search','admin/daftar_pembeli/search') />
						<div class='input-group-btn'>
							<button class='btn btn-sm btn-default' onclick=javascript:search('#search','admin/daftar_pembeli/search')><i class='fa fa-search'></i></button>
						</div>
					</div>
				</div><br>
				<div id='div-paging'>
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
						echo "<tr>
								<td colspan='4'>Zero</td>                                       
							 </tr>";
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
			<div id='page' class='box-footer clearfix'>
				$pagination
			</div>
		</div>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
	</section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->
";
?>