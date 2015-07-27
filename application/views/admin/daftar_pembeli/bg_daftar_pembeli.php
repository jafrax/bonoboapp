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
						<input type='text' name='table_search' class='form-control input-sm pull-right' style='width: 150px;' placeholder='Search'/>
						<div class='input-group-btn'>
							<button class='btn btn-sm btn-default'><i class='fa fa-search'></i></button>
						</div>
					</div>
				</div><br>
				<div id='div-paging'>
				<table class='table table-bordered table-striped'>
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Pembeli</th>
							<th>Email</th>
							<th>Action</th>
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
								<td>$i</td>
								<td>".$nama."</td>
								<td>".$row->email."</td>
								<td>
									<button data-toggle='modal' data-target='.confirm' class='btn btn-warning btn-sm' >Hapus</button>
								</td>
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
							<th>No</th>
							<th>Nama Pembeli</th>
							<th>Email</th>
							<th>Action</th>
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